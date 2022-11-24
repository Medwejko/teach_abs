<?php
class api
{
	public static function saveResult($result,$user,$data)
	{
		$sql ="DELETE FROM `registr_result` WHERE `result` = :result";
		$param = array('result'=>$result);
		db::init();
		$clear = db::init()->delete($sql,$param);
		$sql = "INSERT INTO `registr_result` (`result`,`question`,`answer`,`answer_text`) VALUES (:result,:question,:answer,:answer_text)";

		foreach ($data as $value) {
			$answer = self::collection('answer',array('question' => $value['question'], 'weight' => $value['answer']));
			main::printr($answer[0]->id);
			$param = array('result'=>$result,'question'=>$value['question'], 'answer' => $answer[0]->id, 'answer_text' => $value['answer_text']);
			$registr_result = db::init()->insert($sql,$param);
		};
	}

	public static function dynamicSelect($class,$properties,$mask)
	{
		$properties = str_replace('\'', '"', $properties);

		$filter = json_decode($properties);
		$option = array(
			'type' => 'like', 
			'mask' => $mask
		);
		$result = self::collection($class,$filter,$option);
		return $result;
	}

	public static function dynamicSelectTask($class,$properties,$mask)
	{
		$properties = str_replace('\'', '"', $properties);

		$filter = json_decode($properties);
		$option = array(
			'type' => 'like', 
			'mask' => $mask
		);
		$users = self::collection($class,$filter,$option);
		$tasks = [];
		foreach ($users as $user) 
		{

			$task = self::collection('task', array('user' => $user->id));
			if (isset($task[0])) 
			{
				$tasks[] = $task;
			}
		}
		return $tasks;
	}

	public static function dynamicSelectResult($class,$properties,$mask)
	{
		$properties = str_replace('\'', '"', $properties);

		$filter = json_decode($properties);
		$option = array(
			'type' => 'like', 
			'mask' => $mask
		);
		$result = self::collection($class,$filter,$option);
		if ($_SESSION['user']->group->access == 1) 
		{
			$userCollection = [];
			$projectAdmin = self::projCol($_SESSION['user']->id);
			$sql = "SELECT * FROM `task` WHERE ";
			
			foreach ($projectAdmin as $projID) 
			{
				$sql .= "`project` = ".$projID." OR ";
			};
			$sql = substr($sql, 0, -4);
			db::init();
			$taskColl = db::init()->getAll($sql);
			
			foreach ($taskColl as $userTask) 
			{
				$i = 0;
				foreach ($result as $userResult) 
				{

					if ($userTask['user'] == $userResult->id) 
					{
						
						unset($result[$i]);
						array_push($userCollection, $userResult);
					}
					$i++;
				}

			}
		}
		else
		{
			$userCollection = $result;
		}
		
		return $userCollection;

	}


	public static function dsCollection($id,$tus)
	{
		$collection = array();
		$sql = "SELECT * FROM `registr_task` WHERE `task` = :task AND `tus` = :tus";
		$param = array('task'=>$id,'tus'=>$tus);

		db::init();
		$users = db::init()->getAll($sql,$param);


		foreach($users as $user)
		{
			
			$collection[] = new user(array('id' =>$user['user']));
			
		};

		return $collection;
	}

	public static function reservCollection($id)
	{
		$collection = array();
		$sql = "SELECT * FROM `user_reserv` WHERE `user` = :user OR `reserv` = :reserv";
		$param = array('user'=>$id,'reserv'=>$id);

		db::init();
		$users = db::init()->getAll($sql,$param);


		foreach($users as $user)
		{
			
			$collection['user'][] = new user(array('id' =>$user['user']));
			$collection['reserv'][] = new user(array('id' =>$user['reserv']));
			
		};

		return $collection;
	}

	public static function projCol($adminID)
	{

		$sql = "SELECT * FROM `admin_control` WHERE `user` = :id";
		db::init();
		$projCol = db::init()->getAll($sql,array('id'=>$adminID));
		
		$collection = [];
		foreach ($projCol as $value) 
		{
			array_push($collection, $value['project']);
		}

		return $collection;
	}

