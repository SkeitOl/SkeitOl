<?php
/** @var string $sys_title */
/** @var string $sys_description */
/** @var string $sys_keywords */
?>
<!DOCTYPE>
<html>
<head>
	<title><?= $sys_title ?: 'SkeitOl - Soft' ?></title>
	<meta name="description" content="<?= $sys_description ?: '' ?>">
	<meta name="keywords" content="<?= $sys_keywords ?: '' ?>">
	<meta name="author" content="SkeitOl">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="copyright" content="Все права принадлежат SkeitOl">
	<?/*<link rel="Stylesheet" type="text/css" href="style.css?005"/>*/?>
	<link rel="Stylesheet" type="text/css" href="/admin/css/font-awesome.min.css"/>
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,700,600' rel='stylesheet' type='text/css'>
	<link rel="shortcut icon" href="<?php echo "https://" . $_SERVER['HTTP_HOST'] . "/"; ?>/favicon.ico?001" type="image/x-icon"/>
	<!--<script src="script/jquery-1.8.3.js"></script>-->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">


	<!-- Option 1: Bootstrap Bundle with Popper -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

	<!-- Option 2: Separate Popper and Bootstrap JS -->
	<!--
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
	-->
	<?php
	if (!empty($sys_special_head_text)) {
		echo $sys_special_head_text;
	}
	?>
</head>