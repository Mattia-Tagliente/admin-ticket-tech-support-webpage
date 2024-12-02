<?php
// Check if 'ticketCode' parameter is set in the URL and is not empty
if (isset($_GET['ticketCode']) && !empty($_GET['ticketCode'])) {
    $ticketCode = $_GET['ticketCode'];

    // Define the URL for the API endpoint
    $url = "http://localhost:8080/api/v1/app/ticket/resolution/$ticketCode"; // Replace with the actual API endpoint URL

    // Initialize cURL session
    $ch = curl_init();

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Get the response as a string
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Accept: application/json', // Specify that we expect a JSON response
    ));

    // Execute the cURL request
    $response = curl_exec($ch);

    // Check for cURL errors
    if (curl_errno($ch)) {
        echo 'Curl error: ' . curl_error($ch);
        exit;
    }

    // Get the HTTP status code of the response
    $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Close the cURL session
    curl_close($ch);

    // Handle the response based on the HTTP status code
    if ($httpStatus === 200) {
        // Decode the JSON response into a PHP associative array
        $data = json_decode($response, true);

        // Check if the response contains resolution notes
        if (isset($data) && !empty($data)) {
            echo "<table border='1'>";
            echo "<thead>
                    <tr>
                        <th>Data</th>
                        <th>Nota</th>
                        <th>Autore</th>
                        <th>Email dell'autore</th>
                    </tr>
                </thead><tbody>";

            // Iterate through the resolution notes and display them in a table
            foreach ($data as $note) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($note['noteDate']) . "</td>";
                echo "<td>" . htmlspecialchars($note['resolutionNote']) . "</td>";
                echo "<td>" . htmlspecialchars($note['adminName'] . " " . $note['adminSurname']) . "</td>";
                echo "<td>" . htmlspecialchars($note['adminEmail']) . "</td>";
                echo "</tr>";
            }

            echo "</tbody></table><br><br>";
        } else {
            echo "Nessuna nota di risoluzione è stata trovata per questo ticket.";
        }
    } elseif ($httpStatus === 404) {
        echo "Nessuna nota di risoluzione è stata trovata per questo ticket.";
    } else {
        echo "E' avvenuto un errore imprevisto. HTTP Status: $httpStatus";
    }
} else {
    echo "Errore: il codice del ticket non è disponibile.";
}
?>