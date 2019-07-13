<?php

class Customer extends CI_Controller
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
			$this->load->model('customer_model');
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
		$this->show();
		// $this->data['breadcrumb']['heading'] = 'Customer';  
		// $this->data['breadcrumb']['route'] = array(array('title'=>'Customer','path'=>'Customer'),'Show');
		// $this->data['lists']=$this->customer_model->lists();
		// $this->load->view('includes/header',$this->data);
		// $this->load->view('pages/Customer_view',$this->data);
		// $this->load->view('includes/footer',$this->data);
	}

	public function show($value='')
	{
		$this->data['breadcrumb']['heading'] = 'Customer';  
		$this->data['breadcrumb']['route'] = array(array('title'=>'Customer','path'=>'Customer'),'Show');
		$this->data['lists'] = $this->customer_model->get_details();
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/cust_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	public function get_show_data2()
 	{
 		$res = $this->customer_model->get_show_data2();
		echo json_encode($res);
 	}

}	
?>