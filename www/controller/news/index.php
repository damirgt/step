<?php

$this->is_pageable = 1;

if ($this->is_pageable === 1) {
    $this->i = 1;
    $this->sph = new selectpageable_helper();
    $this->recordset = $this->sph->run('*', 'news', 'ORDER BY id DESC', $this->i, 6);
    $this->view();
} else {
    $this->recordset = $this->sqlexecute('SELECT * FROM news ORDER BY ID DESC');
    $this->view();
}
?>
																														