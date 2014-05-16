<?php
$this->entities = new sys_action_Model();
$this->entities->controller_id = $this->values[id];
$this->entities->select_by_controller_id();
$this->view();
?>
