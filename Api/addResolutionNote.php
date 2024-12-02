<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate required fields
    if (!isset($_POST['ticketCode']) || empty($_POST['ticketCode']) ||
        !isset($_POST['resolutionNote']) || empty($_POST['resolutionNote']) ||
        !isset($_POST['noteDate']) || empty($_POST['noteDate']) ||
        !isset($_POST['adminUsername']) || empty($_POST['adminUsername'])) {
        echo "<script>alert('All fields are required.'); window.location.href = 'resolution-form.php';</script>";
        exit;
    }

    // Get data from the form
    $ticketCode = $_POST['ticketCode'];
    $resolutionNote = $_POST['resolutionNote'];
    $noteDate = $_POST['noteDate']; // Use the noteDate from the form
    $adminUsername = $_POST['adminUsername'];

    // Prepare the DTO as JSON
    $requestBody = json_encode([
        'ticketCode' => $ticketCode,
        'resolutionNote' => $resolutionNote,
        'noteDate' => $noteDate,
        'adminUsername' => $adminUsername,
    ]);

    // Initialize cURL session
    $ch = curl_init("http://localhost:8080/api/v1/app/ticket/resolution/new"); // Update with your actual API URL

    // Set cURL options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Accept: application/json',
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);

    // Execute the cURL request
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Handle the response
    if ($httpCode === 200) {
        echo "<script>alert('Nota aggiunta con successo.'); window.location.href = '../ticket-detail.php?ticketCode={$ticketCode}';</script>";
    } elseif ($httpCode === 409) {
        echo "<script>alert('Conflitto: impossibile agigungere la nota.'); window.location.href = '../ticket-detail.php';</script>";
    } else {
        echo "<script>alert('Errore imprevisto, riprovare più tardi.'); window.location.href = '../ticket-detail.php';</script>";
    }
} else {
    echo "<script>alert('Metodo della richiesta non valido.'); window.location.href = '../ticket-detail.php';</script>";
    exit;
}

?>