<?php
	class Message_type_model extends CI_Model
	{
		public function check($id = NULL,$login_as = "Client")
		{
			$user = count($this->fetch_model->show(array('MT' =>array('ID'=>$id))));
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
				$this->errorlog_library->entry('Message_type_model > check > argument ID is invalid.');
				redirect('Message_type/add/');
			}
		}

		public function add_or_edit()
		{
			$this->load->model('form_model');
			if(empty($_POST['ID']))
			{
				unset($_POST['ID']);
				$result = $this->form_model->add(array("table"=>"MT","columns"=>$_POST));
			}
			else
			{
				$result = $this->form_model->edit(array("table"=>"MT","columns"=>$_POST,"where"=>array('ID'=>$_POST['ID'])));
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