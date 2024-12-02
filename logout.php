<?php
include('./Widgets/head.php');
session_destroy();
echo "<script>alert('Hai effettuato il logout, arrivederci!.'); window.location.href = 'login.php';</script>";
?>