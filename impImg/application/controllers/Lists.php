<?php

	class Lists extends CI_Controller 
	{
		
		public function __construct()
		{ 
			parent::__construct();
			if($this->login_model->check_login())
			{
				$this->lang->load('custom',$this->session_library->get_session_data('Language'));
				$this->data['Login']['Login_as'] = $this->session_library->get_session_data('Login_as');
				$this->data['Login']['Added_by'] = $this->session_library->get_session_data('Added_by');
				$this->data['Login']['Name'] = $this->session_library->get_session_data('Name');
				$this->data['Login']['Email'] = $this->session_library->get_session_data('Email');
				$this->data['Login']['branch_ID'] = $this->session_library->get_session_data('branch_ID');
				$this->data['Login']['ID'] = $this->session_library->get_session_data('ID');
				$this->load->model('list_model');
				$this->load->model('customer_model');
				$this->data['my_config'] = $this->my_config = $this->config->item('skyq');
                $this->data['menu'] = $this->setting_model->get_menus($this->data,$this->my_config);
			}
			else 
			{
				redirect($this->config->item('skyq')['default_login_page']);
			}
	 	}

		function index($id = NULL)
		{
			$this->data['breadcrumb']['heading'] = 'Calling Lists';  
			$this->data['breadcrumb']['route'] = array(array('title'=>'Calling Lists','path'=>'lists/index/'.$id),'Show');
			$this->data['lists'] = $this->customer_model->lists($id);
			$this->data['branch_ID'] = $id;
			$this->load->view('includes/header',$this->data);
			$this->load->view('pages/customer_view',$this->data);
			$this->load->view('includes/footer',$this->data);
		}

		public function import($branch_ID = NULL)
		{
			$d_id = 'DSSK10000007';
			$this->data['employee'] = $this->fetch_model->show(array("US"=>array("Type"=>$d_id)));
			$this->data['breadcrumb']['heading'] = 'Calling Lists';  
			$this->data['breadcrumb']['route'] = array(array('title'=>'Calling Lists','path'=>'Customer'),'Import');
			$this->data['branch_ID'] = $branch_ID;
			$this->load->view('includes/header',$this->data);
			$this->load->view('pages/calling_import_view',$this->data);
			$this->load->view('includes/footer',$this->data);
		}

		public function importDatabase1($branch_ID = NULL)
		{
			$data = $this->customer_model->importDatabase1($branch_ID);
			if ($data === true)
			{
				echo json_encode(true);
			}
			else
			{
				echo json_encode($data);
			}
		}

		function add($branch_ID = NULL,$id = NULL)
		{
			$this->data['breadcrumb']['heading'] = 'Add Calling Lists';
			$this->data['breadcrumb']['route'] = array(array('title'=>'Calling Lists','path'=>'Customer'),'Add');
			$d_id = 'DSSK10000007';
			$this->data['employee'] = $this->fetch_model->show(array("US"=>array("branch_ID"=>$branch_ID)));
			$check = $this->customer_model->check($id,$this->data['Login']['Login_as']);
	 		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
	        if(IS_AJAX)
			{
				if(($res = $this->customer_model->add_or_edit()) === TRUE)
				{
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
						$this->data['breadcrumb']['heading'] = 'Edit Customer';  
						$this->data['breadcrumb']['route'] = array(array('title'=>'Customer','path'=>'Customer'),'Edit');  
						$this->data['DETAIL'] = $this->customer_model->get_details($id);
					}
					$this->data['branch_ID'] = $branch_ID;
					$this->data['listID'] = $this->customer_model->get_bill_number('list_ID');
					$this->load->view('includes/header',$this->data);
					$this->load->view('pages/list_add_edit_view',$this->data);
					$this->load->view('includes/footer',$this->data);
				}
				else
				{
			 		return FALSE;
				}
			}
		}

		public function show($branch_ID = NULL,$id = NULL)
	 	{
	 		$this->data['breadcrumb']['heading'] = 'Service Details';
			$this->data['breadcrumb']['route'] = array(array('title'=>'Services','path'=>'Product'),'View');  
			$this->data['lists'] = $this->list_model->get_details($branch_ID,$id);
			$this->data['branch_ID'] = $branch_ID;
			$this->load->view('includes/header',$this->data);
			$this->load->view('pages/list_view',$this->data);
			$this->load->view('includes/footer',$this->data);
	 	}

	 	public function chnageStatus()
	 	{
			header('Content-Type:application/x-json; charset=utf-8');
	 		$id=$_POST['id'];
	 		$status=$_POST['status'];
	 		$change=$this->list_model->chnageStatus($id,$status);
	 		if ($change)
	 		{
	 			echo json_encode($change);
	 		}
	 		else
	 		{
	 			echo json_encode("Something went Wrong");
	 		}
	 	}

	 	public function updateInfo()
	 	{
	 		$change=$this->list_model->updateInfo();
	 		if ($change)
	 		{
	 			echo json_encode(true);
	 		}
	 		else
	 		{
	 			echo json_encode("Something went Wrong");
	 		}
	 	}

	 	public function getCount($id)
	 	{
	 		$change=$this->list_model->getCount($id);
	 		if ($change)
	 		{
	 			echo json_encode($change);
	 		}
	 		else
	 		{
	 			echo json_encode("Something went Wrong");
	 		}
	 	}

	 	public function getDetails($id)
	 	{
	 		// print_r($id);
			header('Content-Type:application/x-json; charset=utf-8');
	 		$change=$this->list_model->getDetails($id);
	 		if ($change)
	 		{
	 			echo json_encode($change);
	 		}
	 		else
	 		{
	 			echo json_encode("Something went Wrong");
	 		}
	 	}

	 	public function recall()
	 	{
	 		header('Content-Type:application/x-json; charset=utf-8');
	 		$change = $this->list_model->recall();
	 		if ($change)
	 		{
	 			echo json_encode($change);
	 		}
	 		else
	 		{
	 			echo json_encode($change);
	 		}
	 	}

	 	public function call_record()
	 	{
	 		header('Content-Type:application/x-json; charset=utf-8');
	 		$res = $this->list_model->call_record();
	 		if ($res)
	 		{
	 			echo json_encode($res);
	 		}
	 		else
	 		{
	 			echo json_encode($res);
	 		}
	 	}

	 	public function abort_contacts()
	 	{
	 		header('Content-Type:application/x-json; charset=utf-8');
	 		$res = $this->list_model->abort_contacts();
	 		if ($res)
	 		{
	 			echo json_encode($res);
	 		}
	 		else
	 		{
	 			echo json_encode($res);
	 		}
	 	}

	 	public function call_recs($id)
	 	{
	 		// print_r($id);
			header('Content-Type:application/x-json; charset=utf-8');
	 		$recs = $this->list_model->call_recs($id);
	 		if ($recs)
	 		{
	 			echo json_encode($recs);
	 		}
	 		else
	 		{
	 			echo json_encode("Something went Wrong");
	 		}
	 	}

	 	public function get_recalls($id)
	 	{
			header('Content-Type:application/x-json; charset=utf-8');
	 		$recs = $this->fetch_model->show(array('R'=>array('contactID'=>$id)));
	 		echo json_encode($recs);
	 	}

	 	public function get_abort_reasons()
	 	{
			header('Content-Type:application/x-json; charset=utf-8');
	 		$recs = $this->fetch_model->show('AR');
	 		echo json_encode($recs);
	 	}

	 	public function get_sms_list($id)
	 	{
	 		// header('Content-Type:application/x-json; charset=utf-8');
	 		$recs = $this->list_model->get_sms_list($id);
 			echo json_encode($recs);
	 	}

	 	public function save_sms()
	 	{
	 		$recs = $this->list_model->save_sms();
 			echo json_encode($recs);
	 	}
}
?>