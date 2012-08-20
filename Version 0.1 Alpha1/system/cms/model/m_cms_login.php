<?php
class m_CMS_LOGIN extends Model_CMS
{
	function gen_code($user_id)
	{
		$array = array();
		
		$rand1 = substr(str_shuffle(str_repeat('abcdefghijklmnopqrstuvwxyz0123456789',12)),0,12);
		$ip = $_SERVER['REMOTE_ADDR'];
		$select = "SELECT * FROM sessions WHERE user_id=".$this->mysql->escape($user_id);
		if($this->mysql->num_row($select) == 0)
		{
			$sql = "INSERT INTO sessions (user_id, session_code, ip, timestamp) VALUES ('".$this->mysql->escape($user_id)."', '".$this->mysql->escape($rand1)."', '".$this->mysql->escape($ip)."', '".$this->mysql->escape(strtotime(date('Y-m-d H:i:s')))."' )";
		}else{
			$sql = "UPDATE sessions SET session_code='".$this->mysql->escape($rand1)."', ip='".$this->mysql->escape($ip)."', timestamp='".$this->mysql->escape(strtotime(date('Y-m-d H:i:s')))."' WHERE user_id=".$this->mysql->escape($user_id);
		}
		$this->mysql->query($sql, $data=null);
		return $rand1;
	}
	
	function check_login($user,$pass)
	{
		$select = "SELECT * FROM users WHERE username='".$this->mysql->escape($user)."' AND password='".$this->mysql->escape($pass)."'";
		if($this->mysql->num_row($select) == 1)
		{
			return true;
		}
		return false;
	}
	
	function get_userid($user,$pass)
	{
		$select = "SELECT user_id FROM users WHERE username='".$this->mysql->escape($user)."' AND password='".$this->mysql->escape($pass)."'";
		if($this->mysql->num_row($select) == 0)
		{
			return false;
		}elseif($this->mysql->num_row($select) < 1)
		{
			return false;
		}
		$query = $this->mysql->assoc($select);
		foreach($query as $value)
		{
			return $value;
		}
	}
	
	function start_session($user_id, $session_code)
	{
		$ip = $_SERVER['REMOTE_ADDR'];
		$_SESSION['user_id'] = $user_id;
		$_SESSION['session_code'] = $session_code;
		$_SESSION['ip'] = $ip;
		if(!empty($ip) && !empty($user_id) && !empty($session_code))
		{
			if(!empty($_SESSION['ip']) && !empty($_SESSION['user_id']) && !empty($_SESSION['session_code']))
			{
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
		//echo "ID: ".$_SESSION['user_id']." Session_code: ".$_SESSION['session_code']." IP: ".$_SESSION['ip'];
	}
}