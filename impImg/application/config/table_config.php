<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	$config['AR'] = array(
			'Types'=>array(
					'rules'=> 'required',

				),
			'Datatype'=>array(
					'rules'=> 'required'
				),
			'Name'=>array(
					'rules'=> 'required'
				),
			'Default_value'=>array(
					'rules'=> 'required'
				),
			'Description'=>array(
					'rules'=> 'required'
				)
		);
	$config['CA'] = array(
			'Method_ID'=>array(
					'rules'=> 'required'
				),
			'Method_For'=>array(
					'rules'=> 'required'
				),
			'Method_Which'=>array(
					'rules'=> 'required'
				),
			'Description'=>array(
					'rules'=> 'required'
				),
			'Calls_status'=>array(
					'rules'=> 'required'
				)
		);
	$config['US'] = array(
			'Timezone'=>array(
					'rules'=> 'required'
				),
			'Date_Format'=>array(
					'rules'=> 'required'
				),
			'Time_Format'=>array(
					'rules'=> 'required'
				),
			'Type'=>array(
					'rules'=> 'required'
				),
			'Name'=>array(
					'rules'=> 'required'
				),
			'Email'=>array(
					'rules'=> 'required'
				),
			'Passowrd'=>array(
					'rules'=> 'required'
				),
			'Language_ID'=>array(
					'rules'=> 'required'
				)
		);
	$config['DT'] = array(
			'Title'=>array(
					'rules'=> 'required'
				),
		);
	$config['F'] = array(
			'Title'=>array(
					'rules'=> 'required'
				),
			'File_type'=>array(
					'rules'=> 'required'
				),
			'File_categories'=>array(
					'rules'=> 'required'
				)
		);
	$config['FU'] = array(
			'Title'=>array(
					'rules'=> 'required'
				),
			'Output'=>array(
					'rules'=> 'required'
				),
			'Format'=>array(
					'rules'=> 'required'
				),
			'Datatype'=>array(
					'rules'=> 'required'
				),
			'File_ID'=>array(
					'rules'=> 'required'
				)
		);
	$config['IN'] = array(
			'Method_ID'=>array(
					'rules'=> 'required'
				),
			'View_ID'=>array(
					'rules'=> 'required'
				),
			'Conditional'=>array(
					'rules'=> 'required'
				)
		);
	$config['LO'] = array(
			'Type'=>array(
					'rules'=> 'required' 
				),
			'Sub_type'=>array(
					'rules'=> 'required' 
				),
			'Last_record'=>array(
					'rules'=> 'required' 
				)
		);
	$config['P'] = array(
			'Project_name'=>array(
					'rules'=> 'required'
				),
			'Client_ID'=>array(
					'rules'=> 'required'
				)
		);
	$config['V'] = array(
			'Root_name'=>array(
					'rules'=> 'required'
				),
			'File_name'=>array(
					'rules'=> 'required'
				),
			'Output'=>array(
					'rules'=> 'required'
				),
			'Type'=>array(
					'rules'=> 'required'
				)
		);
	//$this->config->load('table');
	$config['LN'] = array(
			'Title'=>array(
					'rules'=> 'required|is_unique[languages.Title]'
				),
			'Substitute_English'=>array(
					'rules'=> 'required'
				)
		);
	$config['TR'] = array(
			'Word'=>array(
					'rules'=> 'required'
				),
			'Translation'=>array(
					'rules'=> 'required'
				),
			'Language_ID'=>array(
					'rules'=> 'required'
				)
		);
	$config['M'] = array(
			'Meeting_type'=>array(
					'rules'=> 'required'
				),
			'Client_name'=>array(
					'rules'=> 'required'
				),
			'Team_members'=>array(
					'rules'=> 'required'
				),
			'Project_ID'=>array(
					'rules'=> 'required'
				),
			'Date'=>array(
					'rules'=> 'required'
				),
			'End'=>array(
					'rules'=> 'required'
				),
			'Start_time'=>array(
					'rules'=> 'required'
				),
			'Subject'=>array(
					'rules'=> 'required'
				),
			'Topics'=>array(
					'rules'=> 'required'
				),
			'End_time'=>array(
					'rules'=> 'required'
				)
		);

	$config['PP'] = array(
			'products_ID'=>array(
					'rules'=> 'required'
				),
			'quantity'=>array(
					'rules'=> 'required'
				),
			'purchase_cost'=>array(
					'rules'=> 'required'
				),
			'Model_ID'=>array(
					'rules'=> 'required'
				)
		);
?>