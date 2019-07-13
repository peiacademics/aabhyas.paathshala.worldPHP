<?php
	class Test extends CI_Controller {
		
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
			$this->load->model('test_model');
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

		$this->data['breadcrumb']['heading'] = 'Student Tests';  
		$this->data['breadcrumb']['route'] = array(array('title'=>'Tests','path'=>'Test/index/'.$branch_ID),'Show');
		$this->data['branch_ID'] = $branch_ID;
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/test_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	public function get_show_data($branch_ID = NULL)
	{
		if($this->data['Login']['Login_as'] == 'DSSK10000011')
		{
			$res = array();
			$assignment_ids = array();
			$assignments = $this->fetch_model->show(array('TS'=>array('student_ID'=>$this->data['Login']['ID'])),array('test_ID'));
			foreach ($assignments as $key_as => $value_as) {
				$assignment_ids[] = $value_as['test_ID'];
			}
			$ids = implode('||', $assignment_ids);
			$res = $this->test_model->get_show_data(array('TE'=>array('branch_ID'=>$branch_ID,'ID'=>$ids)),array('title','batch_ID','>>Name:>fr>SB>name:ID=^subject_ID^','chapter','topic','test_date','ID'));
		}
		else if($this->data['Login']['Login_as'] == 'DSSK10000001')
		{
			$res = $this->test_model->get_show_data(array('TE'=>array('branch_ID'=>$branch_ID)),array('title','batch_ID','>>Name:>fr>SB>name:ID=^subject_ID^','chapter','topic','test_date','ID'));
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
			$res = $this->test_model->get_show_data(array('TE'=>array('branch_ID'=>$branch_ID,'subject_ID'=>$ids)),array('title','batch_ID','>>Name:>fr>SB>name:ID=^subject_ID^','chapter','topic','test_date','ID'));
		}
		foreach ($res['data'] as $key => $value) {
			if ($value[1] != 'all') {
				if(strpos($value[1], ',') !== FALSE)
				{
					$batch = explode(',', $value[1]);
					$batches = '';
					foreach ($batch as $keyb => $valueb) {
						$batches .= $this->str_function_library->call('fr>BT>name:ID=`'.$valueb.'`').',';
					}
					$res['data'][$key][1] = rtrim($batches,',');
				}
				else
				{
					$res['data'][$key][1] = $this->str_function_library->call('fr>BT>name:ID=`'.$value[1].'`');
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
				$res['data'][$key][1] = 'All';
			}
			$value[4] = date('d-m-Y h:i:s', strtotime($value[4]));
			$res['data'][$key][4] = str_replace('-', '|', $value[4]);
		}
		echo json_encode($res);
 	}

 	public function add($branch_ID = NULL, $id = NULL)
 	{
 		$this->data['breadcrumb']['heading'] = 'Add Test';
		$this->data['breadcrumb']['route'] = array(array('title'=>'Tests','path'=>'test/index/'.$branch_ID),'Add');
		$check = $this->test_model->check($id,$this->data['Login']['Login_as']);
		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
        if(IS_AJAX)
		{
			$this->test_model->add_or_edit();
		}
		else
		{
			if($check)
			{
				if(!is_null($id))
				{
					$this->data['breadcrumb']['heading'] = 'Edit Test';  
					$this->data['breadcrumb']['route'] = array(array('title'=>'Tests','path'=>'test/index/'.$branch_ID),'Edit');
					$this->data['What'] = 'Edit';
					$item = $this->fetch_model->show(array('TE'=>array('ID'=>$id)));
					$this->data['View'] = $item[0];
				}
				$this->data['subjects'] = $this->fetch_model->show('SB');
				$this->load->view('includes/header',$this->data);
				$this->load->view('pages/test_add_edit_view',$this->data);
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
 		$delete_data = $this->test_model->delete($item_id);
 		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
		if($delete_data)
 		{
		    if(IS_AJAX)
			{
				echo json_encode($delete_data);
			}
			else
			{
	 			redirect('test');
	 		}
		}
 	}

 	public function get_students()
 	{
 		$res = $this->test_model->get_students();
 		echo json_encode($res);
 	}

 	public function student_attendace($id = NULL)
 	{
 		$res = $this->test_model->student_attendace($id);
 		echo json_encode($res);
 	}

 	public function save_attendance()
 	{
 		$res = $this->test_model->save_attendance();
 		echo json_encode($res);
 	}

 	public function view($id = NULL)
 	{
 		$res = $this->test_model->view($id);
 		echo json_encode($res);	
 	}
}
?>