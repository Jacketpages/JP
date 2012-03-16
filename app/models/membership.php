<?php
class Membership extends AppModel {
	var $name = 'Membership';
	var $actsAs = array('Containable');
	var $belongsTo = array(
		'Organization' => array(
			'className' => 'Organization',
			'foreignKey' => 'organization_id',
	),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
	),
	);
	var $validate = array(
		'role' => array(
			'declared' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => 'Must be numbers and letters.',
	),
	),
		'user_id' => array(
			'declared' => array(
				'rule' => 'notEmpty',
				'required' => true,
	),
	),
		'organization_id' => array(
			'declared' => array(
				'rule' => 'notEmpty',
				'required' => true,
	),
	),
	);
}
?>
