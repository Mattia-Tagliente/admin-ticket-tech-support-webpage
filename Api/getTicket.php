<?php

include("./Functions/GetCurrentTicketStatus.php");

// Check if ticketCode is provided in the URL
if (!isset($_GET['ticketCode']) || empty($_GET['ticketCode'])) {
    echo "Ticket code is missing or empty.";
    exit;
}

$ticketCode = $_GET['ticketCode'];

// Define the API URL with the ticketCode parameter
$apiUrl = "http://localhost:8080/api/v1/app/ticket/$ticketCode"; // Replace with your actual API endpoint

// Initialize cURL session
$ch = curl_init();

// Set cURL options
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // Get the response as a string
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Accept: application/json',  // Specify that we expect a JSON response
]);

// Execute the cURL request
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// Close the cURL session
curl_close($ch);

// Check for errors in the cURL request
if(curl_errno($ch)) {
    echo 'Curl error: ' . curl_error($ch);
    exit;
}

// Decode the JSON response into a PHP associative array
$data = json_decode($response, true);

// Check if the response is NOT_FOUND or OK
if ($httpCode === 404) {
    echo "<p>No ticket found for the given ticket code.</p>";
} elseif ($httpCode === 200) {
    // If response is OK, fetch and display the ticket details
    echo "<h3>Dettagli del ticket</h3>";
    echo "<p><strong>Denominazione sociale del cliente:</strong> " . htmlspecialchars($data['customerName']) . "</p>";
    echo "<p><strong>Codice del ticket:</strong> " . htmlspecialchars($data['ticketCode']) . "</p>";
    echo "<p><strong>Descrizione del ticket:</strong> " . htmlspecialchars($data['ticketDescription']) . "</p>";

    // Fetch the ticket statuses (TicketStatusDto)
    if (!empty($data['ticketStatus'])) {
        echo "<h4>Stati del ticket</h4>";
        echo "<table border='1'>";
        echo "<thead><tr><th>Status</th><th>Data</th></tr></thead><tbody>";

        foreach ($data['ticketStatus'] as $status) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($status['statusType']) . "</td>";
            echo "<td>" . htmlspecialchars($status['postDate']) . "</td>";
            echo "</tr>";

        }

        echo "</tbody></table>";

        $currentStatus = calculateStatus($data['ticketStatus']);

        if ($currentStatus === "open"){
            echo "<a href='./Api/updateStatus.php?ticketCode=$ticketCode&updatedStatus=2'>Prendi in carico il ticket</a><br><br>";
        } else if($currentStatus === "in_progress"){
            echo "<a href='./Api/updateStatus.php?ticketCode=$ticketCode&updatedStatus=3'>Chiudi il ticket</a><br><br>";
        }

    } else {
        echo "<p>Non è stato trovato nessuno status per questo ticket.</p>";
    }
} else {
    echo "<p>Unexpected error occurred. HTTP Status Code: $httpCode</p>";
}

?>