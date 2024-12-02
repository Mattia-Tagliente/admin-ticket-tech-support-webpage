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
        alert('Non sei loggato!.');
        window.location.href = 'login.php';
    </script>";
    exit;
} else {
    // If admin is set, redirect to home.php with an alert
    echo "<script>
        alert('Bentornato!.');
        window.location.href = 'home.php';
    </script>";
    exit;
}
?>
</body>
</html>