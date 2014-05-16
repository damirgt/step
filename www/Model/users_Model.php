<?php

//require_once("model/_base.php");

class users_Model extends base_Model {

    //конфиг
    var $orm_object = "sys_users";
    var $orm_object_type = "table";

    function select_by_login() {
        try {
            $qs = $this->connect->prepare("SELECT * FROM $this->orm_object WHERE login=:id");
            $qs->bindValue(':id', $this->login);
            $qs->execute();
            if ($row = $qs->fetch()) {

                foreach ($row as $key => $item) {
                    $this->$key = $item;
                }

                $this->orm_entity = array();
                $this->orm_entity[] = $row;

                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    function is_role() {
        $argscnt = func_num_args();

        if ($argscnt == 0) {
            return false;
        } else {
            $instr = "";
            $sep = "";
            $arg_list = func_get_args();
            foreach ($arg_list as $item) {
                $instr = $instr . $sep . "'" . $item . "'";
                $sep = ",";
            }
            try {
                $qs = $this->connect->prepare(
                        "SELECT 1 FROM users u 
					INNER JOIN user_roles ur ON ur.user_id = u.id
					INNER JOIN roles r ON r.id = ur.role_id
				WHERE u.id=$this->id AND r.name IN ($instr)");
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

    function is_role_by_id($instr) {
        if (strlen($instr) == 0)
            return true;
        try {
            $qs = $this->connect->prepare(
                    "SELECT 1 FROM users u 
				INNER JOIN user_roles ur ON ur.user_id = u.id
			WHERE u.id=$this->id AND ur.role_id IN ($instr)");
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

    //*********************************** overload vars ***************************************
    var $orm_pk = "id";
    //var $orm_allow_delete = false;
    //var $orm_sequence = "id DESC";
    //*********************************** overload methods ***************************************
    //*********************************** Поля (объявление, валидация) ***************************************
    var $orm_fields = array(
        'id' => array(
            'primary_key' => true,
            'auto_increment' => true,
            'type' => 'SMALLINT(8) UNSIGNED'
        ),
        'login' => array(
            'label' => 'Логин',
            'type' => 'VARCHAR(25) NOT NULL'
        ),
        'password' => array(
            'label' => 'Пароль',
            'type' => 'VARCHAR(32) NOT NULL'
        ),
        'salt' => array(
            'label' => 'Соль',
            'type' => 'VARCHAR(3) NOT NULL'
        ),
        'email' => array(
            'label' => 'e-mail',
            'type' => 'VARCHAR(50) NOT NULL'
        ),
        'online' => array(
            'label' => 'Онлайн',
            'type' => 'INT(11) NOT NULL'
        ),
        'last_act' => array(
            'label' => 'Последняя активность',
            'type' => 'INT(11) NOT NULL'
        ),
        'reg_date' => array(
            'type' => 'DATE NULL'
        ),
        'provider' => array(
            'type' => 'VARCHAR(50) NULL'
        ),
        'social_id' => array(
            'type' => 'VARCHAR(255) NULL'
        ),
        'name' => array(
            'type' => 'VARCHAR(255) NULL'
        ),
        'social_page' => array(
            'type' => 'VARCHAR(255) NULL'
        ),
        'sex' => array(
            'type' => 'VARCHAR(1) NULL'
        )
        ,
        'birthday' => array(
            'type' => 'DATE NULL'
        )
        ,
        'avatar' => array(
            'type' => 'VARCHAR(255) NULL'
        )
    );

    //*******************************************************************************************
}

?>