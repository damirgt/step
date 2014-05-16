<?php
	$res = $this->SQLexecute('SELECT controller_id FROM sys_action WHERE id=?',array($this->values['id']),1);
	$this->SQLexecute('DELETE FROM sys_action_ml WHERE id=?',array($this->values['id']));
	$this->SQLexecute('DELETE FROM sys_action WHERE id=?',array($this->values['id']));
	$this->header('/administrator/actions/'.$res['controller_id']);
?>