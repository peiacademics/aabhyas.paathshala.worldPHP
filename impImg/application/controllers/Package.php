<?php

class Package extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if($this->login_model->check_login())
		{
			$this->data['Login']['Name'] = $this->session_library->get_session_data('Name');
			$this->data['Login']['Login_as'] = $this->session_library->get_session_data('Login_as');
			$this->data['Login']['ID'] = $this->session_library->get_session_data('ID');
			$this->data['Login']['branch_ID'] = $this->session_library->get_session_data('branch_ID');
			$this->data['Date_format'] = $this->date_library->get_date_format();
			$this->load->model('package_model');
			$this->data['my_config'] = $this->my_config = $this->config->item('skyq');
            $this->data['menu'] = $this->setting_model->get_menus($this->data,$this->my_config);
		}
		else
		{
			redirect($this->config->item('skyq')['default_login_page']);
		}
 	}
	
	function index()
	{
		$this->data['breadcrumb']['heading'] = 'Package';  
		$this->data['breadcrumb']['route'] = array(array('title'=>'Package','path'=>'Package'),'Show');
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/abhyas_package_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	public function add()
	{
		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
	    if(IS_AJAX)
		{
			echo json_encode($this->package_model->add());
		}
		else{
			$this->data['breadcrumb']['heading'] = 'Package';  
			$this->data['breadcrumb']['route'] = array(array('title'=>'Package','path'=>'Package'),'Add');
			$this->load->view('includes/header',$this->data);
			$this->load->view('pages/abhyas_package_add_view',$this->data);
			$this->load->view('includes/footer',$this->data);
		}
	}

	public function get_show_data()
 	{
 		$res = $this->package_model->get_show_data('APG',array('name','price','ID'));
		echo json_encode($res);
 	}

 	public function delete($id)
 	{
 		$res = $this->package_model->delete($id);
		echo json_encode($res);
 	}

 	public function get_abhyas_details()
 	{
 		$res = $this->package_model->get_abhyas_details();
		echo json_encode($res);
 	}

 	public function view($id)
 	{
 		$this->data['breadcrumb']['heading'] = 'Package';  
		$this->data['breadcrumb']['route'] = array(array('title'=>'Package','path'=>'Package'),'View');
 		$this->data['data'] = $this->package_model->get_details($id);
 		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/abhyas_package_detail_view',$this->data);
		$this->load->view('includes/footer',$this->data);
 	}

 	public function get_data()
 	{
 		$res = $this->package_model->get_data();
		echo json_encode($res);
 	}

 	public function addtopackage()
 	{
 		$res = $this->package_model->addtopackage();
		echo json_encode($res);
 	}

 	public function set_date()
 	{
 		$res = $this->package_model->set_date();
		echo json_encode($res);
 	}

 	public function remove_data()
 	{
 		$res = $this->package_model->remove_data();
		echo json_encode($res);
 	}

 	public function update_data()
 	{
 		$res = $this->package_model->update_data();
		echo json_encode($res);
 	}
}	
?>