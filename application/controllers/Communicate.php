
<?php
	class Communicate extends CI_Controller {
		
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
			$this->load->model('communicate_model');
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
		echo "string";
	}

	public function getTypeList()
	{
		echo json_encode($this->communicate_model->getTypeList());
	}

	public function personsToSendMsg()
	{
		echo json_encode($this->communicate_model->personsToSendMsg());
	}
	
	public function getMsgMaster()
	{
		echo json_encode($this->communicate_model->getMsgMaster());
	}

	public function sendMsg()
	{
		echo json_encode($this->communicate_model->sendMsg());
	}

	public function communication_setting()
 	{
 		$this->data['breadcrumb']['heading'] = 'Communication Setting';  
		$this->data['breadcrumb']['route'] = array(array('title'=>'Settings','path'=>'settings'),'Communication Setting');
		$this->data['student'] = $this->fetch_model->show(array('CMS'=>array('type'=>'Student','send_type'=>'bulk')));
		$this->data['employee'] = $this->fetch_model->show(array('CMS'=>array('type'=>'Employee','send_type'=>'bulk')));
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/communication_setting_view',$this->data);
		$this->load->view('includes/footer',$this->data);
 	}

 	public function add_communication_setting()
 	{
 		echo json_encode($this->communicate_model->add_communication_setting());
 	}

 	public function get_record()
 	{
 		echo json_encode($this->communicate_model->get_record());
 	}

 	public function mail_bheja()
 	{
 		$this->load->library('email');
 		$Edata['Msg'] = "welcome to paathshala.";
					$Edata['time'] = date("Y-m-d H:i:s");
					$config = array(
						'protocol' => 'smtp',
						'smtp_host' => 'md-in-67.webhostbox.ne',
						'smtp_port' => 465,
						'smtp_user' => 'mumbai@transmarine.online',
						'smtp_pass' => 'mumbai@123',
						'mailtype'  => 'html',
					);
					$this->email->initialize($config);
		        	$this->email->from('support@paathshala.in','Paathshala');
			   		$save = $this->load->view('messages/comunication_msg',$Edata,TRUE);
		        	$this->email->subject('Welcome to Paathshala.');
		        	$this->email->message($save);
					$this->email->to("gulawani.prasad310@gmail.com");
					if($this->email->send())
					{
						// echo "done";
					}
					else
					{
						// echo "flase";
					}
 	}

}
?>