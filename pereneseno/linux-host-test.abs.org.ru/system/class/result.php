<?php
/**
 * пользователь
 */
class result extends main
{	
	function __construct($data)
	{
		if(count($data) == 1 AND isset($data['id']))
		{
			$this->get(__CLASS__, $data);
			$this->task= new task(array('id'=>$this->task));
			$this->getRegistr_result();
			$this->user = new user(array('id'=>$this->user));
		}
		else
		{
			
			$collection = api::collection('result', array('task'=>$data['task'], 'user'=>$data['user']));

			$registr_result = $_SESSION['result']['registr_result'];
			unset($data['registr_result']);
			
			if (count($collection) == 0) 
			{
				$this->save(__CLASS__, $data);
				$resultID = $this->id;

			}
			else
			{
				
				foreach ($collection as $value) 
				{
					$resultID = $value->id;	
					$taskID = $value->task->id;	
					$userID = $value->task->user->id;
					
				};
				
			};
			$_SESSION['result']['id'] = $resultID;



			if (count($registr_result) >= 1) 
			{
				$sql = "INSERT INTO `registr_result` (`result`,`question`,`answer`,`answer_text`) VALUES (:result,:question,:answer,:answer_text)";
				db::init();
				if(!isset($registr_result->answer))
				{
					$registr_result->answer = NULL;
				};
				$param = array('result'=>$resultID,'question'=>$registr_result->question,'answer'=>$registr_result->answer,'answer_text'=>$registr_result->answer_text);
				$id = db::init()->insert($sql,$param);
				
			};
			
		};
	}

	public function getRegistr_result()
	{
		db::init();
		$sql = "SELECT * FROM `registr_result` WHERE `result` = :id";
		$registr_result = db::init()->getAll($sql,array('id'=>$this->id));

		$this->registr_result = array();

		foreach ($registr_result as $regResult) 
		{
			try {
				$regResult = (object)$regResult;
				$regResult->question = new question(array('id'=>$regResult->question));
				if(!is_null($regResult->answer))
				{
					$regResult->answer = new answer(array('id'=>$regResult->answer));
				};
				unset($regResult->result);
				$this->registr_result[] = $regResult;
			} catch (Exception $e) {
				main::printr($e);
			}
		};
	}
}
?>