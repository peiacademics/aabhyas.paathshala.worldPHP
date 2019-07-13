<?php
	class Meeting_model extends CI_Model
	{
		function color2subject($color)
		{
			switch($color)
			{
				case 'Weekly':
					return 'label-success';
				break;
				
				case 'Monthly':
					return 'label-danger';
				break;

				case 'Occasionally':
					return 'label-pink';
				break;

				case 'Project_report':
					return 'label-purple';
				break;

				default :
					return 'label-grey';
				break;
			}
		}

		public function events($month='',$year='')
		{
			$t = 'M';
			//$t = $this->db_library->get_tbl('M');
			$this->db->where('Status','A');
			if(!empty($month) && !empty($year))
			{
				$this->db->where('YEAR(Date)',$year);
				$this->db->where('MONTH(Date)',$month);
			}
			$result = $this->db->get_where('meetings',array('Status'=>'A'));
			foreach($result->result_array() as $event)
			{
				$event_details = (object) array(
					'id'=>$event['ID'],
					'title'	=>$event['Meeting_type'],
					'start' => $event['Date']." ".$event['Start_time'],
					'end' => $event['End']." ".$event['End_time'],
					'className' => $this->color2subject($event['Subject'])
				);
				
				$events[] = $event_details;
			}
			return $events;
		}

		function add_rec()
		{
			//$id = $this->input->post('id');
			//$t = 'M';
			$t = $this->db_library->get_tbl('M');
			$id = $this->sform->find_next_id($t);
			$status = 'A';
			$Added_on=$this->date_library->get_current_time();
			$Added_by = $this->session_library->get_session_data('ID');
			$title = $this->input->post('title');
			$start = $this->input->post('start');
			$end = $this->input->post('end');
			$project_id= $this->input->post('project_id');
			$subject = $this->input->post('subject');
			$team_members = $this->input->post('team_members');
			$client_name = $this->input->post('client_name');
			$topic = $this->input->post('topic');

			$data =array(
				
					'ID'=>$id,
					'Status'=>$status,
					'Added_on'=>$Added_on,
					'Added_by'=>$added_by,
					'Meeting_type'=>$title,
					'Date'=>$start,
					'End'=>$end,
					'Project_ID'=>$project_id,
					'Subject'=>$subject,
					'Team_members'=>$team_members,
					'Client_name'=>$client_name,
					'Topic'=>$topic
			);
			$sql = $this->db->insert('meetings',$data);
			if($sql)
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
			
		}

		function update_event_drop()
		{
			$t = $this->db_library->get_tbl('M');
			$id = $this->input->post('id');
			$status = 'A';
			$Added_on=$this->date_library->get_current_time();
			$Added_by = $this->session_library->get_session_data('ID');
			$title = $this->input->post('title');
			$start = $this->input->post('start');
			$start_det = explode(" ",$start);
			$start_date = $start_det[0];
			$start_time = $start_det[1];
			$data = array(
					'Status'=>$status,
					'Added_on'=>$Added_on,
					'Added_by'=>$Aadded_by,
					'Meeting_type'=>$title,
					'Date'=>$start_date,
					'Start_time'=>$start_time
				);
			$this->db->where('ID',$id);
			$sql = $this->db->update('meetings',$data);
			if($sql)
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}

		}

		function update_event_resize()
		{
			$t = $this->db_library->get_tbl('M');
			$id = $this->input->post('id');
			$status = 'A';
			$Added_on=$this->date_library->get_current_time();
			$Added_by = $this->session_library->get_session_data('ID');
			$title = $this->input->post('title');
			$start = $this->input->post('start');
			$start_det = explode(" ",$start);
			$start_date = $start_det[0];
			$start_time = $start_det[1];
			$end = $this->input->post('end');
			$end_det = explode(" ",$end);
			$end_date = $end_det[0];
			$end_time = $end_det[1];
			$data = array(
					//'ID'=>$id,
					'Status'=>$status,
					'Added_on'=>$Added_on,
					'Added_by'=>$Added_by,
					'Meeting_type'=>$title,
					'Date'=>$start_date,
					'End'=>$end_date,
					'Start_time'=>$start_time,
					'End_time'=>$end_time
				);
			$this->db->where('ID',$id);
			$sql =$this->db->update('meetings',$data);
			if($sql)
			{
				return True;
			}
			else
			{
				return FALSE;
			}
		}
		function delete()
		{
			$t = $this->db_library->get_tbl('M');
			$id = $this->input->post('id');
			$status = 'A';
			$Added_on=$this->date_library->get_current_time();
			$Added_by = $this->session_library->get_session_data('ID');
			$this->db->where('ID',$id);
			$sql = $this->db->update('meetings',array('Status'=>'D')); 
			if($sql)
			{
				return True;
			}
			else
			{
				return FALSE;
			}
		}
		function edit_event_load_data($id)
		{
			$t = $this->db_library->get_tbl('M');
			//$id = $this->input->post('id');
			$result=$this->db->get_where('meetings',array('ID'=>$id));
			$query = $result->result_array();
			foreach($query as $row)
			{
				$data = array(
					"Meeting_type"=>$row['Meeting_type'],
					"Team_members"=>$row['Team_members'],
					"Project_ID"=>$row['Project_ID'],
					"Client_name"=>$row['Client_name'],
					"Subject"=>$row['Subject'],
					"Start_time"=>$row['Start_time'],
					"Topics"=>$row['Topics']
				);
				return $data;
			}	


		}

		function save()
		{
			$t = $this->db_library->get_tbl('M');
			$id = $this->input->post('id');
			$status = 'A';
			$Added_on=$this->date_library->get_current_time();
			$Added_by = $this->session_library->get_session_data('ID');
			$title = $this->input->post('title');
			$project_id= $this->input->post('project_id');
			$subject= $this->input->post('subject');
			$team_members = $this->input->post('team_members');
			$client_name = $this->input->post('client_name');
			$topic = $this->input->post('topic');
			$Start_time=$this->input->post('Start_time');

			$data = array(
					//'ID'=>$id,
					'Status'=>$status,
					'Added_on'=>$Added_on,
					'Added_by'=>$added_by,
					'Meeting_type'=>$title,
					'Date'=>$start,
					'Project_ID'=>$project_id,
					'Subject'=>$subject,
					'Team_members'=>$team_members,
					'Client_name'=>$client_name,
					'Topic'=>$topic,
					'Start_time'=>$start_time
				);
			$this->db->where('ID',$id);
			$sql = $this->db->update('meetings',$data); 
			if($sql)
			{
				return TRUE;	
			}
			else {
				return FALSE;	
			}
		}
	}