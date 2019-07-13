<?php
	class Spdf_model extends CI_Model
	{
		public function view($url_data)
		{
			$d = array();
			$this->load->library('encrypt');
			$my_config = $this->config->item('skyq');
			$data = $this->encrypt->decrypt_string(base64_decode(urldecode($url_data)),$my_config['app_ie']);
			$exp = explode('^',$data);
			// echo "<pre>"; print_r($data); echo "</pre>";
			$d['subject'] = $this->str_function_library->call('fr>SB>name:ID=`'.$exp[0].'`');
			$d['lesson'] = $this->str_function_library->call('fr>LS>name:ID=`'.$exp[1].'`');
			$d['topic'] = $this->str_function_library->call('fr>TP>name:ID=`'.$exp[2].'`');
			$d['package'] = $this->str_function_library->call('fr>APG>name:ID=`'.$exp[3].'`');
			$d['list'] = $this->str_function_library->call('fr>AP>name:ID=`'.$exp[4].'`');
			unset($exp[4]);
			$encrypt = implode('^',$exp);
			$d['link'] = urlencode(base64_encode($this->encrypt->encrypt_string($encrypt,$my_config['app_ie'])));
			return $d;
		}

		public function get_pdf()
		{
			$link = '0';
			$this->load->library('encrypt');
			$my_config = $this->config->item('skyq');
			$data = $this->encrypt->decrypt_string(base64_decode(urldecode($_POST['url_data'])),$my_config['app_ie']);
			$exp = explode('^',$data);
			$pdf_ID = $this->str_function_library->call('fr>AP>pdf_ID:ID=`'.$exp[4].'`,subject_ID=`'.$exp[0].'`,lesson_ID=`'.$exp[1].'`,topic_ID=`'.$exp[2].'`');/*$this->fetch_model->show(array('AP'=>array('subject_ID'=>$exp[0],'lesson_ID'=>$exp[1],'topic_ID'=>$exp[2])));*/
			$link = $this->str_function_library->call('fr>ASS>path:ID=`'.$pdf_ID.'`');
			// var_dump($exp);
			return ($link != '-NA-') ? $link : '0';
		}
	}
?>