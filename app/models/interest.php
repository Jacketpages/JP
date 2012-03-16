<?php
class Interest extends AppModel {
	var $name = 'Interest';
	var $belongsTo = array(
		'Organization' => array(
			'className' => 'Organization',
			'foreignKey' => 'organization_id'
	),
	);
}
?>