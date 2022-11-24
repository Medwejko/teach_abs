<?php
/**
 * тест
 */
class task extends main
{	
	function __construct($data)
	{
		if(count($data) == 1 AND isset($data['id']))
		{
			$this->get(__CLASS__, $data);
			$this->user = new user(array('id'=>$this->user));
			$this->test = new test(array('id'=>$this->test));
			$this->project = new project(array('id'=>$this->project));


			$this->getRegistr_task();

		}
		elseif ($data['user'] == 0) 
		{
			
			$token1 = api::getToken($token);
			unset($data['tus_self']);
			unset($data['tus_boss']);
			unset($data['tus_subject']);
			unset($data['tus_colleague']);
			$data['user'] = 7000;
			main::printr($data);
			$this->save(__CLASS__, $data);

			$sql ="DELETE FROM `registr_task` WHERE `task` = :task AND `user` = :user";
			$param = array('task'=>$this->id, 'user'=>$this->user);
			db::init();
			$clear = db::init()->delete($sql,$param);

			$test = api::collection('test', array('id' => $data['test']));
			$timer = $test['0']->countdown;
			$parsed = date_parse($timer);
			$miliseconds = $parsed['hour'] * 3600000 + $parsed['minute'] * 60000 + $parsed['second']* 1000;

			$sql = "INSERT INTO `registr_task` (`task`,`user`,`tus`,`token`,`timer`) VALUES (:task,:user,:tus,:token,:timer)";
			$token1 = api::getToken($token);
			$param = array('user'=>$this->user,'task'=>$this->id, 'tus' => 1, 'token' => $token1, 'timer' => $miliseconds);
			$registr_id = db::init()->insert($sql,$param);
			$this->getRegistr_task();
			
		}
		else
		{
			main::printr($data);
			$tus_self = 0;
			$tus_colleague = [];
			$tus_boss = [];
			$tus_subject = [];
			$token = [];
			$token1 = api::getToken($token);
			
			if (isset($data['tus_self']))
			{
				$tus_self = 1;
				unset($data['tus_self']);
				
			};
			
			if (strlen($data['tus_boss']) >= 3)
			{
				$tus = $data['tus_boss'];
				$tus = substr($tus, 1);
				$tus = substr($tus, 0, -1);
				$tus_boss = explode(",", $tus);
			};
			unset($data['tus_boss']);

			if (strlen($data['tus_subject']) >= 3)
			{
				$tus = $data['tus_subject'];
				
				$tus = substr($tus, 1);
				$tus = substr($tus, 0, -1);
				$tus_subject = explode(",", $tus);
			};
			unset($data['tus_subject']);

			if (strlen($data['tus_colleague']) >= 3)
			{
				$tus = $data['tus_colleague'];
				
				$tus = substr($tus, 1);
				$tus = substr($tus, 0, -1);
				$tus_colleague = explode(",", $tus);
			};
			unset($data['tus_colleague']);

			$this->save(__CLASS__, $data);

			$taskDel = api::collection('task', array('id' => $this->id));
			$taskDel = $taskDel['0'];

			foreach ($taskDel->registr_task as $keyDel => $regDel) 
			{
				
				if ($tus_self == 1) {
					if ($regDel->user->id == $this->user and $regDel->tus == 1) {
						unset($taskDel->registr_task[$keyDel]);
						$tus_self = 0;
					};
				};

				if (count($tus_subject) != 0) 
				{
					foreach ($tus_subject as $keySub => $tusSub) 
					{


						if ($regDel->user->id == $tusSub and $regDel->tus == 4) 
						{
							unset($taskDel->registr_task[$keyDel]);
							unset($tus_subject[$keySub]);
							main::printr($tus_subject);

						};
					# code...
					};
				};
				if (count($tus_colleague) != 0) 
				{
					foreach ($tus_colleague as $keyColl => $tusColl) 
					{


						if ($regDel->user->id == $tusColl and $regDel->tus == 3) 
						{
							unset($taskDel->registr_task[$keyDel]);
							unset($tus_colleague[$keyColl]);


						};
					# code...
					};
				};
				if (count($tus_boss) != 0) 
				{
					foreach ($tus_boss as $keyBoss => $tusBoss) 
					{


						if ($regDel->user->id == $tusBoss and $regDel->tus == 2) 
						{
							unset($taskDel->registr_task[$keyDel]);
							unset($tus_boss[$keyBoss]);


						};
					# code...
					};
				};
				
			};
			/*очищаем регистр*/
			main::printr($taskDel->registr_task);

			if (count($taskDel->registr_task) != 0) 
			{
				foreach ($taskDel->registr_task as $regDel) 
				{
					if (isset($regDel->bitrixTask)) {
						api::endTask($this->id,$regDel->user->id);
					};
					db::init();
					$sql ="DELETE FROM `registr_task` WHERE `task` = :task AND `user` = :user";
					$param = array('task'=>$this->id, 'user'=>$regDel->user->id);
					db::init();
					$clear = db::init()->delete($sql,$param);
					
					$sql ="DELETE FROM `result` WHERE `task` = :task AND `user` = :user";
					$param = array('task'=>$this->id, 'user'=>$regDel->user->id);
					db::init();
					$clear = db::init()->delete($sql,$param);
				};
			};

			/*сохраняем новых пользователей в задаче*/
			$test = api::collection('test', array('id' => $data['test']));
			$timer = $test['0']->countdown;
			$parsed = date_parse($timer);

			$miliseconds = $parsed['hour'] * 3600000 + $parsed['minute'] * 60000 + $parsed['second']* 1000;

			$sql = "INSERT INTO `registr_task` (`task`,`user`,`tus`,`token`,`timer`) VALUES (:task,:user,:tus,:token,:timer)";
			if ($tus_self != 0) 
			{
				$token1 = api::getToken($token);
				$param = array('user'=>$this->user,'task'=>$this->id, 'tus' => 1, 'token' => $token1, 'timer' => $miliseconds);
				$registr_id = db::init()->insert($sql,$param);
			}
			if (count($tus_boss) != 0) 
			{
				foreach ($tus_boss as $tusID) 
				{
					$token1 = api::getToken($token);
					$param = array('user'=>$tusID,'task'=>$this->id, 'tus' => 2, 'token' => $token1, 'timer' => $miliseconds);
					$registr_id = db::init()->insert($sql,$param);
				}
			}

			if (count($tus_colleague) != 0) 
			{
				foreach ($tus_colleague as $tusID) 
				{			
					$token1 = api::getToken($token);
					$param = array('user'=>$tusID,'task'=>$this->id, 'tus' => 3, 'token' => $token1, 'timer' => $miliseconds);
					$registr_id = db::init()->insert($sql,$param);
				}
			}
			
			if (count($tus_subject) != 0) 
			{
				foreach ($tus_subject as $tusID) 
				{
					$token1 = api::getToken($token);
					$param = array('user'=>$tusID,'task'=>$this->id, 'tus' => 4, 'token' => $token1, 'timer' => $miliseconds);
					$registr_id = db::init()->insert($sql,$param);
				}

			}			

			
			$this->getRegistr_task();
			
		};
	}

	public function getRegistr_task()
	{
		db::init();
		$sql = "SELECT * FROM `registr_task` WHERE `task` = :id";
		$registr_task = db::init()->getAll($sql,array('id'=>$this->id));

		$this->registr_task = array();

		foreach ($registr_task as $registr) 
		{
			$registr = (object)$registr;
			$registr->user = new user(array('id'=>$registr->user));
			unset($registr->task);
			$this->registr_task[] = $registr;
		};
		
	}

	


}
?>