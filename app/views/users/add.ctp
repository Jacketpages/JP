<?php $this->Html->addCrumb('Create Profile', '/users/add'); ?>
<div id="sidebars">




<?php echo $this->element('sidebar')?>
</div>
<div id="middle">
	<h3>Create Profile</h3>
	
	
	
	
	
	
	
	
<?php echo $this->Form->create('User');?>
	<fieldset>
	<?php
		echo $this->Form->input('gtUsername', array('type' => 'text','label' => 'GT Username*', 'hidden' => false, 'readonly'=> 'readonly', 'default' => $this->Session->read('User.gtUsername')));
		echo $this->Form->input('name', array('label' => 'Name*'));
		echo $this->Form->input('email', array('label' => 'Email*'));
		echo $this->Form->input('phone');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
