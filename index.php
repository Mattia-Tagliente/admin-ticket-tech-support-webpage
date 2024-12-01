<!DOCTYPE html>
<html lang="en">
<head>
    <?php include ('./Widgets/head.php')?>
</head>
<body>
<?php
session_start();

if (!isset($_SESSION['admin'])) {
    // If admin is not set, redirect to login.php with an alert
    echo "<script>
        alert('You are not logged in. Redirecting to the login page.');
        window.location.href = 'login.php';
    </script>";
    exit;
} else {
    // If admin is set, redirect to home.php with an alert
    echo "<script>
        alert('Welcome back! Redirecting to the home page.');
        window.location.href = 'home.php';
    </script>";
    exit;
}
?>
</body>
</html>