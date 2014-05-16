<?php

$id = $this->values['id'];
$this->model = new news_Model();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = HtmlSpecialChars($_REQUEST['name']['id']);
    $date = HtmlSpecialChars($_REQUEST['name']['date']);
    $name = HtmlSpecialChars($_REQUEST['name']['name']);

    //$this->model = array('id' => $id, 'date' => $date, 'name' => $name);
    $this->model->orm_data = array('id' => $id, 'date' => $date, 'name' => $name);

    $this->model->update();
    
    //$model->orm_data = $this->model;

    if ($this->model->save()) {
        $this->header("/news/details/" . $id);
    } else {
        $this->title = 'Измение новости. Проверьте поля.';
        $this->view();
    }
} else {
    $this->model->orm_data = $this->sqlexecute('SELECT * FROM news WHERE id = ? LIMIT 1', array($id), 1);

    $this->title = 'Измение новости';
    $this->view();
}
?>																										