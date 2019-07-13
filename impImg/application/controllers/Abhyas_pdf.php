<?php
	class Abhyas_pdf extends CI_Controller {
		
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
			$this->load->model('abhyas_pdf_model');
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
		$this->data['breadcrumb']['heading'] = 'Abhyas PDFs';  
		$this->data['breadcrumb']['route'] = array(array('title'=>'Aabhyas','path'=>'Abhyas_pdf'),'Abhyas PDFs');  
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/abhyas_pdf_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	public function get_show_data($item_id = NULL)
	{
		$res = $this->abhyas_pdf_model->get_show_data('AP',array('name','description','>>Subject:>fr>SB>name:ID=^subject_ID^','>>Lesson:>fr>LS>name:ID=^lesson_ID^','>>Topic:>fr>TP>name:ID=^topic_ID^','ID'));
		echo json_encode($res);
 	}

 	public function add($id = NULL)
 	{
 		$this->data['breadcrumb']['heading'] = 'Add Abhyas PDF';
		$this->data['breadcrumb']['route'] = array(array('title'=>'Aabhyas','path'=>'Abhyas_pdf'),array('title'=>'Abhyas PDF','path'=>'Abhyas_pdf'),'Add');
		$check = $this->abhyas_pdf_model->check($id,$this->data['Login']['Login_as']);
		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
        if(IS_AJAX)
		{
			$this->abhyas_pdf_model->add_or_edit();
		}
		else
		{
			if($check)
			{
				if(!is_null($id))
				{
					$this->data['breadcrumb']['heading'] = 'Edit Abhyas PDF';  
					$this->data['breadcrumb']['route'] = array(array('title'=>'Aabhyas','path'=>'Abhyas_pdf'),array('title'=>'Abhyas PDF','path'=>'Abhyas_pdf'),'Edit');  
					$this->data['What'] = 'Edit';
					$item = $this->fetch_model->show(array('AP'=>array('ID'=>$id))); 
					$this->data['View'] = $item[0];
				}
				$this->load->view('includes/header',$this->data);
				$this->load->view('pages/abhyas_pdf_add_edit_view',$this->data);
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
 		$delete_data = $this->form_model->delete(array('AP' => array('ID' => $item_id)));
 		define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
		if($delete_data)
 		{
		    if(IS_AJAX)
			{
				echo json_encode($delete_data);	
			}
			else
			{
	 			redirect('Abhyas_pdf');
	 		}
		}
 	}

 	public function upload_pdf()
	{
		echo $this->abhyas_pdf_model->upload_pdf();
	}

	public function view_pdf($id = NULL)
	{
		$this->data['breadcrumb']['heading'] = 'View PDF';  
		$this->data['breadcrumb']['route'] = array(array('title'=>'Dashboard','path'=>'dashboard'),array('title'=>'Abhyas PDF','path'=>'Abhyas_pdf'),'View PDF');
		$img = $this->str_function_library->call('fr>AP>pdf_ID:ID=`'.$id.'`');
	    $this->data['path'] = $this->str_function_library->call('fr>ASS>path:ID=`'.$img.'`');
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/abhyas_pdf_show_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

}
?>