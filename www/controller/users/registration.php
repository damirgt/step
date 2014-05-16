<?php

$this->helper = new users_helper();

//проверим, быть может пользователь уже авторизирован. Если это так, перенаправим его на главную страницу сайта
if (isset($_SESSION['id']) || (isset($_COOKIE['login']) && isset($_COOKIE['password']))) {
    $this->header('/home');
} else {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $correct = $this->helper->registrationCorrect(); //записываем в переменную результат работы функции registrationCorrect(), которая возвращает true, если введённые данные верны и false в противном случае
        if ($correct == "") { //если данные верны, запишем их в базу данных
            $login = htmlspecialchars($_POST['login']);
            $password = $_POST['password'];
            $mail = htmlspecialchars($_POST['mail']);
            $salt = mt_rand(100, 999);
            $tm = time();
            $password = md5(md5($password) . $salt);

            $this->model = new users_Model();
            
            $this->model->orm_data = array(
                'login' => $login,
                'password' => $password,
                'salt' => $salt,
                'email' => $mail,
                'last_act' => $tm
            );
 /*
            $model = new users_Model();
            $model->orm_data = $this->model;
  */
            $this->model->insert();            
                       
            if ($this->model->save()) { //пишем данные в БД и авторизуем пользователя
                setcookie("login", $login, time() + 50000, '/');
                setcookie("password", md5($login . $password), time() + 50000, '/');

                Auth_Library::$user = $this->sqlexecute('SELECT * FROM sys_users WHERE login = ? LIMIT 1', array($login), 1);

                //запускаем механизм сессий ** добавлено 2012.10.19 **, по умолчанию механизм сессий отключен
                session_start();
                $_SESSION['id'] = Auth_library::$user['id'];

                $this->buf['correct'] = $correct;
                $this->buf['regged'] = true;
                
                $this->title = 'Регистрация на сайте успешно завершена';
                $this->view();
            }
        } else {
            //подключаем шаблон в случае некорректности данных
            $this->buf['correct'] = $correct;
            $this->buf['regged'] =  false;
            $this->title = 'Регистрация на сайте. Недопустимые значения полей';
            $this->view();
        }
    } else {
         $this->buf['correct'] = "";
        $this->buf['regged'] =  false;
        
        $this->title = 'Регистрация на сайте';
        $this->view();
    }
}
?>													