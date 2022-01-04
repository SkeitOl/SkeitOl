<?php

class ClassAdmin
{
	public $tp;
	public $db;
	
	function __construct()
	{
	
	}
	
	function __construct1($tp, $db)
	{
		$this->tp = $tp;
		$this->db = $db;
	}
	
	public function PrintEditBlock($text)
	{
		?>
		<div id="text_box_admin" data-full="0">
			<div class="editor_sidebar">
				<div id="edit_panel_box">
					<span id="bt_full">🔎</span>
					<div class="edit-button">
						<span class="button" onclick='add_html_box("b")'>B</span>
						<span class="button" onclick='add_html_box("img")'>IMG</span>
						<span class="button" onclick='add_html_box("p")'>P</span>
						<span class="button" onclick='add_html_box("h1")'>H1</span>
						<span class="button" onclick='add_html_box("h2")'>H2</span>
						<span class="button" onclick='add_html_box("h3")'>H3</span>
						<span class="button" onclick='add_html_box("pre")'>PRE</span>
						<span class="button" onclick='add_html_box("a")'>a</span>
						<span class="button" onclick='add_html_box("a-out")'>a-out</span>
						<span style="width:50px;"></span>
						<span class="button" onclick='ConvertSpecialSharactersToHTML()'>ToHTML</span>
					</div>
				</div>
			</div>
			<div class="editor_area">
				<div class="editor_area_con">
					<textarea name="text" rows="8" id="text-box"><?= $text ?></textarea>
				</div>
			</div>
		</div>
		<?
	}
	
