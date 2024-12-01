<?php


// Check if 'vat' parameter is set in the URL
if (!isset($_GET['vat']) || empty($_GET['vat'])) {
    header("index.php"); 
    exit;    
}

include('./Functions/GetCurrentTimestamp.php');

//Vat number of the customer for whom the user will be created
$customerVat = $_GET['vat'];
?>

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

<?php include('./Widgets/header.php')?>
<br>

<h1>Registra un nuovo utente per il cliente</h1>
    <form action="./registration-action.php" method="POST">

        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br><br>

        <label for="userName">Nome:</label><br>
        <input type="text" id="userName" name="userName" required><br><br>

        <label for="userSurname">Cognome:</label><br>
        <input type="text" id="userSurname" name="userSurname" required><br><br>

        <label for="userEmail">Email:</label><br>
        <input type="text" id="userEmail" name="userEmail" required><br><br>

        <label for="fiscalCode">Codice fiscale::</label><br>
        <input type="text" id="fiscalCode" name="fiscalCode" required><br><br>

        <label for="userPassword">Password:</label><br>
        <input type="text" id="userPassword" name="userPassword" required><br><br>

        <label for="phoneNumber">Numero di telefono:</label><br>
        <input type="text" id="phoneNumber" name="phoneNumber" required><br><br>

        <label for="customerVat">Partita Iva del cliente:</label><br>
        <input type="text" id="customerVat" name="customerVat" value="<?php echo $customerVat; ?>" readonly required><br><br>

        <!-- Hidden input for adminRole -->
        <input type="hidden" id="adminRole" name="adminRole" value="0">

        <!-- Hidden input for registrationDate -->
        <input type="hidden" id="registrationDate" name="registrationDate" value="<?php echo getCurrentTimestamp(); ?>">

        <button type="submit">Registra nuovo utente</button>
    </form>

    <a href="customers-list.php">Torna alla lista dei clienti</a>

    
    <?php
        
    ?>

</body>
</html>