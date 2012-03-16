<h3>Authors</h3>
<table class="list">
	<?php if($bill['Bill']['type'] != 'Budget' && $bill['Bill']['category'] != 'Graduate'):
	?>
	<tr>
		<td class="label">Undergraduate Author</td>
		<td><?php if($bill['UndergradAuthor']['id'] != null):
		?>

		<?php
			if ($this -> isLevel('power'))
			{
				echo $this -> Html -> link($bill['UndergradAuthor']['User']['name'], 'mailto:' . $bill['UndergradAuthor']['User']['email']);
			}
			else
			{
				echo $bill['UndergradAuthor']['User']['name'];
			}
		?>
		&nbsp;
		<?php
			if (!$bill['Bill']['underAuthorApproved'])
			{
				echo " (Undergraduate author has not accepted.)";
			}
		?>
		<?php else:?>
		<em>None</em><?php endif;?></td>
	</tr>
	<?php endif;?>
	<?php if($bill['Bill']['type'] != 'Budget' && $bill['Bill']['category'] != 'Undergraduate'):
	?>
	<tr>
		<td class="label">Graduate Author</td>
		<td><?php if($bill['GraduateAuthor']['id'] != null):
		?>
		<?php
			if ($this -> isLevel('power'))
			{
				echo $this -> Html -> link($bill['GraduateAuthor']['User']['name'], 'mailto:' . $bill['GraduateAuthor']['User']['email']);
			}
			else
			{
				echo $bill['GraduateAuthor']['User']['name'];
			}
		?>
		&nbsp;
		<?php
			if (!$bill['Bill']['gradAuthorApproved'])
			{
				echo " (Graduate author has not accepted.)";
			}
		?>

		<?php else:?>
		<em>None</em><?php endif;?></td>
	</tr>
	<?php endif;?>
	<tr>
		<td class="label">Submitter</td>
		<td><?php
			if ($this -> isLevel('power'))
			{
				echo $this -> Html -> link($bill['Submitter']['name'], 'mailto:' . $bill['Submitter']['email']);
			}
			else
			{
				echo $bill['Submitter']['name'];
			}
		?>
		&nbsp;</td>
	</tr>
	<tr>
		<td class="label">Organization</td>
		<td><?php if($bill['Organization']['name'] != 'N/A'):
		?>
		<?php echo $this -> Html -> link($bill['Organization']['name'], array('controller' => 'organizations', 'action' => 'view', $bill['Organization']['id']));?>
		<?php else:?>
		Not sponsored.
		<?php endif;?>
		&nbsp;</td>
	</tr>
</table>
<br />
