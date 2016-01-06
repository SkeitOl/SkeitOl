$( document ).ready(function() {
   $("#load_articles").click(function(){
               var list=$(this).attr("data-list");$(this).attr("data-list",parseInt(list)+1);
               $.ajax({url:"/ajax_articles.php",data:"list="+list,
            	beforeSend: function(){
                	$("#preload_list_articles").css("display","inline-block");
            		$("#load_articles").css("display","none");
               },
               complete:function(event){
                     console.log(event);
               		if(event.statusText=="OK"){
                        if(event.responseText.length>0){
                  			setTimeout(function(){
                  				$("#list_block").html($("#list_block").html()+event.responseText);
                  				$("#preload_list_articles").css("display","none");
                  				$("#load_articles").css("display","inline-block");
                  			},500);
                        }else{$("#load_articles, #preload_list_articles").css("display","none");}
               		}
               		else{
               			$("#load_articles").html("Ошибка загрузки");$("#preload_list_articles").css("display","none");$("#load_articles").css("display","inline-block");
               		}
               		
               		//console.log(event);
               	},/*,
            	success:function(data){
            		if(data.length>0){
            		
            		setTimeout(function(data){
            			if(data){
            				$("#list_block").html($("#list_block").html()+data);
            				$("#load_articles").css("display","inline-block");
            			}
            			$("#preload_list_articles").css("display","none");
            		},1000);
            	
            	}*/

            	}
            );
            });
$(".show_all_text_desc").click(function(){$(this).parent().parent().removeClass("short_comment_text");$(this).remove();});
});