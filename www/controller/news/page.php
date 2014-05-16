<?php

$this->i = $this->values[id];
$this->sph = new selectpageable_helper();
$this->recordset = $this->sph->run('*', 'news', 'ORDER BY id DESC', $this->i, 6);
$this->bodyid = page1;
$this->view('index');
?>