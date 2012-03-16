<?php
	/**
	 * Creates the array structure whereby elements in the database can be referenced.
	 * If a database entry does not appear in the schema then it cannot be referenced.
	 */
	/* App schema generated on: 2011-10-24 21:23:04 : 1319491384*/
	class AppSchema extends CakeSchema
	{
		var $name = 'App';

		/**
		 * Not sure if this function is used or necessary.
		 */
		function before($event = array())
		{
			return true;
		}

		/**
		 * Not sure if this function is used or necessary.
		 */
		function after($event = array())
		{
		}

		var $bills = array(
				'id' => array(
						'type' => 'integer',
						'null' => false,
						'default' => NULL,
						'key' => 'primary'
				),
				'title' => array(
						'type' => 'string',
						'null' => false,
						'length' => 60,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'description' => array(
						'type' => 'text',
						'null' => true,
						'default' => NULL,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'submit_date' => array(
						'type' => 'date',
						'null' => true,
						'default' => NULL
				),
				'dues' => array(
						'type' => 'integer',
						'null' => true,
						'default' => NULL
				),
				'fundraising' => array(
						'type' => 'text',
						'null' => true,
						'default' => NULL,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'number' => array(
						'type' => 'string',
						'null' => true,
						'default' => NULL,
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'type' => array(
						'type' => 'string',
						'null' => true,
						'default' => NULL,
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'category' => array(
						'type' => 'string',
						'null' => true,
						'default' => NULL,
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'status' => array(
						'type' => 'string',
						'null' => false,
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'organization_id' => array(
						'type' => 'integer',
						'null' => false,
						'default' => '0',
						'key' => 'index'
				),
				'underAuthor_id' => array(
						'type' => 'integer',
						'null' => true,
						'default' => NULL,
						'key' => 'index'
				),
				'underAuthorApproved' => array(
						'type' => 'integer',
						'null' => true,
						'default' => NULL,
						'length' => 6
				),
				'gradAuthor_id' => array(
						'type' => 'integer',
						'null' => true,
						'default' => NULL,
						'key' => 'index'
				),
				'gradAuthorApproved' => array(
						'type' => 'integer',
						'null' => true,
						'default' => NULL,
						'length' => 6
				),
				'grad_pres_sign' => array(
						'type' => 'string',
						'default' => 'Not Yet Signed',
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'grad_secr_sign' => array(
						'type' => 'string',
						'default' => 'Not Yet Signed',
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'ungr_pres_sign' => array(
						'type' => 'string',
						'default' => 'Not Yet Signed',
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'ungr_secr_sign' => array(
						'type' => 'string',
						'default' => 'Not Yet Signed',
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),'vp_fina_sign' => array(
						'type' => 'string',
						'default' => 'Not Yet Signed',
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'user_id' => array(
						'type' => 'integer',
						'null' => false,
						'default' => NULL,
						'key' => 'index'
				),
				'gss_date' => array(
						'type' => 'date',
						'null' => true,
						'default' => NULL
				),
				'gss_yeas' => array(
						'type' => 'integer',
						'null' => true,
						'default' => NULL
				),
				'gss_nays' => array(
						'type' => 'integer',
						'null' => true,
						'default' => NULL
				),
				'gss_abst' => array(
						'type' => 'integer',
						'null' => true,
						'default' => NULL
				),
			//Deprecated: Derived in bill model.
				'gss_py' => array(
						'type' => 'string',
						'null' => true,
						'default' => NULL,
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
			//Deprecated: Derived in bill model.
				'gss_co' => array(
						'type' => 'string',
						'null' => true,
						'default' => NULL,
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
			//Deprecated: Derived in bill model.
				'gss_glr' => array(
						'type' => 'string',
						'null' => true,
						'default' => NULL,
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'uhr_date' => array(
						'type' => 'date',
						'null' => true,
						'default' => NULL
				),
				'uhr_yeas' => array(
						'type' => 'integer',
						'null' => true,
						'default' => NULL
				),
				'uhr_nays' => array(
						'type' => 'integer',
						'null' => true,
						'default' => NULL
				),
				'uhr_abst' => array(
						'type' => 'integer',
						'null' => true,
						'default' => NULL
				),
			//Deprecated: Derived in bill model.
				'uhr_py' => array(
						'type' => 'string',
						'null' => true,
						'default' => NULL,
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
			//Deprecated: Derived in bill model.
				'uhr_co' => array(
						'type' => 'string',
						'null' => true,
						'default' => NULL,
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
			//Deprecated: Derived in bill model.
				'uhr_glr' => array(
						'type' => 'string',
						'null' => true,
						'default' => NULL,
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'ucc_yeas' => array(
						'type' => 'integer',
						'null' => true,
						'default' => NULL
				),
				'ucc_nays' => array(
						'type' => 'integer',
						'null' => true,
						'default' => NULL
				),
				'ucc_abst' => array(
						'type' => 'integer',
						'null' => true,
						'default' => NULL
				),
				'gcc_yeas' => array(
						'type' => 'integer',
						'null' => true,
						'default' => NULL
				),
				'gcc_nays' => array(
						'type' => 'integer',
						'null' => true,
						'default' => NULL
				),
				'gcc_abst' => array(
						'type' => 'integer',
						'null' => true,
						'default' => NULL
				),
			//Deprecated: Derived in bill model.
				'cc_py' => array(
						'type' => 'string',
						'null' => true,
						'default' => NULL,
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
			//Deprecated: Derived in bill model.
				'cc_co' => array(
						'type' => 'string',
						'null' => true,
						'default' => NULL,
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
			//Deprecated: Derived in bill model.
				'cc_glr' => array(
						'type' => 'string',
						'null' => true,
						'default' => NULL,
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
			//Deprecated: Derived in bill model.
				'cc_ulr' => array(
						'type' => 'string',
						'null' => true,
						'default' => NULL,
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),

				'jfc_recommendations' => array(
						'type' => 'text',
						'null' => true,
						'default' => NULL,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'indexes' => array(
						'PRIMARY' => array(
								'column' => 'id',
								'unique' => 1
						),
						'organization_id' => array(
								'column' => 'organization_id',
								'unique' => 0
						),
						'underAuthor_id' => array(
								'column' => 'underAuthor_id',
								'unique' => 0
						),
						'gradAuthor_id' => array(
								'column' => 'gradAuthor_id',
								'unique' => 0
						),
						'user_id' => array(
								'column' => 'user_id',
								'unique' => 0
						)
				),
				'tableParameters' => array(
						'charset' => 'latin1',
						'collate' => 'latin1_swedish_ci',
						'engine' => 'MyISAM'
				)
		);
		var $budget_line_items = array(
				'id' => array(
						'type' => 'integer',
						'null' => false,
						'default' => NULL,
						'key' => 'primary'
				),
				'bill_id' => array(
						'type' => 'integer',
						'null' => false,
						'default' => NULL,
						'key' => 'index'
				),
				'parent_id' => array(
						'type' => 'integer',
						'null' => false,
						'default' => NULL,
						'key' => 'index'
				),
				'state' => array(
						'type' => 'string',
						'null' => false,
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'name' => array(
						'type' => 'string',
						'null' => false,
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'costPerUnit' => array(
						'type' => 'integer',
						'null' => false,
						'default' => '0'
				),
				'quantity' => array(
						'type' => 'integer',
						'null' => false,
						'default' => '0'
				),
				'totalCost' => array(
						'type' => 'integer',
						'null' => false,
						'default' => '0'
				),
				'amount' => array(
						'type' => 'integer',
						'null' => false,
						'default' => '0'
				),
				'section' => array(
						'type' => 'string',
						'null' => false,
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'indexes' => array(
						'PRIMARY' => array(
								'column' => 'id',
								'unique' => 1
						),
						'bill_id' => array(
								'column' => 'bill_id',
								'unique' => 0
						),
						'parent_id' => array(
								'column' => 'parent_id',
								'unique' => 0
						)
				),
				'tableParameters' => array(
						'charset' => 'latin1',
						'collate' => 'latin1_swedish_ci',
						'engine' => 'MyISAM'
				)
		);
		var $budgets = array(
				'id' => array(
						'type' => 'integer',
						'null' => false,
						'default' => NULL,
						'key' => 'primary'
				),
				'organization_id' => array(
						'type' => 'integer',
						'null' => false,
						'default' => NULL,
						'key' => 'index'
				),
				'name' => array(
						'type' => 'string',
						'null' => false,
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'size' => array(
						'type' => 'integer',
						'null' => false,
						'default' => '0'
				),
				'type' => array(
						'type' => 'string',
						'null' => false,
						'length' => 200,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'file' => array(
						'type' => 'binary',
						'null' => true,
						'default' => NULL
				),
				'updated' => array(
						'type' => 'datetime',
						'null' => false,
						'default' => '0000-00-00 00:00:00'
				),
				'archived' => array(
						'type' => 'integer',
						'null' => false,
						'default' => NULL
				),
				'indexes' => array(
						'PRIMARY' => array(
								'column' => 'id',
								'unique' => 1
						),
						'organization_id' => array(
								'column' => 'organization_id',
								'unique' => 0
						)
				),
				'tableParameters' => array(
						'charset' => 'latin1',
						'collate' => 'latin1_swedish_ci',
						'engine' => 'InnoDB'
				)
		);
		var $categories = array(
				'id' => array(
						'type' => 'integer',
						'null' => false,
						'default' => NULL,
						'key' => 'primary'
				),
				'category' => array(
						'type' => 'string',
						'null' => false,
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'organization_id' => array(
						'type' => 'integer',
						'null' => false,
						'default' => NULL,
						'key' => 'index'
				),
				'indexes' => array(
						'PRIMARY' => array(
								'column' => 'id',
								'unique' => 1
						),
						'organization_id' => array(
								'column' => 'organization_id',
								'unique' => 0
						)
				),
				'tableParameters' => array(
						'charset' => 'latin1',
						'collate' => 'latin1_swedish_ci',
						'engine' => 'MyISAM'
				)
		);
		var $charters = array(
				'id' => array(
						'type' => 'integer',
						'null' => false,
						'default' => NULL,
						'key' => 'primary'
				),
				'organization_id' => array(
						'type' => 'integer',
						'null' => false,
						'default' => NULL,
						'key' => 'index'
				),
				'name' => array(
						'type' => 'string',
						'null' => false,
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'size' => array(
						'type' => 'integer',
						'null' => false,
						'default' => '0'
				),
				'type' => array(
						'type' => 'string',
						'null' => false,
						'length' => 200,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'file' => array(
						'type' => 'binary',
						'null' => true,
						'default' => NULL
				),
				'updated' => array(
						'type' => 'datetime',
						'null' => false,
						'default' => '0000-00-00 00:00:00'
				),
				'indexes' => array(
						'PRIMARY' => array(
								'column' => 'id',
								'unique' => 1
						),
						'organization_id' => array(
								'column' => 'organization_id',
								'unique' => 0
						)
				),
				'tableParameters' => array(
						'charset' => 'latin1',
						'collate' => 'latin1_swedish_ci',
						'engine' => 'MyISAM'
				)
		);
		var $interests = array(
				'id' => array(
						'type' => 'integer',
						'null' => false,
						'default' => NULL,
						'key' => 'primary'
				),
				'interest' => array(
						'type' => 'string',
						'null' => false,
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'organization_id' => array(
						'type' => 'integer',
						'null' => false,
						'default' => NULL,
						'key' => 'index'
				),
				'indexes' => array(
						'PRIMARY' => array(
								'column' => 'id',
								'unique' => 1
						),
						'organization_id' => array(
								'column' => 'organization_id',
								'unique' => 0
						)
				),
				'tableParameters' => array(
						'charset' => 'latin1',
						'collate' => 'latin1_swedish_ci',
						'engine' => 'MyISAM'
				)
		);
		var $line_items = array(
				'id' => array(
						'type' => 'integer',
						'null' => false,
						'default' => NULL,
						'key' => 'primary'
				),
				'bill_id' => array(
						'type' => 'integer',
						'null' => false,
						'default' => NULL,
						'key' => 'index'
				),
				'parent_id' => array(
						'type' => 'integer',
						'null' => true,
						'default' => NULL,
						'key' => 'index'
				),
				'state' => array(
						'type' => 'string',
						'null' => false,
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'name' => array(
						'type' => 'string',
						'null' => false,
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'costPerUnit' => array(
						'type' => 'integer',
						'null' => false,
						'default' => '0'
				),
				'quantity' => array(
						'type' => 'integer',
						'null' => false,
						'default' => '0'
				),
				'totalCost' => array(
						'type' => 'integer',
						'null' => false,
						'default' => '0'
				),
				'amount' => array(
						'type' => 'integer',
						'null' => false,
						'default' => '0'
				),
				'account' => array(
						'type' => 'string',
						'null' => false,
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'indexes' => array(
						'PRIMARY' => array(
								'column' => 'id',
								'unique' => 1
						),
						'bill_id' => array(
								'column' => 'bill_id',
								'unique' => 0
						),
						'parent_id' => array(
								'column' => 'parent_id',
								'unique' => 0
						)
				),
				'tableParameters' => array(
						'charset' => 'latin1',
						'collate' => 'latin1_swedish_ci',
						'engine' => 'MyISAM'
				)
		);
		var $memberships = array(
				'id' => array(
						'type' => 'integer',
						'null' => false,
						'default' => NULL,
						'key' => 'primary'
				),
				'user_id' => array(
						'type' => 'integer',
						'null' => false,
						'default' => NULL,
						'key' => 'index'
				),
				'organization_id' => array(
						'type' => 'integer',
						'null' => false,
						'default' => NULL,
						'key' => 'index'
				),
				'role' => array(
						'type' => 'string',
						'null' => false,
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'title' => array(
						'type' => 'string',
						'null' => false,
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'since' => array(
						'type' => 'date',
						'null' => false,
						'default' => '0000-00-00'
				),
				'end_date' => array(
						'type' => 'date',
						'null' => false,
						'default' => '0000-00-00'
				),
				'duesPaid' => array(
						'type' => 'date',
						'null' => false,
						'default' => '0000-00-00'
				),
				'status' => array(
						'type' => 'string',
						'null' => false,
						'default' => 'Active',
						'length' => 25,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'reserver' => array(
						'type' => 'string',
						'null' => false,
						'default' => 'No',
						'length' => 3,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'indexes' => array(
						'PRIMARY' => array(
								'column' => 'id',
								'unique' => 1
						),
						'user_id' => array(
								'column' => 'user_id',
								'unique' => 0
						),
						'organization_id' => array(
								'column' => 'organization_id',
								'unique' => 0
						)
				),
				'tableParameters' => array(
						'charset' => 'latin1',
						'collate' => 'latin1_swedish_ci',
						'engine' => 'MyISAM'
				)
		);
		var $organizations = array(
				'id' => array(
						'type' => 'integer',
						'null' => false,
						'default' => NULL,
						'key' => 'primary'
				),
				'name' => array(
						'type' => 'string',
						'null' => false,
						'length' => 200,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'dues' => array(
						'type' => 'string',
						'null' => false,
						'length' => 100,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'type' => array(
						'type' => 'string',
						'null' => false,
						'length' => 100,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'description' => array(
						'type' => 'text',
						'null' => true,
						'default' => NULL,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'status' => array(
						'type' => 'string',
						'null' => false,
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'member_count' => array(
						'type' => 'integer',
						'null' => false,
						'default' => '0'
				),
				'logo_name' => array(
						'type' => 'string',
						'null' => false,
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'logo_size' => array(
						'type' => 'integer',
						'null' => false,
						'default' => '0'
				),
				'logo_type' => array(
						'type' => 'string',
						'null' => false,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'logo' => array(
						'type' => 'binary',
						'null' => true,
						'default' => NULL
				),
				'short_name' => array(
						'type' => 'string',
						'null' => false,
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'website' => array(
						'type' => 'string',
						'null' => false,
						'length' => 100,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'website_key' => array(
						'type' => 'string',
						'null' => false,
						'length' => 100,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'organization_email' => array(
						'type' => 'string',
						'null' => false,
						'length' => 100,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'address_line_1' => array(
						'type' => 'string',
						'null' => false,
						'length' => 100,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'address_line_2' => array(
						'type' => 'string',
						'null' => false,
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'city' => array(
						'type' => 'string',
						'null' => false,
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'state' => array(
						'type' => 'string',
						'null' => false,
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'zip' => array(
						'type' => 'string',
						'null' => false,
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'phone_number' => array(
						'type' => 'string',
						'null' => false,
						'length' => 100,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'fax_number' => array(
						'type' => 'string',
						'null' => false,
						'length' => 100,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'parent_organization' => array(
						'type' => 'string',
						'null' => false,
						'length' => 100,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'approved_service_hours' => array(
						'type' => 'string',
						'null' => false,
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'organization_contact' => array(
						'type' => 'string',
						'null' => false,
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'organization_contact_campus_email' => array(
						'type' => 'string',
						'null' => false,
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'organization_contact_preferred_email' => array(
						'type' => 'string',
						'null' => false,
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'organization_contact_local_phone' => array(
						'type' => 'string',
						'null' => false,
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'organization_contact_mobile_phone' => array(
						'type' => 'string',
						'null' => false,
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'annual_events' => array(
						'type' => 'string',
						'null' => false,
						'length' => 1000,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'charter_date' => array(
						'type' => 'date',
						'null' => false,
						'default' => '0000-00-00'
				),
				'elections' => array(
						'type' => 'string',
						'null' => false,
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'meeting_info' => array(
						'type' => 'string',
						'null' => false,
						'length' => 1000,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'meeting_frequency' => array(
						'type' => 'string',
						'null' => false,
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'indexes' => array('PRIMARY' => array(
							'column' => 'id',
							'unique' => 1
					)),
				'tableParameters' => array(
						'charset' => 'latin1',
						'collate' => 'latin1_swedish_ci',
						'engine' => 'MyISAM'
				)
		);
		var $resolution_items = array(
				'id' => array(
						'type' => 'integer',
						'null' => false,
						'default' => NULL,
						'key' => 'primary'
				),
				'bill_id' => array(
						'type' => 'integer',
						'null' => false,
						'default' => NULL,
						'key' => 'index'
				),
				'parent_id' => array(
						'type' => 'integer',
						'null' => false,
						'default' => NULL,
						'key' => 'index'
				),
				'state' => array(
						'type' => 'string',
						'null' => false,
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'context' => array(
						'type' => 'text',
						'null' => true,
						'default' => NULL,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'indexes' => array(
						'PRIMARY' => array(
								'column' => 'id',
								'unique' => 1
						),
						'bill_id' => array(
								'column' => 'bill_id',
								'unique' => 0
						),
						'parent_id' => array(
								'column' => 'parent_id',
								'unique' => 0
						)
				),
				'tableParameters' => array(
						'charset' => 'latin1',
						'collate' => 'latin1_swedish_ci',
						'engine' => 'MyISAM'
				)
		);
		var $sga_people = array(
				'id' => array(
						'type' => 'integer',
						'null' => false,
						'default' => NULL,
						'key' => 'primary'
				),
				'user_id' => array(
						'type' => 'integer',
						'null' => false,
						'default' => NULL,
						'key' => 'index'
				),
				'house' => array(
						'type' => 'string',
						'null' => false,
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'department' => array(
						'type' => 'string',
						'null' => false,
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'status' => array(
						'type' => 'string',
						'null' => false,
						'default' => 'Active',
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'indexes' => array(
						'PRIMARY' => array(
								'column' => 'id',
								'unique' => 1
						),
						'user_id' => array(
								'column' => 'user_id',
								'unique' => 0
						)
				),
				'tableParameters' => array(
						'charset' => 'latin1',
						'collate' => 'latin1_swedish_ci',
						'engine' => 'MyISAM'
				)
		);
		var $users = array(
				'id' => array(
						'type' => 'integer',
						'null' => false,
						'default' => NULL,
						'key' => 'primary'
				),
				'gtUsername' => array(
						'type' => 'string',
						'null' => false,
						'default' => NULL,
						'length' => 50,
						'key' => 'unique',
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'phone' => array(
						'type' => 'string',
						'null' => false,
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'email' => array(
						'type' => 'string',
						'null' => false,
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'name' => array(
						'type' => 'string',
						'null' => false,
						'length' => 100,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'first_name' => array(
						'type' => 'string',
						'null' => false,
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'last_name' => array(
						'type' => 'string',
						'null' => false,
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'level' => array(
						'type' => 'string',
						'null' => false,
						'default' => 'User',
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'local_address_line_1' => array(
						'type' => 'string',
						'null' => false,
						'length' => 100,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'local_address_line_2' => array(
						'type' => 'string',
						'null' => false,
						'length' => 100,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'local_city' => array(
						'type' => 'string',
						'null' => false,
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'local_state' => array(
						'type' => 'string',
						'null' => false,
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'local_zip' => array(
						'type' => 'string',
						'null' => false,
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'home_phone_number' => array(
						'type' => 'string',
						'null' => false,
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'home_address_line_1' => array(
						'type' => 'string',
						'null' => false,
						'length' => 100,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'home_address_line_2' => array(
						'type' => 'string',
						'null' => false,
						'length' => 100,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'home_city' => array(
						'type' => 'string',
						'null' => false,
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'home_state' => array(
						'type' => 'string',
						'null' => false,
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'home_zip' => array(
						'type' => 'string',
						'null' => false,
						'length' => 50,
						'collate' => 'latin1_swedish_ci',
						'charset' => 'latin1'
				),
				'indexes' => array(
						'PRIMARY' => array(
								'column' => 'id',
								'unique' => 1
						),
						'gtUsername' => array(
								'column' => 'gtUsername',
								'unique' => 1
						)
				),
				'tableParameters' => array(
						'charset' => 'latin1',
						'collate' => 'latin1_swedish_ci',
						'engine' => 'MyISAM'
				)
		);
	}
?>