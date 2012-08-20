<?php
class CW_admin_Loadstyle
{	
	//var $check_style;
	
	function __construct()
	{
		//$this->settings = new settings();
		// -----------------------
		//require_once('system/style/class.check_style.php');
		//$this->check_style = new check_style();
		
		require_once('../system/framework/class.mysql.php');
		//require_once('../system/class.mysql_config.php');
		//require_once('../system/style/class.template_parser.php');
		//require_once('../system/class.settings.php');
	}
	
	function header2()
	{
		$this->check_style = new check_style();
		if(file_exists("header.php"))
		{
			require_once("header.php");
		}else{
			throw new Exception('Can not header found on: '.$this->check_style->default_style().'(default style)');
		}
	}
	
	function header()
	{
		$file = "style/header.php";
		if(file_exists($file))
		{
			$file_content = file_get_contents($file);
			$key = "{WEBSITE-NAME}";
			if(strpos($file_content, $key))
			{
				//$val = $this->settings->get_setting_value("website_name");
				$val = "CMSWire.nl";
				$file_content = str_replace($key, $val, $file_content);
				
				$menu = $this->menu();
				$file_content = str_replace("{menu}", $menu, $file_content);
				
				$setting = new settings();
				$val2 = $setting->base_url();
				$file_content = str_replace("{CSS_LAYOUT}", $val2.'/admin/style/layout.css', $file_content);
				$file_content = str_replace("{CSS_MENU}", $val2.'/admin/style/menu.css', $file_content);
				$file_content = str_replace("{setting.base_url}", $val2, $file_content);
			}
			return $file_content;
			//require_once($file);
		}else{
			throw new Exception('Can not found header on admin');
		}
	}
	
	private function menu2()
	{
		$mysql = new Mysql();
		$template = new Template_parser();
		
		$file = "styles/".$this->check_style->load()."/menu.php";
		if(file_exists($file))
		{
			$jp = "";
			for ($i = 1; $i <= 10; $i++) 
			{
				$file_content = file_get_contents($file);
				$m_cat = "SELECT * FROM menu_category WHERE menu_category_id=".$mysql->escape($i);
				$m_item = "SELECT * FROM menu_items WHERE menu_category_id=".$mysql->escape($i);
				
				$m_cat2 = "SELECT * FROM menu_category WHERE menu_category_id=".$mysql->escape($i);
				$m_item2 = "SELECT * FROM menu_items WHERE menu_category_id=".$mysql->escape($i)." ORDER BY order_by";
				
				$item_num = "";
				
				if($mysql->num_row($m_cat))
				{
					$data = array();
					if($mysql->num_row($m_item))
					{
						$data['item'] = $mysql->select_query($m_item2);
					}else{
						$data['item'] = array(array("item_name" => null));
					}
					$data['category'] = $mysql->select_query($m_cat2);
					$jp .= $template->parse('styles/default/menu',$data);
				}
			}
			return $jp;
		}else{
			throw new Exception('Can not found menu.php on: '.$this->check_style->load().'(default style)');
		}
	}
	
	private function menu()
	{
		$mysql = new Mysql();
		$template = new Template_parser();
		
		$file = "style/menu.php";
		if(file_exists($file))
		{
			$jp = "";
			for ($i = 1; $i <= 10; $i++) 
			{
				$file_content = file_get_contents($file);
				$m_cat = "SELECT * FROM admin_menu_category WHERE order_by=".$mysql->escape($i);				
				if($mysql->num_row($m_cat) == 1)
				{
					$data = array();
					$row1 = $mysql->assoc($m_cat);
					$m_item = "SELECT * FROM admin_menu_items WHERE menu_category_id=".$mysql->escape($row1['menu_category_id']);
					if($mysql->num_row($m_item))
					{
						$data['item'] = $mysql->select_query($m_item);
						$data['category'] = $mysql->select_query($m_cat);
						$data['ul'] = '<ul>';
						$data['/ul'] = '</ul>';
						$jp .= $template->parse('style/menu',$data);
					}else{
						$data['item'] = array();
						$data['category'] = $mysql->select_query($m_cat);
						$data['ul'] = '';
						$data['/ul'] = '';
						$jp .= $template->parse('style/menu',$data);
					}
				}
			}
			return $jp;
		}else{
			throw new Exception('Can not found menu.php on: '.$this->check_style->load().'(default style)');
		}
	}
	
	function footer()
	{
		$file = "style/footer.php";
		if(file_exists($file))
		{
			/*
			$file_content = file_get_contents($file);
			$key = "{copyright}";
			if(strpos($file_content, $key))
			{
				$val = "&copy;".$this->settings->get_setting_value("website_name")." - 2010-2011";
				$file_content = str_replace($key, $val, $file_content);
			}
			return $file_content;
			*/
			require_once($file);
		}else{
			throw new Exception('Can not found footer on admin style');
		}
	}
	
	function footer2()
	{
		$this->check_style = new check_style();
		if(file_exists("footer.php"))
		{
			require_once("footer.php");
		}else{
			throw new Exception('Can not footer found on: '.$this->check_style->default_style().'(default style)');
		}
	}
}