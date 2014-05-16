<?php
if ($_SERVER['REQUEST_METHOD']=='POST') {	
	$this->entities=new sys_view_Model();

	$this->entities->dataToObject($_REQUEST['name']);
	
	if ($this->entities->insert()) {
		Header("Location: http://".$_SERVER["SERVER_NAME"]."/administrator/views/".$this->entities->sys_action_id);
		exit();
	}
	else {
		$this->title='Добавление действия. Проверьте поля.';
		$this->entities->select_by_action_id();

		$this->view();
	}
}
else {
	Header("Location: http://".$_SERVER["SERVER_NAME"]."/administrator");
}
?>
