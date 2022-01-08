$( document ).ready(function() {
	initEventPage();
});

function initEventPage(){
	$("#load_articles").click(function(){
		var list=$(this).attr("data-list");$(this).attr("data-list",parseInt(list)+1);
		$.ajax({url:"/ajax_articles.php",data:{list:list,type:"ajax_ls_only"},
				beforeSend: function(){
					$("#preload_list_articles").css("display","inline-block");
					$("#load_articles").css("display","none");
				},
				complete:function(event){
					//console.log(event);
					if(event.statusText==="success"){
						if(event.responseText.length>0){
							setTimeout(function(){
								$("#list_block").html($("#list_block").html()+event.responseText);
								$("#preload_list_articles").css("display","none");
								$("#load_articles").css("display","inline-block");
								pagePreload.lazyLoad();
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

	$(".ajax_nav_links").click(function(){
			var list=$(this).attr("data-list");
			$.ajax({url:"/ajax_articles.php",data:"list="+list,
					beforeSend: function(){
						$("#preload_list_articles").css("display","inline-block");
						$("#load_articles").css("display","none");
					},
					complete:function(event){
						//console.log(event);
						if(event.statusText==="success"){
							if(event.responseText.length>0){
								setTimeout(function(){
									$("#con_block_item").html(event.responseText);
									initEventPage();
									//window.location.href =;
									history.pushState('', '', '/articles/?list='+list);
									scrollToElement("con_block_item");
									pagePreload.lazyLoad();
									//$("#preload_list_articles").css("display","none");
									//$("#load_articles").css("display","inline-block");
								},500);
							}else{$("#load_articles, #preload_list_articles").css("display","none");}
						}
						else{
							$("#load_articles").html("Ошибка загрузки");$("#preload_list_articles").css("display","none");$("#load_articles").css("display","inline-block");
						}
					}
				}
			);
			return false;
		}
	);
}

function scrollToElement(idElement) {
/*
	var theElement= document.getElementById("idElement");
	var selectedPosX = 0;
	var selectedPosY = 0;

	while (theElement != null) {
		selectedPosX += theElement.offsetLeft;
		selectedPosY += theElement.offsetTop;
		theElement = theElement.offsetParent;
	}

	window.scrollTo(selectedPosX,selectedPosY);*/
	var destination =$("#"+idElement).offset().top;
	if ($.browser.safari) {
		$('body').animate({ scrollTop: destination }, 500);
	} else {
		$('html').animate({ scrollTop: destination }, 500);
	}
}

function submitS(obj) {

 return false;
}/*
$("#form_add_com").submit(function (e) {
	e.preventDefault();
	$.post($("#form_add_com").attr("action"), $("#form_add_com").find('input,textarea').serialize()
		//$("#form_add_com :input, #form_add_com :textarea").serializeArray()
		, function (info) {
			if(info=="1"){
				$("#form_add_com").remove();
				$("#res_comm").html("<span class='text_good'>После проверки сообщения модератором оно будет добавленно.</span>");}
			else {$("#res_comm").html(info);	grecaptcha.reset();}
		});
});*/
function ShowHideElement (id) {
	$(id).slideToggle();
	/*
	if($(id).css("display")=="none")
		$(id).css("display","block");
	else $(id).css("display","none");*/
}
function initArticlesEvent(){
	$("#submit_comment").click(function(){
		if($("#com_nick").val().length==0){
			$("#res_comm").html("<span class='text_error'>Имя пусто!</span>").show();
			$("#com_nick").css({"border":"1px solid red","box-shadow":"0 0 3px red"});
			setTimeout(function(){$("#com_nick").removeAttr("style");$("#res_comm").hide();}, 3000);
			return false;
		}else if($("#com_text").val().length==0){
			$("#res_comm").html("<span class='text_error'>Сообщение пусто!</span>").show();
			$("#com_text").css({"border":"1px solid red","box-shadow":"0 0 3px red"});
			setTimeout(function(){$("#com_text").removeAttr("style");$("#res_comm").hide();}, 3000);
			return false;
		}
		const $form=$("#form_add_com");
		$.post($form.attr("action"), $form.serializeArray()//$("#form_add_com :input, #form_add_com :textarea").serializeArray()
			, function (result) {
				if (result) {
					if (!result.status || (result.status && result.status !== 'ok')) {
						$("#res_comm").html("<span class='text_error'>" + result.message + "</span>");
					} else {
						$("#res_comm").html("<span class='text_good'>" + result.message + "</span>");
						$form[0].reset();
					}
				} else {
					$("#res_comm").html("<span class='text_good'>Ошибка отправки запроса</span>");
				}
				grecaptcha.reset();
			});
	});
}
/*
jQuery(document).ready(function(){
	// Скрываем все спойлеры
	jQuery('.spoiler-body').hide(300);
	jQuery('.spoiler-head').click(function(){
		$(this).parents('.spoiler-wrap')
		.toggleClass("active")
		.find('.spoiler-body').slideToggle();
	})
})*/
$(function () {
	$('.spoiler-body').hide(300);
	$(document).on('click','.spoiler-head',function (e) {
		e.preventDefault()
		$(this).parents('.spoiler-wrap').toggleClass("active").find('.spoiler-body').slideToggle();
	})
})