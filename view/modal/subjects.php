<?php
/**
 * Created by PhpStorm.
 * User: Konel
 * Date: 11.03.2023
 * Time: 1:02
 */
?>

<div class = 'row input-row'>
    <div class = 'col-4'>
        <div class = 'label-div'>
            <label for = 'subject'>Предмет</label>
        </div>
    </div>
    <div class = 'col-8'>
        <input id = 'subject' type = 'text' value = '<?= $modalData['current']['name'] ?>' class = 'form-control' placeholder = 'Предмет' name = 'name' autocomplete = 'off'>
    </div>
</div>
