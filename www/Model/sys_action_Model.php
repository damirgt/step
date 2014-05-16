<?php
//require_once("model/_base.php");

class sys_action_Model extends base_Model {
	
	//конфиг
	var $orm_object = "sys_action";
	var $orm_object_type = "table";
	
	//*********************************** overload vars ***************************************
	var $orm_pk = "id";
	//var $orm_allow_delete = false;
	//var $orm_sequence = "id DESC";
	
	//*********************************** overload methods ***************************************
	function select_by_controller_id()
	{
		try {
			$qs = $this->connect->prepare("SELECT * FROM sys_action WHERE controller_id=:controller_id");
			$qs->bindValue(':controller_id',$this->controller_id);
			$qs->execute();
			
			for ($this->orm_entity=array(); $row=$qs->fetch(PDO::FETCH_ASSOC); $this->orm_entity[]=$row);
		}
		catch(PDOException $e) {
			die("Error: ".$e->getMessage());
		}
	}
	
	//*********************************** Поля (объявление, валидация) ***************************************
	var $orm_fields = array(
		'id' => array(
			'primary_key' => true,
			'auto_increment' => true,
			'type' => 'SMALLINT(5) UNSIGNED',
		),
		'controller_id' => array(
			'required' => 'Обязателен для ввода',
			'type' => 'SMALLINT(5) UNSIGNED',
			'foreign_key' => 'sys_controller.id',
			'form' => array('label' => 'Контроллер',
							'type' => 'list',
							'attribute' => array ('name' => 'name[controller_id]','class' => 'validate[required]'),
							'dblist' => array ('table'=>'sys_controller', 'display'=>'name', 'value'=>'id'),
							'list' => array ('1'=>'Home', '2'=>'News', '3'=>'Users', '4'=>'Администратор')
							)
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
			//'required' => 'Обязателен для ввода',
			'type' => 'VARCHAR(255)',
			'form' => array('label' => 'Наименование',
							'type' => 'text',
							'attribute' => array ('name' => 'name[name]','cols' => '1', 'rows' => '1', 'class' => 'validate[required]')
							)
			
		),
		'description' => array(
			'type' => 'VARCHAR(255)',
			'form' => array('label' => 'Описание',
							'type' => 'text',
							'attribute' => array ('name' => 'name[description]','cols' => '1', 'rows' => '1')
							)
		),
		'type_id' => array(
			'required' => 'Обязателен для ввода',
			'type' => 'SMALLINT(5) UNSIGNED',
			'form' => array('label' => 'тип',
							'type' => 'list',
							'attribute' => array ('name' => 'name[type_id]', 'class' => 'validate[required]'),
							'list' => array('1'=>'Действие','3'=>'Представление в файле', '4'=> 'Представление в базе')
							)
		),
		'content' => array(
			'type' => 'TEXT',
			'form' => array('label' => 'Контент',
							'type' => 'textarea',
							'attribute' => array ('id' => 'code', 'name' => 'name[content]','cols' => '1', 'rows' => '1')
							)
		),
		'title' => array(
			'type' => 'VARCHAR(255)',
			'form' => array('label' => 'Title',
							'type' => 'text',
							'attribute' => array ('name' => 'name[title]','cols' => '1', 'rows' => '1')
							)
		),
		'keywords' => array(
			'type' => 'VARCHAR(255)',
			'form' => array('label' => 'Keywords',
							'type' => 'text',
							'attribute' => array ('name' => 'name[keywords]','cols' => '1', 'rows' => '1')
							)
		),
		'rights' => array(
			'type' => 'VARCHAR(255)',
			'form' => array('label' => 'rights',
							'type' => 'text',
							'attribute' => array ('name' => 'name[rights]','cols' => '1', 'rows' => '1')
							)
		),
		'layout' => array(
			'type' => 'VARCHAR(255)',
			'form' => array('label' => 'Шаблон',
							'type' => 'text',
							'attribute' => array ('name' => 'name[layout]','cols' => '1', 'rows' => '1')
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