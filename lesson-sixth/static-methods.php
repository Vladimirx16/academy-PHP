<?php

class User {
    public static $description = 'Это пользователь.';

    public static function getMethodDescription() {
        echo 'Это статический метод.';
    }
}

$user = new User();
$user->getMethodDescription(); // Вызвать статический метод может объект класса.

User::getMethodDescription(); // Вызвать статический метод может сам класс.