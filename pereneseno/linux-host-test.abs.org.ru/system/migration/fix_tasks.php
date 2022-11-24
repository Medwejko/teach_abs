<?php
ini_set('display_errors','On');
error_reporting('E_ALL');
include_once $_SERVER['DOCUMENT_ROOT'].'/system/config.php';



$registr = api::collection('registr_task', array('status' => 0));
foreach ($registr as $regist) {
	if($regist->task->status == 2)
	{
		main::printr($regist->task->id);
		$sql = "UPDATE `task` SET `status` = '1' WHERE `id` = :task";
		$param = array('task'=>$regist->task->id);
			
		$statusT = db::init()->update($sql,$param);

	}
}


?>