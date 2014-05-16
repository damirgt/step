<?php
if ($_SERVER['REQUEST_METHOD']=='POST') {	
	$code = $_POST[code];
	
	$sys_action = $this->sqlexecute('SELECT a.code as action_code,c.code as controller_code,c.id as controller_id FROM sys_action a INNER JOIN sys_controller c ON c.id = a.controller_id WHERE a.id = ?',array($this->values[id]),1);

	$file = 'controller/'.$sys_action[controller_code].'/'.$sys_action['action_code'].'.php';

	$fp = fopen($file, 'w');
	$flag = fwrite($fp,html_entity_decode($code));
	fclose($fp);
	$this->header('/administrator/actions/'.$sys_action['controller_id']);
}
else {
	$this->view();
}
?>
		