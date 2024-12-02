<!DOCTYPE html>
<html lang="en">
<head>
    <?php include ('./Widgets/head.php')?>
    <?php
        if (!isset($_SESSION['admin'])) 
        { echo "<script>alert('Non hai i permessi necessari per visitare questa pagina.'); 
            window.location.href = 'login.php';</script>"; 
            exit; }
    ?>
</head>
<body>
    <?php include('./Widgets/header.php');?>
</body>
</html>