	public static function pageProjcol($class,$filter = array())
	{
		//array('name'=>'Иван','surname'=>'Иванов')
		

		$sql = "SELECT COUNT(*) FROM `$class` WHERE " ;
		
		foreach ($filter as $projID) 
		{
			$sql .="`project` = ".$projID." OR ";
		};
		$sql = substr($sql, 0, -4);
		$result = db::init()->getAll($sql);
		
		$count = $result['0']['COUNT(*)'];
		$pagecol = $count / 14;
		$pagecol = ceil($pagecol);
		
		return $pagecol;
	}


	public static function pagecol($class,$filter = array())
	{
		//array('name'=>'Иван','surname'=>'Иванов')
		

		if(count($filter) != 0)
		{
			$sql = "SELECT COUNT(*) FROM `".$class."` WHERE ";
			$param = array();
			
			foreach ($filter as $key => $value) 
			{
				$sql .= "`".$key."` = :".$key." AND ";
				$param[$key] = $value;
			};
			$sql = substr($sql, 0, -5);


			

			db::init();
			$result = db::init()->getAll($sql,$param);
		}
		else
		{
			$sql = "SELECT COUNT(*) FROM `".$class."`";
			db::init();
			$result = db::init()->getAll($sql);
		};
		$count = $result['0']['COUNT(*)'];
		$pagecol = $count / 14;
		$pagecol = ceil($pagecol);
		main::printr($pagecol);
		return $pagecol;
	}

	public static function getToken($token)
	{
		date_default_timezone_set('Europe/Moscow');
		$currentdate = date("Y-m-d");
		$generator = uniqid();
		$token = $currentdate.$generator;
		return $token;

	}

	public static function obj($obj,$data)
	{
		main::printr($obj);
		main::printr($data);
		return new $obj($data);		
	}

	//коллекцию объектов \\SELECT * FROM `user` WHERE `id` IN (SELECT `user` AS `id` FROM `registr_task` WHERE `task` = 256)
	public static function collection($class,$filter = array(),$option = array('type' => 'default'))
	{
		//array('name'=>'Иван','surname'=>'Иванов')
		$collection = array();

		if(count($filter) != 0)
		{
			$sql = "SELECT `id` FROM `".$class."` WHERE ";
			$param = array();
			switch ($option['type']) {
				case 'like':
				foreach ($filter as $key) 
				{
					$sql .= "`".$key."` LIKE :".$key." OR ";
					$param[$key] = $option['mask'].'%';
				};
				$sql = substr($sql, 0, -4);
				break;
				
				default:
				foreach ($filter as $key => $value) 
				{
					$sql .= "`".$key."` = :".$key." AND ";
					$param[$key] = $value;
				};
				$sql = substr($sql, 0, -5);
				
				break;
			};

			db::init();
			$result = db::init()->getAll($sql,$param);
		}
		else
		{
			$sql = "SELECT `id` FROM `".$class."`";
			db::init();
			$result = db::init()->getAll($sql);
		};

		foreach($result as $id)
		{
			//$id = array('id'=>1)
			$collection[] = new $class($id);
		};

		return $collection;
	}

