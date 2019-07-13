<?php
	class Settings extends CI_Controller {
		
		public function __construct()
		{
			parent::__construct();
			if($this->login_model->check_login())
			{
				$this->lang->load('custom',$this->session_library->get_session_data('Language'));
				$this->data['Login']['Login_as'] = $this->session_library->get_session_data('Login_as');
				$this->data['Login']['Name'] = $this->session_library->get_session_data('Name');
				$this->data['Login']['Email'] = $this->session_library->get_session_data('Email');
				$this->data['Login']['ID'] = $this->session_library->get_session_data('ID');
				$this->load->model('setting_model');
				$this->data['my_config'] = $this->my_config = $this->config->item('skyq');

                $this->data['menu'] = $this->setting_model->get_menus($this->data,$this->my_config);
                
			}
			else 
			{
				redirect($this->config->item('skyq')['default_login_page']);
			}
	 	}

		public function index()
		{
			$this->data['breadcrumb']['heading'] = 'Paathshala Masters';
			// $this->data['breadcrumb']['heading'] = 'Settings';
			$this->data['breadcrumb']['route'] = array(array('title'=>'Paathshala Masters','path'=>'settings'),'Show');
			$this->data['settings_menu'] = $this->config->item('settings_menu');
			$this->load->view('includes/header',$this->data);
			$this->load->view('sessions/settings_view',$this->data);
			$this->load->view('includes/footer',$this->data);
		}

		public function change_password()
		{
			$this->load->view('includes/header',$this->data);
			$this->load->view('sessions/change_pd',$this->data);
			$this->load->view('includes/footer',$this->data);
		}

		public function cp()
		{
			define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
	        if(IS_AJAX)
			{
				$this->load->model('setting_model');

				$op = $this->input->post('old_pw');
				$np = $this->input->post('new_pw');
				$cp = $this->input->post('confirm_pw');
				
				echo json_encode($this->setting_model->change_password($op,$np,$cp));
			}
			else {
				$this->load->view($this->config->item('skyq')['hacker_view']);
			}
		}

		public function update_lang_file()
		{
			$lang_id = $this->session_library->get_session_data('Language_ID');
			$this->lang_library->updatelangfile($lang_id);
		}

		public function help()
		{
			$this->load->model('setting_model');
			$this->data['questionAnswers'] = $this->setting_model->help_data();
			
			$this->load->view('includes/header',$this->data);
			$this->load->view('sessions/help_view',$this->data);
			$this->load->view('includes/footer',$this->data);
		}

		public function help1()
		{
			$this->load->model('setting_model');
			$this->data['questionAnswers'] = $this->setting_model->help_data();
			
			echo "<pre>";
			print_r($this->data['questionAnswers']);
			echo "</pre>";
			
		}

		public function menu()
		{
			$this->data['menu'] = $this->setting_model->get_menus($this->data,$this->my_config);
			$this->data['breadcrumb']['heading'] = 'Menu Orders';
			$this->data['breadcrumb']['route'] = array(array('title'=>'Dashboard','path'=>'dashboard'),array('title'=>'Settings','path'=>'settings'),'Menu');
			$this->load->view('includes/header',$this->data);
			$this->load->view('settings/menu_view',$this->data);
			$this->load->view('includes/footer',$this->data);
		}

	public function image_upload($width=null,$height=null)
    {
    	if(!empty($_FILES))
    	{
			header('Content-Type:application/x-json; charset=utf-8');
			$new_name = time().$_FILES["file"]['name'];
			$new_name=str_replace(' ', '-', $new_name);
	        $config['upload_path']          = './uploads/';
	        $config['allowed_types']        = 'gif|jpg|png';
	        $config['max_size']             = 1000;
			$config['file_name'] 			= $new_name;
	        $this->load->library('upload', $config);
	        $this->upload->initialize($config);
	        if ( ! $this->upload->do_upload('file'))
	        {
	        	echo json_encode($this->upload->display_errors());
	        }
	        else
	        {
	        	$this->load->model('form_model');
	        	$file_name = $new_name;
	        	if($this->form_model->add(array('table'=>'SS','columns'=>array('path'=>'uploads/'.$file_name))))
	        	{
	        		$id = $this->db_library->find_max_id('SS');
	        		$result = $this->fetch_model->show(array('SS'=>array('ID'=>$id)));
	        		 echo json_encode($result[0]);
	        	}
	        	else{
	        		echo json_encode("Image Not found");
	        	}
	        }
	    }
	    else{
	    	echo json_encode("Image Not found");
	    }
    }
    
		public function update_menu_orders()
		{
			define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
	        if(IS_AJAX)
			{
				$update = $this->setting_model->update_menu_orders($this->data,$this->my_config);
				if($update)
				{
					echo 1;
				}
				else
				{
					$this->errorlog_library->entry('Setting > update_menu_orders > Menu orders are not updated');
					echo 0;
				}
			}
			else
			{
				$this->errorlog_library->entry('Setting > update_menu_orders > Ajax function not called');
				echo 0;
			}
		}

		public function add_user_form()
		{
			$this->data['breadcrumb']['heading'] = 'New User';  
			$this->data['breadcrumb']['route'] = array(array('title'=>'Dashboard','path'=>'dashboard'),array('title'=>'Settings','path'=>'settings'),'New User');  
			$this->data['language_array'] = $this->fetch_model->show("LN",array('ID','Title'));
			$this->load->view('includes/header',$this->data);
			$this->load->view('settings/user_view',$this->data);
			$this->load->view('includes/footer',$this->data);
		}

		//public function error()
		//{
			//$this->data['breadcrumb']['heading'] = 'Error Sync';  
			//$this->data['breadcrumb']['route'] = array(array('title'=>'Dashboard','path'=>'dashboard'),array('title'=>'Settings','path'=>'settings'),'Error Sync');  
			//$this->load->view('includes/header',$this->data);
			//$this->load->view('settings/error_view',$this->data);
			//$this->load->view('includes/footer',$this->data);
		//}

		public function sync_error()
		{
			define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
	        if(IS_AJAX)
			{
				$authentication = new CI_Authentication();
				if($authentication->sync_log())
				{
					echo 1;
				}
				else
				{
					echo 0;
				}
			}
			else
			{
				$this->errorlog_library->entry('Setting > sync_error > Ajax method is not called.');
				return FALSE;
			}
		}

		public function add_user()
		{
			define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
	        if(IS_AJAX)
			{
				$this->load->model('form_model');				
				if(($result = $this->form_model->add(array("table"=>"US","columns"=>$_POST))) === TRUE)
				{
					echo 1;
				}
				else
				{
					echo json_encode($result);
				}
			}
			else {
				echo 0;				
			}
		}

		//public function help_view()
		//{
			//$this->data['breadcrumb']['heading'] = 'Help';  
			//$this->data['breadcrumb']['route'] = array(array('title'=>'Dashboard','path'=>'dashboard'),array('title'=>'Settings','path'=>'settings'),'Help');  
			//$this->data['help_category'] = $this->config->item('help_category');
			//$this->load->view('includes/header',$this->data);
			//$this->load->view('settings/help_detail_view',$this->data);
			//$this->load->view('includes/footer',$this->data);
		//}

		public function add_help_category_form()
		{
			$this->data['breadcrumb']['heading'] = 'Help';  
			$this->data['breadcrumb']['route'] = array(array('title'=>'Dashboard','path'=>'dashboard'),array('title'=>'Settings','path'=>'settings'),array('title'=>'Help','path'=>'settings/help_view'),'Category');  
			$this->load->view('includes/header',$this->data);
			$this->load->view('settings/help_category_view',$this->data);
			$this->load->view('includes/footer',$this->data);
		}

		public function add_help_category()
		{
			define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
	        if(IS_AJAX)
			{
				$this->load->model('form_model');
				
				//$rules_array = array("required|xss_clean","required|xss_clean");
				//$rules_arr = array_combine(array_keys($_POST),$rules_array);
				$result = $this->form_model->add(array("table"=>"HC","columns"=>$_POST));
				if( $result === TRUE)
				{
					echo 1;
				}
				else
				{
					echo json_encode($result);
				}
				
			}
			else {
				echo 0;				
			}
		}

		public function find_help_parent_id($Category_ID=NULL)
		{
			$this->load->model('fetch_model');
			$parent_array = $this->fetch_model->show(array("H"=>array('Level'=>'1','Category_ID'=>$Category_ID)),array('ID','Question','Category_ID'));
			header('Content-Type: application/x-json; charset=utf-8');
			echo json_encode($parent_array);
		}

		public function add_help_form()
		{
			$this->data['breadcrumb']['heading'] = 'Add FAQs';  
			$this->data['breadcrumb']['route'] = array(array('title'=>'Dashboard','path'=>'dashboard'),array('title'=>'Settings','path'=>'settings'),array('title'=>'Help','path'=>'settings/help_view'),'FAQs');  
			$this->data['category_array'] = $this->fetch_model->show("HC",array('ID','Title'));
			$this->load->view('includes/header',$this->data);
			$this->load->view('settings/help_view',$this->data);
			$this->load->view('includes/footer',$this->data);
		}

		public function add_help()
		{
			define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
	        if(IS_AJAX)
			{
				$this->load->model('form_model');
				$result = $this->form_model->add(array("table"=>"H","columns"=>$_POST));
				if($result === TRUE)
				{
					echo 1;
				}
				else
				{
					echo json_encode($result);
				}
			}
			else {
				echo 0;				
			}
			
		}

		//public function backup_view()
		//{
			//$this->data['Backup'] = $this->config->item('Backup');
			//$this->data['breadcrumb']['heading'] = 'Backup';  
			//$this->data['breadcrumb']['route'] = array(array('title'=>'Dashboard','path'=>'dashboard'),array('title'=>'Settings','path'=>'settings'),'Backup');
			//$this->load->view('includes/header',$this->data);
			//$this->load->view('settings/backup_detail_view',$this->data);
			//$this->load->view('includes/footer',$this->data);
		//}

		public function add_full_backup_form()
		{			
			$this->data['breadcrumb']['heading'] = 'Add FAQs';  
			$this->data['breadcrumb']['route'] = array(array('title'=>'Dashboard','path'=>'dashboard'),array('title'=>'Settings','path'=>'settings'),array('title'=>'Backup','path'=>'settings/backup_view'),'Full Backup');  
			$this->load->view('includes/header',$this->data);
			$this->load->view('settings/full_backup_view',$this->data);
			$this->load->view('includes/footer',$this->data);
		}

		public function backup()
		{

			if($this->load->model('backup_model'))
			{
				if($this->backup_model->app_folder_backup())
				{
					$this->errorlog_library->update_backup('Full Folder Backup File.');
					echo 1;
				}
				else
				{
					echo 0;
				}				
			}
			else
			{
				echo 0;
			}
		}

		public function db_backup()
		{
			if($this->load->model('backup_model'))
			{				
				echo 1;								
			}
			else
			{
				echo 0;
			}
		}

		public function add_data_backup_form()
		{
			$this->data['breadcrumb']['heading'] = 'Data Backup';  
			$this->data['breadcrumb']['route'] = array(array('title'=>'Dashboard','path'=>'dashboard'),array('title'=>'Settings','path'=>'settings'),array('title'=>'Backup','path'=>'settings/backup_view'),'Data Backup');
			$this->load->view('includes/header',$this->data);
			$this->load->view('settings/data_backup_view',$this->data);
			$this->load->view('includes/footer',$this->data);
		}		

		public function download_file($path=NULL)
		{
			if(!is_null($path))
			{								
				$this->load->model('backup_model');			
				$file_path = BASEPATH."files/".$path;
				if($this->backup_model->download_backup($path))
				{
					echo 1;
				}
				else
				{
					echo 0;
				}
			}
			else
			{
				echo "<h1 align='center'>Something Went Wrong.</h1>";
			}
		}

		public function language_form()
		{
			$this->data['breadcrumb']['heading'] = 'Help';  
			$this->data['breadcrumb']['route'] = array(array('title'=>'Dashboard','path'=>'dashboard'),array('title'=>'Settings','path'=>'settings'),'Language'); 
			$this->load->model('fetch_model');
			$this->data['word_array'] = $this->fetch_model->show(array("TR"=>array('Language_ID'=>'LNSK10000002')),'Word');
			$this->load->view('includes/header',$this->data);
			$this->load->view('settings/lang_step_form_old',$this->data);
			$this->load->view('includes/footer',$this->data);
		}	

		public function add_language()
		{
			if(is_array($_POST))
			{				
				$this->load->model('form_model');
				$this->load->model('backup_model');
				$res = $this->form_model->add(array("table"=>"LN","columns"=>$_POST));
				
				if(!is_array($res))
				{
					$result = $this->lang_library->create_language_folder($_POST['Title']);
					if($result != FALSE)			
					{						
						$LanguageID = $this->db_library->find_max_id("LN");
						echo json_encode($LanguageID);
					}			
				}
				else 
				{
					echo json_encode($res);				
				}					
			}
			else 
			{
				echo "0";				
			}			
		}

		public function add_translations()
		{
			if(is_array($_POST))
			{
				$_POST['Translation'];
				$_POST['Language_ID'];
				$col_val = array();
				$translation_arr = array_combine($_POST['Word'],$_POST['Translation']);
				
				foreach($translation_arr as $word_value => $translations_value)
				{
					$col_val[]= array('Translation' => $translations_value,'Word' => $word_value,'Language_ID' => $_POST['Language_ID']);	
					
				}

				$this->load->model('form_model');
				foreach($col_val as $columns)
				{
					$res = $this->form_model->add(array("table"=>"TR","columns"=>$columns));
				}				
				
				echo json_encode($_POST['Language_ID']);				
				
			}
			else 
			{
				echo 0;				
			}			
		}

		public function update_custom_lang_file()
		{
			if($_POST['Lang_ID'])
			{
				if($this->lang_library->updatelangfile($_POST['Lang_ID']))
				{
					echo 1;	
				}
				else 
				{
					echo 0;				
				}				
			}
			else 
			{
				echo 0;				
			}			
		}

		public function date_time_setting()
		{
			define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
	        if(IS_AJAX)
			{
				$result = $this->setting_model->update_user_data();
				if($result === TRUE)
				{
					echo 1;
				}
				else
				{
					echo json_encode($result);
				}
			}
			else
			{
				$this->data['breadcrumb']['heading'] = 'Date &amp; Time Setting';  
				$this->data['breadcrumb']['route'] = array(array('title'=>'Dashboard','path'=>'dashboard'),array('title'=>'Settings','path'=>'Settings'),'Date &amp; Time');  
				$this->data['DETAIL'] = $this->setting_model->get_user_data();  
				$this->data['user_details'] = $this->data['DETAIL']["user_detail"][0];
				$this->load->view('includes/header',$this->data);
				$this->load->view('settings/date_time_view',$this->data);
				$this->load->view('includes/footer',$this->data);
			}
		}

		public function product_type_setting()
		{
			
		}
		
		public function basic_setting()
		{
			define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
	        if(IS_AJAX)
			{
				$result = $this->setting_model->update_user_data();
				if($result === TRUE)
				{
					echo 1;
				}
				else
				{
					echo json_encode($result);
				}
			}
			else
			{
				$this->data['breadcrumb']['heading'] = 'Basic Setting';  
				$this->data['breadcrumb']['route'] = array(array('title'=>'Dashboard','path'=>'dashboard'),array('title'=>'Settings','path'=>'Settings'),'Basic Setting');  
				$this->data['DETAIL'] = $this->setting_model->get_user_data();  
				$this->load->view('includes/header',$this->data);
				$this->load->view('settings/Basic_setting_view',$this->data);
				$this->load->view('includes/footer',$this->data);
			}
		}

		public function synchronize()
		{
			define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
	        if(IS_AJAX)
			{
				$result = $this->setting_model->synchronize();
				if($result)
				{
					echo 1;
				}
				else
				{
					echo json_encode($result);
				}
			}
			else
			{
				return FALSE;
			}
		}

		//public function support()
		//{
			//define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
	        //if(IS_AJAX)
			//{
				//$result = $this->setting_model->send_mail($this->data);
				//if($result === TRUE)
				//{
					//echo 1;
				//}
				//else
				//{
					//echo json_encode($result);
				//}
			//}
			//else
			//{
				//$this->data['breadcrumb']['heading'] = 'Support';
				//$this->data['breadcrumb']['route'] = array(array('title'=>'Dashboard','path'=>'dashboard'),array('title'=>'Settings','path'=>'settings'),'Support');
				//$this->load->view('includes/header',$this->data);
				//$this->load->view('settings/support_view',$this->data);
				//$this->load->view('includes/footer',$this->data);
			//}
		//}

		public function email_setting($id=null)
		{
			$check = $this->setting_model->check($id,$this->data['Login']['Login_as']);
			if($check)
			{
					// $this->setting_model->add();
					$item = $this->fetch_model->show(array('US'=>array('ID'=>$this->data['Login']['ID'])));
					if ($item)
					{
						$this->data['Detail'] = $item[0]['emailConfigID'];
					}
					$this->data['breadcrumb']['heading'] = 'Email Setting';
					$this->data['breadcrumb']['route'] = array(array('title'=>'Dashboard','path'=>'dashboard'),array('title'=>'Settings','path'=>'settings'),'Email setting');
					$this->load->view('includes/header',$this->data);
					$this->load->view('settings/EmailSetting_view',$this->data);
					$this->load->view('includes/footer',$this->data);			
			}
			else
			{
		 		return FALSE;
			}
		}

	public function EsettingAdd()
	{
		$result = $this->setting_model->add();
	}

	public function themes_setting()
		{
			define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
	        if(IS_AJAX)
			{
				$result = $this->setting_model->themes_setting();
				if($result)
				{
					echo 1;
				}
				else
				{
					echo json_encode($result);
				}
			}
			else
			{
				 $item= $this->fetch_model->show(array('US'=>array('ID'=>$this->data['Login']['ID'])));
				 $this->data['item']=$item[0];
				$this->data['breadcrumb']['heading'] = 'Themes';
				$this->data['breadcrumb']['route'] = array(array('title'=>'Dashboard','path'=>'dashboard'),array('title'=>'Settings','path'=>'settings'),'Themes');
				$this->load->view('includes/header',$this->data);
				$this->load->view('settings/themes_view',$this->data);
				$this->load->view('includes/footer',$this->data);
			}
		}
		
	public function import()
		{
			$this->data['breadcrumb']['heading'] = 'Calling Lists';  
			$this->data['breadcrumb']['route'] = array(array('title'=>'Setting','path'=>'settings'),'Import');
			$this->load->view('includes/header',$this->data);
			$this->load->view('pages/calling_import_view',$this->data);
			$this->load->view('includes/footer',$this->data);
		}

		public function importDatabase1()
		{
			ini_set('max_execution_time', 30000);
			// $data=$this->customer_model->importDatabase1();
			$data=$this->setting_model->import();
			if ($data === true)
			{
				echo json_encode(true);
			}
			else
			{
				echo json_encode($data);
			}
		}


	public function uploadFile()
	{
		$target_path = "uploadfile/";  
		$target_path = $target_path.basename($_FILES['file']['name']);
		if(move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {  
		    $this->load->model('form_model');
        	if($this->form_model->add(array('table'=>'SS','columns'=>array('path'=>$target_path))))
        	{
        		$id = $this->db_library->find_max_id('SS');
        		$result = $this->fetch_model->show(array('SS'=>array('ID'=>$id)));
        		// return $result[0];
        		 echo json_encode($result[0]);
        	}
        	else{
        		echo json_encode("Image Not found");
        	}
		} else{  
		    echo "Sorry, file not uploaded, please try again!";
		}  
	}
}
?>