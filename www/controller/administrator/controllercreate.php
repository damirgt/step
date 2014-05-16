<?php
if ($_SERVER['REQUEST_METHOD']=='POST') {	
	$model = $_POST['name'];

	if (trim($model[code]) == '') {
		$this->header("/administrator");exit;
	}
	
	$q = $this->sqlexecute('SELECT * FROM sys_controller WHERE code = ?',array($model[code]));
	if (count($q) != 0) {
		$this->header("/administrator");exit;
	}
	
	$r = $this->db_connect->prepare('INSERT INTO sys_controller(code,description,layout) VALUES(:code,:description,:layout)');
	$r->bindValue(':code',$model['code'], PDO::PARAM_STR);
	$r->bindValue(':description',$model['description'], PDO::PARAM_STR);
	$r->bindValue(':layout',$model['layout'], PDO::PARAM_STR);
	$r->execute();
	
	$this->header("/administrator");
}
else {
	$this->header("/administrator");
}
?>																				