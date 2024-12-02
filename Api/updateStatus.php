<?php
include('../Functions/GetCurrentTimestamp.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Check if ticketCode and currentStatus are provided in the URL
    if (!isset($_GET['ticketCode']) || empty($_GET['ticketCode']) || !isset($_GET['updatedStatus']) || empty($_GET['updatedStatus'])) {
        echo "<script>alert('Uno o più parametri mancanti.'); window.location.href = '../ticket-detail?ticketCode=".$_GET['ticketCode'].";</script>";
        exit;
    }

    // Retrieve the parameters from the URL
    $ticketCode = $_GET['ticketCode'];
    $updatedStatus = $_GET['updatedStatus'];

    // Prepare the DTO for the API request
    $statusTypeId = (int)$updatedStatus; // Assuming the currentStatus maps directly to statusTypeId
    $postDate = getCurrentTimestamp();

    $newStatusDto = [
        "ticketCode" => $ticketCode,
        "statusTypeId" => $statusTypeId,
        "postDate" => $postDate
    ];

    // Convert DTO to JSON
    $jsonBody = json_encode($newStatusDto);

    // Initialize cURL session
    $apiUrl = "http://localhost:8080/api/v1/app/ticket/status/new"; // Update with your actual API endpoint
    $ch = curl_init($apiUrl);

    // Set cURL options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Accept: application/json"
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonBody);

    // Execute the cURL request
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Close the cURL session
    curl_close($ch);

    // Handle the response
    if ($httpCode === 409) { // Conflict
        echo "<script>alert('Conflitto imprevisto: riprovare di nuovo.'); window.location.href = '../ticket-detail.php?ticketCode=$ticketCode';</script>";
    } elseif ($httpCode === 200) { // OK
        echo "<script>alert('Status del ticket aggiornato con successo!'); window.location.href = '../ticket-detail.php?ticketCode=$ticketCode';</script>";
    } else { // Other errors
        echo "<script>alert('Errore ignoto: riprovare di nuovo.'); window.location.href = '../ticket-detail.php?ticketCode=$ticketCode';</script>";
    }
} else {
    echo "<script>alert('Metodo della richiesta non valido.'); window.location.href = '../ticket-detail.php?ticketCode=$ticketCode';</script>";
}
?>