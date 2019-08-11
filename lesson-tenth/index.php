<?php
$connection = new PDO('mysql:host=localhost; dbname=lesson_tenth; charset=utf8', 'root', '');
$allComments = $connection->query("SELECT * FROM comments ORDER BY comment_date DESC");

if ($_POST['user_name']) {
    $safeQuery = $connection->prepare('INSERT INTO lesson_tenth.comments(user_name, user_comment) VALUES (:userName, :userComment)');
    $comment_info = ['userName'=>htmlspecialchars($_POST['user_name']), 'userComment'=>htmlspecialchars($_POST['user_comment'])];
    $safeQuery->execute($comment_info);
    header('Location: index.php');
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Форум</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<form method="POST">
    <input type="text" name="user_name" placeholder="Ваше имя" required>
    <textarea name="user_comment" placeholder="Ваш комментарий" required></textarea>
    <button>Отправить</button>
</form>

<div class="comments-section">
    <span class="warning">Перед публикацией комментарии проходят модерацию</span>
    <?

    if ($connection->query("SELECT COUNT(*) FROM lesson_tenth.comments")->fetch()['COUNT(*)'] == 0 || $connection->query("SELECT COUNT(*) FROM lesson_tenth.comments WHERE moderated = 1")->fetch()['COUNT(*)'] == 0) {
        echo "<div style='display: flex;align-items: center;justify-content: center;text-align: center;max-width:300px;width: 100%;'>Здесь пока что нету никаких комментариев!</div>";
    } else {
        foreach ($allComments as $comment) {
            if ($comment['moderated'] && $comment['decision'] == 'accepted')
            echo "<div class='pre' style='padding: 10px 5px; margin-bottom: 20px;'><div class='comment-section'><span class='name' style='width: 70px; text-align: left'>". $comment['user_name'] .":</span><span class='comment' style='text-align: left; max-width: 150px; width: 100%;'>". $comment['user_comment'] ."</span><span class='date'>". substr($comment['comment_date'], 0, 10) ."</span></div></div>";
        }
    }

    ?>
</div>

</body>
</html>
