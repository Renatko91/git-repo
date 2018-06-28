<?php
    session_start();
?>

<!DOCTYPE html>
<html>

    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link href="style.css" rel="stylesheet">
        <title>Страница 2</title>
    </head>

    <body>
        <div id='header'>
            Тестовый сайт
            <a href="index.php">Главная</a> <a href="page1.php">Страница 1</a> <a href="page2.php">Страница 2</a>
        </div>

        <?php
            if(!empty($_SESSION['auth'])) {
        ?>

        <div id='container'>
            <p>Этот текст только для юзеров!</p>
        </div>

        <?php
        }
        else {
        ?>

        <div id='container'>
            <p>Вам сюда нельзя!</p>
        </div>

        <?php
            }
        ?>

        <div id='footer'>
            Подвал
        </div>
    </body>
</html>
