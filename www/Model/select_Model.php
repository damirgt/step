<?php
class select_Model
{
	function run()
	{
		try {
				$r = $this->obj->connect->query("SELECT * FROM ".$this->obj->orm_object." ORDER BY ".$this->obj->orm_sequence);
				for ($this->obj->orm_entity=array(); $row=$r->fetch(PDO::FETCH_ASSOC); $this->obj->orm_entity[]=$row);
		}
		catch(PDOException $e) {
			die("Error: ".$e->getMessage());
		}
		
		return $this->obj->orm_entity;
	}
}
?>