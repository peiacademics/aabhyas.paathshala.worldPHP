<?php
	class Test_model extends CI_Model
	{
		public function check($id=NULL,$login_as="Client")
		{
			$user = count($this->fetch_model->show(array('TE' =>array('ID'=>$id))));
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
				$this->errorlog_library->entry('Test_model > check > argument ID is invalid.');
				redirect('test/add/');
			}
		}

		public function add_or_edit()
		{
			$this->load->model('form_model');
			$students = $_POST['student_ID'];
			$_POST['test_date'] = date("Y-m-d H:i:s", strtotime($_POST['test_date']));
			if(empty($_POST['ID']))
			{
				unset($_POST['ID']);
				$result = $this->form_model->add(array("table"=>"TE","columns"=>$_POST));
				foreach ($students as $key_st => $value_st) {
					$stu_asgn = $this->form_model->add(array("table"=>"TS","columns"=>array('student_ID'=>$value_st,'test_ID'=>$this->db_library->find_max_id('TE'),'subject_ID'=>$_POST['subject_ID'],'chapter'=>$_POST['chapter'],'topic'=>$_POST['topic'],'out_of'=>$_POST['max_marks'],'branch_ID'=>$_POST['branch_ID'])));
				}
			}
			else
			{
				$result = $this->form_model->edit(array("table"=>"TE","columns"=>$_POST,"where"=>array('ID'=>$_POST['ID'])));
			}				
			if($result === TRUE)
			{
				$res['id'] = $this->db_library->find_max_id('TE');
				$res['stat'] = TRUE;
				echo json_encode($res);
			}
			else
			{
				echo json_encode($result);
			}
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
			 			foreach ($_POST['batch_ID'] as $key_b => $value_b) {
			 				if($info[0]['Batch'] == $value_b)
			 				{
			 					$value['batch'] = $value_b;
			 					$data['students'][] = $value;
			 					$data['batchWise'][$value['batch']][] = $value['ID'];
			 					$data['batches'][] = array('key'=>$value_b,'value'=>$this->str_function_library->call('fr>BT>name:ID=`'.$value_b.'`'));
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
	 				$res = $this->fetch_model->show(array('TS'=>array('test_ID'=>$id)));
	 				break;
	 			
	 			case 'DSSK10000011':
	 				$res = $this->fetch_model->show(array('TS'=>array('test_ID'=>$id,'student_ID'=>$this->session_library->get_session_data('ID'))));
	 				break;

	 			case 'DSSK10000012':
	 				$res = $this->fetch_model->show(array('TS'=>array('test_ID'=>$id,'student_ID'=>$this->session_library->get_session_data('ID'))));
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
	 			$res = $this->form_model->edit(array("table"=>"TS","columns"=>$value_e,"where"=>array('ID'=>$id)));
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
	 		$student_records = $this->fetch_model->show(array('TS'=>array('test_ID'=>$item_ID)));
	 		$delete_parent = $this->form_model->delete(array('TE'=>array('ID'=>$item_ID)));
	 		if($delete_parent == TRUE)
	 		{
	 			if(($student_records != NULL) && !empty($student_records) && ($student_records != FALSE))
	 			{
	 				$cnt = count($student_records);
	 				$i = 0;
	 				foreach ($student_records as $key => $value) {
	 					$delete_child = $this->form_model->delete(array('TS'=>array('ID'=>$value['ID'])));
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
	 		$rec = $this->fetch_model->show(array('TE'=>array('ID'=>$id)));
	 		$rec = $rec[0];
	 		$rec['test_date'] = date("Y-m-d H:i A", strtotime($rec['test_date']));
	 		$rec['subject_ID'] = $this->str_function_library->call('fr>SB>name:ID=`'.$rec['subject_ID'].'`');

	 		switch ($this->session_library->get_session_data('Login_as')) {
	 			case 'DSSK10000001':
	 				$students = $this->fetch_model->show(array('TS'=>array('test_ID'=>$rec['ID'])),array('student_ID'));
	 				break;
	 			
	 			case 'DSSK10000011':
	 				$students = $this->fetch_model->show(array('TS'=>array('test_ID'=>$rec['ID'],'student_ID'=>$this->session_library->get_session_data('ID'))),array('student_ID'));
	 				break;

	 			case 'DSSK10000012':
	 				$students = $this->fetch_model->show(array('TS'=>array('test_ID'=>$rec['ID'],'student_ID'=>$this->session_library->get_session_data('ID'))),array('student_ID'));
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