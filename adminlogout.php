<?php 
session_start();
$_SESSION['agency_id'] ="";
session_destroy();
session_unset();

header('location: adminlogin.php')
?>