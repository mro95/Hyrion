<?php
if(file_exists('system/class.mysql_config.php'))
{
	require_once('system/class.mysql_config.php');
}else{
	require_once('../system/class.mysql_config.php');
}

class Mysql extends mysql_config
{
	private $db_conn;
	public $db_host;
	public $db_user;
	public $db_pass;
	public $db_name;
	
	function __construct($data = null)
	{
			$this->db_host = $this->config_mysql_host;
			$this->db_user = $this->config_mysql_user;
			$this->db_pass = $this->config_mysql_pass;
			$this->db_name = $this->config_mysql_name;
	}
	
	private function controleer_verbinding()
	{
		if(!$this->db_conn)
		{
			$this->open_verbinding();
		}
	}

	private function open_verbinding()
	{
		$this->db_conn = mysql_connect($this->db_host,$this->db_user,$this->db_pass);
		if(!$this->db_conn)
		{
			throw new Exception('mySQL verbindings Fout: ' . mysql_error($this->db_conn));
		}

		if(!mysql_select_db($this->db_name, $this->db_conn))
		{
			throw new Exception('mySQL Databaseselectie Fout: ' . mysql_error($this->db_conn));
		}
	}
	
	function escape($item)
	{
		$this->controleer_verbinding();
		return mysql_real_escape_string($item);
	}
	
	function select_query($sql, $data = null)
	{
		$this->controleer_verbinding();

		if($data)
		{
			foreach ($data as $param=>$value)
			{
				$param = mysql_real_escape_string($param);
				$value = mysql_real_escape_string($value);
				if(!is_numeric($value)) $value = '\'' . $value . '\'';
				$sql = str_replace($param, $value, $sql);
			}
		}

		$result = mysql_query($sql, $this->db_conn);
		if(!$result)
		{
			throw new Exception('mySQL Fout: ' . mysql_error($this->db_conn));
		}
		$result_array = array();
		while($row = mysql_fetch_assoc($result))
		{
			array_push($result_array, $row);
		}
		return $result_array;
	}
	
	public function assoc($sql, $data=null)
	{
		$this->controleer_verbinding();

		if($data)
		{
			foreach ($data as $param=>$value)
			{
				$param = mysql_real_escape_string($param);
				$value = mysql_real_escape_string($value);
				if(!is_numeric($value)) $value = '\'' . $value . '\'';
				$sql = str_replace($param, $value, $sql);
			}
		}

		$result = mysql_query($sql, $this->db_conn) or die(mysql_error());
		if(!$result)
		{
			throw new Exception('mySQL Fout: ' . mysql_error($this->db_conn));
		}
		return mysql_fetch_assoc($result);
	}
	
	public function fetch_assoc($result1){
            return mysql_fetch_assoc($result1);
    }

	function num_row($sql, $data=null)
	{
		$this->controleer_verbinding();

		if($data)
		{
			foreach ($data as $param=>$value)
			{
				$param = mysql_real_escape_string($param);
				$value = mysql_real_escape_string($value);
				if(!is_numeric($value)) $value = '\'' . $value . '\'';
				$sql = str_replace($param, $value, $sql);
			}
		}

		$result = mysql_query($sql, $this->db_conn);
		return mysql_num_rows($result);
	}

	function query($sql, $data=null, $show_query = false)
	{
		$this->controleer_verbinding();

		if($data)
		{
			foreach ($data as $param=>$value)
			{
				$param = mysql_real_escape_string($param);
				$value = mysql_real_escape_string($value);
				if(!is_numeric($value) && !is_null($value) && $value !== strtoupper('null'))
				{
					if(empty($value)) $value = 'NULL';
					else $value = '\'' . $value . '\'';
				}
				elseif( is_null($value) )
					$value = 'NULL';

				$sql = str_replace($param, $value, $sql);
			}
		}
		if($show_query)
		{
			echo $sql;
			return true;
		}
		else
		{
			return mysql_query($sql, $this->db_conn);
		}
	}
}
?>