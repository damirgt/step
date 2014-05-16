<?php

use \system\basecontroller\basecontroller;
//из фронтконтролера вызывается класс с имененем controller и методом run()

class controller extends basecontroller {
    
    public $config_controller = array(
    'layout'=>"bootstrap",
    'title'=> "Домашняя страница",
    'description' => "Домашняя страница",
    'keywords' => "Домашняя страница",
    'actions'=>array(
        'index' => array('type' => "v"),
        'about' => array('type' => "v", 'title' => "О нас"),
        'create' => array('type' => "v"),
        'services' => array('type' => "v", 'title' => "Наши сервисы"),
        'support' => array('type' => "v", 'title' => "Поддержка"),
        'contacts' => array('type' => "v", 'title' => "Контакты"),
        'sitemap' => array('type' => "v"),
        'error404' => array('type' => "v", 'title' => "Нет такой страницы."),
        'details' => array('type' => "a")
        )
    );   
    
    //public $error_action = "about";


    //эту функцию можно не писать, по умолчанию вызовется функция родителя.
    public function run()
    {
        //echo "переопределенная функция";
        parent::run();
    }

}