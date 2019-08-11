<?php

/*echo '<style>';
echo 'body {display: flex;}';
echo '</style>';

for ($i = 1; $i <= 10; $i++) {
    echo '<div style="margin-right: 20px;">';
    for ($l = 1; $l <= 10; $l++) {
        echo "$i x $l = " . $i*$l . "<br>";
    }
    echo '</div>';
}

ПЕРВАЯ ДОМАШНЯЯ - ГОТОВО*/



/*$i = 1;

while (true) {

    if ($i ** 2 > 100) {
        goto flag;
    }

    echo "$i в квадрате - " . $i ** 2 . '<br>';
    $i++;
}

flag:
echo 'Цикл завершён';

ВТОРОЕ ЗАДАНИЕ - ВЫПОЛНЕНО*/

/*echo multiplication(5, 6, 10);

function multiplication(int $a, int $b, int $c = 5) {
    return $a * $b * $c;
}

ДОМАШКА ТРИ - ВЫПОЛНЕНО*/

/*$arr = [];

for ($i = 1; $i <= 100; $i++) {
    echo $i . '<br>';
    array_push($arr, $i);
}

foreach ($arr as $key=>$value) {
    echo "$value - это простое число №$key<br>";
}

ДОМАШКА 4 - ВЫПОЛНЕНО*/

/*function isYearLeap(int $year) {

    if (($year % 4 == 0 && $year % 100 != 00) || $year % 400 == 0) {
        return true;
    }
    return false;
}

echo isYearLeap(2012);

ДОМАШКА 5 - ГОТОВО*/