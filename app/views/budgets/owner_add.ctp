<?php echo $this->Html->addCrumb('My Organizations', '/owner/organizations'); ?>
<?php echo $this->Html->addCrumb($org['Organization']['name'], '/owner/organizations/view/'.$org['Organization']['id']); ?>
<div id="sidebars">




<?php echo $this->element('sidebar')?>
</div>
<div id="middle">
	<h3>
		Charter for
		<?php echo $org['Organization']['name'];?>
	</h3>
	
	
	
	
	
	
	
	
<?php echo $form->create('Charter', array('action' => 'add/'.$org['Organization']['id'], 'type' => 'file')); ?>
<fieldset>
 		<?php
if(isset($org['Charter']['updated'])){
	echo "<p>This organization has a charter in the system as of ".$org['Charter']['updated']."</p>";
}
?>

<?php
    echo $form->file('File');
    echo $form->submit('Upload');
    
?>
</fieldset>
<?php echo $form->end();?>
</div>
