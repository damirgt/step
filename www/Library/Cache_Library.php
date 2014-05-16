<?php
class Cache_Library
{
	function Run()
	{
		$cache_uri = strtolower($_SERVER['REQUEST_URI']);
		//$cache_uri_md5 = md5($cache_uri);
		$cache_uri_md5 = str_replace('/','$',$cache_uri);

		$cache_file = ltrim((SITE_DIR."cache/".$cache_uri_md5.".php"),'/');

		if (is_file($cache_file)) {
		
			ob_start();//включаем буферизацию кэша
			
			include $cache_file;
			
			if ($cache_expiry-time() < 0) {
				ob_end_clean();
				//echo time();
				//1. передаем управление фронт контроллеру, там создается новый кэшированный файл (старый при этом удаляется)
			} 
			else {
				ob_end_flush();
				//вывод кэша из буфреа
				//echo $cache_expiry-time();
				exit;//завершаем выполнение скрипта
			}	
		}

	}
}
?>
