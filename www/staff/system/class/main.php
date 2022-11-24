<?php
/**
 * родительский класс
 */
class main 
{
	public function get($class,$data)
	{
		$sql = "SELECT * FROM `".$class."` WHERE `id` = :id";
		db::init();
		$result = db::init()->getObj($sql,$data);
		
		foreach ($result as $key => $value) 
		{

			$this->$key = $value;
		};
	}

	public function save($class,$data)
	{
		if(isset($data['id']))
		{
			$sql = "UPDATE `".$class."` SET ";

			$id = $data['id'];
			unset($data['id']);

			foreach ($data as $key => $value) 
			{
				$sql .= "`".$key."` = :".$key.", ";
			};

			$sql = substr($sql, 0, -2);

			$data['id'] = $id;

			$sql .= " WHERE `id` = :id";

			db::init();
			$result = db::init()->update($sql,$data);

			$this->get($class,array('id'=>$id));

		}
		else
		{
			$sql = "INSERT INTO `".$class."`(";
			$values = " VALUES (";

			foreach ($data as $key => $value) 
			{
				$sql .= "`".$key."`, ";
				$values .= ":".$key.", ";
			};

			$sql = substr($sql, 0, -2).")";
			$values = substr($values, 0, -2).")";

			$sql = $sql.$values;

			db::init();
			$id = db::init()->insert($sql,$data);

			$this->get($class,array('id'=>$id));

		}
	}

	public static function delete($class,$id)
	{
		if ($class == 'task') {

			$sql = "DELETE FROM `registr_task` WHERE `task` = :id";
			
			$param = array('id'=>$id);
			$del = db::init()->delete($sql,$param);
		};
		try {
			$sql = "DELETE FROM `".$class."` WHERE `id` = :id";
			$param = array('id'=>$id);
			db::init();
			$del = db::init()->delete($sql,$param);
			return array('status'=>'ok');
		} catch (Exception $e) {
			echo '<pre>';
			print_r($e);
			echo '</pre>';
			return array('status'=>'error','desc'=>$e);
		};

	}

	public static function printr($data,$type=0)
	{
		if($GLOBALS['debug'])
		{
			switch ($type) {
				case '0':
				echo '<pre>';
				print_r($data);
				echo '</pre>';
				break;
				
				case '1':
				echo '<pre>';
				var_dump($data);
				echo '</pre>';
				break;
				
				default:
				break;
			}
		}
	}
}
?>