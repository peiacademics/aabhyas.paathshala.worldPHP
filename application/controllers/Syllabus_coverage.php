<?php
	class Syllabus_coverage extends CI_Controller {
		
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
			$this->load->model('syllabus_coverage_model');
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
		if($this->data['Login']['Login_as'] == 'DSSK10000011' || $this->data['Login']['Login_as'] == 'DSSK10000012')
		{
			$this->data['breadcrumb']['heading'] = 'Student Syllabus Coverage';  
			$this->data['breadcrumb']['route'] = array(array('title'=>'Dashboard','path'=>'dashboard'),'Student Syllabus Coverage');
			$subjects = $this->str_function_library->call('fr>ADT>Subject:Student_ID=`'.$this->data['Login']['ID'].'`');
			$subjects = rtrim($subjects, ',');
			$subs = explode(',', $subjects);
			$sb = array();
			foreach ($subs as $key => $value) {
				if($value != NULL)
				{
					$sb['sub'][$value] = $this->str_function_library->call('fr>SB>name:ID=`'.$value.'`');
					$sb[$value]['self_study'] = $this->fetch_model->show(array('SSC'=>array('subject_ID'=>$value,'student_ID'=>$this->data['Login']['ID'])));
				}
			}
			$this->data['student_ID'] = $this->data['Login']['ID'];
			$this->data['subjects'] = $sb;
			$this->load->view('includes/header',$this->data);
			$this->load->view('pages/syllabus_student_view',$this->data);
			$this->load->view('includes/footer',$this->data);
		}
		else if($this->data['Login']['Login_as'] == 'DSSK10000001')
		{
			$this->data['breadcrumb']['heading'] = 'Syllabus Coverage';  
			$this->data['breadcrumb']['route'] = array(array('title'=>'Syllabus Coverage','path'=>'Syllabus_coverage/index/'.$branch_ID),'Syllabus Coverage');
			$this->data['branch_ID'] = $branch_ID;
			$this->data['subjects'] = $this->fetch_model->show('SB');
			$this->load->view('includes/header',$this->data);
			$this->load->view('pages/syllabus_coverage_view',$this->data);
			$this->load->view('includes/footer',$this->data);
		}
		else
		{
			$this->data['breadcrumb']['heading'] = 'Syllabus Coverage';  
			$this->data['breadcrumb']['route'] = array(array('title'=>'Dashboard','path'=>'dashboard'),'Syllabus Coverage');
			$this->data['branch_ID'] = $branch_ID;
			$assignment_ids = array();
			$subs = $this->str_function_library->call('fr>US>subject_ID:ID=`'.$this->data['Login']['ID'].'`');
			$assignments = explode(',', $subs);
			foreach ($assignments as $key_as => $value_as) {
				$assignment_ids[] = $value_as;
			}
			$ids = implode('||', $assignment_ids);
			$this->data['subjects'] = $this->fetch_model->show(array('SB'=>array('ID'=>$ids)));
			$this->load->view('includes/header',$this->data);
			$this->load->view('pages/syllabus_coverage_view',$this->data);
			$this->load->view('includes/footer',$this->data);
		}
	}

	public function show($student_ID = NULL)
	{
		$this->data['breadcrumb']['heading'] = 'Student Syllabus Coverage';  
		$this->data['breadcrumb']['route'] = array(array('title'=>'Dashboard','path'=>'dashboard'),'Student Syllabus Coverage');
		$subjects = $this->str_function_library->call('fr>ADT>Subject:Student_ID=`'.$student_ID.'`');
		$subjects = rtrim($subjects, ',');
		$subs = explode(',', $subjects);
		$sb = array();
		foreach ($subs as $key => $value) {
			if($value != NULL)
			{
				$sb['sub'][$value] = $this->str_function_library->call('fr>SB>name:ID=`'.$value.'`');
				$sb[$value]['self_study'] = $this->fetch_model->show(array('SSC'=>array('subject_ID'=>$value,'student_ID'=>$student_ID)));
			}
		}
		$this->data['student_ID'] = $student_ID;
		$this->data['subjects'] = $sb;
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/syllabus_student_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	public function students($branch_ID = NULL)
	{
		$this->data['breadcrumb']['heading'] = 'Student Syllabus Coverage';  
		$this->data['breadcrumb']['route'] = array(array('title'=>'Student Syllabus Coverage','path'=>'Syllabus_coverage/students/'.$branch_ID),'Show');
		$students = $this->fetch_model->show(array('ST'=>array('branch_ID'=>$branch_ID)));
		$syllabus = $this->fetch_model->show(array('SYC'=>array('branch_ID'=>$branch_ID)),array('student_ID'));
		foreach ($students as $key_st => $value_st) {
			/*$students[$key_st]['count'] = 0;
			foreach ($syllabus as $key_sy => $value_sy) {
				if(strpos($value_sy['student_ID'], $value_st['ID']) != FALSE)
				{
					$students[$key_st]['count']++;
				}
			}
			if($students[$key_st]['count'] < 1)
			{
				unset($students[$key_st]);
			}*/
		}
		$this->data['Team'] = $students;
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/student_syllabus_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	public function get_show_data($branch_ID = NULL, $subject_ID = NULL)
	{
		$res = $this->syllabus_coverage_model->get_show_data(array('SYC'=>array('branch_ID'=>$branch_ID,'subject_ID'=>$subject_ID)),array('batch_ID','chapter','topic','date','>>Name:>fr>SB>name:ID=^subject_ID^','ID'));
		foreach ($res['data'] as $key => $value) {
			if ($value[0] != 'all') {
				if(strpos($value[0], ',') !== FALSE)
				{
					$batch = explode(',', $value[0]);
					$batches = '';
					foreach ($batch as $keyb => $valueb) {
						$batches .= $this->str_function_library->call('fr>BT>name:ID=`'.$valueb.'`').',';
					}
					$res['data'][$key][0] = rtrim($batches,',');
				}
				else
				{
					$res['data'][$key][0] = $this->str_function_library->call('fr>BT>name:ID=`'.$value[0].'`');
				}
				if(strpos($value[2], ',') !== FALSE)
		 		{
		 			$ch='';
		 			$chapt=explode(',', $value[2]);
		 			foreach ($chapt as $keyc => $valuec) 
		 			{
		 				$ch.= $this->str_function_library->call('fr>LS>name:ID=`'.$valuec.'`').',';
		 			}
		 			$res['data'][$key][2]  = rtrim($ch,',');
		 		}
		 		else{
		 		$res['data'][$key][2]  = $this->str_function_library->call('fr>LS>name:ID=`'.$value[3].'`');

		 		}
			}
			else
			{
				$res['data'][$key][0] = 'All';
			}
			$value[3] = date('d-m-Y h:i:s', strtotime($value[3]));
			$res['data'][$key][3] = str_replace('-', '|', $value[3]);
		}
		echo json_encode($res);
 	}

 	public function add($branch_ID = NULL, $id = NULL)
 	{
 		$this->data['breadcrumb']['heading'] = 'Add Syllabus Coverage';
		$this->data['breadcrumb']['route'] = array(array('title'=>'Dashboard','path'=>'dashboard'),array('title'=>'Syllabus Coverage','path'=>'syllabus_coverage/index/'.$branch_ID),'Add');
		$check = $this->syllabus_coverage_model->check($id,$this->data['Login']['Login_as']);
		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
        if(IS_AJAX)
		{
			$this->syllabus_coverage_model->add_or_edit();
		}
		else
		{
			if($check)
			{
				if(!is_null($id))
				{
					$this->data['breadcrumb']['heading'] = 'Edit Syllabus Coverage';  
					$this->data['breadcrumb']['route'] = array(array('title'=>'Dashboard','path'=>'dashboard'),array('title'=>'Syllabus Coverage','path'=>'syllabus_coverage/index/'.$branch_ID),'Edit');
					$this->data['What'] = 'Edit';
					$item = $this->fetch_model->show(array('SYC'=>array('ID'=>$id)));
					$this->data['View'] = $item[0];
				}
				$this->data['subjects'] = $this->fetch_model->show('SB');
				$this->load->view('includes/header',$this->data);
				$this->load->view('pages/syllabus_coverage_add_edit_view',$this->data);
				$this->load->view('includes/footer',$this->data);
			}
			else
			{
	 			return FALSE;
			}
		}
	}

 	public function delete($item_id=NULL)
 	{
 		$delete_data = $this->syllabus_coverage_model->delete($item_id);
 		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
		if($delete_data)
 		{
		    if(IS_AJAX)
			{
				echo json_encode($delete_data);
			}
			else
			{
	 			redirect('syllabus_coverage');
	 		}
		}
 	}

 	public function get_students()
 	{
 		$res = $this->syllabus_coverage_model->get_students();
 		echo json_encode($res);
 	}

 	public function student_attendace($id = NULL)
 	{
 		$res = $this->syllabus_coverage_model->student_attendace($id);
 		echo json_encode($res);
 	}

 	public function save_attendance()
 	{
 		$res = $this->syllabus_coverage_model->save_attendance();
 		echo json_encode($res);
 	}

 	public function view($id = NULL)
 	{
 		$res = $this->syllabus_coverage_model->view($id);
 		echo json_encode($res);	
 	}

 	public function student_syllabus()
 	{
 		$res = $this->syllabus_coverage_model->student_syllabus();
 		echo json_encode($res);
 	}

 	public function add_remark()
 	{
 		$res = $this->syllabus_coverage_model->add_remark();
 		echo json_encode($res);
 	}

 	public function change_checked_status()
 	{
 		$res = $this->syllabus_coverage_model->change_checked_status();
 		echo json_encode($res);
 	}

 	public function append_remark()
 	{
 		$res = $this->syllabus_coverage_model->append_remark();
 		echo json_encode($res);
 	}
}
?>