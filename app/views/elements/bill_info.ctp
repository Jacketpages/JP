<table class="list">
	<tr>
		<td class="label">Title</td>
		<td><?php echo $bill['Bill']['title'];?>&nbsp;</td>
	</tr>
	<tr>
		<td class="label">Description</td>
		<td><?php echo nl2br($bill['Bill']['description']);?>&nbsp;</td>
	</tr>
	<tr>
		<td class="label">Number</td>
		<td><?php echo $bill['Bill']['number'];?>&nbsp;</td>
	</tr>
	<tr>
		<td class="label">Submit Date</td>
		<td><?php echo date('n/j/Y', strtotime($bill['Bill']['submit_date']));?>
		&nbsp;</td>
	</tr>
	<?php if ($bill['Bill']['type'] != 'Resolution') {
	?>
	<tr>
		<td class="label">Dues Collected</td>
		<td><?php echo $bill['Bill']['dues'];?>
		&nbsp;</td>
	</tr>
	<tr>
		<td class="label">Fundraising</td>
		<td><?php echo nl2br($bill['Bill']['fundraising']);?>
		&nbsp;</td>
	</tr>
	<?php }?>
</table>
<br/>
