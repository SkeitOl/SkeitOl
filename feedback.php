<?php
header('Content-Type: text/html; charset= utf-8');
include("blocks/bd.php");
include("blocks/func/func.php"); ?>
<!DOCTYPE html>
<html>
	<?
	$sys_description="Обратная связь SkeitOl";
	$sys_keywords="Обратная связь, Обратная связь SkeitOl,Обратная связь SkeitOl Soft";
	$sys_title="Обратная связь";
	
	$sys_special_head_text='<!-- Plagin view image -->
	<script src="js/jquery-1.7.2.min.js"></script>
	<script src="js/lightbox.js"></script>
	<link href="style/lightbox.css" rel="stylesheet" />
	<link href="css/normalize.css" rel="stylesheet" />
	<link href="css/set1.css" rel="stylesheet" />
	
	<!-- END Plagin view image -->';
	include_once("blocks/head.php");?>
<body>
<?php include("blocks/header.php");?>

<div id='content'>
	<div class='left-con'>
		<div class='con-block'>
			<center><div class='title-small-block'>Обратная связь</div> </center>
			<style>label {color: red;}
			</style>
			<form id="myForm" name="contactForm" action="add_feedback.php" method="post" enctype="multipart/form-data">
				<div class="clear"></div>
				<span class="input input--hoshi">
					<input class="input__field input__field--hoshi" type="text" id="input-4" name="nik">
					<label class="input__label input__label--hoshi input__label--hoshi-color-1" for="input-4">
						<span class="input__label-content input__label-content--hoshi">Ваше имя</span>
					</label>
				</span>
				<div class="clear"></div>
				<span class="input input--hoshi">
					<input class="input__field input__field--hoshi" type="text" name="email"  id="input-7">
					<label class="input__label input__label--hoshi input__label--hoshi-color-3" for="input-6">
						<span class="input__label-content input__label-content--hoshi">Ваш e-mail</span>
					</label>
				</span>	
				<div class="clear"></div>
				<span class="input input--hoshi">
					
					<textarea class="input__field input__field--hoshi" type="text"  name="message" rows="3" style='width:90%;'></textarea>
					<label class="input__label input__label--hoshi input__label--hoshi-color-2" for="input-6">
						<span class="input__label-content input__label-content--hoshi">Ваше сообщение</span>
					</label>
				</span>					
				<div class="clear"></div>
				<br/>
				<img src="captcha/captcha.php" id="captcha-img" /><button onclick="UpdateImg();">Обновить</button>
				<br>
				<span class="input input--hoshi">
					<input class="input__field input__field--hoshi" type="text"name="captcha_code"  id="input-7">
					<label class="input__label input__label--hoshi input__label--hoshi-color-3" for="input-6">
						<span class="input__label-content input__label-content--hoshi">CAPTCHA:</span>
					</label>
				</span>	
				<div class="clear"></div>
				
				<script type="text/javascript">
				function UpdateImg() {
				document.images["captcha-img"].src = 'captcha/captcha.php';
				}
				</script><br/>
				
				<button id="sub">Отправить</button>
				<p><span id="result"></span></p>				
			</form>
			
			<script type="text/javascript">
				$("#sub").click(function () {
				$("#result").html("Отправка данных...");
				$.post($("#myForm").attr("action"), $("#myForm :input").serializeArray(), function (info) {
				if(info=="1")
				{
				$('#myForm')[0].reset();
				$("#result").html("<span style='color:#088A08;'>Сообщение отправленно</span>");
				UpdateImg();
				}else $("#result").html(info);
				});});
				$("#myForm").submit(function () {
				return false;
				});
			</script>			
		</div>
	</div>
	<script src="js/classie.js"></script>
	<script>
	
			(function() {
				// trim polyfill : https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/Trim
				if (!String.prototype.trim) {
					(function() {
						// Make sure we trim BOM and NBSP
						var rtrim = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;
						String.prototype.trim = function() {
							return this.replace(rtrim, "");
						};
					})();
				}

				[].slice.call( document.querySelectorAll( "input.input__field" ) ).forEach( function( inputEl ) {
					// in case the input is already filled..
					if( inputEl.value.trim() !== "" ) {
						classie.add( inputEl.parentNode, "input--filled" );
					}

					// events:
					inputEl.addEventListener( "focus", onInputFocus );
					inputEl.addEventListener( "blur", onInputBlur );
				} );

				function onInputFocus( ev ) {
					classie.add( ev.target.parentNode, "input--filled" );
				}

				function onInputBlur( ev ) {
					if( ev.target.value.trim() === "" ) {
						classie.remove( ev.target.parentNode, "input--filled" );
					}
				}
			})();
		
		</script>
	<div class='right-con'>
		<?php include("blocks/rightblock.php");?>		
	</div>
</div>
<?php include("blocks/footer.php"); ?>
</body>
</html>