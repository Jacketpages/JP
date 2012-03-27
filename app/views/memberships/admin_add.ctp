<?php $this->Html->addCrumb('Memberships', '/memberships'); ?>
<div id="sidebars">
	<ul>
        <li><?php echo $this->Html->link(__('List Memberships', true), array('action' => 'index'));?></li>
    </ul>
	<?php echo $this->element('sidebar')?>
</div>
<div id="middle">
<h3>Add Membership</h3>
<?php echo $this->Form->create('Membership');?>
	<fieldset>
	<?php
		echo $this->Form->input('user_id', array('default' => $id));
		echo $this->Form->input('organization_id');
		echo $this->Form->input('role', array('options' => array('Member' => 'Member', 'Pending Member' => 'Pending Member', 'President' => 'President', 'Treasurer' => 'Treasurer', 'Advisor' => 'Faculty Advisor', 'Room Reserver' => 'Room Reserver')));
		echo $this->Form->input('title');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
