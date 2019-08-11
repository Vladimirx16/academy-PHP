<?php
$connection = new PDO('mysql:host=localhost; dbname=lesson_tenth; charset=utf8', 'root', '');
$allComments = $connection->query("SELECT * FROM lesson_tenth.comments WHERE moderated = 0 AND decision != 'rejected' AND decision != 'accepted'");

session_start();

if (!$_SESSION['admin_login'] || !$_SESSION['admin_password']) {
    header('Location: login.php');
    die();
}

$is_admin = 0;
$is_moder = 0;

if ($connection->query('SELECT is_admin FROM lesson_tenth.users WHERE user_login = "'. $_SESSION['admin_login'] .'"')->fetch()['is_admin']) {
    $is_admin = true;
} else {
    $is_moder = false;
}

foreach ($_POST as $key => $comment) {
    if ($comment == "accept") {
        $connection->query('UPDATE lesson_tenth.comments SET moderated = 1, decision = "accepted" WHERE id = "' . $key . '"');
        header('Location: admin-panel.php');
    } else {
        $connection->query('UPDATE lesson_tenth.comments SET moderated = 1, decision = "rejected" WHERE id = "' . $key . '"');
        header('Location: admin-panel.php');
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
    <title>Админ-панель</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<style>
    .comment-header {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        margin: 10px 0;
    }

    .comment-header .name,
    .comment-header .date {
        font-weight: 600;
    }

    .pre {
        margin-bottom: 20px;
    }

    .comment-actions form {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
    }
</style>
<body>
<h2 class="title" style="text-align: center;color: #42A8C0;">Панель администратора</h2>
<br>
<span>Комментарии к модерации:</span>
<div class="moderation-section">

    <?
    if ($connection->query('SELECT COUNT(*) FROM lesson_tenth.comments WHERE moderated = 0')->fetch()['COUNT(*)'] == 0) {
        echo '<span style="margin-top: 20px; text-decoration: underline;">Нет комментариев к модерации</span>';
    } else {
        foreach ($allComments as $comment) { ?>
            <div class="moderation-comment">
                <div class="comment-header">
                    <span class="name"><?= $comment['user_name'] ?></span>
                    <span class="date"><?= $comment['comment_date'] ?></span>
                </div>
                <div class="pre"><?= $comment['user_comment'] ?></div>
                <div class="comment-actions">
                    <form method="POST">
                        <select id=<?= $comment['id'] ?> name=<?= $comment['id'] ?>>
                            <? if ($is_admin) { ?>
                                <option value="accept">Опубликовать</option>
                                <option value="reject">Отклонить</option>
                            <? } else { ?>
                            <option value="reject">Отклонить</option>
                <? } ?>
                        </select>
                        <button>Отправить</button>
                    </form>
                </div>
            </div>
        <? }
    } ?>

</div>
</body>
</html>
