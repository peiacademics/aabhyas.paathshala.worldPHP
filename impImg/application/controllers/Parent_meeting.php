<?php
	class Parent_meeting extends CI_Controller {
		
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
			$this->load->model('parent_meeting_model');
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
		$this->data['breadcrumb']['heading'] = 'Parent Meetings';  
		$this->data['breadcrumb']['route'] = array(array('title'=>'Parent Meetings','path'=>'Parent_meeting/index/'.$branch_ID),'Show');
		$this->data['branch_ID'] = $branch_ID;
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/parent_meeting_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	public function get_show_data($branch_ID = NULL)
	{
		if($this->data['Login']['Login_as'] == 'DSSK10000011')
		{
			$res = $this->parent_meeting_model->get_show_data(array('PME'=>array('branch_ID'=>$branch_ID,'student_ID LIKE'=>'%'.$this->data['Login']['ID'].'%')),array('title','date','description','ID'));
		}
		else if($this->data['Login']['Login_as'] == 'DSSK10000001')
		{
			$res = $this->parent_meeting_model->get_show_data(array('PME'=>array('branch_ID'=>$branch_ID)),array('title','date','description','ID'));
			foreach ($res['data'] as $key => $value) {
				if (strpos($value[3], '/add') !== false) {
					$res['data'][$key][3] = str_replace('/add', '/add/'.$branch_ID, $value[3]);
				}
			}
		}
		else
		{
			$res = $this->parent_meeting_model->get_show_data(array('PME'=>array('branch_ID'=>$branch_ID,'staff_ID LIKE'=>'%'.$this->data['Login']['ID'].'%')),array('title','date','description','ID'));
		}
		echo json_encode($res);
 	}

 	public function add($branch_ID = NULL, $id = NULL)
 	{
 		$this->data['breadcrumb']['heading'] = 'Add Parent Meeting';
		$this->data['breadcrumb']['route'] = array(array('title'=>'Parent Meetings','path'=>'parent_meeting/index/'.$branch_ID),'Add');
		$check = $this->parent_meeting_model->check($id,$this->data['Login']['Login_as']);
		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
        if(IS_AJAX)
		{
			$this->parent_meeting_model->add_or_edit();
		}
		else
		{
			if($check)
			{
				if(!is_null($id))
				{
					$this->data['breadcrumb']['heading'] = 'Edit Parent Meeting';  
					$this->data['breadcrumb']['route'] = array(array('title'=>'Parent Meetings','path'=>'parent_meeting/index/'.$branch_ID),'Edit');  
					$this->data['What'] = 'Edit';
					$item = $this->fetch_model->show(array('PME'=>array('ID'=>$id)));
					// $item[0]['student_ID'] = explode(',', $item[0]['student_ID']);
					$this->data['View'] = $item[0];
				}
				$this->load->view('includes/header',$this->data);
				$this->load->view('pages/parent_meeting_add_edit_view',$this->data);
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
 		$delete_data = $this->parent_meeting_model->delete($item_id);
 		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
		if($delete_data)
 		{
		    if(IS_AJAX)
			{
				echo json_encode($delete_data);	
			}
			else
			{
	 			redirect('parent_meeting');
	 		}
		}
 	}

 	public function get_students()
 	{
 		$res = $this->parent_meeting_model->get_students();
 		echo json_encode($res);
 	}

 	public function meeting_attendace($id = NULL)
 	{
 		$res = $this->parent_meeting_model->meeting_attendace($id);
 		echo json_encode($res);
 	}

 	public function save_attendance()
 	{
 		$res = $this->parent_meeting_model->save_attendance();
 		echo json_encode($res);
 	}

 	public function view($id = NULL)
 	{
 		$res = $this->parent_meeting_model->view($id);
 		echo json_encode($res);	
 	}
}
?>