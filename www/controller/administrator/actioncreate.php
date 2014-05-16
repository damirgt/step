<?php
if ($_SERVER['REQUEST_METHOD']=='POST') {	
	/*$this->entities=new sys_action_Model();
	$this->entities->dataToObject($_REQUEST['name']);
	*/
	
	
	$model = $_POST['name'];
	$pc = $this->db_connect->prepare("INSERT INTO sys_action(controller_id, code,type_id,title,description,keywords,rights,layout) VALUES(:controller_id, :code,:type_id,:title,:description,:keywords,:rights,:layout)");
	$pc->bindValue(':controller_id',$model['controller_id'],PDO::PARAM_INT);
	$pc->bindValue(':code',$model['code'], PDO::PARAM_STR);
	$pc->bindValue(':type_id',$model['type_id'], PDO::PARAM_INT);
	$pc->bindValue(':title',$model['title'], PDO::PARAM_STR);
	$pc->bindValue(':description',$model['description'], PDO::PARAM_STR);
	$pc->bindValue(':keywords',$model['keywords'], PDO::PARAM_STR);
	$pc->bindValue(':rights',$model['rights'], PDO::PARAM_STR);
	$pc->bindValue(':layout',$model['layout'], PDO::PARAM_STR);
	$pc->execute();
	
	if ($pc->errorcode() == 0) {
		Header("Location: http://".$_SERVER["SERVER_NAME"]."/administrator/actions/".$model['controller_id']);
		exit();
	}
	else {
		$this->title='Добавление действия. Проверьте поля.';
		//$this->entities->select_by_controller_id();

		$this->view('actions');
	}
}
else {
	Header("Location: http://".$_SERVER["SERVER_NAME"]."/administrator");
}
?>
																						