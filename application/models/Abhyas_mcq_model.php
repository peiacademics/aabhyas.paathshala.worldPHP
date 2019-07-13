<?php
	class Abhyas_mcq_model extends CI_Model
	{
		public function check($id=NULL,$login_as="Client")
		{
			$user = count($this->fetch_model->show(array('AM' =>array('ID'=>$id))));
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
				$this->errorlog_library->entry('Abhyas_mcq_model > check > argument ID is invalid.');
				redirect('Abhyas_mcq/add/');
			}
		}

		public function add_or_edit()
		{
			$this->load->model('form_model');
			unset($_POST[0]);
			if(empty($_POST['ID']))
			{
				unset($_POST['ID']);
				$rec_save = array();
				foreach ($_POST as $key => $value) {
					if(strpos($key, '-') != FALSE)
		 			{
		 				$question = explode('-', $key);
		 				if(strpos($question[0], 'SK') != FALSE)
		 				{
		 					$ans = explode('SK', $question[0]);
		 					$rec_save[$question[1]][$ans[1]][$ans[0]] = $value;
		 				}
		 				else
		 				{
		 					$rec_save[$question[1]][0][$question[0]] = $value;
		 				}
		 				unset($_POST[$key]);
		 			}
				}
				$result = $this->form_model->add(array("table"=>"AM","columns"=>$_POST));
				$mcq_ID = $this->db_library->find_max_id('AM');
				$i = 0;
				$cnt = 0;
				if($result == TRUE)
				{
					if(($rec_save != NULL) && !empty($rec_save) && ($rec_save != FALSE))
					{
						foreach ($rec_save as $keyrs => $valuers)
						{
							$i = 0;
							$cnt = count($valuers);
							foreach ($valuers as $key1 => $value1)
							{
								if($key1 == '0')
								{
									$question = $this->form_model->add(array("table"=>"AMQ","columns"=>array("question"=>$value1['question'],"question_path"=>$value1['question_path'],"type"=>$value1['type'],"mcq_ID"=>$mcq_ID,'correct_marks'=>$value1['correct_marks'],'blank_marks'=>$value1['blank_marks'],'wrong_marks'=>$value1['wrong_marks'],'explanation'=>$value1['explanation'])));
									if($question == TRUE)
									{
										$question_ID = $this->db_library->find_max_id('AMQ');
										$i++;
									}
								}
								else
								{
									if(array_key_exists('correct', $value1) == TRUE)
									{
										$value1['correct'] = 'yes';
									}
									else
									{
										$value1['correct'] = 'no';
									}
									$ans = $this->form_model->add(array("table"=>"AMA","columns"=>array("question_ID"=>$question_ID,"correct"=>$value1['correct'],"answer"=>@$value1['answer'],"ans_path"=>@$value1['ans_path'],"order_seq"=>@$value1['order_seq'])));
									$i++;
								}
							}
						}
					}
					else
					{
						$result = FALSE;
					}
					if(($i == $cnt) && ($i > 0) && ($cnt > 0)) 
					{
						$result = TRUE;
					}
					else
					{
						$result = FALSE;
					}
				}
				else
				{
					$result = FALSE;
				}
			}
			else
			{
				$mcq_ID = $_POST['ID'];
				$rec_save = array();
				foreach ($_POST as $key => $value) {
					if(strpos($key, '-') != FALSE)
		 			{
		 				$question = explode('-', $key);
		 				if(strpos($question[0], 'SK') != FALSE)
		 				{
		 					$ans = explode('SK', $question[0]);
		 					$rec_save[$question[1]][$ans[1]][$ans[0]] = $value;
		 				}
		 				else
		 				{
		 					$rec_save[$question[1]][0][$question[0]] = $value;
		 				}
		 				unset($_POST[$key]);
		 			}
				}
				$result = $this->form_model->edit(array("table"=>"AM","columns"=>$_POST,"where"=>array('ID'=>$_POST['ID'])));
				$cnt = 0;
				$i = 0;
				if($result == TRUE)
				{
					if(($rec_save != NULL) && !empty($rec_save) && ($rec_save != FALSE))
					{
						foreach ($rec_save as $keyrs => $valuers)
						{
							$i = 0;
							$cnt = count($valuers);
							foreach ($valuers as $key1 => $value1)
							{
								if($key1 == '0')
								{
									if(empty($value1['ID']))
									{
										$question = $this->form_model->add(array("table"=>"AMQ","columns"=>array("question"=>$value1['question'],"question_path"=>$value1['question_path'],"type"=>$value1['type'],"mcq_ID"=>$mcq_ID,'correct_marks'=>$value1['correct_marks'],'blank_marks'=>$value1['blank_marks'],'wrong_marks'=>$value1['wrong_marks'],'explanation'=>$value1['explanation'])));
										$question_ID = $this->db_library->find_max_id('AMQ');
									}
									else
									{
										$question = $this->form_model->edit(array("table"=>"AMQ","columns"=>array("question"=>$value1['question'],"question_path"=>$value1['question_path'],"type"=>$value1['type'],"mcq_ID"=>$_POST['ID'],'correct_marks'=>$value1['correct_marks'],'blank_marks'=>$value1['blank_marks'],'wrong_marks'=>$value1['wrong_marks'],'explanation'=>$value1['explanation']),"where"=>array('ID'=>$value1['ID'])));
										$question_ID = $value1['ID'];
									}
									if($question == TRUE)
									{
										$i++;
									}
								}
								else
								{
									if(array_key_exists('correct', $value1) == TRUE)
									{
										$value1['correct'] = 'yes';
									}
									else
									{
										$value1['correct'] = 'no';
									}
									if(empty($value1['ID']))
									{
										$ans = $this->form_model->add(array("table"=>"AMA","columns"=>array("question_ID"=>$question_ID,"correct"=>$value1['correct'],"answer"=>$value1['answer'],"ans_path"=>$value1['ans_path'],"order_seq"=>@$value1['order_seq'])));
									}
									else
									{
										$ans = $this->form_model->edit(array("table"=>"AMA","columns"=>array("question_ID"=>$question_ID,"correct"=>$value1['correct'],"answer"=>$value1['answer'],"ans_path"=>$value1['ans_path'],"order_seq"=>@$value1['order_seq']),"where"=>array('ID'=>$value1['ID'])));
									}
									if($ans == TRUE)
									{
										$i++;
									}
								}
							}
						}
					}
					else
					{
						$result = FALSE;
					}
					if(($i == $cnt) && ($i > 0) && ($cnt > 0)) 
					{
						$result = TRUE;
					}
					else
					{
						$result = FALSE;
					}
				}
				else
				{
					$result = FALSE;
				}
			}				
			if($result === TRUE)
			{
				echo 1;
			}
			else
			{
				echo json_encode($result);
			}
		}

		public function get_show_data($input,$output)
		{
		 	$this->load->library('datatable_library');
	 		return $this->datatable_library->get_data($input,$output);
		}

		public function upload_Q()
	    {
	       	if((!empty($_FILES)))
	    	{
	    		if(($_FILES['file']['type'] === "image/jpg") || ($_FILES['file']['type'] === "image/png") || ($_FILES['file']['type'] === "image/jpeg") || ($_FILES['file']['type'] === "image/gif"))
	    		{
					$new_name = str_replace(" ", "-", time().md5($_FILES["file"]['name']).'.'.$ext[count($ext)-1]);
			        $config['upload_path']          = './abhyas_questions_upload/';
			        $config['allowed_types']        = '*';
			        $config['max_size']             = '1000000';
					$config['file_name'] = $new_name;
			        $this->load->library('upload', $config);
			        $this->upload->initialize($config);
			        if (!$this->upload->do_upload('file'))
			        {
			        	echo json_encode($this->upload->display_errors());
			        }
			        else
			        {
			        	$this->load->model('form_model');
			        	$file_name = $new_name;
			        	$path = 'abhyas_questions_upload/'.$file_name;
			        	return $path;
			        }
			    }
			    else
			    {
			    	return false;
			    }
		    }
		    else{
		    	return false;
		    }
	    }

	    public function upload_A()
	    {
	       	if((!empty($_FILES)))
	    	{
	    		if(($_FILES['file']['type'] === "image/jpg") || ($_FILES['file']['type'] === "image/png") || ($_FILES['file']['type'] === "image/jpeg") || ($_FILES['file']['type'] === "image/gif"))
	    		{
					$new_name = str_replace(" ", "-", time().md5($_FILES["file"]['name']).'.'.$ext[count($ext)-1]);
			        $config['upload_path']          = './abhyas_answers_upload/';
			        $config['allowed_types']        = '*';
			        $config['max_size']             = '1000000';
					$config['file_name'] = $new_name;
			        $this->load->library('upload', $config);
			        $this->upload->initialize($config);
			        if (!$this->upload->do_upload('file'))
			        {
			        	echo json_encode($this->upload->display_errors());
			        }
			        else
			        {
			        	$this->load->model('form_model');
			        	$file_name = $new_name;
			        	$path = 'abhyas_answers_upload/'.$file_name;
			        	return $path;
			        }
			    }
			    else
			    {
			    	return false;
			    }
		    }
		    else{
		    	return false;
		    }
	    }

	    public function get_details($id = NULL)
	    {
	    	$data = array();
	    	$rec_mcq = $this->fetch_model->show(array('AM'=>array('ID'=>$id)));
	    	$data = $rec_mcq[0];
	    	$rec_q = $this->fetch_model->show(array('AMQ'=>array('mcq_ID'=>$id)));
	    	$data['question'] = $rec_q;
	    	foreach ($rec_q as $key => $value) {
		    	$data['question'][$key]['answer'] = $this->fetch_model->show(array('AMA'=>array('question_ID'=>$value['ID'])));
	    	}
	    	return $data;
	    }

	    public function delete($item_id = NULL)
	 	{
	 		$this->load->model('form_model');
	 		$mcq_questions = $this->fetch_model->show(array('AMQ'=>array('mcq_ID'=>$item_id)));
	 		$delete_data = $this->form_model->delete(array('AM' => array('ID' => $item_id)));
			if($delete_data == TRUE)
	 		{
	 			$cnt = count($mcq_questions);
	 			$i = 0;
	 			foreach ($mcq_questions as $key => $value)
	 			{
	 				$delete_ans = $this->form_model->delete(array('AMA'=>array('question_ID'=>$value['ID'])));
	 				$delete_q = $this->form_model->delete(array('AMQ'=>array('ID'=>$value['ID'])));
	 				if(($delete_ans == TRUE) && ($delete_q == TRUE))
	 				{
	 					$i++;
	 				}
	 			}
	 			if($cnt == $i)
	 			{
	 				return TRUE;
	 			}
	 			else
	 			{
	 				return FALSE;
	 			}
			}
			else
			{
				return FALSE;
			}
	 	}

	 	public function delete_question($item_id = NULL)
	 	{
	 		$this->load->model('form_model');
	 		$delete_ans = $this->form_model->delete(array('AMA'=>array('question_ID'=>$item_id)));
	 		$delete_q = $this->form_model->delete(array('AMQ'=>array('ID'=>$item_id)));
	 		if(($delete_ans == TRUE) && ($delete_q == TRUE))
	 		{
	 			return TRUE;
	 		}
	 		else
	 		{
	 			return FALSE;
	 		}
	 	}

	 	public function delete_answer($item_id = NULL)
	 	{
	 		$this->load->model('form_model');
	 		$delete_ans = $this->form_model->delete(array('AMA'=>array('ID'=>$item_id)));
			return $delete_ans;
	 	}

	 	public function check_duplicate($new_rec = NULL)
	    {
	    	$entries = $this->fetch_model->show('AM');
	    	$duplicate = 'No';
	    	foreach ($entries as $key_en => $value_en)
	    	{
	    		if(($value_en['subject_ID'] == $new_rec['subject_ID']) && ($value_en['lesson_ID'] == $new_rec['lesson_ID']) && ($value_en['topic_ID'] == $new_rec['topic_ID']))
	    		{
	    			$duplicate = 'Yes';
	    		}
	    	}
	    	return $duplicate;
	    }

	    public function print_details($id = NULL)
	    {
	    	$rec = $this->fetch_model->show(array('AM'=>array('ID'=>$id)));
	    	$mcq = $rec[0];
	    	$mcq['questions'] = $this->fetch_model->show(array('AMQ'=>array('mcq_ID'=>$id)));
	    	foreach ($mcq['questions'] as $key => $value)
	    	{
	    		$mcq['questions'][$key]['answers'] = $this->fetch_model->show(array('AMA'=>array('question_ID'=>$value['ID'])));
	    	}
	    	return $mcq;
	    }
	}
?>