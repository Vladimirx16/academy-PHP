<?php
$connection = new PDO('mysql:host=localhost; dbname=lesson_tenth; charset=UTF8', 'root', '');
$allAdmins = $connection->query("SELECT * FROM lesson_tenth.users");

session_start();

if ($_POST['user_login']) {
    foreach ($allAdmins as $admin) {
        if ($admin['user_login'] == $_POST['user_login'] && $admin['user_password'] == $_POST['user_password']) {
            $_SESSION['admin_login'] = $_POST['user_login'];
            $_SESSION['admin_password'] = $_POST['user_password'];
            header('Location: admin-panel.php');
        }
    }
    echo 'Не верный логин или пароль!';
}

if ($_POST['unlogin'] == 'true') {
    session_destroy();
    header('Location: login.php');
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Вход</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<h2 class="title" style="text-align: center;color: #42A8C0;">Вход в админ-панель</h2>
<? if (!$_SESSION['admin_login']) { ?>
    <form method="POST">
        <input type="text" name="user_login" placeholder="Логин" required>
        <input type="password" name="user_password" placeholder="Пароль" required>
        <button>Войти</button>
    </form>
    <button><a href="index.php" style="text-decoration: none; color: white;">К форуму</a></button>
<? } else { ?>
    <span style="display: block;margin: 0 auto">Вы уже вошли как <span class="admin"><?= $_SESSION['admin_login'] ?></span></span>
    <form method="POST">
        <button name="unlogin" value="true">Выйти</button>
    </form>
    <button><a href="admin-panel.php" style="text-decoration: none; color: white;">К админ-панели</a></button>
    <button><a href="index.php" style="text-decoration: none; color: white;">К форуму</a></button>

<? } ?>
</body>
</html>
