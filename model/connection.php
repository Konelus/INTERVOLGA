<?php
/**
 * Created by PhpStorm.
 * User: Konel
 * Date: 09.03.2023
 * Time: 22:10
 */

abstract class abstractConnection
{
	abstract protected function select($value, $table, $where = '', $report = 0);		// Получение данных
	abstract protected function update($table, $fields, $values, $where, $report = 0);	// Изменение данных
	abstract protected function insert($table, $values, $fields, $report = 0);			// Добавление данных
	abstract protected function delete($table, $where, $report = 0);					// Удаление данных
}
class connection extends abstractConnection
{
	protected object $mysql;

	public function __construct()
	{
		$data = parse_ini_file(__DIR__."/connection.ini");
		$this->mysql = mysqli_connect($data['hostname'],$data['username'],$data['password'],$data['database']);
		$this->mysql->set_charset("UTF8");
	}
	protected function select($value, $table, $where = '1', $report = 0)
	{
		$query = "SELECT $value FROM $table WHERE $where ORDER BY id ASC";
		if ($report == 1) { echo "<div>$query</div>"; }
		$result = $this->mysql->query($query);

		return $result;
	}

	protected function update($table, $fields, $values, $where, $report = 0)
	{
		$resultValues = '';
		// Обработка полей и значение
		foreach ($values as $key => $value)
		{
			if ($resultValues == '') { $resultValues = "`{$fields[$key]}` = '$value'"; }
			else { $resultValues .= ", `{$fields[$key]}` = '$value'"; }
		}
		$query = "UPDATE $table SET $resultValues WHERE $where";
		if ($report == 1) { echo "<div>$query</div>"; }
		$this->mysql->query($query);
	}

	protected function insert($table, $values, $fields, $report = 0)
	{
		$query = "INSERT INTO $table ($fields) VALUES ($values)";
		if ($report == 1) { echo "<div>$query</div>"; }
		$this->mysql->query($query);
	}

	protected function delete($table, $where, $report = 0)
	{
		$query = "DELETE FROM $table WHERE $where";
		if ($report == 1) { echo "<div>$query</div>"; }
		$this->mysql->query($query);
	}
}