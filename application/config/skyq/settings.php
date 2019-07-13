<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	$config['settings']['default_date_format'] = 'Y-m-d';
	$config['settings']['default_time_format'] = 'h:i:s';
	$config['settings']['default_time_zone'] = 'UP45';
	$config['settings']['default_login_page'] = 'Login';
	$config['settings_menu'] = array(
			'Academic' => array(
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
					'Title'=>'Subjects',
					'Link' => 'Subject',
					'Icon' => 'book'
				),
				array(
					'Title'=>'Lesson',
					'Link' => 'lesson',
					'Icon' => 'file-text-o'
				),
				array(
					'Title'=>'Topic',
					'Link' => 'topic',
					'Icon' => 'file-text'
				)
			),
			'Marketing' => array(
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
				)
			),
			'General' => array(
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
					'Title'=>'Vendor Categories',
					'Link' => 'Business_category',
					'Icon' => 'briefcase'
				)
				,
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
					'Title'=>'Communication Settings',
					'Link' => 'communicate/communication_setting',
					'Icon' => 'cogs'
				),
				array(
					'Title'=>'Banks',
					'Link' => 'bank',
					'Icon' => 'university'
				)
			)
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