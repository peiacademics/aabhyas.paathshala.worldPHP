<?php
class Drive extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if($this->login_model->check_login())
		{
			$this->data['Login']['Name'] = $this->session_library->get_session_data('Name');
			$this->data['Login']['Login_as'] = $this->session_library->get_session_data('Login_as');
			$this->data['Login']['ID'] = $this->session_library->get_session_data('ID');
			$this->data['Date_format'] = $this->date_library->get_date_format();
			// $this->load->model('team_model');
			$this->data['my_config'] = $this->my_config = $this->config->item('skyq');
            $this->data['menu'] = $this->setting_model->get_menus($this->data,$this->my_config);
		}
		else
		{
			redirect($this->config->item('skyq')['default_login_page']);
		}
 	}

	function index()
	{
		$this->data['breadcrumb']['heading'] = 'Drive';  
		$this->data['breadcrumb']['route'] = array("Drive");
		// $this->data['Team']=$this->fetch_model->show('EP');`
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/awards_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	function view()
	{
		$this->data['breadcrumb']['heading'] = 'Drive';  
		$this->data['breadcrumb']['route'] = array("Drive");
		// $this->data['Team']=$this->fetch_model->show('EP');`
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/awards_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

}	

?>