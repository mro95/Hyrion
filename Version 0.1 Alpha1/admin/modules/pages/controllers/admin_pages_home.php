<?php
class admin_pages_home extends cw_admin_Controller
{

	function __construct()
    {
        parent::construct();
    }
	
	function index()
	{
		$this->load = new cw_load();
		$setting = new settings();
				
		$model1 = $this->load->model('admin_pages_loaddata');
		$result_array = $model1->home();
		
		$data = array();
		$data['base_url'] = $setting->base_url();
		$data['content'] = $result_array;
		$template = new Template_parser();
		echo $template->parse('style/templates/pages_home',$data);
	}
	
}