<?php
    $db = new PDO('mysql:host=localhost','renatko91_1','Gn0cVMJ70T');
    $cdb = $db->exec("CREATE DATABASE renatko91_1");

    $dbh = new PDO('mysql:dbname=renatko91_1;host=localhost', 'renatko91_1', 'Gn0cVMJ70T');
    $ctable = $dbh->exec("CREATE TABLE `renatko91_1`.`users` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `login` VARCHAR(100) NOT NULL , `password` VARCHAR(255) NOT NULL , `key` VARCHAR(100) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB");

    header ('Location: index.php');
    exit();
?>
