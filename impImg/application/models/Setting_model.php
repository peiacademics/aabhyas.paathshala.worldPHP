<?php
	class Setting_model extends CI_Model
	{

		public function check($id=NULL,$login_as="Client")
		{
			$user = count($this->fetch_model->show(array('ES' =>array('ID'=>$id))));
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
				$this->errorlog_library->entry('Product_model > check > argument id is invalid.');
				redirect('product/add/');
			}
		}

		function change_password($old=NULL,$new=NULL,$confirm=NULL)
		{
			if(!is_null($old) && !is_null($new) && !is_null($confirm))
			{
				if(!empty($old) && !empty($new) && !empty($confirm))
				{	
					$table = $this->db_library->get_tbl('US');
					$this->db->select('Password');
					$query = $this->db->get_where($table,array("Status"=>"A","ID"=>$this->session_library->get_session_data('ID')));
					if($query->num_rows() > 0)
					{
						$result = $query->row();
						$password = $result->Password;
						if($old===$password && $new === $confirm)
			            { 
			            	$update = array(
			            		'Password' => $confirm
			            	);
			            	$this->db->where(array('ID'=>$this->session_library->get_session_data('ID'),'Status'=>'A'));
							$this->db->update($table,$update); 
							return TRUE;
			            }
			             else if($old!==$password)
			            {
			            	return array('er_old' => 'Please enter valid current password');
			            }
			            else if($new !== $confirm)
			            {
			            	return array('er_new' => 'New password does not match to Confirm password field.');
			            }
				         else 
				        {
			             	return array('er_old' => 'Please enter all fields');
			            }	
			        }
			        else
			        {
			        	return array('er_old' => 'Please enter valid current password.'); 
			        } 
			    }
			    else{
			    	return array('er_old' => 'Please enter all fields');
			    }    
		    }       
		}

		public function send_mail($data)
		{
			$my_config = $this->config->item('skyq');
			$from = $data['Login']['Email'];
			$name = $data['Login']['Name'];
			$subject = $this->input->post('subject');
			$to = 'pawan@skyq.in';
			$config = $my_config['email_config'];
	   		$msg = $this->input->post('query');
			$this->load->library('email',$config);
			$this->email->from($from, $name);
			$this->email->to($to);
			$this->email->subject($subject);
			$this->email->message($msg);
			if($this->email->send())
			{
				return TRUE;
			}
			else
			{
				return show_error($this->email->print_debugger());
			}
		}

		public function get_menus($data,$my_config)
		{
			$this->load->library('encrypt');
			$login_as = $data['Login']['Login_as'];
 			$dir = APPPATH.$my_config['app_log_directory'].'/'.underscore($login_as).$my_config['log_file_extension'];
	            $d = read_file($dir);
	        $this->load->library('encrypt');
          	$d = $this->encrypt->decrypt_string($d,$my_config['app_ie']);
          	$d = json_decode($d);
          	$d = $this->objToArray($d);
          	return is_null($d) ? $this->config->item(ucfirst(underscore($login_as).'_menu')):$d;
		}

		public function  objToArray($json_object, &$arr=NULL)
		{
			if(!is_object($json_object) && !is_array($json_object)){
		        $arr = $json_object;
		        return $arr;
		    }

		    foreach ($json_object as $key => $value)
		    {
		        if (!empty($value))
		        {
		            $arr[$key] = array();
		            $this->objToArray($value, $arr[$key]);
		        }
		        else
		        {
		            $arr[$key] = $value;
		        }
		    }
		    return $arr;
		}

		public function update_menu_orders($d,$my_config)
		{
			$json_object = array(
			/*array('title'=>"Dashboard",
				'icon'=>"dashboard",
				'link'=> "dashboard"),*/
			array(
				'title'=>"Paathshala",
				'icon'=>"university",
				'link'=> "#",
				'children'=>array(
					array(
						'title'=>"Finance Accounting",
						'icon'=>"credit-card",
						'link'=> "Transaction"),
					array('title'=>"Marketing Telecalling",
						'icon'=>"mobile",
						'link'=> "report/call"),
					//array('title'=>"Content Packages",
						// 'icon'=>"database",
						// 'link'=> "Content_packages/view"),
					/*array('title'=>"Drive",
						'icon'=>"info-circle",
						'link'=> "Drive/view"),*/
					array('title'=>"Business Contacts",
						'icon'=>"phone",
						'link'=> "Business_contact"),
					array('title'=>"CCTV",
						'icon'=>"video-camera",
						'link'=> "CCTV/view"),
					array('title'=>"HR Recruitment",
						'icon'=>"male",
						'link'=> "HR_recruitment/view"),
					array('title'=>"Masters",
						'icon'=>"info-circle",
						'link'=> "settings"),
					array('title'=>"Abhyas",
						'icon'=>"graduation-cap",
						'link'=> "#",
						'children'=>array(
							array('title'=>"Masters",
							'icon'=>"star-o",
							'link'=> "#",
							'children'=>array(
									array('title'=>"Lesson",
									'icon'=>"file-o",
									'link'=> "Lesson"),
									array('title'=>"Topic",
									'icon'=>"file-text-o",
									'link'=> "Topic")
								),
							),
							array('title'=>"MCQ",
							'icon'=>"question-circle",
							'link'=> "Abhyas_mcq"),
							array('title'=>"PDF",
							'icon'=>"file-pdf-o",
							'link'=> "Abhyas_pdf"),
							array('title'=>"Video",
							'icon'=>"file-video-o",
							'link'=> "Abhyas_video"),
							array('title'=>"Packages",
							'icon'=>"suitcase",
							'link'=> "package")
						),
					),
					array('title'=>"Website",
						'icon'=>"exclamation",
						'link'=> "#",
						'children'=>array(
							array('title'=>"Content Packages",
							'icon'=>"database",
							'link'=> "Content_packages/view"),
							array('title'=>"Updated Website",
							'icon'=>"sitemap",
							'link'=> "Updated_website/view")
						),
					),//"Masters/view"
				)
			),
			array(
				'title'=>"Thane Paathshala",
				'icon'=>"graduation-cap",
				'link'=> "#",
				'children'=>array(
					array(
						'title'=>"Attendance",
						'icon'=>"check-circle-o",
						'link'=> "Attendance/branchAttendance/BRSK10000001"),
					array('title'=>"Batch",
						'icon'=>"book",
						'link'=> "batch/show/BRSK10000001"),
					array('title'=>"Students",
						'icon'=>"male",
						'link'=> "#",
						'children'=>array(
							array(
								'title'=>"Students Profile",
								'icon'=>"male",
								'link'=> "student/show/BRSK10000001"),
							array('title'=>"Assignments",
								'icon'=>"check-circle",
								'link'=> "assignment/index/BRSK10000001"),
							array(
								'title'=>"Tests",
								'icon'=>"file-text",
								'link'=> "test/index/BRSK10000001"),
							array('title'=>"Messages",
								'icon'=>"comment",
								'link'=> "student/message/BRSK10000001"),
							array(
								'title'=>"Email",
								'icon'=>"envelope-o",
								'link'=> "student/email/BRSK10000001"),
							array('title'=>"App Notifications",
								'icon'=>"bell",
								'link'=> "student/app_notifications/BRSK10000001"),
							array(
								'title'=>"Student Notice Board",
								'icon'=>"exclamation-circle",
								'link'=> "student_notice/index/BRSK10000001"),
							array('title'=>"Remarks",
								'icon'=>"bars",
								'link'=> "student_remark/index/BRSK10000001"),
							array(
								'title'=>"Chat-Room",
								'icon'=>"comments",
								'link'=> "student/chat_room/BRSK10000001"),
							/*array('title'=>"Doubts",
								'icon'=>"question",
								'link'=> "student/doubt/BRSK10000001"),*/
							array('title'=>"Parent Meeting",
								'icon'=>"child",
								'link'=> "parent_meeting/index/BRSK10000001"),
							array('title'=>"Counselling Session",
								'icon'=>"comment",
								'link'=> "counseling_session/index/BRSK10000001"),
							array('title'=>"Syllabus Coverage",
								'icon'=>"file-text-o",
								'link'=> "syllabus_coverage/index/BRSK10000001"),
							),
						),
					array('title'=>"Professors",
						'icon'=>"user",
						'link'=> "#",
						'children'=>array(
							array('title'=>"List",
								'icon'=>"info-circle",
								'link'=> "team/lists/BRSK10000001"),
							array('title'=>'Doubts',
								'icon'=>'info-circle',
								'link'=>'team/raised_doubts/BRSK10000001'),
							array('title'=>"Tasks",
								'icon'=>"tasks",
								'link'=> "#",
								'children'=>array(
									array('title'=>"Major Tasks",
										'icon'=>"folder-open",
										'link'=> "task/index/BRSK10000001"),
									array('title'=>"Calendar Tasks",
										'icon'=>"calendar",
										'link'=> "task/calendar_task/BRSK10000001")
								),
								),
							array('title'=>"Employee Notice Board",
								'icon'=>"exclamation",
								'link'=> "employee_notice/index/BRSK10000001"),
							array('title'=>"Student Syllabus Coverage",
								'icon'=>"file-text-o",
								'link'=> "syllabus_coverage/students/BRSK10000001"),
							array('title'=>"Reports",
								'icon'=>"flag",
								'link'=> "#",
								'children'=>array(
									array('title'=>"Score",
										'icon'=>"star",
										'link'=> "Report/score/BRSK10000001"),
									array('title'=>"Daily Reports",
										'icon'=>"bar-chart",
										'link'=> "Report/daily_base/BRSK10000001"),
									array('title'=>"Task Reports",
										'icon'=>"flag",
										'link'=> "Report/task_base/BRSK10000001"),
								),
								),
							array('title'=>"Attendance",
								'icon'=>"check-circle",
								'link'=> "team/attendance_veiw/BRSK10000001"),
							array('title'=>"Payments",
								'icon'=>"money",
								'link'=> "team/payment/BRSK10000001"),
							array('title'=>"Awards",
								'icon'=>"trophy", 
								'link'=> "team/award/BRSK10000001")
									),
							),
					array('title'=>"Employees",
						'icon'=>"users",
						'link'=> "#",
						'children'=>array(
							array('title'=>"List",
								'icon'=>"info-circle",
								'link'=> "team/lists/BRSK10000001"),
							// array('title'=>"My Profile",
							// 	'icon'=>"info-circle",
							// 	'link'=> "team/view"),
							array('title'=>"Tasks",
								'icon'=>"tasks",
								'link'=> "#",
								'children'=>array(
									array('title'=>"Major Tasks",
										'icon'=>"folder-open",
										'link'=> "task/index/BRSK10000001"),
									array('title'=>"Calendar Tasks",
										'icon'=>"calendar",
										'link'=> "task/calendar_task/BRSK10000001")
								),
								),
							array('title'=>"Employee Notice Board",
								'icon'=>"exclamation",
								'link'=> "employee_notice/index/BRSK10000001"),
							array('title'=>"Reports",
								'icon'=>"flag",
								'link'=> "#",
								'children'=>array(
									array('title'=>"Score",
										'icon'=>"star",
										'link'=> "Report/score/BRSK10000001"),
									array('title'=>"Daily Reports",
										'icon'=>"bar-chart",
										'link'=> "Report/daily_base/BRSK10000001"),
									array('title'=>"Task Reports",
										'icon'=>"flag",
										'link'=> "Report/task_base/BRSK10000001"),
								),
								),
							array('title'=>"Attendance",
								'icon'=>"check-circle",
								'link'=> "team/attendance_veiw/BRSK10000001"),
							array('title'=>"Payments",
								'icon'=>"money",
								'link'=> "team/payment/BRSK10000001"),
							array('title'=>"Awards",
								'icon'=>"trophy", 
								'link'=> "team/award/BRSK10000001")
									),
						),
					array('title'=>"Center & Inventory",
						'icon'=>"exclamation-triangle",
						'link'=> "Centerandinventory/view/BRSK10000001"),
					array('title'=>"Finance Accounting",
						'icon'=>"credit-card",
						'link'=> "Transaction/index/BRSK10000001"),
					// array('title'=>"Marketing Telecalling",
					// 	'icon'=>"mobile",
					// 	'link'=> "Marketing_telecalling/view"),
					array('title'=>"Marketing Telecalling",
								'icon'=>"mobile",
								'link'=> "#",
								'children'=>array(
									array(
										'title'=>"Prospect Lists",
										'icon'=>"phone",
										'link'=> "#",
										'children'=>array(
											array(
												'title'=>"Add",
												'icon'=>"plus",
												'link'=> "lists/add/BRSK10000001",
											),
											array(
												'title'=>"Import",
												'icon'=>"upload",
												'link'=> "lists/import/BRSK10000001",
											)
										)
									),
									array(
										'title'=>"Uploaded Lists",
										'icon'=>"list",
										'link'=> "lists/index/BRSK10000001",
									),
									array(
										'title'=>"Customer",
										'icon'=>"user",
										'link'=> "Customer/show",
									),
									array(
										'title'=>"Leads",
										'icon'=>"plus-circle",
										'link'=> "leads/index/BRSK10000001",
									),
									array(
										'title'=>"Reports",
										'icon'=>"line-chart",
										'link'=> "report/call/BRSK10000001"
									),
								),
								),
					array('title'=>"Business Contacts",
						'icon'=>"phone",
						'link'=> "Business_contact/transfer/BRSK10000001"),
					array('title'=>"CCTV Thane",
						'icon'=>"video-camera",
						'link'=> "CCTV/view_cam/BRSK10000001")
				)
			),
			
			// array(
			// 	'title'=>"Paathshala Staff",
			// 	'icon'=>"users",
			// 	'link'=> "#",
			// 	'children'=>array(
			// 		array(
			// 			'title'=>"Add",
			// 			'icon'=>"plus",
			// 			'link'=> "Team/add",
			// 		),
			// 		array(
			// 			'title'=>"Show",
			// 			'icon'=>"eye",
			// 			'link'=> "Team",
			// 		)
			// 	)
			// ),
			/*array(
				'title'=>"Customers",
				'icon'=>"users",
				'link'=> "#",
				'children'=>array(
					array(
						'title'=>"Add",
						'icon'=>"plus",
						'link'=> "customer/add",
					),
					array(
						'title'=>"Show",
						'icon'=>"eye",
						'link'=> "customer",
					)
				)
			),
			array(
				'title'=>"Vendors",
				'icon'=>"building",
				'link'=> "#",
				'children'=>array(
					array(
						'title'=>"Add",
						'icon'=>"plus",
						'link'=> "vendor/add",
					),
					array(
						'title'=>"Show",
						'icon'=>"eye",
						'link'=> "vendor",
					)
				)
			),
			array(
				'title'=>"Products",
				'icon'=>"puzzle-piece",
				'link'=> "#",
				'children'=>array(
					array(
						'title'=>"Add",
						'icon'=>"plus",
						'link'=> "product/add",
					),
					array(
						'title'=>"Show",
						'icon'=>"eye",
						'link'=> "product",
					)
				)
			),
			array(
				'title'=>"Purchase",
				'icon'=>"truck",
				'link'=> "#",
				'children'=>array(
					array(
						'title'=>"Add Purchase",
						'icon'=>"plus",
						'link'=> "purchase/add",
					),
					array(
						'title'=>"Show Purchases",
						'icon'=>"eye",
						'link'=> "purchase",
					)
				)
			),
			//array(
			//	'title'=>"Stocks",
			//	'icon'=>"database",
			//	'link'=> "#",
			//	'children'=>array(
			//		array(
			//			'title'=>"Add",
			//			'icon'=>"plus",
			//			'link'=> "stock/add",
			//		),
			//		array(
			//			'title'=>"Show",
			//			'icon'=>"eye",
			//			'link'=> "stock",
			//		)
			//	)
			//),
			array(
				'title'=>"Estimate",
				'icon'=>"briefcase",
				'link'=> "#",
				'children'=>array(
					array(
						'title'=>"Add",
						'icon'=>"plus",
						'link'=> "bill/add/estimate",
					),
					array(
						'title'=>"Show",
						'icon'=>"eye",
						'link'=> "bill/show/estimate",
					)
				)
			),
			array(
				'title'=>"Invoice",
				'icon'=>"newspaper-o",
				'link'=> "#",
				'children'=>array(
					array(
						'title'=>"Add",
						'icon'=>"plus",
						'link'=> "bill/add/invoice",
					),
					array(
						'title'=>"Show",
						'icon'=>"eye",
						'link'=> "bill/show/invoice",
					)
				)
			),
			array(
				'title'=>"Leads",
				'icon'=>"leaf",
				'link'=> "#",
				'children'=>array(
					array(
						'title'=>"Generate",
						'icon'=>"plus",
						'link'=> "lead/add",
					),
					array(
						'title'=>"Show",
						'icon'=>"eye",
						'link'=> "lead",
					)
					,
					array(
						'title'=>"Show Preview",
						'icon'=>"eye",
						'link'=> "lead/preview",
					)
				)
			),
			array(
				'title'=>"Accounting",
				'icon'=>"credit-card",
				'link'=> "#",
				'children'=>array(
					array(
						'title'=>"Add Transactions",
						'icon'=>"plus",
						'link'=> "transaction/add",
					),
					array(
						'title'=>"Show Transactions",
						'icon'=>"eye",
						'link'=> "transaction/show",
					),
					array(
						'title'=>"Cash Book",
						'icon'=>"book",
						'link'=> "account/showCashBook",
					),
					array(
						'title'=>"Bank Book",
						'icon'=>"cc-mastercard",
						'link'=> "account/showBankBook",
					)
				)
			),
			// array(
			// 	'title'=>"AMC",
			// 	'icon'=>"star",
			// 	'link'=> "#",
			// 	'children'=>array(
			// 		array(
			// 			'title'=>"Add New AMC",
			// 			'icon'=>"plus",
			// 			'link'=> "amc/add",
			// 		),
			// 		array(
			// 			'title'=>"Show AMC",
			// 			'icon'=>"eye-slash",
			// 			'link'=> "amc",
			// 		),
			// 		array(
			// 			'title'=>"Add Visits",
			// 			'icon'=>"binoculars",
			// 			'link'=> "amc/add_visits",
			// 		),
			// 		array(
			// 			'title'=>"Show Visits",
			// 			'icon'=>"eye",
			// 			'link'=> "amc/show",
			// 		)
			// 	)
			// ),
			array(
				'title'=>"Reports",
				'icon'=>"line-chart",
				'link'=> "#",
				'children'=>array(
					array(
						'title'=>"Sells Report",
						'icon'=>"newspaper-o",
						'link'=> "report/Sells",
					),
					array(
						'title'=>"Purchse Report",
						'icon'=>"truck",
						'link'=> "report/Purchase",
					),
					//array(
					//	'title'=>"Stock Reports",
					//	'icon'=>"database",
					//	'link'=> "report/Stock",
					//),
					array(
						'title'=>"Expence Category Reports",
						'icon'=>"credit-card",
						'link'=> "report/Expences",
					)
				)
			),
			array(
				'modal'=>"true",
				'title'=>"Alerts",
				'icon'=>"bell-o",
				'target'=> "amcBX",
				'link'=> "#"
			),
			array(
				'title'=>"Support Tickets",
				'icon'=>"building",
				'link'=> "#",
				'children'=>array(
					array(
						'title'=>"Create",
						'icon'=>"plus",
						'link'=> "query/add",
					),
					array(
						'title'=>"Show Tickets",
						'icon'=>"eye",
						'link'=> "query",
					)
				)
			)*/
		);
			 $json_object = json_decode($_POST['menu_order']);
			//$arr = $this->setting_model->objToArray($json_object);
			$menu = array('menu'=>$arr);
			$data = json_encode($menu);
			$data = $this->encrypt->encrypt_string($data,$my_config['app_ie']);
			$dir = APPPATH.$my_config['app_log_directory'].'/';
			$file_name = underscore($d['Login']['Login_as']);
			if(!file_exists($dir))
			{
				mkdir($dir);
				if ( ! write_file($dir.'/'.$file_name.$my_config['log_file_extension'], $data))
				{
				    return FALSE;
				}
				else
				{
				    return TRUE;
				}
			}
			else
			{
				if ( ! write_file($dir.'/'.$file_name.$my_config['log_file_extension'], $data,'w'))
				{
				     return FALSE;
				}
				else
				{
				     return TRUE;
				}
			}
		}
		public function help_data()
		{
			$this->load->model('fetch_model');
			$categories = $this->fetch_model->show('HC',array('ID','Title','Icon'));
			$stack = array();
			foreach ($categories as $row)
			{
				$stack[$row['ID']]["properties"] = array($row['ID'],$row['Title'],$row['Icon']);
				$qa = $this->fetch_model->show(array('H'=>array('Category_ID'=>$row['ID'],'Parent_ID'=>'')));
				if(count($qa) > 0)
				{
					$stack[$row['ID']]["data"] = $qa;
					foreach ($qa as $key => $qproperties)
					{
						$childs = $this->fetch_model->show(array('H'=>array('Category_ID'=>$row['ID'],'Parent_ID'=>$qproperties['ID'])));
						
						if(count($childs) > 0)
						{
							$stack[$row['ID']]["childs"][$qproperties['ID']] = $childs;
							unset($qa[$key]);
						}
					}
				}
			}
			return $stack;
		}

		public function get_user_data()
		{
			$data['user_detail'] =  $this->fetch_model->show(array('US'=>array('ID'=>$this->session_library->get_session_data('ID'))));
			$data['currency'] = $this->fetch_model->show('CU');
			if(count($data['user_detail'] === 1) && $data['user_detail'] !== FALSE)
			{
				return $data;
			}
			else
			{
				return FALSE;
			}
		}

		public function update_user_data()
		{
			$this->load->model('form_model');
			if (array_key_exists('is_discount', $_POST))
			{
				$_POST['is_discount']=$_POST['is_discount'];
			}
			else
			{
				$_POST['is_discount']='No';
			}
			$res = $this->form_model->edit(array("table"=>"US","columns"=>$_POST,'where'=>array('ID'=>$this->session_library->get_session_data('ID'))));
			return $res;
		}

		public function synchronize()
		{
					
		}

		public function getCustomers()
		{
			$data=$this->fetch_model->show('C');
			if ($data)
			{
				return $data;
			}
			else
			{
				return false;
			}
		}

	public function add()
	{
		$this->load->model('form_model');
		$p_add=$this->form_model->edit(array('table'=> 'US','columns'=> array('emailConfigID'=>json_encode($_POST)),'where'=> array('ID'=>$this->data['Login']['ID'])));
		if ($p_add)
		{
			echo json_encode(1);
		}
		else
		{
			echo json_encode($p_add);
		}
	}

	public function themes_setting()
	{
		$_POST['fixed_footer']=(isset($_POST['fixed_footer']) ? $_POST['fixed_footer'] : Null);
		$_POST['top_navbar']=(isset($_POST['top_navbar']) ? $_POST['top_navbar'] : NULL);
		$_POST['boxed_layout']=(isset($_POST['boxed_layout']) ? $_POST['boxed_layout'] : NULL);
		$_POST['fixed_slidebar']=(isset($_POST['fixed_slidebar']) ? $_POST['fixed_slidebar'] : NULL);
		$_POST['collaps_menu']=(isset($_POST['collaps_menu']) ? $_POST['collaps_menu'] : NULL);
		$this->load->model('form_model');
		if($this->form_model->edit(array("table"=>"US","columns"=>$_POST,'where'=>array('ID'=>$this->session_library->get_session_data('ID')))))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	function import($value='')
	{
		$this->load->model('form_model');
		$targetDir = "uploads/";
		$x=0;
		foreach ($_FILES['file']['name'] as $key => $value) {
		$ext=explode('.', $value);
		$ext=$ext[1];
	   		$fileName =$value;
	    	$targetFile = $targetDir.$fileName;
	    	if(move_uploaded_file($_FILES['file']['tmp_name'][$x],$targetFile)){
				$lines = file($targetFile);
				unset($lines[0]);
				// unset($lines[1]); // we do not need these lines.
				foreach($lines as $line) 
				{
				    $var = preg_split("/[\t]/", $line);
				    $subVar = preg_split('/\s+/', $var[4]);
				    if (count($var)===5 && (count($subVar)===3 || count($subVar)===2)) {
				    	$arr[] = array($var[0],$var[1],$var[2],$var[3],$subVar[0],$subVar[1]);
				    }
				    else
				    {
				    	return array("errormultiple"=>"Please Check File ..Something went wrong");
				    }
				    
				}

				foreach ($arr as $key => $value) {
				// 	$result=$this->form_model->add(array("table"=>"AT","columns"=>array('Att_no'=>$value[0],'employee_ID'=>$value[2],'Name'=>$value[3],'date'=>$this->date_library->date2db($value[4],"Y/m/d"),'time'=>$value[5])),array('Att_no'=>array(
				// 	'rules'=> 'required|is_unique[attendance.Att_no]'
				// )));
					$isDataPresnt=$this->fetch_model->show(array('AT' =>array('Att_no'=>$value[0])));
					if (empty($isDataPresnt)) {
						$result=$this->form_model->add(array("table"=>"AT","columns"=>array('Att_no'=>$value[0],'employee_ID'=>$value[2],'Name'=>$value[3],'date'=>$this->date_library->date2db($value[4],"Y/m/d"),'time'=>$value[5])));
					}
					else
					{
						$result=array("errormultiple"=>"Unique Values");
					}
					


				}
				if ($result===true) {
					$this->addEmplpyee();
					return true;
				}
				else
				{
					return $result;
				}
		    }
		    $x++;
		}
	}

	public function addEmplpyee($value='')
	{
		$this->load->model('form_model');
		$this->db->group_by('employee_ID');
		$query = $this->db->get('attendance');
		$data=$query->result_array();
		$empData=$this->fetch_model->show('EP');
		if ($empData) {
			foreach ($data as $key => $value) {
				$dataPresent=$this->fetch_model->show(array('EP' =>array('employee_ID'=>$value['employee_ID'])));
				if (empty($dataPresent))
				{
					if (!ctype_space($value['Name'])) {
						$result=$this->form_model->add(array("table"=>"EP","columns"=>array('employee_ID'=>$value['employee_ID'],'Name'=>$value['Name'])));
						// print_r($value);
					}
					// var_dump($result);
				}
			}
			if ($result===true) {
				return true;
			}
			else
			{
				return false;
			}
		}
		else{
			foreach ($data as $key => $value) {
				if (!ctype_space($value['Name'])) {
					$result=$this->form_model->add(array("table"=>"EP","columns"=>array('employee_ID'=>$value['employee_ID'],'Name'=>$value['Name'])));
				}
			}
			if ($result===true) {
				return true;
			}
			else
			{
				return false;
			}
		}
	}

}
?>