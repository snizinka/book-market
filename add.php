<link rel="stylesheet" href="styles.css">

<?php
session_start();
require_once('header.php');
require_once('navigation.php');

if($_SESSION['role'] != "admin")
{
    header("Location: index.php");
}

if($_POST)
{
    if(!copy($_FILES['image']['tmp_name'], 'D:/openserver/domains/localhost/3pv/img/'.$_FILES['image']['name'].''))
    {
        header("Location: add.php");
    }
    $db = mysqli_connect("localhost", "root", "", "abooks");
    $ggg = "INSERT INTO `book`(`bname`, `bauthor`, `bcost`, `bdes`, `bimg`, `aId`, `cId`) VALUES ('".$_POST["bname"]."','".$_POST["author"]."','".$_POST["price"]."','".htmlentities($_POST['des'])."','img/".$_FILES["image"]["name"]."','".$_POST["age"]."','".$_POST["cat"]."')";  
    mysqli_query ($db, $ggg);
    header("Location: add.php");
}
?>

<div class="addblock">
    <form method="post" enctype="multipart/form-data">
        <div class="addfield">
            <div class="addrow">
                <p>Назва книги</p><input type="text" name="bname" class="bname">
                <p class="error">Поле не може бути пустим</p>
            </div>
            <div class="addrow">
                <p>Автор книги</p><input type="text" name="author" class="author">
                <p class="error">Поле не може бути пустим</p>
            </div>
            <div class="addrow">
                <p>Ціна книги</p><input type="text" name="price" class="price">
                <p class="error">Необхідно ввести числове значення</p>
            </div>
            <div class="addrow">
                <p>Опис книги</p><textarea class="tarea" name="des" id="des" class="des"></textarea>
                <p class="error">Поле не може бути пустим</p>
            </div>
            <div class="addrow">
                <p>Категорія книги</p>
                <select name="cat">
                    <option value="1">Роман</option>
                    <option value="2">Детектив</option>
                    <option value="3">Пригоди</option>
                    <option value="4">Фентезі</option>
                </select>
            </div>
            <div class="addrow">
                <p>Вікові обмеження</p>
                <select name="age">
                    <option value="2">10+</option>
                    <option value="3">15+</option>
                    <option value="4">18+</option>
                </select>
            </div>

            <div class="addrow"><p>Зображення</p><input type="file" id="image" name='image' class="filecont">
            <p class="error">Необхідно обрати зображення</p></div>
            <input class="addbtn" type="button" value="Завантажити">
            <input class="addbtn" type="submit" value="Завантажити">
        </div>
    </form>
</div>
<div class="footer">
<p>Novak Vladislava</p>
</div>

<script>
    document.getElementsByClassName("addbtn")[1].style.visibility = "hidden";
    var editbook = document.getElementsByClassName("addbtn")[0];
    editbook.onclick = () => {
        let fount = 0;
        if (!isNumber(document.getElementsByClassName("price")[0].value)) {
            document.getElementsByClassName("price")[0].style.borderColor = "black";
            document.getElementsByClassName("error")[2].style.visibility = "visible";
            fount ++;
        } else {
            document.getElementsByClassName("price")[0].style.borderColor = "salmon";
            document.getElementsByClassName("error")[2].style.visibility = "hidden";
        }

        if (document.getElementsByClassName("bname")[0].value == "") {
            document.getElementsByClassName("error")[0].style.visibility = "visible";
            fount ++;
            document.getElementsByClassName("bname")[0].style.borderColor = "black";
        } else {
            document.getElementsByClassName("bname")[0].style.borderColor = "salmon";
            document.getElementsByClassName("error")[0].style.visibility = "hidden";
        }

        if (document.getElementsByClassName("author")[0].value == "") {
            document.getElementsByClassName("error")[1].style.visibility = "visible";
            fount ++;
            document.getElementsByClassName("author")[0].style.borderColor = "black";
        } else {
            document.getElementsByClassName("author")[0].style.borderColor = "salmon";
            document.getElementsByClassName("error")[1].style.visibility = "hidden";
        }

        if (document.getElementById("des").value == "") {
            document.getElementsByClassName("error")[3].style.visibility = "visible";
            fount ++;
            document.getElementById("des").style.borderColor = "black";
        } else {
            document.getElementById("des").style.borderColor = "salmon";
            document.getElementsByClassName("error")[3].style.visibility = "hidden";
        }

        if(document.getElementById("image").value == "")
        {
            document.getElementsByClassName("error")[4].style.visibility = "visible";
            fount ++;
            document.getElementById("image").style.borderColor = "black";
        } else {
            document.getElementsByClassName("error")[4].style.visibility = "hidden";
            document.getElementById("image").style.borderColor = "salmon";
        }
console.log(fount);
        if(fount == 0)
        {
            document.getElementsByClassName("addbtn")[1].click();
        }
    }
    
    function isNumber(val) {
        return ((val >= 0 || val < 0) && val != "");
    }
</script>