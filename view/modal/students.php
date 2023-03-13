<?php
/**
 * Created by PhpStorm.
 * User: Konel
 * Date: 11.03.2023
 * Time: 0:31
 */
?>

<?php if (!$modalData['groups']) { ?>
<div class = 'row input-row'>
    <div class = 'col alert alert-info modal-alert'>Не забудьте создать для студента группу!</div>
</div>
<?php } ?>
<div class = 'row input-row'>
    <div class = 'col-4'>
        <div class = 'label-div'>
            <label for = 'student'>Студент</label>
        </div>
    </div>
    <div class = 'col-8'>
        <input id = 'student' type = 'text' value = '<?= $modalData['current']['student'] ?>' class = 'form-control' placeholder = 'Студент' name = 'name' autocomplete = 'off'>
    </div>
</div>
<div class = 'row input-row'>
    <div class = 'col-4'>
        <div class = 'label-div'>
            <label for = 'groups'>Группа</label>
        </div>
    </div>
    <div class = 'col-8'>
        <?php if (!$modalData['groups']) { $groupDisabled = 'disabled'; } ?>
        <select id = 'groups' class = 'form-control' name = 'group_id' <?= $groupDisabled ?> required>
            <option hidden value = ''>Группа</option>
            <?php foreach ($modalData['groups'] as $key => $value) { if ($modalData['current']['group_name'] == $value['name']) { $selected = 'selected'; } else { $selected = ''; } ?>
            <option value = '<?= $value['id'] ?>' <?= $selected ?>><?= $value['name'] ?></option>
            <?php } ?>
        </select>
    </div>
</div>