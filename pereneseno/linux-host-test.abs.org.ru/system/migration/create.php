<?php
ini_set('display_errors','On');
error_reporting('E_ALL');
include_once $_SERVER['DOCUMENT_ROOT'].'/system/config.php';

db::init();

try {
$sql = "ALTER TABLE `registr_task` ADD `bitrixTask` INT NULL DEFAULT NULL AFTER `token`";

//echo $sql;

$load_dump = db::init()->query($sql);
echo 'ok';
} catch (Exception $e) {
	echo '<pre>';
	print_r($e);
	echo '</pre>';
};



//$sql = "ALTER TABLE `test2` ADD `dff` INT NOT NULL AFTER `test`;";
//$sql .= "ALTER TABLE `test3` ADD `dff` INT NOT NULL AFTER `test`;";

//$migration = db::init()->query($sql);

?>