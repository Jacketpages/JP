<?php echo $this->Html->addCrumb('My Bills', '/owner/bills'); ?>
<?php echo $this->Html->addCrumb('Bill', '/owner/bills/view/'.$this->data['Bill']['id']); ?>
<div id="sidebars">
	<ul>
		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('LineItem.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('LineItem.id'))); ?>
		</li>
		<li><?php echo $this->Html->link(__('List Line Items', true), array('action' => 'index'));?>
		</li>
		<li><?php echo $this->Html->link(__('List Line Items', true), array('controller' => 'line_items', 'action' => 'index')); ?>
		</li>
		<li><?php echo $this->Html->link(__('New Parent', true), array('controller' => 'line_items', 'action' => 'add')); ?>
		</li>
		<li><?php echo $this->Html->link(__('List Bills', true), array('controller' => 'bills', 'action' => 'index')); ?>
		</li>
		<li><?php echo $this->Html->link(__('New Bill', true), array('controller' => 'bills', 'action' => 'add')); ?>
		</li>
	</ul>
	
	
	
	
	
	
	
	
	<?php echo $this->element('sidebar')?>
</div>
<div id="middle">
	<h3>Edit Line Item</h3>
	
	
	
	
	
	
	
	
<?php echo $this->Form->create('LineItem');?>
	<fieldset>
	<?php
		debug($this);
		echo $this->Form->input('id');
		echo $this->Form->input('bill_id');
		echo $this->Form->input('parent_id');
		echo $this->Form->input('state');
		echo $this->Form->input('name');
		echo $this->Form->input('costPerUnit');
		echo $this->Form->input('quantity');
		echo $this->Form->input('totalCost');
		echo $this->Form->input('amount');
		echo $this->Form->input('account');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
