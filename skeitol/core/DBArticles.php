<?php
/**
 * Created by PhpStorm.
 * User: skeit
 * Date: 18.04.2018
 * Time: 13:24
 */

namespace SkeitOl;


class DBArticles
{
	public static $DB_NAME = "articles";
	private $default_count = 10;
	var $DB;

	private function __construct()
	{
		$this->DB = new Core();
	}

	public function getArrResult(&$arParams)
	{
		$arResult = array();
		//сортировка по умолчанию
		$sql_sort_by = 'date';
		$sql_sort_order = "desc";

		//проверка arParams
		if (!$arParams["SELECT_CODE"] || empty($arParams["SELECT_CODE"]) || !is_array($arParams["SELECT_CODE"]))
			$arParams["SELECT_CODE"] = array("*");
		//сортировка
		if (!empty($arParams["SORT_BY"])) {
			if (in_array(strtolower($arParams["SORT_BY"]), array("desc", "asc")))
				$sql_sort_order = $arParams["SORT_BY"];
		}
		if (!empty($arParams["SORT_ORDER"])) {
			$sql_sort_by = htmlspecialchars($arParams["SORT_ORDER"]);
		}

//        if (!empty($arParams["FILTER"])) {
//            $filter_custom = htmlspecialchars($arParams["SORT_ORDER"]);
//        }


		$table_name = ($arParams["TABLE_NAME"]) ? $arParams["TABLE_NAME"] : self::$DB_NAME;
		$count_elements = 10;
		if ($arParams["COUNT"] && is_numeric($arParams["COUNT"])) {
			if ($arParams["COUNT"] > 0) $count_elements = $arParams["COUNT"];
		}


		//Записи
		if (isset($_GET['list'])) $list = htmlspecialchars($_GET['list']);
		else $list = 1;


		//Пагинация
		$startI = ($list - 1) * $count_elements;
		$endI = $startI + $count_elements;


		//$sql_query="SELECT * FROM articles WHERE active=1 ORDER BY ".$sql_sort_name." DESC LIMIT $startI,$endI";

		$SkeitOlCore = new Core();

		$arResult["ITEMS"] = $SkeitOlCore->GetList($table_name, array(
			"filter" => array("active" => 1),
			"order" => array($sql_sort_by => $sql_sort_order),
			"limit" => array("top" => $startI, "bottom" => $endI),
			"select" => $arParams["SELECT_CODE"]));

		unset($SkeitOlCore);

		return $arResult;
	}

	public static function ArticlesList($arParams = array(
		"TABLE_NAME" => '',
		"COUNT" => 10,
		'SELECT_CODE' => array("*"),
		"SORT_ORDER" => "date",
		"SORT_BY" => "desc",
	))
	{
		$obArticles= new namespace\DBArticles();
		$obArticles->getTemplate($obArticles->getArrResult($arParams));

		unset($obArticles);
	}

	public function getTemplate(&$arResult)
	{
		if ($arResult["ITEMS"]) {
			foreach ($arResult["ITEMS"] as $item) {
				//SkeiOl::dump($item);


				/**/$array1 = array();
				$array1 = unserialize($item['category']);
				$category_string = '';
				if (count($array1) > 0) {
					$category_string = "<div class='tags'>";
					for ($i = 0; $i < count($array1); $i++) {
						$row1 = $this->DB->GetList("category", array("filter" => array("id" => $array1[$i])));

						$category_string .= '<span class="item">' . $row1['name'] . '</span>';
						//if($i<count($array1)-1)echo ", ";
					}
					$category_string .= "</div>";
				}


				if (!empty($item['url'])) $url_page = $item['url']; else $url_page = $item['id'];

				setlocale(LC_ALL, 'ru_RU.UTF-8');
				$st_date = strftime('%d %h %Y %H:%M', strtotime($item['date']));
				//date_format(date_create($item['date']), 'd-M-Y H:i')


				?>
				<div class='news-item' itemscope itemtype='http://schema.org/Article'>
					<div class="left_con">
						<? $photo_img = strip_tags($item['src_preview']);
						if (empty($photo_img)) $photo_img = "/images/favicon/apple-touch-icon-114x114.png"; ?>
						<?/*<span class="photo_img" style="background-image: url('<?=$photo_img?>')"></span>*/
						?><a class='news-item-link' href='/articles/<?= $url_page ?>/'>
                <span class="photo_img lazy_load"
					  style="background-image: url('data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7')"
					  data-src="<?= $photo_img ?>"></span>
						</a>
					</div>
					<div class="right_con">
						<div class='news-title' itemprop='name'><a class='news-item-link'
																   href='/articles/<?= $url_page ?>/'><?= $item['title'] ?></a>
						</div>
						<div class='news-main'>
							<div class='news-text' itemprop='description'><?= $item['description'] ?></div>
							<div class='clear'></div>
						</div>
						<?= $category_string ?>
						<div class='news-data'><?= $st_date ?>
							<div class='view_block'><?= $item['views'] ?></div>
						</div>
					</div>
				</div>
				<?
			}
		}
	}

}