	//коллекцию объектов для list \\SELECT * FROM `user` WHERE `id` IN (SELECT `user` AS `id` FROM `registr_task` WHERE `task` = 256)
	public static function listCollection($class,$page,$filter = array())
	{
		//array('name'=>'Иван','surname'=>'Иванов')
		$lsitCollection = array();
		$pagecount = $page * 14;
		main::printr($filter);
		if(count($filter) != 0)
		{
			$sql = "SELECT `id` FROM `".$class."` WHERE ";
			$param = array();
			
			foreach ($filter as $key => $value) 
			{
				$sql .= "`".$key."` = :".$key." AND ";
				$param[$key] = $value;
			};
			$sql = substr($sql, 0, -4);
			$sql .="ORDER BY `id` DESC LIMIT ".$pagecount.",14";	
			
			main::printr($sql);
			db::init();
			$result = db::init()->getAll($sql,$param);
		}
		else
		{
			$sql = "SELECT `id` FROM `".$class."` ORDER BY `id` DESC LIMIT ".$pagecount.",14";
			db::init();
			$result = db::init()->getAll($sql);
		};

		foreach($result as $id)
		{
			//$id = array('id'=>1)
			$lsitCollection[] = new $class($id);
		};

		return $lsitCollection;
	}
	public static function listProjCollection($class,$page,$filter = array())
	{
		//array('name'=>'Иван','surname'=>'Иванов')
		$lsitCollection = array();
		$pagecount = $page * 14;
		main::printr($filter);
		if(count($filter) != 0)
		{

			$sql = "SELECT `id` FROM `".$class."` WHERE ";
			
			foreach ($filter as $projID) 
			{
				$sql .= "`project` = ".$projID." OR ";
			};
			$sql = substr($sql, 0, -4);
			$sql .=" ORDER BY `id` DESC LIMIT ".$pagecount.",14";	
			main::printr($sql);

			db::init();
			$result = db::init()->getAll($sql);
		}
		else
		{
			$sql = "SELECT `id` FROM `".$class."` ORDER BY `id` DESC LIMIT ".$pagecount.",14";
			db::init();
			$result = db::init()->getAll($sql);
		};

		foreach($result as $id)
		{
			//$id = array('id'=>1)
			$lsitCollection[] = new $class($id);
		};

		return $lsitCollection;
	}
	//коллекцию объектов \\SELECT * FROM `user` WHERE `id` IN (SELECT `user` AS `id` FROM `registr_task` WHERE `task` = 256)
	public static function userCollection($task)
	{
		
		//array('name'=>'Иван','surname'=>'Иванов')
		

		$sql = "SELECT * FROM `user` WHERE `id` IN (SELECT `user` AS `id` FROM `registr_task` WHERE `task` = :task)";
		$param = array('task'=>$task);
		
		db::init();


		$result = db::init()->getAll($sql,$param);
		

		return $result;
	}

	public static function delete($class,$id)
	{
		if ($class == 'task') {
			$sql = "SELECT * FROM `registr_task` WHERE `task` = :task";
			$param = array('task'=>$id);
			$bitrixTask = db::init()->getAll($sql,$param);
			main::printr($bitrixTask);
			$sql = "SELECT * FROM `user` WHERE `id` = :id";
			foreach ($bitrixTask as $obj) {
				$param = array('id'=>$obj['user']);
				$userColl = db::init()->getAll($sql,$param);
				$users = array();
				$users[] = (object) array(
					"id"=>$obj['user'],"surname"=>"Битрикс24","name"=>"","taskId"=>$obj['bitrixTask']

				);

				$json = (object) array(
					"token" => "fasd9f84whnfHFujhkfs",
					"user" => $users
				);


				$query = json_encode($json, JSON_UNESCAPED_UNICODE);


				$url = 'https://b24.ska.su/api/web/set/deleteTask';
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
			}
			$sql ="DELETE FROM `registr_task` WHERE `task` = :task";
			$param = array('task'=>$id);
			$clear = db::init()->delete($sql,$param);
		}
		else if ($class == 'user') 
		{
			$sql ="DELETE FROM `registr_task` WHERE `user` = :user";
			$param = array('user'=>$id);
			$clear = db::init()->delete($sql,$param);
			$sql ="DELETE FROM `task` WHERE `user` = :user";
			$param = array('user'=>$id);
			$clear = db::init()->delete($sql,$param);
		}
		else if ($class == 'subunit') {
			db::init();
			$sql = "UPDATE `user` SET `subunit` = '100' WHERE `subunit` = :subunit";
			$param = array('subunit'=>$id);

			$status = db::init()->update($sql,$param);

			db::init();
			$sql = "UPDATE `task` SET `subunit` = '100' WHERE `subunit` = :subunit";
			$param = array('subunit'=>$id);

			$status = db::init()->update($sql,$param);
		}
		else if ($class == 'test') {
			db::init();
			$sql ="DELETE FROM `registr_test_question` WHERE `test` = :test";
			$param = array('test'=>$id);

			$clear = db::init()->delete($sql,$param);
		}
		else if ($class == 'question') {
			db::init();
			$sql ="DELETE FROM `registr_test_question` WHERE `question` = :question";
			$param = array('question'=>$id);

			$clear = db::init()->delete($sql,$param);
			$sql ="DELETE FROM `answer` WHERE `question` = :question";
			$param = array('question'=>$id);

			$clear = db::init()->delete($sql,$param);
		}
		return main::delete($class,$id);
	}

