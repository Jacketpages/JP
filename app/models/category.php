<?php
class Category extends AppModel {
	var $name = 'Category';
	var $belongsTo = array(
		'Organization' => array(
			'className' => 'Organization',
			'foreignKey' => 'organization_id'
	),
	);
}
?>