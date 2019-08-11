<?php


/*
 * ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА
 * ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА
 * ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА ВОВА
 *
 * НАДЕЮСЬ ТЫ БЛЯТЬ ЭТО ПРОЧИТАЕШЬ! НУЖНО НАПИСАТЬ ОБРАБОТЧИК $_FILES ПРИ ЗАГРУЗКЕ ФОТО, INPUT И ФОРМА ДЛЯ ЗАГРУЗКИ ГОТОВЫ, НУЖНО ЛИШЬ ЗАМЕНЯТЬ ФОТОГРАФИЮ ПРИ ЗАГРУЗКЕ, ОКЕЙ? ПОДОЗРЕВАЮ, ЭТО МОЖНО СДЕЛАТЬ И БЕЗ БД
 * СПОКОЙНОЙ НОЧИ
 *
 * */

session_start();

if (!$_SESSION['login'] || !$_SESSION['password']) {
    header("Location: index.php");
    die();
}

require_once('connection.php');

$is_admin = 0;

foreach ($usersData as $user) {
    if ($user['user_login'] == $_SESSION['login'] && $user['is_admin'] == 1) {
        $is_admin = 1;
    }
}

if (isset($_POST['upload']) && $is_admin) {
    $fileName = $_FILES['avatar']['name'];
    $fileTmpName = $_FILES['avatar']['tmp_name'];
    $fileType = $_FILES['avatar']['type'];
    $fileError = $_FILES['avatar']['error'];
    $fileSize = $_FILES['avatar']['size'];

    $fileExtension = strtolower(end(explode('.', $_FILES['avatar']['name'])));
    $fileName = substr($fileName, 0, (strlen($fileName) - strlen($fileExtension) - 1));
    $fileName = preg_replace('/[0-9]/', '', $fileName);

    $allowedExtensions = ['jpg', 'jpeg', 'png'];

    if (in_array($fileExtension, $allowedExtensions)) {
        if ($_FILES['avatar']['size'] < 2097152) {
            if ($_FILES['avatar']['error'] == 0) {
                $connection->query("INSERT INTO practice_db.images (img_name, img_extension) VALUES ('$fileName', '$fileExtension')");
                $lastID = $connection->query("SELECT MAX(id) FROM practice_db.images")->fetch()['MAX(id)'];
                $fileFullName = $lastID . $fileName . '.' . $fileExtension;
                $fileLocation = 'uploads/' . $fileFullName;
                move_uploaded_file($fileTmpName, $fileLocation);
                header('Location: portfolio.php');
            } else {
                echo '<p class="text-danger">При загрузке что-то пошло не так :(</p>';
            }
        } else {
            echo '<p class="text-danger">Размер файла слишком большой!</p>';
        }
    } else {
        echo '<p class="text-danger">Недопустимый тип файла!</p>';
    }

}

if (isset($_POST['delete_avatar']) && $is_admin) {
    foreach ($connection->query("SElECT * FROM practice_db.images") as $image) {
        $connection->query("DELETE FROM practice_db.images WHERE id = '". $image['id'] ."'");
    }
    header('Location: portfolio.php');
}

if ($_POST['comment']) {
    $newCommentName = $_SESSION['name'];
    $newComment = strip_tags($_POST['comment']);
    $connection->query("INSERT INTO comments (comment_name, comment) VALUES ('$newCommentName', '$newComment')");
    header('Location: portfolio.php');
}

if ($_POST['delete_comment'] && $is_admin) {
    $connection->query('DELETE FROM comments WHERE id = "' . $_POST['delete_comment'] . '"');
    header('Location: portfolio.php');
}

?>

<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en"> <!--<![endif]-->
<head>
    <title>Responsive Resume/CV Template for Developers</title>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Responsive HTML5 Resume/CV Template for Developers">
    <meta name="author" content="Xiaoying Riley at 3rd Wave Media">
    <link rel="shortcut icon" href="favicon.ico">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,500,400italic,300italic,300,500italic,700,700italic,900,900italic'
          rel='stylesheet' type='text/css'>
    <!-- Global CSS -->
    <link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">
    <!-- Plugins CSS -->
    <link rel="stylesheet" href="assets/plugins/font-awesome/css/font-awesome.css">

    <!-- Theme CSS -->
    <link id="theme-style" rel="stylesheet" href="assets/css/styles.css">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style>
        form img,
        form .change_avatar_input {
            width: 100px;
            height: 100px;
            border-radius: 50%
        }

        form input[type=file] {
            display: none;
        }

        form .change_avatar_input {
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            opacity: 0;
            top: 0;
            margin-top: 30px;
            left: 50%;
            margin-left: -50px;
            transition: 0.5s ease;
        }

        form .change_avatar_input:hover {
            background: rgba(59, 59, 59, 0.76);
            opacity: 1;
            transition: 0.5s ease;
            cursor: pointer;
        }

        form button:focus {
            outline: none !important;
        }

        form .change_avatar_button {
            display: none;
            border-radius: 5px;
            background: #d9534f;
            border-color: #d43f3a;
            margin-bottom: 5px;
        }

        form .change_avatar_button:hover {
            background: #b9423f;
            border-top: 2px solid #b9423f;
            border-left: 2px solid #b9423f;
        }

        form .delete_avatar {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            position: absolute;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 25px;
            height: 25px;
            border-radius: 50%;
            z-index: 1;
            top: 0;
            padding: 0 !important;
            margin-top: 16px;
        }
    </style>
