<?php
	class Employee_notice extends CI_Controller {
		
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
			$this->load->model('employee_notice_model');
			$this->data['my_config'] = $this->my_config = $this->config->item('skyq');
            $this->data['menu'] = $this->setting_model->get_menus($this->data,$this->my_config);
		}
		else 
		{
			redirect($this->config->item('skyq')['default_login_page']);
		}
 	}

	public function index($branch_ID = NULL)
	{
		$this->data['breadcrumb']['heading'] = 'Employee Notices';  
		$this->data['breadcrumb']['route'] = array(array('title'=>'Employee Notices','path'=>'Employee_notice/index/'.$branch_ID),'show');
		$this->data['branch_ID'] = $branch_ID;
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/employee_notice_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	public function get_show_data($branch_ID = NULL)
	{
		$res = $this->employee_notice_model->get_show_data(array('EN'=>array('branch_ID'=>$branch_ID)),array('title','date','description','ID'));
		foreach ($res['data'] as $key => $value) {
			if (strpos($value[3], '/add') !== false) {
				$res['data'][$key][3] = str_replace('/add', '/add/'.$branch_ID, $value[3]);
			}
			$value[1] = date('d-m-Y h:i:s', strtotime($value[1]));
			$res['data'][$key][1] = str_replace('-', '|', $value[1]);
		}
		echo json_encode($res);
 	}

 	public function add($branch_ID = NULL, $id = NULL)
 	{
 		$this->data['breadcrumb']['heading'] = 'Add Employee Notice';
		$this->data['breadcrumb']['route'] = array(array('title'=>'Employee Notices','path'=>'employee_notice/index/'.$branch_ID),'Add');
		$check = $this->employee_notice_model->check($id,$this->data['Login']['Login_as']);
		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
        if(IS_AJAX)
		{
			$this->employee_notice_model->add_or_edit();
		}
		else
		{
			if($check)
			{
				if(!is_null($id))
				{
					$this->data['breadcrumb']['heading'] = 'Edit Employee Notice';
					$this->data['breadcrumb']['route'] = array(array('title'=>'Employee Notices','path'=>'employee_notice/index/'.$branch_ID),'Edit');  
					$this->data['What'] = 'Edit';
					$item = $this->fetch_model->show(array('EN'=>array('ID'=>$id)));
					// $item[0]['student_ID'] = explode(',', $item[0]['student_ID']);
					$this->data['View'] = $item[0];
				}
				$this->data['subjects'] = $this->fetch_model->show('SB');
				$this->load->view('includes/header',$this->data);
				$this->load->view('pages/employee_notice_add_edit_view',$this->data);
				$this->load->view('includes/footer',$this->data);
			}
			else
			{
	 			return FALSE;
			}
		}
	}

 	public function delete($item_id = NULL)
 	{
 		$delete_data = $this->employee_notice_model->delete($item_id);
 		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
		if($delete_data)
 		{
		    if(IS_AJAX)
			{
				echo json_encode($delete_data);	
			}
			else
			{
	 			redirect('employee_notice');
	 		}
		}
 	}

 	public function get_employees()
 	{
 		$res = $this->employee_notice_model->get_employees();
 		echo json_encode($res);
 	}

 	public function student_attendace($id = NULL)
 	{
 		$res = $this->employee_notice_model->student_attendace($id);
 		echo json_encode($res);
 	}

 	public function save_attendance()
 	{
 		$res = $this->employee_notice_model->save_attendance();
 		echo json_encode($res);
 	}

 	public function view($id = NULL)
 	{
 		$res = $this->employee_notice_model->view($id);
 		echo json_encode($res);
 	}
}
?>