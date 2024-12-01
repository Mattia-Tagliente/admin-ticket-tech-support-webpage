<?php
include('../Widgets/head.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['usernameOrEmail']) || !isset($_POST['password'])) {
        echo "<script>alert('Missing credentials. Please fill in both fields.'); window.location.href = '../login.php';</script>";
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
        echo "<script>alert('Invalid credentials. Please try again.'); window.location.href = 'login.php';</script>";
        exit;
    } elseif ($httpCode === 200) { // OK
        $userData = json_decode($response, true);

        if ($userData['adminStatus'] === 0) { // User is not authorized
            echo "<script>alert('User is not authorized to access this area.'); window.location.href = 'login.php';</script>";
            exit;
        }

        $_SESSION['admin'] = $userData;
        echo "<script>alert('Login eseguito con successo!.'); window.location.href = '../home.php';</script>";

        exit;
    } else { // Other errors
        echo "<script>alert('An unexpected error occurred. Please try again later.'); window.location.href = '../login.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('Invalid request method.'); window.location.href = '../login.php';</script>";
    exit;
}