<?php
	class Counseling_session_model extends CI_Model
	{
		public function check($id = NULL, $login_as = "Client")
		{
			$user = count($this->fetch_model->show(array('SC' =>array('ID'=>$id))));
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
				$this->errorlog_library->entry('Counseling_session_model > check > argument ID is invalid.');
				redirect('Counseling_session/add/');
			}
		}

		public function add_or_edit()
		{
			$this->load->model('form_model');
			$_POST['date'] = date("Y-m-d H:i:s", strtotime($_POST['date']));
			if(empty($_POST['ID']))
			{
				unset($_POST['ID']);
				$result = $this->form_model->add(array("table"=>"SC","columns"=>$_POST));
			}
			else
			{
				$result = $this->form_model->edit(array("table"=>"SC","columns"=>$_POST,"where"=>array('ID'=>$_POST['ID'])));
			}				
			if($result === TRUE)
			{
				$res['id'] = $this->db_library->find_max_id('SC');
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
	 		if($_POST['batch_ID'][0] == 'all')
	 		{
	 			$data = $this->fetch_model->show(array('ST'=>array('branch_ID'=>$_POST['branch_ID'])));	
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
		 					$data[] = $value;
		 				}
		 			}
		 		}
	 		}
	 		return $data;
	 	}

	 	public function counseling_attendace($id = NULL)
	 	{
			$res = $this->fetch_model->show(array('SC'=>array('ID'=>$id)));
			foreach ($res as $key_at => $value_at) {
				$res[$key_at]['name'] = $this->str_function_library->call('fr>ST>Name:ID=`'.$value_at['student_ID'].'`').' '.$this->str_function_library->call('fr>ST>Middle_name:ID=`'.$value_at['student_ID'].'`').' '.$this->str_function_library->call('fr>ST>Last_name:ID=`'.$value_at['student_ID'].'`');
			}
	 		return $res[0];
	 	}

	 	public function save_attendance()
	 	{
	 		$this->load->model('form_model');
	 		$id = $_POST['ID'];
	 		unset($_POST['ID']);
	 		$res = $this->form_model->edit(array("table"=>"SC","columns"=>$_POST,"where"=>array('ID'=>$id)));
	 		return $res;
	 	}

	 	public function delete($item_ID = NULL)
	 	{
	 		$this->load->model('form_model');
	 		$delete_parent = $this->form_model->delete(array('SC'=>array('ID'=>$item_ID)));
	 		return $delete_parent;
	 	}

	}
?>