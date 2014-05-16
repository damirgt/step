<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $this->retval_mas = array();

    //временно сохраняем язык интрефейса
    $templang = Core::$language;

    //наименование шаблона переданный как параметр POST методом
    $template = $this->values['id'];

    
    //наименование файла шаблона
    $template_file = 'templates/' . $template . '/index.php';

    //конфигурационный файл шаблона
    $template_config = 'templates/' . $template . '/config.php';
    if (is_file($template_config))
    include $template_config;

    $template_ml = 0;
    if (isset($template_langs)) {
        $template_ml = 1;
    } else {
        //создаем фальшивый язык
        $template_langs = array("nothing");
    }

    if ($template_ml === 1) {
        $template_lang_default_str = "<?php include 'index." . $template_lang_default . ".php'; ?>";
        $template_lang_default_file = "templates/" . $template . "/compile/index.php";

        $fp = fopen($template_lang_default_file, 'w');
        $flag = fwrite($fp, $template_lang_default_str);
        fclose($fp);
    }

    //создание папки истории
    $history_dir = "templates/" . $template . "/history/";

    
    
    if (!is_dir($history_dir)) {
        mkdir($history_dir);
    }

    //копирование старого шаблона в папку истории
    $tm = time();
    $template_file_history = $history_dir . 'index_' . $tm . '.php';

    if (copy($template_file, $template_file_history))
        $this->retval_mas[] = "Копирование успешно выполнено.<br>";
    else
        $this->retval_mas[] = "Ошибка при копировании.<br>";

    //обновление файла шаблона

    $fp = fopen($template_file, 'w');
    $flag = fwrite($fp, html_entity_decode($_POST['code']));
    fclose($fp);

    if ($flag)
        $this->retval_mas[] = "Изменения в шаблон внесены";

    //удаление скомпилированных файлов
    foreach ($template_langs as $template_lang) {
        if ($template_ml === 1) {
            $compile = "templates/" . $template . "/compile/index." . $template_lang . ".php";
            $compile_cache = "templates/" . $template . "/compile_cache/index." . $template_lang . ".php";
            Core::$language = $template_lang;
        } else {
            $compile = "templates/" . $template . "/compile/index.php";
            $compile_cache = "templates/" . $template . "/compile_cache/index.php";
        }

        if (is_file($compile)) {
            if (unlink($compile)) {
                $this->retval_mas[] = "Файл $compile удален";
            } else {
                $this->retval_mas[] = "Ошибка при удалении файла $compile";
            }
        }

        if (is_file($compile_cache)) {
            if (unlink($compile_cache)) {
                $this->retval_mas[] = "Файл $compile_cache удален";
            } else {
                $this->retval_mas[] = "Ошибка при удалении файла $compile_cache ";
            }
        }

        //компиляция шаблона
        ob_start();
        include $template_file;
        $buffer = ob_get_contents();

        //предварительная компиляция
        $buffer = (str_replace('cache?]', '?>', (str_replace('[?cache=', '<?=', $buffer))));
        $buffer = (str_replace('cache?]', '?>', (str_replace('[?cache', '<?php', $buffer))));
        $fp = fopen($compile_cache, 'w');
        fwrite($fp, $buffer);
        fclose($fp);
        $this->retval_mas[] = "Файл $compile_cache создан ";

        //полная компиляция
        $buffer = (str_replace('php?]', '?>', (str_replace('[?php=', '<?=', $buffer))));
        $buffer = (str_replace('php?]', '?>', (str_replace('[?php', '<?php', $buffer))));
        $fp = fopen($compile, 'w');
        fwrite($fp, $buffer);
        fclose($fp);
        $this->retval_mas[] = "Файл $compile создан ";
        ob_end_clean();
    }

    //Возвращаем исходный язык
    Core::$language = $templang;
}

$this->view();

/*
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $this->retval_mas = array();

    //временно сохраняем язык интрефейса
    $templang = Lang_Library::$language;

    //наименование шаблона переданный как параметр POST методом
    $template = $this->values['id'];

    
    //наименование файла шаблона
    $template_file = 'templates/' . $template . '/index.php';

    //конфигурационный файл шаблона
    $template_config = 'templates/' . $template . '/config.php';
    if (is_file($template_config))
    include $template_config;

    $template_ml = 0;
    if (isset($template_langs)) {
        $template_ml = 1;
    } else {
        //создаем фальшивый язык
        $template_langs = array("nothing");
    }

    if ($template_ml === 1) {
        $template_lang_default_str = "<?php include 'index." . $template_lang_default . ".php'; ?>";
        $template_lang_default_file = "templates/" . $template . "/compile/index.php";

        $fp = fopen($template_lang_default_file, 'w');
        $flag = fwrite($fp, $template_lang_default_str);
        fclose($fp);
    }

    //создание папки истории
    $history_dir = "templates/" . $template . "/history/";

    if (!is_dir($history_dir)) {
        mkdir($history_dir);
    }

    //копирование старого шаблона в папку истории
    $tm = time();
    $template_file_history = $history_dir . 'index_' . $tm . '.php';

    if (copy($template_file, $template_file_history))
        $this->retval_mas[] = "Копирование успешно выполнено.<br>";
    else
        $this->retval_mas[] = "Ошибка при копировании.<br>";

    //обновление файла шаблона

    $fp = fopen($template_file, 'w');
    $flag = fwrite($fp, html_entity_decode($_POST['code']));
    fclose($fp);

    if ($flag)
        $this->retval_mas[] = "Изменения в шаблон внесены";

    //удаление скомпилированных файлов
    foreach ($template_langs as $template_lang) {
        if ($template_ml === 1) {
            $compile = "templates/" . $template . "/compile/index." . $template_lang . ".php";
            $compile_cache = "templates/" . $template . "/compile_cache/index." . $template_lang . ".php";
            Lang_Library::$language = $template_lang;
        } else {
            $compile = "templates/" . $template . "/compile/index.php";
            $compile_cache = "templates/" . $template . "/compile_cache/index.php";
        }

        if (is_file($compile)) {
            if (unlink($compile)) {
                $this->retval_mas[] = "Файл $compile удален";
            } else {
                $this->retval_mas[] = "Ошибка при удалении файла $compile";
            }
        }

        if (is_file($compile_cache)) {
            if (unlink($compile_cache)) {
                $this->retval_mas[] = "Файл $compile_cache удален";
            } else {
                $this->retval_mas[] = "Ошибка при удалении файла $compile_cache ";
            }
        }

        //компиляция шаблона
        ob_start();
        include $template_file;
        $buffer = ob_get_contents();

        //предварительная компиляция
        $buffer = (str_replace('cache?]', '?>', (str_replace('[?cache=', '<?=', $buffer))));
        $buffer = (str_replace('cache?]', '?>', (str_replace('[?cache', '<?php', $buffer))));
        $fp = fopen($compile_cache, 'w');
        fwrite($fp, $buffer);
        fclose($fp);
        $this->retval_mas[] = "Файл $compile_cache создан ";

        //полная компиляция
        $buffer = (str_replace('php?]', '?>', (str_replace('[?php=', '<?=', $buffer))));
        $buffer = (str_replace('php?]', '?>', (str_replace('[?php', '<?php', $buffer))));
        $fp = fopen($compile, 'w');
        fwrite($fp, $buffer);
        fclose($fp);
        $this->retval_mas[] = "Файл $compile создан ";
        ob_end_clean();
    }

    //Возвращаем исходный язык
    Lang_Library::$language = $templang;
}

$this->view();*/
?>		