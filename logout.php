<?php
session_start();
$_SESSION['authprized'] = "false";
$_SESSION['userID'] = "";
$_SESSION['role'] = "";
header("Location: authorization.php");
?>