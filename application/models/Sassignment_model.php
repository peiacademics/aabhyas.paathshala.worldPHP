<?php
	class Sassignment_model extends CI_Model
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
			$d['list'] = $this->str_function_library->call('fr>AQS>name:ID=`'.$exp[4].'`');
			// print_r($exp);
			unset($exp[4]);
			$encrypt = implode('^',$exp);
			$d['link'] = urlencode(base64_encode($this->encrypt->encrypt_string($encrypt,$my_config['app_ie'])));
			return $d;
		}

		public function start_assignment()
		{
			$link = '0';
			$this->load->library('encrypt');
			$my_config = $this->config->item('skyq');
			$data = $this->encrypt->decrypt_string(base64_decode(urldecode($_POST['url_data'])),$my_config['app_ie']);
			$exp = explode('^',$data);
			$dt = $this->fetch_model->show(array('AQS'=>array('ID'=>$exp[4],'subject_ID'=>$exp[0],'lesson_ID'=>$exp[1],'topic_ID'=>$exp[2])),array('ID','name','question_bank_ID'));
			if(!empty($dt))
			{
				foreach ($dt as $dtkey => $dtvalue) {
					$question_bank_IDs = str_replace(',', '||', $dtvalue['question_bank_ID']);
					$dt[$dtkey]['qn'] = $this->fetch_model->show(array('AQB'=>array('ID'=>$question_bank_IDs)),array('ID','question','question_path','correct_marks','blank_marks','wrong_marks','type'));
					if(!empty($dt[$dtkey]['qn']))
					{
						foreach ($dt[$dtkey]['qn'] as $qnkey => $qnvalue) {
							$ans = $this->fetch_model->show(array('AQA'=>array('question_bank_ID'=>$qnvalue['ID'])),array('ID','answer','ans_path'));
							if(!empty($ans))
							{
								$dt[$dtkey]['qn'][$qnkey]['ans'] = $ans;
							}
						}
					}
				}
			}
			return $dt;
		}

		public function submit_assignment($url_data)
		{
			$this->load->model('form_model');
			$this->load->library('encrypt');
			$my_config = $this->config->item('skyq');
			$data = $this->encrypt->decrypt_string(base64_decode(urldecode($url_data)),$my_config['app_ie']);
			$exp = explode('^',$data);
			$count = 0;
			$score = 0;
			//print_r($_POST);
			// print_r($exp);
			$qn_ids = $this->str_function_library->call('fr>AQS>question_bank_ID:ID=`'.$exp[4].'`');
			$qns_id = str_replace(',','||', $qn_ids);
			$show = $this->fetch_model->show(array('AQB'=>array('ID'=>$qns_id)),array('ID','type','correct_marks','blank_marks','wrong_marks'));
			$total_marks = $marks_obtained = 0;
			foreach ($show as $key=>$value) {
				$total_marks += $value['correct_marks'];
				if(array_key_exists($value['ID'], $_POST))
				{
					switch ($value['type']) {
						case 'single':
							$correct = $this->str_function_library->call('fr>AQA>correct:ID=`'.$_POST[$value['ID']].'`');
							$check = ($correct=='yes') ? TRUE : FALSE;
							$show[$key]['your_answer'] = $_POST[$value['ID']];
							break;
						case 'multiple':
							$check = TRUE;
							foreach ($_POST[$value['ID']] as $answer_ID) {
								$cr = $this->str_function_library->call('fr>AQA>correct:ID=`'.$answer_ID.'`');
								if($cr == 'no'){
									$check = FALSE;
									break;
								}
							}
							$show[$key]['your_answer'] = implode(',',$_POST[$value['ID']]);
							break;

						case 'most_correct':
							$check = TRUE;
							$json_decode = json_decode($_POST[$value['ID']],true);
							foreach ($json_decode as $jk => $jv) {
								$j = $jk+1;
								$odr = $this->str_function_library->call('fr>AQA>order_seq:ID=`'.$jv['id'].'`');
								if($odr != $j){
									$check = FALSE;
									break;
								}
							}
							$show[$key]['your_answer'] = $_POST[$value['ID']];
							break;
						
						default:
							$check = FALSE;
							break;
					}
					if($check == TRUE)
					{
						$show[$key]['score'] = $value['correct_marks'];
						$marks_obtained += $value['correct_marks'];
					}
					else{
						$show[$key]['score'] = $value['wrong_marks'];
						$marks_obtained += $value['wrong_marks'];
					}
				}
				else{
					$show[$key]['score'] = $value['blank_marks'];
					$marks_obtained += $value['blank_marks'];
					$show[$key]['your_answer'] = '';
				}
			}
			// print_r('<br>'.$total_marks.'<br>');
			// print_r($marks_obtained.'<br>');
			// print_r($show);
			$query = $this->form_model->add(array('table'=>'AAS','columns'=>array('student_ID'=>$this->session_library->get_session_data('ID'),'assignment_ID'=>$exp[4],'total_marks'=>$total_marks,'marks_obtained'=>$marks_obtained)));
			if($query == TRUE)
			{
				$aas_ID = $this->db_library->find_max_id('AAS');
				foreach ($show as $skey => $svalue) {
					$query_s = $this->form_model->add(array('table'=>'AASC','columns'=>array('aas_ID'=>$aas_ID,'question_ID'=>$svalue['ID'],'marks_obtained'=>$svalue['score'],'your_answer'=>$svalue['your_answer'])));
				}
				return $aas_ID;
			}
			else{
				return FALSE;
			}
		}

		public function get_show_data($input,$output)
		{
		 	$this->load->library('datatable_library');
	 		return $this->datatable_library->get_data($input,$output);
		}

		public function score_details($aas_ID = NULL)
		{
			if(!empty($aas_ID))
			{
				$ddata = $this->fetch_model->show(array('AAS'=>array('ID'=>$aas_ID,'student_ID'=>$this->session_library->get_session_data('ID'))));
				$assignment_ID = $this->str_function_library->call('fr>AAS>assignment_ID:ID=`'.$aas_ID.'`');
				$subject_ID = $this->str_function_library->call('fr>AQS>subject_ID:ID=`'.$assignment_ID.'`');
				$topic_ID = $this->str_function_library->call('fr>AQS>topic_ID:ID=`'.$assignment_ID.'`');
				$lesson_ID = $this->str_function_library->call('fr>AQS>lesson_ID:ID=`'.$assignment_ID.'`');
				$ddata[0]['subject'] = $this->str_function_library->call('fr>SB>name:ID=`'.$subject_ID.'`');
				$ddata[0]['topic'] = $this->str_function_library->call('fr>TP>name:ID=`'.$topic_ID.'`');
				$ddata[0]['lesson'] = $this->str_function_library->call('fr>LS>name:ID=`'.$lesson_ID.'`');
				$ddata[0]['name'] = $this->str_function_library->call('fr>AQS>name:ID=`'.$assignment_ID.'`');
				$ddata[0]['date'] = $this->str_function_library->call('fr>AQS>Added_on:ID=`'.$assignment_ID.'`');
				$ddata[0]['description'] = $this->str_function_library->call('fr>AQS>description:ID=`'.$assignment_ID.'`');
				if(!empty($ddata))
				{
					$data = $ddata[0];
					$data['z_scores'] = $this->fetch_model->show(array('AASC'=>array('aas_ID'=>$aas_ID)),array('ID','aas_ID','marks_obtained','>>qn_ID:>fr>AQB>ID:ID=^question_ID^','>>qn_name:>fr>AQB>question:ID=^question_ID^','>>qn_type:>fr>AQB>type:ID=^question_ID^','your_answer'));
					if(!empty($data['z_scores']))
					{
						foreach ($data['z_scores'] as $key => $value) {
							$data['z_scores'][$key]['qn_path'] = $this->str_function_library->call('fr>AQB>question_path:ID=`'.$value['qn_ID'].'`');
							$data['z_scores'][$key]['qn_explain'] = $this->str_function_library->call('fr>AQB>explanation:ID=`'.$value['qn_ID'].'`');
							$data['z_scores'][$key]['z_answer'] = $this->fetch_model->show(array('AQA'=>array('question_bank_ID'=>$value['qn_ID'])),array('ID','answer','ans_path','correct','order_seq'));
							switch ($value['qn_type']) {
								case 'single':
									$correct = $this->str_function_library->call('fr>AQA>correct:ID=`'.$value['your_answer'].'`');
									$check = ($correct=='yes') ? TRUE : FALSE;
									break;
								case 'multiple':
									$check = TRUE;
									$your_ans = explode(',', $value['your_answer']);
									foreach ($your_ans as $answer_ID) {
										$cr = $this->str_function_library->call('fr>AQA>correct:ID=`'.$answer_ID.'`');
										if($cr == 'no'){
											$check = FALSE;
											break;
										}
									}
									break;
								case 'most_correct':
									$check = TRUE;
									$json_decode = json_decode($value['your_answer'],true);
									foreach ($json_decode as $jk => $jv) {
										$j = $jk+1;
										$odr = $this->str_function_library->call('fr>AQA>order_seq:ID=`'.$jv['id'].'`');
										if($odr != $j){
											$check = FALSE;
											break;
										}
									}
									break;
								default:
									$check = FALSE;
									break;
							}
							$data['z_scores'][$key]['qn_correct'] = $check;
							if(strpos($value['your_answer'], ',') !== FALSE)
							{
								if(strpos($value['your_answer'], ':') !== FALSE)
								{
									$your_ans = json_decode($value['your_answer']);
									$answer = '';
									$i = 1;
									foreach ($your_ans as $keyids => $valueids) {
										foreach ($valueids as $keyans => $valueans) {
											$an = $this->str_function_library->call('fr>AQA>answer:ID=`'.$valueans.'`');
											$answer .= '('.$i.') '.$an.',';
											$i++;
										}
									}
									$answer = rtrim($answer, ',');
								}
								else
								{
									$answer = '';
									$ans = explode(',', $value['your_answer']);
									foreach ($ans as $keya => $valuea) {
										$an = $this->str_function_library->call('fr>AQA>answer:ID=`'.$valuea.'`');
										$answer .= $an.',';
									}
									$answer = rtrim($answer, ',');
								}
							}
							else
							{
								$answer = $this->str_function_library->call('fr>AQA>answer:ID=`'.$value['your_answer'].'`');
							}
							$data['z_scores'][$key]['your_answer'] = $answer;
						}
					}
					return $data;
				}
				return $ddata;
			}
			else{
				return FALSE;
			}
		}
		
	}
?>