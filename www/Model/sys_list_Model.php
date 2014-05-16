<?php
//require_once("model/_base.php");

class sys_list_Model extends base_Model {
	
	//конфиг
	var $orm_object = "sys_list";
	var $orm_object_type = "table";
	
	//*********************************** overload vars ***************************************
	var $orm_pk = "id";
	//var $orm_allow_delete = false;
	//var $orm_sequence = "id DESC";
	
	//*********************************** overload methods ***************************************
	function select_by_parentid($parentid)
	{
		try {
				$r = $this->connect->query("SELECT * FROM sys_list WHERE parent_id = $parentid ORDER BY sequence");
				for ($this->orm_entity=array(); $row=$r->fetch(PDO::FETCH_ASSOC); $this->orm_entity[]=$row);
		}
		catch(PDOException $e) {
			die("Error: ".$e->getMessage());
		}
		
		return $this->orm_entity;
	}
	
	function select_maxid_parentid($parentid)
	{
		try {
			$pk = $this->orm_pk;
			$qs = $this->connect->prepare("SELECT MAX(sequence) AS maxsequence FROM sys_list WHERE parent_id = $parentid");
			$qs->execute();
			if ($row = $qs->fetch()) {
				return $row[maxsequence];
			}
			else {
				return -1;
			}
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
		'parent_id' => array(
			'type' => 'SMALLINT(5) UNSIGNED'
		),
		'code' => array(
			'type' => 'VARCHAR(20)',
			'form' => array('label' => 'Код',
							'type' => 'text',
							'attribute' => array ('name' => 'name[code]','cols' => '1', 'rows' => '1', 'class' => 'validate[required]')
							)
		),
		'display' => array(
			'type' => 'VARCHAR(255)',
			'form' => array('label' => 'Наименование',
							'type' => 'text',
							'attribute' => array ('name' => 'name[display]','cols' => '1', 'rows' => '1', 'class' => 'validate[required]')
							)
		),
		'value' => array(
			'type' => 'VARCHAR(255)',
			'form' => array('label' => 'Значение',
							'type' => 'text',
							'attribute' => array ('name' => 'name[value]','cols' => '1', 'rows' => '1', 'class' => 'validate[required]')
							)
		),
		'sequence' => array(
			'type' => 'SMALLINT(5) UNSIGNED'		
		),
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