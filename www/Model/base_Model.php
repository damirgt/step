<?php

class base_Model {

    var $orm_pk = "id";
    var $orm_sequence = "id DESC";
    var $orm_allow_delete = true;
    var $connect;
    //Одна запись
    public $orm_data = array();
    //Много записей, асоциативный
    public $orm_recordset = array();
    //предопределенный запрос
    public $orm_prepare;
    public $orm_prepare_errorinfo = array();
    //ошибки валидации
    public $orm_validate = array();
    public $orm_fields = array();

    //*********************************** overload methods ***************************************
    function __construct() {
        $this->connect = Core::getConnect();
    }

    //select, first, insert, update, delete
    function __call($m, $p) {
        $name = $m . "_model";
        $tm = new $name();
        $tm->obj = $this;
        return $tm->run();
    }

    function select_pageable($i, $n) {
        $tm = new select_pageable_model();
        $tm->obj = $this;
        return $tm->run($i, $n);
    }

    function get_mess($i) {
        if (isset($this->orm_validate[$i]))
            return $this->orm_validate[$i];
        else
            return '';
    }
    
    function get_data($i) {
        if (isset($this->orm_data[$i]))
            return $this->orm_data[$i];
        else
            return '';
    }

    function validate() {
        $msg = true;

        //Обнуляем массив ошибок
        $orm_validate = array();

        foreach ($this->orm_fields as $index => $object) {

            //Проверяем на валидность только те элементы, у которых есть признак 'validate'
            if (isset($object['validate'])) {

                //Цикл по валидаторам
                foreach ($object['validate'] as $i => $o) {
                    if ($i === 'type') {
                        if ($this->orm_fields[$index]['type'] === 'DATE') {

                            list($date_y, $date_m, $date_d) = explode('-', $this->orm_data[$index]);

                            if (!(checkdate($date_m, $date_d, $date_y))) {
                                $this->orm_validate[$index] = $o;
                                $msg = false;
                            }
                        }
                    };

                    if ($i === 'required') {
                        if (strlen($this->orm_data[$index]) == 0) {
                            $this->orm_validate[$index] = $o;
                            $msg = false;
                        }
                    }

                    if ($i === 'max_length') {
                        if (strlen($this->orm_data[$index]) > $this->orm_fields[$index]['max_length']) {
                            $this->orm_validate[$index] = $o;
                            $msg = false;
                        }
                    }
                }
            }
        }

        return $msg;
    }

    //DML
    function insert() {

        //создаем массив входных параметров
        $str_into = "";
        $str_values = "";

        $orm_data = $this->orm_data;

        foreach ($this->orm_fields as $index => $object) {
            if (array_key_exists($index, $orm_data)) {
                //массив входных параметров

                if (!isset($object['primary_key'])) {
                    if ($str_into == "")
                        $str_into = $index;
                    else
                        $str_into = $str_into . ", " . $index;
                    if ($str_values == "")
                        $str_values = ":" . $index;
                    else
                        $str_values = $str_values . ", :" . $index;
                }
            }
        };

        try {
            $this->orm_prepare = $this->connect->prepare("INSERT INTO " . $this->orm_object . "($str_into) VALUES($str_values)");
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    function update() {

        $str_set = "";
        $str_where = "";

        $orm_data = $this->orm_data;

        foreach ($this->orm_fields as $index => $object) {

            //if (isset($orm_data[$index])) {
            if (array_key_exists($index, $orm_data)) {

                if (isset($object['primary_key']))
                    $str_where = $index . " = :" . $index;
                else {
                    if ($str_set == "")
                        $str_set = $index . " = :" . $index;
                    else
                        $str_set = $str_set . ", " . $index . " = :" . $index;
                }
            }
        };

        $this->orm_prepare = $this->connect->prepare("UPDATE " . $this->orm_object . " SET $str_set WHERE $str_where");
    }

    function save() {
        $msg = $this->validate();

        if ($msg) {
            $this->orm_prepare->execute($this->orm_data);

            $this->orm_prepare_errorinfo = $this->orm_prepare->errorInfo();

            $msg = $this->orm_prepare_errorinfo[0] === '00000' ? true : false;
        }

        return $msg;
    }

}

?>