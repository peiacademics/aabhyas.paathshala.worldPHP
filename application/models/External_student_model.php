<?php
	class External_student_model extends CI_Model
	{
		public function check($id=NULL,$login_as="Client")
		{
			$user = count($this->fetch_model->show(array('XS' =>array('ID'=>$id))));
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
				$this->errorlog_library->entry('External_student_model > check > argument ID is invalid.');
				redirect('external_student/add/');
			}
		}

		public function add_or_edit()
		{
			$this->load->model('form_model');
			$date = str_replace('|', '-', $_POST['DOB']);
			$_POST['DOB'] = date('Y-m-d', strtotime($date));
			if(empty($_POST['ID']))
			{
				unset($_POST['ID']);
				$result = $this->form_model->add(array("table"=>"XS","columns"=>$_POST));
			}
			else
			{
				$result = $this->form_model->edit(array("table"=>"XS","columns"=>$_POST,"where"=>array('ID'=>$_POST['ID'])));
			}				
			echo json_encode($result);
		}

		public function get_show_data($input,$output)
		{
		 	$this->load->library('datatable_library');
	 		return $this->datatable_library->get_data($input,$output);
		}

	}
?>