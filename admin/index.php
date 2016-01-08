<?header('Content-Type: text/html; charset= utf-8');
/*ini_set("display_errors",1);
error_reporting(E_ALL);*/

	include("lock.php");
	include("blocks/bd.php");
    if( isset($_POST['act'])){$act=$_POST['act'];if($act=='')unset($act);}
    if(!isset($act)){if( isset($_GET['act'])){$act=$_GET['act'];if($act=='')unset($act);}}
	if( isset($_POST['tp'])){$tp=$_POST['tp'];if($tp=='')unset($tp);}
    if(!isset($tp)){if( isset($_GET['tp'])){$tp=$_GET['tp'];if($tp=='')unset($tp);}}
	session_start();
	if(isset($_SESSION['step'])&&(!empty($_SESSION['step'])))
		$step=$_SESSION['step'];
	else $step=10;
	if(isset($_GET['step'])){
		$step=$_GET['step'];
		$_SESSION['step']=$step;
	}
//Глобальные настройки
$DEFAULT_AUTHOR="SkeitOl";
?><!DOCTYPE>
<html>
	<?php 
	$sys_description="Панель администратора CMS SkeitOl-Soft";
	$sys_keywords="Панель администратора SkeitOl, SkeitOl - Soft, SkeitOl,CMS SkeitOl Soft";
	$sys_pages="admin";
	$sys_pages_print="Панель администратора";
	$sys_title="Панель администрирования CMS SkeitOl-Soft";
	$sys_special_head_text=@'
	<link rel="Stylesheet" type="text/css" href="cal.css?01" />
	 <!-- Message-->
	 <script src="script/jquery.toastmessage.js?01"></script>
	 <link rel="Stylesheet" type="text/css" href="css/jquery.toastmessage.css?01" />
	 <!-- End Message-->
	 <!-- Chose-->
	 <link rel="stylesheet" href="chosen/chosen.min.css?01">
	 <!-- End Chose-->
	 <script src="script/cal.js?01"></script>
	 <script type="text/javascript">
		$(document).ready(function(){
		$("#calendar").simpleDatepicker();  // Привязать вызов календаря к полю с CSS идентификатором #calendar
		});
		
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
		});/*End блокировка Ctr+s*/	
		
		/*Вставка html в richtextbox*/
		function add_html_box(char) {
			var textarea = document.getElementById("text-box");
			textarea.focus();

			switch (char) {
				case "b": textarea.value=htmlInBig(textarea,"<b>","</b>"); break;
				case "p": textarea.value=htmlInBig(textarea,"<p>","</p>"); break;
				case "img": textarea.value += "<img src=\'\'/>"; break;
				case "a": textarea.value=htmlInBig(textarea,"<a href=\'\' class=\'link\'>","</a>"); break;
				case "a-out": textarea.value=htmlInBig(textarea,"<a href=\'\' target=\'_blank\' class=\'link-out\'>","</a>"); break;
				case "h1": textarea.value=htmlInBig(textarea,"<h1>","</h1>");break;
				case "h2": textarea.value=htmlInBig(textarea,"<h2>","</h2>"); break;
				case "h3": textarea.value=htmlInBig(textarea,"<h3>","</h3>"); break; 
			}
		}
		function htmlInBig(el,startTag,endTag){
			return el.value.substring(0,el.selectionStart)+startTag+el.value.substring(el.selectionStart,el.selectionEnd)+endTag+el.value.substring(el.selectionEnd);
		}
	</script>
	<style>

		.text-input{width:90%;padding:3px;max-width:600px;height:2em;}
	</style>
	';
	include('blocks/head.php'); 
?><body>
<script>
/**
 * Ajax upload
 * Project page - http://valums.com/ajax-upload/
 * Copyright (c) 2008 Andris Valums, http://valums.com
 * Licensed under the MIT license (http://valums.com/mit-license/)
 * Version 3.5 (23.06.2009)
 */

/**
 * Changes from the previous version:
 * 1. Added better JSON handling that allows to use 'application/javascript' as a response
 * 2. Added demo for usage with jQuery UI dialog
 * 3. Fixed IE "mixed content" issue when used with secure connections
 * 
 * For the full changelog please visit: 
 * http://valums.com/ajax-upload-changelog/
 */

