<?php

//use \system\basecontroller\basecontroller;
//из фронтконтролера вызывается класс с имененем controller и методом run()

class controller {

    //эту функцию можно не писать, по умолчанию вызовется функция родителя.
    public function run()
    {
        echo "<p>Для работы фреймворка необязательно наследоваться от других классов</p>";
    }
}