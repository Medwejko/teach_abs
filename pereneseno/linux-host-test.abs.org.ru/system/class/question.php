<?php
/*** вопрос*/
include_once $_SERVER['DOCUMENT_ROOT'].'/system/config.php';

class question extends main
{	
	function __construct($data)
	{
		if(count($data) == 1 AND isset($data['id']))
		{
			$this->get(__CLASS__, $data);
			$this->getTestsID();
			$this->getAnswer();
		}

		else
		{
			
			$collection = $data['collection'];
			unset($data['collection']);
			unset($data['answer_id[]']);
            unset($data['answer_place[]']);
			$testid = $collection['test_id'];
			unset($collection['test_id']);
			$result = [];
			foreach ($collection as $answer => $values) {
				foreach ($values as $i => $value) {
					$result[$i][$answer] = $value;
				}
			};
			main::printr($testid);
			$this->save(__CLASS__, $data);

			/*очищаем таблицу ответов*/
			$sql ="DELETE FROM `answer` WHERE `question` = :question";
			$param = array('question'=>$this->id);
			db::init();
			$clear = db::init()->delete($sql,$param);

			/*сохраняем ответы*/
			foreach ($result as $answer ) {
				if (isset($answer['answer_id'])) {

					$sql = "INSERT INTO `answer` (`id`,`text`,`weight`,`question`,`place`) VALUES (:id,:text,:weight,:question,:place)";
					$param = array('id'=>$answer['answer_id'],'text'=>$answer['answer_text'],'question'=>$this->id, 'weight'=>$answer['answer_weight'],'place'=>$answer['answer_place']);
					$status = db::init()->insert($sql,$param);
				}
				else
				{
					$sql = "INSERT INTO `answer` (`text`,`weight`,`question`,`place`) VALUES (:text,:weight,:question,:place)";
					$param = array('text'=>$answer['answer_text'],'question'=>$this->id, 'weight'=>$answer['answer_weight'],'place'=>$answer['answer_place']);
					$status = db::init()->insert($sql,$param);
				}
			}

			$this->getAnswer();


			/*очищаем регистр*/
			$sql ="DELETE FROM `registr_test_question` WHERE `question` = :question";
			$param = array('question'=>$this->id);
			db::init();
			$clear = db::init()->delete($sql,$param);

			
			/*сохраняем новые вопросы в тесте*/
			$sql = "INSERT INTO `registr_test_question` (`question`,`test`) VALUES (:question,:test)";
			foreach ($testid as $test) 
			{
				$param = array('test'=>$test,'question'=>$this->id);
				$registr_id = db::init()->insert($sql,$param);
			};

			$this->getTestsID();

		};

	}

	public function getAnswer()
	{
		db::init();
		$sql = "SELECT `id` FROM `answer` WHERE `question` = :question ORDER BY `place` ASC";
		$answers = db::init()->getAll($sql,array('question'=>$this->id));

		$this->answers = array();

		foreach ($answers as $id) 
		{
			$this->answers[] = new answer($id);
		};
	}

	public function getTestsID()
	{
		db::init();
		$sql = "SELECT `test` AS `id` FROM `registr_test_question` WHERE `question` = :question";
		$tests = db::init()->getAll($sql,array('question'=>$this->id));

		$this->tests = $tests;

		//foreach ($tests as $id) 
		//{
		//	$this->tests[] = new test($id);
		//};

	}
}
?>