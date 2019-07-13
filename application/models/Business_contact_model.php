<?php
	class Business_contact_model extends CI_Model
	{
		public function check($id=NULL,$login_as="Client")
		{
			$user = count($this->fetch_model->show(array('BNC' =>array('ID'=>$id))));
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
				$this->errorlog_library->entry('Business_contact_model > check > argument ID is invalid.');
				redirect('Business_contact/add/');
			}
		}

		public function add_or_edit()
		{

			if(empty($_POST['ID']))
			{
				return $this->add();
			}
			else
			{
				return $this->edit($_POST['ID']);			
			}

		}



		public function add()
		{
			$num_row1 = $_POST['num_row1'];
			$num_row2 = $_POST['num_row2'];	
			
			unset($_POST['num_row1']);
			unset($_POST['num_row2']);

			foreach($_POST as $key => $value)
			{
			    $exp_key = explode('-', $key);
			    if($exp_key[0] == 'PH')
			    {
			         $bt_arr[$exp_key[2]][$exp_key[1]] = $value;
			    	 unset($_POST[$key]);
			    }
			    else if($exp_key[0] == 'AD')
			    {
			         $ad_arr[$exp_key[2]][$exp_key[1]] = $value;
			    	 unset($_POST[$key]);
			    }
			}
			$this->load->model('form_model');
			unset($_POST['ID']);

				$b_add = $this->form_model->add(array("table"=>"BNC","columns"=>$_POST));
				if($b_add === TRUE)
				{
					foreach($bt_arr as $key => $columns)
					{
						$columns['person_ID'] = $this->db_library->find_max_id('BNC');
						$result1 = $this->form_model->add(array("table"=>"PH","columns"=>$columns));
					}

					foreach($ad_arr as $key1 => $columns1)
					{
						$columns1['person_ID'] = $this->db_library->find_max_id('BNC');
						$result = $this->form_model->add(array("table"=>"AD","columns"=>$columns1));
					}

					if($result === true && $result1 === true)
					{
						$id = $this->db_library->find_max_id('BNC');
						return $id;
					}
					else
					{
						return $result;
					}
				}
				else
				{
					return $b_add;
				}
		}

		public function edit($id)
		{
			// print_r($_POST);
			$this->load->model('form_model');

			$num_row1 = $_POST['num_row1'];
			$num_row2 = $_POST['num_row2'];	

			unset($_POST['num_row1']);
			unset($_POST['num_row2']);

			foreach($_POST as $key => $value)
			{
			    $exp_key = explode('-', $key);
			    if($exp_key[0] == 'PH')
			    {
			         $bt_arr[$exp_key[2]][$exp_key[1]] = $value;
			    	 unset($_POST[$key]);
			    }
			    else if($exp_key[0] == 'AD')
			    {
			         $ad_arr[$exp_key[2]][$exp_key[1]] = $value;
			    	 unset($_POST[$key]);
			    }
			}

			$updatePhn=$this->EditMultiaddData($bt_arr,'PH',$id);
			$updateAddr=$this->EditMultiaddData($ad_arr,'AD',$id);
			if ($updatePhn===true && $updateAddr===true) {
				// $prevData=$this->EditData($prevInfo,'PI',$id);
				// $curData=$this->EditData($curInfo,'CI',$id);
				// if ($curData===true && $prevData===true) {
					return $this->updateMainForm($id);
				// }
			}


		}

		public function updateMainForm($id)
		{
			$b_edit = $this->form_model->edit(array("table"=>"BNC","columns"=>$_POST,"where"=>array('ID'=>$id)));
			if($b_edit === TRUE)
			{
				return $id;
			}
			else
			{	
				return $b_edit;
			}
		}

		public function EditData($bt_arr,$tbl,$id)
		{
			$iddd=$bt_arr['ID'];
			unset($bt_arr['ID']);
			$b_add = $this->form_model->edit(array("table"=>$tbl,"columns"=>$bt_arr,"where"=>array('ID'=>$iddd)));
			return $b_add;
		}

		public function EditMultiaddData($bt_arr,$tbl,$id)
		{
			foreach ($bt_arr as $key => $value) {
				if (array_key_exists('ID', $value)){
					$iddd=$value['ID'];
					unset($value['ID']);
					$b_add = $this->form_model->edit(array("table"=>$tbl,"columns"=>$value,"where"=>array('ID'=>$iddd)));
				}
				else
				{
					$value['person_ID']=$id;
					$b_add = $this->form_model->add(array("table"=>$tbl,"columns"=>$value));
				}
			}
			if ($b_add===true) {
				return true;
			}
			else
			{
				return false;
			}
		}

		public function get_details($id=NULL)
		{
			$data = array();
			if(!is_null($id))
			{  
				$data['What'] = 'Edit';               
				$data['View'] = $this->fetch_model->show(array('BNC'=>array('ID'=>$id)));
				if (!empty($data['View']))
				{
					$data['List']['Phone']=$this->fetch_model->show(array('PH'=>array('person_ID'=>$id)));
					$data['List']['Address']=$this->fetch_model->show(array('AD'=>array('person_ID'=>$id)));
					$data['category'] = $data['View'][0]['category_ID'];
					$data['branch'] = $data['View'][0]['branch_ID'];
				}
				// $data['user']=$this->fetch_model->show(array('US'=> array('ID'=>$data['studentDetail'][0]['Added_by'])));
			}
			return $data;
		}

		public function get_data($id=NULL)
		{
			$data = array();
			if (!is_null($id)) 
			{
				$data['Category'] = $this->fetch_model->show('BSC');
				if (!empty($data['Category'])) 
				{
					foreach ($data['Category'] as $key => $value) 
					{
						$data['Category'][$key]['Contact']= $this->fetch_model->show(array('BNC'=>array('category_ID'=>$value['ID'],'branch_ID'=>$id)));
					}
					if (!empty($data['Category'])) 
					{
						foreach ($data['Category'] as $k => $v) 
						{
							if (!empty($v['Contact'])) 
							{
								foreach ($v['Contact'] as $k2 => $v2) 
								{

									$phone = $this->fetch_model->show(array('PH'=>array('person_ID'=>$v2['ID'])));
									if($phone != NULL)
									{
										$ph = '';
										foreach ($phone as $key_ph => $value_ph) {
											$ph .= $value_ph['phone_number'].',';
										}
										$ph = rtrim($ph,',');
										$data['Category'][$k]['Contact'][$k2]['phone']= $ph;
									}
									else
									{
										$data['Category'][$k]['Contact'][$k2]['phone']= 'No Number';
									}
								}	
							}
						}	
					}	
				}
			}
			return $data;
		}

		public function delete_Field($id)
		{
			$this->load->model('form_model');
			if ($id[0]==='P') {
				$result=$this->form_model->delete(array('PH' => array('ID' => $id)));
			}
			else
			{
				$result=$this->form_model->delete(array('AD' => array('ID' => $id)));
			}
			return $result;
		}

		public function get_contact($id=NULL)
		{
			$data = array();
			if (!is_null($id)) 
			{
				$data = $this->fetch_model->show(array('BNC'=>array('ID'=>$id)));
				if (!empty($data)) 
				{
					$category = $this->fetch_model->show(array('BSC'=>array('ID'=>$data[0]['category_ID'])));
					$branch = $this->fetch_model->show(array('BR'=>array('ID'=>$data[0]['branch_ID'])));
					$data[0]['category'] = $category[0]['name'];
					$data[0]['branch'] = $branch[0]['name'];
					$data['List']['Phone']=$this->fetch_model->show(array('PH'=>array('person_ID'=>$id)));
					$data['List']['Address']=$this->fetch_model->show(array('AD'=>array('person_ID'=>$id)));	
				}
			}
			return $data;
		}

	}
	?>