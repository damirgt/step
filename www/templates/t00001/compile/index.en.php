<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title><?=$this->title;?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="Content-Style-Type" content="text/css" />
        <meta name="description" content="<?=$this->description;?>" />
        <meta name="keywords" content="<?=$this->keywords;?>" />
        <meta name="author" content="Templates.com - website templates provider" />
        <link href="/templates/t00001/css/style.css" rel="stylesheet" type="text/css" />
        <link href="/templates/t00001/css/layout.css" rel="stylesheet" type="text/css" />
        <link href="/lightbox.css" rel="stylesheet" type="text/css" />
        <link href="/screen.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="/scripts/jquery-1.7.2.min.js"></script> 
        <script type="text/javascript" src="/scripts/lightbox.js"></script>

        <link rel="stylesheet" href="/css/validationEngine.jquery.css" type="text/css" media="screen" title="no title" charset="utf-8" />
        <script src="/js/jquery.js" type="text/javascript"></script>
        <script src="/js/jquery.validationEngine.js" type="text/javascript"></script>
        <!--[if lt IE 7]>
           <link href="/style_ie.css" rel="stylesheet" type="text/css" />
        <![endif]-->
    </head>
    <body id="<?=$this->bodyid;?>">
        <div class="tail-top-right"></div>
        <div class="tail-top">
            <div class="tail-bottom">
                <div id="main">
                    <!-- header -->
                    <div id="header">
                        <form action="" method="post" id="form">
                            <div>
                                <label><a href = '/ru/<?=Routing_Library::$URI; ?>'>ru</a>|<a href = '/en/<?=Routing_Library::$URI; ?>'>en</a></label>
                                <label>Поиск по сайту:</label>
                                <span>
                                    <input type="text" />
                                </span>
                                <?=Auth_library::$user['login']; ?>
                            </div>
                        </form>
                        <ul class="list">
                            <li><a href="/Home"><img src="/images/icon1.gif" alt="" /></a></li>
                            <li><a href="/Home/contacts"><img src="/images/icon2.gif" alt="" /></a></li>
                            <li><a href="/Home/sitemap"><img src="/images/icon3.gif" alt="" /></a></li>
                            <?php if  (1===1) /*(isset(Auth_library::$user))*/ {?>
                            <li class="last"><a href="/users/logout"><img src="/images/icon5.gif" alt="" /></a>
                            </li>
                            <?php } else { ?>
                            <li class="last"><a href="/users/login"><img src="/images/icon4.gif" alt="" /></a></li>
                            <?php } ?>
                        </ul>
                        <!-- menu -->

                        <ul class="site-nav">
                            <li><a href="<?=$this->href('Home')?>">Home</a></li>
                            <li><a href="<?=$this->href('Home/about')?>">About Us</a></li>
                            <li><a href="<?=$this->href('Home/services')?>">Services</a></li>
                            <li><a href="<?=$this->href('Home/support')?>">Support</a></li>
                            <li><a href="<?=$this->href('gallery')?>">Галерея</a></li>
                            <li><a href="<?=$this->href('Home/contacts')?>">Contact Us</a></li>
                            <li><a href="<?=$this->href('forum')?>">Forum</a></li>
                            <li><a href="<?=$this->href('fm')?>">Fm</a></li>
                            <li class="last"><a href="<?=$this->href('Home/sitemap')?>">Site Map</a></li>
                        </ul> 
                        <!-- end menu -->
                        <div class="logo"><a href="/en/Home"><img src="/images/logo.gif" alt="" /></a></div>
                        <div class="slogan"><img src="/images/slogan.gif" alt="" /></div>
                    </div>

                    <script>
                        function json_example()
                        {
                            $.getJSON('/Home/jsoncontent', function(data) {
                                s = "";
                                $.each(data, function(key, val) {
                                    s = s + key + ' => ' + val + '<br/>'
                                });
                                $("#info").html(s);
                            });
                        }

                        function news_show()
                        {
                            $.ajax({
                                url: "/Home/newsjs",
                                cache: false,
                                success: function(html) {
                                    $("#contentjs").html(html);
                                }
                            });
                        }

                        $(document).ready(function() {
                            //news_show();   
                            //setInterval('news_show()',1000);
                            //json_example();
                            //setInterval('json_example()',1000);				
                        });
                    </script>  
                    <div id="info"></div>
                    <div id="contentjs"></div>
                    <!-- content -->
                    <div id="content">
                        <?php include($this->content); ?>
                    </div>
                    <!-- footer -->
                    <div id="footer">
                        <div class="indent">
                            <div class="fleft">© Гафиятуллин Д.Т.     <?php if (1===1) {?><a href="/administrator">Администрирование системы</a> <?php } ?></div>
                            <div class="fright">Designed by: <a href="http://www.templates.com"><img alt="website templates " src="/images/templates-logo.gif" title="templates.com - website templates provider" /></a> Your <a href="http://russian.templates.com/product/3d-models/" title="templates.com - website templates provider">3D Models</a> Marketplace</div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>																																																																																																																																																																																																																																																																																																																																																																																				