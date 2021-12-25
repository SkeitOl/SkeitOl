<?php
/**
 * Created by PhpStorm.
 * User: oem
 * Date: 05.09.16
 * Time: 22:54
 */?>
<!DOCTYPE html>
<html lang="ru" class="no-js">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=$title?></title>
    <meta name="author" content="SkeitOl" />
    <link rel="shortcut icon" href="<?=SITE_DIR?>favicon.ico">
    <link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/bc/css/normalize.css" />
    <link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/bc/fonts/font-awesome-4.3.0/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/bc/css/style1.css" />
    <link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,700,600" rel="stylesheet" type="text/css">
    <script  src="<?=SITE_TEMPLATE_PATH?>/bc/js/modernizr.custom.js"></script>
</head>
<body>
<div class="container">
    <button id="menu-toggle" class="menu-toggle"><span>Menu</span></button>
    <div id="theSidebar" class="sidebar">
        <button class="close-button fa fa-fw fa-close"></button>
        <img src="/images/favicon/apple-touch-icon-57x57.png" alt="">
        <h1><span>Статьи</span></h1>
        <div class="related">
            <h3>Другие разделы:</h3>
            <a href="/articles/">Статьи</a>
            <a href="/news/">Новости</a>
            <a href="/programs/">Программы</a>
            <a href="/programs/">О нас</a>
            <a href="/programs/">Карта сайта</a>
            <a href="/programs/">Условия использования<br>информации</a>
        </div>
    </div>
    <div id="theGrid" class="main">