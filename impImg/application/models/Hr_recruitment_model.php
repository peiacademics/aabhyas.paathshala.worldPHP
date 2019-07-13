<?php
	class Hr_recruitment_model extends CI_Model
	{
		public function check($id=NULL,$login_as="Client")
		{
			$user = count($this->fetch_model->show(array('HR' =>array('ID'=>$id))));
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
				$this->errorlog_library->entry('Hr_recruitment_model > check > argument ID is invalid.');
				redirect('hr_recruitment/add/');
			}
		}

		public function add_or_edit()
		{
			$this->load->model('form_model');
			$_POST['phone'] = '';
			$_POST['email'] = '';
			unset($_POST['num_row1']);
			unset($_POST['num_row2']);
			foreach ($_POST as $key => $value) {
				if(strpos($key,'phone-') !== FALSE)
				{
					$_POST['phone'] = $_POST['phone'].$value.',';
					unset($_POST[$key]);
				}
				if(strpos($key,'email-') !== FALSE)
				{
					$_POST['email'] = $_POST['email'].$value.',';
					unset($_POST[$key]);
				}
			}
			if(empty($_POST['ID']))
			{
				unset($_POST['ID']);
				$result = $this->form_model->add(array("table"=>"HR","columns"=>$_POST));
			}
			else
			{
				$result = $this->form_model->edit(array("table"=>"HR","columns"=>$_POST,"where"=>array('ID'=>$_POST['ID'])));
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

		public function delete_Field()
		{
			$this->load->model('form_model');
			if ($_POST['type'] == 'phone')
			{
				$phone = $this->str_function_library->call('fr>HR>phone:ID=`'.$_POST['ID'].'`');
				$phone = str_replace($_POST['value'].',',"",$phone);
				$result = $this->form_model->edit(array("table"=>"HR","columns"=>array('phone'=>$phone),"where"=>array('ID'=>$_POST['ID'])));
			}
			else
			{
				$email = $this->str_function_library->call('fr>HR>email:ID=`'.$_POST['ID'].'`');
				$email = str_replace($_POST['value'].',',"",$email);
				$result = $this->form_model->edit(array("table"=>"HR","columns"=>array('email'=>$email),"where"=>array('ID'=>$_POST['ID'])));
			}
			return $result;
		}

		public function get_filter_data($id=NULL)
		{
			$data = array();
			$tbl = $this->db_library->get_tbl('HR');
			$this->db->select('city');
			$this->db->distinct();
			$query = $this->db->get($tbl);
			$data['city'] = $query->result_array();
			$this->db->select('area');
			$this->db->distinct();
			$query = $this->db->get($tbl);
			$data['area'] = $query->result_array();
			$data['designation'] = $this->fetch_model->show('TT',array('ID','title'));
			$nk = array();
			return $data;
		}

		public function get_filtered_resumes($id=NULL)
		{
			$data = array();
			$where['dept_ID LIKE '] = '%'.$_POST['designation'].'%';
			if(!empty($_POST['area']))
			{
				$where['area'] = $_POST['area'];
			}
			if(!empty($_POST['city']))
			{
				$where['city'] = $_POST['city'];
			}
			if(!empty($_POST['gender']))
			{
				$where['gender'] = $_POST['gender'];
			}
			$data = $this->fetch_model->show(array('HR'=>$where),array('ID','name','phone','address','email','gender','area','city','dob','>>designation:>fr>TT>title:ID=^dept_ID^'));
			if(!empty($_POST['detail']))
			{
				foreach ($data as $key => $value) {
					if((strrpos($value['name'],$_POST['detail']) === FALSE) && (strrpos($value['phone'],$_POST['detail']) === FALSE) && (strrpos($value['email'],$_POST['detail']) === FALSE))
					{
						unset($data[$key]);
					}
				}
			}
			foreach ($data as $key1 => $value1) {
				$data[$key1]['link'] = '<div><a class="label label-primary" href="'.base_url("Hr_recruitment/add/".$value1['ID']).'"><i class="fa fa-pencil bigger-130"></i></a>&nbsp;&nbsp;<span class="label label-success" onclick="message(\''.$value1['ID'].'\',\''.$value1['name'].'\')"><i class="fa fa-comment bigger-130"></i></span>&nbsp;&nbsp;<span class="label label-danger red" id="item'.$value1['ID'].'" onclick="deletef(\''.$value1['ID'].'\',\''.base_url("Hr_recruitment/delete/".$value1['ID']).'\')"><i class="fa fa-trash-o bigger-130"></i></span>&nbsp;&nbsp;</div>';
			}
			return $data;
		}

		public function send_message()
		{
			$this->load->model('form_model');
			$this->load->library('email');
			$_POST['resume_ID'] = $_POST['ID'];
			unset($_POST['ID']);
			if($_POST['message_type'] === 'email')
			{
				$emails = $this->str_function_library->call('fr>HR>email:ID=`'.$_POST['resume_ID'].'`');
				$emails = rtrim($emails,',');
				$addData = $this->form_model->add(array("table"=>"HRM","columns"=>$_POST));
				if($addData)
				{
					// var_dump($emails);
					$this->sendEmails($emails,$_POST['message']);
					return true;
				}
			}
			elseif(($_POST['message_type'] === 'mobile') || ($_POST['message_type'] === 'gateway'))
			{
				$numners = $this->str_function_library->call('fr>HR>phone:ID=`'.$_POST['resume_ID'].'`');
				$numners = rtrim($numners,',');
				$addData = $this->form_model->add(array("table"=>"HRM","columns"=>$_POST));
				if ($addData)
				{
					if(strpos($numners,',') === FALSE)
					{
						return array('types'=>$_POST['message_type'],'data'=>$numners);
					}
					else
					{
						return array('types'=>$_POST['message_type'],'data'=>implode(',', $numners));
					}
				}
				else
				{
					return false;
				}
			}
			else
			{
				// Comming soon
			}
		}

		public function sendEmails($emails,$msgs)
		{
			// foreach ($emails as $key => $value) {
			// var_dump($emails);
				$Edata['Msg'] = $msgs;
				$Edata['time'] = date("Y-m-d H:i:s");
				$config = array(
					'protocol' => 'smtp',
					'smtp_host' => 'mail.skyq.in',
					'smtp_port' => 587,
					'smtp_user' => 'pawan@skyq.in',
					'smtp_pass' => 'pawan@12345',
					'mailtype'  => 'html',
				);
				$this->email->initialize($config);
	        	$this->email->from('hr@paathshala.in','Paathshala');
		   		$save = $this->load->view('messages/comunication_msg',$Edata,TRUE);
	        	$this->email->subject('Welcome to Paathshala.');
	        	$this->email->message($save);
				$this->email->to($emails);
				if($this->email->send())
				{
					// echo "done";
				}
				else
				{
					// echo "flase";
				}
			// }
		}

	}
?>