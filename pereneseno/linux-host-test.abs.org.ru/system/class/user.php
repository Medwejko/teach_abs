<?php
/**
 * пользователь
 */
class user extends main
{	
	function __construct($data)
	{
		if(count($data) == 1 AND isset($data['id']))
		{
			$this->get(__CLASS__, $data);
			$this->group = new group(array('id'=>$this->group));
			$this->subunit = new subunit(array('id'=>$this->subunit));
		}
		else
		{
			if($data['name']!= '')
			{
				db::init();
				$user_u = [];
				$user_r = [];
				if (isset($data['id'])) {

					$sql ="DELETE FROM `user_reserv` WHERE `user` = :user OR `reserv` = :reserv";
					$param = array('user'=>$data['id'], 'reserv'=>$data['id']);
					db::init();
					$clear = db::init()->delete($sql,$param);
				}
				
				if (strlen($data['user_reserv-user']) >= 3)
				{
					$tus = $data['user_reserv-user'];
					main::printr($tus);
					$tus = substr($tus, 1);
					$tus = substr($tus, 0, -1);
					$user_u = explode(",", $tus);
				};
				unset($data['user_reserv-user']);
				if (strlen($data['user_reserv-reserv']) >= 3)
				{
					$tus = $data['user_reserv-reserv'];
					main::printr($tus);
					$tus = substr($tus, 1);
					$tus = substr($tus, 0, -1);
					$user_r = explode(",", $tus);
				};
				unset($data['user_reserv-reserv']);

				$this->save(__CLASS__, $data);
				main::printr($this->id);
				$userID = $this->id;
				$sql = "INSERT INTO `user_reserv` (`user`,`reserv`) VALUES (:user,:reserv)";

				if (count($user_u) != 0) 
				{
					foreach ($user_u as $usrID) 
					{
						$param = array('user'=>$usrID,'reserv'=>$userID);
						$registr_id = db::init()->insert($sql,$param);
					};
				};

				if (count($user_r) != 0) 
				{
					foreach ($user_r as $usrID) 
					{
						$param = array('user'=>$userID, 'reserv'=>$usrID);
						$registr_id = db::init()->insert($sql,$param);
					};
				};
			};
		};
	}

}

?>