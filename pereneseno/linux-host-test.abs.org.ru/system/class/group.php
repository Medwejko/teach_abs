<?php
/**
 * пользователь
 */
class group extends main
{	
	function __construct($data)
	{
		if(count($data) == 1 AND isset($data['id']))
		{
			$this->get(__CLASS__, $data);

		};
	}

	
}
?>