<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Document</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="css/style.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="top-row">
    <div class="">
        <div class="container">
            <div class="col-sm-3"><span class="glyphicon glyphicon-phone" aria-hidden="true"></span> 8 800 100-90-22
            </div>
            <div class="col-sm-3"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
                manager@prazdniksnab.com
            </div>
            <div class="col-sm-2"><a href=""><span class="glyphicon glyphicon-comment" aria-hidden="true"></span> Задать
                    вопрос</a></div>
            <div class="col-sm-4">
                <form class="navbar-form navbar-right" role="search">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Search">
                    </div>
                    <button type="submit" class="btn btn-default">Поиск</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="header_con">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-4">
                    <a href="/prazdniksnab/"><img src="http://morozko5.ru/img/logotype.png" height="70px"></a>
                </div>
                <div class="col-md-4">
                    <div class="hd-m-trust">
                        <ul>
                            <li>
                                <img src="http://prazdniksnab.com/img/g1.png" alt="ВЫСОКОЕ КАЧЕСТВО ТОВАРОВ">
                                <p>ВЫСОКОЕ КАЧЕСТВО ТОВАРОВ</p>
                            </li>
                            <li>
                                <img src="http://prazdniksnab.com/img/g2.png" alt="ДОСТАВКА ПО РФ и СНГ">
                                <p>НАДЕЖНЫЙ ПАРТНЕР</p>
                            </li>
                            <li>
                                <img src="http://prazdniksnab.com/img/g3.png" alt="ОБУЧАЮЩИЕ КУРСЫ В ПОДАРОК">
                                <p>ОБУЧАЮЩИЕ КУРСЫ В ПОДАРОК</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="contacts_new">
                        <div class="phone_header_new"><span class="glyphicon glyphicon-phone"></span> 8 800 100-90-22
                        </div>
                        <div class="dostavka" style="margin-left:-5px;">Звонки со всех телефонов<br>РФ бесплатные</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                        aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="<? /*active*/ ?>"><a href="#about">Каталог</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false">Покупателям <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Доставка</a></li>
                            <li><a href="#">Оплата</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#">Скидки</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false">О компании<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Информация о компании</a></li>
                            <li><a href="#">Миссия и уникальность</a></li>
                            <li><a href="#">Вакансии</a></li>
                            <li><a href="#">Отзывы клиентов</a></li>
                            <li><a href="#">Вакансии</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Оптовикам</a></li>
                    <li><a href="#contact">Контакты</a></li>

                </ul>

            </div><!--/.nav-collapse -->
        </div>
    </nav>
</div>

<!-- Carousel
    ================================================== -->
<div class="container">
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner" role="listbox">
            <div class="item active">
                <img class="first-slide"
                     src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw=="
                     alt="First slide">
                <div class="container">
                    <div class="carousel-caption">
                        <h1>Example headline.</h1>
                        <p>Note: If you're viewing this page via a <code>file://</code> URL, the "next" and "previous"
                            Glyphicon buttons on the left and right might not load/display properly due to web browser
                            security rules.</p>
                        <p><a class="btn btn-lg btn-primary" href="#" role="button">Sign up today</a></p>
                    </div>
                </div>
            </div>
            <div class="item">
                <img class="second-slide"
                     src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw=="
                     alt="Second slide">
                <div class="container">
                    <div class="carousel-caption">
                        <h1>Another example headline.</h1>
                        <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta
                            gravida
                            at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                        <p><a class="btn btn-lg btn-primary" href="#" role="button">Learn more</a></p>
                    </div>
                </div>
            </div>
            <div class="item">
                <img class="third-slide"
                     src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw=="
                     alt="Third slide">
                <div class="container">
                    <div class="carousel-caption">
                        <h1>One more for good measure.</h1>
                        <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta
                            gravida
                            at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                        <p><a class="btn btn-lg btn-primary" href="#" role="button">Browse gallery</a></p>
                    </div>
                </div>
            </div>
        </div>
        <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div><!-- /.carousel -->
</div>
<div class="container">
    <div class="row">
        <div class="col-sm-5">
            <h2>Акции</h2>
            <div class="col-sm-12">
                <div class="col-sm-4"><img
                        style="height:150px;display: block;"
                        src="https://pp.vk.me/c629409/v629409106/3ae7c/yNvZ71H81QI.jpg"
                        data-holder-rendered="true"></div>
                <div class="col-sm-8"><div class="caption"><h3>Глаза разбегаются👀</h3>
                        <p>«Надувашки»<br>
                            гитары, синтезаторы, саксофоны, трубы, микрофоны
                            представлены более чем в пяти разных цветах.
                            <br><br>
                            Цены от <b>80 руб.</b></p>
                        <p><a href="#">Подробнее</a></p>
                    </div></div>


            </div>
        </div>
        <div class="col-sm-7">
            <h2>Новости</h2>
            <div>
                <ul>
                    <li><p><span>20 апреля 2016</span> <a href="">Новая подборка фотографий. Надувной костюм Клоун</a></p></li>
                    <li><p><span>20 апреля 2016</span> <a href="">Новая подборка фотографий. Надувной костюм Клоун</a></p></li>
                    <li><p><span>20 апреля 2016</span> <a href="">Новая подборка фотографий. Надувной костюм Клоун</a></p></li>
                    <li><p><span>20 апреля 2016</span> <a href="">Новая подборка фотографий. Надувной костюм Клоун</a></p></li>
                    <li><p><span>20 апреля 2016</span> <a href="">Новая подборка фотографий. Надувной костюм Клоун</a></p></li>
                </ul>
            </div>
        </div>
        <div style="clear:both;"></div>
        <div class="col-sm-12">
            <h1 class="center">Каталог</h1>
        </div>
    </div>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
</body>
</html>