<?php

$this->model = new projects_Model();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = Auth_Library::$user['id'];
    $name = HtmlSpecialChars($_REQUEST['name']['name']);

    $this->model->orm_data = array('user_id' => $user_id, 'name' => $name);

    $this->model->insert();

    if ($this->model->save()) {
        $this->header('/user');
    } else {
        $this->title = 'Добавление проекта. Проверьте поля.';
        $this->view();
    }
} else {
    //$this->model->orm_data  = array('date' => date('Y-m-d'));
    $this->title = 'Добавление проекта';
    $this->view();
}
?>