<?php
/*
echo "<pre>";
print_r($_POST[name]);
echo "</pre>";
*/
$f = $_POST[name];

$field = $this->sqlexecute('SELECT * FROM sys_form_field WHERE sys_form_id=? AND field_name=?',array($this->values['id'],$_POST[name][field_name]));
if (count($field) == 0)
{
	$pc = $this->db_connect->prepare("INSERT INTO sys_form_field(sys_form_id, label,field_name,type,pdo_type,attributes,src_type,src,display,data,filter,empty,empty_text,empty_value) VALUES(:sys_form_id, :label,:field_name,:type,:pdo_type,:attributes,:src_type,:src,:display,:data,:filter,:empty,:empty_text,:empty_value)");
	$pc->bindValue(':sys_form_id',$this->values['id'],PDO::PARAM_INT);
	$pc->bindValue(':label',$f[label], PDO::PARAM_STR);
	$pc->bindValue(':field_name',$f[field_name], PDO::PARAM_STR);
	$pc->bindValue(':type',$f[type], PDO::PARAM_STR);
	$pc->bindValue(':pdo_type',$f[pdo_type], PDO::PARAM_INT);
	$pc->bindValue(':attributes',$f[attributes], PDO::PARAM_STR);
	$pc->bindValue(':src_type',$f[src_type], PDO::PARAM_STR);
	$pc->bindValue(':src',$f[src], PDO::PARAM_STR);
	$pc->bindValue(':display',$f[display], PDO::PARAM_STR);
	$pc->bindValue(':data',$f[data], PDO::PARAM_STR);
	$pc->bindValue(':filter',$f[filter], PDO::PARAM_STR);
	$pc->bindValue(':empty',(isset($f['empty']))?1:0, PDO::PARAM_INT);
	$pc->bindValue(':empty_text',$f[empty_text], PDO::PARAM_STR);
	$pc->bindValue(':empty_value',$f[empty_value], PDO::PARAM_STR);
	$pc->execute();
	/*
	echo '<pre>';
	print_r($pc->errorInfo());
	echo '</pre>';*/
}
else
{
	$pc = $this->db_connect->prepare("UPDATE sys_form_field SET sys_form_id=:sys_form_id, label=:label,field_name=:field_name,type=:type,pdo_type=:pdo_type,attributes=:attributes,src_type=:src_type,src=:src,display=:display,data=:data,filter=:filter,empty =:empty,empty_text=:empty_text,empty_value=:empty_value WHERE id=:id");
	$pc->bindValue(':id',$f[id],PDO::PARAM_INT);
	$pc->bindValue(':sys_form_id',$this->values['id'],PDO::PARAM_INT);
	$pc->bindValue(':label',$f[label], PDO::PARAM_STR);
	$pc->bindValue(':field_name',$f[field_name], PDO::PARAM_STR);
	$pc->bindValue(':type',$f[type], PDO::PARAM_STR);
	$pc->bindValue(':pdo_type',$f[pdo_type], PDO::PARAM_INT);
	$pc->bindValue(':attributes',htmlspecialchars($f[attributes]), PDO::PARAM_STR);
	$pc->bindValue(':src_type',$f[src_type], PDO::PARAM_STR);
	$pc->bindValue(':src',$f[src], PDO::PARAM_STR);
	$pc->bindValue(':display',$f[display], PDO::PARAM_STR);
	$pc->bindValue(':data',$f[data], PDO::PARAM_STR);
	$pc->bindValue(':filter',$f[filter], PDO::PARAM_STR);
	$pc->bindValue(':empty',(isset($f['empty']))?1:0, PDO::PARAM_INT);
	$pc->bindValue(':empty_text',$f[empty_text], PDO::PARAM_STR);
	$pc->bindValue(':empty_value',$f[empty_value], PDO::PARAM_STR);
	
	$pc->execute();
}

Header("Location: http://".$_SERVER["SERVER_NAME"]."/administrator/formfields/".$this->values['id']);
?>
