<?php
/**
 * тест
 */
class test extends main
{	
	function __construct($data)
	{
		if(count($data) == 1 AND isset($data['id']))
		{
			$this->get(__CLASS__, $data);
			$this->getQuestion();
		}
		else
		{
			
			if($data['name']!= '')
			{

				$collection = $data['collection'];
				unset($data['place[]']);
				unset($data['question[]']);
				unset($data['collection']);
				$placeArr = $collection['place'];
				main::printr($placeArr);
				$questionArr = $collection['question'];
				$result = [];
				$this->save(__CLASS__, $data);
				$test = $this->id;
				if (isset($collection['place'])) {
					foreach ($placeArr as $i => $place) 
					{
						foreach ($questionArr as $y => $question) 
						{
							if ($i==$y) 
							{
								db::init();
								$sql = "UPDATE `registr_test_question` SET `place` = :place WHERE `test` = :test AND `question` = :question";
								$param = array('place'=>$place,'test'=>$test,'question'=>$question);
								$status = db::init()->update($sql,$param);
								main::printr($param);
							};

						};
					};
				};
				
				

			};
			
		};
	}
	
	public function getQuestion()
	{
		db::init();
		$sql = "SELECT `question` AS `id` FROM `registr_test_question` WHERE `test` = :test ORDER BY `place` ASC";
		$question = db::init()->getAll($sql,array('test'=>$this->id));

		$this->question = array();

		foreach ($question as $id) 
		{
			$this->question[] = new question($id);
		};
	}

}
?>