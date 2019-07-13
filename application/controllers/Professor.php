<?php
class Professor extends CI_Controller
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
			$this->load->model('student_model');
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
		$this->data['breadcrumb']['heading'] = 'Student';  
		$this->data['breadcrumb']['route'] = array("Student");
		// $this->data['Team']=$this->fetch_model->show('EP');`
		$this->data['Team']=$this->fetch_model->show('EP');
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/student_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	function view($branch_ID = NULL)
	{
		$this->data['breadcrumb']['heading'] = 'Professor';  
		$this->data['breadcrumb']['route'] = array("Professor");
		// $this->data['Team']=$this->fetch_model->show('EP');`
		$this->data['Team'] = $this->fetch_model->show(array('EP'=>array('branch_ID'=>$branch_ID)));
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/professor_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}	
}	


?>