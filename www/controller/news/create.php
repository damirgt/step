<?php

$this->model = new news_Model();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $date = HtmlSpecialChars($_REQUEST['name']['date']);
    $name = HtmlSpecialChars($_REQUEST['name']['name']);

    $this->model->orm_data = array('date' => $date, 'name' => $name);
    
    if (!( session_id() )) session_start();
    
    if (isset($_SESSION['captcha_keystring']) && $_SESSION['captcha_keystring'] === $_POST['name']['keystring']) {
        unset($_SESSION['captcha_keystring']);
        $this->model->insert();

        if ($this->model->save()) {
            $this->header('/news');
        } else {
            $this->title = 'Добавление новости. Проверьте поля.';
            $this->view();
        }
    } else {
        $this->model->orm_validate['keystring'] = 'Неправильно введена фраза';
        $this->title = 'Добавление новости. Проверьте поля.';
        $this->view();
    }
} else {
    $this->model->orm_data = array('date' => date('Y-m-d'));
    $this->title = 'Добавление новости';
    $this->view();
}
?>