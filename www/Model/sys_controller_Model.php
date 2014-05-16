<?php
//require_once("model/_base.php");

class sys_controller_Model extends base_Model {
	
	//конфиг
	var $orm_object = "sys_controller";
	var $orm_object_type = "table";
	
	//*********************************** overload vars ***************************************
	var $orm_pk = "id";
	//var $orm_allow_delete = false;
	//var $orm_sequence = "id DESC";
	
	//*********************************** overload methods ***************************************
	function select1()
	{
		try {
				$r = $this->connect->query("SELECT * FROM $this->orm_object ORDER BY id DESC LIMIT 0,3");
				for ($this->orm_entity=array(); $row=$r->fetch(PDO::FETCH_ASSOC); $this->orm_entity[]=$row);
		}
		catch(PDOException $e) {
			die("Error: ".$e->getMessage());
		}
		
		return $this->orm_entity;
	}
	
	//*********************************** Поля (объявление, валидация) ***************************************
	var $orm_fields = array(
		'id' => array(
			'primary_key' => true,
			'auto_increment' => true,
			'type' => 'SMALLINT(5) UNSIGNED',
		),
		'code' => array(
			'required' => 'Обязателен для ввода',
			'type' => 'VARCHAR(50)',
			'form' => array('label' => 'Код',
							'type' => 'text',
							'attribute' => array ('name' => 'name[code]','cols' => '1', 'rows' => '1', 'class' => 'validate[required]')
							)
			
		),
		'name' => array(
			'required' => 'Обязателен для ввода',
			'type' => 'VARCHAR(255)',
			'form' => array('label' => 'Наименование',
							'type' => 'text',
							'attribute' => array ('name' => 'name[name]','cols' => '1', 'rows' => '1', 'class' => 'validate[required]')
							)
			
		),
		'description' => array(
			'required' => 'Обязателен для ввода',
			'type' => 'VARCHAR(255)',
			'form' => array('label' => 'Описание',
							'type' => 'textarea',
							'attribute' => array ('name' => 'name[description]','cols' => '1', 'rows' => '1', 'class' => 'validate[required]')
							)
		),
		'layout' => array(
			'required' => 'Обязателен для ввода',
			'type' => 'VARCHAR(255)',
			'form' => array('label' => 'Шаблон',
							'type' => 'list',
							'attribute' => array ('name' => 'name[layout]', 'class' => 'validate[required]'),
							'dirlist' => array('dir'=> 'templates', 'emptyitem' => false)
							)
			
		)
		/*,
		'variants' => array(
			'label' => 'Варианты ответов',
			'type' => 'radio',
			'form' => array('label' => 'Варианты ответов', 'type' => 'checkboxlist', 'name' => 'rado', 'list' => array('red'=>'Красный','green'=>'Зеленый','yellow'=>'Желтый'))
		)*/
	);
	//*******************************************************************************************
}
?>