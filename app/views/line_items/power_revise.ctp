<?php echo $this -> Html -> addCrumb('All Bills', '/power/bills');?>
<?php echo $this -> Html -> addCrumb('Bill', '/power/bills/view/' . $this -> data['LineItem']['bill_id']);?>
<?php echo $this -> Html -> addCrumb($this -> data['LineItem']['name'], '/power/line_items/view/' . $this -> data['LineItem']['parent_id']);?>
<div id="sidebars">
	<ul>
		<li>
			<?php echo $this -> Html -> link(__('View Bill', true), array(
					'controller' => 'bills',
					'action' => 'view',
					$this -> data['LineItem']['bill_id']
			));
			?>
		</li>
	</ul>
	<?php echo $this->element('sidebar')
	?>
</div>
<div id="middle">
	<h3>Revise Line Item</h3>
	<?php echo $this -> Form -> create('LineItem');?>
	<fieldset>
		<?php
			echo $this -> Form -> hidden('bill_id');
			echo $this -> Form -> hidden('parent_id');
			echo $this -> Form -> input('state', array(
					'label' => 'Revision',
					'options' => array(
							'JFC' => 'JFC',
							'Undergraduate' => 'Undergraduate',
							'Graduate' => 'Graduate',
							'Conference' => 'Conference',
							'Final' => 'Final'
					)
			));
			echo $this -> Form -> input('name', array('label' => 'Item Name'));
			echo $this -> Form -> input('account', array(
					'div' => 'account',
					'id' => 'account',
					'options' => array(
							'PY' => 'Prior Year',
							'CO' => 'Capital Outlay',
							'ULR' => 'Undergraduate Legislative Reserve',
							'GLR' => 'Graduate Legislative Reserve'
					)
			));
			echo $this -> Form -> input('costPerUnit', array(
					'div' => 'perUnit',
					'id' => 'perUnit'
			));
			echo $this -> Form -> input('quantity', array(
					'div' => 'quantity',
					'id' => 'quantity'
			));
			echo $this -> Form -> input('totalCost', array(
					'div' => 'totalCost',
					'id' => 'totalCost'
			));
			echo $this -> Form -> input('amount', array(
					'div' => 'amount',
					'id' => 'amount'
			));
		?>
	</fieldset>
	<?php echo $this -> Form -> end(__('Revise', true));?>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$(".quantity").change(updateCost);
		$(".perUnit").change(updateCost);
		$(".account").change(updateCost);
	});
	function updateCost() {
		var account = $("#account option:selected").val();
		var perUnit = $("#perUnit").val();
		var quantity = $("#quantity").val();
		var totalCost = perUnit * quantity;
		$("#totalCost").val(totalCost);
		if(account == "CO") {
			var co = Math.round(totalCost * (2 / 3) * 100) / 100;
			$("#amount").val(co);
		} else {
			$("#amount").val(totalCost);
		}
	}
</script>
