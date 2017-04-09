<?php

namespace SkeitOl {

    use mysqli;

    define("DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]);

    class SkeiOl
    {

        private $DB_CONFIG = array();

        function __construct()
        {
            $this->init();
        }

        function __destruct()
        {
            unset($this->DB_CONFIG);
        }

        private function init()
        {
            if (!require(DOC_ROOT . "/skeitol/config.php")) die("Error open SQLConnect config file");
            if (!empty($DB)) {
                $this->DB_CONFIG["host"] = ($DB["host"]) ? $DB["host"] : "localhost";
                $this->DB_CONFIG["username"] = ($DB["username"]) ? $DB["username"] : "";
                $this->DB_CONFIG["passwd"] = ($DB["passwd"]) ? $DB["passwd"] : "";
                $this->DB_CONFIG["dbname"] = ($DB["dbname"]) ? $DB["dbname"] : "";

                if (empty($this->DB_CONFIG["username"]) OR empty($this->DB_CONFIG["dbname"]))
                    die("Error settings SQLConnect config file");

                if (!$this->ObjConnectServer()) {
                    die("Error connect DB");
                }

            } else die("Error DB settings");


        }

        public static function dump($var,$printr=false)
        {
            if(!$printr){
                echo "<pre>";
                $result='';
                ob_start();
                var_dump($var);
                $result = ob_get_clean();
                echo"$result";
                echo "</pre>";
            }else{
                echo "<pre>" . print_r($var,true) . "</pre>";
            }
        }

        /**
         * @return mysqli
         */
        private function ObjConnectServer()
        {
            $mysqli = new mysqli($this->DB_CONFIG["host"], $this->DB_CONFIG["username"], $this->DB_CONFIG["passwd"], $this->DB_CONFIG["dbname"]);
            // проверка соединения /
            if ($mysqli->connect_errno) {
                die("Не удалось подключиться: " . $mysqli->connect_error . "\n");
            }
            return $mysqli;
        }

        /**
         * Запрос к БД
         *
         * @param $string SQL-строка запроса
         * @return array|bool
         */
        public function SQLQuery($string)
        {

            if (!empty($string)) {
                $dataArr = array();
                $mysqli = $this->ObjConnectServer();

                // Посылаем запрос серверу
                if ($result = $mysqli->query($string)) {

                    // Выбираем результаты запроса:
                    while ($row = $result->fetch_assoc()) {
                        $dataArr[] = $row;
                    }
                    // Освобождаем память
                    $result->close();
                }
                // Закрываем соединение
                $mysqli->close();

                return $dataArr;
            } else {
                return false;
            }

        }

        public function __debugInfo()
        {
            return [
                'DB_CONFIG' => array("1"),
            ];
        }

        /**
         * Выводим список из БД таблицы
         */

        /**
         * @param $table_name
         * @param array $arr_params =array("select"=>array("*"),
         * "filter"=>array(),
         * "order"=>array(),
         * "limit"=>array("top"=>'1','bottom'=>"10"),
         * @return array|bool
         */
        public function GetList($table_name, $arr_params = array()
            //$arr_select = array("*"), $arr_filter = array(),$arr_order = array(),$arr_limit=array()
        )
        {
            $arr_data = array();
            if ($table_name) {
                $select_default = "*";
                $select = "";
                if (!empty($arr_params["select"]))
                    if (is_array($arr_params["select"]) && count($arr_params["select"]) > 0) {
                        foreach ($arr_params["select"] as $val) {
                            if (!empty($val)) {
                                $select .= htmlspecialchars($val) . ", ";
                            }
                        }
                        $select = mb_substr($select, 0, -2);
                    }

                if (!$select) $select = $select_default;

                $filter = "";
                //if($_SERVER['REMOTE_ADDR']=="5.158.233.184"){ SkeiOl::dump($arr_params);}
                if (!empty($arr_params["filter"]))
                    if (is_array($arr_params["filter"]) && count($arr_params["filter"]) > 0) {
                        $n = count($arr_params["filter"]);
                        $i = 0;
                        foreach ($arr_params["filter"] as $key => $item) {
                            if ($i != 0)
                                $filter .= ' AND ';

                            $def_operator = "=";
                            if (in_array($key[0], array('>', '!', '<'))) {
                                $rep_length = 1;
                                if ($key[1] == '=') $rep_length = 2;
                                if ($key[0] == "!") {
                                    $def_operator = "<>";
                                } else {
                                    $def_operator = substr($key, 0, $rep_length);
                                    $key = substr($key, $rep_length);
                                }
                            }
                            if (!in_array(gettype($item), array('integer', 'double'))) {
                                if(gettype($item)=="array"){
                                    $def_operator="in";
                                    $titem='';
                                    foreach($item as $arItem){
                                        $titem.=$arItem.',';
                                    }
                                    $titem=substr($titem,0,-1);
                                    $item='('.$titem.')';
                                }else{
                                 $item = "'" . htmlspecialchars($item) . "'";
                                }
                            }

                            $filter .= htmlspecialchars($key) . " " . $def_operator . " " . $item;
                            $i++;
                        }
                    }

                $order = "";
                if (!empty($arr_params["order"]))
                    if (is_array($arr_params["order"]) && count($arr_params["order"]) > 0) {
                        $n = count($arr_params["order"]);
                        $i = 0;
                        foreach ($arr_params["order"] as $key => $item) {
                            if ($i != 0)
                                $order .= ', ';
                            $order .= htmlspecialchars($key) . " " . htmlspecialchars($item);
                            $i++;
                        }
                    }
                $limit = "";
                if (!empty($arr_params["limit"]))
                    if (is_array($arr_params["limit"]) && count($arr_params["limit"]) > 0) {
                        if (isset($arr_params["limit"]["top"])) {
                            $limit = ($arr_params["limit"]["top"]);
                            if ($arr_params["limit"]["bottom"])
                                $limit .= "," . ($arr_params["limit"]["bottom"]);
                        }
                    }

                $sql_query = "SELECT " . $select . " FROM " . $table_name . ' ';

                if ($filter) {
                    $sql_query .= 'WHERE ' . $filter . ' ';
                }
                if ($order) {
                    $sql_query .= 'ORDER BY ' . $order . ' ';
                }
                if ($limit) {
                    $sql_query .= 'LIMIT ' . $limit . ' ';
                }


                //Запрос к БД
                //if($_SERVER['REMOTE_ADDR']=="5.158.233.184"){ SkeiOl::dump($sql_query);}


                $arr_data = $this->SQLQuery($sql_query);


            }
            return $arr_data;
        }
    }

    $SketOl = new SkeiOl;


    class DBArticles
    {
        public static $DB_NAME = "articles";
        private $default_count = 10;
        var $DB;

        private function __construct()
        {
            $this->DB = new SkeiOl();
        }

        public function GetArrResult(&$arParams)
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


            $table_name = ($arParams["TABLE_NAME"]) ? $arParams["TABLE_NAME"] : DBArticles::$DB_NAME;
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

            $SkeiOl = new SkeiOl();

            $arResult["ITEMS"] = $SkeiOl->GetList($table_name, array(
                "filter" => array("active" => 1),
                "order" => array($sql_sort_by => $sql_sort_order),
                "limit" => array("top" => $startI, "bottom" => $endI),
                "select" => $arParams["SELECT_CODE"]));

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
            DBArticles::GetTemplate(DBArticles::GetArrResult($arParams));

        }

        public function GetTemplate(&$arResult)
        {
            if ($arResult["ITEMS"]) {
                foreach ($arResult["ITEMS"] as $item) {
                    //SkeiOl::dump($item);


                    /*$array1 = array();
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
                    }*/


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
}