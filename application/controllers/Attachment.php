<?php
	class Attachment extends CI_Controller {
		
	public function __construct()
	{
		parent::__construct();
		$this->load->model('attachment_model');
 	}

	public function index()
	{
		$this->load->view('messages/errorRedirect');
	}

	public function view($token,$download=null)
	{
		if (!empty($token)) {
			$this->attachment_model->view($token,$download);
		}
		else
		{
			redirect('Attachment');
		}
	}

	public function transaction($token,$download=null)
	{
		if (!empty($token)) {
			$this->attachment_model->transaction($token,$download);
		}
		else
		{
			redirect('Attachment');
		}
	}

	public function AddChanges($data)
	{
		$_POST = json_decode(base64_decode(urldecode($data)),TRUE);
		if (!empty($_POST['jsonData'])) {
			$this->load->model('form_model');
			foreach (json_decode($_POST['jsonData'],true) as $key => $value) {
				$b_add = $this->form_model->add(array("table"=>"EL","columns"=>array('Comments'=>$value['comment'],'Attr_path'=>$value['path'],'token'=>$_POST['token'],'Page_path'=>$_POST['currenturl'],'Type'=>$_POST['type'])));
			}
			echo json_encode($b_add);
		}
		else
		{
			echo json_encode("No Data Found");;
		}

	}

	public function GetChanges($data)
	{
		$_POST = json_decode(base64_decode(urldecode($data)),TRUE);
		if (!empty($_POST['token'])) {
			$b_add=$this->fetch_model->show(array('EL' =>array('token'=>$_POST['token'])));
			echo json_encode($b_add);
		}
		else
		{
			echo json_encode("No Data Found");;
		}

	}

	public function getAllData()
	{
		$data['Category']=$this->fetch_model->show(array('EL' =>array('token'=>$_POST['token'])));
	}

}
?>