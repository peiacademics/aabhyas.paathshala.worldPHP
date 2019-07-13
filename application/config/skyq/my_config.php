<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	$config['app']['appname'] = 'Software';
	$config['app']['version'] = '1.0';
	$config['app']['segment'] = 'Retail';
	$config['app']['theme'] = 'skin-1';

	$config['paathshala']['message'] = "Dear Student,<br><br><p>You have received following marks in test(test name), 10(marks) / 15(out of marks).<p>";

	$config['skyq']['default_date_format'] = 'Y-m-d';
	$config['skyq']['default_time_format'] = 'h:i:s';
	$config['skyq']['default_time_zone'] = 'UP45';
	$config['skyq']['default_login_page'] = 'Login';
	$config['skyq']['default_lock_page'] = 'Login/lock';
	$config['skyq']['default_home_page'] = 'Dashboard';
	$config['skyq']['default_language'] = 'English';
	$config['skyq']['english_language_id'] = 'LNSK10000001';
	$config['skyq']['hacker_view'] = 'messages/hacker_view';
    $config['skyq']['seperator'] = 'SK';
    $config['skyq']['number'] = '10000001';
    $config['skyq']['backup_file_extension'] = '.sql';
    $config['skyq']['table_prefix'] = 'sk_';
    $config['skyq']['string_seperator'] = ':>';

   	$config['skyq']['aps_interval'] = '86400';
    $config['skyq']['app_log_directory'] = 'logs';
    $config['skyq']['base_log_directory'] = 'files';
    $config['skyq']['log_file_extension'] = '.skyq';
    $config['skyq']['log_files'] = array('errorlog','backuplog','backup');

    $config['skyq']['error_report_mail'] = '';
    $config['skyq']['app_ie'] = 'APKUT10A';
    $config['skyq']['Teacher_Debit'] = 'ECSK10000002';
    $config['skyq']['Student_Credit'] = 'ECSK10000001';
    $config['skyq']['Contra'] = 'ECSK10000004';
    $config['skyq']['payment_mode_cash'] = 'PMSK10000001';
    $config['skyq']['ftp_details'] = array(
    	'hostname'=> 'ftp.skyq.in',
    	'username'=> 'skyqintest@skyq.in',
    	'password'=> 'saurabh@2992',
    	'port'=> 21,
    	'passive'=> TRUE,
    	'debug'=> TRUE 
    	);
	$config['skyq']['leadSource'] = array('Email','Phone','Google','BigRock','Website','Direct','Just Dial');
    $config['skyq']['email_config'] = array(
          'protocol'=>'smtp',
          'smtp_host'=>'ssl://beast.pacifichost.com',
          'smtp_port'=>465,
          'smtp_user'=>'pawan@skyq.in',
          'smtp_pass'=>'pawan@12345',
          'mailtype' => 'html'
        ); 
    $config['header_image'] = 'img/logo.png';
	$config['Admin_menu'] = array(
		'level'=>'1',
		'menu'=>array(
			array(
				'title'=>"Vendors",
				'icon'=>"users",
				'link'=> "#",
				'children'=>array(
					array(
						'title'=>"Add",
						'icon'=>"plus",
						'link'=> "vendor/add",
					),
					array(
						'title'=>"Show",
						'icon'=>"eye",
						'link'=> "vendor",
					)
				)
			),
			array(
				'title'=>"Customers",
				'icon'=>"users",
				'link'=> "#",
				'children'=>array(
					array(
						'title'=>"Add",
						'icon'=>"plus",
						'link'=> "customer/add",
					),
					array(
						'title'=>"Show",
						'icon'=>"eye",
						'link'=> "customer",
					)
				)
			),
			array(
				'title'=>"Products",
				'icon'=>"puzzle-piece",
				'link'=> "#",
				'children'=>array(
					array(
						'title'=>"Add",
						'icon'=>"plus",
						'link'=> "product/add",
					),
					array(
						'title'=>"Show",
						'icon'=>"eye",
						'link'=> "product",
					)
				)
			),
			array(
				'title'=>"Purchase",
				'icon'=>"truck",
				'link'=> "#",
				'children'=>array(
					array(
						'title'=>"Add Purchase",
						'icon'=>"plus",
						'link'=> "customer/add",
					),
					array(
						'title'=>"Show Purchases",
						'icon'=>"eye",
						'link'=> "customer",
					)
				)
			),
			array(
				'title'=>"Stocks",
				'icon'=>"database",
				'link'=> "#",
				'children'=>array(
					array(
						'title'=>"Add",
						'icon'=>"plus",
						'link'=> "stock/add",
					),
					array(
						'title'=>"Show",
						'icon'=>"eye",
						'link'=> "stock",
					)
				)
			),
			array(
				'title'=>"Estimate",
				'icon'=>"briefcase",
				'link'=> "#",
				'children'=>array(
					array(
						'title'=>"Add",
						'icon'=>"plus",
						'link'=> "bill/add/estimate",
					),
					array(
						'title'=>"Show",
						'icon'=>"eye",
						'link'=> "bill/show/estimate",
					)
				)
			),
			array(
				'title'=>"Invoice",
				'icon'=>"newspaper-o",
				'link'=> "#",
				'children'=>array(
					array(
						'title'=>"Add",
						'icon'=>"plus",
						'link'=> "bill/add/invoice",
					),
					array(
						'title'=>"Show",
						'icon'=>"eye",
						'link'=> "bill/show/invoice",
					)
				)
			),
			array(
				'title'=>"Accounting",
				'icon'=>"credit-card",
				'link'=> "#",
				'children'=>array(
					array(
						'title'=>"Add Transactions",
						'icon'=>"plus",
						'link'=> "transaction/add",
					),
					array(
						'title'=>"Show Transactions",
						'icon'=>"eye",
						'link'=> "transaction",
					),
					array(
						'title'=>"Cash Book",
						'icon'=>"book",
						'link'=> "account/cash-book",
					),
					array(
						'title'=>"Bank Book",
						'icon'=>"cc-mastercard",
						'link'=> "account/bank-book",
					)
				)
			),
			array(
				'title'=>"AMC",
				'icon'=>"star",
				'link'=> "#",
				'children'=>array(
					array(
						'title'=>"Add New AMC",
						'icon'=>"plus",
						'link'=> "amc/add",
					),
					array(
						'title'=>"Show AMC",
						'icon'=>"eye-slash",
						'link'=> "amc",
					),
					array(
						'title'=>"Add Visits",
						'icon'=>"binoculars",
						'link'=> "amc/add_visits",
					),
					array(
						'title'=>"Show Visits",
						'icon'=>"eye",
						'link'=> "amc/add_visits",
					)
				)
			),
			array(
				'title'=>"",
				'icon'=>"bell-o",
				'link'=> "amc/notify",
			)
		)
	);

	$config['Team_member_menu'] = array(
		'level'=>'1',
		'menu'=>array(
			array(
				'title'=>"Vendors",
				'icon'=>"users",
				'link'=> "#",
				'children'=>array(
					array(
						'title'=>"Add",
						'icon'=>"plus",
						'link'=> "vendor/add",
					),
					array(
						'title'=>"Show",
						'icon'=>"eye",
						'link'=> "vendor",
					)
				)
			),
			array(
				'title'=>"Customers",
				'icon'=>"users",
				'link'=> "#",
				'children'=>array(
					array(
						'title'=>"Add",
						'icon'=>"plus",
						'link'=> "customer/add",
					),
					array(
						'title'=>"Show",
						'icon'=>"eye",
						'link'=> "customer",
					)
				)
			),
			array(
				'title'=>"Products",
				'icon'=>"puzzle-piece",
				'link'=> "#",
				'children'=>array(
					array(
						'title'=>"Add",
						'icon'=>"plus",
						'link'=> "product/add",
					),
					array(
						'title'=>"Show",
						'icon'=>"eye",
						'link'=> "product",
					)
				)
			),
			array(
				'title'=>"Purchase",
				'icon'=>"truck",
				'link'=> "#",
				'children'=>array(
					array(
						'title'=>"Add Purchase",
						'icon'=>"plus",
						'link'=> "customer/add",
					),
					array(
						'title'=>"Show Purchases",
						'icon'=>"eye",
						'link'=> "customer",
					)
				)
			),
			array(
				'title'=>"Stocks",
				'icon'=>"database",
				'link'=> "#",
				'children'=>array(
					array(
						'title'=>"Add",
						'icon'=>"plus",
						'link'=> "stock/add",
					),
					array(
						'title'=>"Show",
						'icon'=>"eye",
						'link'=> "stock",
					)
				)
			),
			array(
				'title'=>"Estimate",
				'icon'=>"briefcase",
				'link'=> "#",
				'children'=>array(
					array(
						'title'=>"Add",
						'icon'=>"plus",
						'link'=> "bill/add/estimate",
					),
					array(
						'title'=>"Show",
						'icon'=>"eye",
						'link'=> "bill/show/estimate",
					)
				)
			),
			array(
				'title'=>"Invoice",
				'icon'=>"newspaper-o",
				'link'=> "#",
				'children'=>array(
					array(
						'title'=>"Add",
						'icon'=>"plus",
						'link'=> "bill/add/invoice",
					),
					array(
						'title'=>"Show",
						'icon'=>"eye",
						'link'=> "bill/show/invoice",
					)
				)
			),
			array(
				'title'=>"Accounting",
				'icon'=>"credit-card",
				'link'=> "#",
				'children'=>array(
					array(
						'title'=>"Add Transactions",
						'icon'=>"plus",
						'link'=> "transaction/add",
					),
					array(
						'title'=>"Show Transactions",
						'icon'=>"eye",
						'link'=> "transaction",
					),
					array(
						'title'=>"Cash Book",
						'icon'=>"book",
						'link'=> "account/cash-book",
					),
					array(
						'title'=>"Bank Book",
						'icon'=>"cc-mastercard",
						'link'=> "account/bank-book",
					)
				)
			),
			array(
				'title'=>"AMC",
				'icon'=>"star",
				'link'=> "#",
				'children'=>array(
					array(
						'title'=>"Add New AMC",
						'icon'=>"plus",
						'link'=> "amc/add",
					),
					array(
						'title'=>"Show AMC",
						'icon'=>"eye-slash",
						'link'=> "amc",
					),
					array(
						'title'=>"Add Visits",
						'icon'=>"binoculars",
						'link'=> "amc/add_visits",
					),
					array(
						'title'=>"Show Visits",
						'icon'=>"eye",
						'link'=> "amc/add_visits",
					)
				)
			),
			array(
				'title'=>"",
				'icon'=>"bell-o",
				'link'=> "amc/notify",
			)
		)
	);

	$config['Client_menu']= array(
		'level'=>'1',
		'menu'=>array(
			array(
				'title'=>"Vendors",
				'icon'=>"users",
				'link'=> "#",
				'children'=>array(
					array(
						'title'=>"Add",
						'icon'=>"plus",
						'link'=> "vendor/add",
					),
					array(
						'title'=>"Show",
						'icon'=>"eye",
						'link'=> "vendor",
					)
				)
			),
			array(
				'title'=>"Customers",
				'icon'=>"users",
				'link'=> "#",
				'children'=>array(
					array(
						'title'=>"Add",
						'icon'=>"plus",
						'link'=> "customer/add",
					),
					array(
						'title'=>"Show",
						'icon'=>"eye",
						'link'=> "customer",
					)
				)
			),
			array(
				'title'=>"Products",
				'icon'=>"puzzle-piece",
				'link'=> "#",
				'children'=>array(
					array(
						'title'=>"Add",
						'icon'=>"plus",
						'link'=> "product/add",
					),
					array(
						'title'=>"Show",
						'icon'=>"eye",
						'link'=> "product",
					)
				)
			),
			array(
				'title'=>"Purchase",
				'icon'=>"truck",
				'link'=> "#",
				'children'=>array(
					array(
						'title'=>"Add Purchase",
						'icon'=>"plus",
						'link'=> "purchase/add",
					),
					array(
						'title'=>"Show Purchases",
						'icon'=>"eye",
						'link'=> "customer",
					)
				)
			),
			array(
				'title'=>"Stocks",
				'icon'=>"database",
				'link'=> "#",
				'children'=>array(
					array(
						'title'=>"Add",
						'icon'=>"plus",
						'link'=> "stock/add",
					),
					array(
						'title'=>"Show",
						'icon'=>"eye",
						'link'=> "stock",
					)
				)
			),
			array(
				'title'=>"Estimate",
				'icon'=>"briefcase",
				'link'=> "#",
				'children'=>array(
					array(
						'title'=>"Add",
						'icon'=>"plus",
						'link'=> "bill/add/estimate",
					),
					array(
						'title'=>"Show",
						'icon'=>"eye",
						'link'=> "bill/show/estimate",
					)
				)
			),
			array(
				'title'=>"Invoice",
				'icon'=>"newspaper-o",
				'link'=> "#",
				'children'=>array(
					array(
						'title'=>"Add",
						'icon'=>"plus",
						'link'=> "bill/add/invoice",
					),
					array(
						'title'=>"Show",
						'icon'=>"eye",
						'link'=> "bill/show/invoice",
					)
				)
			),
			array(
				'title'=>"Accounting",
				'icon'=>"credit-card",
				'link'=> "#",
				'children'=>array(
					array(
						'title'=>"Add Transactions",
						'icon'=>"plus",
						'link'=> "transaction/add",
					),
					array(
						'title'=>"Show Transactions",
						'icon'=>"eye",
						'link'=> "transaction",
					),
					array(
						'title'=>"Cash Book",
						'icon'=>"book",
						'link'=> "account/cash-book",
					),
					array(
						'title'=>"Bank Book",
						'icon'=>"cc-mastercard",
						'link'=> "account/bank-book",
					)
				)
			),
			array(
				'title'=>"AMC",
				'icon'=>"star",
				'link'=> "#",
				'children'=>array(
					array(
						'title'=>"Add New AMC",
						'icon'=>"plus",
						'link'=> "amc/add",
					),
					array(
						'title'=>"Show AMC",
						'icon'=>"eye-slash",
						'link'=> "amc",
					),
					array(
						'title'=>"Add Visits",
						'icon'=>"binoculars",
						'link'=> "amc/add_visits",
					),
					array(
						'title'=>"Show Visits",
						'icon'=>"eye",
						'link'=> "amc/add_visits",
					)
				)
			),
			array(
				'title'=>"",
				'icon'=>"bell-o",
				'link'=> "amc/notify",
			)
		)
	);

	$config['add_menu'] = array(
		'Admin' => array(
			array('title' =>'Direct Add Menus',
					'icon'=>'spinner fa-spin',
					'link'=>'#')
				// array(
				// 	'title'=>"Customer",
				// 	'icon'=>"user",
				// 	'link'=> "customer/add",
				// ),
				// array(
				// 	'title'=>"Vendor",
				// 	'icon'=>"user",
				// 	'link'=> "vendor/add",
				// ),
				// array(
				// 	'title'=>"Product",
				// 	'icon'=>"puzzle-piece",
				// 	'link'=> "product/add",
				// ),
				// array(
				// 	'title'=>"Purchase",
				// 	'icon'=>"truck",
				// 	'link'=> "purchase/add",
				// ),
				// array(
				// 	'title'=>"Estimate",
				// 	'icon'=>"briefcase",
				// 	'link'=> "bill/add/estimate",
				// ),
				// array(
				// 	'title'=>"Invoice",
				// 	'icon'=>"newspaper-o",
				// 	'link'=> "bill/add/invoice",
				// ),
				// array(
				// 	'title'=>"Leads",
				// 	'icon'=>"database",
				// 	'link'=> "lead/add",
				// ),
				// array(
				// 	'title'=>"Transactions",
				// 	'icon'=>"credit-card",
				// 	'link'=> "transaction/add",
				// ),
				// array(
				// 	'title'=>"Support Ticket",
				// 	'icon'=>"building",
				// 	'link'=> "query/add",
				// )
			),
		'Team Member' => array(
			array('title' =>'Direct Add Menus',
					'icon'=>'spinner fa-spin',
					'link'=>'#')
				// array(
				// 	'title'=>"Customer",
				// 	'icon'=>"user",
				// 	'link'=> "customer/add",
				// ),
				// array(
				// 	'title'=>"Vendor",
				// 	'icon'=>"user",
				// 	'link'=> "vendor/add",
				// ),
				// array(
				// 	'title'=>"Product",
				// 	'icon'=>"puzzle-piece",
				// 	'link'=> "product/add",
				// ),
				// array(
				// 	'title'=>"Purchase",
				// 	'icon'=>"truck",
				// 	'link'=> "purchase/add",
				// ),
				// array(
				// 	'title'=>"Estimate",
				// 	'icon'=>"briefcase",
				// 	'link'=> "bill/add/estimate",
				// ),
				// array(
				// 	'title'=>"Invoice",
				// 	'icon'=>"newspaper-o",
				// 	'link'=> "bill/add/invoice",
				// ),
				// array(
				// 	'title'=>"Lead",
				// 	'icon'=>"leaf",
				// 	'link'=> "lead/add",
				// ),
				// array(
				// 	'title'=>"Transactions",
				// 	'icon'=>"credit-card",
				// 	'link'=> "transaction/add",
				// ),
				// array(
				// 	'title'=>"Support Ticket",
				// 	'icon'=>"building",
				// 	'link'=> "query/add",
				// )
			),
		'Client' => array(
			array('title' =>'Direct Add Menus',
					'icon'=>'spinner fa-spin',
					'link'=>'#')
				// array(
				// 	'title'=>"Customer",
				// 	'icon'=>"user",
				// 	'link'=> "customer/add",
				// ),
				// array(
				// 	'title'=>"Vendor",
				// 	'icon'=>"user",
				// 	'link'=> "vendor/add",
				// ),
				// array(
				// 	'title'=>"Product",
				// 	'icon'=>"puzzle-piece",
				// 	'link'=> "product/add",
				// ),
				// array(
				// 	'title'=>"Purchase",
				// 	'icon'=>"truck",
				// 	'link'=> "purchase/add",
				// ),
				// array(
				// 	'title'=>"Estimate",
				// 	'icon'=>"briefcase",
				// 	'link'=> "bill/add/estimate",
				// ),
				// array(
				// 	'title'=>"Invoice",
				// 	'icon'=>"newspaper-o",
				// 	'link'=> "bill/add/invoice",
				// ),
				// array(
				// 	'title'=>"Lead",
				// 	'icon'=>"leaf",
				// 	'link'=> "lead/add",
				// ),
				// array(
				// 	'title'=>"Transactions",
				// 	'icon'=>"credit-card",
				// 	'link'=> "transaction/add",
				// ),
				// array(
				// 	'title'=>"Support Ticket",
				// 	'icon'=>"building",
				// 	'link'=> "query/add",
				// )
			)		
	);

	$config['dropdown_menu'] = array(
		'DSSK10000001' => array(
				array(
					'Title'=>"Settings",
					'Icon'=>"cogs",
					// 'Link'=> "#"
					'Link'=> "Settings"
				),
				/*array(
					'Title'=>"Help",
					'Icon'=>"question-circle",
					'Link'=> "#"
					// 'Link'=> "Settings/help"
				),
				array(
					'Title'=>"Lock Screen",
					'Icon'=>"lock",
					'Link'=> "#"
					// 'Link'=> "Login/lock"
				),*/
				array(
					'Title'=>"Change Password",
					'Icon'=>"key",
					'Link'=> "Settings/change_password"
				)
			),
		'DSSK10000002' => array(
				/*array(
					'Title'=>"Lock Screen",
					'Icon'=>"lock",
					// 'Link'=> "#"
					'Link'=> "Login/lock"
				),*/
				array(
					'Title'=>"Change Password",
					'Icon'=>"key",
					// 'Link'=> "#"
					'Link'=> "Settings/change_password"
				)
			),
		'DSSK10000003' => array(
				/*array(
					'Title'=>"Lock Screen",
					'Icon'=>"lock",
					// 'Link'=> "#"
					'Link'=> "Login/lock"
				),*/
				array(
					'Title'=>"Change Password",
					'Icon'=>"key",
					// 'Link'=> "#"
					'Link'=> "Settings/change_password"
				)
			),
		'DSSK10000004' => array(
				/*array(
					'Title'=>"Lock Screen",
					'Icon'=>"lock",
					// 'Link'=> "#"
					'Link'=> "Login/lock"
				),*/
				array(
					'Title'=>"Change Password",
					'Icon'=>"key",
					// 'Link'=> "#"
					'Link'=> "Settings/change_password"
				)
			),
		'DSSK10000005' => array(
				/*array(
					'Title'=>"Lock Screen",
					'Icon'=>"lock",
					// 'Link'=> "#"
					'Link'=> "Login/lock"
				),*/
				array(
					'Title'=>"Change Password",
					'Icon'=>"key",
					// 'Link'=> "#"
					'Link'=> "Settings/change_password"
				)
			),
		'DSSK10000006' => array(
				/*array(
					'Title'=>"Lock Screen",
					'Icon'=>"lock",
					// 'Link'=> "#"
					'Link'=> "Login/lock"
				),*/
				array(
					'Title'=>"Change Password",
					'Icon'=>"key",
					// 'Link'=> "#"
					'Link'=> "Settings/change_password"
				)
			),
		'DSSK10000007' => array(
				/*array(
					'Title'=>"Lock Screen",
					'Icon'=>"lock",
					// 'Link'=> "#"
					'Link'=> "Login/lock"
				),*/
				array(
					'Title'=>"Change Password",
					'Icon'=>"key",
					// 'Link'=> "#"
					'Link'=> "Settings/change_password"
				)
			),
		'DSSK10000008' => array(
				/*array(
					'Title'=>"Lock Screen",
					'Icon'=>"lock",
					// 'Link'=> "#"
					'Link'=> "Login/lock"
				),*/
				array(
					'Title'=>"Change Password",
					'Icon'=>"key",
					// 'Link'=> "#"
					'Link'=> "Settings/change_password"
				)
			),
		'DSSK10000009' => array(
				/*array(
					'Title'=>"Lock Screen",
					'Icon'=>"lock",
					// 'Link'=> "#"
					'Link'=> "Login/lock"
				),*/
				array(
					'Title'=>"Change Password",
					'Icon'=>"key",
					// 'Link'=> "#"
					'Link'=> "Settings/change_password"
				)
			),
		'DSSK10000010' => array(
				/*array(
					'Title'=>"Lock Screen",
					'Icon'=>"lock",
					// 'Link'=> "#"
					'Link'=> "Login/lock"
				),*/
				array(
					'Title'=>"Change Password",
					'Icon'=>"key",
					// 'Link'=> "#"
					'Link'=> "Settings/change_password"
				)
			),
		'DSSK10000011' => array(
				/*array(
					'Title'=>"Lock Screen",
					'Icon'=>"lock",
					// 'Link'=> "#"
					'Link'=> "Login/lock"
				),*/
				array(
					'Title'=>"Change Password",
					'Icon'=>"key",
					// 'Link'=> "#"
					'Link'=> "Settings/change_password"
				)
			),
		'DSSK10000012' => array(
				/*array(
					'Title'=>"Lock Screen",
					'Icon'=>"lock",
					// 'Link'=> "#"
					'Link'=> "Login/lock"
				),*/
				array(
					'Title'=>"Change Password",
					'Icon'=>"key",
					// 'Link'=> "#"
					'Link'=> "Settings/change_password"
				)
			),
		'DSSK10000013' => array(
				/*array(
					'Title'=>"Lock Screen",
					'Icon'=>"lock",
					// 'Link'=> "#"
					'Link'=> "Login/lock"
				),*/
				array(
					'Title'=>"Change Password",
					'Icon'=>"key",
					// 'Link'=> "#"
					'Link'=> "Settings/change_password"
				)
			),
		'DSSK10000017' => array(
				/*array(
					'Title'=>"Lock Screen",
					'Icon'=>"lock",
					// 'Link'=> "#"
					'Link'=> "Login/lock"
				),*/
				array(
					'Title'=>"Change Password",
					'Icon'=>"key",
					// 'Link'=> "#"
					'Link'=> "Settings/change_password"
				)
			),
		'DSSK10000014' => array(
				/*array(
					'Title'=>"Lock Screen",
					'Icon'=>"lock",
					// 'Link'=> "#"
					'Link'=> "Login/lock"
				),*/
				array(
					'Title'=>"Change Password",
					'Icon'=>"key",
					// 'Link'=> "#"
					'Link'=> "Settings/change_password"
				)
			),
		'Client' => array(
				array(
					'Title'=>"Settings",
					'Icon'=>"cogs",
					'Link'=> "#"
					// 'Link'=> "Settings"
				),
				array(
					'Title'=>"Help",
					'Icon'=>"question-circle",
					'Link'=> "#"
					// 'Link'=> "Settings/help"
				),
				array(
					'Title'=>"Lock Screen",
					'Icon'=>"lock",
					'Link'=> "#"
					// 'Link'=> "Login/lock"
				),
				array(
					'Title'=>"Change Password",
					'Icon'=>"key",
					'Link'=> "#"
					// 'Link'=> "Settings/change_password"
				)
			),
		'Team Member' => array(
				array(
					'Title'=>"Settings",
					'Icon'=>"cogs",
					// 'Link'=> "#"
					'Link'=> "Settings"
				),
				array(
					'Title'=>"Help",
					'Icon'=>"question-circle",
					'Link'=> "#"
					// 'Link'=> "Settings/help"
				),
				array(
					'Title'=>"Lock Screen",
					'Icon'=>"lock",
					'Link'=> "#"
					// 'Link'=> "Login/lock"
				),
				array(
					'Title'=>"Change Password",
					'Icon'=>"key",
					'Link'=> "#"
					// 'Link'=> "Settings/change_password"
				)
			)
	);

	
?>