(function(){
	
var d = document, w = window;

/**
 * Get element by id
 */	
function get(element){
	if (typeof element == "string")
		element = d.getElementById(element);
	return element;
}

/**
 * Attaches event to a dom element
 */
function addEvent(el, type, fn){
	if (w.addEventListener){
		el.addEventListener(type, fn, false);
	} else if (w.attachEvent){
		var f = function(){
		  fn.call(el, w.event);
		};			
		el.attachEvent('on' + type, f)
	}
}


/**
 * Creates and returns element from html chunk
 */
var toElement = function(){
	var div = d.createElement('div');
	return function(html){
		div.innerHTML = html;
		var el = div.childNodes[0];
		div.removeChild(el);
		return el;
	}
}();

function hasClass(ele,cls){
	return ele.className.match(new RegExp('(\\s|^)'+cls+'(\\s|$)'));
}
function addClass(ele,cls) {
	if (!hasClass(ele,cls)) ele.className += " "+cls;
}
function removeClass(ele,cls) {
	var reg = new RegExp('(\\s|^)'+cls+'(\\s|$)');
	ele.className=ele.className.replace(reg,' ');
}

// getOffset function copied from jQuery lib (http://jquery.com/)
if (document.documentElement["getBoundingClientRect"]){
	// Get Offset using getBoundingClientRect
	// http://ejohn.org/blog/getboundingclientrect-is-awesome/
	var getOffset = function(el){
		var box = el.getBoundingClientRect(),
		doc = el.ownerDocument,
		body = doc.body,
		docElem = doc.documentElement,
		
		// for ie 
		clientTop = docElem.clientTop || body.clientTop || 0,
		clientLeft = docElem.clientLeft || body.clientLeft || 0,
		
		// In Internet Explorer 7 getBoundingClientRect property is treated as physical,
		// while others are logical. Make all logical, like in IE8.
		
		
		zoom = 1;
		if (body.getBoundingClientRect) {
			var bound = body.getBoundingClientRect();
			zoom = (bound.right - bound.left)/body.clientWidth;
		}
		if (zoom > 1){
			clientTop = 0;
			clientLeft = 0;
		}
		var top = box.top/zoom + (window.pageYOffset || docElem && docElem.scrollTop/zoom || body.scrollTop/zoom) - clientTop,
		left = box.left/zoom + (window.pageXOffset|| docElem && docElem.scrollLeft/zoom || body.scrollLeft/zoom) - clientLeft;
				
		return {
			top: top,
			left: left
		};
	}
	
} else {
	// Get offset adding all offsets 
	var getOffset = function(el){
		if (w.jQuery){
			return jQuery(el).offset();
		}		
			
		var top = 0, left = 0;
		do {
			top += el.offsetTop || 0;
			left += el.offsetLeft || 0;
		}
		while (el = el.offsetParent);
		
		return {
			left: left,
			top: top
		};
	}
}

function getBox(el){
	var left, right, top, bottom;	
	var offset = getOffset(el);
	left = offset.left;
	top = offset.top;
						
	right = left + el.offsetWidth;
	bottom = top + el.offsetHeight;		
		
	return {
		left: left,
		right: right,
		top: top,
		bottom: bottom
	};
}

/**
 * Crossbrowser mouse coordinates
 */
function getMouseCoords(e){		
	// pageX/Y is not supported in IE
	// http://www.quirksmode.org/dom/w3c_cssom.html			
	if (!e.pageX && e.clientX){
		// In Internet Explorer 7 some properties (mouse coordinates) are treated as physical,
		// while others are logical (offset).
		var zoom = 1;	
		var body = document.body;
		
		if (body.getBoundingClientRect) {
			var bound = body.getBoundingClientRect();
			zoom = (bound.right - bound.left)/body.clientWidth;
		}

		return {
			x: e.clientX / zoom + d.body.scrollLeft + d.documentElement.scrollLeft,
			y: e.clientY / zoom + d.body.scrollTop + d.documentElement.scrollTop
		};
	}
	
	return {
		x: e.pageX,
		y: e.pageY
	};		

}
/**
 * Function generates unique id
 */		
var getUID = function(){
	var id = 0;
	return function(){
		return 'ValumsAjaxUpload' + id++;
	}
}();

function fileFromPath(file){
	return file.replace(/.*(\/|\\)/, "");			
}

function getExt(file){
	return (/[.]/.exec(file)) ? /[^.]+$/.exec(file.toLowerCase()) : '';
}			

// Please use AjaxUpload , Ajax_upload will be removed in the next version
Ajax_upload = AjaxUpload = function(button, options){
	if (button.jquery){
		// jquery object was passed
		button = button[0];
	} else if (typeof button == "string" && /^#.*/.test(button)){					
		button = button.slice(1);				
	}
	button = get(button);	
	
	this._input = null;
	this._button = button;
	this._disabled = false;
	this._submitting = false;
	// Variable changes to true if the button was clicked
	// 3 seconds ago (requred to fix Safari on Mac error)
	this._justClicked = false;
	this._parentDialog = d.body;
	
	if (window.jQuery && jQuery.ui && jQuery.ui.dialog){
		var parentDialog = jQuery(this._button).parents('.ui-dialog');
		if (parentDialog.length){
			this._parentDialog = parentDialog[0];
		}
	}			
					
	this._settings = {
		// Location of the server-side upload script
		action: 'upload.php',			
		// File upload name
		name: 'userfile',
		// Additional data to send
		data: {},
		// Submit file as soon as it's selected
		autoSubmit: true,
		// The type of data that you're expecting back from the server.
		// Html and xml are detected automatically.
		// Only useful when you are using json data as a response.
		// Set to "json" in that case. 
		responseType: false,
		// When user selects a file, useful with autoSubmit disabled			
		onChange: function(file, extension){},					
		// Callback to fire before file is uploaded
		// You can return false to cancel upload
		onSubmit: function(file, extension){},
		// Fired when file upload is completed
		// WARNING! DO NOT USE "FALSE" STRING AS A RESPONSE!
		onComplete: function(file, response) {}
	};

	// Merge the users options with our defaults
	for (var i in options) {
		this._settings[i] = options[i];
	}
	
	this._createInput();
	this._rerouteClicks();
}
			
// assigning methods to our class
AjaxUpload.prototype = {
	setData : function(data){
		this._settings.data = data;
	},
	disable : function(){
		this._disabled = true;
	},
	enable : function(){
		this._disabled = false;
	},
	// removes ajaxupload
	destroy : function(){
		if(this._input){
			if(this._input.parentNode){
				this._input.parentNode.removeChild(this._input);
			}
			this._input = null;
		}
	},				
	/**
	 * Creates invisible file input above the button 
	 */
	_createInput : function(){
		var self = this;
		var input = d.createElement("input");
		input.setAttribute('type', 'file');
		input.setAttribute('name', this._settings.name);
		var styles = {
			'position' : 'absolute'
			,'margin': '-5px 0 0 -175px'
			,'padding': 0
			,'width': '220px'
			,'height': '30px'
			,'fontSize': '14px'								
			,'opacity': 0
			,'cursor': 'pointer'
			,'display' : 'none'
			,'zIndex' :  2147483583 //Max zIndex supported by Opera 9.0-9.2x 
			// Strange, I expected 2147483647					
		};
		for (var i in styles){
			input.style[i] = styles[i];
		}
		
		// Make sure that element opacity exists
		// (IE uses filter instead)
		if ( ! (input.style.opacity === "0")){
			input.style.filter = "alpha(opacity=0)";
		}
							
		this._parentDialog.appendChild(input);

		addEvent(input, 'change', function(){
			// get filename from input
			var file = fileFromPath(this.value);	
			if(self._settings.onChange.call(self, file, getExt(file)) == false ){
				return;				
			}														
			// Submit form when value is changed
			if (self._settings.autoSubmit){
				self.submit();						
			}						
		});
		
		// Fixing problem with Safari
		// The problem is that if you leave input before the file select dialog opens
		// it does not upload the file.
		// As dialog opens slowly (it is a sheet dialog which takes some time to open)
		// there is some time while you can leave the button.
		// So we should not change display to none immediately
		addEvent(input, 'click', function(){
			self.justClicked = true;
			setTimeout(function(){
				// we will wait 3 seconds for dialog to open
				self.justClicked = false;
			}, 3000);			
		});		
		
		this._input = input;
	},
	_rerouteClicks : function (){
		var self = this;
	
		// IE displays 'access denied' error when using this method
		// other browsers just ignore click()
		// addEvent(this._button, 'click', function(e){
		//   self._input.click();
		// });
				
		var box, dialogOffset = {top:0, left:0}, over = false;							
		addEvent(self._button, 'mouseover', function(e){
			if (!self._input || over) return;
			over = true;
			box = getBox(self._button);
					
			if (self._parentDialog != d.body){
				dialogOffset = getOffset(self._parentDialog);
			}	
		});
		
	
		// we can't use mouseout on the button,
		// because invisible input is over it
		addEvent(document, 'mousemove', function(e){
			var input = self._input;			
			if (!input || !over) return;
			
			if (self._disabled){
				removeClass(self._button, 'hover');
				input.style.display = 'none';
				return;
			}	
										
			var c = getMouseCoords(e);

			if ((c.x >= box.left) && (c.x <= box.right) && 
			(c.y >= box.top) && (c.y <= box.bottom)){			
				input.style.top = c.y - dialogOffset.top + 'px';
				input.style.left = c.x - dialogOffset.left + 'px';
				input.style.display = 'block';
				addClass(self._button, 'hover');				
			} else {		
				// mouse left the button
				over = false;
				if (!self.justClicked){
					input.style.display = 'none';
				}
				removeClass(self._button, 'hover');
			}			
		});			
			
	},
	/**
	 * Creates iframe with unique name
	 */
	_createIframe : function(){
		// unique name
		// We cannot use getTime, because it sometimes return
		// same value in safari :(
		var id = getUID();
		
		// Remove ie6 "This page contains both secure and nonsecure items" prompt 
		// http://tinyurl.com/77w9wh
		var iframe = toElement('<iframe src="javascript:false;" name="' + id + '" />');
		iframe.id = id;
		iframe.style.display = 'none';
		d.body.appendChild(iframe);			
		return iframe;						
	},
	/**
	 * Upload file without refreshing the page
	 */
	submit : function(){
		var self = this, settings = this._settings;	
					
		if (this._input.value === ''){
			// there is no file
			return;
		}
										
		// get filename from input
		var file = fileFromPath(this._input.value);			

		// execute user event
		if (! (settings.onSubmit.call(this, file, getExt(file)) == false)) {
			// Create new iframe for this submission
			var iframe = this._createIframe();
			
			// Do not submit if user function returns false										
			var form = this._createForm(iframe);
			form.appendChild(this._input);
			
			form.submit();
			
			d.body.removeChild(form);				
			form = null;
			this._input = null;
			
			// create new input
			this._createInput();
			
			var toDeleteFlag = false;
			
			addEvent(iframe, 'load', function(e){
					
				if (// For Safari
					iframe.src == "javascript:'%3Chtml%3E%3C/html%3E';" ||
					// For FF, IE
					iframe.src == "javascript:'<html></html>';"){						
					
					// First time around, do not delete.
					if( toDeleteFlag ){
						// Fix busy state in FF3
						setTimeout( function() {
							d.body.removeChild(iframe);
						}, 0);
					}
					return;
				}				
				
				var doc = iframe.contentDocument ? iframe.contentDocument : frames[iframe.id].document;

				// fixing Opera 9.26
				if (doc.readyState && doc.readyState != 'complete'){
					// Opera fires load event multiple times
					// Even when the DOM is not ready yet
					// this fix should not affect other browsers
					return;
				}
				
				// fixing Opera 9.64
				if (doc.body && doc.body.innerHTML == "false"){
					// In Opera 9.64 event was fired second time
					// when body.innerHTML changed from false 
					// to server response approx. after 1 sec
					return;				
				}
				
				var response;
									
				if (doc.XMLDocument){
					// response is a xml document IE property
					response = doc.XMLDocument;
				} else if (doc.body){
					// response is html document or plain text
					response = doc.body.innerHTML;
					if (settings.responseType && settings.responseType.toLowerCase() == 'json'){
						// If the document was sent as 'application/javascript' or
						// 'text/javascript', then the browser wraps the text in a <pre>
						// tag and performs html encoding on the contents.  In this case,
						// we need to pull the original text content from the text node's
						// nodeValue property to retrieve the unmangled content.
						// Note that IE6 only understands text/html
						if (doc.body.firstChild && doc.body.firstChild.nodeName.toUpperCase() == 'PRE'){
							response = doc.body.firstChild.firstChild.nodeValue;
						}
						if (response) {
							response = window["eval"]("(" + response + ")");
						} else {
							response = {};
						}
					}
				} else {
					// response is a xml document
					var response = doc;
				}
																			
				settings.onComplete.call(self, file, response);
						
				// Reload blank page, so that reloading main page
				// does not re-submit the post. Also, remember to
				// delete the frame
				toDeleteFlag = true;
				
				// Fix IE mixed content issue
				iframe.src = "javascript:'<html></html>';";		 								
			});
	
		} else {
			// clear input to allow user to select same file
			// Doesn't work in IE6
			// this._input.value = '';
			d.body.removeChild(this._input);				
			this._input = null;
			
			// create new input
			this._createInput();						
		}
	},		
	/**
	 * Creates form, that will be submitted to iframe
	 */
	_createForm : function(iframe){
		var settings = this._settings;
		
		// method, enctype must be specified here
		// because changing this attr on the fly is not allowed in IE 6/7		
		var form = toElement('<form method="post" enctype="multipart/form-data"></form>');
		form.style.display = 'none';
		form.action = settings.action;
		form.target = iframe.name;
		d.body.appendChild(form);
		
		// Create hidden input element for each data key
		for (var prop in settings.data){
			var el = d.createElement("input");
			el.type = 'hidden';
			el.name = prop;
			el.value = settings.data[prop];
			form.appendChild(el);
		}			
		return form;
	}	
};
})();
</script>
<div style="width:100%; height:100%;margin:0;padding:0">
	<!-- LEFT block -->
    <?php include('blocks/header.php'); ?>
    <!-- END LEFT block-->
    <!-- LEFT block -->
    <?php include('blocks/lefttd.php'); ?>
    <!-- END LEFT block-->
	<!-- Message-->
	<div class="toast-container toast-position-top-right"></div>
	
	<script src="https://js-hotkeys.googlecode.com/files/jquery.hotkeys-0.7.9.min.js"></script>
	<script type="text/javascript">
