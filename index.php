<?php
    session_start();

    try {
        $dbh = new PDO('mysql:dbname=renatko91_1;host=localhost', 'renatko91_1', 'Gn0cVMJ70T');
    }
    catch (PDOException $e) {
        header ('Location: db.php');
        exit();
    }

    $stable = $dbh->query("SELECT `id` FROM `users`");
    if(empty($stable))
    {
        header ('Location: db.php');
        exit();
    }

    function generateCache()
    {
        $salt='';
        $saltLength=8;
        for($i=0; $i<$saltLength; $i++)
        {
            $salt.=chr(mt_rand(33,126));
        }
        return $salt;
    }

    if(empty($_SESSION['auth'])) {
        if (!empty($_COOKIE['login']) and !empty($_COOKIE['key']) ) {
            $login=$_COOKIE['login'];
            $key=$_COOKIE['key'];

            $skey = $dbh->prepare("SELECT `key` FROM `users` WHERE `login` = ?");
            $skey->execute(array($login));
            $key_db=$skey->fetch(PDO::FETCH_ASSOC);

            if(!empty($key_db)) {
                $_SESSION['auth']=true;
            }
        }
        else {
            if(!empty($_POST['login']) && !empty($_POST['password'])) {
                $options=array('options'=>array('regexp'=>'/^[a-zA-z0-9]*$/'));
                $login=filter_var($_POST['login'], FILTER_VALIDATE_REGEXP, $options);
                $password=filter_var($_POST['password'], FILTER_VALIDATE_REGEXP, $options);

                $spas = $dbh->prepare("SELECT `password` FROM `users` WHERE `login` = ?");
                $spas->execute(array($login));
                $password_db = $spas->fetch(PDO::FETCH_ASSOC);

                if(!empty($password_db)) {
                    if(password_verify($password, $password_db['password'])) {
                        $_SESSION['auth']=true;

                        if(!empty($_POST['remember'])) {
                            $key=generateCache();

                            setcookie('login', $login, time()+3600*24*30);
                            setcookie('key', $key, time()+3600*24*30);

                            $uuser = $dbh->prepare("UPDATE `users` SET `key` = :key WHERE `login` = :login");
                            $uuser->execute(array('key' => $key, 'login' => $login));
                            header("Refresh:0");
                        }
                    }
                    else {
                        echo "<p>Неверный пароль.</p>";
                    }
                }
                else {
                    echo "<p>Пользователь не зарегистрирован.</p>";
                }
            }
        }
    }
    if(!empty($_POST['exit'])) {
        session_destroy();

        setcookie('login', '', time());
        setcookie('key', '', time());
        header("Refresh:0");
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link href="style.css" rel="stylesheet">
        <title>Авторизация</title>
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
            <p>Поздравляем вы вошли!</p>
            <form action="" method="POST">
                <input type="submit" name="exit" value="Выход">
            </form>
        </div>

        <?php
            }
            else {
        ?>

        <div id='container'>
            <form action="index.php" method="POST">
                Логин <input type="text" required name="login" placeholder="Логин">
                </br>
                Пароль <input type="password" required name="password" placeholder="Пароль">
                </br>
                <input type="checkbox" name="remember"> Запомнить
                </br>
                <input type="submit" value="Вход">
            </form>

            <form action="reg.php">
                <input type="submit" value="Регистрация">
            </form>
        </div>

        <?php
            }
        ?>

        <div id='footer'>
            Подвал
        </div>
    </body>
</html>
