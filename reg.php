<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Регистрация</title>
    </head>

    <body>
        <h1>Введите данные для регистрации.</h1>
        <form action="" method="POST">
            <input type=text placeholder="login" required name="login">
            <input type=password placeholder="password" required name="password">
            <input type=submit value=Регистрация>
        </form>

        <hr>

        <form action="index.php">
            <button type=submit>Выйти</button>
        </form>
    </body>
</html>

<?php
    try {
        $dbh = new PDO('mysql:dbname=renatko91_1;host=localhost', 'renatko91_1', 'Gn0cVMJ70T');
    }
    catch (PDOException $e) {
        die('Подключение не удалось: ' . $e->getMessage());
    }

    if(!empty($_POST)) {
        $options=array('options'=>array('regexp'=>'/^[a-zA-z0-9]*$/'));
        $login=filter_var($_POST['login'], FILTER_VALIDATE_REGEXP, $options);
        $password=password_hash($_POST['password'], PASSWORD_BCRYPT);

        if(!empty($login)) {
            $sall = $dbh->prepare("SELECT * FROM `users` WHERE `login` = ?");
            $sall->execute(array($login));
            $reg = $sall->rowCount();

            if ($reg==0) {
                $sall = $dbh->prepare("INSERT INTO `users` (`login`, `password`) VALUES (:login,:password)");
                $sall->execute(array('login'=>$login,'password'=>$password));
                /*mysqli_query($connection,"INSERT INTO `users` (`login`, `password`) VALUES ('$login','$password')");*/
                echo "<p>Вы зарегистрированы.</p>";
            }
            else {
                echo "<p>Произошла ошибка либо пользователь уже зарегистрирован.</p>";
            }
        }
        else {
            echo "<p>Произошла ошибка либо пользователь уже зарегистрирован.</p>";
        }
    }
?>
