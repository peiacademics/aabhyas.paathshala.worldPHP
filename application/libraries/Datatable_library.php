<?php
/*

 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simply to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */
class Datatable_library {
	
	public function __construct()
	{
		$this->ci =& get_instance();
		$this->ci->load->library('db_library');
		//$this->ci->load->library('database');
		$this->ci->config->load('skyq/my_config');
		$this->my_config = $this->ci->config->item('skyq');
	}

	public function get_data($input,$output,$options=null)
	{
		// DB table to use
		if(is_array($input))
		{
			$table = key($input);
		}
		else
		{
			$tbl = $input;
			$table = $tbl;
		}
		// Table's primary key
		$primaryKey = 'ID';
		 
		// Array of database columns which should be read and sent back to DataTables.
		// The `db` parameter represents the column name in the database, while the `dt`
		// parameter represents the DataTables column identifier. In this case simple
		// indexes
		$columns = array();
		$i = 0;
		foreach($output as $column)
		{
			// if( strpos($column, '^') !== false ){
			// 	preg_match('#\^(.*?)\^#', $column, $match);
			// 	// print_r($match[1]);
			// 	$column=$match[1];
			// }
			// $columns[] = array("db"=>$column,"dt"=>$column);
			$columns[] = array("db"=>$column,"dt"=>$i);
			$i++;
		}

		// print_r($columns);
		/*$columns = array(
		    array( 'db' => 'Client_name', 'dt' => 0 ),
		    array( 'db' => 'Company_name',  'dt' => 1 ),
		    array( 'db' => 'Email',   'dt' => 2 ),
		    array( 'db' => 'Address',     'dt' => 3 ),
		    array( 'db' => 'Contact_no',     'dt' => 4 )
		    array(
		        'db'        => 'start_date',
		        'dt'        => 4,
		        'formatter' => function( $d, $row ) {
		            return date( 'jS M y', strtotime($d));
		        }
		    ),
		    array(
		        'db'        => 'salary',
		        'dt'        => 5,
		        'formatter' => function( $d, $row ) {
		            return '$'.number_format($d);
		        }
		    )
		);*/
		$this->ci->load->database();
		// SQL server connection information
		$sql_details = array(
		    'user' => $this->ci->db->username,
		    'pass' => $this->ci->db->password,
		    'db'   => $this->ci->db->database,
		    'host' => $this->ci->db->hostname
		);
		 
		 
		/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
		 * If you just want to use the basic configuration for DataTables with PHP
		 * server-side, there is no need to edit below this line.
		 */
		$this->ci->load->library('SSP');
		//require( 'ssp.class.php' );
		//var_dump($columns);
		// print_r($options);
		// print_r($_GET);
		return ($this->ci->ssp->simple( $_GET, $sql_details, $table, $primaryKey, $columns,$input,$output,$options));
		//return array($_GET, $sql_details, $table, $primaryKey, $columns);
	}
}
?>