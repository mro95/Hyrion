<?php
require_once "system/cms/class.Controller_CMS.php";
require_once "system/cms/class.model_cms.php";
class CMS_load_page extends Controller_CMS
{

	function home()
	{
		$model_home = $this->load->model('m_cms_load_page');
		$row = $model_home->load_home();
		
		$this->load_template = new Load_Template();
		echo $this->load_template->header();
		echo $row['page_content'];
		echo $this->load_template->footer();
	}
	
	function error_404()
	{
		$this->load_template = new Load_Template();
		echo $this->load_template->header();
		echo "Error 404";
		echo $this->load_template->footer();
	}
	
	function load()
	{
		$model_home = $this->load->model('m_cms_load_page');
		$helper1 = $this->load->helper('helper_uri');
		$page_id = $helper1->uri_segment(2);
		$row = $model_home->load_page($page_id);
		
		$this->load_template = new Load_Template();
		echo $this->load_template->header();
		echo $row['page_content'];
		echo $this->load_template->footer();
	}
	
}