<?php
if (isset($this->values[id])) {
	$this->sqlexecute('DELETE FROM sys_controller WHERE id = ?',array($this->values[id]));
}
$this->header('/administrator');
?>