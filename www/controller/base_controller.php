<?php

class base_Controller {

    private $controller = "";
    private $action = "";
    private $values = array();
    private $content = ""; //вызывается в layout файле
    public $sys_action = array();
    public $sys_action_ml = array();

    public $buf = array();//временное хранилище
    
    public $retval_mas = array(); //временно, для administrator/templatesedit
    
    function run() {
        if (func_num_args() === 0) {
            $this->controller = strtolower(Core::$controller);
            $this->action = strtolower(Core::$action);
            $this->values = Core::$values;
        } else {
            $this->controller = func_get_arg(0);
            $this->action = func_get_arg(1);
            $this->values = func_get_arg(2);
        }

        $config_controller_file = strtolower("controller/" . $this->controller . "_config.php");
		
        if (is_file($config_controller_file))
            include $config_controller_file;
        else {
            $this->run("home", "error404", "");
            return;
        }

        if (!isset($config_controller['actions'][strtolower($this->action)])) {
            $this->action = "error404";
        }

        $config_action = array_merge((array) $config_controller, (array) $config_controller['actions'][strtolower($this->action)]);

        $this->title = $config_action["title"];
        $this->description = $config_action["description"];
        $this->keywords = $config_action["keywords"];
        $this->layout = $config_action["layout"];

        if ($config_action['type'] === "a") {
            include $this->controller . "/" . $this->action . ".php";
        }

        if ($config_action['type'] === "v") {
            $this->view();
        }
    }

    public function view() {

        $layout_file = "templates/" . $this->layout . "/compile/index." . Core::$language . ".php";

        if (!is_file($layout_file)) {
            $layout_file = "templates/" . $this->layout . "/compile/index.php";
        }

        $content = (func_num_args() == 0) ? $this->action : func_get_arg(0);

        $content_file_ml = "view/" . $this->controller . "/$content." . Core::$language . ".php";

		
		$this->content = (is_file($content_file_ml)) ? $content_file_ml : 'view/' . $this->controller . '/' . $content . '.php';

		
		
		$this->content = strtolower($this->content);
		
		
        /*if ($_REQUEST['ajaxload'] == 1)
            include($this->content);
        else*/
            include($layout_file);
    }

    public function viewcontent() {
        $content = (func_num_args() == 0) ? $this->action : func_get_arg(0);
        $content_file_ml = "view/" . $this->controller . "/$content." . Core::$language . ".php";
        $content_file = (is_file($content_file_ml)) ? $content_file_ml : 'view/' . $this->controller . '/' . $content . '.php';
        include($content_file);
    }

    //############### helpers ################
    function href($a) {
        return Core::$root . "/" . Core::$language . "/" . $a;
    }

    function src($a) {
        return Core::$root . "/" . $a;
    }

    function header($a = "") {
        Header("Location: http://" . $_SERVER["SERVER_NAME"] . $a);
    }

    //############### dbwork #################
    public function sqlexecute() {
        $first = 0;
		
		$sql = func_get_arg(0);
        if (func_num_args() >= 2) {
            $data = func_get_arg(1);
        }

        if (func_num_args() == 3) {
            $first = 1;
        }

        try {
            $r = Core::getConnect()->prepare($sql);
            if (isset($data)) {
                $r->execute($data);
            } else {
                $r->execute();
            }
            for ($recordset = array(); $row = $r->fetch(PDO::FETCH_ASSOC); $recordset[] = $row)
                ;
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }

        return ($first) ? $recordset[0] : $recordset;
    }

    function get_res($resource) {

        $menu_ml = array(
            'ru' => array('home' => 'Главная'),
            'en' => array('home' => 'Home'),
        );

        return $menu_ml[Core::$language][$resource];
    }

}

?>