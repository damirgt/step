<?php

$id = $this->values[id];
//echo $id;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$model = $_POST['name'];
	
	$cmd_str = "
	UPDATE sys_action 
	SET controller_id=:controller_id
		,code=:code
		,type_id=:type_id
		,title=:title
		,description=:description
		,keywords=:keywords
		,rights=:rights
		,layout=:layout 
                ,is_ml = 1
	WHERE id=:id
	";
	
        //print_r($model);
        
	$pc = $this->db_connect->prepare($cmd_str);
	
        $pc->bindValue(':id',$id,PDO::PARAM_INT);
	$pc->bindValue(':controller_id',$model['controller_id'],PDO::PARAM_INT);
	$pc->bindValue(':code',$model['code'], PDO::PARAM_STR);
	//$pc->bindValue(':name',$model['name'], PDO::PARAM_STR);
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
		$this->title='Измение новости. Проверьте поля.';			
		$this->view();
	}
}
else {
	/*$this->entities=new sys_action_Model();
	$this->entities->id = $id;
	$this->entities->first();
	*/
	//$this->title='Измение новости';			
	$this->view();
}
?>												