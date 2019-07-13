<?php
	class System_tools extends CI_Controller{
		public function __construct()
		{
			parent::__construct();
			if($this->login_model->check_login())
			{
				$this->data['Login']['Name'] = $this->session_library->get_session_data('Name');
				$this->data['Login']['Login_as'] = $this->session_library->get_session_data('Login_as');
				$this->my_config = $this->config->item('skyq');
			}
			else 
			{
				redirect($this->config->item('skyq')['default_login_page']);
			}
	 	}
	}
?>