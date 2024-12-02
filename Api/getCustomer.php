<?php

if (isset($_GET['vat'])) {
    $vatNumber = $_GET['vat'];  // Get the vat number from the URL parameter
} else {
    echo "VAT number is missing.";
    exit;
}

// Define the URL of the endpoint with the vatNumber from the URL
$url = "http://localhost:8080/api/v1/app/customer/$vatNumber";  // Update the URL accordingly

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

// Close the cURL session
curl_close($ch);

// Decode the JSON response into a PHP associative array
$data = json_decode($response, true);

// Check if the response is valid and contains customer data
if (isset($data['companyName']) && isset($data['vatNumber'])) {
    // Display the customer data in HTML format
    echo "<h2>{$data['companyName']}</h2>";
    echo "<h3>Partita IVA:</h3>
    <p>{$data['vatNumber']}</p><br><br>";
} else {
    // Handle case where data is not found or invalid
    echo "<p>Cliente non trovato o risposta non valida del server.</p>";
}
?>