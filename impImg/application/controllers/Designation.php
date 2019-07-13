<?php

	class Designation extends CI_Controller {

		

		public function __construct()

		{

			parent::__construct();

			if($this->login_model->check_login())

			{

				$this->lang->load('custom',$this->session_library->get_session_data('Language'));

				$this->data['Login']['Login_as'] = $this->session_library->get_session_data('Login_as');

				$this->data['Login']['ID'] = $this->session_library->get_session_data('ID');

				$this->data['Login']['Name'] = $this->session_library->get_session_data('Name');

				$this->data['Login']['Email'] = $this->session_library->get_session_data('Email');

				$this->load->model('salary_model');

				$this->data['my_config'] = $this->my_config = $this->config->item('skyq');

                $this->data['menu'] = $this->setting_model->get_menus($this->data,$this->my_config);

			}

			else 

			{

				redirect($this->config->item('skyq')['default_login_page']);

			}

	 	}



		public function index()

		{

			$this->data['breadcrumb']['heading'] = 'Salary';  

			$this->data['breadcrumb']['route'] = array(array('title'=>'Settings','path'=>'settings'),'Designation');  

			$this->load->view('includes/header',$this->data);

			$this->load->view('pages/salary_view',$this->data);

			$this->load->view('includes/footer',$this->data);

		}



		public function get_show_data($item_id = NULL)

	 	{

	 		$res = $this->salary_model->get_show_data('DS',array('post','description','ID'));

			echo json_encode($res);

	 	}



 	public function add($id=NULL)

 	{

 		$this->data['breadcrumb']['heading'] = 'Add Designation';  

		$this->data['breadcrumb']['route'] = array(array('title'=>'Settings','path'=>'settings'),array('title'=>'Designation','path'=>'designation'),'Add');

		$check = $this->salary_model->check($id,$this->data['Login']['Login_as']);

		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');

        if(IS_AJAX)

		{

			$res=$this->salary_model->add_or_edit();

			if ($res===true) {

				echo 1;

			}

			else

			{

				echo json_encode($res);

			}

		}

		else

		{

			if($check)

			{

				if(!is_null($id))

				{

					$this->data['breadcrumb']['heading'] = 'Edit Designation';  

					$this->data['breadcrumb']['route'] = array(array('title'=>'settings','path'=>'settings'),array('title'=>'Designation','path'=>'designation'),'Edit');

					$this->data['What'] = 'Edit';

					$item = $this->fetch_model->show(array('DS'=>array('ID'=>$id))); 

					$this->data['View'] = $item[0];

					$perticular = $this->fetch_model->show(array('DSP'=>array('designation_ID'=>$id)));

					$this->data['List'] = $perticular;

				}

				

				$this->load->view('includes/header',$this->data);

				$this->load->view('pages/salary_add_edit_view',$this->data);

				$this->load->view('includes/footer',$this->data);			

			}

			else

			{

		 		return FALSE;

			}

		}

 	}





 	public function delete($item_id=NULL)

 	{

 		$this->load->model('form_model');

 		$delete_data = $this->form_model->delete(array('DS' => array('ID' => $item_id)));

 		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');

		if($delete_data)

 		{

		    if(IS_AJAX)

			{

				echo json_encode($delete_data);	

			}

			else

			{

	 			redirect('Designation');

	 		}

		}

 	}



 	public function removePerticular($id)

 	{

 		$this->load->model('form_model');

 		$delete_data = $this->form_model->delete(array('DSP' => array('ID' => $id)));

 		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');

		if($delete_data)

 		{

		    if(IS_AJAX)

			{

				echo json_encode($delete_data);	

			}

			else

			{

	 			redirect('Designation');

	 		}

		}

 	}



 	public function view($id)

 	{

 		$data=$this->fetch_model->show(array('DSP'=>array('designation_ID'=>$id)));

 		echo json_encode($data);

 	}



 	public function showDetails($id)

 	{

 		$data['designation']=$this->fetch_model->show(array('DS'=>array('ID'=>$id)));

 		$data['perticular']=$this->fetch_model->show(array('DSP'=>array('designation_ID'=>$id,'amountType'=>'E')));

 		$data['deduction']=$this->fetch_model->show(array('DSP'=>array('designation_ID'=>$id,'amountType'=>'D')));

 		foreach ($data['perticular'] as $key => $value) {

 			if (in_array('Dynamic', $value)) {

 				$data['Dynamic']='Yes';

 				break;

 			}

 			else

 			{

 				$data['Dynamic']='No';

 			}

 		}

 		echo json_encode($data);

 	}

 }

?>