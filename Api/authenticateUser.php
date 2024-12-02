<?php
include('../Widgets/head.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['usernameOrEmail']) || !isset($_POST['password'])) {
        echo "<script>alert('Una o più credenziali mancanti.'); window.location.href = '../login.php';</script>";
        exit;
    }

    $usernameOrEmail = $_POST['usernameOrEmail'];
    $password = $_POST['password'];

    // Prepare the data to send in the POST request
    $postData = json_encode([
        "usernameOrEmail" => $usernameOrEmail,
        "password" => $password
    ]);

    // Initialize cURL
    $ch = curl_init("http://localhost:8080/api/v1/app/user/login"); // Replace with your actual API endpoint
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Accept: application/json"
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

    // Execute the request
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Handle the response
    if ($httpCode === 401) { // Unauthorized
        echo "<script>alert('Credenziali non valide.'); window.location.href = 'login.php';</script>";
        exit;
    } elseif ($httpCode === 200) { // OK
        $userData = json_decode($response, true);

        if ($userData['adminStatus'] === 0) { // User is not authorized
            echo "<script>alert('L'utente non è autorizzato in quest'area'); window.location.href = 'login.php';</script>";
            exit;
        }

        $_SESSION['admin'] = $userData;
        echo "<script>alert('Login eseguito con successo!.'); window.location.href = '../home.php';</script>";

        exit;
    } else { // Other errors
        echo "<script>alert('Errore imprevisto: riprovare più tardi.'); window.location.href = '../login.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('Metodo della richiesta non valido.'); window.location.href = '../login.php';</script>";
    exit;
}