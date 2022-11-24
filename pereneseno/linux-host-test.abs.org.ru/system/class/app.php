<?php

/**
 * Приложение
 */
class app
{	
	function __construct($param)
	{
		$param = (object) $param;
		if(isset($param->query))
		{
			switch ($param->query) 
			{
				case 'StartTask':
				$this->StartTask($param->id);
				break;

				case 'getQuestion':
				$this->getQuestion();
				break;
				
				case 'endTask':
				$this->endTask();
				break;

				case 'StartBitrixTask':
				$this->StartBitrixTask($param->id);
				break;

				case 'getQuestionCol':
				$this->getQuestionCol();
				break;

				case 'addResultData':

                    unset($param->query);
				$this->addResultData($param);
				break;

				case 'updateResultData':
				unset($param->query);
				$this->updateResultData($param);
				break;

				case 'auth':
				unset($param->query);
				$sql = "SELECT `user`.`id`,`group`.`access` FROM `user` LEFT JOIN `group` ON `user`.`group` = `group`.`id` WHERE `login` = :login AND `password` = :password"; 
				db::init();
				$user = db::init()->getObj($sql, (array) $param);
				if($user AND $user->access == 2)
				{
					$_SESSION['user'] = new user(array('id'=>$user->id));
					header('Location: ../user_interface.php');
				}
				elseif($user AND $user->access <= 1)
				{
					$_SESSION['user'] = new user(array('id'=>$user->id));
					header('Location: ../index.php');
				}
				else
				{
					header('Location: ../auth.php?error=1');
				};
				break;

				

				default:
					# code...
				break;
			}

		}
		else
		{
			echo '{"status":"error","desc":"query not set"}';
		};
	}

	public function StartTask($id)
	{
		$_SESSION['task'] = new task(array('id'=>$id));
		$_SESSION['result'] = array();
		$_SESSION['result']['registr_result'] = array();
		foreach ($_SESSION['task']->registr_task as $registr_task) {
			if ($registr_task->user->id == $_SESSION['user']->id) {
				$timer = $registr_task->timer;
			}
		}
		$_SESSION['timer'] = $timer;


		if(count($_SESSION['task']->test->question) != 0)
		{
			echo '{"status":"ok"}';
			$_SESSION['result']['user'] = $_SESSION['user']->id;
			$_SESSION['result']['task'] = $_SESSION['task']->id;
			$tsk = $_SESSION['task'];

			foreach($tsk->registr_task as $obj)
			{
				if ($_SESSION['user']->id == $obj->user->id)
				{
					$tus = $obj->tus;
				};
			};
			$_SESSION['result']['tus'] = $tus;
			$this->saveResult();
		}
		else
		{
			unset($_SESSION['task']);
			echo '{"status":"error","desc":"Тест не содержит вопросов"}';
		};
	}

	public function StartBitrixTask($task,$user,$token)
	{
		$_SESSION['user'] = new user(array('user'=>$user));
		$_SESSION['task'] = new task(array('task'=>$task));
		$_SESSION['result'] = array();
		$_SESSION['result']['registr_result'] = array();
		

		if(count($_SESSION['task']->test->question) != 0)
		{
			echo '{"status":"ok"}';
			$_SESSION['result']['user'] = $_SESSION['user']->id;
			$_SESSION['result']['task'] = $_SESSION['task']->id;
			$tsk = $_SESSION['task'];
			foreach($tsk->registr_task as $obj)
			{
				if ($_SESSION['user']->id == $obj->user->id)
				{
					$tus = $obj->tus;
				};
			};
			$_SESSION['result']['tus'] = $tus;
			$this->saveResult();
		}
		else
		{
			unset($_SESSION['task']);
			echo '{"status":"error","desc":"Тест не содержит вопросов"}';
		};
	}

	public function getQuestionCol()
	{
		$position = 1;
		$questionCol = 0;
		$task = api::collection('task', array('id'=>$_SESSION['task']->id));
		foreach ($task['0']->test->question as $value) 
		{

			
			$questionCol ++;
		};
		$this->questionCol = $questionCol;
	}

	public function getQuestion()
	{
		$position = 1;
		$questionCol = 0;
		$task = api::collection('task', array('id'=>$_SESSION['task']->id));
		foreach ($task['0']->test->question as $value) {
			$questionCol ++;
		}
		
		if(count($_SESSION['task']->test->question) != 0)
		{
			
			$check = api::collection('result',array('id'=>$_SESSION['result']['id']));
			foreach ($check['0']->registr_result as $value) 
			{
				foreach ($_SESSION['task']->test->question as $quest) 
				{
					if ($quest->id == $value->question->id) 
					{
						$del = array_shift($_SESSION['task']->test->question);
                        $position++;
					}
				}



				
			}
			$question = $_SESSION['task']->test->question['0'];
			$this->question = $question;
			$this->position = $position;
			$this->questionCol = $questionCol;
			
		}

	}


