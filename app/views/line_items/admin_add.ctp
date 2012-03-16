<?php echo $this -> Html -> addCrumb('All Bills', '/power/bills');?>
<?php echo $this -> Html -> addCrumb('Bill', '/power/bills/view/' . $bill['Bill']['id']);?>
<div id="sidebars" class="action">
	<ul>
		<li>
			<?php echo $this -> Html -> link('Travel Calculator', array(
					'owner' => false,
					'action' => 'travel'
			), array('target' => 'blank'));
			?>
		</li>
		<li>
			<?php echo $this -> Html -> link(__('All Bills', true), array(
					'controller' => 'bills',
					'action' => 'index'
			));
			?>
		</li>
	</ul>
	<?php echo $this->element('sidebar')
	?>
</div>
<div id="middle">
	<div class="post lineItems form type-post">
		<h3> Add Line Item to Bill: <?php echo $bill['Bill']['title'];?></h3>
		<?php echo $this -> Form -> create('LineItem');
		debug($this->data);?>
		<fieldset>
			<?php
				echo $this -> Form -> hidden('bill_id', array(
						'label' => 'Bill',
						'value' => $bill['Bill']['id']
				));
				echo $this -> Form -> hidden('parent_id', array(
						'value' => '',
						'label' => 'Parent Line Item'
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
				echo $this -> Form -> input('state', array(
						'value' => 'Submitted',
						'options' => array(
								'Submitted' => 'Submitted',
								'JFC' => 'JFC',
								'Undergraduate' => 'Undergraduate',
								'Graduate' => 'Graduate',
								'Conference' => 'Conference',
								'Final' => 'Final'
						)
				));
				echo "\n";
				echo $this -> Form -> input('costPerUnit', array(
						'div' => 'perUnit',
						'id' => 'perUnit'
				));
				echo "\n";
				echo $this -> Form -> input('quantity', array(
						'div' => 'quantity',
						'id' => 'quantity'
				));
				echo "\n";
				echo $this -> Form -> input('totalCost', array(
						'readonly' => 'readonly',
						'div' => 'totalCost',
						'id' => 'totalCost'
				));
				echo "\n";
				if ($bill['Bill']['type'] != 'Resolution')
				{
					echo $this -> Form -> input('amount', array(
							'label' => 'Amount Requested',
							'div' => 'amount',
							'id' => 'amount'
					));
					echo "\n";
				}
			?>
		</fieldset>
		<?php echo $this -> Form -> end(__('Submit', true));?>
		Additional line items can be added by choosing "Add Line Item" after submitting.
	</div>
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
