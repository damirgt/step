<?php

$this->sqlexecute('DELETE FROM news WHERE id = ?', array($this->values['id']));
$this->header("/news");
?>		