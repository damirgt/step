<?php

class FormInserter_Library {
    
    public $connect = null;

    //$object - обязательно должен быть инициализирован. Массив, где хранятся данные модели (или ссылка) object[type],object[description]
    
    function run($formname) {
        try {
            $this->connect = Conn_Library::getConnect();

            $r = $this->connect->prepare('SELECT * FROM sys_form sf WHERE sf.name = :name');
            $r->bindValue(':name', $formname, PDO::PARAM_STR);
            $r->execute();
            if ($r->errorCode() != 0) {
                return $r->errorCode();
            }
            
            if ($row = $r->fetch(PDO::FETCH_ASSOC)) {
                $form_id = $row['id'];
                $table_name = $row['table_name'];

                $r = $this->connect->prepare('SELECT * FROM sys_form_field WHERE sys_form_id = :sys_form_id AND type NOT IN ("submit","pk")');
                $r->bindValue(':sys_form_id', $form_id, PDO::PARAM_INT);
                $r->execute();
                if ($r->errorCode() != 0) {
                    return $r->errorCode();
                }
                for ($recordset = array(); $row = $r->fetch(PDO::FETCH_ASSOC); $recordset[] = $row)
                    ;
                if (count($recordset) == 0) {
                    return "Отсутствуют описания полей для формы '$formname'";
                } else {
                    foreach ($recordset AS $record) {
                        if (isset($this->object[$record[field_name]])) {
                            $cmd_into = (isset($cmd_into)) ? $cmd_into . ',' . $record[field_name] : $record[field_name];
                            $cmd_values = (isset($cmd_values)) ? $cmd_values . ',:' . $record[field_name] : ':' . $record[field_name];
                        }
                    }

                    if (!(isset($cmd_into))) {
                        return 'В процедуру не передано не одно поле не являющийся первичным ключом';
                    }

                    $cmd_str = "INSERT INTO $table_name($cmd_into) VALUES ($cmd_values)";

                    $r = $this->connect->prepare($cmd_str);
                    foreach ($recordset AS $record) {
                        if (isset($this->object[$record[field_name]])) {
                            $r->bindValue(':' . $record[field_name], htmlspecialchars($this->object[$record[field_name]]), $record[pdo_type]);
                        }
                    }
                    $r->execute();
                    if ($r->errorCode() != 0) {
                        return $r->errorCode();
                    }
                }
            } else {
                return "Форма '$formname' не найдена";
            }
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }

        return '';
    }

}

?>
