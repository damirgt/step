<?php

class Dispatcher_Library {

    public static $config = array(
            file => 'logs/log.txt'
        );

    public function __construct() {
        self::$config = array(
            file => 'logs/log.txt'
        );
    }

    static function write($string) {
        $fp = fopen(self::$config['file'], 'a');
        fwrite($fp, $string);
        fclose($fp);
    }
    
    static function writeln($string) {
        $fp = fopen(self::$config['file'], 'a');
        fwrite($fp, $string."\r\n");
        fclose($fp);
    }
}

?>