<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of core
 *
 * @author Лейсан
 */
class core {
    static public $url = "";
            
    static public function request_url() {

        if (isset($_SERVER['REQUEST_URI'])) {
            $url = $_SERVER['REQUEST_URI'];
        } else {
            if (isset($_SERVER['argv'])) {
                $url = $_SERVER['SCRIPT_NAME'] . '?' . $_SERVER['argv'][0];
            } elseif (isset($_SERVER['QUERY_STRING'])) {
                $url = $_SERVER['SCRIPT_NAME'] . '?' . $_SERVER['QUERY_STRING'];
            } else {
                $url = $_SERVER['SCRIPT_NAME'];
            }
        }

        self::$url = '/' . ltrim($url, '/');
    }

}
