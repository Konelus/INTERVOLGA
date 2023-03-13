<?php
/**
 * Created by PhpStorm.
 * User: Konel
 * Date: 11.03.2023
 * Time: 21:41
 */
?>

<?php if ($_POST['add']) { $modalData['grade'] = 0; if (($modalData['groups'] == null) || ($modalData['subjects'] == null)) { $disabled = 'disabled'; ?>
<div class = 'row input-row'>
    <div class = 'col alert alert-danger modal-alert'>
        Невозможно создать новую запись!<br>
        Сперва заполните таблицы: <a href = '/?page=groups'>Группы</a> и <a href = '/?page=subjects' >Предметы</a>!
    </div>
</div>
<?php } } ?>
<div class = 'row input-row'>
    <div class = 'col-4'>
        <div class = 'label-div'>
            <label for = 'group_name'>Группа</label>
        </div>
    </div>
    <div class = 'col-8'>
        <select id = 'group_name' class = 'form-control' name = 'group_id' <?= $disabled ?>>
            <option hidden selected>Группа</option>
            <?php foreach ($modalData['groups'] as $key => $value) { if ($modalData['current']['group_name'] == $value['name']) { $selected['group'] = 'selected'; } else { $selected['group'] = ''; } ?>
            <option <?= $selected['group'] ?> value = '<?= $value['id'] ?>'><?= $value['name'] ?></option>
            <?php } ?>
        </select>
    </div>
</div>
<div class = 'row input-row'>
    <div class = 'col-4'>
        <div class = 'label-div'>
            <label for = 'subjects'>Предмет</label>
        </div>
    </div>
    <div class = 'col-8'>
        <select id = 'subjects' class = 'form-control' name = 'subject_id' <?= $disabled ?>>
            <option hidden selected>Предмет</option>
            <?php foreach ($modalData['subjects'] as $key => $value) { if ($modalData['current']['subject'] == $value['name']) { $selected['subject'] = 'selected'; } else { $selected['subject'] = ''; } ?>
            <option <?= $selected['subject'] ?> value = '<?= $value['id'] ?>'><?= $value['name'] ?></option>
            <?php } ?>
        </select>
    </div>
</div>