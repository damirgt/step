<?php
namespace system\basecontroller;

use system\routing\routing;

abstract class basecontroller {

    public $config_controller = array();
    public $controller_catalog = "";

    public $error_action = "error404";  
    
    public function run() {
        $this->controller_catalog = $_SERVER['DOCUMENT_ROOT'] . '/module/' . routing::$controller;

        echo "<hr>";
        echo "Вызов контроллера: " . routing::$controller;
        echo "<br>";
        echo "Действие: " . routing::$action;
        echo "<br>";
        echo "Каталог: " . $this->controller_catalog;

        if (!isset($this->config_controller['actions'][routing::$action])) {
            routing::$action = $this->error_action;
        }
        
        $config_action = array_merge((array) $this->config_controller, (array) $this->config_controller['actions'][strtolower(routing::$action)]);

        $this->title = $config_action["title"];
        $this->description = $config_action["description"];
        $this->keywords = $config_action["keywords"];
        $this->layout = $config_action["layout"];

        if ($config_action['type'] === "a") {
            include $this->controller_catalog . "/controller/" . routing::$action . ".php";
        }

        if ($config_action['type'] === "v") {
            $this->view();
        }
    }

    public function view() {

        /* $layout_file = "templates/" . $this->layout . "/compile/index." . Core::$language . ".php";
          if (!is_file($layout_file)) {
          $layout_file = "templates/" . $this->layout . "/compile/index.php";
          } */

        $layout_file = $this->controller_catalog . "/layout/layout.php";

        //$content = (func_num_args() == 0) ? $this->action : func_get_arg(0);
        //$content_file_ml = "view/" . $this->controller . "/$content." . Core::$language . ".php";
        //$this->content = (is_file($content_file_ml)) ? $content_file_ml : 'view/' . $this->controller . '/' . $content . '.php';
        //$this->content = strtolower($this->content);

        $this->content_file = $this->controller_catalog . "/controller/view/" . routing::$action . "/d." . routing::$action . ".php";
        ;

        include($layout_file);
    }
}