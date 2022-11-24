<?php
/**
 * пользователь
 */
class project extends main
{	
	function __construct($data)
	{
		if(count($data) == 1 AND isset($data['id']))
		{
			$this->get(__CLASS__, $data);

			$sql = "SELECT * FROM `admin_control` WHERE `project` = :id";
			$admin = db::init()->getAll($sql,array('id'=>$data['id']));
			$this->admin = $admin;
		}
		else
		{
			if($data['name']!= '')
			{
				if (isset($data['id'])) {
					$sql ="DELETE FROM `admin_control` WHERE `project` = ". $data['id'];
					$clear = db::init()->delete($sql);
				};
				
				unset($data['user_id[]']);
				$col = $data['collection'];
				$admins = $col['user_id'];
				unset($data['collection']);
				$this->save(__CLASS__, $data);
				if (count($admins) != 0) 
				{
					foreach ($admins as $admin) 
					{
						$sql = "INSERT INTO `admin_control` (`user`,`project`) VALUES (:user,:project)";
						$param = array('user'=>$admin,'project'=>$this->id);
						$registr_id = db::init()->insert($sql,$param);



					};
				};
			};
		};

	}
}
?>