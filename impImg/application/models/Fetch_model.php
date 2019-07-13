<?php
	class Fetch_model extends CI_Model{

		function show($input=NULL,$output='*',$options=NULL)
		{
			$this->load->library('process/security_lib');
			$combinations = $this->security_lib->get_combination('show',$input,$output);
			// print_r($combinations);
			// var_dump($input);
			// echo "string";
			// print_r($options);
			switch($combinations)
			{
				case '1ULXXSK4TSXS':
					$this->errorlog_library->entry('Fetch model > show > case : 1ULXXSK4TSXS > argument input is null.');
					return FALSE;
				break;

				case '4TSXVSK4TSXS':
					if(!$tbl = $this->db_library->get_tbl($input))
					{
						$this->errorlog_library->entry('Fetch model > show > case : 4TSXVSK4TSXS > table not found.');
						return FALSE;
					}
					else
					{
						// var_dump($options);
						$this->db->select($output);
						if (isset($options))
						{
							// echo "string";
							$this->limits($options);
						}
						$show_data = $this->db->get_where($tbl,array('Status'=>'A'));
						return $show_data->result_array(); //returns Array
					}					
				break;

				case '4TSXVSK4TSXV':
					if(!$tbl = $this->db_library->get_tbl($input))
					{
						$this->errorlog_library->entry('Fetch model > show > case : 4TSXVSK4TSXV > table not found.');
						return FALSE;
					}
					else
					{
						if (strpos($output,',') !== FALSE)
						{
							$this->errorlog_library->entry('Fetch model > show > case : 4TSXVSK4TSXV > argument output contains comma');
							return FALSE;
						}
						else
						{
							$this->db->select($output);
							if (isset($options))
							{
								$this->limits($options);
							}
							$show_data = $this->db->get_where($tbl,array('Status'=>'A'));
							return $show_data->result_array(); //returns Array
						}
					}					
				break;

				case '4TSXVSK5YAL1':
					$tbl = $this->db_library->get_tbl($input);
					// print_r($)
					return $this->get_array_data($output,$tbl,'4TSXVSK5YAL1',$options);
				break;

				case '5YAL2SK4TSXS':
					foreach ($input as $shrtTbl => $conditions_array)
					{	
						if($this->get_input_array($shrtTbl,$conditions_array,'5YAL2SK4TSXS') !== FALSE)
						{
							$tbl = $this->db_library->get_tbl($shrtTbl);
							if (isset($options)) {
								$this->limits($options);
							}
							$show_data = $this->db->get($tbl);
							if(is_array($show_data->result_array()))
							{
								return $show_data->result_array(); //returns Array
							}
							else {
								$this->errorlog_library->entry('Fetch model > show > case : 5YAL2SK4TSXS > argument output case : string > Failed to Return MySQL Result Array with All Columns.');
								return FALSE;
							}
						}
						else
						{
							return FALSE;
						}
					}
				break;

				case '5YAL2SK4TSXV':
					foreach ($input as $shrtTbl => $conditions_array)
					{
						$tbl = $this->db_library->get_tbl($shrtTbl);
						if($this->get_input_array($shrtTbl,$conditions_array,'5YAL2SK4TSXV') !== FALSE)
						{
							if (strpos($output,',') !== FALSE)
							{
								$this->errorlog_library->entry('Fetch model > show > case : 5YAL2SK4TSXV > argument output contains comma');
								return FALSE;
							}
							else
							{
								$this->db->select($output);
								if (isset($options))
								{
									$this->limits($options);
								}
								$show_data = $this->db->get($tbl);
								if(is_array($show_data->result_array()))
								{
									return $show_data->result_array(); //returns Array
								}
								else
								{
									$this->errorlog_library->entry('Fetch model > show > case : 5YAL2SK4TSXV > argument output case : string > Failed to Return MySQL Result Array with Single Column.');
									return FALSE;
								}
							}
						}
						else
						{
							return FALSE;
						}
					}

				case '5YAL2SK5YAL1':
					foreach ($input as $shrtTbl => $conditions_array)
					{	
						if($this->get_input_array($shrtTbl,$conditions_array,'5YAL2SK5YAL1') !== FALSE)
						{
							$tbl = $this->db_library->get_tbl($shrtTbl);
							return $this->get_array_data($output,$tbl,'5YAL2SK5YAL1',$options);
						}
						else
						{
							return FALSE;
						}
					}
				break;

				default:
					$this->errorlog_library->entry('Fetch model > show > Undefined datatype of variable input');
					return FALSE;
				break;
			}
		}

		private function get_input_array($shrtTbl=NULL,$conditions_array=NULL,$case=NULL)
		{
			if(!is_null($shrtTbl) && !is_null($conditions_array) && is_array($conditions_array) && !is_null($case))
			{
				if(!$tbl = $this->db_library->get_tbl($shrtTbl))
				{
					$this->errorlog_library->entry('Fetch model > show > table not found > case : `'.$case.'` ');
					return FALSE;
				}
				else {
					if(is_array($conditions_array))
					{
						//Creates Conditions of MySQL Query
						foreach($conditions_array as $column_name => $value)
						{
							//If the Multiple OR Conditions in string
							if(strpos($value, '||')!==FALSE)
							{
								$or_stack = '';
								if($cols = explode('||', $value))
								{
									$or_stack .= '(';
									$last_val = count($cols);
									$or_counter = 1;
									foreach ($cols as $col)
									{
										$or_stack .= $column_name.'="'.$col.'"';
										if($or_counter < $last_val)
										{
											$or_stack .= ' OR ';
										}
										$or_counter++;
									}
									$or_stack .= ')';
								}
								else {
									$this->errorlog_library->entry('Fetch model > show > argument output multiple OR conditions were failed to seperate > case : `'.$case.'` ');
									return FALSE;
								}
								//echo $or_stack;
								$this->db->where($or_stack);
							}
							//If the Multiple AND Conditions in string
							elseif (strpos($value, '&&')!==FALSE)
							{
								$and_stack = '';
								if($cols = explode('&&', $value))
								{
									$and_stack .= '(';
									$last_val = count($value);
									$and_counter = 1;
									foreach ($cols as $col)
									{
										$and_stack .= $column_name.'="'.$col.'"';
										if($and_counter < $last_val)
										{
											$and_stack .= ' AND ';
										}
										$and_counter++;
									}
									$and_stack .= ')';
								}
								else {
									$this->errorlog_library->entry('Fetch model > show > argument output multiple AND conditions were failed to seperate > case : `'.$case.'` ');
									return FALSE;
								}
								$this->db->where($and_stack);
							}
							//Normal Condition
							else {
								$this->db->where($column_name,$value);
							}
						}
						if(!array_key_exists('Status',$conditions_array))
						{
							$this->db->where('Status','A');
						}
					}
				}
			}
			else
			{
				$this->errorlog_library->entry('Fetch model > get_input_array > argument shrtTbl, conditions_array or case is null or argumet conditions_array is not an array > case :`'.$case.'`');
				return FALSE;
			}
		}

		public function limits($options)
		{
			if (is_array($options))
			{
				$data=array();
				foreach ($options as $key => $value) {
					// print_r($value);
					if ($key === 'LIMITS')
					{
						// $data[]=$this->db->limit($value[0], $value[1]);
						$this->db->limit($value[0], $value[1]);
					}
					else if ($key ==='ORDER') {
						// $data[]=$this->db->limit($value[0], $value[1]);
						$this->db->order_by($value[0], $value[1]);
					}
					else if ($key ==='GROUP_BY') {
						// $data[]=$this->db->limit($value[0], $value[1]);
						$this->db->group_by($value);
					}
				}
			}
			else
			{
				return false;
			}
		}

		public function get_multiadd_data($tbl_sc,$data)
		{
			$new_data = array();
			$ids = explode(',', $data);
			if(!empty($ids[0]))
			{
				foreach ($ids as $id) {
					$id = trim($id);
					if(!empty($id))
					{
						$multi_data = $this->fetch_model->show(array($tbl_sc=>array('ID'=>$id)));
						
						if($multi_data !== FALSE || (!empty($multi_data)))
						{
							$new_data[] = $multi_data[0];

						}
						else
						{
							return FALSE;
						}
					}
				}
			}
			return $new_data;
		}
		
		private function get_array_data($output= NULL,$tbl = NULL,$case = NULL,$options=null)
		{
			// echo "string";
			// var_dump($options);
			if(!is_null($output) && !is_null($tbl) && !is_null($case))
			{
				$select_stack = '';
				$last_col = count($output);
				$select_counter = 1;
				$function_flag = FALSE;
				$function_stack = array();
				foreach ($output as $key => $column)
				{
					if(strpos($column, '>>') === 0)
					{
						$this->load->library('str_function_library');
						$col_array = $this->str_function_library->get_careted_columns($column);
						if(empty($col_array))
						{
							$this->errorlog_library->entry('Fetch model > get_array_data > show > case : '.$case.' > argument col_array not found');
							return FALSE;
						}
						else
						{
							$function_flag = TRUE;
							$coll_counter = 1;
							$last_coll = count($col_array);
							foreach ($col_array as $coll)
							{
								$select_stack .= $coll;
								if($coll_counter <= $last_coll && $select_counter < $last_col)
								{
									$select_stack .= ',';
								}
								$coll_counter++;
							}
							//First Remove ">>" From variable Column AND THEN Explode with Proposed Column name & Custom function String
							$cache1 = explode(':>', str_replace(">>","",$column));
							$function_stack[$key] = $cache1[0]."->".$cache1[1];
						}
					}
					else
					{
						$select_stack .= $column;
						if($select_counter < $last_col)
						{
							$select_stack .= ',';
						}
					}	
					$select_counter++;
				}
				$this->db->select($select_stack);
				if (isset($options))
				{
					// echo "string";
					$this->limits($options);
				}
				$show_data = $this->db->get_where($tbl,array('Status'=>'A'));
				if($show_data->num_rows() > 0)
				{
					if($function_flag === FALSE)
					{
						return $show_data->result_array(); //returns Result Array
					}
					else {
						if(is_array($function_stack))
						{
							$this->load->library('str_function_library');
							foreach ($function_stack as $key => $str_function)
							{
								foreach ($show_data->result_array() as $rownum => $row)
								{
									$cache_call = '';
									$cache_response = '';
									$cache_seperator = '';

									//UnPack Column & String Function
									$cache_seperator = explode('->', $str_function);
									//Create String Function Call code
									$cache_call = $this->str_function_library->substitutor($cache_seperator[1],$row);
									//Clear Cache
									//Receive Response From String Function
									$cache_response = $this->str_function_library->call($cache_call);
									if(!empty($cache_response))
									{
										//Add New Column with its respective value
										$show_data->result_array[$rownum][$cache_seperator[0]] = $cache_response;

										//Remove The Replacable Column From $show_data arrays
										foreach ($this->str_function_library->get_careted_columns($cache_seperator[1]) as $colllnum => $colll)
										{
											$unset_cols[] = $colll;
											//unset($show_data->result_array[$rownum][$colll]);
										}
									}
									else
									{
										$this->errorlog_library->entry('Fetch model > get_array_data > show > case : '.$case.' > Failed to Return Cache Response.');
										return FALSE;
									}
								}
								
							}
							foreach ($show_data->result_array() as $rownum => $row)
							{
								foreach (array_unique($unset_cols) as $collllll => $colll)
								{
									unset($show_data->result_array[$rownum][$colll]);
								}
							}
							/*echo "<pre>";
							print_r(array_unique($unset_cols));
							echo "</pre>";
*/
							return $show_data->result_array(); // Return Result Array
						}
						else
						{
							$this->errorlog_library->entry('Fetch model > get_array_data > show > case : '.$case.' > Argument function_stack is not array.');
							return FALSE;
						}
					}
				}
				else {
					$this->errorlog_library->entry('Fetch model > get_array_data > show > case : '.$case.' > Failed to Return MySQL Result Array with Selected Columns.');
					return FALSE;
				}
			}
			else
			{
				$this->errorlog_library->entry('Fetch model > get_array_data > Argument output, tbl or case is null.');
				return FALSE;
			}			
		}

		public function show_datatable($input=NULL)
	 	{
	 		if(!is_null($input) && is_array($input))
			{
				if(array_key_exists('columns', $input) && array_key_exists('table', $input))
				{
					//$input['columns'][] = "ID";
					$aColumns = $input['columns'];

					/* Indexed column (used for fast and accurate table cardinality) */
					$sIndexColumn = "ID";
					
					/* DB table to use */
					$tbl = $this->db_library->get_tbl($input['table']);
					//echo $tbl;
					$sTable = $tbl;
					$sLimit = "";
					if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
					{
						$sLimit = "LIMIT ".intval( $_GET['iDisplayStart'] ).", ".
							intval( $_GET['iDisplayLength'] );
					}
					
					
					/*
					 * Ordering
					 */
					$sOrder = "";
					if ( isset( $_GET['iSortCol_0'] ) )
					{
						$sOrder = "ORDER BY  ";
						for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
						{
							if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
							{
								$sOrder .= "`".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."` ".
									($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
							}
						}
						
						$sOrder = substr_replace( $sOrder, "", -2 );
						if ( $sOrder == "ORDER BY" )
						{
							$sOrder = "";
						}
					}
					
					
					/* 
					 * Filtering
					 * NOTE this does not match the built-in DataTables filtering which does it
					 * word by word on any field. It's possible to do here, but concerned about efficiency
					 * on very large tables, and MySQL's regex functionality is very limited
					 */
					$sWhere = "";
					//if(array_key_exists('where', $input))
					$sWhere = "WHERE Added_by=";
					if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
					{
						$sWhere .= " AND (";
						for ( $i=0 ; $i<count($aColumns) ; $i++ )
						{
							$sWhere .= "`".$aColumns[$i]."` LIKE '%".$_GET['sSearch']."%' OR ";
						}
						$sWhere = substr_replace( $sWhere, "", -3 );
						$sWhere .= ')';
					}
					
					/* Individual column filtering */
					for ( $i=0 ; $i<count($aColumns) ; $i++ )
					{
						if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
						{
							if ( $sWhere == "" )
							{
								$sWhere = "WHERE ";
							}
							else
							{
								$sWhere .= " AND ";
							}
							$sWhere .= "`".$aColumns[$i]."` LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
						}
					}
					/*echo "<br>";
					echo $sWhere;
					echo "<br>";*/
					/*
					 * SQL queries
					 * Get data to display
					 */
					$sQuery = "
						SELECT SQL_CALC_FOUND_ROWS `".str_replace(" , ", " ", implode("`, `", $aColumns))."`
						FROM   $sTable
						$sWhere
						$sOrder
						$sLimit
						";
					$rResult = $this->db->query($sQuery);
					/* Data set length after filtering */
					$sQuery = "
						SELECT FOUND_ROWS()
					";
					$rResultFilterTotal = $this->db->query($sQuery);
					$aResultFilterTotal = $rResultFilterTotal->result_array();;
					$iFilteredTotal = $aResultFilterTotal[0]['FOUND_ROWS()'];
					/* Total data set length */
					$sQuery = "
						SELECT COUNT(`".$sIndexColumn."`)
						FROM   $sTable
					";
					$rResultTotal = $this->db->query($sQuery);
					$aResultTotal = $rResultTotal->result_array();
					$iTotal = $aResultTotal[0]['COUNT(`ID`)'];
					
					/*
					 * Output
					 */
					$output = array(
						"sEcho" => intval($_GET['sEcho']),
						"iTotalRecords" => $iTotal,
						"iTotalDisplayRecords" => $iFilteredTotal,
						"aaData" => array()
					);
					
					$output['aaData'] = $rResult->result_array();
					foreach ($rResult->result_array() as $key => $value)
					{
						$output['aaData'][$key]['links'] = "<div><span class='blue' onClick='view(".$output['aaData'][$key]['ID'].")'><i class='fa fa-plus-square bigger-130'></i></span>&nbsp;&nbsp;<a class='green' href=".base_url('contact/add/clients/'.$output['aaData'][$key]['ID'])."><i class='fa fa-pencil bigger-130'></i></a>&nbsp;&nbsp;<a class='red' href=".base_url('contact/delete/'.$output['aaData'][$key]['ID'])."><i class='fa fa-trash-o bigger-130'></i></a></div>";
						unset($output['aaData'][$key]['ID']);
					}
					echo json_encode( $output );
				}
				else
				{
			 		$this->errorlog_library->entry('Fetch_model > show_datatable > Argument input either not contains column or tablename.');
					return FALSE;
				}
			}
			else
			{
		 		$this->errorlog_library->entry('Fetch_model > show_datatable > Argument input is null or invalid.');
				return FALSE;
			}
	 	}
	}


?>