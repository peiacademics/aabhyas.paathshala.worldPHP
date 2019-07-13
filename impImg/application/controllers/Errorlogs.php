<?php
	class Errorlogs extends CI_Controller {
		
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
			$this->data['Date_format'] = $this->date_library->get_date_format();
			$this->load->model('bank_model');
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
		$this->data['breadcrumb']['heading'] = 'Error Logs';  
		$this->data['breadcrumb']['route'] = array(array('title'=>'Dashboard','path'=>'dashboard'),'Error Logs');
		$this->data['errorLogs']=$this->bank_model->getErrorLogs();  
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/error_log_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}
}
?>