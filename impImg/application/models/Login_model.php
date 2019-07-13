<?php

	class Login_model extends CI_Model{



		public function authenticate($email=NULL,$passwd=NULL)
		{
			if(!is_null($passwd)||!is_null($email))
			{
				if(!$this->is_locked())
				{
					$tbl = $this->db_library->get_tbl('US');
					$email = $this->db->escape_str($email);
					$query = $this->db->get_where($tbl,array("Status"=>"A","Email"=>$email,"Type !="=>"Client"));
					if($query->num_rows() > 0)
					{
						if($query->row()->Password === $passwd)
						{
							$logindata = array(
								'ID' => $query->row()->ID,
								'Name' => $query->row()->Name,
								'Date_Format' => $query->row()->Date_Format,
								'Email' => $query->row()->Email,
								'Login_as' => $query->row()->Type,
								'Added_by' => $query->row()->Added_by,
								'Language' => $this->str_function_library->call('fr>LN>Title:ID=`'.($query->row()->Language_ID).'`'),
								'branch_ID' => $query->row()->branch_ID,
								'Logged_in' => "TRUE",
								'Locked' => "FALSE",
							);
							$this->session_library->set_session_data($logindata);
							$this->session->set_flashdata('alert', true);
							$res['status'] = TRUE;
							$res['type'] = $query->row()->Type;
							$res['ID'] = $query->row()->ID;
							return $res;
						}
						else
						{
							return FALSE;
						}
					}
					else {
						return FALSE;
					}
				}
				else {
					if(is_null($email) && !is_null($passwd) && $this->is_locked())
					{
						$tbl = $this->db_library->get_tbl('US');
						$email = $this->session_library->get_session_data('Email');
						$query = $this->db->get_where($tbl,array("Status"=>"A","Email"=>$email));
						if($query->num_rows() > 0)
						{
							if($query->row()->Password === $passwd)
							{
								return TRUE === $this->unlock() ? TRUE : FALSE; 
							}
							else
							{
								return FALSE;
							}
						}
						else
						{
							redirct('Login/logout');
						}
					}
					else
					{
						return FALSE;
					}
				}
			}
		}



	    public function check_login()

	    {

	    	if($this->session_library->get_session_data('Logged_in') === "TRUE")

	    	{

	    		return ($this->session_library->get_session_data('Locked') === "FALSE") ? TRUE : FALSE;

	    	}

	    	else

	    	{

	    		return FALSE;

	    	}	

	    }



	    public function is_locked()

	    {

	    	if($this->session_library->get_session_data('Logged_in') === "FALSE")

	    	{

	    		return ($this->session_library->get_session_data('Locked') === "TRUE") ? TRUE : FALSE;

	    	}

	    	else

	    	{

	    		return FALSE;

	    	}

	    }



	    private function unlock()

	    {

	    	if($this->is_locked())

	    	{

	    		$log = $this->session_library->set_session_data("Logged_in","TRUE");

	    		$lock = $this->session_library->set_session_data("Locked","FALSE");

	    		if($log && $lock)

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



	    public function lock()

	    {

	    	if($this->check_login())

	    	{

	    		$log = $this->session_library->set_session_data("Logged_in","FALSE");

	    		$lock = $this->session_library->set_session_data("Locked","TRUE");

	    		if($log && $lock)

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

	    		if($this->is_locked())

	    		{

	    			return TRUE;

	    		}

	    		else

	    		{

	    			return FALSE;

	    		}

	    	}

	    }



	    public function logout()

	    {

	    	$this->session->sess_destroy();

	    	return TRUE;

	    }



	    public function set_lang($lang_id=NULL)

	    {

	    	if(!is_null($lang_id))

	    	{

	    		if($this->session_library->set_session_data('Language_ID',$lang_id))

	    		{

					$this->lang_library->update_lang();

					return TRUE;

	    		}

	    	}

	    	else {

	    		return FALSE;

	    	}

	    }

	    public function authenticate_student($email = NULL,$passwd = NULL)
		{
			if(!is_null($passwd)||!is_null($email))
			{
				$tbl = $this->db_library->get_tbl('ST');
				$email = $this->db->escape_str($email);
				$query = $this->db->get_where($tbl,array("Status"=>"A","Email"=>$email,"Type !="=>"Client"));
				$res = array();
				if($query->num_rows() > 0)
				{
					if($query->row()->Password === $passwd)
					{
						$logindata = array(
							'ID' => $query->row()->ID,
							'Name' => $query->row()->Name,
							'Email' => $query->row()->Email,
							'Login_as' => $query->row()->Type,
							'Added_by' => $query->row()->Added_by,
							'Language' => $this->str_function_library->call('fr>LN>Title:ID=`'.($query->row()->Language_ID).'`'),
							'branch_ID' => $query->row()->branch_ID,
							'Language_ID' => $query->row()->Language_ID,
							'Logged_in' => "TRUE",
							'Locked' => "FALSE",
							'Time_Format' => $this->date_library->get_time_format($query->row()->ID),
							'Date_Format' => $this->date_library->get_date_format($query->row()->ID),
							'Timezone' => $this->date_library->get_timezone($query->row()->ID),
						);
						$this->session_library->set_session_data($logindata);
						$this->session->set_flashdata('alert', true);
						$res['status'] = TRUE;
						$res['type'] = $query->row()->Type;
						$res['ID'] = $query->row()->ID;
						return $res;
					}
					else
					{
						return FALSE;
					}
				}
				else {
					return FALSE;
				}
			}
		}

		public function authenticate_parent($email = NULL,$passwd = NULL)
		{
			if(!is_null($passwd)||!is_null($email))
			{
				$tbl = $this->db_library->get_tbl('GD');
				$email = $this->db->escape_str($email);
				$query = $this->db->get_where($tbl,array("Status"=>"A","Email"=>$email,"Type !="=>"Client"));
				$res = array();
				if($query->num_rows() > 0)
				{
					if($query->row()->Password === $passwd)
					{
						$logindata = array(
							'ID' => $query->row()->ID,
							'Name' => $query->row()->Name,
							'Email' => $query->row()->Email,
							'Login_as' => $query->row()->Type,
							'Added_by' => $query->row()->Added_by,
							// 'Language' => $this->str_function_library->call('fr>LN>Title:ID=`'.($query->row()->Language_ID).'`'),
							// 'branch_ID' => $query->row()->branch_ID,
							// 'Language_ID' => $query->row()->Language_ID,
							'Logged_in' => "TRUE",
							'Locked' => "FALSE",
							'Time_Format' => $this->date_library->get_time_format($query->row()->ID),
							'Date_Format' => $this->date_library->get_date_format($query->row()->ID),
							'Timezone' => $this->date_library->get_timezone($query->row()->ID),
							'student_ID'=>$query->row()->Student_ID
						);
						$this->session_library->set_session_data($logindata);
						$this->session->set_flashdata('alert', true);
						$res['status'] = TRUE;
						$res['type'] = $query->row()->Type;
						$res['ID'] = $query->row()->ID;
						$res['student_ID'] = $query->row()->Student_ID;
						return $res;
					}
					else
					{
						return FALSE;
					}
				}
				else {
					return FALSE;
				}
			}
		}

	}

?>