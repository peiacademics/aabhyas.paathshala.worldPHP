<?php
	class Client_model extends CI_Model{
		public function check($id=NULL,$login_as="Client")
		{
			$user = count($this->fetch_model->show(array('CL' =>array('ID'=>$id))));
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
				redirect('clients/add/');
			}
		}

		public function add_or_edit()
		{
			$this->load->model('form_model');
			if(empty($_POST['ID']))
			{
				unset($_POST['ID']);
				$result = $this->form_model->add(array("table"=>"CL","columns"=>$_POST));
				if($result)
				{
					//print_r($_POST);
					$data = array('Type'=>'Client','Name'=>$_POST['Client_name'],'Email'=>$_POST['Email'],'Password'=>'12345');
					$result = $this->form_model->add(array("table"=>"US","columns"=>$data));
				}
			}
			else
			{
				unset($_POST['Email']);
				$result = $this->form_model->edit(array("table"=>"CL","columns"=>$_POST,"where"=>array('ID'=>$_POST['ID'])));
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
	 		/*$fetch_data = $this->fetch_model->show('CL',array('Client_name','Company_name','Email','Address','Contact_no','ID'));
			if(empty($fetch_data))
			{
				return array("aaData"=>array());
		 	}
		 	else
		 	{
		 		foreach($fetch_data as $key => $value)
		 		{
		 			$fetch_data[$key]['Links'] = "<div><span class='blue' onClick=view('".$value['ID']."')><i class='fa fa-eye bigger-130'></i></span>&nbsp;&nbsp;<a class='green' href=".base_url('clients/add/'.$value['ID'])."><i class='fa fa-pencil bigger-130'></i></a>&nbsp;&nbsp;<a class='red' id='item".$value['ID']."' href=".base_url('clients/delete/'.$value['ID'])."><i class='fa fa-trash-o bigger-130'></i></a></div><script type='text/javascript'>
				        $(document).ready(function() {
			        	    $('#item".$value['ID']."').on('click',function(e){
			        	    	e.preventDefault();
						        var href = $('#item".$value['ID']."').attr('href');
						        bootbox.confirm('Are you sure you want to delete?', function(result) {
							       	if (result == true) {
							        	window.location.href = href;
								    }
								    else
								    {
								    	e.preventDefault();
								    }
							    });
						    });
				        });
				        </script>";
		 			unset($fetch_data[$key]['ID']);
		 		}

		 		return array("aaData"=>$fetch_data);
		 	}*/
		 	$this->load->library('datatable_library');
	 		return $this->datatable_library->get_data($input,$output);
		}
	}
?>