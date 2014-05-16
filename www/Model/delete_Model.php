<?php
class delete_Model
{
	function run()
	{
		$pk = $this->obj->orm_pk;
		if ($this->obj->orm_allow_delete) {
			$qs = $this->obj->connect->prepare("DELETE FROM ".$this->obj->orm_object." WHERE $pk=:$pk");
			$data[$pk] = $this->obj->$pk;
			$qs->execute($data);
		}
	}
}
?>