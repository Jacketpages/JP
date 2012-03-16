<h3>Bills</h3>
<?php
$i = 0;
foreach ($set['Bill'] as $bill):
if ($bill['type'] != 'Budget')
$i++;
endforeach;
if ($i != 0) {
?>
<table cellpadding="0" cellspacing="0">
	<tr>
		<th width="40%"><?php __('Title');?></th>
		<th width="20%"><?php __('Status');?></th>
		<th width="20%"><?php __('Submitted');?></th>
		<th width="20%"><?php __('Number');?></th>
	</tr>
	<?php
$i = 0;
foreach ($set['Bill'] as $bill):
if($bill['type'] == 'Budget')
continue;
$class = null;
if ($i++ % 2 == 0) {
$class = ' class="altrow"';
}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $this -> Html -> link(__($bill['title'], true), array('controller' => 'bills', 'action' => 'view', $bill['id']));?></td>
		<td><?php echo $bill['status'];?></td>
		<td><?php echo $bill['submit_date'];?></td>
		<td><?php echo $this -> Html -> link(__($bill['number'], true), array('controller' => 'bills', 'action' => 'view', $bill['id']));?></td>
		</tr> <?php endforeach;?>
</table>
<?php } else {?>
<h4>No bills submitted.</h4>
<?php }?>