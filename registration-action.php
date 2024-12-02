<?php

// Check if all necessary POST variables are set and not empty
$requiredFields = [
    'username',
    'userName',
    'userSurname',
    'userEmail',
    'fiscalCode',
    'userPassword',
    'phoneNumber',
    'customerVat',
    'registrationDate',
    'adminRole' 
];

foreach ($requiredFields as $field) {
    if (!isset($_POST[$field]) || ($_POST[$field]) == '') {
        // Alert user and redirect to error page if any required field is missing or empty
        echo "<script>alert('Error: uno o più campi non compilati.'); window.location.href = 'customer-tickets.php?vat=$customerVat';</script>";
        exit;
    }
}

// Get form data
$username = $_POST['username'];
$userName = $_POST['userName'];
$userSurname = $_POST['userSurname'];
$userEmail = $_POST['userEmail'];
$fiscalCode = $_POST['fiscalCode'];
$userPassword = $_POST['userPassword'];
$phoneNumber = $_POST['phoneNumber'];
$customerVat = $_POST['customerVat'];
$registrationDate = $_POST['registrationDate'];
$adminRole = $_POST['adminRole'];

// API endpoint
$apiUrl = "http://localhost:8080/api/v1/app/user/register"; // Replace 'your-api-domain' with your API's actual domain

// Create the NewUserDto array
$newUserDto = [
    "username" => $username,
    "userName" => $userName,
    "userSurname" => $userSurname,
    "userEmail" => $userEmail,
    "fiscalCode" => $fiscalCode,
    "userPassword" => $userPassword,
    "phoneNumber" => $phoneNumber,
    "registrationDate" => $registrationDate,
    "customerVat" => $customerVat,
    "adminRole" => (int)$adminRole // Ensure adminRole is an integer
];

// Initialize cURL
$ch = curl_init();

// Set cURL options
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json"
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($newUserDto)); // Convert PHP array to JSON

// Execute the cURL request and get the response
$response = curl_exec($ch);

// Get the HTTP response status code
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// Close the cURL session
curl_close($ch);

// Handle the response
if ($httpCode === 201) { // 201 Created
    echo "<script>alert('Registrazione effettuata con successo!'); window.location.href = 'customer-tickets.php?vat=$customerVat';</script>";
    exit;
} elseif ($httpCode === 401) { // 401 Unauthorized
    echo "<script>alert('Registrazione fallita: email o username già in uso, oppure il cliente non è riconosciuto.'); window.location.href = 'registration.php?vat=$customerVat';</script>";
    exit;
} else { // Other HTTP responses
    echo "<script>alert('Errore imprevisto, riprovare più tardi.'); window.location.href = 'registration.php?vat=$customerVat';</script>";
    exit;
}
?>