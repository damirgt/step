<?php

$id = $_SESSION['id'];

//обнуляем поле online, говорящее, что пользователь вышел с сайта (пригодится в будущем) 	

$this->model = new users_Model();
$this->model->orm_data = array(
    'id' => $id,
    'online' => 0
);

//$model = new users_Model();
//$model->orm_data = $this->model;
$this->model->update();

if ($this->model->save()) {

    unset($_SESSION['id']); //удаляем переменную сессии
    //session_destroy();
    SetCookie("login", "", 0, "/"); //удаляем cookie с логином 	
    SetCookie("password", "", 0, "/"); //удаляем cookie с паролем  	
    SetCookie(session_name(), "", 0, "/");

    Auth_Library::$user = null;

    $this->header();
} else {
    echo "Ошибка";
}
?>
												