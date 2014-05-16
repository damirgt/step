<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="/templates/bootstrap/assets/ico/favicon.png">

        <title>[?cache=$this->title;cache?]</title>

        <!-- Bootstrap core CSS -->
        <link href="/templates/bootstrap/dist/css/bootstrap.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="/templates/bootstrap/css/jumbotron.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="/templates/bootstrap/assets/js/html5shiv.js"></script>
          <script src="/templates/bootstrap/assets/js/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/Home/">Project name</a>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="<?= $this->href('home'); ?>"><?= $this->get_res('home'); ?></a></li>
                        <li><a href="/Home/about">About</a></li>
                        <li><a href="/Home/Contacts">Contact</a></li>                       
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Язык<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="/ru/[?php=Routing_Library::$URI; php?]">Русский</a></li>
                                <li><a href="/en/[?php=Routing_Library::$URI; php?]">English</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="/Home/Sitemap">Sitemap</a></li>
                                <li><a href="/Home/Services">Services</a></li>
                                <li><a href="#">Another action</a></li>
                                <li><a href="#">Something else here</a></li>
                                <li class="divider"></li>
								<li><a href="/administrator">Администрирование</a></li>
								<li class="divider"></li>
                                <li class="dropdown-header">Вход через соцсети</li>
                                <li><a href="/vkgdt?provider=vk">Вход через Вконтакте</a></li>
                                <li><a href="/vkgdt?provider=yandex">Вход через Яндекс</a></li>
                                <li><a href="/vkgdt?provider=facebook">Вход через Facebook</a></li>
                            </ul>
                        </li>
                    </ul>
                    [?php if  (isset(Auth_library::$user)) { php?]

                    <ul class="nav navbar-nav navbar-right">

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">[?cache=Auth_library::$user['login']; cache?]<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="/User">Персональная страница</a></li>
                                <li><a href="/User/projects">Мои проекты</a></li>
                                <li><a href="/User/create" class="btn-primary">Новый проект</a></li>
                                <li class="divider"></li>
                                <li><a href="/users/logout">Выход</a></li>
                            </ul>
                        </li>
                    </ul>

                    [?php } else { php?]

                    <form class="navbar-form navbar-right" method="POST" action="/users/login">
                        <div class="form-group">
                            <input type="text" placeholder="Login" class="form-control" name="login">
                        </div>
                        <div class="form-group">
                            <input type="password" placeholder="Password" class="form-control" name="password">
                        </div>
                        <button type="submit" class="btn btn-success">Sign in</button>
                        
                    </form>

                    [?php }; php?]

                </div><!--/.navbar-collapse -->
            </div>
        </div>

        <!-- Main jumbotron for a primary marketing message or call to action -->
        <!-- div class="jumbotron">
          <div class="container">
            <h1>Заголовок!</h1>
            <p>This is a template for a simple marketing or informational website. It includes a large callout called the hero unit and three supporting pieces of content. Use it as a starting point to create something more unique.</p>
            <p><a class="btn btn-primary btn-lg">Learn more »</a></p>
          </div>
        </div-->

        <div class="container">
            <!-- Example row of columns -->
            <div class="row">
                [?cache include($this->content); cache?]
            </div>

            <hr>

            <footer>
                <p>© Company 2013</p>
            </footer>
        </div> <!-- /container -->


        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="/templates/bootstrap/assets/js/jquery.js"></script>
        <script src="/templates/bootstrap/dist/js/bootstrap.min.js"></script>  
    </body>
</html>
														