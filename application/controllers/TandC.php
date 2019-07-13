<?php
/**
* 
*/
class TandC extends CI_controller
{
	
	public function __construct()
	{
		parent::__construct();
		if($this->login_model->check_login())
		{
			$this->lang->load('custom',$this->session_library->get_session_data('Language'));
			$this->data['Login']['Login_as'] = $this->session_library->get_session_data('Login_as');
			$this->data['Login']['Name'] = $this->session_library->get_session_data('Name');
			$this->data['Login']['ID'] = $this->session_library->get_session_data('ID');
			$this->data['Login']['Email'] = $this->session_library->get_session_data('Email');
			$this->load->model('TandC_model');
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
		$this->data["user"]= $this->fetch_model->show(array('US'=> array('ID'=>$this->data['Login']['ID'])));
		$this->data['breadcrumb']['heading'] = 'T & C';  
		$this->data['breadcrumb']['route'] = array(array('title'=>'Dashboard','path'=>'dashboard'),array('title'=>'Settings','path'=>'settings'),'T & C');  
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/t_c_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	public function add()
	{
		$this->TandC_model->add();
	}
}
?>