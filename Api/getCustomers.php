<?php
// Define the API endpoint URL
$apiUrl = "localhost:8080/api/v1/app/customer";

// Initialize cURL
$curl = curl_init($apiUrl);

// Set cURL options
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Return the response as a string
curl_setopt($curl, CURLOPT_HTTPGET, true); // Set the request method to GET

// Execute the cURL request
$response = curl_exec($curl);

// Check for errors
if (curl_errno($curl)) {
    echo 'cURL error: ' . curl_error($curl);
} else {
    // Get the HTTP status code
    $httpStatusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    if ($httpStatusCode === 200) {
        // Decode and process the response if the status is 200 OK
        $data = json_decode($response, true);

            echo '<h2>Lista dei clienti:</h2><br>'; 
            echo '<form action="./customer-tickets.php" method="GET">';
            echo '<button type="submit">Visualizza i ticket del cliente selezionato</button><br><br>';
            echo '<table border="1" cellpadding="10" cellspacing="0">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Select</th>';
            echo '<th>Company Name</th>';
            echo '<th>VAT Number</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            foreach ($data as $customer) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($customer['companyName']) . '</td>';
                echo '<td>' . htmlspecialchars($customer['vatNumber']) . '</td>';
                echo '<td>';
                echo '<input type="radio" name="vat" value="' . htmlspecialchars($customer['vatNumber']) . '" required>';
                echo '</td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
            echo '</form>';
        } else {
            echo "No customers found.";
        }
    } 


// Close the cURL session
curl_close($curl);
?>