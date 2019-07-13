<?php
	class Svideo_model extends CI_Model
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
			$d['list'] = $this->str_function_library->call('fr>AV>name:ID=`'.$exp[4].'`');
			unset($exp[4]);
			$encrypt = implode('^',$exp);
			$d['link'] = urlencode(base64_encode($this->encrypt->encrypt_string($encrypt,$my_config['app_ie'])));
			return $d;
		}

		public function get_video()
		{
			$link = '0';
			$this->load->library('encrypt');
			$my_config = $this->config->item('skyq');
			$data = $this->encrypt->decrypt_string(base64_decode(urldecode($_POST['url_data'])),$my_config['app_ie']);
			$exp = explode('^',$data);
			// print_r($exp);
			$pdf_ID = $this->str_function_library->call('fr>AV>video_ID:ID=`'.$exp[4].'`,subject_ID=`'.$exp[0].'`,lesson_ID=`'.$exp[1].'`,topic_ID=`'.$exp[2].'`');/*$this->fetch_model->show(array('AP'=>array('subject_ID'=>$exp[0],'lesson_ID'=>$exp[1],'topic_ID'=>$exp[2])));*/
			$link = $this->str_function_library->call('fr>AVU>path:ID=`'.$pdf_ID.'`');
			// var_dump($exp);
			if($link != '-NA-')
			{
				$l = explode('/',$link);
				$ln = $l[0].'/'.urlencode(base64_encode($l[1]));
			}
			else{
				$ln = '0';
			}
			return $ln;
		}
	}
?>