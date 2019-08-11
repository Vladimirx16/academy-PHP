<?php

abstract class Article {
    public $title;
    public $titleFontSize;
    public $articleBody;
    public $articleBodyFontSize;
    public $border;
    public $background;

    public function printArticle() {
        echo "<div style='background: {$this->background}; border: {$this->border};'> <h2 style='font-size: {$this->titleFontSize}px;'>{$this->title}</h2><span style='font-size: {$this->articleBodyFontSize}px'>{$this->articleBody}</span></div>";
    }

    public function __construct(string $title, string $border, string $background, int $titleFontSize = 20, int $articleBodyFontSize = 14, string $articleBody = 'So fishy text here, I strongly recommend do not read this shit, man!')
    {
        $this->title = $title;
        $this->titleFontSize = $titleFontSize;
        $this->articleBody = $articleBody;
        $this->articleBodyFontSize = $articleBodyFontSize;
        $this->border = $border;
        $this->background = $background;
    }
}

class GamesArticle extends Article {
    public $image;

    public function __construct(string $title, string $border, string $background, string $image , int $titleFontSize = 20, int $articleBodyFontSize = 14, string $articleBody = 'So fishy text here, I strongly recommend do not read this shit, man!')
    {
        $this->image = $image;
        parent::__construct($title, $border, $background, $titleFontSize, $articleBodyFontSize, $articleBody);
    }

    public function printArticle() {
        echo "<div style='background: {$this->background}; border: {$this->border};'> <h2 style='font-size: {$this->titleFontSize}px;'>{$this->title}</h2><span style='font-size: {$this->articleBodyFontSize}px'>{$this->articleBody}</span><br><img src='{$this->image}'></div>";
    }
}

class WeatherArticle extends Article {
    public $temperature;

    public function __construct(string $title, string $border, string $background, int $temperature, int $titleFontSize = 20, int $articleBodyFontSize = 14, string $articleBody = 'So fishy text here, I strongly recommend do not read this shit, man!')
    {
        $this->temperature = $temperature;
        parent::__construct($title, $border, $background, $titleFontSize, $articleBodyFontSize, $articleBody);
    }

    public function printArticle() {
        echo "<div style='background: {$this->background}; border: {$this->border};'> <h2 style='font-size: {$this->titleFontSize}px;'>{$this->title}</h2><span style='font-size: {$this->articleBodyFontSize}px'>{$this->articleBody}</span><br><span><b>Temperature today is {$this->temperature} degrees!</b></span></div>";
    }
}

class PoliticsArticle extends Article {
    public $link;

    public function __construct(string $title, string $border, string $background, string $link, int $titleFontSize = 20, int $articleBodyFontSize = 14, string $articleBody = 'So fishy text here, I strongly recommend do not read this shit, man!')
    {
        $this->link = $link;
        parent::__construct($title, $border, $background, $titleFontSize, $articleBodyFontSize, $articleBody);
    }

    public function printArticle() {
        echo "<div style='background: {$this->background}; border: {$this->border};'> <h2 style='font-size: {$this->titleFontSize}px;'>{$this->title}</h2><span style='font-size: {$this->articleBodyFontSize}px'>{$this->articleBody}</span><br><a href='{$this->link}'>Источник</a></div>";
    }
}

$gamesNews = new GamesArticle('Дата выхода RDR 2 на ПК намечена на 30.08.19! ПК бояре ликуют!', '1px solid red', 'yellow', 'img/red-ded-redemption-2.jpg');
$gamesNews->printArticle();

$weatherNews = new WeatherArticle('На 30.08.19 планируются дожди и грозы, запасайтесь чаем и пледом.', '3px solid black', 'wheat', 24);
$weatherNews->printArticle();

$politicsNews = new PoliticsArticle('30.08.19 Владимир Путин уйдёт в отставку - новым президентом станет оппозиционер.', '0.5px solid black', 'beige', 'https://google.com');
$politicsNews->printArticle();