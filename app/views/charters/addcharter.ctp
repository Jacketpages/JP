<?php echo $this->Html->addCrumb('All Organizations', '/organizations'); ?>
<?php echo $this->Html->addCrumb($organization['Organization']['name'], '/owner/organizations/view/'.$organization['Organization']['id']); ?>
<?php echo $this->Html->addCrumb('Add Document', '/charters/addcharter/'.$organization['Organization']['id']); ?>
<div id="sidebars">




<?php echo $this->element('sidebar')?>
</div>
<div id="middle">
	<h3>Choose Document</h3>
	
	
	
	
	
	
	
	
	<?php
	echo $this->Form->create('false', array('url'=>array('controller'=>'charters', 'action'=>'addcharter', $organization['Organization']['id']), 'type' => 'file'));
	echo $this->Form->file('File.doc');
    echo $this->Form->submit('Upload', array('url'=>array('controller'=>'charters', 'action'=>'addcharter', $organization['Organization']['id'])));
	echo $this->Form->end();
	?>
	Document should be less than 2MB in size.
</div>
