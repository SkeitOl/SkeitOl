<?/*<div class='small-block'>	
	<div class='title-small-block'><a href="programm.php">Программы</a></div>	
		<div class='pr'>		
			<noidex>
			<ul>			
			<?php $result = mysql_query("SELECT id,title FROM programm ORDER BY id DESC LIMIT 0,3",$db);	  			$myrow=mysql_fetch_array($result);				do			{				printf("				<img src='/images/anim/%s.gif' alt='%s' widht=15px height=15px  align=left />				<li><a href='/program/%s/'>%s</a></li>",strtolower($myrow['title']),$myrow['title'],mb_strtolower($myrow['title']),$myrow['title']);			}			while($myrow=mysql_fetch_array($result))?>		</ul>
			</noidex>
		</div>
</div>
<div class='small-block'>
    <noidex>
    <div class='title-small-block'>Популярные категории:</div>
        <div class='top-articles'>
            <a href='/articles/?category=14'><img src='/images/articles/C_Sharp.png' /></a>
            <a href='/articles/?category=17'><img src='/images/articles/java_logo.png' /></a>
            <a href='/articles/?category=23'><img src='/images/articles/php_logo.jpg' /></a>
            <a href='/articles/?category=8'><img src='/images/articles/windows-8-logo.png' /></a>
        </div>
    </noidex>
</div>
*/?>
<div class='small-block'>
    <noidex>
    <div class='title-small-block'>Популярные категории:</div>
        <div class='top-articles'>
            <a href='/articles/?category=14'><span class="sml_bl_item"><span class="sml_bl_item_con" style="background-image:url('/images/articles/C_Sharp.png')"></span></span></a>
            <a href='/articles/?category=17'><span class="sml_bl_item"><span class="sml_bl_item_con" style="background-image:url('/images/articles/java_logo.png')"></span></span></a>
			<a href='/articles/?category=23'><span class="sml_bl_item"><span class="sml_bl_item_con" style="background-image:url('/images/articles/php_logo.jpg')"></span></span></a>
            <a href='/articles/?category=8'><span class="sml_bl_item"><span class="sml_bl_item_con" style="background-image:url('/images/articles/windows-8-logo.png')"></span></span></a>
        </div>
	</noidex>
</div>
 <div class="small-block" <?if(!isset($_GET['show_test']))echo'style="display:none"';?>>
        <noidex>
        <h4>Фильтр</h4>
        <style>
            .filter_bl{overflow: hidden;list-style-type:none;width:100%;padding:0;margin:0;}
            .filter_bl .item{ display:block;margin:0;padding:0;font-size:0.75rem;
    
    vertical-align: top;
    word-wrap: break-word;
    word-break: break-word;
    line-height: normal;
            }
            .filter_bl .item p{margin:5px 0;padding: 0;vertical-align: top;}
            .filter_bl .item label{padding-left: 10px;}
            *{-webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;}
        </style>
        
        <div>
            <div class="filter_bl">
                <?$result1 = mysql_query("SELECT * FROM category", $db);
                $row1 = mysql_fetch_array($result1);
                do
                {?>
                    <div class="item">
                        <p><input class="filter_check" id="filter-ct-<?=$row1['id']?>" name="filter[]" value="ct-<?=$row1['id']?>" type="checkbox"><label for="filter-ct-<?=$row1['id']?>"><?=$row1['name']?></label></p>
                    </div>
                    
                <?}

                while ($row1 = mysql_fetch_array($result1));?>
                <!-- 
                    
                    <a href='/articles/?category="<?=$row1['id']?>' title='<?=$row1['name']?>'><?=$row1['name']?></a> -->
            </div>
        </div>
        <script>
            window.onload= function(){
                $( ".filter_check" ).change(function() {
                    var en="1";
                    if(!this.checked){en="0";}
                    id=$(this).attr('id');
                    console.log("id="+id+"\nen="+en);

                    $.ajax({
                      method: "POST",
                      url: "/articles_ajax.php",
                      data: {filter:id}
                    })
                      .done(function( msg ) {
                        $("#list_block" ).html(msg);
                        //alert(msg);
                      });
                });
                };
        </script>
        </noidex>
    </div>

<div class='small-block'>	
	<div class='title-small-block'><a href="/articles/">Последние статьи</a></div>
	<noidex><ul class="list-right-blocks"><?php
	$st='';
			if (isset($id)) {$st=' AND id<>'.$id;}
		$result = mysql_query("SELECT id,title,url FROM articles WHERE active=1 ".$st." ORDER BY id DESC LIMIT 0,4",$db);
		$myrow=mysql_fetch_array($result);do{
		if(!empty($myrow['url']))$url_page=$myrow['url'];else $url_page=$myrow['id'];
		printf("<li><a href='/articles/%s/'>%s</a></li>",$url_page,$myrow['title']);}while($myrow=mysql_fetch_array($result))?></ul></noidex>
</div>

<div class='small-block'>
	<div class='title-small-block'>Тэги</div><noidex>
<?
//Все категории
                            /*echo"
                            <script type='text/javascript'>
    function diplay_hide() {
        if ($('#block_id').css('display') == 'none')
            $('#block_id').animate({ height: 'show' }, 400);
        else
            $('#block_id').animate({ height: 'hide' }, 400);
    }
</script>
<p><span class='links'><a href='#'onclick='diplay_hide();return false;'><b></b></a></span></p>
<div id='block_id'>";*/
        echo"<div class='category-view'>
            <p style='border-left: 3px #57AA43 solid;padding-left: 10px;text-indent: 0px;'>";
        $result1 = mysql_query("SELECT * FROM category", $db);
        $row1 = mysql_fetch_array($result1);
        do
        {
            echo "<a href='/articles/?category=" . $row1['id'] . "' title='" . $row1['name'] . "'>" . $row1['name'] . "</a>";
        }
        while ($row1 = mysql_fetch_array($result1));
        echo"</p>
            </div>
        </div>";
        // 
?>
	</noidex>

</div>
