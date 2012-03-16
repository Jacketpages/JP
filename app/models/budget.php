<?php
class Budget extends AppModel {
	var $name = 'Budget';
	var $belongsTo = array(
		'Organization' => array(
			'className' => 'Organization',
			'foreignKey' => 'organization_id',
	),
	);
}
?>
