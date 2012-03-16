<?php echo $this->Html->addCrumb('My Bills', '/owner/bills'); ?>
<?php echo $this->Html->addCrumb('Bill', '/owner/bills/view/'.$this->data['Bill']['id']); ?>
<div id="sidebars">
	<ul>
		<li><?php echo $this->Html->link('Travel Calculator', array('owner' => false, 'action' =>'travel'), array('target' => 'blank'));?>
		</li>
		<li><?php echo $this->Html->link(__('List Bills', true), array('controller' => 'bills', 'action' => 'index')); ?>
		</li>
	</ul>
	
	
	
	
	
	
	
	
	<?php echo $this->element('sidebar')?>
</div>
<div id="middle">
	<h3>
		Add Line Item to Budget:
		<?php echo $bill['Bill']['title']; ?>
	</h3>
	
	
	
	
	
	
	
	
<?php echo $this->Form->create('BudgetLineItem');?>
	<fieldset>
	<?php
		echo $this->Form->hidden('bill_id', array('label' => 'Bill', 'value' => $bill['Bill']['id']));
		echo $this->Form->hidden('parent_id', array('value' => '', 'label' => 'Parent Line Item'));
		echo $this->Form->hidden('state', array('value' => 'submitted', 'options' => array('submitted' => 'Submitted', 'jfc' => 'JFC', 'Undergraduate' => 'Undergraduate', 'Graduate' => 'Graduate', 'conference' => 'Conference', 'final' => 'Final')));
		echo $this->Form->input('name', array('label' => 'Item Name'));
		echo $this->Form->input('section', array('div' => 'section', 'id' => 'section', 'options' => array('ose' => 'OS&E', 'event' => 'Event/Activity', 'personnel' => 'Personnel', 'conference' => 'Conferences/Competitions')));
		echo "\n";
		echo $this->Form->input('costPerUnit', array('div' => 'perUnit', 'id' => 'perUnit'));
		echo "\n";
		echo $this->Form->input('quantity', array('div' => 'quantity', 'id' => 'quantity'));
		echo "\n";
		echo $this->Form->input('totalCost', array('div' => 'totalCost', 'id' => 'totalCost'));
		echo "\n";
		echo $this->Form->input('amount', array('label' => 'Amount Requested', 'div' => 'amount', 'id' => 'amount'));
		echo "\n";
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<script type="text/javascript">
$(document).ready(function() {
	$(".quantity").change(updateCost);
	$(".perUnit").change(updateCost);
});
function updateCost(){
	var perUnit = $("#perUnit").val();
	var quantity = $("#quantity").val();
	var totalCost = perUnit * quantity;
	$("#totalCost").val(totalCost);
	$("#amount").val(totalCost);
}
</script>
