<?php

$this->helper = new users_helper();

if ($_SERVER['REQUEST_METHOD']=='POST') {
	$correct = $this->helper->enter();
	if ($correct == "") {
            $this->header();
	} else {
		$this->correct = $correct;
		$this->title='Ошибка входа на сайт. Проверьте введенные данные!';	
		$this->view();
	}
}
else {
	$this->title='Вход на сайт';	
	$this->view();
}

?>
										