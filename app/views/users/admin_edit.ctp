<?php echo $this -> Html -> addCrumb('Users', '/admin/users');?>
<?php echo $this -> Html -> addCrumb($user['User']['name'], '/admin/users/view/' . $user['User']['id']);?>
<?php echo $this -> Html -> addCrumb('Edit User', '/admin/users/edit/' . $user['User']['id']);?>
<div id="sidebars">
	<ul>
		<?php if($user['SgaPerson']['id'] != ''):
		?>
		<li>
			<?php echo $this -> Html -> link(__('Edit SGA House', true), array(
					'controller' => 'sga_people',
					'action' => 'edit',
					$user['SgaPerson']['id']
			));
			?>
		</li>
		<?php else:?>
		<li>
			<?php echo $this -> Html -> link(__('Add SGA House', true), array(
					'controller' => 'sga_people',
					'action' => 'add',
					$user['User']['id']
			));
			?>
		</li>
		<?php endif;?>
		<li>
			<?php echo $this -> Html -> link('Add Affiliation', array(
					'controller' => 'memberships',
					'action' => 'add',
					$user['User']['id']
			));
			?>
		</li>
		<li>
			<?php echo $this -> Html -> link(__('Delete User', true), array(
					'action' => 'delete',
					$user['User']['id']
			), null, sprintf(__('Are you sure you want to delete %s?', true), $user['User']['name']));
			?>
		</li>
	</ul>
	<?php echo $this->element('sidebar')
	?>
</div>
<div id="middle">
	<h3>Edit User</h3>
	<?php echo $this -> Form -> create('User');?>
	<fieldset>
		GT Usernames are passed from the Georgia Institute of Technology's Office of Information Technology and cannot be edited.
		<br />
		<br />
		<?php
			echo $this -> Form -> input('name', array('label' => 'Name*'));
			echo $this -> Form -> input('email', array('label' => 'Email*'));
			echo $this -> Form -> input('phone');
			echo $this -> Form -> input('level', array('options' => array(
						'user' => 'Normal',
						'power' => 'SGA Power',
						'admin' => 'Administrator'
				)));
		?>
	</fieldset>
	<?php echo $this -> Form -> end(__('Submit', true));?>
</div>