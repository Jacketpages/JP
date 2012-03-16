<?php
class SgaPerson extends AppModel{
	var $name = 'SgaPerson';
	var $useTable = 'sga_people';
	var $recursive = 1;
	var $displayField = 'user_id';
	var $hasMany = array(
		'UndergradBill' => array(
			'className' => 'Bill',
			'foreignKey' => 'underAuthor_id',
	),
		'GradBill' => array(
			'className' => 'Bill',
			'foreignKey' => 'gradAuthor_id',
	),
	);
	// The User array already has all of these fields so this was only 
	// creating duplicate entries in the array of every field within the
	// User model. Slowed things down immensely.
	
	// var $hasOne = array(
		// 'Name' => array(
			// 'className' => 'User',
			// 'foreignKey' => 'name',
	// ),
		// 'Email' => array(
			// 'className' => 'User',
			// 'foreignKey' => 'email',
	// ),
		// 'Phone' => array(
			// 'className' => 'User',
			// 'foreignKey' => 'phone',
	// ),
	// );
	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
	),
	);
	var $validate = array(
		'user_id' => array(
			'required' => array('rule' => 'notEmpty', 'message' => 'Invalid user.', 'allowEmpty' => 'false'),
			'unique' => array('rule' => array('validateUniqueUsername'), 'message' => 'This user is already assigned a role in SGA.'),

	),
	);
	var $order = array("house" => "asc");
	function validateUniqueUsername(){
		$error=0;
		//Attempt to load based on data in the field
		$someone = $this->find('first', array('recursive' => -1, 'conditions' => array('SgaPerson.user_id' => $this->data['SgaPerson']['user_id'])));
		// if we get a result, this user name is in use, try again!
		if (isset($someone['SgaPerson']))
		{
			$error++;
		}
		return ($error==0);
	}

}