	public static function taskCollection($id,$status)
	{
		$taskCollection = array();
		$sql = "SELECT `task` AS `id` FROM `registr_task` WHERE `user` = :user AND `status` = :status";
		$param = array('user'=>$id,'status'=>$status);

		db::init();
		$tasks = db::init()->getAll($sql,$param);
		foreach ($tasks as $task) 
		{
			$taskCollection[] = new task($task);
		};
		return $taskCollection;
	}

	public static function dmCollection($id,$status)
	{
		$taskCollection = array();
		$sql = "SELECT * FROM `registr_task` WHERE `user` = :user AND `tus` = :tus";
		$param = array('user'=>$id,'tus'=>$status);

		db::init();
		$tasks = db::init()->getAll($sql,$param);
		foreach ($tasks as $task) 
		{
			$taskCollection[] = new task($task);
		};
		return $taskCollection;
	}

	public static function bitrixStatus($id)
	{
		db::init();
		$sql = "UPDATE `task` SET `status` = '1' WHERE `id` = :task";
		$param = array('task'=>$id);
		db::init();
		try {
			$status = db::init()->update($sql,$param);

		} catch (Exception $e) {
			main::printr($e);
		};
	}

	public static function endTask($task,$user)
	{
		
		$sql = "SELECT `bitrixTask` AS `id` FROM `registr_task` WHERE `task` = :task AND `user` = :user";
		$param = array('task'=>$task,'user'=>$user);
		$bitrixTask = db::init()->getAll($sql,$param);
		$sql = "SELECT * FROM `user` WHERE `id` = :id";
		$param = array('id'=>$user);
		$userColl = db::init()->getAll($sql,$param);
		main::printr($userColl[0]);
		$users = array();
		$users[] = (object) array(
			//"id"=>$user,"surname"=>$userColl['0']['surname'],"name"=>$userColl['0']['name'],"taskId"=>$bitrixTask[0]['id']
			"id"=>$user,"surname"=>"Битрикс24","name"=>"","taskId"=>$bitrixTask[0]['id']

		);
		
		$json = (object) array(
			"token" => "fasd9f84whnfHFujhkfs",
			"user" => $users
		);


		$query = json_encode($json, JSON_UNESCAPED_UNICODE);

		main::printr($query);

		$url = 'https://b24.ska.su/api/web/set/deleteTask';
		$options = 
		array(
			'http' => array(
				'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
				'method'  => 'POST',
				'content' => $query
			)
			
		);
		$context  = stream_context_create ($options);
		main::printr($query);
		$result = file_get_contents($url, false, $context);

		$answers = json_decode($result);
		main::printr($result);
		unset($_SESSION['task']);
		if ($user != 7000) {
			$sql = "UPDATE `registr_task` SET `status` = '1',`token` = '' WHERE `task` = :task AND `user` = :user";
			$param = array('task'=>$task,'user'=>$user);
			
			try 
			{
				$status = db::init()->update($sql,$param);
			} 
			catch (Exception $e) 
			{
				main::printr($e);
			};
		}

		db::init();
		$sql = "SELECT * FROM `registr_task` WHERE `task` = :task AND `status` = 0";
		$param = array('task'=> $task);
		$status = db::init()->getAll($sql,$param);

		if (!isset($status['0'])) {
			$sql = "UPDATE `task` SET `status` = '2' WHERE `id` = :task";
			$param = array('task'=>$task);
			try 
			{
				$statusT = db::init()->update($sql,$param);
			} 
			catch (Exception $e) 
			{
				main::printr($e);
			};
		}
		


	}
}
?>