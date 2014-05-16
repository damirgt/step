<?php
if ($_SERVER['REQUEST_METHOD']=='POST') {	
	$controller_id = $_POST[name][controller_id];
	$type_id = $_POST[name][type_id];
	$filename = $_POST[name][filename];
	$code = $_POST[name][code];
	
	$controller = $this->SQLexecute('SELECT code FROM sys_controller WHERE id = ?',array($controller_id),1);
	//echo $controller[code];
	
	$this->retval_mas = array();
	
	if ($type_id == 1)
		$file = 'controller/'.$controller[code].'/'.$filename.'.php';
	else
		$file = 'view/'.$controller[code].'/'.$filename.'.php';
		
	if (is_file($file)) {
		echo "Файл $file уже существует!";
	} else {	
		$fp = fopen($file, 'w');
		$flag = fwrite($fp,$code);
		fclose($fp);
		$this->header('/administrator/actions/'.$controller_id);
	}
	
}
else {
	Header("Location: http://".$_SERVER["SERVER_NAME"]."/administrator");
}
?>
