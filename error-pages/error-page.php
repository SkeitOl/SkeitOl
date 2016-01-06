<!DOCTYPE>
<?php
    $error="0";
    $text="";
 if(isset($_GET['error']))
 {
 $error= $_GET['error'];
 switch($error)
 {
 case "404":
    $text="Страница не найдена";
    $help="Сервер понял запрос, но не нашёл соответствующего ресурса по указанному URI.";
 break;
 case "400":
    $text="Bad Request";
    $help="Bad Request";
 break;
 case "403":
    $text="Запрещено";
    $help="Запрещено скачивать файлы с сервера.";
 break;
 case "503":
    $text="Сервис недоступен";
    $help="Сервис временно недоступен";
 break;
 case "401":
    $text="Unauthorized";
    $help="Unauthorized";
 break;
 };
 }
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Error <?php echo $error ?></title>
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
    <style>
        h1 {
            font-family: Calibri;
            color: #ff6a00;
            text-align: center;
            font-size: 88px;
        }

        h2 {
            color: #f00;
            font-size: 30px;
            font-family: Calibri, 'Century Gothic','Angsana New';
            text-align: center;
        }

        #f1-span {
            color: #1b9a2c;
            font-size: 20px;
            text-decoration: dashed;
            
        }

        a {
            color: #0026ff;
            text-decoration: dotted;
            font-size: 16px;
        }
    </style>
    <h2>Ooops</h2>
    <h1><? echo $error;?></h1>
    <h2><?echo $text;?></h2>
    <div style="text-align: center">
        <span id="f1-span" onclick="Click_f1span()">Справка</span>

        <script>
            function Click_f1span() {
                if (document.getElementById('f1-span').innerHTML == "Справка") {
                    document.getElementById('f1-span').style.textDecoration = "none";

                    document.getElementById('f1-span').innerHTML = "<? echo $help;?>";
                }
            }
        </script>
        <p style="font-size: 18px;">
            <a href="javascript:history.back()">Вернуться назад</a>
        </p>
        <p style="font-size: 18px;">
            <a href="../index.php">Начать с начала</a>
        </p>
    </div>
</body>
</html>