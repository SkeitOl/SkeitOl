<head>
	<title><?echo(!empty($sys_title))?$sys_title:"SkeitOl - Soft";?></title>
	<meta name="description" content="<?echo $sys_description;?>">
	<meta name="keywords" content="<?echo $sys_keywords;?>">
	<meta name="author" content="SkeitOl">
	<meta name="copyright" content="Все права принадлежат SkeitOl">
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="Stylesheet" type="text/css" href="style.css?005" />
	
	<link rel="shortcut icon" href="<?echo "http://".$_SERVER['HTTP_HOST']."/";?>/favicon.ico?001" type="image/x-icon" />

	<!--<script src="script/jquery-1.8.3.js"></script>-->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	
	
	
	<?if(!empty($sys_special_head_text))echo $sys_special_head_text;?>
</head>