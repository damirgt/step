<?php

class Auth_Library {

    static public $connect = null;
    //обязательно присвоить значение null, в контроллере делается проверка isset
    static public $user = null;

    static public function users_login() {
        self::$connect = Core::getConnect();

        if (isset($_SESSION['id'])) {

            //echo "Сессия";
            //если сесcия есть
            if (isset($_COOKIE['login']) && isset($_COOKIE['password'])) {//если cookie есть, то просто обновим время их жизни и вернём true
                SetCookie("login", "", time() - 1, '/');
                SetCookie("password", "", time() - 1, '/');
                SetCookie("login", $_COOKIE['login'], time() + 50000, '/');
                SetCookie("password", $_COOKIE['password'], time() + 50000, '/');
                self::users_lastAct($_SESSION['id']);
                return true;
            } else {
                //иначе добавим cookie с логином и паролем,
                //чтобы после перезапуска браузера сессия не слетала
                //запрашиваем строку с искомым id
                $qs = self::$connect->prepare("SELECT * FROM sys_users WHERE id=:id");
                $qs->bindValue(':id', $_SESSION['id']);
                $qs->execute();
                if ($row = $qs->fetch()) { //если получена одна строка
                    setcookie("login", $row['login'], time() + 50000, '/');
                    setcookie("password", md5($row['login'] . $row['password']), time() + 50000, '/');
                    self::users_lastAct($_SESSION['id']);
                    return true;
                }
                else
                    return false;
            }
        }
        else { //если сессии нет, то проверим существование cookie. Если они существуют, то проверим их валидность по БД
            if (isset($_COOKIE['login']) && isset($_COOKIE['password'])) {
                //если куки существуют.
                $qs = self::$connect->prepare("SELECT * FROM sys_users WHERE login=:login");
                $qs->bindValue(':login', $_COOKIE['login']);
                $qs->execute();
                $res_fl = $qs->fetch();

                if ($res_fl && md5($res_fl['login'] . $res_fl['password']) == $_COOKIE['password']) {
                    //если логин и пароль нашлись в БД
                    //запу  скаем механизм сессий ** добавлено 2012.10.19 **, по умолчанию механизм сессий отключен
                    session_start();
                    $_SESSION['id'] = $res_fl['id']; //записываем в сесиию id
                    self::users_lastAct($_SESSION['id']);
                    return true;
                } else { //если данные из cookie не подошли, то удаляем эти куки, ибо они такие нам не нужны
                    SetCookie("login", "", time() - 360000, '/');
                    SetCookie("password", "", time() - 360000, '/');
                    return false;
                }
            } else {//если куки не существуют 
                //$this->users_lastAct(8);
                return false;
            }
        }
    }

    //установка времени последней активности пользователя
    static public function users_lastAct($id) {
        self::$connect = Core::getConnect();

        $tm = time();
        $qs = self::$connect->prepare("UPDATE sys_users SET online = :online, last_act=:last_act WHERE id = :id");
        $qs->bindValue(':online', $tm);
        $qs->bindValue(':last_act', $tm);
        $qs->bindValue(':id', $id);
        $qs->execute();

        $qss = self::$connect->prepare("SELECT * FROM sys_users WHERE id=:id");
        $qss->bindValue(':id', $id);
        $qss->execute();
        self::$user = $qss->fetch(PDO::FETCH_ASSOC);
    }

    //end####################################  модуль авторизации  #########################################
    static public function is_role_by_id($instr) {
        self::$connect = Core::getConnect();

        $id = self::$user['id'];
        if (strlen($instr) == 0)
            return true;
        try {
            $qs = self::$connect->prepare(
                    "SELECT 1 FROM sys_users u 
				INNER JOIN sys_user_roles ur ON ur.user_id = u.id
			WHERE u.id=$id AND ur.role_id IN ($instr)");
            $qs->execute();
            if ($row = $qs->fetch()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    static public function is_role() {
        self::$connect = Core::getConnect();

        $argscnt = func_num_args();

        if ($argscnt == 0) {
            return false;
        } else {
            $instr = "";
            $sep = "";
            $id = self::$user['id'];
            $arg_list = func_get_args();
            foreach ($arg_list as $item) {
                $instr = $instr . $sep . "'" . $item . "'";
                $sep = ",";
            }
            try {
                $qs = self::$connect->prepare(
                        "SELECT 1 FROM sys_users u 
					INNER JOIN sys_user_roles ur ON ur.user_id = u.id
					INNER JOIN sys_roles r ON r.id = ur.role_id
				WHERE u.id=$id AND r.name IN ($instr)");
                $qs->execute();
                if ($row = $qs->fetch()) {
                    return true;
                } else {
                    return false;
                }
            } catch (PDOException $e) {
                die("Error: " . $e->getMessage());
            }
        }
    }

}

?>