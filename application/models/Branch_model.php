<?php

	class Branch_model extends CI_Model

	{

		public function check($id=NULL,$login_as="Client")

		{

			$user = count($this->fetch_model->show(array('BR' =>array('ID'=>$id))));

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

				$this->errorlog_library->entry('Branch_model > check > argument id is invalid.');

				redirect('Branch/add/');

			}

		}



		public function add_or_edit()

		{

			$this->load->model('form_model');

			if(empty($_POST['ID']))

			{

				unset($_POST['ID']);

				$result = $this->form_model->add(array("table"=>"BR","columns"=>$_POST));

				

			}

			else

			{

				

				$result = $this->form_model->edit(array("table"=>"BR","columns"=>$_POST,"where"=>array('ID'=>$_POST['ID'])));

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



		public function get_show_data($input,$output,$is_object = "No")

		{
			$this->load->library('datatable_library');
	 		return $this->datatable_library->get_data($input,$output,$is_object);

		 	// $this->load->library('datatable_library');

	 		// $ec = $this->datatable_library->get_data($input,$output);

	 		// $var = $this->config->item('skyq');

	 		// foreach ($ec['data'] as $key => $value)

	 		// {

	 		// 	$pos1 = strpos($value[2], $var['Vendor_Debit']);

	 		// 	$pos2 = strpos($value[2], $var['Customer_Credit']);

	 		// 	if($pos1 == TRUE || $pos2 == TRUE)

	 		// 	{

	 		// 		$ec['data'][$key][2]="";

	 		// 	}

	 		// }

	 		// return $ec;

		}

	}

?>