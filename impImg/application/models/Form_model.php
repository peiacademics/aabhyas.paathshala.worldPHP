<?php
	class Form_model extends CI_Model{

		function show($input=NULL,$output='*')
		{
			switch(gettype($input))
			{
				case 'NULL':
					$this->errorlog_library->entry('Form model > show > argument input is null.');
					return FALSE;
				break;
				//--------------------------------------
				case 'string':
					if(!$tbl = $this->db_library->get_tbl($input))
					{
						$this->errorlog_library->entry('Form model > show > input type case : string > table not found.');
						return FALSE;
					}
					else
					{
						switch(gettype($output))
						{
							case 'string':
								if($output === "*")
								{
									$show_data = $this->db->get_where($tbl,array('Status'=>'A'));
									return $show_data->result_array(); //returns Array
									break;
								}
								else
								{
									if (strpos($output,',') !== FALSE)
									{
										$this->errorlog_library->entry('Form model > show > input type case : string > argument output contains comma');
										return FALSE;
									}
									else
									{
										$this->db->select($output);
										$show_data = $this->db->get_where($tbl,array('Status'=>'A'));
										return $show_data->result_array(); //returns Array
									}
								}
							break;
							//-------------------------------
							case 'array':
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
											$this->errorlog_library->entry('Form model > show > input type case : string > outpu type case : array > argument col_array not found');
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
													//print_r($cache_seperator);
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
															unset($show_data->result_array[$rownum][$colll]);
														}
													}
													else
													{
														$this->errorlog_library->entry('Form model > show > input type case : string > argument output case : array > Failed to Return Cache Response.');
														return FALSE;
													}
												}
											}
											return $show_data->result_array(); // Return Result Array
										}
										else
										{
											$this->errorlog_library->entry('Form model > show > input type case : string > argument output case : array > Argument function_stack is not array.');
											return FALSE;
										}

										
									}
								}
								else {
									$this->errorlog_library->entry('Form model > show > input type case : string > argument output case : array > Failed to Return MySQL Result Array with Selected Columns.');
									return FALSE;
								}
							break;
							//---------------------------------
							default:
								$this->errorlog_library->entry('Form model > show > input type case : string > argument output is invalid.');
								return FALSE;
							break;
						}
					}
				break;
				//---------------------------------
				case 'array':
					foreach ($input as $shrtTbl => $conditions_array)
					{
						if(!$tbl = $this->db_library->get_tbl($shrtTbl))
						{
							$this->errorlog_library->entry('Form model > show > input type case : array > table not found.');
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
											$this->errorlog_library->entry('Form model > show > input type case : array > argument output multiple OR conditions were failed to seperate.');
											return FALSE;
										}
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
											$this->errorlog_library->entry('Form model > show > input type case : array > argument output multiple AND conditions were failed to seperate.');
											return FALSE;
										}
										$this->db->where($and_stack);
									}
									//Normal Condition
									else {
										$this->db->where($column_name,$value);
									}
								}

								switch(gettype($output))
								{
									case 'string':
										if($output === "*")
										{
											if(is_object($show_data = $this->db->get($tbl)))
											{
												return $show_data->result_array(); //returns Array
											}
											else {
												$this->errorlog_library->entry('Form model > show > input type case : array > argument output case : string > Failed to Return MySQL Result Array with All Columns.');
												return FALSE;
											}
											break;
										}
										else
										{
											if (strpos($output,',') !== FALSE)
											{
												$this->errorlog_library->entry('Form model > show > input type case : array > argument output contains comma');
												return FALSE;
											}
											else
											{
												$this->db->select($output);
												if(is_object($show_data = $this->db->get($tbl)))
												{
													return $show_data->result_array(); //returns Array
												}
												else {
													$this->errorlog_library->entry('Form model > show > input type case : array > argument output case : string > Failed to Return MySQL Result Array with Single Column.');
													return FALSE;
												}
											}
										}
									break;
									//---------------------------------
									case 'array':
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
												if(!$col_array = $this->str_function_library->get_careted_columns($column))
												{
													$this->errorlog_library->entry('Form model > show > input type case : string > outpu type case : array > argument col_array not found');
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
										$this->db->where('Status','A');
										$show_data = $this->db->get($tbl);
										if($show_data->num_rows() > 0)
										{
											if($function_flag === FALSE)
											{
												return $show_data->result_array(); //returns Result Array
											}
											else {
												//print_r($function_stack);
												if(is_array($function_stack))
												{
													$this->load->library('str_function_library');
													foreach ($function_stack as $key => $str_function)
													{
														foreach ($show_data->result_array() as $rownum=>$row)
														{
															//Clear Cache
															$cache_call = '';
															$cache_response = '';
															$cache_seperator = '';

															//UnPack Column & String Function
															$cache_seperator = explode('->', $str_function);
															//Create String Function Call code
															$cache_call = $this->str_function_library->substitutor($cache_seperator[1],$row);

															//Receive Response From String Function
															$cache_response = $this->str_function_library->call($cache_call);
															if($cache_response !== FALSE)
															{
																//Add New Column with its respective value
																$show_data->result_array[$rownum][$cache_seperator[0]] = $cache_response;

																//Remove The Replacable Column From $show_data arrays
																foreach ($this->str_function_library->get_careted_columns($cache_seperator[1]) as $colllnum => $colll)
																{
																	unset($show_data->result_array[$rownum][$colll]);
																}
															}
															else
															{
																$this->errorlog_library->entry('Form model > show > input type case : string > argument output case : array > Failed to Return Cache Response.');
																return FALSE;
															}
														}
													}
													return $show_data->result_array();  //returns Result Array 
												}
												else
												{
													$this->errorlog_library->entry('Form model > show > input type case : string > argument output case : array > Argument function_stack is not array.');
													return FALSE;
												}
											}
										}
										else {
											$this->errorlog_library->entry('Form model > show > input type case : string > argument output case : array > Failed to Return MySQL Result Array with Selected Columns.');
											return FALSE;
										}
									break;
									//---------------------------------
									default:
										$this->errorlog_library->entry('Form model > show > input type case : array > argument output is invalid.');
										return FALSE;
									break;
								}
							}
							else {
								$this->errorlog_library->entry('Form model > show > input type case : array > variable columns_array is not an array.');
								return FALSE;
							}
						}
					}
				break;
				//---------------------------------
				default:
					$this->errorlog_library->entry('Form model > show > argument input is invalid.');
					return FALSE;
				break;		
			}	
		}

		public function add($input=NULL,$rules=NULL)
		{
			if(!is_null($input) && array_key_exists('columns', $input))
			{
				if(is_array($input) && is_array($input['columns']) && !empty($input['columns']))
				{
					$this->load->library('form_validation');

					//SET DATA
					$ready = $this->set_data($input['columns']);

					//SET RULES
					$steady = $this->set_rules($input,$rules);

	 				//VALIDATIONS
	 				if($ready && $steady)
	 				{
		 				$go = $this->validate();
		 			}
		 			//Contains Errors if returned an array
	 				if (is_array($go))
	                {
	                	//Return errors
	                	return $go;
	                }
	                else
	                {
	                	if($table_flag = array_key_exists('table', $input) ? TRUE : FALSE)
	                	{
	                		$insert = $this->db_library->insert($input['table'],$input['columns']);
	                		return $insert;
	                	}
	                	else
	                	{
	                		$table_seperation = $this->db_library->table_seperator($input['columns']);
	                		if($multiinsert = $this->db_library->insert($table_seperation))
	                		{
	                			return TRUE;
	                		}
	                		else
	                		{
	                			return $multiinsert;
	                		}
	                	}
	                }
	            }
				else
				{
					$this->errorlog_library->entry('Form model > add > Columns are not configured correctly');
					return FALSE;
				}

			}
			else
			{
				$this->errorlog_library->entry('Form model > add > Either argument input is null or key `columns` is not specified');
				return FALSE;
			}
		}

		public function edit($input=NULL,$rules=NULL)
		{
			if(!is_null($input) && array_key_exists('columns', $input) && array_key_exists('where', $input))
			{
				if(is_array($input) && is_array($input['columns']) && is_array($input['where']))
				{
					$this->load->library('form_validation');

					//SET DATA
					$ready = $this->set_data($input['columns']);

					//SET RULES
					$steady = $this->set_rules($input,$rules);

	 				//VALIDATIONS
	 				if($ready && $steady)
	 				{
		 				$go = $this->validate();
		 			}

		 			//Contains Errors if returned an array
	 				if (is_array($go))
	                {
	                	//Return errors
	                	return $go;
	                }
	                else
	                {
	                	if($table_flag = array_key_exists('table', $input) ? TRUE : FALSE)
	                	{
	                		$update = $this->db_library->update($input['table'],$input['columns'],$input['where']);
	                		return $update;
	                	}
	                	else
	                	{
	                		$table_seperation = $this->db_library->table_seperator($input['columns'],$input['where']);
	                		if($multiupdate = $this->db_library->update($table_seperation))
	                		{
	                			return TRUE;
	                		}
	                		else
	                		{
	                			return $multiupdate;
	                		}
	                	}
	                }
	            }
				else
				{
					$this->errorlog_library->entry('Form model > edit > Columns are not configured correctly');
					return FALSE;
				}

			}
			else
			{
				$this->errorlog_library->entry('Form model > edit > Either argument input is null or key `columns` is not specified or key `where` is not specified');
				return FALSE;
			}
		}

		function delete($input=NULL)
		{
			if(!is_null($input) && is_array($input))
			{
				if($delete = $this->db_library->delete($input))
        		{
        			return TRUE;
        		}
        		else
        		{
        			return $delete;
        		}
			}
			else
			{
				$this->errorlog_library->entry('Form model > delete > Either argument input is null or not an array');
				return FALSE;
			}
		}

		private function tables_counter($columns_array,$result='count')
		{
			if(is_array($columns_array) && count($columns_array) > 0)
			{
				$num_cols = count($column_array);
				$table_array = array();
				foreach ($columns_array as $column=>$value)
				{
					if(strpos($column, '>') !== FALSE)
					{
						$cache1 = explode('>', $column);
						$table_array[] = $cache1[0];
					}
				}

				if($result !== 'count')
				{
					return count($table_array) === $num_cols ? $table_array : '1';
				}
				else
				{
					return count($table_array) === $num_cols ? count($table_array) : '1';
				}

			}
			else
			{
				$this->errorlog_library->entry('Form model > tables_counter > Invalid columns data');
				return FALSE;
			}
		}

		public function set_data($columns=NULL)
		{
			if(is_array($columns) && count($columns) > 0)
			{
				$this->form_validation->set_data($columns);
				return TRUE;
			}
			else
			{
				$this->errorlog_library->entry('Form model > set_data > argument column is not an array');
				return FALSE;
			}
		}

		public function set_rules($input=NULL,$rules=NULL)
		{
			if(is_array($input))
			{
				$this->load->library('form_validation');
				$this->load->config('skyq/table_config');
				$table_flag = FALSE;
				$results = array();
				if(!is_array($rules))
				{
					$rules = $this->config->item($input['table']);
				}

				$table_flag = array_key_exists('table', $input) ? TRUE : FALSE;

				foreach ($input['columns'] as $col=>$col_val)
				{
					if($table_flag)
					{
						if(strpos($col, '>') !== FALSE)
						{
							$this->errorlog_library->entry('Form model > set_rules > variable col must not contain > symbol when table is specified in input array');
							return FALSE;
						}
						else
						{
							if(is_array($rules_config = $this->config->item($input['table'])))
							{
								if(array_key_exists($col, $rules))
								{
									//Fetch custom rules
									$column_rules = $rules[$col]['rules'];
								}
								else
								{
									//Fetch rules from config
									$column_rules = array_key_exists($col, $rules_config) ? $rules_config[$col]['rules'] : NULL;
								}

								//Checks for array fields like checkboxes,multiselect,fileupload
								if(is_array($col_val))
								{
									$this->form_validation->set_rules($col.'[]',strip_data($col),$column_rules);
									$results[$col] = TRUE;
								}
								else
								{	
									$this->form_validation->set_rules($col,strip_data($col),$column_rules);
									$results[$col] = TRUE;
								}
							}
							else
							{
								$this->errorlog_library->entry('Form model > set_rules > variable input[table] contains invalid table short code : '.$input['table']);
								return FALSE;
							}
						}
					}
					else
					{
						$cache1 = explode('>',$col);
						if(array_key_exists($col, $rules))
						{
							//Fetch rules
							$column_rules = $rules[$col];
							//Checks for array fields like checkboxes,multiselect,fileupload 	
							if(is_array($col_val))
							{
								$this->form_validation->set_rules($col.'[]',strip_data($cache1[1]),$column_rules);
								$results[$col] = TRUE;
							}
							else
							{
								$this->form_validation->set_rules($col,strip_data($cache1[1]),$column_rules);
								$results[$col] = TRUE;
							}
						}
						elseif(is_array($rules_config = $this->config->item($cache1[0])))
						{
							//Fetch rules from tables config
							$column_rules = array_key_exists($cache1[1], $rules_config) ? $rules_config[$cache1[1]]['rules'] : NULL;
							//Checks for array fields like checkboxes,multiselect,fileupload 	
							if(is_array($col_val))
							{
								$this->form_validation->set_rules($col.'[]',strip_data($cache1[1]),$column_rules);
								$results[$col] = TRUE;
							}
							else
							{
								$this->form_validation->set_rules($col,strip_data($cache1[1]),$column_rules);
								$results[$col] = TRUE;
							}
						}
						else
						{
							$this->errorlog_library->entry('Form model > set_rules > variable cache1[0] contains invalid table short code : '.$cache1[0]);
							return FALSE;
						}
					}
				}

				return FALSE === in_array(FALSE, $results) ? TRUE : FALSE;
			}
			else
			{
				$this->errorlog_library->entry('Form model > set_rules > Either argument input is not an array or argument rules is not an array');
				return FALSE;
			}
		}

		public function validate()
		{
			if(count($this->form_validation->check_buffer()) > 0)
			{
				if ($this->form_validation->run() == FALSE)
	            {
	            	return $this->form_validation->error_array();
	            }
	            else {
	            	return TRUE;
	            }
	        }
	        else {
				$this->errorlog_library->entry('Form model > validate > Unnecessarily validate function is called.');
	        	return FALSE;
	        }
		}
	}
?>