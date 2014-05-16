<?php

class Routing_Library {

    static public $controller;
    static public $action;
    static public $values;
    static public $URI = "";
    static public $routes = array();   //обязательно передается в текущий экземпляр

    /* пример $routes:
     * $routing->routes = array(
     *       array(name => "default", rule => "{controller}/{action}/{0|0|s|id}", defaults => array(controller => "Home", action => "Index"))
     *   );
     */

    static function get($path) {
        

        //print_r($_GET);
        
        //удаление концевых слешей
        $path = trim($path, '/');

        self::$URI = $path;
        
        $pathArray = explode('?', $path);
        
        //преобразование в массив
        $uriArray = explode('/', $pathArray[0]);

        foreach (self::$routes as $route) {    //##цикл по маршрутам
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
}

?>