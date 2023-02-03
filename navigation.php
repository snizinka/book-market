<header>
<link rel="stylesheet" href="stylus.css">
</header>

<?php

echo 
'
<div class="middle">
<h2 class="tooltip">Меню</h2>
<div class="menu">
    <ul>
        <li class="item">
            <a href="#" class="btn"><form action="index.php" class="skit" method="post"><input class="searcher" name="sfield" placeholder="Назва книжки" type="text"> <input class="confirm" name="sbtn" type="image" src="img/search.png"></form> </a>
        </li>

        <li class="item" id="profile">
            <a href="index.php" class="btn"><i class="fa fa-user"></i> Головна</a>
        </li>

        <li class="item" id="messages">
            <a href="#messages" class="btn"><i class="fa fa-envelope"></i> Категорії</a>
            <div class="smenu">
                <a href="index.php?category=1" name="one">Роман</a>
                <a href="index.php?category=2" name="two">Детектив</a>
                <a href="index.php?category=3" name="three">Пригоди</a>
                <a href="index.php?category=4" name="four">Фентезі</a>
            </div>
        </li>';
        echo'
        <li class="item" id="settings">
            <a href="#settings" class="btn"><i class="fa fa-cog"></i> Адміністрація</a>
            <div class="smenu">
                <a href="add.php">Завантажити книгу</a>
                <a href="admin.php">Редагувати книгу</a>
            </div>
        </li>';
        echo'
        <li class="item">
            <a href="logout.php" class="btn"><i class="fa fa-sign-out-alt"></i> Вийти</a>
        </li>
    </ul>
</div>
</div>
';
?>