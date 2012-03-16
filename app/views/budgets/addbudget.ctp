<?php echo $this->Html->addCrumb('All Organizations', '/organizations'); ?>
<?php echo $this->Html->addCrumb($organization['Organization']['name'], '/owner/organizations/view/'.$organization['Organization']['id']); ?>
<?php echo $this->Html->addCrumb('Submit Budget', '/budgets/addbudget/'.$organization['Organization']['id']); ?>
<div id="sidebars">




<?php echo $this->element('sidebar')?>
</div>
<div id="middle">
	<h3>Choose Budget</h3>
	
	
	
	
	
	
	
	
	<?php
	echo $this->Form->create('false', array('url'=>array('controller'=>'budgets', 'action'=>'addbudget', $organization['Organization']['id']), 'type' => 'file'));
	echo $this->Form->file('File.doc');
    echo $this->Form->submit('Upload', array('url'=>array('controller'=>'budgets', 'action'=>'addbudget', $organization['Organization']['id'])));
	echo $this->Form->end();
	?>
	Budget should be less than 2MB in size.
</div>
