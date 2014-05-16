<?php
//require_once("model/_base.php");

class sys_form_Model extends base_Model {
	
	//конфиг
	var $orm_object = "sys_form";
	var $orm_object_type = "table";
	
	//*********************************** overload vars ***************************************
	var $orm_pk = "id";
	//var $orm_allow_delete = false;
	//var $orm_sequence = "id DESC";
	
	//*********************************** Поля (объявление, валидация) ***************************************
	var $orm_fields = array(
		'id' => array(
			'primary_key' => true,
			'auto_increment' => true,
			'type' => 'SMALLINT(5) UNSIGNED',
		),
		'table_name' => array(
			'required' => 'обязателен для ввода',
			'form' => array('label' => 'Наименование таблицы',
							'type' => 'text',
							'attribute' => array ('name' => 'name[table_name]','cols' => '1', 'rows' => '1')
							)
		),
		'name' => array(
			'required' => 'обязателен для ввода',
			'form' => array('label' => 'Наименование формы',
							'type' => 'text',
							'attribute' => array ('name' => 'name[name]','cols' => '1', 'rows' => '1')
							)
		),
		'template' => array(
			'required' => 'обязателен для ввода',
			'form' => array('label' => 'Шаблон',
							'type' => 'text',
							'attribute' => array ('name' => 'name[template]','cols' => '1', 'rows' => '1')
							)
		)
		
	);
	//*******************************************************************************************
}
?>