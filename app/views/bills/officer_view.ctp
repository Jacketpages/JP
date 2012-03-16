<?php echo $this -> Html -> addCrumb('All Bills', '/bills');?>
<div id="sidebars" class="action">
	<?php echo $this->element('sidebar')
	?>
</div>
<div id="middle">
	<div class="bills view">
		<h3>Bill</h3>
		<?php echo $this -> element('bill_info', array('bill' => $bill));?>
		<?php echo $this -> element('bill_status', array('bill' => $bill));?>
		<?php echo $this -> element('bill_authors', array('bill' => $bill));?>
	</div>
	<div class="related">
		<?php echo $this -> element('lineitems_related', array('bill' => $bill));?>

		<?php echo $this -> element('budgetlineitems_related', array('bill' => $bill));?>

		<?php echo $this -> element('resolutionitems_related', array('bill' => $bill));?>
	</div>
</div>
