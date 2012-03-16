<?php $this->Html->addCrumb('Resolution Items', 'power/resolution_items'); ?>
<div id="sidebars">
	<ul>
		<li><?php echo $this->Html->link(__('View Bill', true), array('controller' => 'bills', 'action' => 'view', $this->data['ResolutionItem']['bill_id'])); ?>
		</li>
	</ul>
	
	
	
	
	
	
	
	
	<?php echo $this->element('sidebar')?>
</div>
<div id="middle">
	<h3>Revise Resolution Item</h3>
	
	
	
	
	
	
	
	
<?php echo $this->Form->create('ResolutionItem');?>
	<fieldset>
	<?php
		echo $this->Form->hidden('bill_id');
		echo $this->Form->hidden('parent_id');
		echo $this->Form->input('state', array('label' => 'Revision', 'options' => array('Undergraduate' => 'Undergraduate', 'Graduate' => 'Graduate', 'conference' => 'Conference', 'final' => 'Final')));
		echo $this->Form->input('content', array('label' => 'Content'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Revise', true));?>
</div>
