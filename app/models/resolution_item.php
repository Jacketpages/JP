<?php
class ResolutionItem extends AppModel {
	var $name = 'ResolutionItem';
	var $belongsTo = array(
		'Bill' => array(
			'className' => 'Bill',
			'foreignKey' => 'bill_id',
	),
	);
	var $order = array("bill_id" => "asc");
}
?>
