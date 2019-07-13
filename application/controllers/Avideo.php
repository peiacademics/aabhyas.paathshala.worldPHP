<?php
	class Avideo extends CI_Controller {
		
	public function __construct()
	{
		parent::__construct();
	}

	public function view($path)
	{
		if($this->session_library->get_session_data('Login_as') != 'DSSK10000011')
		{
			$this->load->library('encrypt');
			$my_config = $this->config->item('skyq');
			$this->data['link'] = $this->encrypt->decrypt_string(base64_decode(urldecode($path)),$my_config['app_ie']);
			//var_dump($this->data['link']);
			$this->load->view('pages/avideo_view',$this->data);
		}
		else{
			echo "<h3>Sorry, this video is not available.</h3>";
		}
	}
}
?>