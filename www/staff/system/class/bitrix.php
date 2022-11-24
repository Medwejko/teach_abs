<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/system/config.php';
date_default_timezone_set('Europe/Moscow');
if (isset($_REQUEST['id']) and isset($_REQUEST['date']))
{

	$id = $_REQUEST['id'];
	$date2 = $_REQUEST['date'];
	$taskStatus = api::bitrixStatus($id);
	
	$date = date("d.m.Y H:i", strtotime($date2));

	$collection = api::collection('task',array('id'=>$_REQUEST['id']));
	$users = array();
	foreach ($collection[0]->registr_task as $userTask) 
	{
		$userID = $userTask->user->id;

		main::printr($userTask);
		if (!isset($userTask->bitrixTask) and $userTask->status == 0 and $_SESSION['user']->group->access != 2) 
		{
			main::printr($_SESSION['user']);
			$admin = array();
			$admins[] = (object) array(
				"id"=>$_SESSION['user']->id,"surname"=>$_SESSION['user']->surname,"name"=>$_SESSION['user']->name,
			);
			$users = array();
			$users[] = (object) array(
				"id"=>$userTask->id,"second_name"=>$userTask->user->middlename,"surname"=>$userTask->user->surname,"name"=>$userTask->user->name,"token"=>$userTask->token,

			);
			$json = (object) array(
				"token" => "fasd9f84whnfHFujhkfs",
				"date" => $date,
				"admin" => $admins,
				"user" => $users,

				"task" => (object) array(
					"head" => "Пройти тест: ".$collection[0]->test->name,
					"body" => $collection[0]->test->BitrixMess." Для прохождения перейдите по ссылке:" 
				),
				"link" => (object) array(
					"url"=> "http://staff.ska.su/auth.php?task=".$id."&token="
				)

			);


			$query = json_encode($json, JSON_UNESCAPED_UNICODE);

			main::printr($query);

			$url = 'https://b24.ska.su/api/web/set/task';
			$options = 
			array(
				'http' => array(
					'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
					'method'  => 'POST',
					'content' => $query
				)

			);
			$context  = stream_context_create ($options);

			$result = file_get_contents($url, false, $context);

			$answers = json_decode($result);
			main::printr($result);
			main::printr($answers);
			$sql = "INSERT INTO `log` (`json`,`answer`,`task`) VALUES (:json,:answer,:task)";
			db::init();
			$param = array('json' => $query, 'answer' => $result, 'task' => $id);
			$registr_id = db::init()->insert($sql,$param);
			
			if ($answers[0]->result != 0) {
				db::init();
				$sql = "UPDATE `registr_task` SET `bitrixTask` = '".$answers[0]->result."' WHERE `task` = :task AND `user` = :user";

				$param = array('task'=>$id,'user'=>$userID);

				$status = db::init()->update($sql,$param);
			};			
		};
	};
};
?>