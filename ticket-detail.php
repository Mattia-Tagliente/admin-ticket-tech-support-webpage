<?php include('./Functions/GetCurrentTimestamp.php')?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include ('./Widgets/head.php');

    if (!isset($_SESSION['admin'])) { 
        echo "<script>alert('You do not have permission to visit this page.'); 
        window.location.href = 'login.php';</script>"; 
        exit; 
    }
    ?>

    
</head>
<body>
    <?php include('./Widgets/header.php')?>
    <br>
    <?php include('./Api/getTicket.php')?>
    <h3>Risoluzione</h3>
    <?php include('./Api/getResolutionNotes.php') ?>

    <h4>Add Resolution Note</h4>
    <form action="submitResolution.php" method="POST">
        
        <label for="resolutionNote">Nota di risoluzione:</label><br>
        <textarea id="resolutionNote" name="resolutionNote" rows="4" cols="50" required></textarea>
        <br><br>

        
        <input type="hidden" id="adminUsername" name="adminUsername" value=<?php echo isset($_SESSION['adminUsername']) ? $_SESSION['adminUsername'] : null;?>>
        <input type="hidden" id="noteDate" name="noteDate" value="<?php echo getCurrentTimestamp()?>">
        <input type="hidden" id="ticketCode" name="ticketCode" value=<?php echo $_GET['ticketCode']?>>
        
        <button type="submit">Submit</button>
    </form>
</body>
</html>