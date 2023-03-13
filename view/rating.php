<?php
/**
 * Created by PhpStorm.
 * User: Konel
 * Date: 09.03.2023
 * Time: 2:23
 */
?>

<div class = 'row group-select'>
    <div class = 'col'></div>
    <div class = 'col-4'>
        <form method = "post">
            <div class = 'input-group'>
                <label for = 'group' class = 'input-group-text'>Группа</label>
                <select id = 'group' class = 'form-control' onchange="form.submit()" name = 'selected-group'>
                    <option hidden>Выбор группы</option>
                    <?php $selected[$_POST['selected-group']] = 'selected'; foreach ($pageData['groups'] as $key => $value) { ?>
                    <option <?= $selected[$key] ?> value = '<?= $value['id'] ?>'><?= $value['name'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <?php if (count($pageData['groups']) == 0) { ?>
            <div class = 'alert alert-danger estimate-alert'>Нет групп для выбора!</div>
            <?php } ?>
        </form>
    </div>
    <div class = 'col'></div>
</div>

<?php if (($_POST['selected-group']) && ($pageData['grade'] != null) && (count($pageData['subjects']) != 0)) { ?>
<div class = 'row'>
    <div class = 'col'>
        <table class = 'table table-striped table-bordered'>
            <thead class = 'thead-dark'>
            <tr>
                <th>№</th>
                <th>Студент</th>
                <?php foreach ($pageData['subjects'] as $key => $value) { ?>
                <th><?= $value ?></th>
                <?php } ?>
                <th>Средний балл</th>
            </tr>
            </thead>
            <tbody>
            <?php $count = 0; foreach ($pageData['student-grade'] as $key => $value) { $count++; ?>
                <tr>
                    <td><?= $count ?></td>
                    <?php foreach ($pageData['grade'][$key] as $key2 => $value2) { if ($key2 != 'id') { ?>
                    <td><?= $value2 ?></td>
                    <?php } } ?>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php } elseif (($_POST['selected-group']) && (($pageData['grade'] == null) || (count($pageData['subjects']) == 0))) {?>
    <div class = 'alert alert-danger estimate-alert'>
        Внимание! Не удалось отобразить рейтинг студентов!<br>
        В выбранной группе нет студентов или у студентов нет оценок в предметах доступных данной группе!<br>
        Проверьте наличие корректных записей в таблицах: <a href = '/?page=estimates'>Оценки</a> и <a href = '/?page=groups_subjects'>Связь: группа-предмет</a>!
    </div>
    <div class = 'alert alert-info estimate-alert'>
        Возможна ситуация, когда студент перевелся из одной группы в другую, и, в новой группе нет ранее оцененных предметов!
    </div>
<?php } ?>
