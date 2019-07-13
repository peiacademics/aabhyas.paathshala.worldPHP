<?php
class Task extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		if($this->login_model->check_login())
		{
			$this->lang->load('custom',$this->session_library->get_session_data('Language'));
			$this->data['Login']['Login_as'] = $this->session_library->get_session_data('Login_as');
			$this->data['Login']['employeeID'] = $this->session_library->get_session_data('employeeID');
			$this->data['Login']['Name'] = $this->session_library->get_session_data('Name');
			$this->data['Login']['Email'] = $this->session_library->get_session_data('Email');
			$this->data['Login']['ID'] = $this->session_library->get_session_data('ID');
			$this->data['Date_format'] = $this->date_library->get_date_format();
			$this->load->model(array('task_model','form_model'));
			$this->data['my_config'] = $this->my_config = $this->config->item('skyq');
            $this->data['menu'] = $this->setting_model->get_menus($this->data,$this->my_config);
		}
		else 
		{
			$my_config = $this->config->item('skyq');
			redirect($my_config['default_login_page']);
		}
 	}

 	function index($branch_ID = NULL)
	{
		$this->data['breadcrumb']['heading'] = 'Major Tasks';  
		$this->data['breadcrumb']['route'] = array(array('title'=>'Major Tasks','path'=>'task/index/'.$branch_ID),'Show');
		$this->data['branch_ID'] = $branch_ID;
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/task_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	public function add($branch_ID = NULL,$id = NULL)
	{
		$this->data['breadcrumb']['heading'] = 'Add Task';
		$this->data['breadcrumb']['route'] = array(array('title'=>'Major Tasks','path'=>'task/index/'.$branch_ID),'Add');  
		$check = $this->task_model->check($id,$this->data['Login']['Login_as']);
		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
        if(IS_AJAX)
		{
			if(($res = $this->task_model->add_or_edit()) === TRUE)
			{
				echo 1;
			}
			else
			{
				echo json_encode($res);
			}
		}
		else
		{
			if($check)
			{
				if(!is_null($id))
				{
					$this->data['breadcrumb']['heading'] = 'Edit Task';  
					$this->data['breadcrumb']['route'] = array(array('title'=>'Task','path'=>'Task'),'Edit');
					$this->data['DETAIL'] = $this->task_model->get_details($id);
				}
				$this->load->view('includes/header',$this->data);
				$this->load->view('pages/task_add_edit_view',$this->data);
				$this->load->view('includes/footer',$this->data);			
			}
			else
			{
		 		return FALSE;
			}
		}
	}

	public function mainTaskAdd()
	{
		echo json_encode($this->task_model->mainTaskAdd());
	}

	public function mainTaskUpdate()
	{
		echo json_encode($this->task_model->mainTaskUpdate());
	}

	public function subTaskAdd()
	{
		echo json_encode($this->task_model->subTaskAdd());
	}

	public function subTaskUpdate()
	{
		echo json_encode($this->task_model->subTaskUpdate());
	}
	
	public function tasks()
	{
		echo json_encode($this->task_model->tasks());
	}

	public function taskByDate()
	{
		echo json_encode($this->task_model->taskByDate());
	}

	public function subTaskByTask()
	{
		echo json_encode($this->task_model->subTaskByTask());
	}

	public function getEmployee($value='')
	{
		echo json_encode($this->task_model->getEmployee());
	}

	public function downloadAttc($path='')
	{
		$path=$_GET['path'];
		// echo json_encode($this->task_model->downloadAttc());
		$this->task_model->downloadAttc($path);
	}

	public function getProjects()
	{
		echo json_encode($this->fetch_model->show('PRJ'));
	}

	public function creatMainTaskForMeeting($value='')
	{
		echo json_encode($this->task_model->creatMainTaskForMeeting());
	}

	public function sendreq($value='')
	{
		echo json_encode($this->task_model->sendreq());
	}

	public function checkreq($value='')
	{
		echo json_encode($this->task_model->checkreq());
	}

	public function upload_AnyFile()
	{
		echo $this->task_model->upload_AnyFile();
	}

	public function calendar_task($id = NULL)
	{
		$this->data['breadcrumb']['heading'] = 'Calender Tasks';
		$this->data['breadcrumb']['route'] = array(array('title'=>'Calender Tasks','path'=>'task/calendar_task/'.$id),'show');
		$this->data['ID'] = $id;
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/task_calendar_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	public function addCalendarTask()
	{
		echo json_encode($this->task_model->addCalendarTask());
	}

	public function calendarTasks($branch_ID = NULL)
 	{
 		echo json_encode($this->task_model->calendarTasks($branch_ID));
 	}

 	public function add_comment()
 	{
 		echo json_encode($this->task_model->add_comment());
 	}

 	public function lists($branch_ID)
 	{
 		echo json_encode($this->task_model->lists($branch_ID));
 	}

 	public function mark_completed($task_id)
 	{
 		echo json_encode($this->task_model->mark_completed($task_id));
 	}

 	public function make_approval()
 	{
 		echo json_encode($this->task_model->make_approval());
 	}
}
?>