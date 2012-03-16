<h3>Status</h3>
<table class="list">
	<tr>
		<td class="label">Type</td>
		<td><?php
			echo $bill['Bill']['type'];
		?></td>
	</tr>
	<tr>
		<td class="label">Category</td>
		<td><?php
			switch($bill['Bill']['category'])
			{
				case 'Joint' :
					echo "Joint";
					break;
				case 'Graduate' :
					echo "Graduate Senate";
					break;
				case 'Undergraduate' :
					echo "Undergraduate House of Representatives";
					break;
			}
		?></td>
	</tr>
	<tr>
		<td class="label">Status</td>
		<td><?php
			if ($bill['Bill']['status'] == "Agenda")
			{
				echo "On Agenda";
			}
			else
			{
				echo $bill['Bill']['status'];
			}
		?></td>
	</tr>
</table>
<?php
	function notUnderGrad($bill_alias)
	{
		if ($bill_alias['Bill']['category'] != 'Undergraduate' && ($bill_alias['Bill']['status'] == 'Passed' || $bill_alias['Bill']['status'] == 'Failed'))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function notGrad($bill_alias)
	{
		if ($bill_alias['Bill']['category'] != 'Graduate' && ($bill_alias['Bill']['status'] == 'Passed' || $bill_alias['Bill']['status'] == 'Failed'))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
?>

<?php if (notUnderGrad($bill) || notGrad($bill)):
?>
<table class="list">
	<tr>
		<?php if (notUnderGrad($bill)):
		?>
		<td class="label">GSS Outcome:</td><td></td>
		<?php endif;?>
		<?php if (notGrad($bill)):
		?>
		<td class="label">UHR Outcome:</td><td></td>
		<?php endif;?>
	</tr>
	<tr>
		<?php if (notUnderGrad($bill)):
		?>
		<td>Date</td><td><?php echo $bill['Bill']['gss_date'];?></td>
		<?php endif;?>
		<?php if (notGrad($bill)):
		?>
		<td>Date</td><td><?php echo $bill['Bill']['uhr_date'];?></td>
		<?php endif;?>
	</tr>
	<tr>
		<?php if (notUnderGrad($bill)):
		?>
		<td>Yeas</td><td><?php echo $bill['Bill']['gss_yeas'];?></td>
		<?php endif;?>
		<?php if (notGrad($bill)):
		?>
		<td>Yeas</td><td><?php echo $bill['Bill']['uhr_yeas'];?></td>
		<?php endif;?>
	</tr>
	<tr>
		<?php if (notUnderGrad($bill)):
		?>
		<td>Nays</td><td><?php echo $bill['Bill']['gss_nays'];?></td>
		<?php endif;?>
		<?php if (notGrad($bill)):
		?>
		<td>Nays</td><td><?php echo $bill['Bill']['uhr_nays'];?></td>
		<?php endif;?>
	</tr>
	<tr>
		<?php if (notUnderGrad($bill)):
		?>
		<td>Abstains</td><td><?php echo $bill['Bill']['gss_abst'];?></td>
		<?php endif;?>
		<?php if (notGrad($bill)):
		?>
		<td>Abstains</td><td><?php echo $bill['Bill']['uhr_abst'];?></td>
		<?php endif;?>
	</tr>
	<tr>
		<?php
if ($bill['Bill']['type'] != 'Resolution'):
if (notUnderGrad($bill)):
		?>
		<td>Prior Year Approved</td><td>$<?php echo number_format($bill['Bill']['amount_graduate_py'], 2);?></td>
		<?php endif;?>
		<?php if (notGrad($bill)):
		?>
		<td>Prior Year Approved</td><td>$<?php echo number_format($bill['Bill']['amount_undergraduate_py'], 2);?></td>
		<?php endif;?>
	</tr>
	<tr>
		<?php if (notUnderGrad($bill)):
		?>
		<td>Capital Outlay Approved</td><td>$<?php echo number_format($bill['Bill']['amount_graduate_co'], 2);?></td>
		<?php endif;?>
		<?php if (notGrad($bill)):
		?>
		<td>Capital Outlay Approved</td><td>$<?php echo number_format($bill['Bill']['amount_undergraduate_co'], 2);?></td>
		<?php endif;?>
	</tr>
	<tr>
		<?php if (notUnderGrad($bill)):
		?>
		<td>GLR Approved</td><td>$<?php echo number_format($bill['Bill']['amount_graduate_glr'], 2);?></td>
		<?php endif;?>
		<?php if (notGrad($bill)):
		?>
		<td>ULR Approved</td><td>$<?php echo number_format($bill['Bill']['amount_undergraduate_ulr'], 2);?></td>
		<?php
			endif;
			endif;
		?>
	</tr>
</table>
<?php endif;
	if ($bill['Bill']['category'] == 'Conference' && ($bill['Bill']['status'] == 'Passed' || $bill['Bill']['status'] == 'Failed')):
?>

<table class="list">
	<tr>
		<td class="label">GSS Conference Outcome:</td><td></td><td class="label">UHR Conference Outcome:</td><td></td>
	</tr>
	<tr>
		<td>Date</td><td><?php echo $bill['Bill']['cc_date'];?></td><td></td><td></td>
	</tr>
	<tr>
		<td>Yeas</td><td><?php echo $bill['Bill']['gcc_yeas'];?></td><td>Yeas</td><td><?php echo $bill['Bill']['ucc_yeas'];?></td>
	</tr>
	<tr>
		<td>Nays</td><td><?php echo $bill['Bill']['gcc_nays'];?></td><td>Nays</td><td><?php echo $bill['Bill']['ucc_nays'];?></td>
	</tr>
	<tr>
		<td>Abstains</td><td><?php echo $bill['Bill']['gcc_abst'];?></td><td>Abstains</td><td><?php echo $bill['Bill']['ucc_abst'];?></td>
	</tr>
	<tr>
		<td>Prior Year Approved</td><td>$<?php echo number_format($bill['Bill']['amount_conference_py'], 2);?></td><td></td><td></td>
	</tr>
	<tr>
		<td>Captial Outlay Approved</td><td>$<?php echo number_format($bill['Bill']['amount_conference_co'], 2);?></td><td></td><td></td>
	</tr>
	<tr>
		<td>GLR Approved</td><td>$<?php echo number_format($bill['Bill']['amount_conference_glr'], 2);?></td><td></td><td></td>
	</tr>
	<tr>
		<td>ULR Approved</td><td>$<?php echo number_format($bill['Bill']['amount_conference_ulr'], 2);?></td><td></td><td></td>
	</tr>
</table>
<?php endif;?>
<br />
