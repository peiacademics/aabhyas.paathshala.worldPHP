<?php
class Stest extends CI_Controller {
		
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
			$this->load->model('stest_model');
			$this->load->model('dashboard_model');
			$this->data['my_config'] = $this->my_config = $this->config->item('skyq');
            $this->data['menu'] = $this->setting_model->get_menus($this->data,$this->my_config);
		}
		else 
		{
			redirect($this->config->item('skyq')['default_login_page']);
		}
 	}

	public function view($url_data = NULL)
	{
		$this->data['data'] = $this->stest_model->view($url_data);
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/stest_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	public function get_test_time()
	{
		echo json_encode($this->stest_model->get_test_time());
	}
	
	public function start_test()
	{
		echo json_encode($this->stest_model->start_test());
	}

	public function submit_test($link)
	{
		echo json_encode($this->stest_model->submit_test($link));
	}

	public function get_student_test($ats_ID = NULL)
	{
		$this->data['student_ID'] = $ats_ID;
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/sstudent_test_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	public function score_details($ats_ID = NULL)
	{	
		/*echo "<pre>";
		print_r($this->assignment_model->score_details($ats_ID));
		echo "</pre>";*/
		echo json_encode($this->stest_model->score_details($ats_ID));
	}

	public function test_records($student_ID = NULL)
	{
		$this->data['student_name'] = $this->str_function_library->call('fr>ST>Name:ID=`'.$this->session_library->get_session_data('ID').'`').' '.$this->str_function_library->call('fr>ST>Middle_name:ID=`'.$this->session_library->get_session_data('ID').'`').' '.$this->str_function_library->call('fr>ST>Last_name:ID=`'.$this->session_library->get_session_data('ID').'`');
		$this->data['student_ID'] = $this->session_library->get_session_data('ID');
		$this->load->view('includes/header',$this->data);
		$this->load->view('pages/sstudent_record_view',$this->data);
		$this->load->view('includes/footer',$this->data);
	}

	public function get_show_data($student_ID = NULL)
	{
		$res = $this->stest_model->get_show_data(array('AMS'=>array('student_ID'=>$student_ID,'ORDER BY date')),array('date','>>Saubject:>fr>SB>name:ID=^subject_ID^','>>Lesson:>fr>LS>name:ID=^lesson_ID^','>>Topic:>fr>TP>name:ID=^topic_ID^','>>MCQ:>fr>AM>name:ID=^mcq_ID^','>>Min_marks:>fn>library>user_library:getSameValue(^min_marks^)','>>Obt_marks:>fn>library>user_library:getSameValue(^obt_marks^)','>>Max_marks:>fn>library>user_library:getSameValue(^max_marks^)','>>Result:>fn>library>user_library:getSameValue(^result^)'));
		echo json_encode($res);
 	}

}

?>