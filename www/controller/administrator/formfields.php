<?php
	$this->ss_table = $this->sqlexecute('SELECT * FROM sys_form WHERE id = '.$this->values[id]);
	
	$this->ss_columns = $this->sqlexecute('SHOW COLUMNS FROM '.$this->ss_table[0][table_name]);
	
	$this->view();
?>
