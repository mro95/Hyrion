<?php
class test_test2 extends Controller
{
	function __construct()
	{
		parent::construct();
	}
	
	function test3()
	{
		//$noob = $this->load->model('model_test_test5');
		//$noob->noobje();
		echo $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
	}
}