<?php
require_once('system/framework/class.mysql.php');
class Mysql_helper extends Mysql
{
	var $db_conn;
	var $db_host;
	var $db_user;
	var $db_pass;
	var $db_name;
	var $mysql;
	
	function __construct()
	{
		$this->mysql = new mysql;
		$this->db_host = $this->mysql->db_host;
		$this->db_user = $this->mysql->db_user;
		$this->db_pass = $this->mysql->db_pass;
		$this->db_name = $this->mysql->db_name;
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
	
	function insert_array($table, $data)
	{
		$this->controleer_verbinding();
		if($data && is_array($data))
		{
			$fields = array();
			$values = array();
	
			foreach ($data as $key => $val)
			{
				$fields[] = mysql_real_escape_string($key);
				if(is_numeric($val))
				{
					$values[] = mysql_real_escape_string($val);
				}else{
					$values[] = '"'.mysql_real_escape_string($val).'"';
				}
			}
			$fields = implode(', ', $fields);
			$values = implode(", ", $values);
		
			$sql = "INSERT INTO $table ($fields) VALUES ($values)";
			$result = mysql_query($sql, $this->db_conn);
			return $result;
		}
	}
	
	function delete_array($table, $where)
	{
		$this->controleer_verbinding();
		if($where && is_array($where))
		{
			$array1 = array();
			$sql = "DELETE FROM ".mysql_real_escape_string($table)." WHERE ";
			foreach($where as $key => $value)
			{
				if(is_numeric($val))
				{
					$array1[] = mysql_real_escape_string($key)."=".mysql_real_escape_string($value);
				}else{
					$array1[] = mysql_real_escape_string($key)."='".mysql_real_escape_string($value)."'";
				}
			}
			$sql .= implode(' AND ', $array1);
		}
		$result = mysql_query($sql, $this->db_conn);
		return $result;
	}
	
	function update_array($table, $data, $where)
	{
		$this->controleer_verbinding();
		if($data && $where)
		{
			if(is_array($data) && is_array($where))
			{
				$array1 = array();
				$array2 = array();
				$sql = "UPDATE ".mysql_real_escape_string($table)." SET ";
				foreach($data as $key => $value)
				{
					if(is_numeric($value))
					{
						$array1[] = mysql_real_escape_string($key)."=".mysql_real_escape_string($value);
					}else{
						$array1[] = mysql_real_escape_string($key)."='".mysql_real_escape_string($value)."'";
					}
				}
				$sql .= implode(', ', $array1);
				$sql .= " WHERE ";
				foreach($where as $key => $value)
				{
					if(is_numeric($value))
					{
						$array2[] = mysql_real_escape_string($key)."=".mysql_real_escape_string($value);
					}else{
						$array2[] = mysql_real_escape_string($key)."='".mysql_real_escape_string($value)."'";
					}
				}
				$sql .= implode(', ', $array2);
				
				$result = mysql_query($sql, $this->db_conn);
				return $result;
			}
		}
	}
	
	function num_row($table, $where)
	{
		$this->controleer_verbinding();
		if($where && is_array($where))
		{
			$array1 = array();
			$sql = "SELECT * FROM ".mysql_real_escape_string($table)." WHERE ";
			foreach($where as $key => $value)
			{
				$array1[] = mysql_real_escape_string($key)."='".mysql_real_escape_string($value)."'";
			}
			$sql .= implode(' AND ', $array1);
		}else{
			$sql = "SELECT * FROM $table";
		}
		if($sql == NULL)
		{
			echo "ERROR #54! Mysql Helper: Num_Row";
			return false;
		}else{
			$result = mysql_query($sql, $this->db_conn);
			return mysql_num_rows($result);
		}
	}
}