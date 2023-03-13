<?php
/**
 * Created by PhpStorm.
 * User: Konel
 * Date: 09.03.2023
 * Time: 1:31
 */

    error_reporting(E_ERROR | E_PARSE);
    require_once ($_SERVER['DOCUMENT_ROOT']."/controller/controller.php");
?>

<!DOCTYPE html>

<html lang = 'ru'>
    <head>
        <title>CRUD</title>
        <meta charset = 'UTF-8'>

        <script src="/dist/jquery.min.js"></script>

        <link href = '/dist/bootstrap/css/bootstrap.min.css' rel = 'stylesheet' type = 'text/css' >
        <script src = '/dist/bootstrap/js/bootstrap.min.js'></script>

        <link rel = 'stylesheet' type = 'text/css' href = '/styles/styles.css'>
    </head>
    <body>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/view/common/header.php"; ?>
        <main>
            <div class = 'container'>

            <?php
                if ($_POST['add'] || $_POST['edit'] || ($_POST['delete'])) { require_once $_SERVER['DOCUMENT_ROOT']."/view/modal.php"; }
                if ($pages[$_GET['page']] != '') {
            ?>
            <div class = 'page-title'>
                <span><?= $pages[$_GET['page']] ?></span>
            </div>
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/view/{$_GET['page']}.php"; } else { ?>
            <div class = 'error'>
               <div class = 'num'>404</div>
               <div class = 'text'>Страница не найдена!</div>
            </div>
            <?php } ?>
            </div>
        </main>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/view/common/footer.html"; ?>
    </body>
</html>

<?php if ($_POST['add'] || $_POST['edit'] || ($_POST['delete'])) { echo "<script>$('#modal').show('modal')</script>"; } ?>

