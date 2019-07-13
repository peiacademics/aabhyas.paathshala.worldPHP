<?php
	class Centerandinventory_model extends CI_Model
	{
		public function check($id=NULL,$login_as="Client")
		{
			$user = count($this->fetch_model->show(array('IT' =>array('ID'=>$id))));
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
				$this->errorlog_library->entry('Centerandinventory_model > check > argument ID is invalid.');
				redirect('Centerandinventory/add/');
			}
		}

		public function add_or_edit()
		{
			$this->load->model('form_model');
			$item = array();
			if(!empty($_POST))
			{
				foreach ($_POST as $key => $value)
	 			{
	 				if(strpos($key, '-') !== FALSE)
	 				{
	 					$recs = explode('-', $key);
	 					$item[$recs[1]][$recs[0]] = $value;
	 					unset($_POST[$key]);
	 				}
	 			}
				if(empty($_POST['ID']))
				{
					unset($_POST['ID']);
					$result = $this->add($_POST,$item);
				}
				else
				{
					$result = $this->edit($_POST,$item);
				}
			}
			else
			{
				$result = FALSE;
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

		public function delete($item_id = NULL)
	 	{
	 		$this->load->model('form_model');
	 		$delete_item = $this->form_model->delete(array('IT' => array('ID' => $item_id)));
			if($delete_item == TRUE)
	 		{
	 			$delete_item_det = $this->form_model->delete(array('ITI'=>array('item_ID'=>$item_id)));
 				return $delete_item_det;
			}
			else
			{
				return FALSE;
			}
	 	}

	 	public function add($record = NULL, $item = NULL)
	 	{
	 		$this->load->model('form_model');
	 		if(($record != NULL) && !empty($record))
	 		{
	 			$item_master = $this->form_model->add(array("table"=>"IT","columns"=>$record));
	 			$max_item = $this->db_library->find_max_id('IT');
	 			if($item_master == TRUE)
	 			{
	 				$cnt = count($item);
	 				$i = 0;
	 				if(($item != NULL) && !empty($item))
	 				{
	 					foreach ($item as $key1 => $value1)
	 					{
	 						$value1['item_ID'] = $max_item;
	 						if($value1['ID'] == NULL)
	 						{
	 							unset($value1['ID']);
	 						}
	 						$item_add = $this->form_model->add(array("table"=>"ITI","columns"=>$value1));
	 						if($item_add == TRUE)
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

	 	public function edit($record = NULL, $item = NULL)
	 	{
	 		$this->load->model('form_model');
	 		if(($record != NULL) && !empty($record))
	 		{
	 			$item_master = $this->form_model->edit(array("table"=>"IT","columns"=>$record,"where"=>array('ID'=>$record['ID'])));
	 			$max_item = $record['ID'];
	 			if($item_master == TRUE)
	 			{
	 				$cnt = count($item);
	 				$i = 0;
	 				if(($item != NULL) && !empty($item))
	 				{
	 					foreach ($item as $key1 => $value1)
	 					{
	 						$value1['item_ID'] = $max_item;
	 						if(empty($value1['ID']))
	 						{
	 							unset($value1['ID']);
	 							$item_add = $this->form_model->add(array("table"=>"ITI","columns"=>$value1));
	 						}
	 						else
	 						{
	 							$item_add = $this->form_model->edit(array("table"=>"ITI","columns"=>$value1,"where"=>array('ID'=>$value1['ID'])));
	 						}
	 						if($item_add == TRUE)
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

	 	public function get_details($id = NULL)
	 	{
	 		$item = $this->fetch_model->show(array('IT'=>array('ID'=>$id)));
	 		$record = $item[0];
	 		$record['serial_nos'] = $this->fetch_model->show(array('ITI'=>array('item_ID'=>$id)));
	 		return $record;
	 	}

	}
?>