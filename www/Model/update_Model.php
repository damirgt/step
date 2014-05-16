<?php

class update_Model {

    function run() {

        $msg = $this->obj->orm_validate();

        if ($msg) {
            $str_set = "";
            $str_where = "";

            $orm_data = $this->obj->orm_data;

            foreach ($this->obj->orm_fields as $index => $object) {

                if (isset($orm_data[$index])) {                   

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

            $qs = $this->obj->connect->prepare("UPDATE " . $this->obj->orm_object . " SET $str_set WHERE $str_where");
            $qs->execute($orm_data);
        }

        return $msg;
    }

}

?>