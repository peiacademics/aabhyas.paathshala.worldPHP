<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	$config['settings']['default_date_format'] = 'Y-m-d';
	$config['settings']['default_time_format'] = 'h:i:s';
	$config['settings']['default_time_zone'] = 'UP45';
	$config['settings']['default_login_page'] = 'Login';
	$config['settings_menu'] = array(
			'Basic Masters' => array(
				 /*array(
					'Title'=>'Menu',
					'Link' => 'Settings/menu',
					'Icon' => 'bars'
				),
				 array(
					'Title'=>'Date & Time',
					'Link' => 'Settings/date_time_setting',
					'Icon' => 'calendar'
				),
				 array(
					'Title'=>'Bank  Accounts',
					'Link' => 'bank',
					'Icon' => 'bank'
				),
				 array(
					'Title'=>'Expense   Categories',
					'Link' => 'expenseCategories',
					'Icon' => 'money'
				),
				 array(
					'Title'=>'Payment  Modes',
					'Link' => 'paymentMode',
					'Icon' => 'rupee'
				),
				 array(
					'Title'=>'Basic  Settings',
					'Link' => 'Settings/basic_setting',
					'Icon' => 'gear'
				),
				array(
					'Title'=>'Product  Types',
					'Link' => 'product_type',
					'Icon' => 'puzzle-piece'
				),
				 array(
					'Title'=>'T & C',
					'Link' => 'TandC',
					'Icon' => 'text-width'
				),
				array(
					'Title'=>'Email Setting',
					'Link' => 'Settings/email_setting',
					'Icon' => 'envelope-o'
				),
				 array(
					'Title'=>'Themes',
					'Link' => 'Settings/themes_setting',
					'Icon' => 'picture-o'
				),
				 array(
					'Title'=>'Import  Attendance',
					'Link' => 'Settings/import',
					'Icon' => 'download'
				),*/
				array(
					'Title'=>'Business Category',
					'Link' => 'business_category',
					'Icon' => 'universal-access'
				),
				array(
					'Title'=>'Designations',
					'Link' => 'designation',
					'Icon' => 'shield'
				),
				array(
					'Title'=>'Subjects',
					'Link' => 'Subject',
					'Icon' => 'book'
				),
				array(
					'Title'=>'Courses',
					'Link' => 'Course',
					'Icon' => 'shield'
				),
				array(
					'Title'=>'Batchs',
					'Link' => 'Batch',
					'Icon' => 'users'
				),
				array(
					'Title'=>'Vendor Categories',
					'Link' => 'Business_category',
					'Icon' => 'briefcase'
				)
				,
				array(
					'Title'=>'Abort Reasons',
					'Link' => 'abort',
					'Icon' => 'ban'
				),
				array(
					'Title'=>'Message Masters',
					'Link' => 'sms',
					'Icon' => 'comment'
				),
				array(
					'Title'=>'Message Type',
					'Link' => 'message_type',
					'Icon' => 'font'
				),
				array(
					'Title'=>'Awards',
					'Link' => 'awards',
					'Icon' => 'trophy'
				),
				array(
					'Title'=>'Departments',
					'Link' => 'task_type',
					'Icon' => 'tasks'
				),
				array(
					'Title'=>'Communication Setting',
					'Link' => 'communicate/communication_setting',
					'Icon' => 'cogs'
				)
			),
			/* 'General' => array(						 
				 array(
					'Title'=>'Help',
					'Link' => 'settings/help_view',
					'Icon' => 'question-circle'
				),
				 array(
					'Title'=>'Backups',
					'Link' => 'settings/backup_view',
					'Icon' => 'globe'
				),
				 array(
					'Title'=>'Errors',
					'Link' => 'settings/error',
					'Icon' => 'exclamation-triangle'
				),
				 array(
					'Title'=>'Support',
					'Link' => 'settings/support',
					'Icon' => 'life-ring'
				)
			) */
	);	

	$config['help_category'] = array(
			'Help' => array( 				
				array(
					'Title'=>'Help Category',
					'Link' => 'settings/add_help_category_form',
					'Icon' => 'question-circle'
				),
				  array(
					'Title'=>'Help Sub-Category',
					'Link' => 'settings/add_help_form',
					'Icon' => 'question'
				)
			)
		);


	$config['Backup'] = array(
			'Backup' => array(				 
				 array(
					'Title'=>'Full Backup',
					'Link' => 'settings/add_full_backup_form',
					'Icon' => 'archive'
				),
				 array(
					'Title'=>'Data Backup',
					'Link' => 'settings/add_data_backup_form',
					'Icon' => 'folder-open'
				)
			)
		);
?>