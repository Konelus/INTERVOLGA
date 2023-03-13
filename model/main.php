<?php

/**
 * Created by PhpStorm.
 * User: Konel
 * Date: 09.03.2023
 * Time: 16:06
 */

abstract class abstractModal extends modalData
{
	abstract public function selectPageData();		// Получение данных для каждой страницы
	abstract protected function rating();			// Получение данных для страницы рейтинга

	abstract protected function subjectsList();		// Список всех студентов
	abstract protected function estimateList();		// Список всех оценок
	abstract protected function groupList();		// Список всех групп
	abstract protected function studentList();		// Список всех студентов
	abstract protected function groups_subjects();	// Список всех связей между группами и дисциплинами

	abstract protected function studentsInGroup();	// Список студентов в выбранной группе
	abstract protected function subjectsInGroup();	// Список дисциплин для выбранной группы
}
class model extends abstractModal
{
	public array $pages;

	public function __construct()
	{
		$this->pages = parse_ini_file(__DIR__."/pages.ini");
		parent::__construct();
	}

	public function selectPageData(): array
	{
		$pageData = $modalData = array();

		// Получение данных для выпадающего списка в модальном окне
		if (($_POST['add']) || ($_POST['edit']))
		{ $modalData = $this->modalData(); }

		// Получение данных для страницы
		switch ($_GET['page'])
		{
			case 'rating':      $pageData = $this->rating();                break;
			case 'estimates':   $pageData = $this->estimateList();          break;
			case 'groups':      $pageData = $this->groupList();             break;
			case 'students':    $pageData = $this->studentList();           break;
			case 'subjects':    $pageData = $this->subjectsList();          break;
			case 'groups_subjects': $pageData = $this->groups_subjects();   break;
		}

		return array($pageData, $modalData);
	}


	protected function subjectsList(): array
	{
		$result = array();

		$query = $this->select("*", "subjects");
		if (($query != null) && (mysqli_num_rows($query) > 0))
		{
			while ($arr = mysqli_fetch_assoc($query))
			{ $result[$arr['id']] = $arr; }
		}

		return $result;
	}


	protected function estimateList(): array
	{
		$result = array();

		// Получение списка оценок у студентов
		$query = $this->select("estimates.id as id, students.id as student_id, students.name as student, `groups`.name as group_name, subjects.id as subject_id, subjects.name as subject, estimates.grade", "estimates, students, `groups`, subjects","estimates.student_id = students.id AND estimates.subject_id = subjects.id AND students.group_id = `groups`.id");
		if (($query != null) && (mysqli_num_rows($query) > 0))
		{
			while ($arr = mysqli_fetch_assoc($query))
			{ $result[$arr['id']] = $arr; }
		}

		// Получение списка оценок у студентов без группы
		$query = $this->select("estimates.id as id, students.name as student, estimates.id as group_name, subjects.name as subject, estimates.grade", "estimates, students, subjects", "estimates.student_id = students.id AND estimates.subject_id = subjects.id AND students.group_id = 0");
		if (($query != null) && (mysqli_num_rows($query) > 0))
		{
			while ($arr = mysqli_fetch_assoc($query))
			{
				$result[$arr['id']] = $arr;
				$result[$arr['id']]['group_name'] = '-';
			}
			ksort($result);
		}

		return $result;
	}


	protected function groups_subjects(): array
	{
		$result = array();

		$query = $this->select("groups_subjects.id as id, `groups`.name as group_name, subjects.name as subject", "subjects, `groups`, groups_subjects", "groups_subjects.group_id = `groups`.id AND groups_subjects.subject_id = subjects.id");
		if (($query != null) && (mysqli_num_rows($query) > 0))
		{
			while ($arr = mysqli_fetch_assoc($query))
			{ $result[$arr['id']] = $arr; }
		}

		return $result;
	}


