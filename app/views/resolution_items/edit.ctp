<?php $this->Html->addCrumb('Resolution Items', 'users/resolution_items'); ?>
<div id="sidebars">
	<ul>
		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('ResolutionItem.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('ResolutionItem.id'))); ?>
		</li>
		<li><?php echo $this->Html->link(__('List Resolution Items', true), array('action' => 'index'));?>
		</li>
		<li><?php echo $this->Html->link(__('List Line Items', true), array('controller' => 'line_items', 'action' => 'index')); ?>
		</li>
		<li><?php echo $this->Html->link(__('New Parent', true), array('controller' => 'resolution_items', 'action' => 'add')); ?>
		</li>
		<li><?php echo $this->Html->link(__('List Bills', true), array('controller' => 'bills', 'action' => 'index')); ?>
		</li>
		<li><?php echo $this->Html->link(__('New Bill', true), array('controller' => 'bills', 'action' => 'add')); ?>
		</li>
	</ul>
	
	
	
	
	
	
	
	
	<?php echo $this->element('sidebar')?>
</div>
<div id="middle">
	<h3>Edit Resolution Item</h3>
	
	
	
	
	
	
	
	
<?php echo $this->Form->create('ResolutionItem');?>
	<fieldset>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('bill_id');
		echo $this->Form->input('parent_id');
		echo $this->Form->input('state');
		echo $this->Form->input('content');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
