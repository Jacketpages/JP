<?php
class Charter extends AppModel {
	var $name = 'Charter';
	var $belongsTo = array(
		'Organization' => array(
			'className' => 'Organization',
			'foreignKey' => 'organization_id',
	),
	);
}
?>
