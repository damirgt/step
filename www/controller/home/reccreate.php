<?
/*echo '<pre>';
print_r($_POST[name]);
echo '</pre>';*/
$form = new formUpdater_library();
$form->object = $_POST[name];
$retstr = $form->run('news');
if ($retstr == '') {
	Header("Location: http://".$_SERVER["SERVER_NAME"]."/Home");
}
else {
	echo $retstr;
}

?>