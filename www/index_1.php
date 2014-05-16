<?php

ini_set('display_errors', 1);

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

header("Content-Type: text/html; charset=utf-8");

Core::$url = trim($_SERVER['REQUEST_URI'], "/");

Core::$url = ltrim(Core::$url, Core::$root);

Core::$url = trim(Core::$url, "/");

// * ************************ Определение языка ****************************** 

Core::$url = Core::languageDetect();

Core::$url = trim(Core::$url, "/");

// * ********************* Автозагрузчик классов ***************************** 
spl_autoload_register('autoload');
/*
function autoload($className) {
    $arr = explode('_', $className);
    $fdr = end($arr);
    $file = $fdr . '/' . $className . '.php';
    include $file;
}
*/
function autoload($className) {
    $pos = strpos($className, '_');
    if ($pos === false) {
        //echo str_replace('\\', '/', $className). '.php';
        require_once str_replace('\\', '/', $className). '.php';
        //require_once str_replace('SocialAuther/', '', str_replace('\\', '/', $className) . '.php');
    } else {
        $arr = explode('_', $className);
        $fdr = end($arr);
        $file = $fdr . '/' . $className . '.php';
        include $file;
    }
}

// * ********************** авторизация и сессия ***************************** 
//ini_set ("session.use_cookies", 0);
ini_set("session.use_trans_sid", 1);
ini_set("session.use_only_cookies", 0);

if (isset($_REQUEST[session_name()]))
    session_start();

Auth_Library::users_login();

// * ********************** роутинг ****************************************** 

Core::getRoute();

$controller = new base_controller();

$controller->run();

class Core11 {

    //соединения
    static private $connections = array();
    //пут к каталогу с проектом Config
    static public $root = "";
    //язык по умолчаний Config
    static public $lang_def = "ru";
    //возможные языки Config
    static public $languages = array('ru' => 'Русский', 'en' => 'English');
    //Текущий язык, определенный системой на основе URL
    static public $language = "";
    //url
    static public $url = "";
    //маршруты
    static public $routes = array(
        'vkgdt' => array(
            'name' => "vkgdt",
            'rule' => "vkgdt",
            'defaults' => array('controller' => "api", 'action' => "social")
        ),
        'default' => array(
            'name' => "default",
            'rule' => "{controller}/{action}/{id}",
            'defaults' => array('controller' => "Home", 'action' => "Index")
        )
    );
    static public $controller;
    static public $action;
    static public $values;

    static public function getConnect($cnname = 'default') {
        if (!isset(self::$connections[$cnname])) {
//            self::$connections[$cnname] = new PDO('mysql:host=127.0.0.1;dbname=spoon', 'root', '');
            self::$connections[$cnname] = new PDO('mysql:host=localhost;dbname=u1805s5430_root', 'u1805s5430_root', 'just2shen');
        }
        return self::$connections[$cnname];
    }

    static public function languageDetect() {
        $url_array = explode('/', ltrim(self::$url, '/'));

        if (strlen($url_array[0]) == 2) {
            self::$language = $url_array[0];
            self::$url = substr(ltrim(self::$url, '/'), 2);
            SetCookie("language", self::$language, time() + 1000000, '/');
        } else {
            if (isset($_COOKIE['language'])) {
                self::$language = $_COOKIE['language'];
            } else {
                // здесь можно попытаться автоматически определить язык посетителя 
                self::$language = self::$lang_def;
                SetCookie("language", self::$language, time() + 1000000, '/');
            }
        }

        if (!(in_array(self::$language, array_keys(self::$languages)))) {
            self::$language = self::$lang_def;
            SetCookie("language", self::$language, time() + 1000000, '/');
        }

        return self::$url;
    }

