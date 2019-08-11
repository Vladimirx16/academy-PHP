<?php

session_start();

$connection = new PDO('mysql:host=localhost; dbname=practice_db; charset=utf8', 'root', '');

function generateAuthKey() {
    $char = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $random = '';

    for ($i = 0; $i < 20; $i++) {
        $random .= $char[rand(0, (strlen($char)-1))];
    }

    return $random;
}

if ($_POST['registration_login']) {
    $result = 0;
    $result = ($connection->query("SELECT COUNT(*) FROM practice_db.users WHERE user_login= '" .
        $_POST['registration_login'] . "'"))->fetch();
    $result = $result['COUNT(*)'];
    $resultMail = 0;
    $resultMail = ($connection->query("SELECT COUNT(*) FROM practice_db.users WHERE user_email= '" .
        $_POST['registration_email'] . "'"))->fetch();
    $resultMail = $resultMail['COUNT(*)'];
}

if ($_POST['registration_login'] && $result != 1) {
    if ($resultMail != 1) {
        if ($_POST['registration_password'] == $_POST['repeat_password']) {
            $userName = $_POST['registration_name'];
            $userLogin = $_POST['registration_login'];
            $userPass = $_POST['registration_password'];
            $userEmail = $_POST['registration_email'];
            $authKey = generateAuthKey();
            $query = $connection->prepare("INSERT INTO users (user_name, user_login, user_password, user_email, auth_key) VALUES (:userName, :userLogin, :userPassword, :userEmail, :authKey)");
            $data = ["userName"=>$userName, "userLogin"=>$userLogin, "userPassword"=>$userPass, "userEmail"=>$userEmail, "authKey"=>$authKey];
            $query->execute($data);
            if ($query) {
                mail($userEmail, 'Подтверждение почты на academy-php', "Доброго времени суток, подтвердите вашу почту на сайте academy-php/lesson-nineth! Перейдите по ссылке http://academy-php/lesson-nineth/?auth=$authKey");
            }
            $_SESSION['name'] = htmlspecialchars($_POST['registration_name']);
            $_SESSION['login'] = htmlspecialchars($_POST['registration_login']);
            $_SESSION['password'] = $_POST['registration_password'];

            header('Location: index.php');

        } else {
            echo '<div style="display: flex; flex-direction: column; justify-content: center; align-items: center; margin-top: 10px;">Введённые пароли не совпадают!</div>';
        }
    } else {
        echo '<div style="display: flex; flex-direction: column; justify-content: center; align-items: center; margin-top: 10px;">Пользователь с такой почтой уже существует!</div>';
    }
} else if ($_POST['registration_login'] && $result == 1) {
    echo '<div style="display: flex; flex-direction: column; justify-content: center; align-items: center; margin-top: 10px;">Пользователь с таким логином уже существует!</div>';
    unset($_POST);
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Регистрация</title>
    <link rel="stylesheet" href="assets/css/normalize.css">
    <link rel="stylesheet" href="assets/css/style-index-page.css">
</head>
<body>

<div class="title-region">
    <h2 class="title">Зарегистрируйтесь</h2>
</div>

<form class="registration-form" action="" method="POST">
    <input type="text" name="registration_login" placeholder="Ваш логин" autocomplete="off"
           value=<?= '"' . $_POST['registration_login']
           . '"' ?>
           required>
    <input type="text" name="registration_name" placeholder="Ваше имя" autocomplete="off"
           value=<?= '"' . $_POST['registration_name']
           . '"' ?>
           required>
    <input type="email  " name="registration_email" placeholder="Ваш email" required>
    <input type="text" name="registration_password" placeholder="Ваш пароль" autocomplete="off" required>
    <input type="text" name="repeat_password" placeholder="Повторите пароль" autocomplete="off" required>
    <button>Зарегистрироваться!</button>
    <a href="index.php" class="link">На страницу авторизации</a>
</form>

<? ?>

</body>
</html>
