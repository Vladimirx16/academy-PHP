<?php

$connection = new PDO('mysql:host=localhost; dbname=lesson_eleventh; charset=utf8', 'root', '');

if (isset($_POST['submit'])) {
    for ($i = 1; $i <= 3; $i++) {
        if ($_FILES["picture_$i"]['name'] != "") {
            $fileName = $_FILES["picture_$i"]['name'];
            $fileTmpName = $_FILES["picture_$i"]['tmp_name'];
            $fileType = $_FILES["picture_$i"]['type'];
            $fileError = $_FILES["picture_$i"]['error'];
            $fileSize = $_FILES["picture_$i"]['size'];

            $fileExtension = strtolower(end(explode('.', $fileName)));
            $fileName = substr($fileName, 0, (strlen($fileName) - strlen($fileExtension) - 1));
            $fileName = preg_replace('/[0-9]/', '', $fileName);

            $allowedExtensions = ['jpg', 'jpeg', 'png'];

            if (in_array($fileExtension, $allowedExtensions)) {
                if ($fileSize < 2097152) {
                    if ($fileError == 0) {
                        $connection->query("INSERT INTO lesson_eleventh.images (img_name, img_extension)  VALUES ('$fileName', '$fileExtension')");
                        $lastID = $connection->query("SELECT MAX(id) FROM lesson_eleventh.images");
                        $lastID = $lastID->fetch()['MAX(id)'];
                        $fileNameNew = $lastID . $fileName . '.' . $fileExtension;
                        $fileLocation = 'uploads/' . $fileNameNew;
                        move_uploaded_file($fileTmpName, $fileLocation);
                        header('Location: index.php');
                    } else {
                        echo 'Что-то пошло не так!';
                    }
                } else {
                    echo 'Размер файла слишком большой!';
                }
            } else {
                echo 'Неверный тип файла!';
            }
        }
    }
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>FileInput</title>
</head>
<body>

<form method="POST" enctype="multipart/form-data">
    <input type="file" name="picture_1">
    <input type="file" name="picture_2">
    <input type="file" name="picture_3">
    <input type="submit" name="submit">
</form>

<?
$data = $connection->query("SELECT * FROM lesson_eleventh.images");
echo "<div style='display: flex; align-items: flex-end; flex-wrap: wrap'>";
foreach ($data as $img) {

    $delete = 'delete' . $img['id'];
    $image = "uploads/" . $img['id'] . $img['img_name'] . '.' . $img['img_extension'];
    if (isset($_POST[$delete])) {
        $connection->query('DELETE FROM lesson_eleventh.images WHERE id = "' . $img['id'] . '"');
        if (file($image)) {
            unlink($image);
        }
    }

    if (file_exists($image)) {
        echo "<div>";
        echo "<img style='width: 150px; height: 150px;' src='$image'>";
        echo "<form method='POST'><button name='delete" . $img['id'] . "' style='display: block; margin: auto;'>Удалить</button></form></div>";
    }
}
echo "</div>";
?>

</body>
</html>
