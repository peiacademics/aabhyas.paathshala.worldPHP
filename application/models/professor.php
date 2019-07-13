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

	function view()
	{
		$this->data['breadcrumb']['heading'] = 'Marketing Telecasting';  
		$this->data['breadcrumb']['route'] = array("Marketing Telecasting");
		// $this->data['Team']=$this->fetch_model->show('EP');`
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/awards_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	public function add($step=NULL,$id=NULL)
	{
		$this->data['units']=$this->fetch_model->show("UN");
		$this->data['breadcrumb']['heading'] = 'Add Student';
		$this->data['breadcrumb']['route'] = array(array('title'=>'Dashboard','path'=>'dashboard'),array('title'=>'Students','path'=>'student'),'Add Student');
		$check = $this->student_model->check($id,$this->data['Login']['Login_as']);
		if($check)
		{
	 		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
	        if(IS_AJAX)
			{
				if (($res = $this->student_model->add_or_edit($step,$id)) === TRUE) {
					echo 1;
				}
				else
				{
					echo json_encode($res);
				}
			}
			else
			{
				if (!empty($id))
				{
					$this->data['id']=$id;
					$this->data['DETAIL']=$this->student_model->get_details($id);
				}
				if ($step==='step1' && !empty($id)) {
					$this->load->view('includes/header',$this->data);
					$this->load->view('pages/student_add_edit_view_step1',$this->data);
					$this->load->view('includes/footer',$this->data);
				}
				else if ($step==='step2' && !empty($id)) {
					$this->load->view('includes/header',$this->data);
					$this->load->view('pages/student_add_edit_view_step2',$this->data);
					$this->load->view('includes/footer',$this->data);
				}
				else if ($step==='step3' && !empty($id)) {
					$this->load->view('includes/header',$this->data);
					$this->load->view('pages/student_add_edit_view_step3',$this->data);
					$this->load->view('includes/footer',$this->data);
				}
				else {
					$this->load->view('includes/header',$this->data);
					$this->load->view('pages/student_add_edit_view_step',$this->data);
					$this->load->view('includes/footer',$this->data);
				}		
			}
		}
		else
		{
	 		return FALSE;
		}
	}

	public function delete_Field($id)
	{
		echo json_encode($this->student_model->delete_Field($id));
	}

	public function delete_File($id,$Student)
	{
		echo json_encode($this->student_model->delete_File($id,$Student));
	}

	public function upload_AnyFile()
	{
		echo $this->student_model->upload_AnyFile();
	}

	public function Assignment($value='')
	{
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/student_assignment_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}
    

   public function tests($value='')
	{
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/tests_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	public function message($value='')
	{
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/message_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	public function email($value='')
	{
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/email_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	public function app_notifications($value='')
	{
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/app_notifications_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	public function notice_board($value='')
	{
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/notice_board_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	public function remark($value='')
	{
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/remark_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	public function chat_room($value='')
	{
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/chat_room_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	public function doubt($value='')
	{
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/doubt_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}
}	


?>