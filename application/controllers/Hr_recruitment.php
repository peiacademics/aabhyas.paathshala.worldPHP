<?php
class Hr_recruitment extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if($this->login_model->check_login())
		{
			$this->lang->load('custom',$this->session_library->get_session_data('Language'));
			$this->data['Login']['Login_as'] = $this->session_library->get_session_data('Login_as');
			$this->data['Login']['Name'] = $this->session_library->get_session_data('Name');
			$this->data['Login']['Email'] = $this->session_library->get_session_data('Email');
			$this->data['Login']['ID'] = $this->session_library->get_session_data('ID');
			$this->data['Date_format'] = $this->date_library->get_date_format();
			$this->load->model('hr_recruitment_model');
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
		$this->data['breadcrumb']['heading'] = 'HR Recruitement';  
		$this->data['breadcrumb']['route'] = array(array('title'=>'HR Recruitement','path'=>'Hr_recruitment'),'Show All Resumes');
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/resume_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	function view()
	{
		$this->data['breadcrumb']['heading'] = 'HR Recruitement';
		$this->data['breadcrumb']['route'] = array(array('title'=>'HR Recruitement','path'=>'Hr_recruitment'),'Show All Resumes');
		$this->data['filter'] = $this->hr_recruitment_model->get_filter_data();
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/resume_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	public function get_show_data($item_id = NULL)
	{
		$res = $this->hr_recruitment_model->get_show_data('HR',array('name','qualification','dept_ID','area','city','phone','email','ID'));
		foreach ($res['data'] as $key => $value) {
			$res['data'][$key][5] = rtrim($value[5], ',');
			$res['data'][$key][6] = rtrim($value[6], ',');
			if(strpos($value[2], ','))
			{
				$depts = explode(',', $value[2]);
				$dept = '';
				foreach ($depts as $keyd => $valued) {
					$dept .= $this->str_function_library->call('fr>TT>title:ID=`'.$valued.'`').',';
				}
				$res['data'][$key][2] = rtrim($dept, ',');
			}
			else
			{
				$res['data'][$key][2] = $this->str_function_library->call('fr>TT>title:ID=`'.$value[2].'`');
			}
		}
		echo json_encode($res);
 	}

 	public function add($id=NULL)
 	{
 		$this->data['breadcrumb']['heading'] = 'Add Resume';
		$this->data['breadcrumb']['route'] = array(array('title'=>'Dashboard','path'=>'dashboard'),array('title'=>'HR Recruitements','path'=>'Hr_recruitment'),'Add');
		$check = $this->hr_recruitment_model->check($id,$this->data['Login']['Login_as']);
		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
        if(IS_AJAX)
		{
			$this->hr_recruitment_model->add_or_edit();
		}
		else
		{
			if($check)
			{
				if(!is_null($id))
				{
					$this->data['breadcrumb']['heading'] = 'Edit HR Recruitements';  
					$this->data['breadcrumb']['route'] = array(array('title'=>'Dashboard','path'=>'dashboard'),array('title'=>'HR Recruitements','path'=>'Hr_recruitment'),'Edit');  
					$this->data['What'] = 'Edit';
					$item = $this->fetch_model->show(array('HR'=>array('ID'=>$id))); 
					$this->data['View'] = $item[0];
					$this->data['View']['path'] = $this->str_function_library->call('fr>SS>path:ID=`'.$item[0]['resume_ID'].'`');
				}
				$this->load->view('includes/header',$this->data);
				$this->load->view('pages/resume_add_edit_view',$this->data);
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
 		$delete_data = $this->form_model->delete(array('HR' => array('ID' => $item_id)));
 		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
		if($delete_data)
 		{
		    if(IS_AJAX)
			{
				echo json_encode($delete_data);	
			}
			else
			{
	 			redirect('hr_recruitement');
	 		}
		}
 	}

 	public function delete_Field()
	{
		echo json_encode($this->hr_recruitment_model->delete_Field());
	}

	function get_filtered_resumes()
	{
		$res = $this->hr_recruitment_model->get_filtered_resumes();
		echo json_encode($res);
	}

	public function send_message()
	{
		echo json_encode($this->hr_recruitment_model->send_message());
	}

}	

?>