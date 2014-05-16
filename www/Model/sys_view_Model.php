<?php
//require_once("model/_base.php");

class sys_view_Model extends base_Model {
	
	//конфиг
	var $orm_object = "sys_view";
	var $orm_object_type = "table";
	
	//*********************************** overload vars ***************************************
	var $orm_pk = "id";
	//var $orm_allow_delete = false;
	//var $orm_sequence = "id DESC";
	
	//*********************************** overload methods ***************************************
	function select_by_action_id()
	{
		try {
			$qs = $this->connect->prepare("SELECT * FROM sys_view WHERE sys_action_id=:sys_action_id");
			$qs->bindValue(':sys_action_id',$this->sys_action_id);
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
		'sys_action_id' => array(
			'required' => 'Обязателен для ввода',
			'type' => 'SMALLINT(5) UNSIGNED',
			'foreign_key' => 'sys_action.id',
			'form' => array('label' => 'Действие',
							'type' => 'list',
							'attribute' => array ('name' => 'name[sys_action_id]','class' => 'validate[required]'),
							'dblist' => array ('table'=>'sys_action', 'display'=>'code', 'value'=>'id'),
							//'list' => array ('1'=>'Home', '2'=>'News', '3'=>'Users', '4'=>'Администратор')
							)
		),
		'lang' => array(
			'required' => 'Обязателен для ввода',
			'type' => 'VARCHAR(2)',
			'form' => array('label' => 'язык',
							'type' => 'list',
							'attribute' => array ('name' => 'name[lang]', 'class' => 'validate[required]'),
							'list' => array('ru'=>'Русский','en'=>'English')
							)
		),
		
		'content' => array(
			'required' => 'Обязателен для ввода',
			'type' => 'text',
			'form' => array('label' => 'Контент',
							'type' => 'textarea',
							'attribute' => array ('name' => 'name[content]','cols' => '1', 'rows' => '1', 'class' => 'validate[required]')
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
		'description' => array(
			'type' => 'VARCHAR(255)',
			'form' => array('label' => 'description',
							'type' => 'text',
							'attribute' => array ('name' => 'name[description]','cols' => '1', 'rows' => '1')
							)
		),
		'layout' => array(
			'type' => 'VARCHAR(255)',
			'form' => array('label' => 'Шаблон',
							'type' => 'text',
							'attribute' => array ('name' => 'name[layout]','cols' => '1', 'rows' => '1')
							)	
		)
	);
	//*******************************************************************************************
}
?>