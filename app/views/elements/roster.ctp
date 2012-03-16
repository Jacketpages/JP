<div>
	<h3>Officers</h3>
	<table cellpadding="0" cellspacing="0">
		<tr>
			<th width="50%">Officer (Edit)</th>
			<th width="40%">Role</th>
			<th width="10%"></th>
		</tr>
		<?php
$i = 0;
foreach ($presidents as $president):
		?>
		<tr>
			<td><?php echo $this -> Html -> link($president['User']['name'], array(
					'controller' => 'memberships',
					'action' => 'edit',
					$president_memberships[$id][$president['User']['id']]
			));
			?></td>
			<td><?php echo $president_title[$president['User']['id']];?>
			&nbsp;</td>
			<td><?php echo $this -> Html -> link('Remove', array(
						'controller' => 'memberships',
						'action' => 'delete',
						'admin' => false,
						'officer' => false,
						$president_memberships[$id][$president['User']['id']]
				), null, sprintf(__('Are you sure you want to delete this membership?', true)));
			?></td>
		</tr>
		<?php $i++;
			endforeach;
		?>
		<?php
foreach ($treasurers as $treasurer):
		?>
		<tr>
			<td><?php echo $this -> Html -> link($treasurer['User']['name'], array(
					'controller' => 'memberships',
					'action' => 'edit',
					$treasurer_memberships[$id][$treasurer['User']['id']]
			));
			?></td>
			<td><?php echo $treasurer_title[$treasurer['User']['id']];?>
			&nbsp;</td>
			<td><?php echo $this -> Html -> link('Remove', array(
						'controller' => 'memberships',
						'action' => 'delete',
						'admin' => false,
						'officer' => false,
						$treasurer_memberships[$id][$treasurer['User']['id']]
				), null, sprintf(__('Are you sure you want to delete this membership?', true)));
			?></td>
		</tr>
		<?php $i++;
			endforeach;
		?>
		<?php
foreach ($officers as $officer):
		?>
		<tr>
			<td><?php echo $this -> Html -> link($officer['User']['name'], array(
					'controller' => 'memberships',
					'action' => 'edit',
					$officer_memberships[$id][$officer['User']['id']]
			));
			?></td>
			<td><?php echo $officer_title[$officer['User']['id']];?>
			&nbsp;</td>
			<td><?php echo $this -> Html -> link('Remove', array(
						'controller' => 'memberships',
						'action' => 'delete',
						'admin' => false,
						'officer' => false,
						$officer_memberships[$id][$officer['User']['id']]
				), null, sprintf(__('Are you sure you want to delete this membership?', true)));
			?></td>
		</tr>
		<?php $i++;
			endforeach;
		?>
		<?php
foreach ($advisors as $advisor):
		?>
		<tr>
			<td><?php echo $this -> Html -> link($advisor['User']['name'], array(
					'controller' => 'memberships',
					'action' => 'edit',
					$advisor_memberships[$id][$advisor['User']['id']]
			));
			?></td>
			<td><?php echo $advisor_title[$advisor['User']['id']];?>
			&nbsp;</td>
			<td><?php echo $this -> Html -> link('Remove', array(
						'controller' => 'memberships',
						'action' => 'delete',
						'admin' => false,
						'officer' => false,
						$advisor_memberships[$id][$advisor['User']['id']]
				), null, sprintf(__('Are you sure you want to delete this membership?', true)));
			?></td>
		</tr>
		<?php $i++;
			endforeach;
		?>
		<?php
foreach ($reservers as $reserver):
		?>
		<tr>
			<td><?php echo $this -> Html -> link($reserver['User']['name'], array(
					'controller' => 'memberships',
					'action' => 'edit',
					$reserver_memberships[$id][$reserver['User']['id']]
			));
			?></td>
			<td> Room Reserver
			&nbsp; </td>
			<td><?php echo $this -> Html -> link('Remove', array(
						'controller' => 'memberships',
						'action' => 'delete',
						'admin' => false,
						'officer' => false,
						$reserver_memberships[$id][$reserver['User']['id']]
				), null, sprintf(__('Are you sure you want to delete this membership?', true)));
			?></td>
		</tr>
		<?php $i++;
			endforeach;
		?>
	</table>
	<?php if ($i == 0) {
	?>
	<h4>No officer information available.</h4>
	<?php }?>
</div>
<div>
	<h3>Members</h3>
	<?php if (count($members) > 0):
	?>
	<table cellpadding = "0" cellspacing = "0">
		<tr>
			<th width="90%">Member (Edit)</th>
			<th width="10%"></th>
		</tr>
		<?php
$i = 0;
foreach ($members as $member):
$class = null;
if ($i++ % 2 == 0) {
$class = ' class="altrow"';
}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $this -> Html -> link($member['User']['name'], array(
					'controller' => 'memberships',
					'action' => 'edit',
					$memberships[$id][$member['User']['id']]
			));
			?></td>
			<td><?php echo $this -> Html -> link('Remove', array(
						'controller' => 'memberships',
						'action' => 'delete',
						'admin' => false,
						'officer' => false,
						$memberships[$id][$member['User']['id']]
				), null, sprintf(__('Are you sure you want to delete this membership?', true)));
			?></td>
			</tr> <?php endforeach;?>
	</table>
	<?php else:?>
	<h4>No members.</h4>
	<br/>
	<?php endif;?>
</div>
<div>
	<h3>Pending Members</h3>
	<?php if (count($pending) > 0):
	?>
	<table cellpadding = "0" cellspacing = "0">
		<tr>
			<th width="90%">Pending Member (Edit)</th>
			<th width="10%"></th>
		</tr>
		<?php
$i = 0;

foreach ($pending as $member):
$class = null;
if ($i++ % 2 == 0) {
$class = ' class="altrow"';
}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $this -> Html -> link($member['User']['name'], array(
					'controller' => 'memberships',
					'action' => 'edit',
					$memberships[$id][$member['User']['id']]
			));
			?></td>
			<td><?php echo $this -> Html -> link('Remove', array(
						'controller' => 'memberships',
						'action' => 'delete',
						'admin' => false,
						'officer' => false,
						$memberships[$id][$member['User']['id']]
				), null, sprintf(__('Are you sure you want to delete this membership?', true)));
			?></td>
			</tr> <?php endforeach;?>
	</table>
	<?php else:?>
	<h4>No pending members.</h4>
	<?php endif;?>
</div>
