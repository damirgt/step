<?php
class FormMaker_Library
{

    public $connect = null;
	//$object - массив, где хранятся данные модели (или ссылка) object[type],object[description]
	
	function run($formname,$action)
	{
		try {
			$this->connect = Conn_Library::getConnect();
			
			$r = $this->connect->prepare('SELECT * FROM sys_form sf WHERE sf.name = :name');
			$r->bindValue(':name',$formname, PDO::PARAM_STR);
			$r->execute();	
			if ($row=$r->fetch(PDO::FETCH_ASSOC))
			{
				$form_id = $row['id'];
				$table_name = $row['id'];
				$name = $row['name'];
				$template = $row['template'];
				$attr_class = $row['attr_class'];
				$attr_id = $row['attr_id'];
				$attr_action = $row['attr_action'];
				$attr_method = $row['attr_method'];
			
				$r = $this->connect->prepare('SELECT * FROM sys_form_field WHERE sys_form_id = :sys_form_id AND type NOT IN ("submit")');
				$r->bindValue(':sys_form_id',$form_id, PDO::PARAM_INT);
				$r->execute();
				for ($recordset=array(); $row=$r->fetch(PDO::FETCH_ASSOC); $recordset[]=$row);
				if (count($recordset) == 0) {echo "Отсутствуют описания полей для формы '$formname'";}
				else {
					/*foreach($recordset AS $record) {
						echo '<pre>';
						print_r($record);
						echo '</pre>';
					}*/
				}
			}
			else
			{
				echo "Форма '$formname' не найдена";
			}
		}
		catch(PDOException $e) {
			die("Error: ".$e->getMessage());
		}
		
		if (count($recordset) != 0) {
			echo '<form class="'.$attr_class.'" id="'.$attr_id.'" action="'.$action.'" method="'.$attr_method.'">';
			echo "<fieldset>";
			foreach($recordset AS $record) {
				
				$list=array();
				if ($record['src_type']=='seltab')
				{
					if ($record['empty']) {
						$list[$record[empty_value]]=$record[empty_text];
					}
					if (strlen($record[filter])!=0) {
						$where = ' where '.$record[filter];
					}
					else {
						$where = '';
					}
					$r = $this->connect->query("SELECT ".$record[display]." AS display, ".$record['data']." AS value FROM ".$record['src'].$where);
					for (;$row=$r->fetch(PDO::FETCH_ASSOC); ) {
						$list[$row[value]]=$row[display];
					}
				}
				
				if ($record['src_type'] == 'freesel')
				{
					$exparr = explode(';',$record['src']);
					foreach($exparr AS $item) {
						$arr1=array();
						$expitem = explode(':',$item);
						if (count($expitem) == 2) $list[$expitem[0]] = $expitem[1]; else $list[$expitem[0]] = $expitem[0];
					}
					//$list = $arr1;
				}				
				
				echo '<div class="field">';
				echo '<label>'.$record[label].'</label>';
				
				if ($record[type] == 'select') {
					echo '<select name="name['.$record[field_name].']" '.htmlspecialchars_decode($record[attributes]).'>';
					foreach($list as $key=>$item) {
						if ($key == $this->object[$record[field_name]])
							echo '<option value="'.$key.'" selected>'.$item.'</option>';
						else
							echo '<option value="'.$key.'">'.$item.'</option>';
					}
					echo '</select>';
				}
				
				if (($record[type] == 'hidden') || ($record[type] == 'pk')) {
					echo '<input type="hidden" name="name['.$record[field_name].']" '.htmlspecialchars_decode($record[attributes]).' value="'.$this->object[$record[field_name]].'">';
					//echo $this->obj->orm_fields[$key]['error'];
				}
				
				if ($record[type] == 'radio') {
					foreach($list as $key=>$item) {
						if ($key == $this->object[$record[field_name]])
							echo '<input type="radio" name="name['.$record[field_name].']" '.htmlspecialchars_decode($record[attributes]).' value="'.$key.'" checked>'.$item;
						else
							echo '<input type="radio" name="'.$record[field_name].'" '.htmlspecialchars_decode($record[attributes]).' value="'.$key.'">'.$item;
					}
				}
				
				if ($record[type] == 'checkbox') {
					echo '<input type="checkbox" name="name['.$record[field_name].']" '.htmlspecialchars_decode($record[attributes]).' checked>';// value="'.$this->obj->$key.'">';
				}
				
				if ($record[type] == 'text') {
					echo '<input type="text" name="name['.$record[field_name].']" '.htmlspecialchars_decode($record[attributes]).' value="'.$this->object[$record[field_name]].'">';
					//echo $this->obj->orm_fields[$key]['error'];
				}
				
				if ($record[type] == 'password') {
					echo '<input type="password" name="name['.$record[field_name].']" '.htmlspecialchars_decode($record[attributes]).'>';
					//echo $this->obj->orm_fields[$key]['error'];
				}
				
				if ($record[type] == 'textarea') {
					echo '<textarea name="name['.$record[field_name].']" '.htmlspecialchars_decode($record[attributes]).'>'.$this->object[$record[field_name]].'</textarea>';
				}

				echo '</div>';
			}
			
			$r = $this->connect->prepare('SELECT * FROM sys_form_field WHERE sys_form_id = :sys_form_id AND type = "submit"');
			$r->bindValue(':sys_form_id',$form_id, PDO::PARAM_INT);
			$r->execute();
			if ($row=$r->fetch(PDO::FETCH_ASSOC))
				echo '<div class="field"><label></label><input type="submit" value="'.$row[label].'" /></div>';
			echo "</fieldset>";
			echo "</form>";
		}
	}
}
?>
