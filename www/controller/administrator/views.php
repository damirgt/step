<?php
$this->entities = new sys_view_Model();
$this->entities->sys_action_id = $this->routing->values[id];
$this->entities->select_by_action_id();
$this->view();
?>
