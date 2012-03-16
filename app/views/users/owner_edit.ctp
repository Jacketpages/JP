<?php echo $this -> Html -> addCrumb($user['User']['name'], '/owner/users/view/' . $user['User']['id']);?>
<?php echo $this -> Html -> addCrumb('Edit Profile', '/owner/users/edit/' . $user['User']['id']);?>
<div id="sidebars">
	<ul>
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
		?>
	</fieldset>
	<?php echo $this -> Form -> end(__('Submit', true));?>
</div>