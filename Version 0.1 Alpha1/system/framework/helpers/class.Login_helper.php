<?php
require_once('system/framework/class.mysql.php');
class Login_helper
{
	public $mysql;
	function check_login()
	{
		$ip = $_SERVER['REMOTE_ADDR'];
		if(isset($_SESSION['ip'], $_SESSION['user_id'], $_SESSION['session_code']))
		{
			return true;
		}else{
			return false;
		}
	}
	
	function must_login()
	{
		$this->mysql = new Mysql();
		
		$ip = $_SERVER['REMOTE_ADDR'];
		if($this->check_login() == true)
		{
			if($_SESSION['ip'] == $ip)
			{
				$select = "SELECT * FROM sessions WHERE user_id=".$_SESSION['user_id'];
				if($this->mysql->num_row($select) == 1)
				{
					$row1 = $this->mysql->assoc($select);
					if(md5($row1["session_code"]) == $_SESSION['session_code'])
					{
						$get_date = date('Y-m-d', $row1['timestamp']);
						$current_date = date('Y-m-d');
						if($get_date == $current_date)
						{
							$get_time=$row1['timestamp'];
							$current_time = time();
							$get_time2=$get_time+(60*60*2);
														
							if($current_time>$get_time2)
							{
								$this->logout();
								//DEBUGGING!!
								//echo '5';
							}else{
								$this->update_session();
								return true;
							}

						}else{
							$this->logout();
						}
						//return true;
					}else{
						$this->logout();
						//DEBUGGING!!
						//echo "4";
					}
				}else{
					$this->logout();
					//DEBUGGING!!
					//echo "3";
				}
			}else{
				$this->logout();
				//DEBUGGING!!
				//echo "2";
			}
		}else{
			return false;
		}
	}
	
	private function update_session()
	{
		$sql = "UPDATE sessions SET timestamp='".$this->mysql->escape(strtotime(date('Y-m-d H:i:s')))."' WHERE user_id=".$this->mysql->escape($_SESSION['user_id']);
		$this->mysql->query($sql, $data=null);
	}
	
	function logout()
	{
		header("location: /cmswire/v3/index.php/ucp/login/");
		session_destroy();
	}
}