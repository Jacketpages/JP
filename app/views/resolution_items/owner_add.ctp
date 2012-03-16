<?php $this->Html->addCrumb('Resolution Items', 'owner/resolution_items'); ?>
<div id="sidebars">
	<ul>
		<li><?php echo $this->Html->link(__('List Line Items', true), array('controller' => 'line_items', 'action' => 'index'));?>
		</li>
		<li><?php echo $this->Html->link(__('List Resolution Items', true), array('action' => 'index')); ?>
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
	<h3>
		Add Resolution Item to
		<?php echo $bill['Bill']['title']; ?>
	</h3>
	
	
	
	
	
	
	
	
<?php echo $this->Form->create('ResolutionItem');?>
	<fieldset>
	<?php
		echo $this->Form->hidden('bill_id', array('label' => 'Bill', 'value' => $bill['Bill']['id']));
		echo $this->Form->hidden('parent_id', array('value' => '', 'label' => 'Parent Resolution Item'));
		echo $this->Form->hidden('state', array('value' => 'submitted', 'options' => array('submitted' => 'Submitted', 'Undergraduate' => 'Undergraduate', 'Graduate' => 'Graduate', 'conference' => 'Conference', 'final' => 'Final')));
		echo $this->Form->input('content', array('label' => 'Content'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
