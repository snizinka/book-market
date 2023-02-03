<link rel="stylesheet" href="styles.css">
<?php
session_start();
require_once('header.php');
require_once('navigation.php');

if($_GET["e"] != null)
{
    if($_SESSION['role'] != "admin")
{
    header("Location: index.php");
}
    $DATABASE = mysqli_connect("localhost", "root", "", "abooks");
    $SELECT = 'SELECT bc.bId, bc.bname, bc.bauthor, bc.bcost, bc.bdes, bc.bimg, a.aage, c.cname FROM `book` as bc
    JOIN age as a on a.aId = bc.aId
    JOIN category as c on c.cId = bc.cId
    WHERE bc.bId = '.$_GET["e"];
    $TO_FETCH = mysqli_query ($DATABASE, $SELECT);
    $FETCHED = mysqli_fetch_array($TO_FETCH);
    
    $IMAGE = $FETCHED["bimg"];
    
    echo '
    <div class="cardfield">
    <form action="editprocess.php?id='.$FETCHED["bId"].'" method="post">
        <div class="imagefield">
            <img src="'.$IMAGE.'">
        </div>
        <div class="textconti">
            <div class="bname"><p>Назва: </p><input name="name" type="text" value="'.$FETCHED["bname"].'"></div>
            <div class="bauthor"><p>Автор: </p><input name="author" type="text" value="'.$FETCHED["bauthor"].'"></div>
            <div class="bprice"><p>Ціна: </p><input name="price" class="iprice" type="text" value="'.$FETCHED["bcost"].'"></div>
            <p class="desp">Опис</p>
            <div class="description"><textarea name="des" class="destxt" type="text">'.$FETCHED["bdes"].'</textarea></div>
            <div class="bcategory"><p>Категорія: </p>
            <select name="vat"> 
            <option value="1" '.($FETCHED["cname"] == "Роман" ? "selected" : "").'>Роман</option>
            <option value="2" '.($FETCHED["cname"] == "Детектив" ? "selected" : "").'>Детектив</option>
            <option value="3" '.($FETCHED["cname"] == "Пригоди" ? "selected" : "").'>Пригоди</option>
            <option value="4" '.($FETCHED["cname"] == "Фентезі" ? "selected" : "").'>Фентезі</option>
            </select>
            </div>
            <div class="bage"><p>Вік: </p>
            <select name="age">
            <option value="2" '.($FETCHED["aage"] == "10+" ? "selected" : "").'>10+</option>
            <option value="3" '.($FETCHED["aage"] == "15+" ? "selected" : "").'>15+</option>
            <option value="4" '.($FETCHED["aage"] == "18+" ? "selected" : "").'>18+</option>
            </select>
            </div>
        </div>
        <div class="editb">
            <input class="editbook" type="button" value="Зберегти" >
            <input class="editbook" type="submit" value="Зберегти" >
        </div>
        </form>
    </div>
    ';
}else if($_GET["id"] != null)
{
    if($_SESSION['authprized'] != "true")
    {
        header("Location: authorization.php");
    }
    $DATABASE = mysqli_connect("localhost", "root", "", "abooks");
    $SELECT = 'SELECT bc.bId, bc.bname, bc.bauthor, bc.bcost, bc.bdes, bc.bimg, a.aage, c.cname FROM `book` as bc
    JOIN age as a on a.aId = bc.aId
    JOIN category as c on c.cId = bc.cId
    WHERE bc.bId = '.$_GET["id"];
    $TO_FETCH = mysqli_query ($DATABASE, $SELECT);
    $FETCHED = mysqli_fetch_array($TO_FETCH);
    
    $IMAGE = $FETCHED["bimg"];
    
    echo '
    <div class="cardfield">
        <div class="imagefield">
            <img src="'.$IMAGE.'">
        </div>
        <div class="textcont">
            <div class="name"><p>'.$FETCHED["bname"].'</p></div>
            <div class="author"><p>Автор: '.$FETCHED["bauthor"].'</p></div>
            <div class="price"><p>Ціна: '.$FETCHED["bcost"].' грн</p></div>
            <p class="desp">Опис</p>
            <div class="description"><p> '.$FETCHED["bdes"].'</p></div>
            <div class="category"><p>Категорія: '.$FETCHED["cname"].'</p></div>
            <div class="age"><p>Вік: '.$FETCHED["aage"].'</p></div>
        </div>
    </div>
    ';
    echo'<div class="footer">
<p>Novak Vladislava</p>
</div>';
}
?>

<script>
    document.getElementsByClassName("editbook")[1].style.visibility = "hidden";
    var editbook = document.getElementsByClassName("editbook")[0];
    editbook.onclick = () => {
        if(!isNumber(document.getElementsByClassName("iprice")[0].value))
        {
            document.getElementsByClassName("iprice")[0].style.borderColor = "red";
        }else
        {
            document.getElementsByClassName("iprice")[0].style.borderColor = "transparent";
            document.getElementsByClassName("editbook")[1].click();
        }
    }

    function isNumber(val) {
    return (val >=0 || val < 0);
}
</script>