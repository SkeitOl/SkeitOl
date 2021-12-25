<?php

//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);

use SkeitOl\DBArticles;

require_once($_SERVER["DOCUMENT_ROOT"]."/skeitol/header.php");
?>
<pre>
<?php
//$DB_ART=new DBArticles();
//$result = mysql_query("SELECT * FROM articles WHERE id=$id AND active=1", $db);
//var_dump($SketOl->GetList(DBArticles::$DB_NAME,array("id"),array("id"=>136,"active"=>1)));
//var_dump($SketOl->GetList(DBArticles::$DB_NAME,array("select"=>array("id","views"),"filter"=>array(">=id"=>130,    "active"=>1),"limit"=>array("top"=>5,"bottom"=>7))));
?>
</pre>
<?
DBArticles::ArticlesList(array(
    "SELECT_CODE"=>array("*"),
    "COUNT"=>3,
//    "SORT_BY"=>"desc",
//    "SORT_ORDER"=>"url",
    //"FILTER"=>array("id"=>array(84,97))
));
?>
	<script charset="utf-8" type="text/javascript" src="//js.hsforms.net/forms/shell.js"></script>
	<script>
		hbspt.forms.create({
			portalId: "4534508",
			formId: "7bb979eb-61bd-4626-be73-aa04b11f85da"
		});
	</script>

	<!-- Start of HubSpot Embed Code -->
	<script type="text/javascript" id="hs-script-loader" async defer src="//js.hs-scripts.com/4534508.js"></script>
	<!-- End of HubSpot Embed Code -->


<div>
	<?php
	//Process a new form submission in HubSpot in order to create a new Contact.

	/*$hubspotutk      = $_COOKIE['hubspotutk']; //grab the cookie from the visitors browser.
	$ip_addr         = $_SERVER['REMOTE_ADDR']; //IP address too.
	$hs_context      = array(
		'hutk' => $hubspotutk,
		'ipAddress' => $ip_addr,
		'pageUrl' => 'https://skeitol.ru/article2/',
		'pageName' => 'Example Title'
	);
	$hs_context_json = json_encode($hs_context);

	$firstname="Test API".date('c');
	$email="test@mail.ru";
	$industry='industry Test';

	//Need to populate these variable with values from the form.
	$str_post = "firstname=" . urlencode($firstname)
		//. "&lastname=" . urlencode($lastname)
		. "&email=" . urlencode($email)
		. "&industry=" . urlencode($industry);
		//. "&phone=" . urlencode($phonenumber)
		//. "&company=" . urlencode($company)
		//. "&hs_context=" . urlencode($hs_context_json); //Leave this one be

	$portalId=4534508;
	$formGuid="7bb979eb-61bd-4626-be73-aa04b11f85da";

	//replace the values in this URL with your portal ID and your form GUID
	$endpoint = "https://forms.hubspot.com/uploads/form/v2/{$portalId}/{$formGuid}";

	$ch = @curl_init();
	@curl_setopt($ch, CURLOPT_POST, true);
	@curl_setopt($ch, CURLOPT_POSTFIELDS, $str_post);
	@curl_setopt($ch, CURLOPT_URL, $endpoint);
	@curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/x-www-form-urlencoded'
	));
	@curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response    = @curl_exec($ch); //Log the response from HubSpot as needed.
	$status_code = @curl_getinfo($ch, CURLINFO_HTTP_CODE); //Log the response status code
	@curl_close($ch);
	echo $status_code . " " . $response;*/

	?>
</div>

<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/skeitol/footer.php");
?>