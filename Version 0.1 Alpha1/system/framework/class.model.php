<?php
abstract class Model
{
	protected $database;
	protected $load;
	protected $mysql;

	function construct()
	{
		require_once('class.mysql.php');
		$this->mysql = new Mysql();
		$this->load = new Load();
		$this->mysql_helper = $this->load->helper('mysql_helper');
	}
}
?>