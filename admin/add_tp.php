<?php
//print_r($_POST);
include("lock.php");

/*New*/
if(!empty($_POST[items]) && !empty($_POST['tp']))
{

	if(!empty($_POST[delet_items]))
	{
		for($i=0; $i < count($_POST[items]); $i++)
		{
			$result= mysql_query("DELETE FROM ".$_POST['tp']." WHERE id='".$_POST[items][$i]."'");
		}
		if($result=='true'){echo "1";}else {echo "-1";}
		
	}
}
/*.New*/

/*OLD*/
if( isset($_POST['activ'])){	
	if($_POST['activ']=="del"){		if(isset($_POST['id'])){		
		foreach($_POST['id'] as $key => $value){			
		$result= mysql_query("DELETE FROM ".$_POST['tp']." WHERE id='".$value."'");		}			
		if($result=='true'){echo "1";}		else {echo "-1";}		}		else echo "0";
	}	
	else{
		if( isset($_POST['title'])){$title=$_POST['title'];if($title==''){unset($title);}}		
		if(isset($_POST['date'])) 		 {$date=$_POST['date'];     if($date==''){unset($date);} }		
		if(isset($_POST['description'])) {$description=$_POST['description'];if($description==''){unset($description);} }		
		if(isset($_POST['text']))        {$text=$_POST['text'];      if($text==''){unset($text);} }		
		if(isset($_POST['author'])) {$author=$_POST['author'];   if($author==''){unset($author);} }		
		if(isset($_POST['url'])) {$author=$_POST['url'];   if($url==''){unset($url);} }
		if(isset($_POST['id'])) 	 {$id=$_POST['id'];   if($id==''){unset($id);} }
		if(isset($_POST['tp'])&&isset($title)&&isset($date)&&isset($description)&&isset($text))		
		{			
			$tp=$_POST['tp'];
			$title = mysql_real_escape_string($title);
			$text = mysql_real_escape_string($text);
			$description = mysql_real_escape_string($description);
			$add_value="";
			$add_key="";
			if($_POST['activ']=="update")	
			{
				if($tp=='articles')
				{
					$string ='';
					if(count($_POST['category_m'])>0){$array = array();$i=0;
					foreach ($_POST['category_m'] as $key=>$value) 
					{$array[$i] = $value;$i++;}
						$string = serialize( $array );
					}
					$add_value.=",category='$string'";
				}
				if(!empty($_POST[meta_description]))$add_value.=",meta_description='".mysql_real_escape_string($_POST[meta_description])."'";
				if(!empty($_POST[meta_keywords]))$add_value.=",meta_keywords='".mysql_real_escape_string($_POST[meta_keywords])."'";
				
				if(!empty($_POST[active_p_bool]))
					if(!empty($_POST[active_p]))$add_value.=",active='1'";
					else $add_value.=",active='0'";
					
				if(!empty($_POST[url]))$add_value.=",url='".mysql_real_escape_string($_POST[url])."'";
				if(!empty($_POST[author]))$add_value.=",author='".mysql_real_escape_string($_POST[author])."'";
				if(!empty($_POST[src_preview]))$add_value.=",src_preview='".mysql_real_escape_string($_POST[src_preview])."'";
				
				$result= mysql_query("UPDATE $tp SET title='$title',date='$date',description='$description',text='$text'".$add_value." WHERE id='$id'");
			}
			else 
				if($_POST['activ']=="add"){
					if($tp=='articles'){
						$string ='';
						if(count($_POST['category_m'])>0){$array = array();$i=0;
						foreach ($_POST['category_m'] as $key=>$value) 
						{$array[$i] = $value;$i++;}
						$string = serialize( $array );
						}
						$add_value.=",'$string'";$add_key.=",category";
					}
					if(!empty($_POST[meta_description])){$add_key.=",meta_description";$add_value.=",'".mysql_real_escape_string($_POST[meta_description])."'";}
					if(!empty($_POST[meta_keywords])){$add_key.=",meta_keywords";$add_value.=",'".mysql_real_escape_string($_POST[meta_keywords])."'";}
					if(!empty($_POST[active_p_bool]))
						if(!empty($_POST[active_p])){$add_key.=",active";$add_value.=",'1'";}
						else {$add_key.=",active";$add_value.=",'0'";}
					
					if(!empty($_POST[url])){$add_key.=",url";$add_value.=",'".mysql_real_escape_string($_POST[url])."'";}
					if(!empty($_POST[author])){$add_key.=",author";$add_value.=",'".mysql_real_escape_string($_POST[author])."'";}
					if(!empty($_POST[src_preview])){$add_key.=",src_preview";$add_value.=",'".mysql_real_escape_string($_POST[src_preview])."'";}
					
					$result=mysql_query("INSERT INTO $tp (title,date,description,text".$add_key.") VALUES ('$title','$date','$description','$text'".$add_value.")");	
				}
			if($result)echo "1";
			else {
				echo "-1";
				$message  = 'Неверный запрос: ' . mysql_error() . "\n";
				$message .= 'Запрос целиком: ' . $query;
				die($message);
			}
		}	
		else echo "0";	
	}	
}else exit();?>