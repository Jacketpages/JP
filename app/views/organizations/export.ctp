<?php
$fields = array('Organization Name', 'Status', 'Contact', 'Contact Email','President','President Email','Treasurer', 'Treasurer Email');
$csv->addRow($fields);
foreach($organizations as $org){
	$rowContents = array($org['Organization']['Organization']['name'], $org['Organization']['Organization']['status'],$org['Organization']['Organization']['organization_contact'],$org['Organization']['Organization']['organization_contact_campus_email'],$org['Members']['presidents']['0']['User']['name'],$org['Members']['presidents']['0']['User']['email'],$org['Members']['treasurers']['0']['User']['name'],$org['Members']['treasurers']['0']['User']['email']);
	$csv->addRow($rowContents);
}
$csv->setFilename("Organizations-$fy.csv");
echo $csv->render();
?>