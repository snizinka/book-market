<html>
<header>
    <link rel="stylesheet" href="styles.css">
</header>

<body class="authback">
    <div class="authblock">

<?php
if($_SESSION['authprized'] == "true")
{
    header("Location: index.php");
}

if($_POST)
{
    $DATABASE = mysqli_connect("localhost", "root", "", "abooks");
    $QUERY = 'SELECT * FROM users WHERE uname = "'.$_POST["login"].'";';
    $TO_FETCH = mysqli_query ($DATABASE, $QUERY);
    $DATA = mysqli_fetch_array($TO_FETCH);

    if($DATA["uname"] == null || $DATA["uname"] == "")
    {
        $_SESSION["error"] = "Користувача ".$_POST["login"]." не знайдено";
    }
    else if($DATA["uname"] == $_POST["login"] && password_verify($_POST["password"], $DATA["upassword"]) == 1)
    {
        session_start();
        $_SESSION['authprized'] = "true";
        $_SESSION['userID'] = $DATA['uId'];
        $_SESSION['role'] = $DATA["urole"];
        header("Location: index.php");
    }else
    {
        $_SESSION["error"] = "Не вірний логін або пароль";
    }
}

echo '
<form method="post">
            <div class="loginside">
                <div class="logintxt">
                    <p>Увійти</p>
                </div>

                <div class="loginfields">
                    <input class="authfield" name="login" type="text" placeholder="Логін">
                    <input class="authfield" name="password" type="password" placeholder="Пароль">

                    <div class="autherror">'.$_SESSION["error"].'</div>

                    <input class="signinbtn" type="submit" value="Авторизуватися">
                </div>
            </div>
        </form>

        <form action="signup.php" method="post">
            <div class="signupside">
                <div class="singupgrid">
                    <div class="signuptxt">
                        <p class="cong">Вітаю, друже!</p>
                        <div class="signupdesc">
                            <p>Створіть новий акаунт на нашому сайті та нирніть у світ книжкової магії</p>
                        </div>
                    </div>
                    <input class="signupbtn" type="submit" value="Зареєструватися">
                </div>
            </div>
        </form>
';
?>      
    </div>
</body>

</html>