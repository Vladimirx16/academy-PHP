<?php

class User // Класс это некая инструкция.
{
    protected $name;
    protected $surname;
    protected $age;
    public static $amount;

    public function getDescription(){
        echo "Имя: {$this->name}<br>Фамилия: {$this->surname}<br>Возраст: {$this->age}<br>";
    }

    public static function setAmount()
    {
        User::$amount = User::$amount + 1;
    }

    public function __construct(string $name, string $surname, int $age)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->age = $age;
    }
}

class Administrator extends User
{
    private $status;

    public function getDescription(){
        echo "Имя: {$this->name}<br>Фамилия: {$this->surname}<br>Возраст: {$this->age}<br>Статус: {$this->status}<br>";
    }

    public function __construct(string $name, string $surname, int $age, string $status)
    {
        $this->status = $status;
        parent::__construct($name, $surname, $age);
    }
}

final class Seller extends User
{
    private $balance;

    public function getDescription(){
        echo "Имя: {$this->name}<br>Фамилия: {$this->surname}<br>Возраст: {$this->age}<br>Баланс: {$this->balance} руб<br>";
    }

    public function __construct(string $name, string $surname, int $age, int $balance)
    {
        $this->balance = $balance;
        parent::__construct($name, $surname, $age);
    }
}

/*$user = new User(); // Объект класса User.
$user->name = 'Владимир'; // Задаём значение поля объекта User.
$user->surname = 'Грищенко';
$user->age = 16;
$user->getDescription();

Инлайновое задание значений полям

*/

/*$user2 = new User('Максим', 'Морозов', 23);
$user2->getDescription();

Задание значений полям через конструктор

*/

$user3 = new Administrator('Иван', 'Петров', 21, 'Старший Администратор');
$user3->getDescription();
User::setAmount();
$user4 = new Seller('Петр', 'Иванов', 30, 5000);
$user4->getDescription();
User::setAmount();
$user5 = new Seller('Андрей', 'Бахчераев', 11, 1000);
$user5->getDescription();
User::setAmount();
echo User::$amount;