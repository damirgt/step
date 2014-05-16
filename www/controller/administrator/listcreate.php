<?php
if ($_SERVER['REQUEST_METHOD']=='POST') {	
	/*$this->entities=new sys_list_Model();

	$this->entities->dataToObject($_REQUEST['name']);
	$this->entities->parent_id = $this->routing->values[id];
	$this->entities->sequence = $this->entities->select_maxid_parentid($this->routing->values[id]) + 1;
	*/
	$model = $_POST['name'];
	
	$seqQ = $this->sqlexecute('SELECT ISNULL(MAX(sequence),0)+1 AS sm FROM sys_list WHERE parent_id = ?', array($model['parent_id']),1);
	$sequence = $seqQ['sm'];

	$r = $this->db_connect->prepare('INSERT INTO sys_list(parent_id,sequence,code,display,value) VALUES(:parent_id,:sequence,:code,:display,:value)');
	$r->bindValue(':parent_id',$model['parent_id'], PDO::PARAM_INT);
	$r->bindValue(':sequence',$sequence, PDO::PARAM_INT);
	$r->bindValue(':code',$model['code'], PDO::PARAM_STR);
	$r->bindValue(':display',$model['display'], PDO::PARAM_STR);
	$r->bindValue(':value',$model['value'], PDO::PARAM_STR);
	$r->execute();
		
	if ($r->errorcode() ==0) {
		Header("Location: http://".$_SERVER["SERVER_NAME"]."/administrator/list/".$model['parent_id']);
		exit();
	}
	else {
		$this->title='Добавление. Проверьте поля.';			
		$this->view();
	}
}
else {
	Header("Location: http://".$_SERVER["SERVER_NAME"]."/administrator");
}
?>				