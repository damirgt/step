<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace system\language;

/**
 * Description of language
 *
 * @author Лейсан
 */
class language {

    
    //static public $url = "";
    
    //язык по умолчанию
    static public $lang_def = "ru";
    
    //возможные языки Config
    static public $languages = array('ru' => 'Русский', 'en' => 'English');

    //Текущий язык, определенный системой на основе URL
    static public $language = "";

    static public function languageDetect() {
        $url = \core::$url;
        
        $url_array = explode('/', ltrim($url, '/'));

        if (strlen($url_array[0]) == 2) {
            self::$language = $url_array[0];
            $url = substr(ltrim($url, '/'), 2);
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

        \core::$url = $url;
        
        return $url;
    }

}
