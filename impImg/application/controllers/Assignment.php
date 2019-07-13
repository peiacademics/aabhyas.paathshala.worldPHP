<?php
	class Assignment extends CI_Controller {
		
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
			$this->load->model('assignment_model');
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
		$this->data['breadcrumb']['heading'] = 'Student Assignments';  
		$this->data['breadcrumb']['route'] = array(array('title'=>'Assignments','path'=>'Assignment/index/'.$branch_ID),'Show');
		$this->data['branch_ID'] = $branch_ID;
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/assignment_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	public function get_show_data($branch_ID = NULL)
	{
		if($this->data['Login']['Login_as'] == 'DSSK10000011')
		{
			$res = array();
			$assignment_ids = array();
			$assignments = $this->fetch_model->show(array('SA'=>array('student_ID'=>$this->data['Login']['ID'])),array('assignment_ID'));
			foreach ($assignments as $key_as => $value_as) {
				$assignment_ids[] = $value_as['assignment_ID'];
			}
			$ids = implode('||', $assignment_ids);
			$res = $this->assignment_model->get_show_data(array('AS'=>array('branch_ID'=>$branch_ID,'ID'=>$ids)),array('title','>>Name:>fr>SB>name:ID=^subject_ID^','chapter','topic','submission_date','ID'));
		}
		else if($this->data['Login']['Login_as'] == 'DSSK10000001')
		{
			$res = $this->assignment_model->get_show_data(array('AS'=>array('branch_ID'=>$branch_ID)),array('title','>>Name:>fr>SB>name:ID=^subject_ID^','chapter','topic','submission_date','ID'));
			foreach ($res['data'] as $key => $value) {
				if (strpos($value[5], '/add') !== false) {
					$res['data'][$key][5] = str_replace('/add', '/add/'.$branch_ID, $value[5]);
				}
			}
		}
		else
		{
			$res = array();
			$assignment_ids = array();
			$subs = $this->str_function_library->call('fr>US>subject_ID:ID=`'.$this->data['Login']['ID'].'`');
			$assignments = explode(',', $subs);
			foreach ($assignments as $key_as => $value_as) {
				$assignment_ids[] = $value_as;
			}
			$ids = implode('||', $assignment_ids);
			$res = $this->assignment_model->get_show_data(array('AS'=>array('branch_ID'=>$branch_ID,'subject_ID'=>$ids)),array('title','>>Name:>fr>SB>name:ID=^subject_ID^','chapter','topic','submission_date','ID'));
		}
		echo json_encode($res);
 	}

 	public function add($branch_ID = NULL, $id = NULL)
 	{
 		$this->data['breadcrumb']['heading'] = 'Add Assignment';
		$this->data['breadcrumb']['route'] = array(array('title'=>'Assignments','path'=>'assignment/index/'.$branch_ID),'Add');
		$check = $this->assignment_model->check($id,$this->data['Login']['Login_as']);
		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
        if(IS_AJAX)
		{
			$this->assignment_model->add_or_edit();
		}
		else
		{
			if($check)
			{
				if(!is_null($id))
				{
					$this->data['breadcrumb']['heading'] = 'Edit Assignment';  
					$this->data['breadcrumb']['route'] = array(array('title'=>'Assignments','path'=>'assignment/index/'.$branch_ID),'Edit');  
					$this->data['What'] = 'Edit';
					$item = $this->fetch_model->show(array('AS'=>array('ID'=>$id)));
					if($item[0]['batch_ID'] == 'all')
					{
						$this->data['student'] = $this->fetch_model->show('ST');
					}
					else if(strpos($item[0]['batch_ID'], ',') !== FALSE)
					{
						
					}
					else
					{

					}
					$this->data['View'] = $item[0];
				}
				$this->data['subjects'] = $this->fetch_model->show('SB');
				$this->load->view('includes/header',$this->data);
				$this->load->view('pages/assignment_add_edit_view',$this->data);
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
 		$delete_data = $this->assignment_model->delete($item_id);
 		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
		if($delete_data)
 		{
		    if(IS_AJAX)
			{
				echo json_encode($delete_data);	
			}
			else
			{
	 			redirect('assignment');
	 		}
		}
 	}

 	public function get_students()
 	{
 		$res = $this->assignment_model->get_students();
 		echo json_encode($res);
 	}

 	public function student_attendace($id = NULL)
 	{
 		$res = $this->assignment_model->student_attendace($id);
 		echo json_encode($res);
 	}

 	public function save_attendance()
 	{
 		$res = $this->assignment_model->save_attendance();
 		echo json_encode($res);
 	}

 	public function view($id = NULL)
 	{
 		$res = $this->assignment_model->view($id);
 		echo json_encode($res);	
 	}
}
?>