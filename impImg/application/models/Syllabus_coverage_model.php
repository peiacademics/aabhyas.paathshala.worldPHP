<?php
	class Syllabus_coverage_model extends CI_Model
	{
		public function check($id=NULL,$login_as="Client")
		{
			$user = count($this->fetch_model->show(array('SYC' =>array('ID'=>$id))));
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
				$this->errorlog_library->entry('Syllabus_coverage_model > check > argument ID is invalid.');
				redirect('Syllabus_coverage/add/');
			}
		}

		public function add_or_edit()
		{
			$this->load->model('form_model');
			$students = $_POST['student_ID'];
			$_POST['date'] = date("Y-m-d H:i:s", strtotime($_POST['date']));
			if(empty($_POST['ID']))
			{
				unset($_POST['ID']);
				$result = $this->form_model->add(array("table"=>"SYC","columns"=>$_POST));
			}
			else
			{
				$result = $this->form_model->edit(array("table"=>"SYC","columns"=>$_POST,"where"=>array('ID'=>$_POST['ID'])));
			}				
			if($result === TRUE)
			{
				echo 1;
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
			$studs = $this->fetch_model->show(array('SYC'=>array('ID'=>$id)),array('student_ID','subject_ID'));
			$student_sc = $this->fetch_model->show(array('SCR'=>array('syllabus_coverage_ID'=>$id)));
	 		$students = explode(',', $studs[0]['student_ID']);
			foreach ($students as $key_at => $value_at) {
				if(($student_sc != NULL) && !empty($student_sc) && ($student_sc != FALSE))
				{
					foreach ($student_sc as $key1 => $value1) {
						if(in_array($value_at, $value1))
						{
							$res['present'][$key_at]['name'] = $this->str_function_library->call('fr>ST>Name:ID=`'.$value_at.'`').' '.$this->str_function_library->call('fr>ST>Middle_name:ID=`'.$value_at.'`').' '.$this->str_function_library->call('fr>ST>Last_name:ID=`'.$value_at.'`');
							$img = $this->str_function_library->call('fr>ST>img_ID:ID=`'.$value_at.'`');
							$res['present'][$key_at]['path'] = $this->str_function_library->call('fr>SS>path:ID=`'.$img.'`');
							$res['present'][$key_at]['ID'] = $value_at;
						}
						else
						{
							$res['absent'][$key_at]['name'] = $this->str_function_library->call('fr>ST>Name:ID=`'.$value_at.'`').' '.$this->str_function_library->call('fr>ST>Middle_name:ID=`'.$value_at.'`').' '.$this->str_function_library->call('fr>ST>Last_name:ID=`'.$value_at.'`');
							$img = $this->str_function_library->call('fr>ST>img_ID:ID=`'.$value_at.'`');
							$res['absent'][$key_at]['path'] = $this->str_function_library->call('fr>SS>path:ID=`'.$img.'`');
							$res['absent'][$key_at]['ID'] = $value_at;
						}
					}
				}
				else
				{
					$res['absent'][$key_at]['name'] = $this->str_function_library->call('fr>ST>Name:ID=`'.$value_at.'`').' '.$this->str_function_library->call('fr>ST>Middle_name:ID=`'.$value_at.'`').' '.$this->str_function_library->call('fr>ST>Last_name:ID=`'.$value_at.'`');
					$img = $this->str_function_library->call('fr>ST>img_ID:ID=`'.$value_at.'`');
					$res['absent'][$key_at]['path'] = $this->str_function_library->call('fr>SS>path:ID=`'.$img.'`');
					$res['absent'][$key_at]['ID'] = $value_at;
					$res['present'] = NULL;
				}
				$res['subject'] = $this->str_function_library->call('fr>SB>name:ID=`'.$studs[0]['subject_ID'].'`');
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
	 		$student_records = $this->fetch_model->show(array('SSC'=>array('syllabus_coverage_ID'=>$item_ID)));
	 		$delete_parent = $this->form_model->delete(array('SYC'=>array('ID'=>$item_ID)));
	 		if($delete_parent == TRUE)
	 		{
	 			if(($student_records != NULL) && !empty($student_records) && ($student_records != FALSE))
	 			{
	 				$cnt = count($student_records);
	 				$i = 0;
	 				foreach ($student_records as $key => $value) {
	 					$delete_child = $this->form_model->delete(array('SSC'=>array('ID'=>$value['ID'])));
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
	 		$rec = $this->fetch_model->show(array('SYC'=>array('ID'=>$id)));
	 		$rec = $rec[0];
	 		$rec['test_date'] = date("Y-m-d H:i A", strtotime($rec['test_date']));
	 		$rec['subject_ID'] = $this->str_function_library->call('fr>SB>name:ID=`'.$rec['subject_ID'].'`');
	 		$students = $this->fetch_model->show(array('SSC'=>array('test_ID'=>$rec['ID'])),array('student_ID'));
	 		foreach ($students as $key => $value) {
	 			$rec['students'][$key]['student'] = $this->str_function_library->call('fr>ST>Name:ID=`'.$value['student_ID'].'`').' '.$this->str_function_library->call('fr>ST>Middle_name:ID=`'.$value['student_ID'].'`').' '.$this->str_function_library->call('fr>ST>Last_name:ID=`'.$value['student_ID'].'`');
	 			$image_ID = $this->str_function_library->call('fr>ST>img_ID:ID=`'.$value['student_ID'].'`');
	 			$rec['students'][$key]['path'] = $this->str_function_library->call('fr>SS>path:ID=`'.$image_ID.'`');
	 		}
	 		return $rec;
	 	}

	 	public function student_syllabus()
	 	{
	 		$res['cols'] = $this->fetch_model->show(array('SYC'=>array('subject_ID'=>$_POST['subject_ID'],'student_ID LIKE'=>'%'.$_POST['student_ID'].'%')));
	 		foreach ($res['cols'] as $key => $value) {
	 			if(($value['proff_ID'] != NULL) && !empty($value['proff_ID']) && ($value['proff_ID'] != FALSE))
	 			{
		 			if(strpos($value['proff_ID'], ',') != FALSE)
		 			{
		 				$proff = explode(',', $value['proff_ID']);
		 				$proffs = '';
		 				foreach ($proff as $keyp => $valuep) {
		 					$proffs .= $this->str_function_library->call('fr>US>Name:ID=`'.$valuep.'`').',';
		 				}
		 				$res['cols'][$key]['proff_ID'] = rtrim($proffs, ',');
		 			}
		 			else
		 			{
		 				$res['cols'][$key]['proff_ID'] = $this->str_function_library->call('fr>US>Name:ID=`'.$value['proff_ID'].'`');
		 			}
		 			$res['cols'][$key]['self_study'] = $this->fetch_model->show(array('SSC'=>array('subject_ID'=>$_POST['subject_ID'],'student_ID LIKE'=>'%'.$_POST['student_ID'].'%')));
		 			if(($res['cols'][$key]['self_study'] != NULL) && !empty($res['cols'][$key]['self_study']) && ($res['cols'][$key]['self_study'] != FALSE))
		 			{
			 			foreach ($res['cols'][$key]['self_study'] as $keyssc => $valuessc) {
			 				$res['cols'][$key]['self_study'][$keyssc]['remarks'] = $this->fetch_model->show(array('SCR'=>array('syllabus_coverage_ID'=>$value['ID'],'student_syllabus_ID'=>$valuessc['ID'])));
			 			}
			 		}
		 		}
		 		else
		 		{
		 			$res['cols'][$key]['proff_ID'] = '';
		 		}
	 		}
	 		return $res;
	 	}

	 	public function add_remark()
	 	{
	 		$this->load->model('form_model');
	 		$recs = array();
	 		$add_results = array();
	 		foreach($_POST as $key => $value)
			{
				if(strpos($key, '_ID=') != FALSE)
				{
					$remark_name = explode('_ID=', $key);
					$remark_ID = explode('-', $remark_name[1]);
					if($value != NULL)
					{
						$add_results[] = $this->form_model->add(array("table"=>"SCR","columns"=>array('remark'=>$value." (".date('d M Y h:i A')."). ",'subject_ID'=>$_POST['subject_ID'],'student_ID'=>$_POST['student_ID'],'syllabus_coverage_ID'=>$remark_ID[0],'student_syllabus_ID'=>$remark_ID[1])));
					}
				}
				else
				{
					if(strpos($key, '-') != FALSE)
		 			{
			 			$first_digit = explode('-', $key);
			 			if(strpos($first_digit[0], '=') != FALSE)
			 			{
			 				$row_digit = explode('=', $first_digit[0]);
			 				$recs[$first_digit[1]][$row_digit[1]] = $value;
			 			}
			 			else
			 			{
			 				$recs[$first_digit[1]][0] = $value;
			 			}
		 			}
		 		}
		 	}
		 	if(($recs != NULL) && !empty($recs) && ($recs != FALSE))
		 	{
			 	foreach ($recs as $keyr => $valuer) {
			 		$cnt = count($valuer);
			 		$i = 0;
			 		foreach ($valuer as $key1 => $value1) {
			 			if($key1 == '0')
			 			{
			 				$column = $this->form_model->add(array("table"=>"SSC","columns"=>array('self_study'=>$valuer[0],'subject_ID'=>$_POST['subject_ID'],'student_ID'=>$_POST['student_ID'])));
			 				if($column == TRUE)
			 				{
			 					$max_ssc = $this->db_library->find_max_id('SSC');
			 					$i++;
			 				}
			 			}
			 			else
			 			{
			 				if(($value1 != NULL) && !empty($value1) && ($value1 != FALSE))
			 				{
			 					$row = $this->form_model->add(array("table"=>"SCR","columns"=>array('remark'=>$value1." (".date('d M Y h:i A')."). ",'subject_ID'=>$_POST['subject_ID'],'student_ID'=>$_POST['student_ID'],'syllabus_coverage_ID'=>$key1,'student_syllabus_ID'=>$max_ssc)));
			 					if($row == TRUE)
				 				{
				 					$i++;
				 				}
			 				}
			 				else
			 				{
			 					$i++;
			 				}
			 			}
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
			if(($add_results != NULL) && !empty($add_results) && ($add_results != FALSE))
			{
				if(in_array(FALSE, $add_results))
				{
					return FALSE;
				}
				else
				{
					return TRUE;
				}
			}
	 	}

	 	public function change_checked_status()
	 	{
	 		$this->load->model('form_model');
	 		if(($_POST['grade'] == NULL) || !empty($_POST['grade']))
	 		{
	 			$_POST['grade'] = NULL;
	 		}
	 		$status = $this->form_model->edit(array("table"=>"SCR","columns"=>array('checked_status'=>$_POST['status'],'grade'=>$_POST['grade']),"where"=>array('ID'=>$_POST['id'])));
	 		if($status == TRUE)
	 		{
	 			$branch_ID = $this->str_function_library->call('fr>ST>branch_ID:ID=`'.$_POST['student_ID'].'`');
	 			$st_remark = $this->form_model->add(array("table"=>"SR","columns"=>array('title'=>'Student Syllabus updated','remark'=>'Self study has been made '.$_POST['status'].' by Professor.','date'=>date('Y-m-d h:i:s'),'batch_ID'=>'all','student_ID'=>$_POST['student_ID'],'branch_ID'=>$branch_ID)));
	 			if($st_remark == TRUE)
	 			{
	 				$res['bool'] = TRUE;
	 				$res['status'] = $_POST['status'];
	 			}
	 			else
	 			{
	 				$res['bool'] = FALSE;
	 			}
	 		}
	 		else
	 		{
	 			$res['bool'] = FALSE;
	 		}
	 		return $res;
	 	}

	 	public function append_remark()
	 	{
	 		$this->load->model('form_model');
	 		$rem = $this->str_function_library->call('fr>SCR>remark:ID=`'.$_POST['id'].'`');
	 		$res = $this->form_model->edit(array("table"=>"SCR","columns"=>array('remark'=>$rem.'<br>'.$_POST['remark']." (".date('d M Y h:i A')."). "),"where"=>array('ID'=>$_POST['id'])));
	 		return $res;
	 	}
	}
?>