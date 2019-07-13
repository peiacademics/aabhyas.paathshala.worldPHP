<?php
	class Assignment_model extends CI_Model
	{
		public function check($id=NULL,$login_as="Client")
		{
			$user = count($this->fetch_model->show(array('AS' =>array('ID'=>$id))));
			if(is_null($id))
			{
				return TRUE;
			}
			elseif($user > 0)
			{
				return TRUE;
			}
			else
			{
				$this->errorlog_library->entry('Assignment_model > check > argument ID is invalid.');
				redirect('assignment/add/');
			}
		}

		public function add_or_edit()
		{
			$this->load->model('form_model');
			$students = $_POST['student_ID'];
			$_POST['submission_date'] = date('Y-m-d h:i:s', strtotime($_POST['submission_date']));
			if(empty($_POST['ID']))
			{
				unset($_POST['ID']);
				$result = $this->form_model->add(array("table"=>"AS","columns"=>$_POST));
				$assignment_ID =  $this->db_library->find_max_id('AS');
				foreach ($students as $key_st => $value_st) {
					$stu_asgn = $this->form_model->add(array("table"=>"SA","columns"=>array('student_ID'=>$value_st,'assignment_ID'=>$assignment_ID,'subject_ID'=>$_POST['subject_ID'],'chapter'=>$_POST['chapter'],'topic'=>$_POST['topic'],'branch_ID'=>$_POST['branch_ID'],'asgn_status'=>'not_submitted')));
				}
			}
			else
			{
				$result = $this->form_model->edit(array("table"=>"AS","columns"=>$_POST,"where"=>array('ID'=>$_POST['ID'])));
			}				
				echo json_encode($result);
			
		}

		public function get_show_data($input,$output)
		{
		 	$this->load->library('datatable_library');
	 		return $this->datatable_library->get_data($input,$output);
		}

		public function get_students()
	 	{
	 		if(@$_POST['batch_ID'][0] == 'all')
	 		{
	 			$data['students'] = $this->fetch_model->show(array('ST'=>array('branch_ID'=>$_POST['branch_ID'])));
	 			$data['batchWise'] = 'All';
	 		}
	 		else
	 		{
	 			if (empty($_POST['batch_ID'])) {
	 				$data = array();
	 			}
	 			else
	 			{
	 				$data = array();
		 			$res = $this->fetch_model->show(array('ST'=>array('branch_ID'=>$_POST['branch_ID'])));
		 			foreach ($res as $key => $value) {
		 				$info = $this->fetch_model->show(array('ADT'=>array('student_ID'=>$value['ID'])));
		 				if($info != FALSE)
		 				{
				 			foreach ($_POST['batch_ID'] as $key_b => $value_b) {
				 				if($info[0]['Batch'] == $value_b)
				 				{
				 					$value['batch']=$value_b;
				 					$data['students'][] = $value;
				 					$data['batchWise'][$value['batch']][] = $value['ID'];
				 					$data['batches'][] = array('key'=>$value_b,'value'=>$this->str_function_library->call('fr>BT>name:ID=`'.$value_b.'`'));
				 				}
				 			}
				 		}
			 		}
	 			}
	 		}
	 		return $data;
	 	}

	 	public function student_attendace($id = NULL)
	 	{
	 		switch ($this->session_library->get_session_data('Login_as')) {
	 			case 'DSSK10000001':
	 				$res = $this->fetch_model->show(array('SA'=>array('assignment_ID'=>$id)));
	 				break;
	 			case 'DSSK10000002':
	 				$res = $this->fetch_model->show(array('SA'=>array('assignment_ID'=>$id)),array('student_ID'));
	 				break;
	 			case 'DSSK10000003':
	 				$res = $this->fetch_model->show(array('SA'=>array('assignment_ID'=>$id)),array('student_ID'));
	 				break;
	 			case 'DSSK10000004':
	 				$res = $this->fetch_model->show(array('SA'=>array('assignment_ID'=>$id)),array('student_ID'));
	 				break;
			 	case 'DSSK10000005':
	 				$res = $this->fetch_model->show(array('SA'=>array('assignment_ID'=>$id)),array('student_ID'));
	 				break;
	 			case 'DSSK10000006':
	 				$res = $this->fetch_model->show(array('SA'=>array('assignment_ID'=>$id)),array('student_ID'));
	 				break;
	 			case 'DSSK10000007':
	 				$res = $this->fetch_model->show(array('SA'=>array('assignment_ID'=>$id)),array('student_ID'));
	 				break;
	 			case 'DSSK10000008':
	 				$res = $this->fetch_model->show(array('SA'=>array('assignment_ID'=>$id)),array('student_ID'));
	 				break;
	 			case 'DSSK10000009':
	 				$res = $this->fetch_model->show(array('SA'=>array('assignment_ID'=>$id)),array('student_ID'));
	 				break;
	 			case 'DSSK10000010':
	 				$res = $this->fetch_model->show(array('SA'=>array('assignment_ID'=>$id)),array('student_ID'));
	 				break;
	 			case 'DSSK10000011':
	 				$res = $this->fetch_model->show(array('SA'=>array('assignment_ID'=>$id,'student_ID'=>$this->session_library->get_session_data('ID'))));
	 				break;
	 			case 'DSSK10000012':
	 				$res = $this->fetch_model->show(array('SA'=>array('assignment_ID'=>$id,'student_ID'=>$this->session_library->get_session_data('ID'))));
	 				break;
	 			default:
	 				$res=array();
	 				break;
	 		}
			
			foreach ($res as $key_at => $value_at) {
				$res[$key_at]['name'] = $this->str_function_library->call('fr>ST>Name:ID=`'.$value_at['student_ID'].'`').' '.$this->str_function_library->call('fr>ST>Middle_name:ID=`'.$value_at['student_ID'].'`').' '.$this->str_function_library->call('fr>ST>Last_name:ID=`'.$value_at['student_ID'].'`');
			}
	 		return $res;
	 	}

	 	public function save_attendance()
	 	{
	 		$this->load->model('form_model');
	 		foreach ($_POST as $key => $value) {
	 			$exp_key = explode('-', $key);
	 			$edit_arr[$exp_key[1]][$exp_key[0]] = $value;
	 		}
	 		$cnt = count($edit_arr);
	 		$i = 0;
	 		foreach ($edit_arr as $key_e => $value_e) {
	 			$id = $value_e['as_ID'];
	 			unset($value_e['as_ID']);
	 			if($value_e['asgn_status'] == 'submitted')
	 			{
	 				$value_e['submitted_on'] = date('Y-m-d H:i:s');
	 			}
	 			else
	 			{
	 				$value_e['submitted_on'] = NULL;
	 			}
	 			$res = $this->form_model->edit(array("table"=>"SA","columns"=>$value_e,"where"=>array('ID'=>$id)));
	 			if($res == TRUE)
	 			{
	 				$i++;
	 			}
	 		}
	 		if($cnt == $i)
	 		{
	 			return TRUE;
	 		}
	 		else
	 		{
	 			return FALSE;
	 		}
	 	}

	 	public function delete($item_ID = NULL)
	 	{
	 		$this->load->model('form_model');
	 		$student_records = $this->fetch_model->show(array('SA'=>array('assignment_ID'=>$item_ID)));
	 		$delete_parent = $this->form_model->delete(array('AS'=>array('ID'=>$item_ID)));
	 		if($delete_parent == TRUE)
	 		{
	 			if(($student_records != NULL) && !empty($student_records) && ($student_records != FALSE))
	 			{
	 				$cnt = count($student_records);
	 				$i = 0;
	 				foreach ($student_records as $key => $value) {
	 					$delete_child = $this->form_model->delete(array('SA'=>array('ID'=>$value['ID'])));
	 					if($delete_child == TRUE)
	 					{
	 						$i++;
	 					}
	 				}
	 				if($cnt == $i)
	 				{
	 					return TRUE;
	 				}
	 				else
	 				{
	 					return FALSE;
	 				}
	 			}
	 			else
	 			{
	 				return TRUE;
	 			}
	 		}
	 		else
	 		{
	 			return FALSE;
	 		}
	 	}

	 	public function view($id = NULL)
	 	{
	 		$rec = $this->fetch_model->show(array('AS'=>array('ID'=>$id)));
	 		$rec = $rec[0];	
	 		$rec['submission_date'] = date("Y-m-d H:i A", strtotime($rec['submission_date']));
	 		$rec['subject_ID'] = $this->str_function_library->call('fr>SB>name:ID=`'.$rec['subject_ID'].'`');
	 		if(strpos($rec['chapter'], ',')!== FALSE)
	 		{
	 			$ch = '';
	 			$chapt = explode(',', $rec['chapter']);
	 			foreach ($chapt as $keyc => $valuec) 
	 			{
	 				$ch .= $this->str_function_library->call('fr>LS>name:ID=`'.$valuec.'`').',';
	 			}
	 			$rec['chapter'] = rtrim($ch,',');
	 		}
	 		else{
		 		$rec['chapter'] = $this->str_function_library->call('fr>LS>name:ID=`'.$rec['chapter'].'`');
	 		}
	 		switch ($this->session_library->get_session_data('Login_as')) {
	 			case 'DSSK10000001':
	 				$students = $this->fetch_model->show(array('SA'=>array('assignment_ID'=>$rec['ID'])),array('student_ID'));
	 				break;
	 			case 'DSSK10000002':
	 				$students = $this->fetch_model->show(array('SA'=>array('assignment_ID'=>$rec['ID'])),array('student_ID'));
	 				break;
	 			case 'DSSK10000003':
	 				$students = $this->fetch_model->show(array('SA'=>array('assignment_ID'=>$rec['ID'])),array('student_ID'));
	 				break;
	 			case 'DSSK10000004':
	 				$students = $this->fetch_model->show(array('SA'=>array('assignment_ID'=>$rec['ID'])),array('student_ID'));
	 				break;
			 	case 'DSSK10000005':
	 				$students = $this->fetch_model->show(array('SA'=>array('assignment_ID'=>$rec['ID'])),array('student_ID'));
	 				break;
	 			case 'DSSK10000006':
	 				$students = $this->fetch_model->show(array('SA'=>array('assignment_ID'=>$rec['ID'])),array('student_ID'));
	 				break;
	 			case 'DSSK10000007':
	 				$students = $this->fetch_model->show(array('SA'=>array('assignment_ID'=>$rec['ID'])),array('student_ID'));
	 				break;
	 			case 'DSSK10000008':
	 				$students = $this->fetch_model->show(array('SA'=>array('assignment_ID'=>$rec['ID'])),array('student_ID'));
	 				break;
	 			case 'DSSK10000009':
	 				$students = $this->fetch_model->show(array('SA'=>array('assignment_ID'=>$rec['ID'])),array('student_ID'));
	 				break;
	 			case 'DSSK10000010':
	 				$students = $this->fetch_model->show(array('SA'=>array('assignment_ID'=>$rec['ID'])),array('student_ID'));
	 				break;
	 			case 'DSSK10000011':
	 				$students = $this->fetch_model->show(array('SA'=>array('assignment_ID'=>$rec['ID'],'student_ID'=>$this->session_library->get_session_data('ID'))),array('student_ID'));
	 				break;

	 			case 'DSSK10000012':
	 				$students = $this->fetch_model->show(array('SA'=>array('assignment_ID'=>$rec['ID'],'student_ID'=>$this->session_library->get_session_data('ID'))),array('student_ID'));
	 				break;

	 			default:
	 				$students=array();
	 				break;
	 		}
	 		foreach ($students as $key => $value) {
	 			$rec['students'][$key]['student'] = $this->str_function_library->call('fr>ST>Name:ID=`'.$value['student_ID'].'`').' '.$this->str_function_library->call('fr>ST>Middle_name:ID=`'.$value['student_ID'].'`').' '.$this->str_function_library->call('fr>ST>Last_name:ID=`'.$value['student_ID'].'`');
	 			$image_ID = $this->str_function_library->call('fr>ST>img_ID:ID=`'.$value['student_ID'].'`');
	 			$rec['students'][$key]['path'] = $this->str_function_library->call('fr>SS>path:ID=`'.$image_ID.'`');
	 		}
	 		return $rec;
	 	}

	}
?>