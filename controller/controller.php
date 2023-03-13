<?php
/**
 * Created by PhpStorm.
 * User: Konel
 * Date: 09.03.2023
 * Time: 16:06
 */

	// Главная страница
	if (!$_GET['page']) { $_GET['page'] = 'rating'; }

	require_once $_SERVER['DOCUMENT_ROOT']."/model/connection.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/model/crud.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/model/modal_data.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/model/main.php";

	$MODEL = new model;

	// Текущая страница
	$pages = $MODEL->pages;
	$currentPage[$_GET['page']] = 'active';

	// Добавление студента без группы
	if (($_POST['add-submit']) && ($_GET['page'] == 'students') && (!is_numeric($_POST['group_id'])))
	{ $_POST['group_id'] = 0; }

	// Вызов метода получения данных на странице
	list($pageData, $modalData) = $MODEL->selectPageData();

	// Вызов CRUD-методов
	if ($_POST['del']) { $MODEL->delData(); }
	elseif ($_POST['add-submit']) { $alarm = $MODEL->insertData(); }
	elseif ($_POST['edit-submit']) { $alarm = $MODEL->updateData(); }

	// Работа с модальным окном
	if ($_POST['add'] || $_POST['edit'])
	{
		if ($_POST['add'])
		{
			$modalTitle = 'Добавление записи';
			$modalBtn = 'Добавить';
		}
		elseif ($_POST['edit'])
		{
			$modalData['current'] = $pageData[key($_POST['edit'])];

			$modalTitle = 'Редактирование записи';
			$modalBtn = 'Изменить';
		}
	}
?>