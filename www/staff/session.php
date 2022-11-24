<?php
include_once 'system/config.php';
if(!isset($_SESSION['user']->id))
{
	echo 'exit';
};
?>