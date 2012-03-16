<?php echo $this->Html->addCrumb('Add User', '/admin/users/add'); ?>
<div id="sidebars">




<?php echo $this->element('sidebar')?>
</div>
<div id="middle">
	<h3>Add User</h3>
	
	
	
	
	
	
	
	
<?php echo $this->Form->create('User');?>
	<fieldset>
	<?php
		echo $this->Form->input('gtUsername', array('type' => 'text','label' => 'GT Username*', 'hidden' => false));
		echo $this->Form->input('name', array('label' => 'Name*'));
		echo $this->Form->input('email', array('label' => 'Email*'));
		echo $this->Form->input('phone');
		echo $this->Form->input('level', array('options' => array('user' => 'Normal', 'power' => 'SGA Power', 'admin' => 'Administrator'), 'default' => 'user'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
