<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

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
					'rules'=> 'required|valid_email'
				),
			'Password'=>array(
					'rules'=> 'required'
				),
			'Language_ID'=>array(
					'rules'=> 'required'
				),
			'alert_interval'=>array(
					'rules'=> 'required'
				),
			'Company_Name'=>array(
					'rules'=> 'required'
				),
			'Address'=>array(
					'rules'=> 'required'
				),
			'Contact'=>array(
					'rules'=> 'required'
				)
		);

	$config['SS'] = array(
			'path'=>array(
					'rules'=> 'required'
				)
		);

	/*$config['ST'] = array(
			's_name'=>array(
					'rules'=> 'required'
				)
		);*/

	$config['TDS'] = array(
		'name'=>array(
				'rules'=> 'required'
			)
	);

	$config['BSC'] = array(
		'name'=>array(
				'rules'=> 'required'
			)
	);

	$config['BNC'] = array(
		'name'=>array(
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
	
	$config['LN'] = array(
			'Title'=>array(
					'rules'=> 'required'
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
	$config['HC'] = array(
			'Title'=>array(
					'rules'=> 'required'
				),
			'Icon'=>array(
					'rules'=> 'required'
				)
			);
	$config['H'] = array(
			'Question'=>array(
					'rules'=> 'required'
				),
			'Answer'=>array(
					'rules'=> 'required'
				),
			'Level'=>array(
					'rules'=> 'required'
				)
			);

	$config['T'] = array(
			'transaction_type'=>array(
					'rules'=> 'required'
				),
			'date'=>array(
					'rules'=> 'required'
				),
			'amount'=>array(
					'rules'=> 'required|numeric'
				),
			'payment_mode_ID'=>array(
					'rules'=> 'required'
				),
			'expence_category_ID'=>array(
					'rules'=> 'required'
				)
		);

	$config['CT'] = array(
			'transaction_type'=>array(
					'rules'=> 'required'
				),
			'date'=>array(
					'rules'=> 'required'
				),
			'amount'=>array(
					'rules'=> 'required|numeric'
				),
			'payment_mode_ID'=>array(
					'rules'=> 'required'
				),
			'expence_category_ID'=>array(
					'rules'=> 'required'
				)
		);

	$config['BA'] = array(
			'bank_name'=>array(
					'rules'=> 'required'
				),
			'branch_name'=>array(
					'rules'=> 'required'
				),
			'ifsc_code'=>array(
					'rules'=> 'required'
				),
			'account_number'=>array(
					'rules'=> 'required'
				),
			'account_opening_date'=>array(
					'rules'=> 'required'
				)
		);	


		$config['PH'] = array(
			'phone_type'=>array(
					'rules'=> 'required'
				),
			'phone_number'=>array(
					'rules'=> 'numeric|required'
				),
			'person_ID'=>array(
				'rules'=>'required'
			)
		);

		$config['AD'] = array(
			'address_type'=>array(
					'rules'=> 'required'
				),
			'address'=>array(
					'rules'=> 'required'
				)
		);		
	
		$config['EC'] = array(
			'title'=>array(
					'rules'=> 'required'
				)
		);

		$config['BR'] = array(
			'name'=>array(
					'rules'=> 'required'
				)
		);

		$config['BT'] = array(
			'name'=>array(
					'rules'=> 'required'
				)
		);

		$config['SB'] = array(
			'name'=>array(
					'rules'=> 'required'
				)
		);

		$config['CS'] = array(
			'name'=>array(
					'rules'=> 'required'
				)
		);

		$config['PM'] = array(
			'title'=>array(
					'rules'=> 'required'
				)
		);
			
		$config['AT'] = array(
			'employee_ID'=>array(
					'rules'=> 'required'
				)
		);

		$config['DS'] = array(
			'post'=>array(
					'rules'=> 'required'
				)
		);


		$config['DSP'] = array(
			'designation_ID'=>array(
					'rules'=> 'required'
				)
		);

		$config['SL'] = array(
			'Total_Amount'=>array(
					'rules'=> 'required'
				)/*,
			'date'=>array(
					'rules'=> 'is_unique[salary.date]'
				)*/
		);


	$config['SLP'] = array(
		'salary_ID'=>array(
				'rules'=> 'required'
			)
	);

	$config['EL'] = array(
			'Page_path'=>array(
					'rules'=> 'required'
				)
		);


	
	$config['RQ'] = array(
			'req_to'=>array(
					'rules'=> 'required'
				)
		);
	$config['TK'] = array(
			'title'=>array(
					'rules'=> 'required'
				)
		);

		$config['TKS'] = array(
			'task_ID'=>array(
					'rules'=> 'required'
				)
		);

		$config['PI'] = array(
			'School'=>array(
					'rules'=> 'required'
				)
		);

		$config['CI'] = array(
			'School'=>array(
					'rules'=> 'required'
				)
		);

		$config['GD'] = array(
			'Name'=>array(
					'rules'=> 'required'
				),
			'Email'=>array(
				'rules'=>'required'
			)
		);

		$config['ADT'] = array(
			'Student_ID'=>array(
					'rules'=> 'required'
				)
		);

		$config['IN'] = array(
			'Student_ID'=>array(
					'rules'=> 'required'
				)
		);

		$config['FR'] = array(
			'Student_ID'=>array(
					'rules'=> 'required'
				)
		);

		$config['CL'] = array(
			'Branch_ID'=>array(
					'rules'=> 'required'
				)
		);

		$config['C'] = array(

		'list_ID'=>array(

				'rules'=> 'required'

			),

		'list_Name'=>array(

				'rules'=> 'required'//|is_unique[customers.email]

			)

	);



	$config['R'] = array(

			'contactID'=>array(

					'rules'=> 'required'

				)/*,

			'Interval'=>array(

					'rules'=> 'required'

				)*/

		);

	$config['CR'] = array(
		'contact_ID'=>array(
			'rules'=> 'required'
		)
	);

	$config['AC'] = array(
		'contact_ID'=>array(
			'rules'=> 'required'
		)
	);

	$config['AR'] = array(
		'reason'=>array(
			'rules'=> 'required'
		)
	);

	$config['SM'] = array(
		'sms'=>array(
			'rules'=> 'required'
		)
	);

	$config['ST'] = array(
		'Name'=>array(
			'rules'=> 'required'
		),
		'Email'=>array(
			'rules'=>'required'
		)
	);

	$config['LC'] = array(
		'contact_ID'=>array(
			'rules'=> 'required'
		)
	);

	$config['DB'] = array(
		'student_ID'=>array(
			'rules'=> 'required'
		)
	);

	$config['DR'] = array(
		'student_ID'=>array(
			'rules'=> 'required'
		)
	);

	$config['MT'] = array(
		'type'=>array(
			'rules'=> 'required'
		)
	);

	$config['AS'] = array(
		'title'=>array(
			'rules'=> 'required'
		)
	);

	$config['SA'] = array(
		'student_ID'=>array(
			'rules'=> 'required'
		)
	);

	$config['TE'] = array(
		'title'=>array(
			'rules'=> 'required'
		)
	);

	$config['TS'] = array(
		'student_ID'=>array(
			'rules'=> 'required'
		)
	);

	$config['SN'] = array(
		'title'=>array(
			'rules'=> 'required'
		)
	);

	$config['EN'] = array(
		'title'=>array(
			'rules'=> 'required'
		)
	);

	$config['SR'] = array(
		'title'=>array(
			'rules'=> 'required'
		)
	);

	$config['PME'] = array(
		'date'=>array(
			'rules'=> 'required'
		)
	);

	$config['PMA'] = array(
		'student_ID'=>array(
			'rules'=> 'required'
		)
	);

	$config['SC'] = array(
		'student_ID'=>array(
			'rules'=> 'required'
		)
	);

	$config['AW'] = array(
		'title'=>array(
			'rules'=> 'required'
		)
	);

	$config['EA'] = array(
		'employee_ID'=>array(
			'rules'=> 'required'
		)
	);

	$config['TT'] = array(
		'title'=>array(
			'rules'=> 'required'
		)
	);

	$config['COMD'] = array(
		'to'=>array(
			'rules'=> 'required'
		),
		'message'=>array(
			'rules'=> 'required'
		),
	);

	$config['CTK'] = array(
		'type_ID'=>array(
			'rules'=> 'required'
		)
	);

	$config['TC'] = array(
		'task_ID'=>array(
			'rules'=> 'required'
		),
		'comment'=>array(
			'rules'=> 'required'
		)
	);

	$config['SYC'] = array(
		'student_ID'=>array(
			'rules'=> 'required'
		)
	);

	$config['SSC'] = array(
		'student_ID'=>array(
			'rules'=> 'required'
		)
	);

	$config['SCR'] = array(
		'student_ID'=>array(
			'rules'=> 'required'
		)
	);

	$config['HR'] = array(
		'name'=>array(
			'rules'=> 'required'
		)
	);

	$config['CMS'] = array(
		'name'=>array(
			'rules'=> 'required'
		)
	);

	$config['DAT'] = array(
		'to'=>array(
			'rules'=> 'required'
		)
	);

	$config['HRM'] = array(
		'to'=>array(
			'resume_ID'=> 'required'
		)
	);

	$config['LS'] = array(
		'name'=>array(
			'rules'=> 'required'
		)
	);

	$config['TP'] = array(
		'name'=>array(
			'rules'=> 'required'
		)
	);

	$config['AM'] = array(
		'name'=>array(
			'rules'=> 'required'
		)
	);

	$config['AP'] = array(
		'topic_ID'=>array(
			'rules'=> 'required'
		)
	);

	$config['AV'] = array(
		'topic_ID'=>array(
			'rules'=> 'required'
		)
	);

	$config['ASS'] = array(
		'path'=>array(
			'rules'=> 'required'
		)
	);

	$config['AVU'] = array(
		'path'=>array(
			'rules'=> 'required'
		)
	);

	$config['AMQ'] = array(
		'mcq_ID'=>array(
			'rules'=> 'required'
		)
	);

	$config['AMA'] = array(
		'question_ID'=>array(
			'rules'=> 'required'
		)
	);

	$config['CH'] = array(
		'message'=>array(
			'rules'=> 'required'
		)
	);

	$config['APG'] = array(
		'name'=>array(
			'rules'=> 'required'
		)
	);

	$config['APGD'] = array(
		'package_ID'=>array(
			'rules'=> 'required'
		)
	);

	$config['IT'] = array(
		'name'=>array(
			'rules'=> 'required'
		)
	);

	$config['ITI'] = array(
		'item_ID'=>array(
			'rules'=> 'required'
		)
	);

	$config['AQB'] = array(
		'topic_ID'=>array(
			'rules'=> 'required'
		)
	);

	$config['AQA'] = array(
		'question_bank_ID'=>array(
			'rules'=> 'required'
		)
	);

	$config['AQT'] = array(
		'topic_ID'=>array(
			'rules'=> 'required'
		)
	);

	$config['AQS'] = array(
		'topic_ID'=>array(
			'rules'=> 'required'
		)
	);

	$config['CV'] = array(
		'chat_ID'=>array(
			'rules'=> 'required'
		)
	);

	$config['LR'] = array(
		'reason'=>array(
			'rules'=> 'required'
		)
	);
	$config['LEC'] = array(
		'class_ID'=>array(
			'rules'=> 'required'
		)
	);
	$config['CC'] = array(
		'contacts_ID'=>array(
			'rules'=> 'required'
		)
	);
	$config['XS'] = array(
		'package_ID'=>array(
			'rules'=> 'required'
		)
	);
?>