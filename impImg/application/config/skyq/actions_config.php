<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	$config['actions']['BA'] = array(

		array(
			'class'=>'primary',
			'link'=>'Bank/add/',
			'icon'=> 'pencil'
		),
		array(
			'class'=>'red',
			'link'=>'Bank/delete/',
			'icon'=> 'trash-o'
		)
	);

	$config['actions']['BT'] = array(

		array(
			'class'=>'primary',
			'link'=>'Batch/add/',
			'icon'=> 'pencil'
		),
		array(
			'class'=>'red',
			'link'=>'Batch/delete/',
			'icon'=> 'trash-o'
		)
	);

	$config['actions']['BSC'] = array(

		array(
			'class'=>'primary',
			'link'=>'Business_category/add/',
			'icon'=> 'pencil'
		),
		array(
			'class'=>'red',
			'link'=>'Business_category/delete/',
			'icon'=> 'trash-o'
		)
	);

	$config['actions']['SB'] = array(

		array(
			'class'=>'primary',
			'link'=>'Subject/add/',
			'icon'=> 'pencil'
		),
		array(
			'class'=>'red',
			'link'=>'Subject/delete/',
			'icon'=> 'trash-o'
		)
	);

	$config['actions']['CS'] = array(

		array(
			'class'=>'primary',
			'link'=>'Course/add/',
			'icon'=> 'pencil'
		),
		array(
			'class'=>'red',
			'link'=>'Course/delete/',
			'icon'=> 'trash-o'
		)
	);

	$config['actions']['EC'] = array(
		
		array(
			'class'=>'primary',
			'link'=>'ExpenseCategories/add/',
			'icon'=> 'pencil'
		),
		array(
			'class'=>'red',
			'link'=>'ExpenseCategories/delete/',
			'icon'=> 'trash-o'
		)
	);

	$config['actions']['US'] = array(
		
		array(
			'class'=>'primary',
			'link'=>'Team/add/',
			'icon'=> 'pencil'
		),
		array(
			'class'=>'red',
			'link'=>'Team/delete/',
			'icon'=> 'trash-o'
		)
	);

	$config['actions']['BR'] = array(
		
		array(
			'class'=>'primary',
			'link'=>'Branch/add/',
			'icon'=> 'pencil'
		),
		array(
			'class'=>'red',
			'link'=>'Branch/delete/',
			'icon'=> 'trash-o'
		)
	);

	$config['actions']['PM'] = array(
		
		array(
			'class'=>'primary',
			'link'=>'PaymentMode/add/',
			'icon'=> 'pencil'
		),
		array(
			'class'=>'red',
			'link'=>'PaymentMode/delete/',
			'icon'=> 'trash-o'
		)
	);

	$config['actions']['C'] = array(
		array(
		'class'=>'success',
		'link'=>'Customer/view/',
		'icon'=> 'eye'
		 ),
		array(
			'class'=>'primary',
			'link'=>'Customer/add/',
			'icon'=> 'pencil'
		),
		array(
			'class'=>'red',
			'link'=>'Customer/delete/',
			'icon'=> 'trash-o'
		)
	);

	$config['actions']['T'] = array(
		array(
		'class'=>'success',
		'link'=>'transaction/view/',
		'icon'=> 'eye'
		 ),
		array(
			'class'=>'primary',
			'link'=>'transaction/add/',
			'icon'=> 'pencil'
		),
		array(
			'class'=>'red',
			'link'=>'transaction/delete/',
			'icon'=> 'trash-o'
		)
		,
		array(
			'class'=>'warning',
			'link'=>'transaction/print_view/download/',
			'icon'=> 'print'
		)
	);
	
	$config['actions']['DS'] = array(
		array(
			'class'=>'primary',
			'link'=>'Designation/add/',
			'icon'=> 'pencil'
		),
		array(
			'class'=>'red',
			'link'=>'Designation/delete/',
			'icon'=> 'trash-o'
		)
	);


	$config['actions']['SL'] = array(
		array(
			'class'=>'red',
			'link'=>'team/deletes/',
			'icon'=> 'trash-o'
		),
		array(
			'class'=>'warning',
			'link'=>'team/print_view/print/',
			'icon'=> 'print'
		),
		array(
			'class'=>'info',
			'link'=>'team/print_view/download/',
			'icon'=> 'download'
		)

	);
	
	$config['actions']['SS'] = array(
		array(
		'class'=>'success',
		'link'=>'bill/show_file/',
		'icon'=> 'external-link'
		 )
	);

	$config['actions']['AR'] = array(
		array(
			'class'=>'primary',
			'link'=>'abort/add/',
			'icon'=> 'pencil'
		),
		array(
			'class'=>'red',
			'link'=>'abort/delete/',
			'icon'=> 'trash-o'
		)
	);

	$config['actions']['SM'] = array(
		array(
			'class'=>'primary',
			'link'=>'sms/add/',
			'icon'=> 'pencil'
		),
		array(
			'class'=>'red',
			'link'=>'sms/delete/',
			'icon'=> 'trash-o'
		)
	);

	$config['actions']['MT'] = array(
		array(
			'class'=>'primary',
			'link'=>'message_type/add/',
			'icon'=> 'pencil'
		),
		array(
			'class'=>'red',
			'link'=>'message_type/delete/',
			'icon'=> 'trash-o'
		)
	);

	$config['actions']['AS'] = array(
		/*array(
			'class'=>'primary',
			'link'=>'assignment/add/',
			'icon'=> 'pencil'
		),*/
		array(
			'class'=>'success',
			'link'=>'#',
			'icon'=>'eye',
			'function'=>'view'
		),
		array(
			'class'=>'default',
			'link'=>'#',
			'icon'=>'camera-retro',
			'function'=>'student_attendace'
		),
		array(
			'class'=>'red',
			'link'=>'assignment/delete/',
			'icon'=> 'trash-o'
		)
	);

	$config['actions']['TE'] = array(
		/*array(
			'class'=>'primary',
			'link'=>'test/add/',
			'icon'=> 'pencil'
		),*/
		array(
			'class'=>'success',
			'link'=>'#',
			'icon'=>'eye',
			'function'=>'view'
		),
		array(
			'class'=>'default',
			'link'=>'#',
			'icon'=>'camera-retro',
			'function'=>'test_attendace'
		),
		array(
			'class'=>'red',
			'link'=>'test/delete/',
			'icon'=> 'trash-o'
		)
	);

	$config['actions']['SN'] = array(
		/*array(
			'class'=>'primary',
			'link'=>'student_notice/add/',
			'icon'=> 'pencil'
		),*/
		array(
			'class'=>'success',
			'link'=>'#',
			'icon'=>'eye',
			'function'=>'view'
		),
		/*array(
			'class'=>'default',
			'link'=>'#',
			'icon'=>'camera-retro',
			'function'=>'student_notice'
		),*/
		array(
			'class'=>'red',
			'link'=>'student_notice/delete/',
			'icon'=> 'trash-o'
		)
	);

	$config['actions']['EN'] = array(
		/*array(
			'class'=>'primary',
			'link'=>'employee_notice/add/',
			'icon'=> 'pencil'
		),*/
		array(
			'class'=>'success',
			'link'=>'#',
			'icon'=>'eye',
			'function'=>'view'
		),
		/*array(
			'class'=>'default',
			'link'=>'#',
			'icon'=>'camera-retro',
			'function'=>'test_attendace'
		),*/
		array(
			'class'=>'red',
			'link'=>'employee_notice/delete/',
			'icon'=> 'trash-o'
		)
	);

	$config['actions']['SR'] = array(
		/*array(
			'class'=>'primary',
			'link'=>'student_remark/add/',
			'icon'=> 'pencil'
		),*/
		array(
			'class'=>'success',
			'link'=>'#',
			'icon'=>'eye',
			'function'=>'view'
		),
		/*array(
			'class'=>'default',
			'link'=>'#',
			'icon'=>'camera-retro',
			'function'=>'test_attendace'
		),*/
		array(
			'class'=>'red',
			'link'=>'student_remark/delete/',
			'icon'=> 'trash-o'
		)
	);

	$config['actions']['PME'] = array(
		/*array(
			'class'=>'primary',
			'link'=>'parent_meeting/add/',
			'icon'=> 'pencil'
		),*/
		array(
			'class'=>'success',
			'link'=>'#',
			'icon'=>'eye',
			'function'=>'view'
		),
		array(
			'class'=>'default',
			'link'=>'#',
			'icon'=>'camera-retro',
			'function'=>'meeting_attendace'
		),
		array(
			'class'=>'red',
			'link'=>'parent_meeting/delete/',
			'icon'=> 'trash-o'
		)
	);

	$config['actions']['SC'] = array(
		array(
			'class'=>'primary',
			'link'=>'counseling_session/add/',
			'icon'=> 'pencil'
		),
		array(
			'class'=>'default',
			'link'=>'#',
			'icon'=>'camera-retro',
			'function'=>'counseling_attendace'
		),
		array(
			'class'=>'red',
			'link'=>'counseling_session/delete/',
			'icon'=> 'trash-o'
		)
	);

	$config['actions']['AW'] = array(
		array(
			'class'=>'primary',
			'link'=>'awards/add/',
			'icon'=> 'pencil'
		),
		array(
			'class'=>'red',
			'link'=>'awards/delete/',
			'icon'=> 'trash-o'
		)
	);

	$config['actions']['EA'] = array(
		array(
			'class'=>'primary',
			'link'=>'team/add_employee_award/',
			'icon'=> 'pencil'
		),
		array(
			'class'=>'red',
			'link'=>'team/delete_employee_award/',
			'icon'=> 'trash-o'
		)
	);

	$config['actions']['TT'] = array(
		array(
			'class'=>'primary',
			'link'=>'task_type/add/',
			'icon'=> 'pencil'
		),
		array(
			'class'=>'red',
			'link'=>'task_type/delete/',
			'icon'=> 'trash-o'
		)
	);

	$config['actions']['HR'] = array(
		array(
			'class'=>'primary',
			'link'=>'hr_recruitment/add/',
			'icon'=> 'pencil'
		),
		array(
			'class'=>'success',
			'link'=>'#',
			'icon'=>'comment',
			'function'=>'message'
		),
		array(
			'class'=>'red',
			'link'=>'hr_recruitment/delete/',
			'icon'=> 'trash-o'
		)
	);

	$config['actions']['SYC'] = array(
		/*array(
			'class'=>'primary',
			'link'=>'syllabus_coverage/add/',
			'icon'=> 'pencil'
		),*/
		array(
			'class'=>'default',
			'link'=>'#',
			'icon'=>'camera-retro',
			'function'=>'test_attendace'
		),
		array(
			'class'=>'red',
			'link'=>'syllabus_coverage/delete/',
			'icon'=> 'trash-o'
		)
	);

	$config['actions']['CMS'] = array(
		array(
			'class'=>'primary',
			'link'=>'syllabus_coverage/add/',
			'icon'=> 'pencil'
		),
		array(
			'class'=>'default',
			'link'=>'#',
			'icon'=>'camera-retro',
			'function'=>'test_attendace'
		),
		array(
			'class'=>'red',
			'link'=>'syllabus_coverage/delete/',
			'icon'=> 'trash-o'
		)
	);

	$config['actions']['DAT'] = array(
		array(
			'class'=>'primary',
			'link'=>'report/add/',
			'icon'=> 'pencil'
		),
		array(
			'class'=>'red',
			'link'=>'report/delete/',
			'icon'=> 'trash-o'
		)
	);

	$config['actions']['HRM'] = array(
		array(
			'class'=>'primary',
			'link'=>'hr/add/',
			'icon'=> 'pencil'
		),
		array(
			'class'=>'red',
			'link'=>'hr/delete/',
			'icon'=> 'trash-o'
		)
	);

	$config['actions']['LS'] = array(
		array(
			'class'=>'primary',
			'link'=>'lesson/add/',
			'icon'=> 'pencil'
		),
		array(
			'class'=>'red',
			'link'=>'lesson/delete/',
			'icon'=> 'trash-o'
		)
	);

	$config['actions']['TP'] = array(
		array(
			'class'=>'primary',
			'link'=>'topic/add/',
			'icon'=> 'pencil'
		),
		array(
			'class'=>'red',
			'link'=>'topic/delete/',
			'icon'=> 'trash-o'
		)
	);

	$config['actions']['AM'] = array(
		/*array(
			'class'=>'primary',
			'link'=>'Abhyas_mcq/add/',
			'icon'=> 'pencil'
		),*/
		array(
			'class'=>'warning',
			'link'=>'Abhyas_mcq/print_pdf/',
			'icon'=> 'file-pdf-o'
		),
		array(
			'class'=>'red',
			'link'=>'Abhyas_mcq/delete/',
			'icon'=> 'trash-o'
		)
	);

	$config['actions']['AP'] = array(
		array(
			'class'=>'success',
			'link'=>'Abhyas_pdf/view_pdf/',
			'icon'=> 'eye'
		),
		/*array(
			'class'=>'primary',
			'link'=>'Abhyas_pdf/add/',
			'icon'=> 'pencil'
		),*/
		array(
			'class'=>'red',
			'link'=>'Abhyas_pdf/delete/',
			'icon'=> 'trash-o'
		)
	);

	$config['actions']['AV'] = array(
		array(
			'class'=>'success',
			'link'=>'#',
			'icon'=>'eye',
			'function'=>'view_video'
		),
		/*array(
			'class'=>'primary',
			'link'=>'Abhyas_video/add/',
			'icon'=> 'pencil'
		),*/
		array(
			'class'=>'red',
			'link'=>'Abhyas_video/delete/',
			'icon'=> 'trash-o'
		)
	);

	$config['actions']['APG'] = array(
		array(
			'class'=>'success',
			'link'=>'package/view/',
			'icon'=> 'eye'
		),
		array(
			'class'=>'red',
			'link'=>'package/delete/',
			'icon'=> 'trash-o'
		)
	);

	$config['actions']['IT'] = array(
		array(
			'class'=>'primary',
			'link'=>'Centerandinventory/add/',
			'icon'=> 'pencil'
		),
		array(
			'class'=>'success',
			'link'=>'#',
			'icon'=> 'eye',
			'function'=>'get_details'
		),
		array(
			'class'=>'red',
			'link'=>'Centerandinventory/delete/',
			'icon'=> 'trash-o'
		)
	);

	$config['actions']['AQB'] = array(
		array(
			'class'=>'primary',
			'link'=>'Abhyas_question_bank/add/',
			'icon'=> 'pencil'
		),
		array(
			'class'=>'red',
			'link'=>'Abhyas_question_bank/delete/',
			'icon'=> 'trash-o'
		)
	);

	$config['actions']['AQA'] = array(
		array(
			'class'=>'primary',
			'link'=>'Abhyas_question_bank/add/',
			'icon'=> 'pencil'
		),
		array(
			'class'=>'red',
			'link'=>'Abhyas_question_bank/delete/',
			'icon'=> 'trash-o'
		)
	);

	$config['actions']['AQT'] = array(
		array(
			'class'=>'primary',
			'link'=>'Abhyas_mcq_test/add/',
			'icon'=> 'pencil'
		),
		array(
			'class'=>'red',
			'link'=>'Abhyas_mcq_test/delete/',
			'icon'=> 'trash-o'
		)
	);

	$config['actions']['AQS'] = array(
		array(
			'class'=>'primary',
			'link'=>'Abhyas_mcq_assignment/add/',
			'icon'=> 'pencil'
		),
		array(
			'class'=>'red',
			'link'=>'Abhyas_mcq_assignment/delete/',
			'icon'=> 'trash-o'
		)
	);

	$config['actions']['LR'] = array(
		array(
			'class'=>'primary',
			'link'=>'Lead_reasons/add/',
			'icon'=> 'pencil'
		),
		array(
			'class'=>'red',
			'link'=>'Lead_reasons/delete/',
			'icon'=> 'trash-o'
		)
	);
?>