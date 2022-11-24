<?php
//ini_set('display_errors','On');
//error_reporting('E_ALL');
class db
{
    public $dbc;
    private static $_instance = NULL;
    /*private $_config = array(
        'host' => '10.2.24.252',
        //'port' => '3306',
        'user' => 'rost',
        'pass' => 'rost2019',
        'name' => 'test_system',
        'charset' => 'utf8',
        'debug' => true
    );*/
    private $_config = array(
        'host' => '10.2.24.252',
        //'port' => '3306',
        'user' => 'root',
        'pass' => 'developer2019',
        'name' => '',
        'charset' => 'utf8',
        'debug' => true
    );
 
    private function __construct($host,$dbname)
    {
        $this->_config['host'] = $host;
        $this->_config['user'] = 'root';
        $this->_config['pass'] = 'ZXCdsaqwe1586';
        $this->_config['name'] = $dbname;
        try {
            $this->_dbc = new PDO(
                'mysql:host='.$this->_config['host'].
				';dbname='.$this->_config['name'],
				///';port='.$this->_connect['port'],
                $this->_config['user'],
                $this->_config['pass']
            );
 
            $this->_dbc->exec('SET NAMES '.$this->_config['charset']);
            if($this->_config['debug']) {
                $this->_dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
        } 
		catch (PDOException $e) {
            throw new Exception('Подключение к БД не удалось: ' . $e->getMessage());
        }
    }

	public static function init($host = '10.2.24.252',$dbname='staff')
    {
        if(self::$_instance === NULL) {
            self::$_instance = new db($host,$dbname);
			//echo 'new connect compleat';
        };
        return self::$_instance;
		//echo 'connect compleat';
    }
	
	public function query($sql, $params = array())
    {
        try {
            $sth = $this->_dbc->prepare($sql);
            $sth->execute($params);
            return $this->_dbc;
        } 
        catch (PDOException $e) {
            $dbcerr = $this->_dbc->errorInfo();
            $pdoerr = $sth->errorInfo();
            //echo "<pre>1";
            //print_r($dbcerr);
            //print_r($pdoerr);
            //echo "</pre>";
            //throw new Exception('dbcerr' . $dbcerr . 'pdoerr' . $pdoerr. 'e:' . $e->getMessage());
            throw new Exception('e:' . $e->getMessage());
        }
	}
	
	public function getAll($sql, $params = array(), $assoc = true)
    {
        $sth = $this->_dbc->prepare($sql);
        $sth->execute($params);
        return $sth->fetchAll($assoc ? PDO::FETCH_ASSOC : PDO::FETCH_BOTH);
    }
	
	public function getObj($sql, $params = array())
    {
        $sth = $this->_dbc->prepare($sql);
        $sth->execute($params);
		$result = $sth->fetch(PDO::FETCH_OBJ);
        return $result;
    }
	
	public function update($sql, $params = array())
	{
        try {
            $sth = $this->_dbc->prepare($sql);
            $sth->execute($params);
            return $this->_dbc;
        } 
        catch (PDOException $e) {
            $dbcerr = $this->_dbc->errorInfo();
            $pdoerr = $sth->errorInfo();
            //echo "<pre>2";
            //print_r($sth);
            //print_r($dbcerr);
            //print_r($pdoerr);
            //echo "</pre>";
            //throw new Exception('dbcerr:' . $dbcerr . 'pdoerr:' . $pdoerr . 'e:' . $e->getMessage());
            throw new Exception('e:' . $e->getMessage());
        }

	}
	
	public function insert($sql, $params = array())
	{
		$sth = $this->_dbc->prepare($sql);
		$sth->execute($params);
		$id = $this->_dbc->lastInsertId();
		return $id;
	}
	
	public function delete($sql, $params = array())
	{
        $sth = $this->_dbc->prepare($sql);
        $sth->execute($params);
		return $this->_dbc;
	}

    public function get_error_info()
    {
        return $this->_dbc->errorInfo();
    }

    public function get_pdostat_error_info()
    {
        return $sth->errorInfo();
    }
}
?>