    static function getRoute() {

        //print_r($_GET);
        //удаление концевых слешей
        self::$url = trim(self::$url, '/');

        $pathArray = explode('?', self::$url);

        //преобразование в массив
        $uriArray = explode('/', $pathArray[0]);

        foreach (self::$routes as $routekey => $route) {    //##цикл по маршрутам
            $route['rule'] = trim($route['rule'], '/');  //## rule	|	удаление концевых слешей

            $ruleArray = explode('/', $route['rule']);  //## rule	|	преобразование в массив

            $i = 0;
            foreach ($ruleArray as $raItem) {    //##цикл по правилу
                if ($raItem[0] == "{") {

                    switch ($raItem) {
                        case "{controller}":
                            self::$controller = empty($uriArray[$i]) ? $route['defaults']['controller'] : $uriArray[$i];
                            $retval = 1;
                            break;
                        case "{action}":
                            self::$action = empty($uriArray[$i]) ? $route['defaults']['action'] : $uriArray[$i];
                            $retval = 1;
                            break;
                        default:
                            $raItem = ltrim(rtrim($raItem, '}'), '{');
                            $raItemParms = explode('|', $raItem);
                            $raipCnt = count($raItemParms);
                            if ($raipCnt == 1) {
                                if (isset($uriArray[$i])) {
                                    self::$values[$raItemParms[0]] = $uriArray[$i];
                                    $retval = 1;
                                } else {
                                    $retval = 0;
                                }
                            } else {
                                if (!isset($uriArray[$i])) {
                                    $retval = ($raItemParms[1] == 1) ? 0 : 1;
                                } else {
                                    $retval = 1;
                                    self::$values[$raItemParms[3]] = $uriArray[$i];

                                    //проверяем дополнительные условия

                                    if ($raItemParms[2] == 'i') {
                                        $retval = (is_numeric($uriArray[$i])) ? 1 : 0;
                                    }

                                    if ($retval == 1) {
                                        if (!empty($raItemParms[0])) {
                                            if (strlen($uriArray[$i]) != $raItemParms[0])
                                                $retval = 0;
                                        }
                                    }
                                }
                            }
                            break;
                    }
                }
                else {
                    $retval = ($raItem == $uriArray[$i]) ? 1 : 0;

                    if ($retval == 0) {
                        break;
                    }
                }

                $i++;
                /* echo $i;               
                  echo "<br>"; */
            } //цикл по правилу	

            if ($retval == 1) {
                if (empty(self::$controller))
                    self::$controller = $route['defaults']['controller'];
                if (empty(self::$action))
                    self::$action = $route['defaults']['action'];
                break;
            }
        }
        return $retval;
    }

    static function getLink($controller = "", $action = "", $routename = "", $params = array()) {
        $route = array();
        if ($routename == "") {
            $routename = "default";
        }

        $route = self::$routes[$routename];

        if ($controller == "") {
            $controller = $route['defaults']['controller'];
        }

        if ($action == "") {
            $action = $route['defaults']['action'];
        }

        $link = $route['rule'];

        $link = str_replace("{controller}", $controller, $link);
        $link = str_replace("{action}", $action, $link);

        foreach ($params as $key => $param) {
            $count = 0;
            $link = str_replace("{" . $key . "}", $param, $link, $count);

            if ($count)
                unset($params[$key]);
        }

        $i = stripos($link, "{");
        if ($i > 0)
            $link = substr($link, 0, $i);

        if (count($params) > 0) {
            $link = $link . "?" . http_build_query($params);
        }

        return "/" . self::$language . "/" . $link;
       
    }

}

//$begin_time = microtime(true);
/*
  $end_time = microtime(true) - $begin_time;
  echo $end_time;
 */

/*
  function request_uri() {

  if (isset($_SERVER['REQUEST_URI'])) {
  $uri = $_SERVER['REQUEST_URI'];
  }
  else {
  if (isset($_SERVER['argv'])) {
  $uri = $_SERVER['SCRIPT_NAME'] .'?'. $_SERVER['argv'][0];
  }
  elseif (isset($_SERVER['QUERY_STRING'])) {
  $uri = $_SERVER['SCRIPT_NAME'] .'?'. $_SERVER['QUERY_STRING'];
  }
  else {
  $uri = $_SERVER['SCRIPT_NAME'];
  }
  }
  // Prevent multiple slashes to avoid cross site requests via the FAPI.
  $uri = '/'. ltrim($uri, '/');

  return $uri;
  }
 */
?>