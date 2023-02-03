
<link rel="stylesheet" href="styles.css">


<?php
session_start();
require_once('header.php');
require_once('navigation.php');

if($_SESSION['authprized'] != "true")
    {
        header("Location: authorization.php");
    }

echo "<div class='main'>";
echo '
<div class="holder">
<form class="barform" method="post">
<div class="additionalbar">
<div class="aging">
<p class="htag">Вікові обмеження</p>
<div>
<p>10+</p>
<input name="tenplus" type="checkbox">
</div>
<div>
<p>16+</p>
<input name="sixteenplus" type="checkbox">
</div>
<div>
<p>18+</p>
<input name="eighteenplus" type="checkbox">
</div>
</div>

<div class="breakline" ></div>

<div class="pricebox">
<p class="htag">Цінові обмеження</p>
<div>
<p>Від</p>
<input name="pricefrom" class="fromp" type="text" value="0">
</div>
<div>
<p>До</p>
<input name="priceto" class="top" type="text" value="100000">
</div>
</div>

<div class="breakline" ></div>

<div class="catbox">
<p class="htag">Категорії</p>
<div>
<p>Роман</p>
<input name="roman" type="checkbox">
</div>
<div>
<p>Детектив</p>
<input name="detective" type="checkbox">
</div>
<div>
<p>Пригоди</p>
<input name="travel" type="checkbox">
</div>
<div>
<p>Фентезі</p>
<input name="fantasy" type="checkbox">
</div>
</div>

<input name="bbutton" class="booksearch" type="image" src="img/booksearch.png">
</form>
</div>

</div>
<div class="container">
';

$SELECT = "";

if($_POST)
{
    if(isset($_POST["sbtn_x"]))
    {
        if($_POST["sfield"] != "" )
        {
            $SELECT = 'SELECT bc.bId, bc.bname, bc.bauthor, bc.bcost, bc.bimg, a.aage, c.cname FROM `book` as bc
            JOIN age as a on a.aId = bc.aId
            JOIN category as c on c.cId = bc.cId
            WHERE bc.bname LIKE "%'.$_POST["sfield"].'%"
            ';
        }else{
            $SELECT = 'SELECT bc.bId, bc.bname, bc.bauthor, bc.bcost, bc.bimg, a.aage, c.cname FROM `book` as bc
            JOIN age as a on a.aId = bc.aId
            JOIN category as c on c.cId = bc.cId';
        }
    }else
    {
    $CATEGORY = "(";
    $CATEGORY = $_POST["roman"] == "on" ? $CATEGORY."c.cname = 'Роман'" : $CATEGORY."";
    $CATEGORY = $_POST["detective"] == "on" ? $_POST["roman"] == "on" ? $CATEGORY." OR c.cname = 'Детектив'" : $CATEGORY."c.cname = 'Детектив'" : $CATEGORY."";
    $CATEGORY = $_POST["travel"] == "on" ? ($_POST["roman"] == "on" ? $CATEGORY." OR c.cname = 'Пригоди'" : ($_POST["detective"] == "on" ? $CATEGORY."OR c.cname = 'Пригоди'" : $CATEGORY."c.cname = 'Пригоди'")) : $CATEGORY."";
    $CATEGORY = $_POST["fantasy"] == "on" ? ($_POST["roman"] == "on" ? $CATEGORY." OR c.cname = 'Фентезі'" : ($_POST["detective"] == "on" ? $CATEGORY."OR c.cname = 'Фентезі'" : ($_POST["travel"] == "on" ? $CATEGORY."OR c.cname = 'Фентезі'" : $CATEGORY."c.cname = 'Фентезі'"))) : $CATEGORY."";
    $CATEGORY = $CATEGORY.")";

    $AGE = $CATEGORY == "()" ? " (" : " AND (";
    $AGE = $_POST["tenplus"] == "on" ? $AGE."a.aId = 2 " : $AGE."";
    $AGE = $_POST["sixteenplus"] == "on" ? $_POST["tenplus"] == "on" ? $AGE."OR a.aId = 3 " : $AGE."a.aId = 3 " : $AGE."";
    $AGE = $_POST["eighteenplus"] == "on" ? ($_POST["tenplus"] == "on" ? $AGE."OR a.aId = 4 " : ($_POST["sixteenplus"] == "on" ? $AGE."OR a.aId = 4 " : $AGE."a.aId = 4")) : $AGE."";
    $AGE = $AGE.") ";

    $PRICE = "";

    if(($CATEGORY == "()") && ($AGE == " AND () " || $AGE == " () "))
    {
            $PRICE = "";
            $AGE = "";
            $CATEGORY = "";
    }
    else if(($CATEGORY == "()") && ($AGE != " AND () " && $AGE != " () "))
    {
        $CATEGORY = "";
        $PRICE = "AND ";
    }
    else if(($CATEGORY != "()") && ($AGE == " AND () " || $AGE == " () "))
    {
        $AGE = "";
        $PRICE = "AND ";
    }
    else
    {
        $PRICE = "AND ";
    }

    $PRICE = $PRICE." (bc.bcost >= ".$_POST["pricefrom"]." AND bc.bcost <= ".$_POST["priceto"].")";

    $SELECT = "SELECT bc.bId, bc.bname, bc.bauthor, bc.bcost, bc.bimg, a.aage, c.cname FROM `book` as bc
    JOIN age as a on a.aId = bc.aId
    JOIN category as c on c.cId = bc.cId
    WHERE ".$CATEGORY."".$AGE."".$PRICE;
    }
}
else if($_GET["category"]!="")
{
    $SELECT = "SELECT bc.bId, bc.bname, bc.bauthor, bc.bcost, bc.bimg, a.aage, c.cname FROM `book` as bc
    JOIN age as a on a.aId = bc.aId
    JOIN category as c on c.cId = bc.cId
    WHERE c.cId = ".$_GET["category"];
}
else
{
    $SELECT = 'SELECT bc.bId, bc.bname, bc.bauthor, bc.bcost, bc.bimg, a.aage, c.cname FROM `book` as bc
JOIN age as a on a.aId = bc.aId
JOIN category as c on c.cId = bc.cId';
}

$db = mysqli_connect("localhost", "root", "", "abooks");
$result = mysqli_query ($db, $SELECT);


$n = 0;
while($myr = mysqli_fetch_array($result))
{
    $n ++;
    echo '
<div class="card">
<form action="book.php?id='.$myr["bId"].'" method="post">
        <div class="image">
            <img src="'.$myr["bimg"].'" >
        </div>
        <div class="caption">
            <p class="bookname">'.$myr["bname"].'</p>
            <p class="price">'.$myr["bcost"].'</p>
            <p class="author">'.$myr["bauthor"].'</p>
        </div>
        <button type="submit" class="show">Детальніше</button>
        </form>
    </div>
';
}
if($n == 0)
    {
        echo '<p class="notfound">Книжок подібного типу, не знайдено</p>';
    }

echo "</div>";
echo "</div>";
echo'<div class="footer">
<p>Novak Vladislava</p>
</div>';
?>

