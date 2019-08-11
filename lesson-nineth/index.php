<?php

session_start();
$connection = new PDO('mysql:host=localhost; dbname=practice_db; charset=utf8', 'root', '');
$users = $connection->query('SELECT * FROM users');

if ($_SESSION['login'] && $_GET['auth'] && ($connection->query('SELECT validate FROM users where user_login = "' . $_SESSION['login'] . '"'))->fetch()['validate'] == 0) {
    if ((($connection->query('SELECT auth_key FROM users where user_login = "' . $_SESSION['login'] . '"' ))->fetch())['auth_key'] == $_GET['auth']) {
        $connection->query('UPDATE users SET validate=1 WHERE user_login = "' . $_SESSION['login'] . '"');
        $connection->query('UPDATE users SET updated_at=current_timestamp WHERE user_login = "' . $_SESSION['login'] . '"');
        echo '<div style=" text-align: center; margin: 20px 0"><span style="color: limegreen">Ваша почта подтверждена!</div>';
    } else {
        echo "<div style=\" text-align: center; margin: 20px 0\"><span style=\"color: red\">Полученный токен не совпадает с токеном на сервере!</span></div>";
    }
} else if ($_SESSION['login'] && $_GET['auth'] && ($connection->query('SELECT validate FROM users where auth_key = "' .
        $_GET['auth'] .
        '"'))->fetch()['validate'] == 1) {
    echo '<div style=" text-align: center; margin: 20px 0"><span style="color: limegreen">Вы уже подтвердили свою почту!</div>';
}

if ($_POST['delete'] == 'true') {
    $connection->query('DELETE FROM practice_db.users WHERE user_login = "' . $_SESSION['login'] . '"');
    session_destroy();
    header('Location: index.php');
}

if ($_POST['logout'] == 'true') {
    unset($_POST);
    session_destroy();
    header('Location: index.php');
}

if ($_POST['login']) {
    foreach ($users as $user) {
        if ($_POST['login'] == $user['user_login'] && $_POST['password'] == $user['user_password']) {
            $_SESSION['name'] = (($connection->query('SELECT user_name FROM users WHERE user_login = "' . $_POST['login'] .
                '"'))->fetch())['user_name'];
            $_SESSION['login'] = $_POST['login'];
            $_SESSION['password'] = $_POST['password'];
            header('Location: portfolio.php');
        }
    }

    echo '<div style=" text-align: center; margin: 20px 0"><span style="color: red">Вы ввели неверный логин или пароль!</span></div>';
}

?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome!</title>
    <!--Fonts-->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&display=swap" rel="stylesheet">
    <!-- Styles-->
    <link rel="stylesheet" href="assets/css/normalize.css">
    <link rel="stylesheet" href="assets/css/style-index-page.css">
</head>
<body>
<div class="title-region">
    <h2 class="title">Добро пожаловать!</h2>
    <?
    if (!$_SESSION['login']) {
        echo '<h3 class="description">Для просмотра портфолио, пожалуйста, войдите</h3>';
    } ?>
    <div class="kgb-region">
        <div class="eye -first"></div>
        <div class="eye -second"></div>
        <div class="eye -third"></div>
        <div class="eye -fourth"></div>
        <img class="image" src="assets/images/login-form-picture.png">
    </div>
</div>

<?

if ($_SESSION['login']) {
    echo '<div style="text-align: center">Вы вошли как <span style="font-weight: 600;color: #42A8C0;text-decoration: underline;">' .
        $_SESSION['login'] .
        '</span><br><a href="portfolio.php"><button class="button -redirect">Посмотреть портфолио</button></a><form action="index.php" method="POST"><br><button class="button -logout" name="logout" value="true">Выйти</button></form><form method="POST"><button id="delete_account" class="button -delete" name="delete" value="true" disabled>Удалить аккаунт</button><br><input id="delete_checkbox" type="checkbox" class="checkbox" name="agreement"><label for="delete_checkbox" class="agreement">Я понимаю, что делаю</label></form></div>';
} else {

    echo '
<form class="login-form" action"" method="POST">
<input id="login_input" type="text" name="login" placeholder="Ваш логин" autocomplete="off" required>
<input id="password_input" type="password" name="password" placeholder="Ваш пароль" required>
<button>Войти</button>
<a href="registration.php" class="registration">Нету аккаунта?</a>
</form>
';
}

?>

<script src="assets/plugins/jquery-1.11.3.min.js"></script>

<script src="assets/js/main.js"></script>

</body>
</html>