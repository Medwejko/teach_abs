<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

include_once $_SERVER['DOCUMENT_ROOT'].'/system/config.php';
echo 'start';
try {
db::init('localhost','mysql');

$sql = "DROP DATABASE IF EXISTS `".$GLOBALS['DBNAME']."`";

$drop_db = db::init()->query($sql);

$sql = "CREATE DATABASE IF NOT EXISTS `".$GLOBALS['DBNAME']."`";

$create_db = db::init()->query($sql);
echo '<br>ok';
} catch (Exception $e) {
echo '<pre>';
print_r($e);
echo '</pre>';
};
?>