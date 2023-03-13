<?php

/**
 * Created by PhpStorm.
 * User: Konel
 * Date: 12.03.2023
 * Time: 18:32
 */

abstract class abstractModalData extends crud
{
	abstract protected function modalData();		// Выбор требуемых данных для вывода в модальном окне
	abstract protected function modalQuery($table);	// Получение данных
}

class modalData extends abstractModalData
{
	public function __construct() { parent::__construct(); }

	protected function modalData(): array
	{
		$modalData = array();

		switch ($_GET['page'])
		{
			case 'estimates':
				$modalData['students'] = $this->modalQuery('students');
				$modalData['groups'] = $this->modalQuery('groups');
				$modalData['subjects'] = $this->modalQuery('subjects');
			break;
			case 'students':
			case 'groups':
				$modalData['groups'] = $this->modalQuery('groups');
			break;
			case 'subjects':
				$modalData['subjects'] = $this->modalQuery('subjects');
			break;
			case 'groups_subjects':
				$modalData['groups'] = $this->modalQuery('groups');
				$modalData['subjects'] = $this->modalQuery('subjects');
			break;
		}

		return $modalData;
	}

	protected function modalQuery($table): array
	{
		$result = array();

		$query = $this->select("id, name", "`{$table}`");
		if (mysqli_num_rows($query) > 0)
		{
			while ($arr = mysqli_fetch_assoc($query))
			{ $result[] = $arr; }
		}

		return $result;
	}
}