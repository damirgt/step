<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>[?cache=$this->title;cache?]</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<link href="<?=$this->src('templates/admin/css/style.css')?>" rel="stylesheet" type="text/css" />
 <link rel="stylesheet" href="<?=$this->src('css/validationEngine.jquery.css')?>" type="text/css" media="screen" title="no title" charset="utf-8" />
 <script src="<?=$this->src('js/jquery.js')?>" type="text/javascript"></script>
 <script src="<?=$this->src('js/jquery.validationEngine.js')?>" type="text/javascript"></script>   

 
 <link rel="stylesheet" href="/js/codemirror/lib/codemirror.css"> 
 <script src="/js/codemirror/lib/codemirror.js"></script> 
 <script src="/js/codemirror/mode/xml/xml.js"></script> 
 <script src="/js/codemirror/mode/javascript/javascript.js"></script> 
 <script src="/js/codemirror/mode/css/css.js"></script> 
 <script src="/js/codemirror/mode/clike/clike.js"></script> 
 <script src="/js/codemirror/mode/php/php.js"></script> 
 <style type="text/css">.CodeMirror {border-top: 1px solid black; border-bottom: 1px solid black;}</style>
 <link rel="stylesheet" href="../../doc/docs.css"> 
 
<!--[if lt IE 7]>
   <link href="/style_ie.css" rel="stylesheet" type="text/css" />
<![endif]-->
</head>
<body>
      <!-- header -->
      <div id="header">
        <!-- menu -->
		<ul class="site-nav">
          <li><a href="[?php=$this->href('administrator')php?]">Главная</a></li>
          <li><a href="[?php=$this->href('administrator/list')php?]">Списки</a></li>
          <li><a href="[?php=$this->href('administrator/forms')php?]">Формы</a></li>
		  <li><a href="[?php=$this->href('administrator/templates')php?]">Шаблоны</a></li>
			<li><a href="[?php=$this->href('administrator/menu')php?]">Меню</a></li>
		</ul>
		
		</div>
	<!-- content -->
	<div id="content">
		[?cache include($this->content); cache?]
	</div>
</body>
</html>								