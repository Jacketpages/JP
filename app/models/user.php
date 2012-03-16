<?php
class User extends AppModel {
	var $name = 'User';
	var $hasOne = array(
		'SgaPerson' => array(
			'className' => 'SgaPerson',
			'foreignKey' => 'id',
	),
	);
	var $hasMany = array(
        'President' => array(
            'className' => 'Membership',
            'foreignKey' => 'user_id',
            'conditions' => array('President.role' => 'President'),
	),
        'Treasurer' => array(
            'className' => 'Membership',
            'foreignKey' => 'user_id',
            'conditions' => array('Treasurer.role' => 'Treasurer'),
	),
        'Advisor' => array(
            'className' => 'Membership',
            'foreignKey' => 'user_id',
            'conditions' => array('Advisor.role' => 'Advisor'),
	),
		'Officer' => array(
            'className' => 'Membership',
            'foreignKey' => 'user_id',
            'conditions' => array('Officer.role' => 'Officer'),
	),
		'RoomReserver' => array(
            'className' => 'Membership',
            'foreignKey' => 'user_id',
            'conditions' => array('RoomReserver.role' => 'Room Reserver'),
	),
		'Member' => array(
            'className' => 'Membership',
            'foreignKey' => 'user_id',
            'conditions' => array('Member.role' => 'Member'),
	),
		'PendingMember' => array(
            'className' => 'Membership',
            'foreignKey' => 'user_id',
            'conditions' => array('PendingMember.role' => 'Pending Member'),
	),
		'Organizations' => array(
			'className' => 'Membership',
			'foreignKey' => 'user_id',
	),
	);
	var $validate = array(
		'email' => array(
			'rule' => 'email',
			'allowEmpty' => 'false',
			'message' => 'A valid email address is required to use the system.',
	),
		'name' => array(
			'rule' => 'notEmpty',
			'required' => 'true',
			'allowEmpty' => 'false',
			'message' => 'A name is required to use the system.',
	),
		'gtUsername' => array(
			'rule' => 'isUnique',
			'message' => 'That GT username already is in the system.',
	),
	);

	var $order = array("User.name" => "asc");

	function set($one, $two = null) {
		parent::set($one, $two);
		// if not already found in database
		if (!$this->exists()) {
			if ($this->id) {
				$this->data[$this->alias][$this->primaryKey] = $this->id;
				$this->id = false;
			}
		}
	}
}
?>
