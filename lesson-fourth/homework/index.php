<?php
echo '_GET: Привет, меня зовут ' . $_GET['name'] . ' ' . $_GET['surname'] . ', мой возраст - ' . (date('Y') - $_GET['birthday']);
echo '<br><br>';
echo '_POST: Привет, меня зовут ' . $_POST['name'] . ' ' . $_POST['surname'] . ', мой возраст - ' . (date('Y') - $_POST['birthday']);
echo '<br><br>';
?>

<form action="">
    <input type="text" name="name" placeholder="Имя">
    <input type="text" name="surname" placeholder="Фамилия">
    <input type="text" name="birthday" placeholder="Дата рождения">
    <input type="submit">
</form>
<form action="" method="POST">
    <input type="text" name="name" placeholder="Имя">
    <input type="text" name="surname" placeholder="Фамилия">
    <input type="text" name="birthday" placeholder="Дата рождения">
    <input type="submit">
</form>
