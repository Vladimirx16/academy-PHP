<?php

interface iDecomposition
{
    public function decomposition();
}

interface iPrintStorageLife
{
    public function printStorageLife();
}

interface iWasSold
{
    public function printSoldProduct();
}

abstract class Product implements iDecomposition, iPrintStorageLife, iWasSold
{
    public $id;
    public $name;
    public $weight;
    public $price;
    public $clearPrice;
    public static $companyName = 'Milky Goods';

    const YEAR_START = 1976;

    public abstract function showImage();

    public function description() {
        echo "Описание товара №{$this->id}: Название - {$this->name}, вес - {$this->weight} г, цена - {$this->price} руб<br><br>";
    }

    public function clearPrice() {
        echo "Цена товара {$this->name} с НДС - {$this->price} руб<br>Цена товара {$this->name} без НДС - {$this->clearPrice} руб<br><br>";
    }

    public static function showCompanyInfo()
    {
        echo 'Название компании: ' . self::$companyName . '<br>Дата создания компании: ' . self::YEAR_START . '<br>';
    }

    public function decomposition()
    {
        echo "Продукт {$this->name} портится<br>";
    }

    public function printStorageLife()
    {
        echo "Срок хранения продукта {$this->name} - 2 месяца<br>";
    }

    public function printSoldProduct()
    {
        echo "Продукт {$this->name} был продан<br>";
    }

    public function __construct(int $id, string $name, int $weight, int $price)
    {
        $this->id = $id;
        $this->name = $name;
        $this->weight = $weight;
        $this->price = $price;
        $this->clearPrice = $price * 80 / 100;
    }
}

class Chocolate extends Product {
    public $calories;

    public function showImage() {
        echo "<div style='width:200px;height:200px;background:url(img/chocolate.jpg)no-repeat;background-size:cover;'></div>";
    }

    public function description() {
        echo "Описание товара №{$this->id}: Название - {$this->name}, вес - {$this->weight} г, цена - {$this->price} руб, количество калорий - {$this->calories}<br><br>";
    }

    public function __construct(int $id, string $name, int $weight, int $price, $calories)
    {
        $this->calories = $calories;

        parent::__construct($id, $name, $weight, $price);
    }

    public function __set($name, $value)
    {
        echo 'Не удалось изменить значение поля ' . $name . ', так как оно не существует<br>';
    }
}

class Candy extends Product {
    public function showImage() {
        echo "<div style='width:100px;height:100px;background:url(img/candy.jpg)no-repeat;background-size:cover;'></div>";
    }

    public function __get($name)
    {
        echo 'Запрошеное поле ' . $name . ' не существует<br>';
    }
}

$chocolate = new Chocolate(0, 'Шоколадка', 100, 90, 250);
$chocolate->description();
$chocolate->showImage();

$candy = new Candy(1, 'Конфетка', 30, 10);
$candy->description();
$candy->showImage();

Product::showCompanyInfo();;
$chocolate->showCompanyInfo();
$candy->showCompanyInfo();

$chocolate->decomposition();
$candy->printStorageLife();
$candy->printSoldProduct();