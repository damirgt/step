<?php
class FormUpdater_Library
{

    public $connect = null;
	//$object - обязательно должен быть инициализирован. Массив, где хранятся данные модели (или ссылка) object[type],object[description]
	//обязательно должен быть указань pk и любое другое поле.
	function run($formname)
	{
		try {
			$this->connect = Conn_Library::getConnect();
			
			$r = $this->connect->prepare('SELECT * FROM sys_form sf WHERE sf.name = :name');
			$r->bindValue(':name',$formname, PDO::PARAM_STR);
			$r->execute();
			if ($r->errorCode()!=0) {return $r->errorCode();}
			if ($row=$r->fetch(PDO::FETCH_ASSOC))
			{
				$form_id = $row['id'];
				$table_name = $row['table_name'];
			
				$r = $this->connect->prepare('SELECT * FROM sys_form_field WHERE sys_form_id = :sys_form_id AND type NOT IN ("submit")');
				$r->bindValue(':sys_form_id',$form_id, PDO::PARAM_INT);
				$r->execute();
				if ($r->errorCode()!=0) {return $r->errorCode();}
				for ($recordset=array(); $row=$r->fetch(PDO::FETCH_ASSOC); $recordset[]=$row);
				if (count($recordset) == 0) {return "Отсутствуют описания полей для формы '$formname'";}
				else {
					foreach($recordset AS $record) {
						if (isset($this->object[$record[field_name]])) {
							if ($record[type] == 'pk') {
								$cmd_pk = (isset($cmd_pk))?$cmd_pk.','.$record[field_name].'=:'.$record[field_name]:$record[field_name].'=:'.$record[field_name];
							} else {
								$cmd_set = (isset($cmd_set))?$cmd_set.','.$record[field_name].'=:'.$record[field_name]:$record[field_name].'=:'.$record[field_name];
							}
						}
					}
					if (!(isset($cmd_pk))) {return 'В процедуру не переданы первичные ключи';}
					if (!(isset($cmd_set))) {return 'В процедуру не передано не одно поле';}
					$cmd_str = "UPDATE $table_name SET $cmd_set WHERE $cmd_pk";
					
					$r = $this->connect->prepare($cmd_str);
					foreach ($recordset AS $record) {
						if (isset($this->object[$record[field_name]])) {
							$r->bindValue(':'.$record[field_name],htmlspecialchars($this->object[$record[field_name]]),$record[pdo_type]);
						}
					}
					$r->execute();
					if ($r->errorCode()!=0) {return $r->errorCode();}
				}
			}
			else
			{
				return "Форма '$formname' не найдена";
			}
		}
		catch(PDOException $e) {
			return "Error: ".$e->getMessage();
		}
		
		return '';
	}
}
?>
