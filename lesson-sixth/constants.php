<?php

class User {
    const DESCRIPTION = 'Это пользователь.';

    public function getDescription() {
        echo User::DESCRIPTION;
        echo self::DESCRIPTION; // Ключевое слово self указывает на сам этот класс.
    }
}

echo User::DESCRIPTION; // Обратиться к константе можно только через класс.

$user = new User();
$user->getDescription(); // Обратиться к константе можно через метод, который будет выводить значение константы.