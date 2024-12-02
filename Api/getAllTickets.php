<?php 

    include("./Functions/GetCurrentTicketStatus.php");
    
    // Define the URL of the endpoint with the vatNumber from the URL
    $url = "http://localhost:8080/api/v1/app/ticket";  // Update the URL accordingly

    // Initialize cURL session
    $ch = curl_init();

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // Get the response as a string
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Accept: application/json',  // Specify that we expect a JSON response
    ));

    // Execute the cURL request
    $response = curl_exec($ch);

    // Check for errors
    if(curl_errno($ch)) {
        echo 'Curl error: ' . curl_error($ch);
        exit;
    }

    // Get the HTTP status code from the cURL response
    $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Close the cURL session
    curl_close($ch);

    // Decode the JSON response into a PHP associative array
    $data = json_decode($response, true);

    // Check the HTTP status code
    if ($httpStatusCode === 200) {
        // If the status is OK (200), print the table with ticket data
        echo "<form action='./ticket-detail.php' method='GET'>";
        echo "<table border='1'>";
        echo "<thead>
                <tr>
                    <th>Cliente</th>
                    <th>Codice del ticket</th>
                    <th>Titolo del ticket</th>
                    <th>Status attuale</th>
                    <th>Seleziona</th>
                </tr>
            </thead><tbody>";

        // Iterate through the tickets and display them in a table
        foreach ($data as $ticket) {
            // Calculate the current status by calling the PHP function to determine the current status
            $currentStatus = calculateStatus($ticket['ticketStatus']);  // Call your function to calculate the current status

            echo "<tr>";
            echo "<td>{$ticket['customerName']}</td>";
            echo "<td>{$ticket['ticketCode']}</td>";
            echo "<td>{$ticket['ticketName']}</td>";
            echo "<td>{$currentStatus}</td>";
            echo "<td><input type='radio' name='ticketCode' value='{$ticket['ticketCode']}'></td>";
            echo "</tr>";
        }

        echo "</tbody></table>";
        echo "<button type='submit'>Submit</button>";
        echo "</form>";

    } elseif ($httpStatusCode === 404) {
        // If the status is NOT_FOUND (404), print a message saying no tickets were found
        echo "<p>Non ci ancora ticket.</p>";
    } else {
        // Handle other HTTP status codes (error handling)
        echo "<p>Errore imprevisto, riprovare più tardi.</p>";
    }

?>