<?php
	class Svideo extends CI_Controller {
		
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
			$this->load->model('svideo_model');
			$this->load->model('dashboard_model');
			$this->data['my_config'] = $this->my_config = $this->config->item('skyq');
            $this->data['menu'] = $this->setting_model->get_menus($this->data,$this->my_config);
		}
		else 
		{
			redirect($this->config->item('skyq')['default_login_page']);
		}
 	}

	public function view($url_data)
	{
		$this->data['data'] = $this->svideo_model->view($url_data);
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/svideo_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	public function get_video()
	{
		echo json_encode($this->svideo_model->get_video());
	}

	public function abhyas_video_upload($data)
	{//base_url("Abhyas_video_upload/".base64_decode(urldecode($data)))
		echo json_encode(PAATHSHALA_PATH.'abhyas_video_upload/'.base64_decode(urldecode($data)));
	}
}

?>