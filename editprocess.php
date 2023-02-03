<?php
if($_SESSION['role'] != "admin")
{
    header("Location: index.php");
}
    $DATABASE = mysqli_connect("localhost", "root", "", "abooks");
    $SELECT = 'UPDATE `book` SET `bname`="'.$_POST["name"].'",`bauthor`="'.$_POST["author"].'",`bcost`="'.$_POST["price"].'",`bdes`="'.htmlentities($_POST['des']).'",`aId`="'.$_POST["age"].'",`cId`="'.$_POST["vat"].'" WHERE bId = '.$_GET["id"];
    //mysqli_query ($DATABASE, $SELECT);
    echo $SELECT;
?>