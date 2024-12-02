<!DOCTYPE html>
<html lang="en">
<head>
    <?php include ('./Widgets/head.php');

    if (!isset($_SESSION['admin'])) { 
            echo "<script>alert('Non hai i permessi necessari per visitare questa pagina.'); 
            window.location.href = 'login.php';</script>"; 
            exit; 
        }
    ?>
    
</head>
<body>
    <?php include('./Widgets/header.php')?>
    <br>
    <?php include("./Api/getCustomer.php")?>
    <?php include("./Api/getCustomerTickets.php")?>

<a href="customers-list.php">Torna alla lista dei clienti</a>
<a href="registration.php?vat=<?php echo $_GET['vat']?>">Aggiungi un nuovo utente per il cliente</a>

</body>
</html>