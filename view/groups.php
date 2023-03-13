<?php
/**
 * Created by PhpStorm.
 * User: Konel
 * Date: 09.03.2023
 * Time: 14:12
 */

if ($alarm == 1) { ?>
<div class = 'alert alert-danger'>
    Вы попытались создать дублирующую запись! Не надо так!
</div>
<?php } ?>
<div class = 'row groups'>

    <div class = 'col'></div>
    <div class = 'col-6'>
        <form method = "post">
            <div class = 'add-btn'>
                <input type = 'submit' class = 'btn btn-success' value = 'Добавить группу' name = 'add'>
            </div>
            <table class = 'table table-striped table-bordered'>
                <thead class = 'thead-dark'>
                    <tr>
                        <th>№</th>
                        <th>Группа</th>
                        <th>Изменить</th>
                        <th>Удалить</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $count = 0; foreach ($pageData as $key => $value) { $count++; ?>
                    <tr>
                        <td><?= $count ?></td>
                        <td><?= $value['name'] ?></td>
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