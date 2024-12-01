<!DOCTYPE html>
<html lang="en">
<head>
    <?php include ('./Widgets/head.php')?>
    <?php
        if (!isset($_SESSION['admin'])) 
        { echo "<script>alert('You do not have permission to visit this page.'); 
            window.location.href = 'login.php';</script>"; 
            exit; }
    ?>
</head>
<body>
    <?php include('./Widgets/header.php');?>
</body>
</html>