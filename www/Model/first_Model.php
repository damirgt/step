<?php
class first_Model
{
	function run()
	{
		try {
			$pk = $this->obj->orm_pk;
			$qs = $this->obj->connect->prepare("SELECT * FROM ".$this->obj->orm_object." WHERE $pk=:id");
			$qs->bindValue(':id',$this->obj->$pk);
			$qs->execute();
			if ($row = $qs->fetch()) {
				
				foreach($row as $key => $item) {
					$this->obj->$key = $item;
				}
		
				$this->obj->orm_entity=array();
				$this->obj->orm_entity[] = $row;
				
				return true;
			}
			else {
				return false;
			}
		}
		catch(PDOException $e) {
			die("Error: ".$e->getMessage());
		}
	}
}
?>