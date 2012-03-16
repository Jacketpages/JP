<?php if ($bill ['Bill'] ['status'] == 'Passed'):?>
<h3>Signatures</h3>
<table class='list'>
	<tr>
		<td class="label">Graduate President</td>
		<td><?php echo $bill['Bill']['grad_pres_sign'];?></td>
	</tr>
	<tr>
		<td class="label">Graduate Secretary</td>
		<td><?php echo $bill['Bill']['grad_secr_sign'];?></td>
	</tr>
	<tr>
		<td class="label">Undergraduate President</td>
		<td><?php echo $bill['Bill']['ungr_pres_sign'];?></td>
	</tr>
	<tr>
		<td class="label">Undergraduate Secretary</td>
		<td><?php echo $bill['Bill']['ungr_secr_sign'];?></td>
	</tr>
	<tr>
		<td class="label">Vice President of Finance</td>
		<td><?php echo $bill['Bill']['vp_fina_sign'];?></td>
	</tr>
</table>
<?php endif;?>
