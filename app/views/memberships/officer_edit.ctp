<?php $this->Html->addCrumb('Memberships', '/memberships'); ?>
<div id="sidebars">
	<ul>
		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Membership.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Membership.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Memberships', true), array('action' => 'index'));?></li>
	</ul>
	<?php echo $this->element('sidebar')?>
</div>
<div id="middle">
<h3>Edit Membership</h3>
<?php echo $this->Form->create('Membership');?>
	<fieldset>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->hidden('user_id');
		echo $this->Form->hidden('organization_id');
		echo $this->Form->input('role', array('options' => array('officer' => 'Officer', 'member' => 'Member', 'pendingMember' => 'Pending Member', 'privileged' => 'Privileged')));
		echo $this->Form->input('duesPaid', array('type' => 'date', 'default' => '0/0/0000'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>