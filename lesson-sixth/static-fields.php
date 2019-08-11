<?php

class User {
    public static $description = 'Это пользователь.';
}

echo User::$description; // Результат: Это пользователь.
User::$description = 'Это точно пользователь.'; // В отличие от констант, статические свойства можно менять.
echo User::$description; // Результат: Это точно пользователь.