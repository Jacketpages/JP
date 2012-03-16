<?php $this -> Html -> addCrumb('Users', '/admin/users');?>
<?php $this -> Html -> addCrumb($user['User']['name'], '/admin/users/view/' . $user['User']['id']);?>
<div id="sidebars">
	<ul>
		<li>
			<?php echo $this -> Html -> link(__('Edit User', true), array(
					'action' => 'edit',
					$user['User']['id']
			));
			?>
		</li>
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
	<?php echo $this->element('user_info', array($user))
	?>

	<?php echo $this -> element('user_organizations', array(
			$user,
			$organizations
	));
	?>
</div>