	protected function rating(): array
	{
		$pageData['groups'] = $this->groupList();

		if ($_POST['selected-group'])
		{
			$studentGrade = array();

			$pageData['subjects'] = $this->subjectsInGroup();
			$grades = $this->studentsInGroup();

			// Получение оценок
			$query = $this->select("estimates.id as id, students.id as student_id, students.name as student_name, subjects.id as subjects_id, estimates.grade", "subjects, estimates, students, groups_subjects","groups_subjects.group_id = '{$_POST['selected-group']}' AND students.group_id = '{$_POST['selected-group']}' AND estimates.student_id = students.id AND estimates.subject_id = subjects.id AND subjects.id = groups_subjects.subject_id");
			if (($query != null) && (mysqli_num_rows($query) > 0))
			{
				while ($arr = mysqli_fetch_assoc($query))
				{ $grades[$arr['id']] = $arr; }
			}

			// Парсинг результатов
			if ($pageData != null)
			{
				foreach ($grades as $key => $value)
				{
					$pageData['grade'][$value['student_id']]['student_name'] = $value['student_name'];

					if ($pageData['grade'][$value['student_id']][$value['subjects_id']] == '')
					{
						foreach ($pageData['subjects'] as $key2 => $value2)
						{ $pageData['grade'][$value['student_id']][$key2] = 0; }
					}

					if ($value['grade'] != null)
					{
						$pageData['grade'][$value['student_id']][$value['subjects_id']] = $value['grade'];
						$studentGrade[$value['student_id']] += $value['grade'];
					}
				}

				// Средний балл
				foreach ($studentGrade as $key => $value)
				{ $pageData['student-grade'][$key] = $pageData['grade'][$key]['student-grade'] = round(($value / count($pageData['subjects'])), "1"); }
				if ($pageData['student-grade'] != null) { arsort($pageData['student-grade']); }
			}
		}

		return $pageData;
	}


	protected function groupList(): array
	{
		$result = array();

		$query = $this->select("*", "`groups`");
		if (($query != null) && (mysqli_num_rows($query) > 0))
		{
			while ($arr = mysqli_fetch_assoc($query))
			{ $result[$arr['id']] = $arr; }
		}

		return $result;
	}


	protected function studentList(): array
	{
		$result = array();

		$query = $this->select("students.id as id, students.name as student, `groups`.name as group_name", "students, `groups`", "students.group_id = `groups`.id");
		if (($query != null) && (mysqli_num_rows($query) > 0))
		{
			while ($arr = mysqli_fetch_assoc($query))
			{ $result[$arr['id']] = $arr; }
		}

		$query = $this->select("id, name", "`students`","group_id = 0");
		if (($query != null) && (mysqli_num_rows($query) > 0))
		{
			while ($arr = mysqli_fetch_assoc($query))
			{
				$result[$arr['id']]['id'] = $arr['id'];
				$result[$arr['id']]['student'] = $arr['name'];
				$result[$arr['id']]['group_name'] = '-';
			}

			ksort($result);
		}

		return $result;
	}

	protected function studentsInGroup(): array
	{
		$result = array();

		$query = $this->select("students.id as id, students.name as name", "students", "students.group_id = '{$_POST['selected-group']}'");
		if (($query != null) && (mysqli_num_rows($query) > 0))
		{
			while ($arr = mysqli_fetch_assoc($query))
			{
				$result[$arr['id']]['student_id'] = $arr['id'];
				$result[$arr['id']]['student_name'] = $arr['name'];
			}
		}

		return $result;
	}


	protected function subjectsInGroup(): array
	{
		$result = array();

		$query = $this->select("subjects.id, subjects.name", "subjects, groups_subjects", "groups_subjects.subject_id = subjects.id AND groups_subjects.group_id = '{$_POST['selected-group']}'");
		if (($query != null) && (mysqli_num_rows($query) > 0))
		{
			while ($arr = mysqli_fetch_assoc($query))
			{ $result[$arr['id']] = $arr['name']; }
		}

		return $result;
	}

}