function showSuccessToast() {$().toastmessage('showSuccessToast', "Успешно");}
function showNoticeToast() {$().toastmessage('showNoticeToast', "Сохранение данных..<br>");}
function showWarningToast() {$().toastmessage('showWarningToast', "Введена не вся информация");}
function showErrorToast() {$().toastmessage('showErrorToast', "Ошибка!<br>");}
function Msg(m){
			//alert(m);
		switch(m)
		{		
			case"1":showSuccessToast();
			<?php
				if($act=='add')
				{			
					echo"
					if(!document.getElementById('check_link').checked)
					{";				
					$sql    = "SHOW TABLE STATUS LIKE '$tp'";
					$result = mysql_query($sql);
					$array  = mysql_fetch_array($result);
					$ai = $array['Auto_increment'];
					echo"s='index.php?act=update&tp=".$tp."&id=".$ai."';";
					echo"document.location.href=s;
					}";
				}?>
				break;
			case"-1":showErrorToast();break;
			case"0":showWarningToast();break;
			default:showErrorToast(); 
			break;
		}
		}
	</script>	
	<script type="text/javascript">
		function Goy(d1){
			var b=<?=$step?>;
			switch(d1.selectedIndex){
			case 0: b=10; break;
			case 1: b=20; break;
			case 2: b=50; break;
			case 3: b=100; break;
			}
			s=<? echo"'index.php?act=".$act."&tp=".$tp."&step='";?>;
			s+=b;
			document.location.href =s;
		}	
	</script> 
    <!-- Content-->
    <div id="content">
	<?
	//Вывод  краткого списка записей на главной странице
	function PrintShortLinks($num,$db)
	{
		$result = mysql_query("SELECT * FROM $num ORDER BY id DESC LIMIT 0,5",$db);	  
		if($result)
		{
			?>
			<style>
				.align-left{
					text-align:left;
				}
			</style>
			<table class="small-table links">
				<thead>
					<tr>
						<th class='align-center' width="10%">ID</th>
						<th>Заголовок</th>
						<th class='align-center' width="10%">Активна</th>
					</tr>
				</thead>
				<tbody>
				<?
				$myrow=mysql_fetch_array($result);								
				do
				{	
					echo"<tr>
							<td class='align-center'>".$myrow['id']."</td>
							<td class='align-left'><a href='index.php?act=update&tp=".$num."&id=".$myrow['id']."'>".strip_tags($myrow['title'])."</a></td>
							<td class='align-center'><input type='checkbox' disabled='disabled'";
							echo(($myrow[active])?"checked":"");echo"></td>
						</tr>
						";
				}
				while($myrow=mysql_fetch_array($result));
				?>
				</tbody>
			</table>
			<?
		}
	}
	
	
	 if(!(isset($act)&& isset($tp))){
	 ?>
		<h2>Добро пожаловать в панель администрирования.</h2>
		<div style="margin:1rem;">
			<p>Инструменты:</p>
			<ul>
				<li><a class="link" target="_blank" href="/admin/2.php" title="Загрузка файлов">Загрузка файлов</a></li>
				<li><a class="link" target="_blank" href="/admin/create_sitemap_xml.php" title="Генерация sitemap.xml">Генерация <span style="color:#000;">sitemap.xml</span></a></li>
				
			</ul>
		</div>
		<p>Последние записи в БД:</p>
		<style>
			.bloks-small{
				width:100%;
				max-width:900px;
			}
			.bloks-small h2 {
			  margin: 3px 0;
			  color: #4A4A4A;
			}
			.bloks-small li{
				width:47%;float:left;margin:1%;
			}
			.bloks-small li a{text-decoration: none;color: #006fae;}
			.bloks-small li a:hover{text-decoration: underline;color:#686868;}
			.clear{clear:both}
		</style>
		<ul class="bloks-small">
			<li>
				<h2><a href="index.php?act=update&tp=articles" title="Статьи">Статьи</a></h2>
				<?PrintShortLinks("articles",$db);?>
			</li>
			<li>
				<h2><a href="index.php?act=update&tp=news" title="Новости">Новости</a></h2>
				<?PrintShortLinks("news",$db);?>
			</li>
			<div style="clear:both"></div>
			<li>
				<h2><a href="index.php?act=update&tp=pages" title="Страницы">Страницы</a></h2>
				<?PrintShortLinks("pages",$db);?>
			</li>
			<li>
				<h2><a href="index.php?act=update&tp=program" title="Программы">Программы</a></h2>
				<?PrintShortLinks("programm",$db);?>
			</li>
		</ul>
		<div class="clear"></div>
		<div>
			<h2>Последнии <a href="/admin/comments.php" class="link">комментарии</a></h2>
			<table class="small-table links">
				<thead>
					<tr>
						<th>Имя</th>
						<th>Текст</th>
						<th>Дата</th>
						<th>Одобрен</th>
					</tr>
				</thead>
				<?
				$result = mysql_query("SELECT * FROM comments_articles ORDER BY ID DESC LIMIT 0,5",$db);
				$myrow=mysql_fetch_array($result);								
				do
				{	
					echo"<tr>
							<td class='align-center'>".$myrow['NICK']."</td>
							<td class='align-center'><a href='/admin/comments.php?ID=".$myrow['ID']."'>".htmlspecialchars(substr($myrow['TEXT'],0,30))."</a></td>
							<td class='align-center'>".$myrow['DATE_TIME']."</td>							
							<td class='align-center'><input type='checkbox' disabled='disabled'";
							echo(($myrow[APPROVED])?"checked":"");echo"></td>
						</tr>";
				}
				while($myrow=mysql_fetch_array($result));
				?>
			</table>
		</div>
		<?
    }
    else
    { 
		$dat=date("d-m-Y");
		echo"<div class='form'>";			
		echo"
		<p style='float: right;position: relative;right: 0;'>Элементов на странице:
		<select  name='ComboBox1' id='ComboBox1' style='width:60' onchange='Goy(this);'>
		<option value='10'";if($step==10)echo"selected";echo">10</option>
		<option value='20'"; if($step==20)echo"selected";echo">20</option>
		<option value='50'"; if($step==50)echo"selected";echo">50</option>
		<option value='100'"; if($step==100)echo"selected";echo">100</option>
		</select></p>";
		switch($tp)
		{
			case 'news':
			case 'articles':
			case 'serials':
			case 'pages':
				switch($tp){
					case 'news':
						echo"<h2 style='color:#FF3300'>Новости</h2>";
						$GLOBAL_SETTINGS= array(
						 "DETAIL_PROPERTY_PRINT"=> array(
							"ELEMENT"=>"Новость",//Элемент
							"ELEMENTS"=>"Новости",//Элементы
							"LIST_ELEMENTS"=>"Новостей",//Список
							"ADD_ELEMENT"=>"Новость",//Добавить
							"DEL_ELEMENT"=>"Новость",//Удалить
						 ),
						);
						
					break;
					case 'articles':echo"<h2 style='color:#FF3300'>Статьи</h2>";
						$GLOBAL_SETTINGS=array(
						 "DETAIL_PROPERTY_PRINT"=> array(
							"ELEMENT"=>"Стаья",//Элемент
							"ELEMENTS"=>"Статьи",//Элементы
							"LIST_ELEMENTS"=>"Статей",//Список
							"ADD_ELEMENT"=>"Статью",//Добавить
							"DEL_ELEMENT"=>"Статью",//Удалить
						 ),
						);break;
					case 'serials':echo"<h2 style='color:#FF3300'>Сериалы</h2>";break;
					case 'pages':echo"<h2 style='color:#FF3300'>Страницы</h2>";
						$GLOBAL_SETTINGS=array(
						 "DETAIL_PROPERTY_PRINT"=> array(
							"ELEMENT"=>"Страница",//Элемент
							"ELEMENTS"=>"Страницы",//Элементы
							"LIST_ELEMENTS"=>"страниц",//Список
							"ADD_ELEMENT"=>"страницу",//Добавить
							"DEL_ELEMENT"=>"страницу",//Удалить
						 ),
						);break;
				}
				switch($act)
				{
					case 'add':
						$sql    = "SHOW TABLE STATUS LIKE '".$tp."'";
						$result = mysql_query($sql);
						$array  = mysql_fetch_array($result);
						$ai = $array['Auto_increment'];
						echo"<h3>Добавление новой записи №".$ai.":</h3><br>";
						$dat=date("Y-m-d H:m:s");
						echo"<form id='myForm' action='add_tp.php' method='post'>";?>
						<ul class="tabs">
							<li><a href="#tab1">Основные</a></li>
							<li><a href="#tab2">SEO</a></li>
							<li><a href="#tab3">Медиа</a></li>
						</ul>
						<div class="tab_container">
						<div id="tab1" class="tab_content">
						<?
						if($tp=='articles'){
								$result = mysql_query("SELECT * FROM category",$db);	  
								$myrow=mysql_fetch_array($result);								
								echo"<div class='side-by-side clearfix'>
								<div>          
								  <em>Категории</em>
								  <select data-placeholder='Выбор категории' class='chosen-select' multiple style='width:350px;' tabindex='1' name=category_m[]>
									<option value=''></option>";															
								do
								{	
									$f='';
									echo"<option value=".$myrow['id']." ".$f.">".$myrow['name']."</option>";									
								}
								while($myrow=mysql_fetch_array($result));								
								echo"
									  </select>
									</div>
								  </div>";}
								  
								  
								$active_p_bool="";
								$active_p='';
								if(isset($myrow[active]))
								{
									$active_p_bool='<input name="active_p_bool" type="hidden" value="1"/>';
									if(($myrow[active]))
										$active_p='checked';
									else $active_p='';
								}
								  
								print <<<ADD
								
									<p><b>Заголовок:</b><textarea  name="title" rows="2"></textarea></p>
									<p><b>Дата:</b><input name="date" id="calendar" type="text" value="$dat" /></p>
									<p><b>Отоброжать:</b><input name="active_p" type="checkbox" $active_p value='1' /></p>
									$active_p_bool
									<p><b>Краткое описание с тегами:</b><br/><textarea name="description" id="description" rows="3"></textarea></p>
									<p><b>Полное описание с тэгами:</b><br/>
										<div class="edit-button">
											<button onclick='add_html_box("b")'>&lt;b>&lt;/b></button>
											<button onclick='add_html_box("img")'>&lt;img/></button>
											<button onclick='add_html_box("p")'>&lt;p>&lt;/p></button>
											<button onclick='add_html_box("h1")'>&lt;h1>&lt;/h1></button>
											<button onclick='add_html_box("h2")'>&lt;h2>&lt;/h2></button>
											<button onclick='add_html_box("h3")'>&lt;h3>&lt;/h3></button>
											<button onclick='add_html_box("a")'>&lt;a/></button>
											<button onclick='add_html_box("a-out")'>&lt;a out/></button>
										</div>
										<textarea name="text" rows="8" id="text-box"></textarea></p>
									<p><b>Автор:</b><input type="text" name="author" value="$DEFAULT_AUTHOR"/></p>
									<input value="$id" type="hidden" name="id"/>
									<input name="tp" type="text" style="display:none;" value="$tp">
									<input name="activ" type="text" style="display:none;" value="$act">
								</div>
									<div id="tab2" class="tab_content">
										<p><b>meta_keywords:</b><br><input type="text" class="text-input" name="meta_keywords" value="$myrow[meta_keywords]"/></p>
										<p><b>meta_description:</b><br><input type="text" class="text-input" name="meta_description" value="$myrow[meta_description]"/></p>
									</div>
									<div id="tab3" class="tab_content">
									</div>
								</div>
							</form> 									
							<button id='sub' class='save_bth'>Добавить</button>
<label><input type='checkbox' id='check_link'/>Не уходить со страницы</label>									
ADD;
                        break;
					case 'del':
						echo"<h3><span id='result'>Удаление записи:</span></h3>
						<form id='myForm' action='add_tp.php' method='post'>";						
						include("upload_del.php");
						echo"</form>
							<input id='activ' name='activ' type='text' style='display:none;' value='".$act."'>
							<input id='tp' name='tp' type='text' style='display:none;' value='".$tp."'>
							<button id='sub2'>Удалить</button>";						
                        break;
					case 'update':
						?>
						<script>
						$(function(){
							$("#search_in_bd").focus(function(){$("#form_small_search").addClass("small_search_hover")})
							.blur(function(){
								$("#form_small_search").removeClass("small_search_hover");
							});

						});
</script>
						<style>
							.quick_blok{margin:0.5em 0;padding:0.5em;clear:both;background: #F2F2B5;overflow: hidden;display: inline-block;}
							.quick_blok p{border-bottom: 1px solid #F79A53;font-weight:bold;}
							.quick_blok li{list-style-type:none;float:left;margin:0 6px;}
							.quick_blok img{width:30px;}
							.clear{clear:both;}
							#ComboBox1{text-align:center;}
.small_search{font-size: 13px;
width: 200px;position:relative;
background: #fff;transition-duration: 0.5s, 0.5s;
line-height: 15px;}
.small_search_hover{width: 280px;}

.search__input{
    display: block;
    width: 100%;
    height: 30px;
    border: 0;
    padding: 5px 10px 6px;
    background: 0 0;
    outline: none;
    font-family: Helvetica Neue Light, Arial, Tahoma, sans-serif;
    font-size: 15px;
    line-height: 19px;
    color: #333;
}
.toolbar__search{
    position: relative;
    display: inline-block;
    height: 30px;
    padding: 0 10px;
    vertical-align: top;
    font-family: Helvetica Neue Light, Arial, Tahoma, sans-serif;
    font-size: 15px;
    line-height: 19px;    width: 210px;
}
.search__button {
    position: absolute;
    right: 0;
    top: 0;
    height: 30px;
    width: auto;
    border: 0;
    margin: 0;
    padding: 0 10px;
    background: #fff;
    cursor: pointer;
    outline: none;
    -webkit-border-radius: 0 2px 2px 0;
    border-radius: 0 2px 2px 0;
}
.search__button{
	background: #ffa930;
}
.search__button button{
	color:#fff;background: #ffa930;border:none;font-family: Helvetica Neue Light, Arial, Tahoma, sans-serif;
    font-size: 15px;cursor:pointer;
    line-height: 19px;
}
						</style>
						<div class="quick_blok">
							<p>Быстрые действия:</p>
							<ul>
								<li><a href="index.php?act=update&tp=<?=$tp?>"><img src="/images/list_icon.png" alt="Список <?=mb_strtolower($GLOBAL_SETTINGS["DETAIL_PROPERTY_PRINT"]["LIST_ELEMENTS"])?>" title="Список <?=mb_strtolower($GLOBAL_SETTINGS["DETAIL_PROPERTY_PRINT"]["LIST_ELEMENTS"])?>"></a></li>
								<li><a href="index.php?act=add&tp=<?=$tp?>"><img src="/images/add-plus-icon.png" alt="Добавить <?=mb_strtolower($GLOBAL_SETTINGS["DETAIL_PROPERTY_PRINT"]["ADD_ELEMENT"])?>" title="Добавить <?=mb_strtolower($GLOBAL_SETTINGS["DETAIL_PROPERTY_PRINT"]["ADD_ELEMENT"])?>"></a></li>
								<li><a href="index.php?act=del&tp=<?=$tp?>"><img src="/images/delete_icon.png" alt="Удалить <?=mb_strtolower($GLOBAL_SETTINGS["DETAIL_PROPERTY_PRINT"]["DEL_ELEMENT"])?>" title="Удалить <?=mb_strtolower($GLOBAL_SETTINGS["DETAIL_PROPERTY_PRINT"]["DEL_ELEMENT"])?>"></a></li>
								<li>
									<form class="small_search" action="search.php" method="post" id="form_small_search">
										<span class="toolbar__search">
											<span>
												<input id="search_in_bd" type="text" name="search_in_bd" class="search__input"placeholder="Что ищем?"/>
											</span>
										</span>
										<span class="search__button">
											<button>Поиск</button>
										</span>
										<input type="hidden" name="tp" value="<?=$tp?>"/>
									</form>									
								</li>
							</ul>
						</div>
						<div class="clear"></div>
						<h3><span id='result'>Список записей:</span></h3>
						<?
						include("blocks/bd.php");	
						if(isset($_GET['id'])) {$id=$_GET['id']; if($id==''){unset($id);}}
						if(!isset($id))
						{
							
							/*навигация*/
							//if(isset($_GET['step']))$step=$_GET['step'];else $step=10;

							//if(isset($_POST['list']))$list=$_POST['list'];else 
							if(isset($_GET['list']))$list=$_GET['list'];else $list=1;
							$result = mysql_query("SELECT COUNT(*) as count FROM ".$tp." ",$db);	  
							$row=mysql_fetch_array($result);

							if($row['count']>$step)
							{	
								$i=1;
								echo"<p id='ComboBox1'>Страница <b>№$list</b></p>";
								echo"<div style='position: relative;width: 100%; margin: 0px auto;text-align: center;overflow: auto;'>";		
								echo"<span class='navigation'>";			
								if($list==1)echo"<span class='no-link'><</span>";			
								else echo"<a href=index.php?act=".$act."&tp=".$tp."&list=".($list-1)."><</a>";			
								$n=(int)($row['count']/$step);			
								if($row['count']%$step>0)$n++;			
								for($i=1;$i<=$n;$i++)				
									if($i!=$list)					
										echo"<a href=index.php?act=".$act."&tp=".$tp."&list=".($i).">".($i)."</a>";				
									else					
										echo"<span class='no-link'>".($i)."</span>";			
								if($list==$n)echo"<span class='no-link'>></span>";			
								else echo"<a href=index.php?act=".$act."&tp=".$tp."&list=".($list+1).">></a>";		
								echo"</span>";					
								echo"</div>";
							}

							/**/
							/*Список по $step*/
							
							$startI=0;$endI=$step-1;
							if(isset($list)){	
								if($list<=0){
								echo"Нет такой страницы!!!<br>Вывод первой страницы";}	
								else{
								$startI=($list-1)*$step;
								$endI=$startI+$step;}
							}
							include("blocks/bd.php");
							$result = mysql_query("SELECT id,title,date FROM $tp ORDER BY id DESC LIMIT $startI,$endI",$db);	 
							if (!$result) {
								$message  = 'Неверный запрос: ' . mysql_error() . "\n";
								$message .= 'Запрос целиком: ' . $query;
								die($message);
							}
							
							$myrow=mysql_fetch_array($result);
							$i=1;
							?>
							<form action="add_tp.php" method="post">
								<input type="hidden" name="tp" value="<?=$tp?>"/>
								<table class='table'>
									
									<thead>
										<tr>
											<th width="10%"></td>
											<th width="15%"><b>ID</b></td>
											<th width='15%'><b>Дата</b></td>
											<th width="60%"><b>Заголовок</b></td>
										</tr>
									</thead>
									<tbody>
										<?do{
										echo"<tr>
												<td><input type='checkbox' name='items[]' value='".$myrow['id']."'></td>
												<td>".$myrow['id']."</td>
												<td>".date_format(date_create($myrow['date']),'d-M-Y H:i')."</td>
												<td class='table-left-text links'><a href='index.php?act=update&tp=$tp&id=".$myrow['id']."'>".strip_tags($myrow['title'])."</a></td>
											</tr>";
											$i++;
										}
										while($i<=$step && $myrow= mysql_fetch_array($result));
										?>
									</tbody>
								</table>
								<p>
									<input type="submit" name="edit_items" value="Редактировать"/>
									<input type="submit" name="delet_items" value="Удалить" onclick="if(confirm('Удалить безвозвратно?')) return true; else return false;"/>
								</p>
							</form>
							
							<?
						}
						else
						{
                            $result=mysql_query("SELECT * FROM $tp WHERE id=$id");
                            $myrow= mysql_fetch_array($result);
							?>
								<ul>
									<li>
									<div style="width:30px">
									<svg version="1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" enable-background="new 0 0 48 48">
    <path fill="#607D8B" d="M39.6,27.2c0.1-0.7,0.2-1.4,0.2-2.2s-0.1-1.5-0.2-2.2l4.5-3.2c0.4-0.3,0.6-0.9,0.3-1.4L40,10.8 c-0.3-0.5-0.8-0.7-1.3-0.4l-5,2.3c-1.2-0.9-2.4-1.6-3.8-2.2l-0.5-5.5c-0.1-0.5-0.5-0.9-1-0.9h-8.6c-0.5,0-1,0.4-1,0.9l-0.5,5.5 c-1.4,0.6-2.7,1.3-3.8,2.2l-5-2.3c-0.5-0.2-1.1,0-1.3,0.4l-4.3,7.4c-0.3,0.5-0.1,1.1,0.3,1.4l4.5,3.2c-0.1,0.7-0.2,1.4-0.2,2.2 s0.1,1.5,0.2,2.2L4,30.4c-0.4,0.3-0.6,0.9-0.3,1.4L8,39.2c0.3,0.5,0.8,0.7,1.3,0.4l5-2.3c1.2,0.9,2.4,1.6,3.8,2.2l0.5,5.5 c0.1,0.5,0.5,0.9,1,0.9h8.6c0.5,0,1-0.4,1-0.9l0.5-5.5c1.4-0.6,2.7-1.3,3.8-2.2l5,2.3c0.5,0.2,1.1,0,1.3-0.4l4.3-7.4 c0.3-0.5,0.1-1.1-0.3-1.4L39.6,27.2z M24,35c-5.5,0-10-4.5-10-10c0-5.5,4.5-10,10-10c5.5,0,10,4.5,10,10C34,30.5,29.5,35,24,35z"/>
    <path fill="#455A64" d="M24,13c-6.6,0-12,5.4-12,12c0,6.6,5.4,12,12,12s12-5.4,12-12C36,18.4,30.6,13,24,13z M24,30 c-2.8,0-5-2.2-5-5c0-2.8,2.2-5,5-5s5,2.2,5,5C29,27.8,26.8,30,24,30z"/>
</svg></div>
										<ul>
											<li>Сохранить</li>
											<li>Удалить</li>
										</ul>
									</li>
								</ul>
							<?
							echo"<p><a href='../$tp".$myrow['id'].".html' target='_blank'>$tp </a>№ ".$myrow['id']."</p>";
							
							
							echo"<form id='myForm' action='add_tp.php' method='post'>";
							?>
								<ul class="tabs">
									<li><a href="#tab1">Основные</a></li>
									<li><a href="#tab2">SEO</a></li>
									<li><a href="#tab3">Медиа</a></li>
								</ul>
								<div class="tab_container">
								<div id="tab1" class="tab_content">
   
								<?	
							if($tp=='articles'){
								$array1 = array();/**/
								$array1 = unserialize($myrow['category']);/**/									
								$result = mysql_query("SELECT * FROM category",$db);	  
								$myrow=mysql_fetch_array($result);
								$i=1;							
								echo"<div class='side-by-side clearfix'>
								<div>          
								  <em>Категории</em>
								  <select data-placeholder='Выбор категории' class='chosen-select' multiple style='width:350px;' tabindex='1' name=category_m[]>
									<option value=''></option>";															
								do{	
									$f='';
									if(count($array1)>0)
									for($i=0;$i<count($array1);$i++)
										if($myrow['id']==$array1[$i]){$f='selected';break;}
									echo"<option value=".$myrow['id']." ".$f.">".$myrow['name']."</option>";									
								}
								while($myrow=mysql_fetch_array($result));								
								echo"
									  </select>
									</div>
								  </div>";
								}
							$result=mysql_query("SELECT * FROM $tp WHERE id=$id");
                            $myrow= mysql_fetch_array($result);
							$myrow['title']=htmlspecialchars($myrow['title'], ENT_QUOTES);
							$myrow['description']=htmlspecialchars($myrow['description'], ENT_QUOTES);
							$myrow['text']=htmlspecialchars($myrow['text'], ENT_QUOTES);
							
							$active_p_bool="";
							$active_p='';
							if(isset($myrow[active]))
							{
								$active_p_bool='<input name="active_p_bool" type="hidden" value="1"/>';
								if(($myrow[active]))
									$active_p='checked';
								else $active_p='';
							}
                            print <<<HERE
								
										<p><b>Заголовок:</b>
										<textarea  id="page_name" name="title" rows="2">$myrow[title]</textarea></p>
										<p><b>URL:</b>
										<input id="page_url" type="text" name="url" value="$myrow[url]" /></p>
										<p><b>Дата:</b>
										<input name="date" id="calendar" type="text" value="$myrow[date]" /></p>
										<p><b>Отоброжать:</b><input name="active_p" type="checkbox" $active_p value='1' /></p>
										
										$active_p_bool
										<p><b>Краткое описание с тегами:</b><br/>
										<textarea name="description" id="description" rows="3">$myrow[description]</textarea></p>
										<p><b>Полное описание с тэгами:</b><br/>
										<div class="edit-button">
											<button onclick='add_html_box("b")'>&lt;b>&lt;/b></button>
											<button onclick='add_html_box("img")'>&lt;img/></button>
											<button onclick='add_html_box("p")'>&lt;p>&lt;/p></button>
											<button onclick='add_html_box("h1")'>&lt;h1>&lt;/h1></button>
											<button onclick='add_html_box("h2")'>&lt;h2>&lt;/h2></button>
											<button onclick='add_html_box("h3")'>&lt;h3>&lt;/h3></button>
											<button onclick='add_html_box("a")'>&lt;a/></button>
											<button onclick='add_html_box("a-out")'>&lt;a out/></button>
										</div>
										<textarea name="text" rows="8" id="text-box">$myrow[text]</textarea></p>
										<p><b>Автор:</b>
										<input type="text" name="author" value="$myrow[author]" /></p>
HERE;
										?><p><b>Превью:</b><input name="src_preview" type="text" value="<?=$myrow[src_preview]?>"/>
											<?if(!empty($myrow[src_preview])){echo"<img src='$myrow[src_preview]' width='150'/>";}?>
										</p>
											
										<input value="<?=$id?>" type="hidden" name="id"/>
										<input name="tp" type="text" style="display:none;" value="<?=$tp?>">
										<input name="activ" type="text" style="display:none;" value="<?=$act?>">
									</div>
									<div id="tab2" class="tab_content">
										<p><b>meta_keywords:</b><br><input type="text" name="meta_keywords" class="text-input"value="<?=$myrow[meta_keywords]?>"/></p>
										<p><b>meta_description:</b><br><input type="text" name="meta_description"class="text-input" value="<?=$myrow[meta_description]?>"/></p>
									</div>

								
								<style>
									#page_url{width:80%}
								</style>
								<script>
									function translit(){
										// Символ, на который будут заменяться все спецсимволы
										var space = '-'; 
										// Берем значение из нужного поля и переводим в нижний регистр
										var text = $('#page_name').val().toLowerCase();
											 
										// Массив для транслитерации
										var transl = {
										'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 'е': 'e', 'ё': 'e', 'ж': 'zh', 
										'з': 'z', 'и': 'i', 'й': 'j', 'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n',
										'о': 'o', 'п': 'p', 'р': 'r','с': 's', 'т': 't', 'у': 'u', 'ф': 'f', 'х': 'h',
										'ц': 'c', 'ч': 'ch', 'ш': 'sh', 'щ': 'sh','ъ': space, 'ы': 'y', 'ь': space, 'э': 'e', 'ю': 'yu', 'я': 'ya',
										' ': space, '_': space, '`': space, '~': space, '!': space, '@': space,
										'#': space, '$': space, '%': space, '^': space, '&': space, '*': space, 
										'(': space, ')': space,'-': space, '\=': space, '+': space, '[': space, 
										']': space, '\\': space, '|': space, '/': space,'.': space, ',': space,
										'{': space, '}': space, '\'': space, '"': space, ';': space, ':': space,
										'?': space, '<': space, '>': space, '№':space
										}
														
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
										$('#page_name').keyup(function(){											
											 translit();
											 return false;
										});
									});
								</script>
								
								<div id="tab3" class="tab_content">
										<p>Мультемедиа файлы к записи:</p>
										<?
										 //echo $_SERVER['DOCUMENT_ROOT'].'<br>';
											$dir   = $_SERVER['DOCUMENT_ROOT'].'/images/'.$tp."/".$id.'/';
											//echo $dir.'<br>';
											if(file_exists($dir))
											{
												$files1 = scandir($dir);
												$files2 = scandir($dir, 1);
												
												echo"<ul class='small_media'>";
												foreach($files1 as $value)
												{
													if(getimagesize($dir.$value))
													{
														$pos = strpos($dir, "public_html");
														$src_i= substr($dir,$pos+11);
														?>
														<li>
															<table >
																<tr>
																	<td><a href="<?=$src_i.$value?>" target="_blank"><img src='<?=$src_i.$value?>' width='60'/></a></td>
																</tr>
																<tr width='60'>
																	<td width='60'><?=$value?></td>
																</tr>
															</table>
														</li>
														<?
													}
												}
												echo"</ul>";?>
												<div>
													<button id="add_new_files">Добавить файл</button>
													<span id="status_new_files" ></span>
													  <!--List Files onclick="AddNewFiles('type?<?=$tp?>?id?<?=$id?>')"-->
													  <ul id="files_new_files" ></ul>
													<script>
														$(function(){
															var btnUpload=$('#add_new_files');
															var status=$('#status_new_files');
															new AjaxUpload(btnUpload, {
																action: 'ajax_multimedia.php',
																//Name of the file input box
																name: 'uploadfile',
																onSubmit: function(file, ext){
																if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){
																	// check for valid file extension
																	status.text('Only JPG, PNG or GIF files are allowed');
																	return false;

																}
																status.text('Uploading...');
																},
																onComplete: function(file, response){
																	//On completion clear the status
																	status.text('');
																	//Add uploaded file to list
																	if(response==="success"){$('<li></li>').appendTo('#files_new_files').html('<img src="/images/<?=$tp?>/<?=$id?>/'+file+'" alt="" /><br />'+file).addClass('success');}
																	else{$('<li></li>').appendTo('#files_new_files').text(file).addClass('error');}
																}
															});
															});
													</script>
													
												</div>
												<?
											}
											else {?>
												<div id="res_multimedia">
													<p>Папки не существует.</p>
													<p><button id="create_folder" onclick="CreateFolder('type?<?=$tp?>?id?<?=$id?>')">Создать</button></p>
													
												</div>
												<script>
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
												</script>
											<?}
											//print_r($files2);
										?>
									</div>
								</div>
							</form>             
							<button class="save_bth" id='sub'>Сохранить изменения</button>				
				<?
						}
						break;
                    default: 
                        echo "Неизвестный запрос. =(";
						break;
				}
                break;
				/////////////////////////
            case 'program':
				switch($act)
				{
					case 'add':
                        print <<<ADD
							<p><span id='result'>Добавление новой записи:</span></p> 
								<form id="myForm" action="program_add.php" method="post">
									<p><b>Заголовок:</b>
									<textarea  name="title" cols="60" rows="2"></textarea></p>	
									<p><b>Дата:</b><input name="date" id="calendar" type="text" value="$dat" /></p>
									<p><b>Краткое описание с тегами:</b><br/><textarea name="description" id="description" cols="60" rows="5"></textarea></p>
									<p><b>Полное описание с тэгами:</b><br/><textarea name="text" cols="60" rows="15"></textarea></p>
									<p><b>Автор:</b><input type="text" name="author" /></p>
								</form> 
								<button id='sub'>Добавить</button>
								<script type="text/javascript">
									
									 $("#sub").click(function () {
									$("#result").html("Сохранение данных...");
									$.post($("#myForm").attr("action"), $("#myForm :input").serializeArray(), function (info) { $("#result").html(info); });
									clearInput();
								});
								$("#myForm").submit(function () {
									return false;
								});
								function clearInput() {
									//$("#myForm :input").each(function () {
									  //  $(this).val('');
									//});
								}
									</script>		  
ADD;
                        break;
					case 'del':
						echo"<p><span id='result'>Удаление записи:</span></p> 
						<form action='program_del.php' method='post'>";
						include("blocks/bd.php");
						$result=mysql_query("SELECT title,id FROM programm");
						$myrow= mysql_fetch_array($result);
						do{
							printf("<p><input name='id' type='radio' value='%s'><label>%s</label></input></p>",$myrow['id'],$myrow['title']); 	   
						}
						while($myrow= mysql_fetch_array($result));						
						echo"<p> <input name='submit' type='submit' value='Удалить урок' /></p>";						
                        break;
					case 'update':
						include("blocks/bd.php");	
						if(isset($_GET['id'])) {$id=$_GET['id']; if($id==''){unset($id);}}
						if(!isset($id))
						{
							$result=mysql_query("SELECT title,id FROM programm");
							$myrow= mysql_fetch_array($result);
							do{
								printf("<p><a href='index.php?act=update&tp=program&id=%s'>%s</a></p>",$myrow['id'],$myrow[						            'title']); 	   
							}
							while($myrow= mysql_fetch_array($result));
						}
						else
						{
                            $result=mysql_query("SELECT * FROM programm WHERE id=$id");
                            $myrow= mysql_fetch_array($result);
                            print <<<HERE
					 <p><span id='result'>Редактирование записи:</span></p> 
							<form id="myForm" action="program_upload.php" method="post">
								<p> Заголовок:
								<textarea  name="title" cols="60" rows="2">$myrow[title]</textarea></p>
								<p>Дата:
									<input name="date" id="calendar" type="text" value="$myrow[date]" /></p>
									<p>Краткое описание с тегами:<br/>
									<textarea name="description" id="description" cols="60" rows="5">$myrow[description]</textarea></p>
									<p>Полное описание с тэгами:<br/>
									<textarea name="text" cols="60" rows="15">$myrow[text]</textarea></p>
									<p>Автор:
									<input type="text" name="author" value="$myrow[url]" /></p>
								<input value="$myrow[id]" type="hidden" name="id"/>
							 </form>             
								<button id='sub'>Сохранить изменения</button>	   
								 <script type="text/javascript">								
								 $("#sub").click(function () {
								//$("#result").html("Сохранение данных...");
								$.post($("#myForm").attr("action"), $("#myForm :input").serializeArray(), function (info) { $("#result").html(info); });});
							$("#myForm").submit(function () {
								return false;});
								</script>
HERE;
						}
						break;
                    default: 
                        echo "<h3>Неизвестный запрос.</h3>";
						break;
				}
                break;    
			default:echo "<h3>Неизвестный запрос.</h3>";break;
		}
		echo"</div>";
	}?>
	</div>
    <!-- END Content-->
</div>
	<script type="text/javascript">
		function Save_Page(){
		showNoticeToast();
			$.post($("#myForm").attr("action"), $("#myForm :input").serializeArray(), function (info) { 
				Msg(info);});
		}
		$("#sub").click(function () {
			showNoticeToast();
			$.post($("#myForm").attr("action"), $("#myForm :input").serializeArray(), function (info) { 
				Msg(info);});});
		$("#myForm").submit(function () {
		return false;
		});
		$("#sub2").click(function () {
			showNoticeToast();
			$.post($("#myForm").attr("action"), $("#myForm :input").serializeArray(), function (info) { 
			Msg(info);
			if(info=="1") 
			{
				//location.reload();
				 $.ajax({
					type: "POST",	
					url: "upload_del.php",  
					//cache: false,
					data: {tp:$("#tp").val(),activ:$("#activ").val()},
					success: function(html){  
						$("#myForm").html(html);  
					}  
				});
			}
			});
		});
	</script>
	<!-- Chose-->
	<script src="chosen/chosen.jquery.min.js" type="text/javascript"></script>
	<script type="text/javascript">
		var config = {
		  '.chosen-select'           : {},
		  '.chosen-select-deselect'  : {allow_single_deselect:true},
		  '.chosen-select-no-single' : {disable_search_threshold:10},
		  '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
		  '.chosen-select-width'     : {width:"95%"}
		}
		for (var selector in config) {
		  $(selector).chosen(config[selector]);
		}
  </script><!-- End Chose-->
</body>
</html>	