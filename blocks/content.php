<html>
<head>
    <title>SkeitOl</title>
    <link rel="stylesheet" type="text/css" href="style/style.css" />
    <link rel="SHORTCUT ICON" href="images/S.ico">
</head>
<body>
<?php include("blocks/header.php");?>
    <div id='header'>
        <div id="topmenu">
            <img src="images/sol.gif" style="position: absolute; height: 30px; width: 80px;" />
        </div>
        <div id='menu-div'>
            <ul id='mainmenu'>
                <li><a href='index.html'>Index</a></li>
                <li><a href='index.html'>News</a></li>
                <li><a href='index.html'>Programm</a></li>
            </ul>
            <div id='search-div'>
                <input class='search-input' type='text' value='Поиск..' />
                <input id='search-button' type="button" value="П" />
                <!--<div id='search-button'></div>
                -->
            </div>
        </div>
    </div>

    <div id='content'>
        <div class='news-block'>
            <center>Блок новостей</center>
            <div class='news-item'>
                <div class='news-title'>
                    <span>Название новости</span>
                </div>
                <div class='news-data'>
                    10,02,2013
                </div>
                <div class='news-main'>
                    <div class='news-text'>
                        Краткий текст новости
                    </div>
                    <div class='news-more'><a href='view_program.php?id=%s'>Подробнее ></a></div>
                    <div class='clear'></div>
                </div>
            </div>
        </div>

        <div class='small-block'>
            <div class='title-small-block'>Блок программ</div>
            <ul>
                <li>Programm 1</li>
                <li>Programm 2</li>
                <li>Programm 3</li>
                <li>Programm 4</li>
            </ul>
        </div>
        <div class='small-block'>
            <div class='title-small-block'>Блок articles</div>
            <ul>
                <li>Статья 1</li>
                <li>Статья 2</li>
                <li>Статья 3</li>
                <li>Статья 4</li>
            </ul>
        </div>
        <div class='small-block'>
            <div class='title-small-block'>Опрос</div>
            <div id='question'>
                <form style='margin: 10px;'>
                    <p>Как Вам сайт?</p>
                    <input type='radio' id='radiobutton1' /><label>Отлично</label><br />
                    <input type='radio' id='radiobutton2' /><label>Хорошо</label><br />
                    <input type='radio' id='radiobutton3' /><label>Ужасно</label><br />
                    <input type="button" value='Ответить' onclick='Hid()' />
                </form>
            </div>
            <script type='text/javascript'>
                function Hid() {
                    var n = 200;
                    if (document.getElementById('radiobutton1').checked || document.getElementById('radiobutton2').checked || document.getElementById('radiobutton3').checked) {
                        document.getElementById('question').style.display = 'none';
                        document.getElementById('opros').style.display = 'block';
                    }
                    else alert('Выберите хотя бы один пункт');
                }
            </script>
            <!--
                width: 240px;
                 -->
            <div id="opros" style='margin: 10px; display: none;'>
                <p>Как Вам сайт?</p>
                <label>Отлично - 2</label>
                <div id='otvet1' style='height: 10px; background-color: green; width: 200px;'></div>
                <label>Хорошо - 1</label>
                <div id='otvet2' style='height: 10px; background-color: yellow; width: 120px;'></div>
                <label>Ужасно - 0</label>
                <div id='otvet3' style='height: 10px; background-color: red; width: 1px;'></div>
            </div>
        </div>
    </div>
    <div id='footer'>
        <div class='div-center'>
            <div id='footer2'>
                <div class='footer-link'>
                    <div class='footer-block'>
                        <div class='title-footer-block'>Основные разделы</div>
                        <ul>
                            <li><a href='index.php'>Главная</a></li>
                            <li><a href='index.php'>Progrqmm</a></li>
                            <li><a href='index.php'>News</a></li>
                        </ul>
                    </div>
                    <div class='separator'></div>
                    <div class='footer-block'>
                        <div class='title-footer-block'>Последние приложения</div>
                        <ul>
                            <li><a href='index.php'>Timer_off</a></li>
                            <li><a href='index.php'>Sked</a></li>
                            <li><a href='index.php'>HtmlColor</a></li>
                        </ul>
                    </div>
                    <div class='separator'></div>
                    <div class='footer-block'>
                    </div>
                </div>
                <div id='footer-contakt'>
                    <table style="width: '100%'; height: '100%'">
                        <tr>
                            <td width='60%'>
                                <p class='title-footer-block'>Контакты:</p>
                                <p class='title-footer-block'>
                                    E-mail: skeit.ol@mail.ru<br />
                                    Тел.: 40-581-358<br />
                                    Адресс: г.Чебоксары, ул. Поселковая
                                </p>
                                <p class='title-footer-block' style='margin: -9px auto;'>
                                    Соц. сети: <a href="http://vk.com/id16340049" target="_blank">
                                        <img src="images/vk.png" />
                                    </a><a href="http://www.facebook.com/skeit.ol" target="_blank">
                                        <img src="images/fb.png" />
                                    </a>
                                </p>
                            </td>
                            <td width='40%'>
                                <center> <img src='images/S.ico' alt='SkeitOL Soft' height='50px' width='50px'></center>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class='downfotter'>©SkeitOL 2013</div>
            </div>

        </div>
    </div>
    <!--UpButton-->
    <script type="text/javascript" src="js/jquery-1.8.3.js"></script>
    <style>
        #upbutton {
            width: 25px;
            position: fixed;
            height: 100%;
            z-index: 100;
            top: 0;
            left: 0;
        }

            #upbutton:hover {
                background: #000;
                opacity: 0.3;
            }

            #upbutton img {
                opacity: 0.6;
            }
    </style>
    <div id="upbutton">
        <img src="images/up.gif" width="14" height="32" style="margin: 5px;" />
    </div>
    <script>
        $(document).ready(function () {
            // hide #back-top first
            $("#upbutton").hide();
            // fade in #back-top
            $(function () {
                $(window).scroll(function () {
                    if ($(this).scrollTop() > 80) {
                        $('#upbutton').fadeIn();
                    } else {
                        $('#upbutton').fadeOut();
                    }
                });
                // scroll body to 0px on click
                $('#upbutton').click(function () {
                    $('body,html').animate({
                        scrollTop: 0
                    }, 800);
                    return false;
                });
            });
        });
    </script>
    <!-- End UpButton-->


</body>
</html>
