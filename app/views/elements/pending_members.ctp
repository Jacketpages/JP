<div>
	<h3>Pending Members</h3>
	
	
	
	
	<?php if (count($pending) > 0):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th width="40%">Pending Member</th>
		<?php if ($isOfficer || $this->isLevel('admin')) {?>
		<th width="40%">Email</th>
		<th width="20%">Phone</th>
		<?php }?>
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
			<td>
				<?php echo $this->Html->link($member['User']['name'], array('controller' => 'memberships', 'action' => 'edit', $memberships[$id][$member['User']['id']]));?>
			</td>			
			<td>
				<?php echo $this->Html->link($member['User']['email'], 'mailto:'.$member['User']['email']);?>
			</td>
			<td>
				<?php echo $member['User']['phone'];?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
	<?php else: ?>
	<h4>No pending members.</h4>
<?php endif; ?>
</div>
