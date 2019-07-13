<?php

class Projects extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if($this->login_model->check_login())
		{
			$this->data['Login']['Name'] = $this->session_library->get_session_data('Name');
			$this->data['Login']['Login_as'] = $this->session_library->get_session_data('Login_as');
			$this->data['Login']['ID'] = $this->session_library->get_session_data('ID');
			$this->data['Date_format'] = $this->date_library->get_date_format();
			$this->data['my_config'] = $this->my_config = $this->config->item('skyq');
            $this->data['menu'] = $this->setting_model->get_menus($this->data,$this->my_config);
			$this->load->model('project_model');
		}
		else 
		{
			redirect($this->config->item('skyq')['default_login_page']);
		}
 	}
	
	function index()
	{
		$this->load->view('includes/header',$this->data);
		$this->load->view('others/projects_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	function add($id=NULL)
	{
		$check = $this->project_model->check($id,$this->data['Login']['Login_as']);
		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
        if(IS_AJAX)
		{
			$this->project_model->add_or_edit();
		}
		else
		{
			if($check)
			{
				if(!is_null($id))
				{
					$this->data['What'] = 'Edit';
					$item = $this->fetch_model->show(array('P'=>array('ID'=>$id))); 
					$this->data['View'] = $item[0];
				}
				$this->data['Country'] = $this->fetch_model->show("CO",array('ID','title'));
				$this->data['Clients'] = $this->fetch_model->show(array('US'=>array('Type'=>'Client')));
				$this->data['teamMembers'] = $this->fetch_model->show(array('US'=>array('Type'=>'Team Member')));
				$this->data['breadcrumb']['heading'] = 'Add Project';  
				$this->data['breadcrumb']['route'] = array(array('title'=>'Project','path'=>'Projects'),'Add');
				$this->load->view('includes/header',$this->data);
				$this->load->view('others/project_add_edit_view',$this->data);
				$this->load->view('includes/footer',$this->data);			
			}
			else
			{
	 			return FALSE;
			}
		}
	}
	
	public function get_show_data()
 	{
 		$res = $this->project_model->get_show_data();
		echo json_encode($res);
 	}

 	public function view($item_id = NULL)
 	{
		header('Content-Type:application/x-json; charset=utf-8');
 		$res = $this->fetch_model->show(array('P'=>array('ID'=>$item_id)),array('Client_name','Address','Company_name','Contact_no','Contact_no1','Email','>>Country:>fr>CO>title:ID=^Country_ID^','ID'));
		echo json_encode($res[0]);
 	}

	public function delete($item_id=NULL)
 	{
 		$this->load->model('form_model');
 		$delete_data = $this->form_model->delete(array('P' => array('ID' => $item_id)));
 		if($delete_data)
 		{

 			redirect('clients/');
 		}
 	}
}	
?>