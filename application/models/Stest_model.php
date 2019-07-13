<?php
	class Stest_model extends CI_Model
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
			$qn_exp = explode('SK',$exp[4]);
			$d['list'] = $this->str_function_library->call('fr>'.$qn_exp[0].'>name:ID=`'.$exp[4].'`');
			// print_r($exp);
			unset($exp[4]);
			$encrypt = implode('^',$exp);
			$d['link'] = urlencode(base64_encode($this->encrypt->encrypt_string($encrypt,$my_config['app_ie'])));
			return $d;
		}

		public function get_test_time()
		{
			$this->load->library('encrypt');
			$my_config = $this->config->item('skyq');
			$data = $this->encrypt->decrypt_string(base64_decode(urldecode($_POST['url_data'])),$my_config['app_ie']);
			$exp = explode('^',$data);
			// print_r($exp);
			return strtotime($this->str_function_library->call('fr>APGD>datetime:package_ID=`'.$exp[3].'`,reference_ID=`'.$exp[4].'`'));
		}

		public function start_test()
		{
			$link = '0';
			$this->load->library('encrypt');
			$my_config = $this->config->item('skyq');
			$data = $this->encrypt->decrypt_string(base64_decode(urldecode($_POST['url_data'])),$my_config['app_ie']);
			$exp = explode('^',$data);
			// print_r($exp);
			$qn_exp = explode('SK',$exp[4]);
			if($qn_exp[0] == 'AM')
			{
				return $this->get_test_am($exp);
			}
			else
			{
				return $this->get_test_aqt($exp);
			}
		}

		public function get_test_am($exp)
		{
			// print_r($exp);
			$dt = $this->fetch_model->show(array('AM'=>array('ID'=>$exp[4],'subject_ID'=>$exp[0],'lesson_ID'=>$exp[1],'topic_ID'=>$exp[2])),array('ID','name','exam_time'));
			if(!empty($dt))
			{
				foreach ($dt as $dtkey => $dtvalue) {
					$dt[$dtkey]['datetime'] = $this->str_function_library->call('fr>APGD>datetime:package_ID=`'.$exp[3].'`,reference_ID=`'.$exp[4].'`');
					$dt[$dtkey]['qn'] = $this->fetch_model->show(array('AMQ'=>array('mcq_ID'=>$exp[4])),array('ID','question','question_path','correct_marks','blank_marks','wrong_marks','type'));
					if(!empty($dt[$dtkey]['qn']))
					{
						$dt[$dtkey]['no_of_questions'] = count($dt[$dtkey]['qn']);
						// print_r($dt[$dtkey]['qn']);
						$dt[$dtkey]['total_marks'] = array_sum(array_column($dt[$dtkey]['qn'],'correct_marks'));
						foreach ($dt[$dtkey]['qn'] as $qnkey => $qnvalue) {
							$ans = $this->fetch_model->show(array('AMA'=>array('question_ID'=>$qnvalue['ID'])),array('ID','answer','ans_path'));
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

		public function get_test_aqt($exp)
		{
			$dt = $this->fetch_model->show(array('AQT'=>array('ID'=>$exp[4],'subject_ID'=>$exp[0],'lesson_ID'=>$exp[1],'topic_ID'=>$exp[2])),array('ID','name','question_bank_ID'));
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

		public function submit_test($url_data)
		{
			$this->load->model('form_model');
			$this->load->library('encrypt');
			$my_config = $this->config->item('skyq');
			$data = $this->encrypt->decrypt_string(base64_decode(urldecode($url_data)),$my_config['app_ie']);
			$exp = explode('^',$data);
			// print_r($_POST);
			// print_r($exp);
			$qn_exp = explode('SK',$exp[4]);
			if($qn_exp[0] == 'AM')
			{
				return $this->submit_test_am($exp);
			}
			else
			{
				return $this->submit_test_aqt($exp);
			}
		}

		public function submit_test_am($exp)
		{
			$count = 0;
			$score = 0;
			$show = $this->fetch_model->show(array('AMQ'=>array('mcq_ID'=>$exp[4])),array('ID','type','correct_marks','blank_marks','wrong_marks'));
			$total_marks = $marks_obtained = 0;
			foreach ($show as $key=>$value) {
				$total_marks += $value['correct_marks'];
				if(array_key_exists($value['ID'], $_POST))
				{

					switch ($value['type']) {
						case 'single':
							$check = $this->single('AMA',$_POST[$value['ID']]);
							$show[$key]['your_answer'] = $_POST[$value['ID']];
							break;
						case 'multiple':
							$check = $this->multiple('AMA',$_POST[$value['ID']]);
							$show[$key]['your_answer'] = implode(',',$_POST[$value['ID']]);
							break;

						case 'most_correct':
							$check = $this->most_correct('AMA',$_POST[$value['ID']]);
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
			return $this->add_to_testscore($exp,$total_marks,$marks_obtained,$show);
		}

		public function submit_test_aqt($exp)
		{
			$count = 0;
			$score = 0;
			$qn_ids = $this->str_function_library->call('fr>AQT>question_bank_ID:ID=`'.$exp[4].'`');
			$qns_id = str_replace(',','||', $qn_ids);
			$show = $this->fetch_model->show(array('AQB'=>array('ID'=>$qns_id)),array('ID','type','correct_marks','blank_marks','wrong_marks'));
			$total_marks = $marks_obtained = 0;
			foreach ($show as $key=>$value) {
				$total_marks += $value['correct_marks'];
				if(array_key_exists($value['ID'], $_POST))
				{
					switch ($value['type']) {
						case 'single':
							$check = $this->single('AQA',$_POST[$value['ID']]);
							$show[$key]['your_answer'] = $_POST[$value['ID']];
							break;
						case 'multiple':
							$check = $this->multiple('AQA',$_POST[$value['ID']]);
							$show[$key]['your_answer'] = implode(',',$_POST[$value['ID']]);
							break;

						case 'most_correct':
							$check = $this->most_correct('AQA',$_POST[$value['ID']]);
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
			// print_r($show);
			return $this->add_to_testscore($exp,$total_marks,$marks_obtained,$show);
		}

		public function add_to_testscore($exp,$total_marks,$marks_obtained,$show)
		{
			$query = $this->form_model->add(array('table'=>'ATS','columns'=>array('student_ID'=>$this->session_library->get_session_data('ID'),'test_ID'=>$exp[4],'total_marks'=>$total_marks,'marks_obtained'=>$marks_obtained)));
			if($query == TRUE)
			{
				$ats_ID = $this->db_library->find_max_id('ATS');
				foreach ($show as $skey => $svalue) {
					$query_s = $this->form_model->add(array('table'=>'ATSC','columns'=>array('ats_ID'=>$ats_ID,'question_ID'=>$svalue['ID'],'marks_obtained'=>$svalue['score'],'your_answer'=>$svalue['your_answer'])));
				}
				return $ats_ID;
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

		public function score_details($ats_ID = NULL)
		{
			if(!empty($ats_ID))
			{
				$ddata = $this->fetch_model->show(array('ATS'=>array('ID'=>$ats_ID,'student_ID'=>$this->session_library->get_session_data('ID'))));
				$test_ID = $this->str_function_library->call('fr>ATS>test_ID:ID=`'.$ats_ID.'`');
				$expl = explode('SK',$test_ID);
				$subject_ID = $this->str_function_library->call('fr>'.$expl[0].'>subject_ID:ID=`'.$test_ID.'`');
				$topic_ID = $this->str_function_library->call('fr>'.$expl[0].'>topic_ID:ID=`'.$test_ID.'`');
				$lesson_ID = $this->str_function_library->call('fr>'.$expl[0].'>lesson_ID:ID=`'.$test_ID.'`');
				$ddata[0]['subject'] = $this->str_function_library->call('fr>SB>name:ID=`'.$subject_ID.'`');
				$ddata[0]['topic'] = $this->str_function_library->call('fr>TP>name:ID=`'.$topic_ID.'`');
				$ddata[0]['lesson'] = $this->str_function_library->call('fr>LS>name:ID=`'.$lesson_ID.'`');
				$ddata[0]['name'] = $this->str_function_library->call('fr>'.$expl[0].'>name:ID=`'.$test_ID.'`');
				$ddata[0]['date'] = $this->str_function_library->call('fr>'.$expl[0].'>Added_on:ID=`'.$test_ID.'`');
				$ddata[0]['description'] = $this->str_function_library->call('fr>'.$expl[0].'>description:ID=`'.$test_ID.'`');
				if(!empty($ddata))
				{
					$data = $ddata[0];
					$data['z_scores'] = $this->fetch_model->show(array('ATSC'=>array('ats_ID'=>$ats_ID)),array('ID','ats_ID','marks_obtained','question_ID','your_answer'));
					if(!empty($data['z_scores']))
					{
						foreach ($data['z_scores'] as $key => $value) {
							$expld = explode('SK', $value['question_ID']);
							$data['z_scores'][$key]['qn_ID'] = $value['question_ID'];
							$data['z_scores'][$key]['qn_name'] = ($expld[0] == 'AQB') ? $this->str_function_library->call('fr>'.$expld[0].'>name:ID=`'.$value['question_ID'].'`') : $this->str_function_library->call('fr>'.$expld[0].'>question:ID=`'.$value['question_ID'].'`');
							$data['z_scores'][$key]['qn_type'] = $this->str_function_library->call('fr>'.$expld[0].'>type:ID=`'.$value['question_ID'].'`');
							$data['z_scores'][$key]['qn_path'] = $this->str_function_library->call('fr>'.$expld[0].'>question_path:ID=`'.$value['question_ID'].'`');
							$data['z_scores'][$key]['qn_explain'] = $this->str_function_library->call('fr>'.$expld[0].'>explanation:ID=`'.$value['question_ID'].'`');

							$data['z_scores'][$key]['z_answer'] = ($expld[0] == 'AQB') ? $this->fetch_model->show(array('AQA'=>array('question_bank_ID'=>$value['question_ID'])),array('ID','answer','ans_path','correct','order_seq')) : $this->fetch_model->show(array('AMA'=>array('question_ID'=>$value['question_ID'])),array('ID','answer','ans_path','correct','order_seq'));
							switch ($data['z_scores'][$key]['qn_type']) {
								case 'single':
									$correct = ($expld[0] == 'AQB') ? $this->str_function_library->call('fr>AQA>correct:ID=`'.$value['your_answer'].'`') : $this->str_function_library->call('fr>AMA>correct:ID=`'.$value['your_answer'].'`');
									$check = ($correct=='yes') ? TRUE : FALSE;
									break;
								case 'multiple':
									$check = TRUE;
									$your_ans = explode(',', $value['your_answer']);
									foreach ($your_ans as $answer_ID) {
										$cr = ($expld[0] == 'AQB') ? $this->str_function_library->call('fr>AQA>correct:ID=`'.$answer_ID.'`') : $this->str_function_library->call('fr>AMA>correct:ID=`'.$answer_ID.'`');
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
										$odr = ($expld[0] == 'AQB') ? $this->str_function_library->call('fr>AQA>order_seq:ID=`'.$jv['id'].'`') : $this->str_function_library->call('fr>AMA>order_seq:ID=`'.$jv['id'].'`');
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
											$an = ($expld[0] == 'AQB') ? $this->str_function_library->call('fr>AQA>answer:ID=`'.$valueans.'`') : $this->str_function_library->call('fr>AMA>answer:ID=`'.$valueans.'`');
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
										$an = ($expld[0] == 'AQB') ? $this->str_function_library->call('fr>AQA>answer:ID=`'.$valuea.'`') : $this->str_function_library->call('fr>AMA>answer:ID=`'.$valuea.'`');
										$answer .= $an.',';
									}
									$answer = rtrim($answer, ',');
								}
							}
							else
							{
								$answer = ($expld[0] == 'AQB') ? $this->str_function_library->call('fr>AQA>answer:ID=`'.$value['your_answer'].'`') : $this->str_function_library->call('fr>AMA>answer:ID=`'.$value['your_answer'].'`');
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

		public function single($tbl,$val)
		{
			$correct = $this->str_function_library->call('fr>'.$tbl.'>correct:ID=`'.$val.'`');
			return ($correct=='yes') ? TRUE : FALSE;
		}

		public function multiple($tbl,$val)
		{
			$check = TRUE;
			foreach ($val as $answer_ID) {
				$cr = $this->str_function_library->call('fr>'.$tbl.'>correct:ID=`'.$answer_ID.'`');
				if($cr == 'no'){
					$check = FALSE;
					break;
				}
			}
			return $check;
		}

		public function most_correct($tbl,$val)
		{
			$check = TRUE;
			$json_decode = json_decode($val,true);
			foreach ($json_decode as $jk => $jv) {
				$j = $jk+1;
				$odr = $this->str_function_library->call('fr>'.$tbl.'>order_seq:ID=`'.$jv['id'].'`');
				if($odr != $j){
					$check = FALSE;
					break;
				}
			}
		}		
	}
?>