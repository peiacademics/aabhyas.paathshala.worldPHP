<?php
	class Abhyas_pdf_model extends CI_Model
	{
		public function check($id=NULL,$login_as="Client")
		{
			$user = count($this->fetch_model->show(array('AP' =>array('ID'=>$id))));
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
				$this->errorlog_library->entry('Abhyas_pdf_model > check > argument ID is invalid.');
				redirect('Abhyas_pdf/add/');
			}
		}

		public function add_or_edit()
		{
			$this->load->model('form_model');
			if(!empty($_POST['pdf_ID']))
			{
				if(empty($_POST['ID']))
				{
					unset($_POST['ID']);
					$result = $this->form_model->add(array("table"=>"AP","columns"=>$_POST));
				}
				else
				{
					$result = $this->form_model->edit(array("table"=>"AP","columns"=>$_POST,"where"=>array('ID'=>$_POST['ID'])));
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
			else
			{
				echo 2;
			}
		}

		public function get_show_data($input,$output)
		{
		 	$this->load->library('datatable_library');
	 		return $this->datatable_library->get_data($input,$output);
		}

		public function upload_pdf()
	    {
	       	if((!empty($_FILES)))
	    	{
	    		if($_FILES['file']['type'] === "application/pdf")
	    		{
	    			$ext = explode('.',$_FILES["file"]['name']);
					$new_name = str_replace(" ", "-", time().md5($_FILES["file"]['name']).'.'.$ext[count($ext)-1]);
			        $config['upload_path']          = '../aabhyas/abhyas_pdf_upload/';
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
			        	$config1['upload_path']          = './abhyas_pdf_upload/';
				        $config1['allowed_types']        = '*';
				        $config1['max_size']             = '1000000';
						$config1['file_name'] = $new_name;
				        $this->load->library('upload', $config1);
				        $this->upload->initialize($config1);
				        if (!$this->upload->do_upload('file'))
				        {
				        	echo json_encode($this->upload->display_errors());
				        }
				        else
				        {
				        	$this->load->model('form_model');
				        	$file_name = $new_name;
				        	$path = 'abhyas_pdf_upload/'.$file_name;
				        	if($this->form_model->add(array('table'=>'ASS','columns'=>array('path'=>'abhyas_pdf_upload/'.$file_name))))
				        	{
				        		return $this->db_library->find_max_id('ASS');
				        	}
				        	else{
				        		return false;
				        	}
				        }
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

	    public function check_duplicate($new_rec = NULL)
	    {
	    	$entries = $this->fetch_model->show('AP');
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

	}
?>