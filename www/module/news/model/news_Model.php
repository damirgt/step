<?php

class news_Model extends base_Model {

    //конфиг 
    var $orm_object = "news";
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
        'date' => array(

            'required' => 'Обязателен для ввода',
            'validate' => array(
                            'type' => 'Неправильный формат даты'
                        ),
            'type' => 'DATE',
            'form' => array('label' => 'Дата',
                'type' => 'dateinput',
                'name1' => 'name[day]',
                'name2' => 'name[month]',
                'name3' => 'name[year]'
                )
        ),
        'name' => array(
            
            'validate' => array(
                            'required' => 'Обязателен для ввода',
                            'max_length' => 'Максимальное количество символов в поле не должно превышать 150'
                        ),          
            'max_length' => 150,
            'type' => 'TEXT',
            'form' => array('label' => 'Текст',
                'type' => 'textarea',
                'attribute' => array('name' => 'name[text]',
                    'cols' => '1',
                    'rows' => '1', 
                    'class' => 'validate[required]'
                    )
            )
        )
    );

    //*******************************************************************************************
}

?>