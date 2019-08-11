<?php

abstract class Product {
    public $id;
    public $name;
    public $weight;
    public $price;
    public $clearPrice;

    public abstract function showImage();

    public function description() {
        echo "Описание товара №{$this->id}: Название - {$this->name}, вес - {$this->weight} г, цена - {$this->price} руб<br><br>";
    }

    public function clearPrice() {
        echo "Цена товара {$this->name} с НДС - {$this->price} руб<br>Цена товара {$this->name} без НДС - {$this->clearPrice} руб<br><br>";
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
}

class Candy extends Product {
    public function showImage() {
        echo "<div style='width:100px;height:100px;background:url(img/candy.jpg)no-repeat;background-size:cover;'></div>";
    }
}

$chocolate = new Chocolate(0, 'Шоколадка', 100, 90, 250);
$chocolate->description();
$chocolate->showImage();

$candy = new Candy(1, 'Конфетка', 30, 10);
$candy->description();
$candy->showImage();