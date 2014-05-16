<?php
if ($_SERVER['REQUEST_METHOD']=='POST') {	

	$this->model = $_POST['name'];
	
	$q = $this->sqlexecute('SELECT * FROM sys_form WHERE name = ?',array($this->model['name']));
	if (count($q) != 0) {
		Header("Location: http://".$_SERVER["SERVER_NAME"]."/administrator/forms");
		exit();
	}
	
	$r = $this->db_connect->prepare('INSERT INTO sys_form(name,table_name) VALUES(:name,:table_name)');
	$r->bindValue(':name',$this->model['name'], PDO::PARAM_STR);
	$r->bindValue(':table_name',$this->model['table_name'], PDO::PARAM_STR);
	$r->execute();
	
	if ($r->errorcode() == 0) {
		Header("Location: http://".$_SERVER["SERVER_NAME"]."/administrator/forms");
		exit();
	}
	else {
		$this->title='Добавление формы. Проверьте поля.';
		$this->view('forms');
	}
}
else {
	Header("Location: http://".$_SERVER["SERVER_NAME"]."/administrator/forms");
}
?>
						