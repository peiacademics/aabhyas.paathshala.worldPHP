<?php
	class Abhyas_video_model extends CI_Model
	{
		public function check($id=NULL,$login_as="Client")
		{
			$user = count($this->fetch_model->show(array('AV' =>array('ID'=>$id))));
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
				$this->errorlog_library->entry('Abhyas_video_model > check > argument ID is invalid.');
				redirect('Abhyas_video/add/');
			}
		}

		public function add_or_edit()
		{
			$this->load->model('form_model');
			if(!empty($_POST['video_ID']))
			{
				if(empty($_POST['ID']))
				{
					unset($_POST['ID']);
					$result = $this->form_model->add(array("table"=>"AV","columns"=>$_POST));
				}
				else
				{
					$result = $this->form_model->edit(array("table"=>"AV","columns"=>$_POST,"where"=>array('ID'=>$_POST['ID'])));
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

		public function upload_video()
	    {
	       	if(!empty($_FILES))
	    	{
	    		if(($_FILES['file']['type'] == "video/mp4") || ($_FILES['file']['type'] == "video/avi") || ($_FILES['file']['type'] == "video/mov") || ($_FILES['file']['type'] == "video/3gp") || ($_FILES['file']['type'] == "video/mpeg") || ($_FILES['file']['type'] == "video/flv"))
	    		{
	    			$ext = explode('.',$_FILES["file"]['name']);
					$new_name = str_replace(" ", "-", time().md5($_FILES["file"]['name']).'.'.$ext[count($ext)-1]);
			        $config['upload_path']          = '../aabhyas/abhyas_video_upload/';
			        $config['allowed_types']        = '*';
			        $config['max_size']             = '1000000000000';//1000000
					$config['file_name'] = $new_name;
			        $this->load->library('upload', $config);
			        $this->upload->initialize($config);
			        if (!$this->upload->do_upload('file'))
			        {
			        	echo json_encode($this->upload->display_errors());
			        }
			        else
			        {
			        	$config1['upload_path']          = './abhyas_video_upload/';
				        $config1['allowed_types']        = '*';
				        $config1['max_size']             = '1000000000000';//1000000
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
				        	$path = 'abhyas_video_upload/'.$file_name;
				        	if($this->form_model->add(array('table'=>'AVU','columns'=>array('path'=>'abhyas_video_upload/'.$file_name))))
				        	{
				        		return $this->db_library->find_max_id('AVU');
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

	    public function view_video($id = NULL)
	    {
	    	$video = $this->str_function_library->call('fr>AV>video_ID:ID=`'.$id.'`');
	    	$path = $this->str_function_library->call('fr>AVU>path:ID=`'.$video.'`');
	    	return $path;
	    }

	    public function check_duplicate($new_rec = NULL)
	    {
	    	$entries = $this->fetch_model->show('AV');
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