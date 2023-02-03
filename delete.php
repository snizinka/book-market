<?php
if($_SESSION['role'] != "admin")
{
    header("Location: index.php");
}
$DATABASE = mysqli_connect("localhost", "root", "", "abooks");
$SELECT = "DELETE FROM book WHERE bId = ".$_GET["id"];
$TO_FETCH = mysqli_query ($DATABASE, $SELECT);
header("Location: admin.php");
?>