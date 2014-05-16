<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace system\routing;

use system\language\language;

/**
 * Description of routing
 *
 * @author Лейсан
 */
class routing {

    static $url = "";
    static $routes = array();

    static public $controller;
    static public $action;
    static public $values;
    
    public function __construct($url,array $routes = array())
    {
        self::$routes = $routes;
        self::$url = $url;
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
                //echo $i;               
                //echo "<br>";
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

        return "/" . language::$language . "/" . $link;
        
        //  rule => "{controller}/{action}/{0|0|s|id}",
        //  defaults => array(controller => "Home", action => "Index")
         
    }
}
