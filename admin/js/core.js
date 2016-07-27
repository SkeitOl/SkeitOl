/*Calendar*/
$(document).ready(function(){$("#calendar").simpleDatepicker();  // Привязать вызов календаря к полю с CSS идентификатором #calendar
});
/*Tabs*/
$(document).ready(function() {
	//Когда страница загружается...
	$(".tab_content").hide(); //Скрыть весь контент
	$("ul.tabs li:first").addClass("active").show(); //Активировать первую вкладку
	$(".tab_content:first").show(); //Показать контент первой вкладки
	//Событие по клику
	$("ul.tabs li").click(function() {
		$("ul.tabs li").removeClass("active"); //Удаление любого "active" класса
		$(this).addClass("active"); //Добавление "active" класса на активную вкладку
		$(".tab_content").hide(); //Скрыть контент вкладок
		var activeTab = $(this).find("a").attr("href"); //Найти href значение атрибута для выявления активной вкладки и контента
		$(activeTab).fadeIn(); //Fade in контента с активным ID
		return false;
	});
});
/*блокировка Ctr+s*/
$(document).bind("keydown", function(e) {
  if(e.ctrlKey && (e.which == 83)) {
	e.preventDefault();
	{
		//alert("Ctrl+S");
		Save_Page();
	}
	return false;
  }
});
/*Вставка html в richtextbox*/
function htmlInBig(el,startTag,endTag){return el.value.substring(0,el.selectionStart)+startTag+el.value.substring(el.selectionStart,el.selectionEnd)+endTag+el.value.substring(el.selectionEnd);}
function add_html_box(char) {
	var textarea = document.getElementById("text-box");
	textarea.focus();

	switch (char) {
		case "b": textarea.value=htmlInBig(textarea,"<strong>","</strong>"); break;
		case "p": textarea.value=htmlInBig(textarea,"<p>","</p>"); break;
		case "img": textarea.value += "<img src=\'\'/>"; break;
		case "a": textarea.value=htmlInBig(textarea,"<a href=\'\' class=\'link\'>","</a>"); break;
		case "a-out": textarea.value=htmlInBig(textarea,"<a href=\'\' target=\'_blank\' class=\'link-out\'>","</a>"); break;
		case "h1": textarea.value=htmlInBig(textarea,"<h1>","</h1>");break;
		case "h2": textarea.value=htmlInBig(textarea,"<h2>","</h2>"); break;
		case "h3": textarea.value=htmlInBig(textarea,"<h3>","</h3>"); break;
		case "pre": textarea.value=htmlInBig(textarea,"<pre>","</pre>"); break;
	}
}
function ConvertSpecialSharactersToHTML(){
	//function htmlInBig(el,startTag,endTag){
		//return 
		var el = document.getElementById("text-box");
		if(el.selectionStart>=0 && el.selectionEnd>0)
		{
			el.value=el.value.substring(0,el.selectionStart)+ConvertSpecailCharToHTML(el.value.substring(el.selectionStart,el.selectionEnd))+el.value.substring(el.selectionEnd);
		}
		else {alert("Выделите текст для замены");}
		/*alert("selectionStart="+el.selectionStart+
			"\nelectionEnd="+el.selectionEnd);*/
		//el.value.substring(0,el.selectionStart)+startTag+el.value.substring(el.selectionStart,el.selectionEnd)+endTag+el.value.substring(el.selectionEnd);
	//}
	//
}
function ConvertSpecailCharToHTML(mystring){
	return mystring.replace(/&/g, "&amp;").replace(/>/g, "&gt;").replace(/</g, "&lt;").replace(/"/g, "&quot;");
}
function translit(){
	// Символ, на который будут заменяться все спецсимволы
	var space = '_'; 
	// Берем значение из нужного поля и переводим в нижний регистр
	var text = $('#page_name').val().toLowerCase();
	// Массив для транслитерации
	var transl = {
	'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 'е': 'e', 'ё': 'e', 'ж': 'zh', 
	'з': 'z', 'и': 'i', 'й': 'j', 'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n',
	'о': 'o', 'п': 'p', 'р': 'r','с': 's', 'т': 't', 'у': 'u', 'ф': 'f', 'х': 'h',
	'ц': 'c', 'ч': 'ch', 'ш': 'sh', 'щ': 'sh','ъ':'', 'ы': 'y', 'ь':'', 'э': 'e', 'ю': 'yu', 'я': 'ya',
	' ': space, '_': space, '`':'', '~': space, '!': space, '@': space,
	'#': space, '$': space, '%': space, '^': space, '&': space, '*': space, 
	'(': space, ')': space,'-': space, '\=': space, '+': space, '[': space, 
	']': space, '\\': space, '|': space, '/': space,'.': space, ',': space,
	'{': space, '}': space, '\'': space, '"': space, ';': space, ':': space,
	'?': space, '<': space, '>': space, '№':space,'»':space
	};				
	var result = '';
	var curent_sim = '';
					
	for(i=0; i < text.length; i++) {
		// Если символ найден в массиве то меняем его
		if(transl[text[i]] != undefined) {
			 if(curent_sim != transl[text[i]] || curent_sim != space){
				 result += transl[text[i]];
				 curent_sim = transl[text[i]];
															}                                                                             
		}
		// Если нет, то оставляем так как есть
		else {
			result += text[i];
			curent_sim = text[i];
		}                              
	}          
					
	result = TrimStr(result);               
					
	// Выводим результат 
	$('#page_url').val(result); 
	
}
function TrimStr(s) {
	s = s.replace(/^-/, '');
	return s.replace(/-$/, '');
}
// Выполняем транслитерацию при вводе текста в поле
$(function(){
	$("#bt_full").click(function(){
		var panel = $("#text_box_admin");
		if($(panel).attr("data-full")=="0"){
			$(panel).addClass('editor_full_window');
			$(panel).attr("data-full","1");
			$('html').css("overflow","hidden");
			//$('#text-box').css({width:"100%",height:'100%'});
		}else{
			$(panel).removeClass('editor_full_window');
			$(panel).attr("data-full","0");
			$('html').css("overflow","visible");
		}
	});
	$('#page_name').keyup(function(){
		if(IsGenerateURL) translit();
		 return false;
	});
});
/**/
$(function(){
$("#search_in_bd").focus(function(){$("#form_small_search").addClass("small_search_hover")})
.blur(function(){
	$("#form_small_search").removeClass("small_search_hover");
});

	$('#change_preview_img').click(function(){
		$('#new_preview_img').css('display','inline-block');
		$('#new_preview_img').click();
	});
});

/*InfoMessage*/
function showSuccessToast() {$().toastmessage('showSuccessToast', "Успешно");}
function showNoticeToast() {$().toastmessage('showNoticeToast', "Сохранение данных..<br>");}
function showWarningToast() {$().toastmessage('showWarningToast', "Введена не вся информация");}
function showErrorToast() {$().toastmessage('showErrorToast', "Ошибка!<br>");}

/**/
function CreateFolder(mes)
{
	arr = mes.split('?');
	if(arr.length==4)
	{
		var t_type=arr[1];
		var t_id=arr[3];
		$.post("ajax_multimedia.php", {act:"create_folder", type: t_type, id: t_id},function(data){alert("Data Loaded: " + data);});
	}
}