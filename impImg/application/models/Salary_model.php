<?php

	class Salary_model extends CI_Model

	{

		public function check($id=NULL,$login_as="Client")

		{

			$user = count($this->fetch_model->show(array('DS' =>array('ID'=>$id))));

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

				$this->errorlog_library->entry('Payment_mode_model > check > argument id is invalid.');

				redirect('Salary_model/add/');

			}

		}



		public function add_or_edit()

		{

			$this->load->model('form_model');
			if(empty($_POST['ID']))

			{

				unset($_POST['ID']);

				$result = $this->form_model->add(array("table"=>"DS","columns"=>$_POST));

				if ($result) {



					// foreach ($bt_arr as $key => $value) {

					// 	$value['designation_ID'] = $this->db_library->find_max_id('DS');

					// 	$addPerticular=$this->form_model->add(array("table"=>"DSP","columns"=>$value));

					// }

					// if ($addPerticular) {

						return true;

					// }

					// else

					// {

					// 	return $addPerticular;

					// }

				}

				else

				{

					return false;

				}

				

			}

			else

			{

				$result = $this->form_model->edit(array("table"=>"DS","columns"=>$_POST,"where"=>array('ID'=>$_POST['ID'])));

				if ($result) {



					// foreach ($bt_arr as $key => $value) {

					// 	if (!array_key_exists('ID', $value)) {

					// 		$value['designation_ID'] = $_POST['ID'];

					// 		$addPerticular=$this->form_model->add(array("table"=>"DSP","columns"=>$value));

					// 	}

					// 	else

					// 	{

					// 		$addPerticular=$this->form_model->edit(array("table"=>"DSP","columns"=>$value,"where"=>array('ID'=>$value['ID'])));

					// 	}

						

					// }

					// if ($addPerticular) {

						return true;

					// }

					// else

					// {

					// 	return $addPerticular;

					// }

				}

				else

				{

					return false;

				}

			}

		}



		public function get_show_data($input,$output)

		{

		 	$this->load->library('datatable_library');

	 		$PT = $this->datatable_library->get_data($input,$output);

	 		$var = $this->config->item('skyq');

	 		foreach ($PT['data'] as $key => $value)

	 		{

	 			$pos1 = strpos($value[2], $var['payment_mode_cash']);

	 			if($pos1 == TRUE)

	 			{

	 				$PT['data'][$key][2]="";

	 			}

	 		}

	 		return $PT;

		}

	}

?>