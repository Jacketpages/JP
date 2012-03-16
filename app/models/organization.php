<?php
class Organization extends AppModel {
	var $name = 'Organization';
	var $hasMany = array(
		'Category' => array(
			'className' => 'Category',
			'foreignKey' => 'organization_id',
			'dependent' => 'true',
	),
		'Interest' => array(
			'className' => 'Interest',
			'foreignKey' => 'organization_id',
			'dependent' => 'true',
	),
		'Bill' => array(
			'className' => 'Bill',
			'foreignKey' => 'organization_id',
			'dependent' => 'true',
	),
		'Member' => array(
			'className' => 'Membership',
			'foreignKey' => 'organization_id',
			'conditions' => array('Member.role' => 'Member'),
	),
		'PendingMember' => array(
			'className' => 'Membership',
			'foreignKey' => 'organization_id',
            'conditions' => array('PendingMember.role' => 'Pending Member'),
	),
		'President' => array(
			'className' => 'Membership',
			'foreignKey' => 'organization_id',
            'conditions' => array('President.role' => 'President'),
	),
		'Treasurer' => array(
			'className' => 'Membership',
			'foreignKey' => 'organization_id',
            'conditions' => array('Treasurer.role' => 'Treasurer'),
	),
        'Advisor' => array(
            'className' => 'Membership',
            'foreignKey' => 'organization_id',
            'conditions' => array('Advisor.role' => 'Advisor'),
	),
		'Officer' => array(
			'className' => 'Membership',
			'foreignKey' => 'organization_id',
            'conditions' => array('Officer.role' => 'Officer'),
	),
		'RoomReserver' => array(
			'className' => 'Membership',
			'foreignKey' => 'organization_id',
            'conditions' => array('RoomReserver.role' => 'Room Reserver'),
	),

		'Charter' => array(
			'className' => 'Charter',
			'foreignKey' => 'organization_id',
			'dependent' => 'true',
	),

		'Budget' => array(
			'className' => 'Budget',
			'foreignKey' => 'organization_id',
			'dependent' => 'true',
	),
	);
	var $order = array("Organization.name" => "asc");

}
?>
