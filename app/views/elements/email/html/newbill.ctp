A new bill was created with you as an author.
<table>
	<tr>
		<td>Title: <?php echo $bill['Bill']['title']; ?></td>
	</tr>
	<tr>
		<td>Description</td>
	</tr>
	<tr>
		<td><?php echo $bill['Bill']['description']; ?></td>
	</tr>

	<tr>
		<td>Dues Collected</td>
		<td><?php echo $bill['Bill']['dues']; ?></td>
	</tr>

	<tr>
		<td>Fundraising</td>
	</tr>
	<tr>




	<?php echo $bill['Bill']['fundraising']; ?>
	</tr>
	
	
	
	
	
	
	
	
<?php if(isset($bill['UndergradAuthor']['User']['name'])):?>
	<tr>
		<td>Undergraduate Author</td>
		<td><?php echo $bill['UndergradAuthor']['User']['name']; ?></td>
	</tr>
<?php endif;
if(isset($bill['GraduateAuthor']['User']['name'])):?>
	<tr>
		<td>Graduate Author</td>
		<td><?php echo $bill['GraduateAuthor']['User']['name']; ?></td>
	</tr>
<?php endif;?>
	<tr>
		<td>Submitter</td>
		<td><?php echo $bill['Submitter']['name']; ?></td>
	</tr>
<?php if(isset($bill['Organization']['name'])): ?>
	<tr>
		<td>Organization</td>
		<td><?php echo $bill['Organization']['name']; ?></td>
	</tr>
<?php endif;?>
</table>

