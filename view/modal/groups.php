<?php
/**
 * Created by PhpStorm.
 * User: Konel
 * Date: 10.03.2023
 * Time: 23:54
 */
?>

<div class = 'row input-row'>
    <div class = 'col-4'>
        <div class = 'label-div'>
            <label for = 'group'>Группа</label>
        </div>
    </div>
    <div class = 'col-8'>
        <input id = 'group' type = 'text' value = '<?= $modalData['current']['name'] ?>' class = 'form-control' placeholder = 'Группа' name = 'name' autocomplete = 'off'>
    </div>
</div>
