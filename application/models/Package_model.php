<?php
	class Package_model extends CI_Model
	{
		public function check($id=NULL,$login_as="Client")
		{
			$user = count($this->fetch_model->show(array('APG' =>array('ID'=>$id))));
			if(is_null($id))
			{
				return TRUE;
			}
			elseif($user > 0)
			{
				return TRUE;
			}
			else
			{
				$this->errorlog_library->entry('Package_model > check > argument id is invalid.');
				redirect('Salary_model/add/');
			}
		}

		public function add()
		{
			$this->load->model('form_model');
			//print_r($_POST);
			if(empty($_POST['ID']))
			{
				unset($_POST['ID']);
				$data['name'] = $_POST['name'];
				$data['price'] = $_POST['price'];
				$result = $this->form_model->add(array("table"=>"APG","columns"=>$data));
				if ($result) {
					unset($_POST['name']);
					unset($_POST['price']);
					foreach ($_POST as $key => $value) {
						if(stripos($key,'-') == FALSE)
						{
							$explode = explode('^',$value);
						 	$columns['package_ID'] = $this->db_library->find_max_id('APG');
						 	$columns['subject_ID'] = $explode[0];
						 	$columns['lesson_ID'] = $explode[1];
						 	$columns['topic_ID'] = $explode[2];
						 	$columns['type'] = $explode[3];
						 	$columns['reference_ID'] = $key;
						 	if(isset($_POST[$key.'-datetime']))
						 	{
						 		$_POST[$key.'-datetime'] = !empty($_POST[$key.'-datetime']) ? $_POST[$key.'-datetime'] : NULL;
						 	}
						 	$columns['datetime'] = @$_POST[$key.'-datetime'];
						 	$addPerticular=$this->form_model->add(array("table"=>"APGD","columns"=>$columns));
						 }
					}
					return true;
				}
				else
				{
					return false;
				}
			}
		}

		public function get_show_data($input,$output)
		{
		 	$this->load->library('datatable_library');
	 		$PT = $this->datatable_library->get_data($input,$output);
	 		return $PT;
		}

		public function delete($id)
		{
			$this->load->model('form_model');
			$this->form_model->delete(array('APGD'=>array('package_ID'=>$id)));
			return $this->form_model->delete(array('APG'=>array('ID'=>$id)));
		}

		public function get_abhyas_details()
		{
			$data = array();
			$subjects = $this->fetch_model->show('SB',array('ID','name'));//LS,TP
			$this->load->library('encrypt');
			$my_config = $this->config->item('skyq');
			if(!empty($subjects))
			{
				foreach ($subjects as $skey => $subject) {
					$data[$skey]['text'] = $subject['name'];
					$data[$skey]['ID'] = $subject['ID'];
					$data[$skey]['hideCheckbox'] = true;
					$data[$skey]['icon'] = 'glyphicon glyphicon-book';
					$lessons = $this->fetch_model->show(array('LS'=>array('subject_ID'=>$subject['ID'])),array('ID','name'));
					if(!empty($lessons))
					{
						foreach ($lessons as $lkey => $lesson) {
							$data[$skey]['nodes'][$lkey]['text'] = $lesson['name'];
							$data[$skey]['nodes'][$lkey]['ID'] = $lesson['ID'];
							$data[$skey]['nodes'][$lkey]['hideCheckbox'] = true;
							$data[$skey]['nodes'][$lkey]['icon'] = 'glyphicon glyphicon-open-file';
							$topics = $this->fetch_model->show(array('TP'=>array('subject_ID'=>$subject['ID'],'lesson_ID'=>$lesson['ID'])),array('ID','name'));
							if(!empty($topics))
							{
								foreach ($topics as $tkey => $topic) {
									$link = $subject['ID'].'^'.$lesson['ID'].'^'.$topic['ID'];
									$data[$skey]['nodes'][$lkey]['nodes'][$tkey]['text'] = $topic['name'];
									$data[$skey]['nodes'][$lkey]['nodes'][$tkey]['ID'] = $topic['ID'];
									$data[$skey]['nodes'][$lkey]['nodes'][$tkey]['hideCheckbox'] = true;
									$data[$skey]['nodes'][$lkey]['nodes'][$tkey]['icon'] = 'glyphicon glyphicon-blackboard';
									$mcqs = array();
									$mcqs_1 = $this->fetch_model->show(array('AM'=>array('subject_ID'=>$subject['ID'],'lesson_ID'=>$lesson['ID'],'topic_ID'=>$topic['ID'])),array('ID','name AS text'));
									if(!empty($mcqs_1)){
										foreach ($mcqs_1 as $m1key => $mcq1) {
											$mcqs[] = array('ID'=>$mcq1['ID'],'text'=>$mcq1['text'],'subject'=>$subject['name'],'lesson'=>$lesson['name'],'topic'=>$topic['name'],'type'=>'test','value'=>$link.'^test');
											// $mcqs[$mkey]['subject'] = $subject['name'];
											// $mcqs[$mkey]['lesson'] = $lesson['name'];
											// $mcqs[$mkey]['topic'] = $topic['name'];
											// $mcqs[$mkey]['type'] = 'mcq';
											// $mcqs[$mkey]['value'] = $link.'^test';
										}
									}
									$mcqs_2 = $this->fetch_model->show(array('AQT'=>array('subject_ID'=>$subject['ID'],'lesson_ID'=>$lesson['ID'],'topic_ID'=>$topic['ID'])),array('ID','name AS text'));
									if(!empty($mcqs_2)){
										foreach ($mcqs_2 as $m2key => $mcq2) {
											$mcqs[] = array('ID'=>$mcq2['ID'],'text'=>$mcq2['text'],'subject'=>$subject['name'],'lesson'=>$lesson['name'],'topic'=>$topic['name'],'type'=>'test','value'=>$link.'^test');
											// $mcqs[$mkey]['subject'] = $subject['name'];
											// $mcqs[$mkey]['lesson'] = $lesson['name'];
											// $mcqs[$mkey]['topic'] = $topic['name'];
											// $mcqs[$mkey]['type'] = 'mcq';
											// $mcqs[$mkey]['value'] = $link.'^test';
										}
									}
									$assignments = $this->fetch_model->show(array('AQS'=>array('subject_ID'=>$subject['ID'],'lesson_ID'=>$lesson['ID'],'topic_ID'=>$topic['ID'])),array('ID','name AS text'));
									if(!empty($assignments)){
										foreach ($assignments as $mkey => $mcq) {
											$assignments[$mkey]['subject'] = $subject['name'];
											$assignments[$mkey]['lesson'] = $lesson['name'];
											$assignments[$mkey]['topic'] = $topic['name'];
											$assignments[$mkey]['type'] = 'assignment';
											$assignments[$mkey]['value'] = $link.'^assignment';
										}
									}
									$pdfs = $this->fetch_model->show(array('AP'=>array('subject_ID'=>$subject['ID'],'lesson_ID'=>$lesson['ID'],'topic_ID'=>$topic['ID'])),array('ID','name AS text'));
									if(!empty($pdfs)){
										foreach ($pdfs as $mkey => $mcq) {
											$pdfs[$mkey]['subject'] = $subject['name'];
											$pdfs[$mkey]['lesson'] = $lesson['name'];
											$pdfs[$mkey]['topic'] = $topic['name'];
											$pdfs[$mkey]['type'] = 'pdf';
											$pdfs[$mkey]['value'] = $link.'^pdf';
										}
									}
									$videos = $this->fetch_model->show(array('AV'=>array('subject_ID'=>$subject['ID'],'lesson_ID'=>$lesson['ID'],'topic_ID'=>$topic['ID'])),array('ID','name AS text'));
									if(!empty($videos)){
										foreach ($videos as $mkey => $mcq) {
											$videos[$mkey]['subject'] = $subject['name'];
											$videos[$mkey]['lesson'] = $lesson['name'];
											$videos[$mkey]['topic'] = $topic['name'];
											$videos[$mkey]['type'] = 'video';
											$videos[$mkey]['value'] = $link.'^video';
										}
									}
									$data[$skey]['nodes'][$lkey]['nodes'][$tkey]['nodes'][] = array('text'=>'MCQ','hideCheckbox'=>true,'nodes'=>$mcqs);
									$data[$skey]['nodes'][$lkey]['nodes'][$tkey]['nodes'][] = array('text'=>'ASSIGNMENT','hideCheckbox'=>true,'nodes'=>$assignments);
									$data[$skey]['nodes'][$lkey]['nodes'][$tkey]['nodes'][] = array('text'=>'PDF','hideCheckbox'=>true,'nodes'=>$pdfs);
									$data[$skey]['nodes'][$lkey]['nodes'][$tkey]['nodes'][] = array('text'=>'VIDEO','hideCheckbox'=>true,'nodes'=>$videos);
									// $data[$skey]['nodes'][$lkey]['nodes'][$tkey]['nodes'][] = array($link);
									// $data[$skey]['nodes'][$lkey]['nodes'][$tkey]['nodes'][] = array($link);
								}
							}
						}
					}				
				}
			}

			return $data;
		}

		public function get_details($id)
		{
			$data = $this->fetch_model->show(array('APG'=>array('ID'=>$id)),array('ID','name','price'));
			if(!empty($data))
			{
				$data = $data[0];
				$package_details = $this->fetch_model->show(array('APGD'=>array('package_ID'=>$id)),array('ID','>>subject:>fr>SB>name:ID=^subject_ID^','>>lesson:>fr>LS>name:ID=^lesson_ID^','>>topic:>fr>TP>name:ID=^topic_ID^','reference_ID','datetime','type'));
				$data['lists'] = array();
				if(!empty($package_details)){
					foreach ($package_details as $key => $value) {
						$explode = explode('SK',$value['reference_ID']);
						$value['reference'] = $this->str_function_library->call('fr>'.$explode[0].'>name:ID=`'.$value['reference_ID'].'`');
						// $value['dt'] = (!empty($value['datetime'])) ? date('d/m/Y h:i a',strtotime($value['datetime'])) : str_replace(' ', 'T', $value['datetime']);
						$value['dt'] = str_replace(' ', 'T', $value['datetime']);
						$data['lists'][$value['type']][] = $value;
					}
				}
				return $data;
			}
			else{
				return array();
			}
		}

		public function get_data()
 		{
 			// print_r($_POST);
 			$data = array();
			$package_data = $this->fetch_model->show(array('APGD'=>$_POST),'reference_ID');
			$package_IDs = array_column($package_data, 'reference_ID');
 			switch ($_POST['type']) {
 				case 'test':
 					$mcqs = array();
					$mcqs_1 = $this->fetch_model->show(array('AM'=>array('subject_ID'=>$_POST['subject_ID'],'lesson_ID'=>$_POST['lesson_ID'],'topic_ID'=>$_POST['topic_ID'])),array('ID','name AS text'));
					if(!empty($mcqs_1))
					{
						foreach ($mcqs_1 as $m1key => $m1value) {
							if(!in_array($m1value['ID'], $package_IDs))
							{
								$mcqs[] = array('ID'=>$m1value['ID'],'text'=>$m1value['text'],'value'=>$_POST['subject_ID'].'^'.$_POST['lesson_ID'].'^'.$_POST['topic_ID'].'^'.$m1value['ID'].'^'.$_POST['package_ID'].'^test');
							}
						}
					}
					$mcqs_2 = $this->fetch_model->show(array('AQT'=>array('subject_ID'=>$_POST['subject_ID'],'lesson_ID'=>$_POST['lesson_ID'],'topic_ID'=>$_POST['topic_ID'])),array('ID','name AS text'));
					if(!empty($mcqs_2))
					{
						foreach ($mcqs_2 as $m2key => $m2value) {
							if(!in_array($m2value['ID'], $package_IDs))
							{
								$mcqs[] = array('ID'=>$m2value['ID'],'text'=>$m2value['text'],'value'=>$_POST['subject_ID'].'^'.$_POST['lesson_ID'].'^'.$_POST['topic_ID'].'^'.$m2value['ID'].'^'.$_POST['package_ID'].'^test');
							}
						}
					}
					$data = $mcqs;
 					break;
				
				case 'assignment':
					$assignments = $this->fetch_model->show(array('AQS'=>array('subject_ID'=>$_POST['subject_ID'],'lesson_ID'=>$_POST['lesson_ID'],'topic_ID'=>$_POST['topic_ID'])),array('ID','name AS text'));
					if(!empty($assignments))
					{
						foreach ($assignments as $key => $value) {
							if(!in_array($value['ID'], $package_IDs))
							{
								$data[] = array('ID'=>$value['ID'],'text'=>$value['text'],'value'=>$_POST['subject_ID'].'^'.$_POST['lesson_ID'].'^'.$_POST['topic_ID'].'^'.$value['ID'].'^'.$_POST['package_ID'].'^assignment');
							}
						}
					}
					break;

				case 'pdf':
					$pdfs = $this->fetch_model->show(array('AP'=>array('subject_ID'=>$_POST['subject_ID'],'lesson_ID'=>$_POST['lesson_ID'],'topic_ID'=>$_POST['topic_ID'])),array('ID','name AS text'));
					if(!empty($pdfs))
					{
						foreach ($pdfs as $key => $value) {
							if(!in_array($value['ID'], $package_IDs))
							{
								$data[] = array('ID'=>$value['ID'],'text'=>$value['text'],'value'=>$_POST['subject_ID'].'^'.$_POST['lesson_ID'].'^'.$_POST['topic_ID'].'^'.$value['ID'].'^'.$_POST['package_ID'].'^pdf');
							}
						}
					}
					break;

				case 'video':
					$videos = $this->fetch_model->show(array('AV'=>array('subject_ID'=>$_POST['subject_ID'],'lesson_ID'=>$_POST['lesson_ID'],'topic_ID'=>$_POST['topic_ID'])),array('ID','name AS text'));
					if(!empty($videos))
					{
						foreach ($videos as $key => $value) {
							if(!in_array($value['ID'], $package_IDs))
							{
								$data[] = array('ID'=>$value['ID'],'text'=>$value['text'],'value'=>$_POST['subject_ID'].'^'.$_POST['lesson_ID'].'^'.$_POST['topic_ID'].'^'.$value['ID'].'^'.$_POST['package_ID'].'^video');
							}
						}
					}
					break;

 				default:
 					$data = array();
 					break;
 			}
 			return $data;
 		}

 		public function addtopackage()
 		{
 			$e = explode('^',$_POST['data']);
 			$this->load->model('form_model');
 			$query = $this->form_model->add(array('table'=>'APGD','columns'=>array('subject_ID'=>$e[0],'lesson_ID'=>$e[1],'topic_ID'=>$e[2],'reference_ID'=>$e[3],'package_ID'=>$e[4],'type'=>$e[5])));
 			if($query == true)
 			{
 				return $e[5];
 			}
 			return $query;
 		}

 		public function set_date()
 		{
 			$this->load->model('form_model');
 			$query = $this->form_model->edit(array('table'=>'APGD','columns'=>array('datetime'=>$_POST['datetime']),'where'=>array('ID'=>$_POST['ID'])));
 			return $query;
 		}

 		public function remove_data()
 		{
 			$this->load->model('form_model');
 			$query = $this->form_model->delete(array('APGD'=>array('ID'=>$_POST['ID'])));
 			return $query;
 		}

 		public function update_data()
 		{
 			//print_r($_POST);
 			$query = $this->fetch_model->show(array('APGD'=>$_POST),array('ID','>>subject:>fr>SB>name:ID=^subject_ID^','>>lesson:>fr>LS>name:ID=^lesson_ID^','>>topic:>fr>TP>name:ID=^topic_ID^','reference_ID','type'),array('LIMITS'=>array(1,0),'ORDER'=>array('ID','DESC')));
 			if(!empty($query))
 			{
 				$exp = explode('SK',$query[0]['reference_ID']);
 				$query[0]['reference'] = $this->str_function_library->call('fr>'.$exp[0].'>name:ID=`'.$query[0]['reference_ID'].'`');
 				return $query[0];
 			}
 			return $query;
 		}
	}
?>