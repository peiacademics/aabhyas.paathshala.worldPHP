<?php
	class Lesson_model extends CI_Model
	{
		public function check($id=NULL,$login_as="Client")
		{
			$user = count($this->fetch_model->show(array('LS' =>array('ID'=>$id))));
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
				$this->errorlog_library->entry('Lesson_model > check > argument ID is invalid.');
				redirect('Lesson/add/');
			}
		}

		public function add_or_edit()
		{
			// $_POST['account_opening_date'] = $this->date_library->date2db($_POST['account_opening_date'],$this->date_library->get_date_format());
			$this->load->model('form_model');
			if(empty($_POST['ID']))
			{
				unset($_POST['ID']);
				$result = $this->form_model->add(array("table"=>"LS","columns"=>$_POST));
			}
			else
			{
				$result = $this->form_model->edit(array("table"=>"LS","columns"=>$_POST,"where"=>array('ID'=>$_POST['ID'])));
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

	}
?>