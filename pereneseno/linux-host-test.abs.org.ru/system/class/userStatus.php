<?php
/**
 * пользователь
 */
class userStatus extends main
{	
	function __construct($data)
	{
		if(count($data) == 1 AND isset($data['id']))
		{
			$this->get(__CLASS__, $data);
		}
		else
		{
			$this->save(__CLASS__, $data);
		};
	}
}
?>