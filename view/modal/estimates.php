<?php
/**
 * Created by PhpStorm.
 * User: Konel
 * Date: 10.03.2023
 * Time: 23:40
 */
?>

<?php if ($_POST['edit']) { ?>
<div class = 'row input-row'>
    <div class = 'col-4'>
        <div class = 'label-div'>
            <label for = 'student'>Студент</label>
        </div>
    </div>
    <div class = 'col-8'>
        <input id = 'student' type = 'text' value = '<?= $modalData['current']['student'] ?>' class = 'form-control' placeholder = 'Студент' readonly>
        <input type = 'hidden' name = 'subject_id' value = '<?= $modalData['current']['student_id'] ?>'>
    </div>
</div>
<div class = 'row input-row'>
    <div class = 'col-4'>
        <div class = 'label-div'>
            <label for = 'group_name'>Группа</label>
        </div>
    </div>
    <div class = 'col-8'>
        <input id = 'group_name' type = 'text' value = '<?= $modalData['current']['group_name'] ?>' class = 'form-control' placeholder = 'Группа' readonly>
    </div>
</div>
<div class = 'row input-row'>
    <div class = 'col-4'>
        <div class = 'label-div'>
            <label for = 'subject'>Предмет</label>
        </div>
    </div>
    <div class = 'col-8'>
        <input id = 'subject' type = 'text' value = '<?= $modalData['current']['subject'] ?>' class = 'form-control' placeholder = 'Предмет' readonly>
        <input type = 'hidden' name = 'subject_id' value = '<?= $modalData['current']['subject_id'] ?>'>
    </div>
</div>
<?php } elseif ($_POST['add']) { $modalData['grade'] = 0; if (($modalData['students'] == null) || ($modalData['subjects'] == null)) { $disabled = 'disabled'; ?>
<div class = 'row input-row'>
    <div class = 'col alert alert-danger modal-alert'>
        Невозможно создать новую запись!<br>
        Сперва заполните таблицы: <a href = '/?page=students'>Студенты</a> и <a href = '/?page=subjects' >Предметы</a>!
    </div>
</div>
<?php } ?>

<div class = 'row input-row'>
    <div class = 'col-4'>
        <div class = 'label-div'>
            <label for = 'student'>Студент</label>
        </div>
    </div>
    <div class = 'col-8'>
        <select id = 'student' class = 'form-control' name = 'student_id' <?= $disabled ?>>
            <option hidden selected>Студент</option>
            <?php foreach ($modalData['students'] as $key => $value) { ?>
            <option value = '<?= $value['id'] ?>'><?= $value['name'] ?></option>
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
            <?php foreach ($modalData['subjects'] as $key => $value) { ?>
            <option value = '<?= $value['id'] ?>'><?= $value['name'] ?></option>
            <?php } ?>
        </select>
    </div>
</div>
<?php } ?>
<div class = 'row input-row'>
    <div class = 'col-4'>
        <div class = 'label-div'>
            <label for = 'grade'>Оценка</label>
        </div>
    </div>
    <div class = 'col-8'>
        <input id = 'grade' type = 'number' min = '0' max = '100' value = '<?= $modalData['current']['grade'] ?>' class = 'form-control' placeholder = 'Оценка' name = 'grade' required autocomplete = 'off' <?= $disabled ?>>
    </div>
</div>