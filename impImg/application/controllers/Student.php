<?php
class Student extends CI_Controller
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
		$this->data['Team'] = $this->fetch_model->show('ST');
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/student_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	function show($branch_ID = NULL)
	{
		if($this->data['Login']['Login_as'] == 'DSSK10000011')
		{
			$this->data['breadcrumb']['heading'] = 'Student Details';  
			$this->data['breadcrumb']['route'] = array('Student Details');
			$this->data['DETAIL'] = $this->student_model->get_details($this->data['Login']['ID']);
			$this->load->view('includes/header',$this->data);
			$this->load->view('pages/student_detail_view',$this->data);
			$this->load->view('includes/footer',$this->data);
		}
		else
		{
			$this->data['breadcrumb']['heading'] = 'Student';  
			$this->data['breadcrumb']['route'] = array(array('title'=>'Student','path'=>'Student/show/'.$branch_ID),'Show');
			$this->data['Team'] = $this->fetch_model->show(array('ST'=>array('branch_ID'=>$branch_ID)));
			$this->load->view('includes/header',$this->data);
			$this->load->view('pages/student_view',$this->data);
			$this->load->view('includes/footer',$this->data);
		}
	}

	function view($id)
	{
		$this->data['breadcrumb']['heading'] = 'Student Details';  
		$this->data['breadcrumb']['route'] = array(array('title'=>'Student','path'=>'Student'),'Student Information');
		$this->data['DETAIL'] = $this->student_model->get_details($id);
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/student_detail_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	public function add($step=NULL,$id=NULL)
	{
		$this->data['units'] = $this->fetch_model->show("UN");
		$this->data['breadcrumb']['heading'] = 'Add Student';
		$this->data['breadcrumb']['route'] = array(array('title'=>'Students','path'=>'student'),'Add Student');
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

	public function Assignment($branch_ID = NULL)
	{
		//$this->data['Team'] = $this->fetch_model->show(array('ST'=>array('branch_ID'=>$branch_ID)));
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/student_assignment_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}
    

   public function tests($branch_ID = NULL)
	{
		//$this->data['Team'] = $this->fetch_model->show(array('ST'=>array('branch_ID'=>$branch_ID)));
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/tests_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	public function message($branch_ID = NULL)
	{
		$this->data['breadcrumb']['heading'] = 'Student Messages';  
		$this->data['breadcrumb']['route'] = array(array('title'=>'Messages','path'=>'Student/message/'.$branch_ID),'Show');
		if($this->data['Login']['Login_as'] == 'DSSK10000011')
		{
			$id = $this->session_library->get_session_data('ID');
			$stud_rec = $this->fetch_model->show(array('ST'=>array('ID'=>$id)));
			$this->data['student'] = $stud_rec[0];
			$this->data['mobile'] = $this->fetch_model->show(array('COMD'=>array('message_type'=>'mobile','msgto LIKE '=>'%'.$id.'%')));
			$this->data['gateway'] = $this->fetch_model->show(array('COMD'=>array('message_type'=>'gateway','msgto LIKE '=>'%'.$id.'%')));
		}
		else
		{
			$this->data['student'] = NULL;
			$this->data['mobile'] = $this->fetch_model->show(array('COMD'=>array('message_type'=>'mobile','branch_ID'=>$branch_ID)));
			$this->data['gateway'] = $this->fetch_model->show(array('COMD'=>array('message_type'=>'gateway','branch_ID'=>$branch_ID)));
		}
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/message_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	public function email($branch_ID = NULL)
	{
		$this->data['breadcrumb']['heading'] = 'Student Emails';  
		$this->data['breadcrumb']['route'] = array(array('title'=>'Emails','path'=>'Student/email/'.$branch_ID),'Show');
		if($this->data['Login']['Login_as'] == 'DSSK10000011')
		{
			$id = $this->session_library->get_session_data('ID');
			$stud_rec = $this->fetch_model->show(array('ST'=>array('ID'=>$id)));
			$this->data['student'] = $stud_rec[0];
			$this->data['emails'] = $this->fetch_model->show(array('COMD'=>array('message_type'=>'email','to LIKE'=>'%'.$id.'%')));
		}
		else
		{
			$this->data['student'] = NULL;
			$this->data['emails'] = $this->fetch_model->show(array('COMD'=>array('message_type'=>'email','branch_ID'=>$branch_ID)));
		}
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/email_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	public function app_notifications($branch_ID = NULL)
	{
		//$this->data['Team'] = $this->fetch_model->show(array('ST'=>array('branch_ID'=>$branch_ID)));
		$this->data['breadcrumb']['heading'] = 'Student App Notifications';  
		$this->data['breadcrumb']['route'] = array(array('title'=>'App Notifications','path'=>'Student/app_notifications/'.$branch_ID),'Show');
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/app_notifications_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	public function notice_board($branch_ID = NULL)
	{
		//$this->data['Team'] = $this->fetch_model->show(array('ST'=>array('branch_ID'=>$branch_ID)));
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/notice_board_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	public function remark($branch_ID = NULL)
	{
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/remark_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	public function chat_room($branch_ID = NULL, $student_ID = NULL)
	{
		$this->data['breadcrumb']['heading'] = 'Chat Room';  
		$this->data['breadcrumb']['route'] = array(array('title'=>'Chats','path'=>'Student/chat_room/'.$branch_ID),'Show');
		$this->load->view('includes/header',$this->data);
		if($this->data['Login']['Login_as'] == 'DSSK10000011' || $this->data['Login']['Login_as'] == 'DSSK10000012')
		{
			$this->load->view('pages/chat_room_st_view',$this->data);
		}
		else{
			if($student_ID != NULL)
			{
				$this->data['student_ID'] = $student_ID;
			}
			$this->load->view('pages/chat_room_view',$this->data);
		}
		$this->load->view('includes/footer',$this->data);
	}

	public function doubt($branch_ID = NULL)
	{
		//$this->data['Team'] = $this->fetch_model->show(array('ST'=>array('branch_ID'=>$branch_ID)));
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/doubt_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	public function addInstallments()
	{
		echo json_encode($this->student_model->addInstallments());
	}

	public function make_solved_doubt()
  	{
  		echo json_encode($this->student_model->make_solved_doubt());
  	}

  	public function add_doubts()
  	{
  		echo json_encode($this->student_model->add_doubts());
  	}

  	public function get_branchwise_students($branch_ID = NULL)
  	{
  		echo json_encode($this->student_model->get_branchwise_students($branch_ID));
  	}

  	public function get_chats()
  	{
  		echo json_encode($this->student_model->get_chats());
  	}

  	public function send_msg()
  	{
  		echo json_encode($this->student_model->send_msg());
  	}

  	public function get_chat_notification()
  	{
  		echo json_encode($this->student_model->get_chat_notification());
  	}

  	public function get_chat_student()
  	{
  		echo json_encode($this->student_model->get_chat_student());
  	}

  	public function get_chat_status()
  	{
  		$status = $this->fetch_model->show(array('ST'=>array('ID'=>$_POST['student_ID'])),array('chat_mute'));
  		echo json_encode($status[0]['chat_mute']);
  	}

  	public function change_mute()
  	{
  		echo json_encode($this->student_model->change_mute());
  	}
}	


?>