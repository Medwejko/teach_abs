<?php
/**
 * вопрос
 */
class project_result extends main
{	
	function __construct($data)
	{
		if(count($data) == 1 AND isset($data['id']))
		{
			$this->get(__CLASS__, $data);
			$this->user = new user(array('id'=>$this->user));
			$this->test = new test(array('id'=>$this->test));
			$this->project = new project(array('id'=>$this->project));
			$this->question = new question(array('id'=>$this->question));			
		}
	}
}
?>