<div id="desc">
	<div id="descLeft">
		<h3>
			
		<?php echo $user['User']['name']; ?></h3>
		<table cellpadding="0" cellspacing="0">
			<tr>
				<td width="40%">GT Username</td>
				<td width="60%">
				<?php echo $user['User']['gtUsername']; ?> &nbsp;</td>
			</tr>
			<tr>
				<td width="40%"><?php __('Email'); ?></td>
				<td width="60%">
				<?php echo $user['User']['email']; ?> &nbsp;</td>
			</tr>
			<tr>
				<td width="40%"><?php __('Phone'); ?></td>
				<td width="60%">
				<?php echo $user['User']['phone']; ?> &nbsp;</td>
			</tr>
			
			
			
			
			<?php 
			if($user['SgaPerson']['house'] == 'Undergraduate') { ?>
				<tr>
				<td width="40%">SGA House</td>
				<td width="60%">
				<?php echo 'Undergraduate';?></td></tr>
			<?php } elseif($user['SgaPerson']['house'] == 'Graduate') { ?>
				<tr>
				<td width="40%">SGA House</td>
				<td width="60%">
				<?php echo 'Graduate';?></td></tr>
			<?php } ?>
		</table>
	</div>
</div>
