<?php
include("lock.php");
if(isset($_POST['id'])) {$id=$_POST['id']; if($id==''){unset($id);}}
if(isset($id))
{
    $result= mysql_query("DELETE FROM programm WHERE id='$id'");
    if($result=='true'){echo "<p>Данные удалены</p>";}
    else {echo "<p> Ошибка удаления</p>";}
}
else echo "<p>������� �� ��� ����������</p>";
      ?>