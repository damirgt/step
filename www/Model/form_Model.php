<?php
class form_Model{
	function get_attr($object)
	{
		$attribute = "";
		foreach($object as $attr => $attrvalue)
			$attribute = $attribute.' '.$attr.'="'.$attrvalue.'"';
		return $attribute;
	}
	
	function run($id,$action,$method,$buttonValue)
	{
		echo '<form class="formular" id="'.$id.'" action="'.$action.'" method="'.$method.'">';
		echo "<fieldset>";
		
		foreach($this->obj->orm_fields  as $key => $object) {
			if (isset($object[form])) {
				
				echo '<div class="field">';
				echo '<label>'.$object[form][label].'</label>';	
				
				//ввод даты
				if ($object[form][type] == 'dateinput') {	
					$dt_elements = explode('-',$this->obj->$key);
					echo '<select name="'.$object[form][name1].'">';
						for($i=1;$i<=31;$i++) if ($i == $dt_elements[2])  echo "<option selected>$i"; else echo "<option>$i";
					echo '</select>';
					
					$strmonth = ARRAY(1=>'Январь',2=>'Февраль',3=>'Март',4=>'Апрель',5=>'Май',6=>'Июнь',7=>'Июль',8=>'Август',9=>'Сентябрь',10=>'Октябрь',11=>'Ноябрь',12=>'Декабрь');
					echo '<select name="'.$object[form][name2].'" value='.$dt_elements[0].'>';
						for($i=1;$i<=12;$i++) if ($i == $dt_elements[1])  echo "<option value=$i selected>$strmonth[$i]"; else echo "<option value=$i>$strmonth[$i]";
					echo "</select>";
					
					echo '<select name="'.$object[form][name3].'">';
						for($i=2005;$i<=2030;$i++) if ($i == $dt_elements[0])  echo "<option selected>$i"; else echo "<option>$i";
					echo "</select>";
					echo $this->obj->orm_fields [$key]['error'];
				}
				
				//текстовое поле
				if ($object[form][type] == 'text') {
					$attribute = $this->get_attr($object[form][attribute]);
					echo '<input type="text" '.$attribute.' value="'.$this->obj->$key.'">';
					echo $this->obj->orm_fields[$key]['error'];
				}
				
				//поле пароля
				if ($object[form][type] == 'password') {
					$attribute = $this->get_attr($object[form][attribute]);
					echo '<input type="password" '.$attribute.' value="'.$this->obj->$key.'">';
					echo $this->obj->orm_fields[$key]['error'];
				}
				
				//флажок
				if ($object[form][type] == 'checkbox') {
					$attribute = $this->get_attr($object[form][attribute]);
					echo '<input  type="checkbox" '.$attribute.'" value="ok">'.$this->obj->$key.'</input>';
					echo $this->obj->orm_fields[$key]['error'];
				}
				
				//большое текстовое поле
				if ($object[form][type] == 'textarea') {
					$attribute = $this->get_attr($object[form][attribute]);
					echo '<textarea '.$attribute.'>'.$this->obj->$key.'</textarea>';
					echo $this->obj->orm_fields[$key]['error'];
				}
				
				//скрытое поле
				if ($object[form][type] == 'hidden') {
					$attribute = $this->get_attr($object[form][attribute]);
					echo '<input type="hidden" '.$attribute.' value="'.$this->obj->$key.'">';
					echo $this->obj->orm_fields[$key]['error'];
				}
				
				//радиокнопка
				if  ($object[form][type] == 'radio') {
					$attribute = $this->get_attr($object[form][attribute]);
					foreach($object['form']['list'] AS $index => $item) {
						echo '<input type="radio" '.$attribute.' value="'.$index.'">'.$item;
					}
				}
				
				//список
				if  ($object[form][type] == 'list') {
					$attribute = $this->get_attr($object[form][attribute]);
					echo '<select "'.$attribute.'">';
					if (isset($object['form']['dblist']))
					{
						try {
							$r = $this->obj->connect->query("SELECT ".$object['form']['dblist']['display']." AS display, ".$object['form']['dblist']['value']." AS value  FROM ".$object['form']['dblist']['table']." ORDER BY ".$this->obj->orm_sequence);
							for (; $row=$r->fetch(PDO::FETCH_ASSOC); ) {
								$object['form']['list'][$row['value']]= $row['display'];
							}
						}
						catch(PDOException $e) {
							die("Error: ".$e->getMessage());
						}
					}
					
					if (isset($object['form']['dirlist']))
					{
						if ($object['form']['dirlist']['emptyitem']==true)
						$object['form']['list']['']= '';
						
						
						$dir = opendir ("templates");
						while ($file = readdir ($dir)) 
						{
							if (( $file != ".") && ($file != ".."))
							{
								$object['form']['list'][$file]= $file;	
							}
							
						}
						closedir ($dir);
					}
					
					foreach($object['form']['list'] AS $index => $item) {
						if ($this->obj->$key == $index) 
							echo '<option selected value="'.$index.'">'.$item.'</option>';
						else 
							echo '<option value="'.$index.'">'.$item.'</option>';
					}	
					echo '</select>';
				}
				
				//список из флажков
				if  ($object[form][type] == 'checkboxlist') {
					$attribute = $this->get_attr($object[form][attribute]);
					foreach($object['form']['list'] AS $index => $item) {
						echo '<input type="checkbox" "'.$attribute.'"  value="'.$index.'">'.$item;
					}
				}
				
				echo '</div>';
			}
		}
		
		echo '<div class="field"><label></label><input type="submit" value="'.$buttonValue.'" /></div>';
		echo "</fieldset>";
		echo "</form>";
	}
}
?>