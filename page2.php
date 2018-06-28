<?php
    session_start();
    include 'layout/header.php';
?>

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

<?php
    include 'layout/footer.php'
?>
