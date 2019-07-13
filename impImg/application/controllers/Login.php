<?php

	class Login extends CI_Controller{



	    public function __construct()

	    {

	        parent::__construct();

	        $this->load->model('system_tools');

	        if($this->system_tools->primary_check() === TRUE)

	        {

		        $this->load->model('login_model');

		        $this->skyq = $this->config->item('skyq');

				$this->load->model('backup_model');	

	        }

	        else

	        {

	        	print_r($this->system_tools->primary_check());

	        }

		}



		public function index($lang="english")

		{

			$lang_id = $this->str_function_library->call('fr>LN>ID:Title=`'.$lang.'`');

			if($this->login_model->set_lang($lang_id))

			{

				if(!($this->login_model->is_locked()))

				{

			        $this->lang->load('custom',$lang);

					$this->data['lang'] = $lang;

					$this->data['all_langs'] = $this->lang_library->get_all_languages();

					$this->load->view('others/login_view',$this->data);

				}

				else

				{

					redirect($this->skyq['default_lock_page']);

				}	

			}

			else {

				show_404();

			}

		}



		public function lock()

		{

			$lang = $this->session_library->get_session_data('Language');

			$lang_id = $this->str_function_library->call('fr>LN>ID:Title=`'.$lang.'`');

			if($this->login_model->set_lang($lang_id))

			{

				if($this->login_model->lock())

				{

			        $this->lang->load('custom',$lang);

					$this->data['lang'] = $lang;

					$this->data['name'] = $this->session_library->get_session_data('Name');

					$this->data['email'] = $this->session_library->get_session_data('Email');

					$this->load->view('others/locked_view',$this->data);

				}

				else

				{	

					redirect($this->skyq['default_login_page']);

				}	

			}

			else {

				redirect('login/logout');

			}

		}



		public function process($page="Login")
		{
			define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
	        if(IS_AJAX)
	        {
	        	if($page === "Login")
	        	{
	        		$this->clearAttachment();
	        		$u = $this->input->post('email');
	            	$p = $this->input->post('password');
	            	echo json_encode($this->login_model->authenticate($u,$p));
	        	}
	        	elseif ($page === "Lock") 
	        	{
	        		$p = $this->input->post('password');
	            	echo json_encode($this->login_model->authenticate(NULL,$p));
	        	}
	        	else
	        	{
	        		redirect($this->skyq['default_login_page']);
	        		return FALSE;
	        	}
            }
	        else
	        {
	        	redirect($this->skyq['default_login_page']);
	        	return FALSE;
	        }
		}



		public function logout()

		{

			if($this->login_model->logout())

			{

				redirect('Login');

			}

			else {

				redirect($this->skyq['default_login_page']);

			}

		}



		public function clearAttachment($value='')
		{
			$files = glob(getcwd().'/attachments/*');
			// $files = glob('/home/skyqin/public_html/skyq.in/support/attachments/*');

			foreach($files as $file){ 
			  if(is_file($file))
			    unlink($file);
			}
		}

		public function student($lang = "english")
		{
			$lang_id = $this->str_function_library->call('fr>LN>ID:Title=`'.$lang.'`');
			if($this->login_model->set_lang($lang_id))
			{
				if(!($this->login_model->is_locked()))
				{
			        $this->lang->load('custom',$lang);
					$this->data['lang'] = $lang;
					$this->data['all_langs'] = $this->lang_library->get_all_languages();
					$this->load->view('others/login_view',$this->data);
				}
				else
				{
					redirect($this->skyq['default_lock_page']);
				}	
			}
			else {
				show_404();
			}
		}

		public function process_student($page = "Login")
		{
			define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
	        if(IS_AJAX)
	        {
	        	if($page === "Login")
	        	{
	        		$this->clearAttachment();
	        		$u = $this->input->post('email');
	            	$p = $this->input->post('password');
	            	echo json_encode($this->login_model->authenticate_student($u,$p));
	        	}
	        	elseif ($page === "Lock") 
	        	{
	        		$p = $this->input->post('password');
	            	echo json_encode($this->login_model->authenticate_student(NULL,$p));
	        	}
	        	else
	        	{
	        		redirect($this->skyq['default_login_page']);
	        		return FALSE;
	        	}
            }
	        else
	        {
	        	redirect($this->skyq['default_login_page']);
	        	return FALSE;
	        }
		}

		public function parent($lang = "english")
		{
			$lang_id = $this->str_function_library->call('fr>LN>ID:Title=`'.$lang.'`');
			if($this->login_model->set_lang($lang_id))
			{
				if(!($this->login_model->is_locked()))
				{
			        $this->lang->load('custom',$lang);
					$this->data['lang'] = $lang;
					$this->data['all_langs'] = $this->lang_library->get_all_languages();
					$this->load->view('others/login_view',$this->data);
				}
				else
				{
					redirect($this->skyq['default_lock_page']);
				}	
			}
			else {
				show_404();
			}
		}

		public function process_parent($page = "Login")
		{
			define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
	        if(IS_AJAX)
	        {
	        	if($page === "Login")
	        	{
	        		$this->clearAttachment();
	        		$u = $this->input->post('email');
	            	$p = $this->input->post('password');
	            	echo json_encode($this->login_model->authenticate_parent($u,$p));
	        	}
	        	elseif ($page === "Lock") 
	        	{
	        		$p = $this->input->post('password');
	            	echo json_encode($this->login_model->authenticate_parent(NULL,$p));
	        	}
	        	else
	        	{
	        		redirect($this->skyq['default_login_page']);
	        		return FALSE;
	        	}
            }
	        else
	        {
	        	redirect($this->skyq['default_login_page']);
	        	return FALSE;
	        }
		}
	}

?>