<?php
class Controller_CMS
{
	var $load;
	protected $uri;
	protected $input;

	function __construct()
	{
		require_once 'system/class.load.php';
		$this->load = new load();
	}
}
?>