	public function saveResult()
	{
		//сохраняем результат

		$result = new result($_SESSION['result']);

		
	}

	public function endTask()
	{
		if(count($_SESSION['task']->test->question) != 0)
		{
			$_SESSION['timer'] = 0;
			foreach ($_SESSION['task']->test->question as $question) 
			{
				if ($question->type == 1) 
				{
					$sql = "INSERT INTO `registr_result` (`result`,`question`,`answer`) VALUES (:result,:question,:answer)";
					db::init();
					$param = array('result'=>$_SESSION['result']['id'], 'question' => $question->id, 'answer' => 1);
					$registr_id = db::init()->insert($sql,$param);
				}
				else
				{
					$sql = "INSERT INTO `registr_result` (`result`,`question`,`answer_text`) VALUES (:result,:question,:answer_text)";
					db::init();
					$param = array('result'=>$_SESSION['result']['id'], 'question' => $question->id, 'answer_text' => "Нет ответа");
					$registr_id = db::init()->insert($sql,$param);
					
				}
			}
			echo '{"status":"ok"}';
		}
	}

	public function addResultData($resultData)
	{
		$timer = $resultData->timer;
		$_SESSION['timer'] = $timer;
		db::init();
		$sql = "UPDATE `registr_task` SET `timer` = :timer WHERE `task` = :task AND `user` = :user";
		$param = array('timer'=>$timer,'task'=>$_SESSION['task']->id,'user'=>$_SESSION['user']->id);
		$status = db::init()->update($sql,$param);
		$check_text = false;
        $check_answer = false;
        $_SESSION['result']['user'] = $_SESSION['user']->id;
        $_SESSION['result']['task'] = $_SESSION['task']->id;
        $tsk = $_SESSION['task'];
        foreach($tsk->registr_task as $obj)
        {
            if ($_SESSION['user']->id == $obj->user->id)
            {
                $tus = $obj->tus;
            };
        };
        $_SESSION['result']['tus'] = $tus;
        $resultData = json_decode(json_encode($resultData), true);
        foreach ($resultData as $key => $value)
{
    if ($key == "answer_text")
    {
        $check_text = true;
    }
    elseif ($key == "answer")
    {
        $check_answer = true;

    }

}
        if(!$check_text)
        {
            foreach ($resultData as $key => $value)
            {
                if ($key != "question" and $key != "timer" )
                 {
                     $objresult = (object) array('question' => $resultData['question'], 'answer'=>$key, 'answer_text' => $value);
                     $_SESSION['result']['registr_result'] = $objresult;

                     $this->saveResult();
                     unset($_SESSION['result']['registr_result']);

                 }

            }
        }
        elseif(!$check_answer)
            {

                     $objresult = (object) array('question' => $resultData['question'], 'answer_text'=>$resultData['answer_text']);
                     $_SESSION['result']['registr_result'] = $objresult;
                     $this->saveResult();
                     unset($_SESSION['result']['registr_result']);


        }
        else
            {

            $objresult = (object) array('question' => $resultData['question'], 'answer'=>$resultData['answer'], 'answer_text' => $resultData['answer_text']);
            $_SESSION['result']['registr_result'] = $objresult;
            $this->saveResult();
            unset($_SESSION['result']['registr_result']);


        }

		echo '{"status":"ok"}';


		$question = array_shift($_SESSION['task']->test->question);
	}
	public function updateResultData($resultData)
	{
		$timer = $resultData->timer;
		$_SESSION['timer'] = $timer;
		db::init();
		$sql = "UPDATE `registr_task` SET `timer` = :timer WHERE `task` = :task AND `user` = :user";
		$param = array('timer'=>$timer,'task'=>$_SESSION['task']->id,'user'=>$_SESSION['user']->id);
		$status = db::init()->update($sql,$param);

		$registr_result = $resultData;
		echo '{"status":"ok"}';
		if(!isset($registr_result->answer))
		{
			$registr_result->answer = NULL;
		};


		db::init();
		$sql = "UPDATE `registr_result` SET `answer` = :answer,`answer_text` = :text_answer WHERE `id` = :id";
		$param = array('answer'=>$registr_result->answer, 'text_answer'=>$registr_result->answer_text, 'id'=>$registr_result->registr_res);
		db::init();
		try {
			$status = db::init()->update($sql,$param);

		} catch (Exception $e) {
			main::printr($e);
		};


	}
}
?>