<?php
/*
 * Helper functions for building a DataTables server-side processing SQL query
 *
 * The static functions in this class are just helper functions to help build
 * the SQL used in the DataTables demo server-side processing scripts. These
 * functions obviously do not represent all that can be done with server-side
 * processing, they are intentionally simple to show how it works. More complex
 * server-side processing operations will likely require a custom script.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */
/*// REMOVE THIS BLOCK - used for DataTables test environment only!
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/mysql.php';
if ( is_file( $file ) ) {
	include( $file );
}*/
class SSP {

	public function __construct()
	{
		$this->ci =& get_instance();
		$this->ci->load->model('fetch_model');
		//$this->ci->load->library('database');
		$this->ci->config->load('skyq/my_config');
		$this->ci->config->load('skyq/actions_config');
		$this->actions_config = $this->ci->config->item('actions');
		$this->my_config = $this->ci->config->item('skyq');
	}

	/**
	 * Create the data output array for the DataTables rows
	 *
	 *  @param  array $columns Column information array
	 *  @param  array $data    Data from the SQL get
	 *  @return array          Formatted data in a row based format
	 */
	public function data_output ($data,$start,$length)
	{
		$out = array();
		//total_entries
		$data = self::limit($start,$length,$data);
		foreach ($data as $key => $value) {
			$out[] = array_values($value);
		}
		return $out;
	}
	/**
	 * Database connection
	 *
	 * Obtain an PHP PDO connection from a connection details array
	 *
	 *  @param  array $conn SQL connection details. The array should have
	 *    the following properties
	 *     * host - host name
	 *     * db   - database name
	 *     * user - user name
	 *     * pass - user password
	 *  @return resource PDO connection
	 */
	static function db ( $conn )
	{
		if ( is_array( $conn ) ) {
			return self::sql_connect( $conn );
		}
		return $conn;
	}
	/**
	 * Paging
	 *
	 * Construct the LIMIT clause for server-side processing SQL query
	 *
	 *  @param  array $request Data sent to server by DataTables
	 *  @param  array $columns Column information array
	 *  @return string SQL limit clause
	 */
	static function limit ($start,$length,$data)
	{
		$limitedArray = array();
		if(isset($data) && $data)
	 	{
	 		for ($i=$start; $i<($start+$length); $i++)
			{
				if(array_key_exists($i, $data))
				{
					$limitedArray[] = $data[$i];
				}	
			}
		}
		return $limitedArray;
	}
	/**
	 * Ordering
	 *
	 * Construct the ORDER BY clause for server-side processing SQL query
	 *
	 *  @param  array $request Data sent to server by DataTables
	 *  @param  array $columns Column information array
	 *  @return string SQL order by clause
	 */
	static function order ($orderby,$data)
	{
		$orderbyData = array();
		$orderbyindex = $orderby['column'];
		if(isset($data) && $data)
	 	{
			foreach ($data as $key => $row)
			{
				$colArray = array_keys($row);
			    $orderbyData[$key] = $row[$colArray[$orderbyindex]];
			}
			if($orderby['dir'] == 'asc')
			{
				array_multisort($orderbyData, SORT_ASC, $data);
			}
			else
			{
				array_multisort($orderbyData, SORT_DESC, $data);
			}
		}
		return $data;
	}
	/**
	 * Searching / Filtering
	 *
	 * Construct the WHERE clause for server-side processing SQL query.
	 *
	 * NOTE this does not match the built-in DataTables filtering which does it
	 * word by word on any field. It's possible to do here performance on large
	 * databases would be very poor
	 *
	 *  @param  array $request Data sent to server by DataTables
	 *  @param  array $columns Column information array
	 *  @param  array $bindings Array of values for PDO bindings, used in the
	 *    sql_exec() function
	 *  @return string SQL where clause
	 */
	static function filter ($search,$data)
	{
		if(!empty($search))
		{
			$filteredArray = array();
			if($data)
			{
				foreach ($data as $key => $value)
				{
					foreach ($value as $col=> $val)
					{
						//var_dump($search);
						if(stristr($val,$search) !== FALSE)
						{
							$filteredArray[] = $value;
							break;
						}
					}
				}
			}
			return $filteredArray;
		}
		else
		{
			return $data;
		}
	}
	/**
	 * Perform the SQL queries needed for an server-side processing requested,
	 * utilising the helper functions of this class, limit(), order() and
	 * filter() among others. The returned array is ready to be encoded as JSON
	 * in response to an SSP request, or can be modified if needed before
	 * sending back to the client.
	 *
	 *  @param  array $request Data sent to server by DataTables
	 *  @param  array|PDO $conn PDO connection resource or connection parameters array
	 *  @param  string $table SQL table to query
	 *  @param  string $primaryKey Primary key of the table
	 *  @param  array $columns Column information array
	 *  @return array          Server-side processing response array
	 */
	public function simple ( $request, $conn, $table, $primaryKey, $columns,$input,$output)
	{
		//var_dump($request);
		$data = $this->ci->fetch_model->show($input,$output);
		//var_dump($data);
		if(array_key_exists($table,$this->actions_config) !== FALSE)
		{
			if($data)
			{
				foreach($data as $key => $value)
		 		{
		 			$data[$key]['Link'] = "<div>";
		 			foreach($this->actions_config[$table] as $action)
		 			{
		 				if(array_key_exists('function', $action))
		 				{
				 			$data[$key]['Link'] .= "<span class='label label-".$action['class']."' onClick=".$action['function']."('".$value['ID']."')><i class='fa fa-".$action['icon']." bigger-130'></i></span>&nbsp;&nbsp;";
		 				}
		 				else
		 				{
		 					
		 					if($action['class']=="red")
		 					{
		 						$data[$key]['Link'] .= "<span class='label label-danger ".$action['class']."' id='item".$value['ID']."' onClick='deletef(\"".$value['ID']."\",\"".base_url($action['link'].$value['ID'])."\")'><i class='fa fa-".$action['icon']." bigger-130'></i></span>&nbsp;&nbsp;";
		 						/*$data[$key]['Link'] .= "<script type='text/javascript'>
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
					        </script>";*/
		 					}
		 					else
		 					{
		 						if($action['icon']=="print" || $action['icon']=="download")
		 						{
		 							$data[$key]['Link'] .= "<a class='label label-".$action['class']."' href='#' onclick='window.open(\"".base_url($action['link'].$value['ID'])."\",\"_blank\",\"toolbar=yes, scrollbars=yes, resizable=yes, left=500, width=900, height=800\")'><i class='fa fa-".$action['icon']." bigger-130'></i></a>&nbsp;&nbsp;";
		 						}
		 						else if ($action['icon']=="folder-open-o") {
		 							$data[$key]['Link'] .= "<span class='label label-info ".$action['class']."' id='item".$value['ID']."' onClick='view(\"".$value['ID']."\",\"".base_url($action['link'].$value['ID'])."\")'><i class='fa fa-".$action['icon']." bigger-130'></i></span>&nbsp;&nbsp;";
		 						}
		 						else if ($action['icon']=="paperclip") {
		 							// $data[$key]['Link'] .= "<span class='label label-info ".$action['class']."' id='item".$value['ID']."' onClick='view(\"".$value['ID']."\",\"".base_url($action['link'].$value['ID'])."\")'><i class='fa fa-".$action['icon']." bigger-130'></i></span>&nbsp;&nbsp;";
		 							$data[$key]['Link'] .= "<a class='label label-".$action['class']."' href=javascript:window.open('".base_url($action['link'].$value['ID'])."','mywindowtitle','width=1000','height=600')><i class='fa fa-".$action['icon']." bigger-130'></i></a>&nbsp;&nbsp;";
		 						}
		 						else
		 						{
		 							$data[$key]['Link'] .= "<a class='label label-".$action['class']."' href=".base_url($action['link'].$value['ID'])."><i class='fa fa-".$action['icon']." bigger-130'></i></a>&nbsp;&nbsp;";
		 						}
		 						
		 					}

		 				}
			 			unset($data[$key]['ID']);
			 		}
		 		$data[$key]['Link'] .= "</div>";
		 		}
	 		}
	 	}
	 	else
	 	{
	 		if(isset($data) && $data)
	 		{
		 		foreach($data as $key => $value)
		 		{
			 		$data[$key]['Link'] = '';
			 		unset($data[$key]['ID']);
			 	}
			}
	 	}

		$recordsTotal = ($data) ? count($data) : 0;
		
		//Filter

		$search = $request['search'];
		$data = self::filter($search['value'],$data);
		
		//Sorting
		$sort = $request['order'];
		$orderBy = $sort[0];
		$data = self::order( $orderBy, $data);

		/*
		 * Output
		 */
		$recordsFiltered = ($data) ? count($data) : 0;
		return array(
			"draw"            => intval( $request['draw'] ),
			"recordsTotal"    => intval( $recordsTotal ),
			"recordsFiltered" => intval( $recordsFiltered ),
			"data"            => self::data_output($data,$request['start'],$request['length'])
		);
	}
	/**
	 * The difference between this method and the `simple` one, is that you can
	 * apply additional `where` conditions to the SQL queries. These can be in
	 * one of two forms:
	 *
	 * * 'Result condition' - This is applied to the result set, but not the
	 *   overall paging information query - i.e. it will not effect the number
	 *   of records that a user sees they can have access to. This should be
	 *   used when you want apply a filtering condition that the user has sent.
	 * * 'All condition' - This is applied to all queries that are made and
	 *   reduces the number of records that the user can access. This should be
	 *   used in conditions where you don't want the user to ever have access to
	 *   particular records (for example, restricting by a login id).
	 *
	 *  @param  array $request Data sent to server by DataTables
	 *  @param  array|PDO $conn PDO connection resource or connection parameters array
	 *  @param  string $table SQL table to query
	 *  @param  string $primaryKey Primary key of the table
	 *  @param  array $columns Column information array
	 *  @param  string $whereResult WHERE condition to apply to the result set
	 *  @param  string $whereAll WHERE condition to apply to all queries
	 *  @return array          Server-side processing response array
	 */
	static function complex ( $request, $conn, $table, $primaryKey, $columns, $whereResult=null, $whereAll=null )
	{
		$bindings = array();
		$db = self::db( $conn );
		$localWhereResult = array();
		$localWhereAll = array();
		$whereAllSql = '';
		// Build the SQL query string from the request
		$limit = self::limit( $request, $columns );
		$order = self::order( $request, $columns );
		$where = self::filter( $request, $columns, $bindings );
		$whereResult = self::_flatten( $whereResult );
		$whereAll = self::_flatten( $whereAll );
		if ( $whereResult ) {
			$where = $where ?
				$where .' AND '.$whereResult :
				'WHERE '.$whereResult;
		}
		if ( $whereAll ) {
			$where = $where ?
				$where .' AND '.$whereAll :
				'WHERE '.$whereAll;
			$whereAllSql = 'WHERE '.$whereAll;
		}
		// Main query to actually get the data
		$data = self::sql_exec( $db, $bindings,
			"SELECT SQL_CALC_FOUND_ROWS `".implode("`, `", self::pluck($columns, 'db'))."`
			 FROM `$table`
			 $where
			 $order
			 $limit"
		);
		// Data set length after filtering
		$resFilterLength = self::sql_exec( $db,
			"SELECT FOUND_ROWS()"
		);
		$recordsFiltered = $resFilterLength[0][0];
		// Total data set length
		$resTotalLength = self::sql_exec( $db, $bindings,
			"SELECT COUNT(`{$primaryKey}`)
			 FROM   `$table` ".
			$whereAllSql
		);
		$recordsTotal = $resTotalLength[0][0];
		/*
		 * Output
		 */
		return array(
			"draw"            => intval( $request['draw'] ),
			"recordsTotal"    => intval( $recordsTotal ),
			"recordsFiltered" => intval( $recordsFiltered ),
			"data"            => self::data_output( $columns, $data )
		);
	}
	/**
	 * Connect to the database
	 *
	 * @param  array $sql_details SQL server connection details array, with the
	 *   properties:
	 *     * host - host name
	 *     * db   - database name
	 *     * user - user name
	 *     * pass - user password
	 * @return resource Database connection handle
	 */
	static function sql_connect ( $sql_details )
	{
		try {
			$db = @new PDO(
				"mysql:host={$sql_details['host']};dbname={$sql_details['db']}",
				$sql_details['user'],
				$sql_details['pass'],
				array( PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION )
			);
		}
		catch (PDOException $e) {
			self::fatal(
				"An error occurred while connecting to the database. ".
				"The error reported by the server was: ".$e->getMessage()
			);
		}
		return $db;
	}
	/**
	 * Execute an SQL query on the database
	 *
	 * @param  resource $db  Database handler
	 * @param  array    $bindings Array of PDO binding values from bind() to be
	 *   used for safely escaping strings. Note that this can be given as the
	 *   SQL query string if no bindings are required.
	 * @param  string   $sql SQL query to execute.
	 * @return array         Result from the query (all rows)
	 */
	static function sql_exec ( $db, $bindings, $sql=null )
	{
		// Argument shifting
		if ( $sql === null ) {
			$sql = $bindings;
		}
		$stmt = $db->prepare( $sql );
		//echo $sql;
		// Bind parameters
		if ( is_array( $bindings ) ) {
			for ( $i=0, $ien=count($bindings) ; $i<$ien ; $i++ ) {
				$binding = $bindings[$i];
				$stmt->bindValue( $binding['key'], $binding['val'], $binding['type'] );
			}
		}
		// Execute
		try {
			$stmt->execute();
		}
		catch (PDOException $e) {
			self::fatal( "An SQL error occurred: ".$e->getMessage() );
		}
		// Return all
		return $stmt->fetchAll();
	}
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Internal methods
	 */
	/**
	 * Throw a fatal error.
	 *
	 * This writes out an error message in a JSON string which DataTables will
	 * see and show to the user in the browser.
	 *
	 * @param  string $msg Message to send to the client
	 */
	static function fatal ( $msg )
	{
		echo json_encode( array( 
			"error" => $msg
		) );
		exit(0);
	}
	/**
	 * Create a PDO binding key which can be used for escaping variables safely
	 * when executing a query with sql_exec()
	 *
	 * @param  array &$a    Array of bindings
	 * @param  *      $val  Value to bind
	 * @param  int    $type PDO field type
	 * @return string       Bound key to be used in the SQL where this parameter
	 *   would be used.
	 */
	static function bind ( &$a, $val, $type )
	{
		$key = ':binding_'.count( $a );
		$a[] = array(
			'key' => $key,
			'val' => $val,
			'type' => $type
		);
		return $key;
	}
	/**
	 * Pull a particular property from each assoc. array in a numeric array, 
	 * returning and array of the property values from each item.
	 *
	 *  @param  array  $a    Array to get data from
	 *  @param  string $prop Property to read
	 *  @return array        Array of property values
	 */
	static function pluck ( $a, $prop )
	{
		$out = array();
		for ( $i=0, $len=count($a) ; $i<$len ; $i++ ) {
			$out[] = $a[$i][$prop];
		}
		return $out;
	}
	/**
	 * Return a string from an array or a string
	 *
	 * @param  array|string $a Array to join
	 * @param  string $join Glue for the concatenation
	 * @return string Joined string
	 */
	static function _flatten ( $a, $join = ' AND ' )
	{
		if ( ! $a ) {
			return '';
		}
		else if ( $a && is_array($a) ) {
			return implode( $join, $a );
		}
		return $a;
	}
}