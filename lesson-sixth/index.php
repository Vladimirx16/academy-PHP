<?php

interface iDescription
{
    public function printDescription();
}

interface iBan
{
    public function printBanInformation();
}

class User implements iDescription, iBan {
    private $login = 'Vladimir';

    public function __get($name)
        /*
         * Магический метод.
         *
         * Вызывается каждый раз, когда обратиться к какому-то полю невозможно,
         * так как оно private, либо не существует.
         *
         * */
    {
        echo "Невозможно обратиться к свойству с именем $name<br>";
    }

    public function __set($name, $value)
        /*
         *
         * Магический метод.
         *
         * Вызывается каждый раз, когда происходит попытка изменить значение
         * свойства, к которому по тем или иным причинам невозможно обратиться.
         *
         * */
    {
        echo "Вы не можете присвоить значение $value свойству $name, поскольку оно не существует<br>";
    }

    public function __call($name, $arguments)
        /*
         *
         * Магический метод.
         *
         * Вызывается каждый раз, когда происходит обращение к методу, который
         * несуществует.
         *
         * */
    {
        echo "Метод с именем $name, к которому вы пытаетесь обратиться, не существует<br>";
    }

    public function __toString()
    {
        return "Это объект класса User, с приватным полем login и его значением {$this->login}<br>";
    }

    public function printDescription()
    {
        echo "Это пользователь<br>";
    }

    public function printBanInformation()
    {
        echo "Это пользователь был забанен " . date('j.n в H:i ') . " по причине: PHP-разработчик<br>";
    }
}

$user = new User();
$user->login; // Проверка __get
$user->password = '12345'; // Проверка __set
$user->changePass(); // Проверка __call
echo $user; // Проверка __toString
$user->printDescription(); // Проверка интерфейса
$user->printBanInformation(); // Проверка интерфейса
