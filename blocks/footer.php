<?
if($_SERVER['REQUEST_URI']=="/")// ||$_SERVER['REQUEST_URI']=="" || $_SERVER['REQUEST_URI']=="index.php"|| empty($_SERVER['REQUEST_URI']))
{
	include_once("footer_index.php");
}
else{
    $long_footer=true; include("footer_new.php");
}