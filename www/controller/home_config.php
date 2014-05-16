<?php

$config_controller = array(
    'layout'=>"bootstrap",
    'title'=> "Домашняя страница",
    'description' => "Домашняя страница",
    'keywords' => "Домашняя страница",
    'actions'=>array(
        'index' => array('type' => "v"),
        'about' => array('type' => "v", 'title' => "О нас"),
        'services' => array('type' => "v", 'title' => "Наши сервисы"),
        'support' => array('type' => "v", 'title' => "Поддержка"),
        'contacts' => array('type' => "v", 'title' => "Контакты"),
        'sitemap' => array('type' => "v"),
        'error404' => array('type' => "v"),
    )
);

?>
