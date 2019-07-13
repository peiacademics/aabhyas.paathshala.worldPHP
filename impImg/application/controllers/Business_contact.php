<?php
class Business_contact extends CI_Controller
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
			$this->load->model('business_contact_model');
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
		$this->data['breadcrumb']['heading'] = 'Business Contacts';  
		$this->data['breadcrumb']['route'] = array(array('title'=>'Business Contacts','path'=>'Business_contact'),'Show');  
		$this->data['Branch']=$this->fetch_model->show('BR');
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/business_contact_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	function view()
	{
		$this->data['breadcrumb']['heading'] = 'Business Contact';  
		$this->data['breadcrumb']['route'] = array("Business Contact");
		// $this->data['Branch']=$this->fetch_model->show('BR');
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/awards_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	public function add($id=NULL,$br_id=NULL)
	{
		$this->data['breadcrumb']['heading'] = 'Add Business Contact';
		$this->data['breadcrumb']['route'] = array(array('title'=>'Business Contact','path'=>'Business_contact'),'Add');
		$check = $this->business_contact_model->check($id,$this->data['Login']['Login_as']);
		if($check)
		{
	 		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
	        if(IS_AJAX)
			{
				if (($res = $this->business_contact_model->add_or_edit()) === TRUE) {
					echo 1;
				}
				else
				{
					echo json_encode($res);
				}
			}
			else
			{
				if (!empty($id))
				{
					$this->data['breadcrumb']['heading'] = 'Edit Business Contact';
					$this->data['breadcrumb']['route'] = array(array('title'=>'Business Contact','path'=>'Business_contact'),'Edit');
					$this->data['id']=$id;
					$this->data['DETAIL']=$this->business_contact_model->get_details($id);
				}
				$this->load->view('includes/header',$this->data);
				$this->load->view('pages/business_contact_add_edit_view',$this->data);
				$this->load->view('includes/footer',$this->data);		
			}
		}
		else
		{
	 		return FALSE;
		}
	}

	public function transfer($id = NULL, $branch_ID = NULL)
	{
		$this->data['breadcrumb']['heading'] = 'Business Contacts';  
		$this->data['breadcrumb']['route'] = array(array('title'=>'Business Contacts','path'=>'Business_contact/transfer/'.$id),'Show');
		$this->data['DETAIL'] = $this->business_contact_model->get_data($id);
		$this->data['id'] = $id;
		if($branch_ID != NULL)
		{
			$this->data['team'] = $this->fetch_model->show(array('US'=>array('Type !='=>'DSSK10000001','branch_ID'=>$branch_ID)));
		}
		else
		{
			$this->data['team'] = $this->fetch_model->show(array('US'=>array('Type !='=>'DSSK10000001')));
		}
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/business_contact_list_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	public function get_contact($id)
	{
		echo json_encode($this->business_contact_model->get_contact($id));
	}

	public function delete_Field($id)
	{
		echo json_encode($this->business_contact_model->delete_Field($id));
	}

	public function delete($item_id=NULL)
 	{
 		// $branch = $this->fetch_model->show(array('BNC'=>array('ID'=>$item_id,'Status'=>'D')));
 		// $branch_id = $branch[0]['branch_ID'];
 		$this->load->model('form_model');
 		$delete_data = $this->form_model->delete(array('BNC' => array('ID' => $item_id)));
 		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
		if($delete_data)
 		{
		    if(IS_AJAX)
			{
				echo json_encode($delete_data);	
			}
			else
			{
				// $this->transfer($branch_ID);
	 			redirect('Business_contact');
	 		}
		}
 	}
}	

?>