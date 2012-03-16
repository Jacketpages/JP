<?php echo $this->Html->addCrumb($user['User']['name'], '/owner/users/view/'.$user['User']['id']); ?>
<div id="sidebars">
	<ul>
		<li><?php echo $this->Html->link(__('Edit Profile', true), array('action' => 'edit', $user['User']['id'])); ?>
		</li>
	</ul>
	
	
	
	
	
	
	
	
	<?php echo $this->element('sidebar')?>
</div>
<div id="middle">




<?php echo $this->element('user_info', array($user))?>




<?php echo $this->element('user_organizations', array($user, $organizations)); ?>
</div>
