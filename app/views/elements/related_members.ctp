<div>
	<h3>Members</h3>
	<?php if (count($members) > 0):
	?>
	<table cellpadding = "0" cellspacing = "0">
		<tr>
			<th width="40%">Member</th>
			<?php if ($isOfficer || $this->isLevel('admin')) {
			?>
			<th width="40%">Email</th>
			<th width="20%">Phone</th>
			<?php }?>
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
			<td><?php
				if (!$isOfficer && !$this -> isLevel('admin'))
				{
					echo $member['User']['name'];
				}
				else
				{
					echo $this -> Html -> link($member['User']['name'], array(
							'controller' => 'memberships',
							'action' => 'edit',
							$memberships[$id][$member['User']['id']],
							'admin' => false,
							'officer' => false
					));
				}
			?></td>
			<?php if ($isOfficer || $this->isLevel('admin')) {
			?>
			<td><?php echo $this -> Html -> link($member['User']['email'], 'mailto:' . $member['User']['email']);?></td>
			<td><?php echo $member['User']['phone'];?></td>
			<?php }?>
			</tr>
			<?php endforeach;?>
	</table>
	<?php else:?>
	<h4>No members.</h4>
	<?php endif;?>
</div>
