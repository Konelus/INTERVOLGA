<?php
/**
 * Created by PhpStorm.
 * User: Konel
 * Date: 09.03.2023
 * Time: 17:41
 */
?>

<div class = 'modal' id = 'modal'>
    <div class = 'modal-dialog'>
        <div class = 'modal-content'>
            <form method = "post">
                <div class = 'modal-header'>
                    <div class = 'title'><?= $modalTitle ?></div>
                </div>
                <div class = 'modal-body'>
                    <?php if ($pages[$_GET['page']]) { require_once __DIR__."/modal/{$_GET['page']}.php"; } ?>
                </div>
                <div class = 'modal-footer'>
                    <?php if ($_POST['edit']) { ?><input type = 'hidden' value = '<?= $modalData['current']['id'] ?>' name = 'id'><?php } ?>
                    <input type = 'submit' value = '<?= $modalBtn ?>' class = 'btn btn-success' <?= $disabled ?> name = '<?= key($_POST).'-submit' ?>'>
                    <input type = 'button' value = 'Закрыть' class = 'btn btn-dark' onclick = "$('#modal').addClass('d-none')">
                </div>
            </form>
        </div>
    </div>
</div>