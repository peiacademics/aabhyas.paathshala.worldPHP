<?php
	class Parent_meeting_model extends CI_Model
	{
		public function check($id = NULL, $login_as = "Client")
		{
			$user = count($this->fetch_model->show(array('PME' =>array('ID'=>$id))));
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
				$this->errorlog_library->entry('Parent_meeting_model > check > argument ID is invalid.');
				redirect('Parent_meeting/add/');
			}
		}

		public function add_or_edit()
		{
			$this->load->model('form_model');
			$_POST['date'] = date("Y-m-d H:i:s", strtotime($_POST['date']));
			if(empty($_POST['ID']))
			{
				unset($_POST['ID']);
				$result = $this->form_model->add(array("table"=>"PME","columns"=>$_POST));
				foreach ($_POST['student_ID'] as $key_st => $value_st) {
					$stu_asgn = $this->form_model->add(array("table"=>"PMA","columns"=>array('student_ID'=>$value_st,'meeting_ID'=>$this->db_library->find_max_id('PME'))));
				}
			}
			else
			{
				$result = $this->form_model->edit(array("table"=>"PME","columns"=>$_POST,"where"=>array('ID'=>$_POST['ID'])));
			}				
			if($result === TRUE)
			{
				$res['id'] = $this->db_library->find_max_id('PME');
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

	 	public function meeting_attendace($id = NULL)
	 	{
			$res = $this->fetch_model->show(array('PMA'=>array('meeting_ID'=>$id)));
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
	 			$id = $value_e['pma_ID'];
	 			unset($value_e['pma_ID']);
	 			$value_e['date'] = date('Y-m-d H:i:s');
	 			$res = $this->form_model->edit(array("table"=>"PMA","columns"=>$value_e,"where"=>array('ID'=>$id)));
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
	 		$student_records = $this->fetch_model->show(array('PMA'=>array('meeting_ID'=>$item_ID)));
	 		$delete_parent = $this->form_model->delete(array('PME'=>array('ID'=>$item_ID)));
	 		return $delete_parent;
	 		if($delete_parent == TRUE)
	 		{
	 			if(($student_records != NULL) && !empty($student_records) && ($student_records != FALSE))
	 			{
	 				$cnt = count($student_records);
	 				$i = 0;
	 				foreach ($student_records as $key => $value) {
	 					$delete_child = $this->form_model->delete(array('PMA'=>array('ID'=>$value['ID'])));
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
	 		$rec = $this->fetch_model->show(array('PME'=>array('ID'=>$id)));
	 		$rec = $rec[0];
	 		$rec['date'] = date("Y-m-d H:i A", strtotime($rec['date']));
	 		$students = explode(',', $rec['student_ID']);
	 		foreach ($students as $key => $value) {
	 			$rec['students'][$key]['student'] = $this->str_function_library->call('fr>ST>Name:ID=`'.$value.'`').' '.$this->str_function_library->call('fr>ST>Middle_name:ID=`'.$value.'`').' '.$this->str_function_library->call('fr>ST>Last_name:ID=`'.$value.'`');
	 			$image_ID = $this->str_function_library->call('fr>ST>img_ID:ID=`'.$value.'`');
	 			$rec['students'][$key]['path'] = $this->str_function_library->call('fr>SS>path:ID=`'.$image_ID.'`');
	 		}
	 		$staffs = explode(',', $rec['staff_ID']);
	 		foreach ($staffs as $key1 => $value1) {
	 			$rec['staffs'][$key1]['staff'] = $this->str_function_library->call('fr>US>Name:ID=`'.$value1.'`');
	 			$image_ID = $this->str_function_library->call('fr>US>Image_ID:ID=`'.$value1.'`');
	 			$rec['staffs'][$key1]['path'] = $this->str_function_library->call('fr>SS>path:ID=`'.$image_ID.'`');
	 		}
	 		return $rec;
	 	}

	}
?>