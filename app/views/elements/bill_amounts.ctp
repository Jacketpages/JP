/**
 * Deprecated. All amounts calculations are now
 * handled within the "lineitems_related.ctp" page.
 */

<?php
$i = 0;
function amountPrinter($type, $prettyName, $bill)
{
	if(isset($bill['Bill'][$type]) && $bill['Bill'][$type] > 0)
	{
		?>
<td class="label"><?php echo $prettyName; ?></td>
<td>$<?php echo number_format($bill['Bill'][$type],2); ?> &nbsp;</td>


<?php
	}
}
?>

<?php 
if($bill['Bill']['type'] == 'Finance Request' || $bill['Bill']['type'] == 'Budget'):?>
<h3>Amounts</h3>


<?php if ($bill['Bill']['amount_submitted'] > 0 || $bill['Bill']['budget_submitted'] > 0):?>
<table class="list">




<?php
amountPrinter('amount_submitted', 'Submitted', $bill);
amountPrinter('amount_jfc', 'JFC', $bill);
amountPrinter('amount_undergraduate', 'Undergraduate', $bill);
amountPrinter('amount_graduate', 'Graduate', $bill);
amountPrinter('amount_conference', 'Conference', $bill);
amountPrinter('amount_final', 'Final', $bill);
amountPrinter('budget_submitted', 'Submitted', $bill);
amountPrinter('budget_jfc', 'JFC', $bill);
amountPrinter('budget_undergraduate', 'Undergraduate', $bill);
amountPrinter('budget_graduate', 'Graduate', $bill);
amountPrinter('budget_conference', 'Conference', $bill);
amountPrinter('budget_final', 'Final', $bill);
?>
</table>


<?php 
endif;
else: ?>
<table class="list">
	<tr>
		<td><em>No line items were submitted.</em></td>

</table>
<?php
endif;
?>