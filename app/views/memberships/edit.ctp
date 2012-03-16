<?php $this -> Html -> addCrumb($org[0]['Organization']['name'], '/organizations/view/' . $org[0]['Organization']['id']);?>
<?php $this -> Html -> addCrumb('Edit Member', '/memberships/edit/' . $this -> data['Membership']['id']);?>
<div id="sidebars">
	<ul>
		<li>
			<?php echo $this -> Html -> link(__('Delete', true), array(
					'action' => 'delete',
					$this -> Form -> value('Membership.id')
			), null, sprintf(__('Are you sure you want to delete this membership?', true)));
			?>
		</li>
	</ul>
	<?php echo $this->element('sidebar')
	?>
</div>
<div id="middle">
	<h3>Edit Membership</h3>
	<div id="desc">
		<div id="descLeft">
			<table cellpadding="0" cellspacing="0">
				<tr>
					<td width="40%">User</td>
					<td width="60%"><?php echo $user[0]['User']['name'];?>&nbsp;</td>
				</tr>
				<tr>
					<td width="40%">Organization</td>
					<td width="60%"><?php echo $org[0]['Organization']['name'];?>&nbsp;</td>
				</tr>
			</table>
		</div>
	</div>
	</br> <?php echo $this -> Form -> create('Membership');?>
	<fieldset>
		<?php
			echo $this -> Form -> input('id');
			echo $this -> Form -> input('role', array('options' => array(
						'Officer' => 'Officer',
						'Member' => 'Member',
						'President' => 'President',
						'Treasurer' => 'Treasurer',
						'Advisor' => 'Advisor'
				)));
			echo $this -> Form -> input('title', array(
					'label' => 'Title (please default to role name)',
					'default' => '(role)'
			));
			echo $this -> Form -> input('status', array('options' => array(
						'Active' => 'Active',
						'Inactive' => 'Inactive',
						'Pending' => 'Pending'
				)));
			if ($this -> isLevel('admin') || $role == 'President')
			{
				echo $this -> Form -> input('reserver', array(
						'label' => 'Room Reserver',
						'options' => array(
								'No' => 'No',
								'Yes' => 'Yes'
						)
				));
			}
		?>
		<div id="date">
			<?php echo $this -> Form -> input('since', array(
					'label' => 'Start Date',
					'dateFormat' => 'MDY'
			));
			?>
			<?php echo $this -> Form -> input('duesPaid', array('dateFormat' => 'MDY'));?>
		</div>
	</fieldset>
	<?php echo $this -> Form -> end(__('Submit', true));?>
</div>
