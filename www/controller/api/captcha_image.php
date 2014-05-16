<?php
    Captcha_Library::KCAPTCHA();
    
    session_start();
    
    $_SESSION['captcha_keystring'] = Captcha_Library::getKeyString();

?>						