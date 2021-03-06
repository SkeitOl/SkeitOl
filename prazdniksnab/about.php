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
<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/prazdniksnab/"><i style="background: url('https://morozko5.ru/img/logotype.png') left center no-repeat;height: 40px;width: 40px;display: inline-block;background-size: 162px;"></i></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#about">Каталог</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Покупателям <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Доставка</a></li>
                        <li><a href="#">Оплата</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#">Скидки</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">О компании<span class="caret"></span></a>
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
            <ul class="nav navbar-nav navbar-right">
                <li><a href="../navbar/"><img id="bx_cart_block" src="https://prazdniksnab.com/img/shopping_cart.png" style="margin: -2px 0 0 21px;cursor: pointer; border: none; width: 32px; height: 32px;" title="Ваша корзина" alt="Ваша корзина"></a></li>
                <?/*<li class="active"><a href="./">Static top <span class="sr-only">(current)</span></a></li>
                <li><a href="../navbar-fixed-top/">Fixed top</a></li>*/?>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <a href="/prazdniksnab/"><img src="https://morozko5.ru/img/logotype.png" height="70px"></a>
            </div>
            <div class="col-md-4">
                <div class="hd-m-trust">
                    <ul>
                        <li>
                            <img src="https://prazdniksnab.com/img/g1.png" alt="ВЫСОКОЕ КАЧЕСТВО ТОВАРОВ">
                            <p>ВЫСОКОЕ КАЧЕСТВО ТОВАРОВ</p>
                        </li>
                        <li>
                            <img src="https://prazdniksnab.com/img/g2.png" alt="ДОСТАВКА ПО РФ и СНГ">
                            <p>НАДЕЖНЫЙ ПАРТНЕР</p>
                        </li>
                        <li>
                            <img src="https://prazdniksnab.com/img/g3.png" alt="ОБУЧАЮЩИЕ КУРСЫ В ПОДАРОК">
                            <p>ОБУЧАЮЩИЕ КУРСЫ В ПОДАРОК</p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div class="contacts_new">
                    <div class="phone_header_new">8 800 100-90-22</div>
                    <div class="dostavka" style="margin-left:-5px;">Звонки со всех телефонов<br>РФ бесплатные</div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h1>Prazdniksnab</h1>
                <h2>Интернет-магазин товаров для ПРАЗДНИКА</h2>
            </div>
        </div>
    </div>

<!-- Carousel
    ================================================== -->
<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner" role="listbox">
        <div class="item active">
            <img class="first-slide" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="First slide">
            <div class="container">
                <div class="carousel-caption">
                    <h1>Example headline.</h1>
                    <p>Note: If you're viewing this page via a <code>file://</code> URL, the "next" and "previous" Glyphicon buttons on the left and right might not load/display properly due to web browser security rules.</p>
                    <p><a class="btn btn-lg btn-primary" href="#" role="button">Sign up today</a></p>
                </div>
            </div>
        </div>
        <div class="item">
            <img class="second-slide" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Second slide">
            <div class="container">
                <div class="carousel-caption">
                    <h1>Another example headline.</h1>
                    <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                    <p><a class="btn btn-lg btn-primary" href="#" role="button">Learn more</a></p>
                </div>
            </div>
        </div>
        <div class="item">
            <img class="third-slide" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Third slide">
            <div class="container">
                <div class="carousel-caption">
                    <h1>One more for good measure.</h1>
                    <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
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

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html>