<?php

class insert_Model {

    function run() {
        $msg = $this->obj->orm_validate();

        if ($msg) {
            //создаем массив входных параметров
            $str_into = "";
            $str_values = "";

            $orm_data = $this->obj->orm_data;

            foreach ($this->obj->orm_fields as $index => $object) {
                if (isset($orm_data[$index])) {
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
                $qs = $this->obj->connect->prepare("INSERT INTO " . $this->obj->orm_object . "($str_into) VALUES($str_values)");

                $qs->execute($orm_data);

                /* echo "<pre>";
                  print_r($qs->errorInfo());
                  echo "</pre>"; */
            } catch (PDOException $e) {
                die("Error: " . $e->getMessage());
            }
        }
        return $msg;
    }

}

?>