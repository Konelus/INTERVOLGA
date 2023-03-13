<?php
/**
 * Created by PhpStorm.
 * User: Konel
 * Date: 11.03.2023
 * Time: 1:10
 */

if ($alarm == 1) { ?>
    <div class = 'alert alert-danger'>
        Вы попытались создать дублирующую запись! Не надо так!
    </div>
<?php } ?>
<div class = 'row groups'>
    <div class = 'col'></div>
    <div class = 'col-8'>
        <form method = "post">
            <div class = 'add-btn'>
                <input type = 'submit' class = 'btn btn-success' value = 'Добавить связь' name = 'add'>
            </div>
            <table class = 'table table-striped table-bordered'>
                <thead class = 'thead-dark'>
                <tr>
                    <th>№</th>
                    <th>Группа</th>
                    <th>Предмет</th>
                    <th>Изменить</th>
                    <th>Удалить</th>
                </tr>
                </thead>
                <tbody>
                <?php $count = 0; foreach ($pageData as $key => $value) { $count++; ?>
                    <tr>
                        <td><?= $count ?></td>
                        <?php foreach ($value as $key2 => $value2) { if ($key2 != 'id') { ?>
                        <td><?= $value2 ?></td>
                        <?php } } ?>
                        <td class = 'td-input'><input type = 'submit' class = 'btn btn-info' value = 'Изменить' name = 'edit[<?= $key ?>]'></td>
                        <td class = 'td-input'><input type = 'submit' class = 'btn btn-danger' value = 'Удалить' name = 'del[<?= $key ?>]'></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </form>
    </div>
    <div class = 'col'></div>
</div>
