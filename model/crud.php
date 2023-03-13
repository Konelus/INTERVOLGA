<?php

/**
 * Created by PhpStorm.
 * User: Konel
 * Date: 12.03.2023
 * Time: 18:28
 */

abstract class abstractCrud extends connection
{
	abstract public function insertData();	// Добавление данных
	abstract public function updateData();	// Изменение данных
	abstract public function delData();		// Удаление данных
}

class crud extends abstractCrud
{

	public function __construct()
	{ parent::__construct(); }

	public function insertData(): bool
	{
		$fields = $values = $where = '';
		$alarm = 0;

		foreach ($_POST as $key => $value)
		{
			if ($key != 'add-submit')
			{
				$value = htmlspecialchars(mysqli_real_escape_string($this->mysql, $value));

				// Получение набора значений
				if ($values == '') { $values = "NULL, '$value'"; }
				else { $values .= ", '$value'"; }

				// Получение набора полей
				if ($fields == '') { $fields = 'id, '.$key; }
				else { $fields .= ", $key"; }

				// Составление условия проверки на наличие записи
				if ($key != 'grade')
				{
					if ($where == '') { $where = "`$key` = '$value'"; }
					else { $where .= " AND `$key` = '$value'"; }
				}
			}
		}

		// Проверка наличия идентичной записи
		$query = $this->select("id","`{$_GET['page']}`","$where");
		if (($query != null) && (mysqli_num_rows($query) == 0))
		{
			$this->insert("`{$_GET['page']}`", "$values", "$fields");
			header ("Location: /?page={$_GET['page']}");

		}
		else { $alarm = 1 ; }
		return $alarm;
	}

	public function updateData(): bool
	{
		$fields = $values =  array();
		$alarm = 0;
		$where = '';

		foreach ($_POST as $key => $value)
		{
			if (($key != 'edit-submit') && ($key != 'id'))
			{
				$value = htmlspecialchars(mysqli_real_escape_string($this->mysql, $value));

				$values[] = "$value";
				$fields[] = "$key";

				// Составление условия проверки на наличие записи
				if ($where == '') { $where = "`$key` = '$value'"; }
				else { $where .= " AND `$key` = '$value'"; }
			}
		}

		// Проверка наличия идентичной записи
		$query = $this->select("id", "`{$_GET['page']}`", "$where");
		if (($query != null) && (mysqli_num_rows($query) == 0))
		{
			$this->update("`{$_GET['page']}`", $fields, $values, "id = '{$_POST['id']}'");
			header ("Location: /?page={$_GET['page']}");
		}
		else { $alarm = 1 ; }
		return $alarm;
	}

	public function delData()
	{
		$id = key($_POST['del']);

		// Редактирование зависимостей при удалении группы
		if ($_GET['page'] == 'groups')
		{
			$values[] = "0";
			$fields[] = "group_id";
			$this->update("students", $fields, $values, "group_id = '$id'");
			$this->delete("groups_subjects", "group_id = '$id'");
		}
		// Удаление связи и оценки при удалении предмета
		elseif ($_GET['page'] == 'subjects')
		{
			$this->delete("groups_subjects", "subject_id = '$id'");
			$this->delete("estimates", "subject_id = '$id'");
		}
		// Удаление оценки при удалении студента
		elseif ($_GET['page'] == 'students')
		{ $this->delete("estimates", "student_id = '$id'"); }

		$this->delete("`{$_GET['page']}`", "id = '$id'");
		header ("Location: /?page={$_GET['page']}");
	}
}