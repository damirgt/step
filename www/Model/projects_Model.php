<?php

class projects_Model extends base_Model {

    //конфиг 
    var $orm_object = "projects";
    var $orm_object_type = "table";
    //*********************************** overload vars ***************************************
    var $orm_pk = "id";
    //var $orm_allow_delete = false;
    //var $orm_sequence = "id DESC";
    //*********************************** Поля (объявление, валидация) ***************************************   
    
    var $orm_fields = array(
        'id' => array(
            'primary_key' => true,
            'auto_increment' => true,
            'type' => 'INT',
        ),
        'user_id' => array(
            'validate' => array(
                            'required' => 'Обязателен для ввода',
                        ),
            'type' => 'INT'
        ),
        'name' => array(
            'validate' => array(
                            'required' => 'Обязателен для ввода',
                            'max_length' => 'Максимальное количество символов в поле не должно превышать 250'
                        ),          
            'max_length' => 250,
            'type' => 'TEXT'
        )
    );

    //*******************************************************************************************
}

?>