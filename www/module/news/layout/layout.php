<?php
use system\language\language;

?>
<html>
    <head>
        <title><?=$this->title; ?></title>
    </head>
    <body>
        <p>Язык <?=language::$language; ?></p>        
        
<?php
include $this->content_file;
?>
    </body>    
</html>
