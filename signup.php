<html>
<header>
<link rel="stylesheet" href="styles.css">
</header>

<body class="authback">
<?php
if($_POST)
{
    session_start();
    
    $DATABASE = mysqli_connect("localhost", "root", "", "abooks");
    $QUERY = 'SELECT * FROM users WHERE uname = "'.$_POST["login"].'";';
    $TO_FETCH = mysqli_query ($DATABASE, $QUERY);
    
    $FETCHED = mysqli_fetch_array($TO_FETCH);
    
    
    if($FETCHED["uname"] == $_POST["login"])
    {
        $_SESSION["error"] = "Користувач ".$_POST["login"]." вже існує";
    }
    else if($_POST["password"] != $_POST["confirmpassword"])
    {
        $_SESSION["error"] = "Паролі не збігаються";
    }
    else
    {
        $PASSWORD = password_hash($_POST["password"], PASSWORD_DEFAULT);
        $QUERY = 'INSERT INTO users (uname, upassword, urole) VALUES("'.$_POST["login"].'", "'.$PASSWORD.'", "user")';
        mysqli_query ($DATABASE, $QUERY);
        header("Location: authorization.php");
    }
}

echo '
    <form method="post" class="regbox">
        <div class="regside">
            <div class="regtxt">
                <p>Реєстрація</p>
            </div>

            <div class="loginfields">
                <input class="regfield" id="login" name="login" type="text" placeholder="Логін">
                <input class="regfield" name="password" type="password" placeholder="Пароль">
                <input class="regfield" name="confirmpassword" type="password" placeholder="Підтвердіть пароль">

                <div class="regerror"><p>'.$_SESSION["error"].'</p><p id="upper"></p></div>

                <input class="regbtn" type="submit" value="Зареєструватися">
                <a class="toauth" href="authorization.php">Авторизація</a>
            </div>
        </div>
    </form>
    ';
    ?>
</body>

</html>

<script>
    var login = document.getElementById("login");
    login.oninput = ()=> {
        let ch = login.value.split("");
        let errs = 0;
        
        for(let i = 0; i < ch.length; i++)
        {
            if(ch[i] == ch[i].toUpperCase())
            {
                errs += 1;
            }
        }
        if(errs > 0)
        {
            document.getElementById("upper").innerText = "Літери верхнього регістру, не допустимі у полі 'Логін'";
            document.getElementById("login").style.borderColor = "red";
        }
        else
        {
            document.getElementById("login").style.borderColor = "transparent";
            document.getElementById("upper").innerText = "";
        }
    }
</script>