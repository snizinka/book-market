<link rel="stylesheet" href="styles.css">

<?php
session_start();
require_once('header.php');
require_once('navigation.php');

if($_SESSION['role'] != "admin")
{
    header("Location: index.php");
}

echo '
<div class="mainfield">
<form method="post">
<div class="searchbookbox">
    <input type="text" name="bookname" class="sfield" placeholder="Назва книги">
    <input type="image" class="sbutton" src="img/listsearch.png">
</div>
</form>
    <div class="booklist">
';

if($_POST)
{
    $SELECT = 'SELECT bc.bId, bc.bname, bc.bauthor, bc.bcost, bc.bdes, bc.bimg, a.aage, c.cname FROM `book` as bc
    JOIN age as a on a.aId = bc.aId
    JOIN category as c on c.cId = bc.cId
    WHERE bc.bname LIKE "%'.$_POST["bookname"].'%"';
}else
{
    $SELECT = 'SELECT bc.bId, bc.bname, bc.bauthor, bc.bcost, bc.bdes, bc.bimg, a.aage, c.cname FROM `book` as bc
    JOIN age as a on a.aId = bc.aId
    JOIN category as c on c.cId = bc.cId';
}

$DATABASE = mysqli_connect("localhost", "root", "", "abooks");
$TO_FETCH = mysqli_query ($DATABASE, $SELECT);

while($myr = mysqli_fetch_array($TO_FETCH))
{
    echo '
    <div class="bookl">
            <div class="imagelist">
                <img src="'.$myr["bimg"].'">
            </div>
            <div class="booklname">
                <p>'.$myr["bname"].'</p>
            </div>
            <div class="edit">
                <form action="book.php?e='.$myr["bId"].'" method="post">
                    <input type="submit" value="Редагувати" >
                </form>
            </div>
            <div class="delete">
                <form action="delete.php?id='.$myr["bId"].'" method="post">
                    <input type="submit" value="Видалити" >
                </form>
            </div>
        </div>
    ';
}
echo'<div class="footer">
<p>Novak Vladislava</p>
</div>';

?>
    </div>
</div>