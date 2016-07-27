<?
if(!empty($_POST[tp]))
{
	if(!empty($_POST[name])&&isset($_POST[price])&&isset($_POST[sizes]))
	{
		include("../blocks/bd.php");		
		$t1='';
		$t2='';
		if($_POST[tp]=='add'){
			if(!empty($_POST[check_old_price])){
				$t1.=',old_price';
				$t2.=",'$_POST[old_price]'";
			}
			if(!empty($_POST[img])){
				$t1.=',img';
				$t2.=",'$_POST[img]'";
			}
			if(!empty($_POST['sort'])){
				$t1.=',sort';
				$t2.=",'$_POST[sort]'";
			}
			if(!empty($_POST['check_new'])){
				$t1.=',new';
				$t2.=",'$_POST[check_new]'";
			}
			$result=mysql_query("INSERT INTO products (name,price,sizes$t1) VALUES ('$_POST[name]','$_POST[price]','$_POST[sizes]'$t2)");
		}
		else if($_POST[tp]=='update')
		{
			if(!empty($_POST[check_old_price])){				
				$t1.=",old_price='$_POST[old_price]'";
			}
			if(!empty($_POST[img])){
				$t1.=",img='$_POST[img]'";				
			}
			if(!empty($_POST['sort'])){
				$t1.=",sort='$_POST[sort]'";
			}
			if(!empty($_POST['check_new'])){
				$t1.=",new='$_POST[check_new]'";
			}
			//echo"t1=$t1";
			$result= mysql_query("UPDATE products SET name='$_POST[name]',sizes='$_POST[sizes]',price='$_POST[price]'$t1 WHERE id='$_POST[id]'");
		}
		if($result)
		{
			header("Location: index.php");
		}
		else {
			$message  = 'Неверный запрос: ' . mysql_error() . "\n";
			$message .= 'Запрос целиком: ' . $query;
			die($message);
		}
	}
}
?>