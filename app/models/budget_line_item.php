<?php
class BudgetLineItem extends AppModel {
	var $name = 'BudgetLineItem';
	var $belongsTo = array(
		'Parent2' => array(
			'className' => 'BudgetLineItem',
			'foreignKey' => 'parent_id',
	),
		'Bill' => array(
			'className' => 'Bill',
			'foreignKey' => 'bill_id',
	),
	);
	var $hasMany = array(
		'Children2' => array(
			'className' => 'BudgetLineItem',
			'foreignKey' => 'parent_id',
			'dependent' => false,
	),
	);
	var $order = array("BudgetLineItem.bill_id" => "asc", "BudgetLineItem.name" => "asc");
}
?>