	public function PrintFormAddOrEdit($myrow, $id, $tp, $act)
	{
		?>
		<form id='myForm' action='add_tp.php' method='post' enctype="multipart/form-data">
			<ul class="tabs">
				<li><a href="#tab1">Основные</a></li>
				<li><a href="#tab2">SEO</a></li>
				<li><a href="#tab_sys_settings">Свойства</a></li>
				<li><a href="#tab3">Медиа</a></li>
			</ul>
			<div class="tab_container">
				<div id="tab1" class="tab_content">
					<table class="edit_box_admin"><?
						if ($tp == 'articles') {
							$array1 = unserialize($myrow['category']);/**/
							include($_SERVER['DOCUMENT_ROOT'] . "/admin/blocks/bd.php");
							$res = mysql_query("SELECT * FROM category", $db);
							$cat_row = mysql_fetch_array($res);
							$i = 1; ?>
							<tr>
								<td width="10%"><b>Категории:</b></td>
								<td width="90%">
									<div class='side-by-side clearfix'>
										<div>
											<select data-placeholder='Выбор категории' class='chosen-select' multiple style='width:350px;' tabindex='1' name=category_m[]>
												<option value=''></option><?
												do {
													$f = '';
													if (count($array1) > 0)
														for ($i = 0; $i < count($array1); $i++)
															if ($cat_row['id'] == $array1[$i]) {
																$f = 'selected';
																break;
															}
													echo "<option value=" . $cat_row['id'] . " " . $f . ">" . $cat_row['name'] . "</option>";
												} while ($cat_row = mysql_fetch_array($res));
												?>
											</select>
										</div>
									</div>
								</td>
							</tr>
						<?
						}
						//$result=mysql_query("SELECT * FROM $this->tp WHERE id=$id");
						//$myrow= mysql_fetch_array($result);
						$myrow['title'] = htmlspecialchars($myrow['title'], ENT_QUOTES);
						$myrow['description'] = htmlspecialchars($myrow['description'], ENT_QUOTES);
						$myrow['text'] = htmlspecialchars($myrow['text'], ENT_QUOTES);
						
						$active_p_bool = "";
						$active_p = '';
						if (isset($myrow[active])) {
							$active_p_bool = '<input name="active_p_bool" type="hidden" value="1"/>';
							if (($myrow[active]))
								$active_p = 'checked';
							else $active_p = '';
						}
						?>
						<script>
							var IsGenerateURL =<?echo ($act == 'update') ? 'false' : 'true'?>;
							$(function () {
								$('.gen_url span').click(function (e) {
									if ($(this).hasClass("active")) {
										$('.gen_url span').removeClass("active").addClass('no_active');
										IsGenerateURL = false;
									} else {
										$('.gen_url span').removeClass("no_active").addClass('active');
										IsGenerateURL = true;
									}
								});
							});
						</script>
						<tr>
							<td width="10%"><b>Название:</b></td>
							<td width="80%" class="gen_url">
								<div style="padding-right: 20px">
									<textarea id="page_name" name="title" rows="2"><?= $myrow[title] ?></textarea>
								</div>
								<span class="<? echo ($act == 'update') ? 'no_active' : 'active' ?>"><i class="fa fa-circle"></i></span>
							</td>
							<td></td>
						</tr>
						<tr>
							<td width="10%"><b>URL:</b></td>
							<td width="80%" class="gen_url">
								<div style="padding-right: 20px">
									<input id="page_url" type="text" name="url" value="<?= $myrow[url] ?>"/>
								</div>
								<span class="<? echo ($act == 'update') ? 'no_active' : 'active' ?>"><i class="fa fa-circle"></i></span>
							</td>
							<td></td>
						</tr>
						<tr>
							<td width="10%"><b>Дата:</b></td><?
							if ($act == 'add') {
								$dat = date("Y-m-d H:m:s");
								$myrow['date'] = $dat;
							}
							?>
							<td width="90%"><input name="date" id="calendar" type="text" value="<?= $myrow['date'] ?>"/>
							</td>
						</tr>
						<tr>
							<td width="10%"><b>Отоброжать:</b></td>
							<td width="90%">
								<input name="active_p" type="checkbox" <?= $active_p ?> value='1'/><?= $active_p_bool ?>
							</td>
						</tr>
						<tr>
							<td width="10%"><b>Автор:</b></td><?
							if ($act == 'add') {
								$myrow['author'] = 'SkeitOl';
							}
							?>
							<td width="90%"><input type="text" name="author" value="<?= $myrow['author'] ?>"/></td>
						</tr>
						<tr>
							<td width="10%"><b>Превью:</b></td>
							<td width="90%">
								<?/*if($myrow['src_preview']){?>
										<div class="block_change_preview_img">
										<img src='<?=$myrow[src_preview]?>' width='100'/>
										<span id="change_preview_img">Изменить</span>
										</div>
										<input id="new_preview_img" type="file" name="src_preview">
									<?}else*/
								if (empty($myrow['src_preview'])) {
									?><p><input id="new_preview_img11" type="file" name="img_preview"></p>
									<p><label for="PREVIEW_IMAGE">URL</label>
										<input id="PREVIEW_IMAGE" type="text" name="src_preview" value=""></p><?
								}
								else
								{
								?>
									<div>
										<a class="fancybox_img_src_preview" title="Превью" href="<?= $myrow['src_preview'] ?>"><img src="<?= $myrow['src_preview'] ?>" alt=""></a>
										<div class="clear"></div>
										<span class="del_preview_img"><a href="#">Удалить</a></span>
									</div>
									<script>
										$(function () {
											$(".fancybox_img_src_preview").fancybox();
										});
										$('.del_preview_img a').click(function () {
											if (confirm('Вы уверены, что хотите удалить превью?')) {
												$('.fancybox_img_src_preview').remove();
												$(this).parent().html('<input id="new_preview_img11" type="file" name="img_preview">' +
													'<input type="hidden" name="clear_preview" value="Y">' +
													'<p><input checked type="checkbox" id="del_old_src_preview" name="<?=$myrow['src_preview']?>" value="del"><label for="del_old_src_preview">Удалить прошлый файл</label></p>');
											}
											return false;
										});
									</script>
									<?
									/*
									if($act!='add'){?><input id="" value="<?=$myrow['src_preview']?>" type="text" name="src_preview"><?}
									else{
										$sql    = "SHOW TABLE STATUS LIKE '".$tp."'";
										$res_ = mysql_query($sql);
										$array  = mysql_fetch_array($res_);
										$ai = $array['Auto_increment'];

										?>
										<input type="hidden" name="uploaddir" value='<?=$tp.'/'.$ai?>'>
										<input id="" type="file" name="img_preview">
									<?}*/
								} ?></td>
						</tr>
						<tr>
							<td colspan=3><b>Краткое описание с тегами:</b></td>
						</tr>
						<tr>
							<td width="10%"></td>
							<td width="90%">
								<textarea name="description" id="description" rows="3"><?= $myrow[description] ?></textarea></p>
							</td>
						</tr>
						<tr>
							<td colspan=3><b>Полное описание с тэгами:</b></td>
						</tr>
						<tr>
							<td colspan=3>
								<? $this->PrintEditBlock($myrow['text']); ?>
							</td>
						</tr>
						<?/*
								<tr><script src="/admin/ckeditor/ckeditor.js"></script>
									<td colspan=3>

										<textarea name="ckeditor"><?=$myrow['text']?></textarea>
										<script>
										  // CKEDITOR.replace( 'ckeditor' );
										  CKEDITOR.replace('ckeditor',{'filebrowserBrowseUrl':'/admin/kcfinder/browse.php?type=files',
  'filebrowserImageBrowseUrl':'/admin/kcfinder/browse.php?type=images',
  'filebrowserFlashBrowseUrl':'/admin/kcfinder/browse.php?type=flash',
  'filebrowserUploadUrl':'/admin/kcfinder/upload.php?type=files',
  'filebrowserImageUploadUrl':'/admin/kcfinder/upload.php?type=images',
  'filebrowserFlashUploadUrl':'/admin/kcfinder/upload.php?type=flash'});
										</script>
									</td>
								</tr>*/ ?>
					</table><? if ($id):?>
						<input value="<?= $id ?>" type="hidden" name="id"/>
					<?endif; ?>
					<input name="tp" type="text" style="display:none;" value="<?= $tp ?>">
					<input name="activ" type="text" style="display:none;" value="<?= $act ?>">
				</div>
				<div id="tab2" class="tab_content">
					<p>
						<b>meta_title<span class="help_text" title="Загаловок окна браузера">?</span>:</b><br><input type="text" name="meta_title" class="text-input" value="<?= $myrow[meta_title] ?>"/>
					</p>
					<p>
						<b>meta_keywords:</b><br><input type="text" name="meta_keywords" class="text-input" value="<?= $myrow[meta_keywords] ?>"/>
					</p>
					<p>
						<b>meta_description:</b><br><input type="text" name="meta_description" class="text-input" value="<?= $myrow[meta_description] ?>"/>
					</p>
				</div>
				<div id="tab_sys_settings" class="tab_content">
					<p><b>Количество
							просмотров:</b><br><input type="text" name="views" class="text-input" value="<?= $myrow['views'] ?>"/>
					</p>
					<p><b>Дата последнего
							обновления:</b><br><span class="date_TIMESTAMP_X"><?= $myrow['TIMESTAMP_X'] ?></span><?/*<input type="text" name="TIMESTAMP_X" class="text-input" value=""/>*/ ?>
					</p>
					
					<? $RECOMMENDATIONS = [];
					if ($myrow['RECOMMENDATIONS']) {
						$RECOMMENDATIONS = unserialize($myrow['RECOMMENDATIONS']);
					}
					
					?>
					<div>
						<p><b>Рекомендации:</b></p>
						<ul id="PROP_RECOMMENDATIONS">
							<? foreach ($RECOMMENDATIONS as $value):?>
								<li>
									<input type="text" name="RECOMMENDATIONS[]" class="text-input" value="<?= $value ?>"/>
								</li>
							<?endforeach; ?>
							<li><input type="text" name="RECOMMENDATIONS[]" class="text-input" value=""/></li>
						</ul>
						<p>
							<span class="button add_element_prop btn " data-parent-id="PROP_RECOMMENDATIONS" data-type-parent="ul" data-add-type_block="<li>" data-add-type="<input:text>" data-add-name="RECOMMENDATIONS[]" data-add-class="text-input">Добавить</span>
						</p>
						<script>
							$(function () {
								$('.add_element_prop').click(function (e) {
									e.preventDefault();
									console.log(this);
									$obj = $(this);
									var parent_type = $obj.data('type-parent');
									var parent_id = $obj.data('parent-id');
									var add_type = $obj.data('add-type');
									var add_type_block = $obj.data('add-type_block');
									var add_name = $obj.data('add-name');
									var add_class = $obj.data('add-class');
									/*
							$('#'+parent_id).add(add_type_block).add(add_type)
								.attr('name',add_name)
								.addClass(add_class);

							$('<input>').attr({ type: 'text', id: 'test', name:'test'}).appendTo('#'+parent_id);*/
									$('#' + parent_id).append('<li><input type="text" class="' + add_class + '" name="' + add_name + '"></li>');
								});
							});
						</script>

						<style>
							.waves-effect {
								position: relative;
								cursor: pointer;
								display: inline-block;
								overflow: hidden;
								-webkit-user-select: none;
								-moz-user-select: none;
								-ms-user-select: none;
								user-select: none;
								-webkit-tap-highlight-color: transparent;
								vertical-align: middle;
								z-index: 1;
								will-change: opacity, transform;
								transition: all .3s ease-out;
							}

							.btn {
								transition: box-shadow 0.2s cubic-bezier(0.4, 0, 0.2, 1);
								transition-delay: 0.2s;
								box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26);
								padding: 2px 16px;
								display: inline-block;
								position: relative;
								height: 32px;
								line-height: 32px;
								border-radius: 2px;
								font-size: 0.9em;
								background-color: #fff;
								color: #646464;
								cursor: pointer;
							}

