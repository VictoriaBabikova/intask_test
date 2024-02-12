<?php
header('Content-Type: application/json;charset=utf-8;');

require_once($_SERVER["DOCUMENT_ROOT"]."/config.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/cp/content/test/create_table_list.php");

$DP_Config = new DP_Config;//Конфигурация CMS
//Подключение к БД
try
{
	$db_link = new PDO('mysql:host='.$DP_Config->host.';dbname='.$DP_Config->db, $DP_Config->user, $DP_Config->password);
}
catch (PDOException $e) 
{
    $answer = array();
	$answer["status"] = false;
	$answer["message"] = "No DB connect";
	exit( json_encode($answer) );
}
$db_link->query("SET NAMES utf8;");

// создание таблицы с данными
$creator = new Creator_table($names, $surnames, $phones, $db_link);
$result = $creator->creatorTable();
 // 


$id = htmlentities(trim($_POST["data"]["id"]));
if ($id == 1) {
	$id = 0;
}
$count = htmlentities(trim($_POST["data"]["count"]));

//Информация о запросе
$array_data = $db_link->query("SELECT *  FROM `people_list` LIMIT $count OFFSET $id;");  // знаю нужно было использовать запрос с параметрами,но в limit и в offset не получилось их поставить, запрос не собирался
$arr = $array_data->fetchAll();

foreach ($arr as $key => $items) {
    foreach ($items as $k => $item) {
        if (!is_int($k)) {
            $data[$key][$k] = $item;
        }
    }
}
exit(json_encode($data));
?>