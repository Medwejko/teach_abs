<?php
/**
 * вопрос
 */
class registr_task extends main
{	
	function __construct($data)
	{
		if(count($data) == 1 AND isset($data['id']))
		{
			$this->get(__CLASS__, $data);	
			$this->user = new user(array('id'=>$this->user));
			$this->task = new task(array('id'=>$this->task));
					
		}
		else
		{
			$this->save(__CLASS__, $data);
		};
	}
}
?>