							.btn:active {
								box-shadow: 0 8px 17px 0 rgba(0, 0, 0, 0.2);
								transition-delay: 0s;
							}</style>
					</div>
				</div>
				<div id="tab3" class="tab_content">
					<p>Мультемедиа файлы к записи:</p>
					<?
					//echo $_SERVER['DOCUMENT_ROOT'].'<br>';
					$dir = $_SERVER['DOCUMENT_ROOT'] . '/images/' . $tp . "/" . $id . '/';
					//echo $dir.'<br>';
					if (file_exists($dir)) {
						$files1 = scandir($dir);
						$files2 = scandir($dir, 1);
						
						echo "<ul class='small_media'>";
					foreach ($files1 as $value) {
					if (getimagesize($dir . $value)) {
						$pos = strpos($dir, "public_html");
						$src_i = substr($dir, $pos + 11);
						?>
						<li>
							<div class="con">
								<div class="align-center">
									<a title="<?= $value ?>" href="<?= $src_i . $value ?>" class="fancybox_img_tab3" rel="group" target="_blank"><img src='<?= $src_i . $value ?>'/></a>
								</div>
								<div class="hover_con">
									<p class="url"><strong>Имя:</strong><br><?= $value ?></p>
									<p class="url"><strong>URL:</strong><br><?= $src_i . $value ?></p>
								</div>
							</div>
						</li>
					<?
					}
					}
					echo "</ul>"; ?>
						<script>
							$(function () {
								$(".fancybox_img_tab3").fancybox();
							});
						</script>
						<div style="clear:both"></div>
						<div>
							<span id="add_new_files">Добавить файл</span>
							<span id="status_new_files"></span>
							<!--List Files onclick="AddNewFiles('type?<?= $tp ?>?id?<?= $id ?>')"-->
							<ul id="files_new_files"></ul>
							<script>
								$(function () {
									var btnUpload = $('#add_new_files');
									var status = $('#status_new_files');
								});
							</script>

						</div>
					<?
					}
					else { ?>
						<div id="res_multimedia">
							<p>Папки не существует.</p>
							<p>
								<button id="create_folder" onclick="CreateFolder('type?<?= $tp ?>?id?<?= $id ?>')">
									Создать
								</button>
							</p>

						</div>
					<?
					}
					//print_r($files2);
					?>
				</div>
			</div>
			<input type="submit" class="save_bth" id='sub' value="Сохранить изменения">
		</form>
	<?
	}
}