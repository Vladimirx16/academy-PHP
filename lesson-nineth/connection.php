<?php
$connection = new PDO('mysql:host=localhost; dbname=practice_db; charset=utf8', 'root', '');

$aboutData = ($connection->query('SELECT * FROM about'))->fetch();
$educationData = $connection->query('SELECT * FROM education');
$speechData = $connection->query('SELECT * FROM speech');
$interestsData = $connection->query('SELECT * FROM interests');
$careerData = ($connection->query('SELECT * FROM career'))->fetch();
$experiencesData = $connection->query('SELECT * FROM experience');
$projectsData = $connection->query('SELECT * FROM projects');
$skillsData = $connection->query('SELECT * FROM skills');
$usersData = $connection->query('SELECT * FROM users');