</head>

<body>
<div class="user-region">
    <span class="information">Вы вошли как </span><a href="index.php"><?= $_SESSION['login'] ?></a>
</div>
<div class="wrapper">
    <div class="sidebar-wrapper">
        <div class="profile-container">
            <form method="POST" action="portfolio.php" enctype="multipart/form-data"
                  style="display: flex;flex-direction: column;justify-content: center;align-items: center;">
                <? if ($is_admin) {?>
                <button class="btn btn-danger delete_avatar" name="delete_avatar" style="font-family: 'FontAwesome';">&#xf014;</button>
                <? } ?>
                <img id="avatar" class="profile" src=
                <?
                if ($connection->query("SELECT COUNT(id) FROM practice_db.images")->fetch()['COUNT(id)'] != 0) {
                    $imgID = $connection->query("SELECT MAX(id) FROM practice_db.images")->fetch()['MAX(id)'];
                    $imgName = $connection->query("SELECT img_name FROM practice_db.images WHERE id = $imgID")->fetch()['img_name'];
                    $imgExtension = $connection->query("SELECT img_extension FROM practice_db.images WHERE id = $imgID")->fetch()['img_extension'];
                    $connection->query("DELETE FROM practice_db.images WHERE id = ($imgID - 1)");
                    echo 'uploads/' . $imgID . $imgName . '.' . $imgExtension;
                } else {
                    echo 'uploads/default.png';
                }
                ?>
                >
                <? if ($is_admin) { ?>
                    <label class="change_avatar_input">Изменить фото
                        <input id="change_avatar" type="file" name="avatar">
                    </label>
                    <button class="change_avatar_button" name="upload"">Загрузить новое<br>фото</button>
                    <a href="portfolio.php" style="color: white;text-decoration: none;">
                        <button class="change_avatar_button" name="decline">Отменить</button>
                    </a>
                <? } ?>
            </form>
            <h1 class="name"><?= $aboutData['name'] ?></h1>
            <h3 class="tagline"><?= $aboutData['post'] ?></h3>
        </div><!--//profile-container-->

        <div class="contact-container container-block">
            <ul class="list-unstyled contact-list">
                <li class="email"><i class="fa fa-envelope"></i><a
                            href="mailto: yourname@email.com"><?= $aboutData['email'] ?></a></li>
                <li class="phone"><i class="fa fa-phone"></i><a href="tel:0123 456 789"><?= $aboutData['phone'] ?></a>
                </li>
                <li class="website"><i class="fa fa-globe"></i><a href="https://vk.com/darkvova"
                                                                  target="_blank"><?= $aboutData['site'] ?></a></li>
                <li class="github"><i class="fa fa-github"></i><a href="https://github.com/Vladimirx16"
                                                                  target="_blank"><?= $aboutData['github'] ?></a></li>
            </ul>
        </div><!--//contact-container-->
        <div class="education-container container-block">
            <h2 class="container-block-title">Education</h2>
            <? foreach ($educationData as $education) { ?>
                <div class="item">
                    <h4 class="degree"><?= $education['faculty'] ?></h4>
                    <h5 class="meta"><?= $education['university'] ?></h5>
                    <div class="time"><?= $education['duration'] ?></div>
                </div><!--//item-->
            <? } ?>
        </div><!--//education-container-->

        <div class="languages-container container-block">
            <h2 class="container-block-title">Languages</h2>
            <ul class="list-unstyled interests-list">
                <? foreach ($speechData as $speech) { ?>
                    <li><?= $speech['language'] ?> <span class="lang-desc">(<?= $speech['level'] ?>)</span></li>
                <? } ?>
            </ul>
        </div><!--//interests-->

        <div class="interests-container container-block">
            <h2 class="container-block-title">Interests</h2>
            <ul class="list-unstyled interests-list">
                <? foreach ($interestsData as $interests) { ?>
                    <li><?= $interests['interest'] ?></li>
                <? } ?>
            </ul>
        </div><!--//interests-->

    </div><!--//sidebar-wrapper-->

    <div class="main-wrapper">

        <section class="section summary-section">
            <h2 class="section-title"><i class="fa fa-user"></i>Career Profile</h2>
            <div class="summary">
                <p><?= $careerData['career_description'] ?></p>
            </div><!--//summary-->
        </section><!--//section-->

        <section class="section experiences-section">
            <h2 class="section-title"><i class="fa fa-briefcase"></i>Experiences</h2>

            <? foreach ($experiencesData as $experiences) { ?>

                <div class="item">
                    <div class="meta">
                        <div class="upper-row">
                            <h3 class="job-title"><?= $experiences['post'] ?></h3>
                            <div class="time"><?= $experiences['duration'] ?></div>
                        </div><!--//upper-row-->
                        <div class="company"><?= $experiences['job'] ?>, <?= $experiences['location'] ?></div>
                    </div><!--//meta-->
                    <div class="details">
                        <p><?= $experiences['details'] ?></p>
                    </div><!--//details-->
                </div><!--//item-->

            <? } ?>

        </section><!--//section-->

        <section class="section projects-section">
            <h2 class="section-title"><i class="fa fa-archive"></i>Projects</h2>
            <div class="intro">
                <p>You can list your side projects or open source libraries in this section. Lorem ipsum dolor sit amet,
                    consectetur adipiscing elit. Vestibulum et ligula in nunc bibendum fringilla a eu lectus.</p>
            </div><!--//intro-->
            <? foreach ($projectsData as $projects) { ?>

                <div class="item">
                    <span class="project-title"><?= $projects['name'] ?></span> - <span
                            class="project-tagline"><?= $projects['description'] ?></span>

                </div><!--//item-->

            <? } ?>
        </section><!--//section-->

        <section class="skills-section section">
            <h2 class="section-title"><i class="fa fa-rocket"></i>Skills &amp; Proficiency</h2>
            <div class="skillset">

                <? foreach ($skillsData as $skills) { ?>

                    <div class="item">
                        <h3 class="level-title"><?= $skills['name'] ?></h3>
                        <div class="level-bar">
                            <div class="level-bar-inner" data-level=<?= $skills['progress'] ?>>
                            </div>
                        </div><!--//level-bar-->
                    </div><!--//item-->

                <? } ?>

            </div>
        </section><!--//skills-section-->

        <form action="" class="feedback-form" method="POST">
            <input id="input_name" type="text" name="name" class="input name" style="font-family:Arial, FontAwesome"
                   value=<?= '\'' . $_SESSION['name'] . '\'' ?> required disabled>
            <? if ($connection->query('SELECT validate FROM users WHERE user_login = "' . $_SESSION['login'] . '"')->fetch()['validate'] == 1) {
                ?>
                <input type="text" name="comment" class="input" placeholder="Ваш комментарий..." autocomplete="off"
                       required>
                <input type="submit" class="submit">
            <? } else { ?>
                <input type="text" name="comment" class="input" placeholder="Ваша почта ожидает подтверждения"
                       autocomplete="off" disabled required>
                <input type="submit" class="submit" disabled style="opacity: 0.5;">
                <?
            }
            ?>
        </form>

        <? if (!($connection->query("SELECT id FROM comments LIMIT 1"))->fetch()) { ?>
            <div class="no-comments">Здесь пока что нет никаких комментариев.</div>
        <? } else {
        $allComments = $connection->query('SELECT * FROM comments ORDER BY comment_date DESC');
        foreach ($allComments

        as $comment) { ?>
        <div class="comment-section"><span class="name"><?= $comment['comment_name'] ?>:</span><span
                    class="comment"><?= $comment['comment'] ?></span><span
                    class="date"><?= substr($comment['comment_date'], 0, 10) ?></span>
            <?
            if ($is_admin == 1) {
            ?>
            <form action="" method="POST">
                <button class="btn btn-danger" name="delete_comment" value="<?= $comment['id'] ?>"
                        style="font-family:Arial,FontAwesome; padding:0 4px;">&#xf014;
                </button>
            </form>
        </div> <?
        } else {
        ?> </div> <?
    }
    }
    } ?>

</div><!--//main-body-->
</div>

<footer class="footer">
    <div class="text-center">
        <!--/* This template is released under the Creative Commons Attribution 3.0 License. Please keep the attribution link below when using for your own project. Thank you for your support. :) If you'd like to use the template without the attribution, you can check out other license options via our website: themes.3rdwavemedia.com */-->
        <small class="copyright">Designed with <i class="fa fa-heart"></i> by <a href="http://themes.3rdwavemedia.com"
                                                                                 target="_blank">Xiaoying Riley</a> for
            developers
        </small>
    </div><!--//container-->
</footer><!--//footer-->

<!-- Javascript -->
<script type="text/javascript" src="assets/plugins/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<!-- custom js -->
<script type="text/javascript" src="assets/js/main.js"></script>
</body>
</html> 

