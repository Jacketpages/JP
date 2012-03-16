<?php
class LineItem extends AppModel {
	var $name = 'LineItem';
	var $belongsTo = array(
		'Parent' => array(
			'className' => 'LineItem',
			'foreignKey' => 'parent_id',
	),
		'Bill' => array(
			'className' => 'Bill',
			'foreignKey' => 'bill_id',
	),
	);
	var $hasMany = array(
		'Children' => array(
			'className' => 'LineItem',
			'foreignKey' => 'parent_id',
			'dependent' => false,
	),
	);
	var $order = array("LineItem.bill_id" => "asc", "LineItem.name" => "asc");
	var $validate = array(
		'name' => array(
			'declared' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => 'Must be numbers and letters and cannot be blank.',
	),
	),
	);
}
?>
