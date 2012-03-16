<?php echo $this -> Html -> addCrumb('All Bills', '/bills');?>
<?php echo $this -> Html -> addCrumb('My Bills', '/owner/bills');?>
<div id="sidebars" class="action">
	<ul>
		<?php
if($bill['Bill']['status'] != 'Agenda'):
if($bill['Bill']['type'] == 'Finance Request'):
		?>
		<li>
			<?php echo $this->Html->link('Add Line Item', array('controller' => 'line_items', 'action' => 'add', $bill['Bill']['id']))
			?>
		</li>
		<?php
			endif;
		?>
		<li>
			<?php echo $this -> Html -> link(__('Delete Bill', true), array(
					'action' => 'delete',
					$bill['Bill']['id']
			), null, sprintf(__('Are you sure you want to delete this bill?', true)));
			?>
		</li>
		<li>
			<?php echo $this -> Html -> link(__('My Bills', true), array('action' => 'index'));?>
		</li>
		<?php endif;?>
	</ul>
	<?php echo $this->element('sidebar')
	?>
</div>
<div id="middle">
	<div class="bills view">
		<h3>Bill</h3>
		<?php echo $this->element('bill_info', array('bill' => $bill))
		?>
		<?php echo $this->element('bill_status', array('bill' => $bill))
		?>
		<?php echo $this->element('bill_authors', array('bill' => $bill))
		?>
	</div>
	<div class="related">
		<?php echo $this->element('lineitems_related', array('bill' => $bill))
		?>

		<?php echo $this->element('budgetlineitems_related', array('bill' => $bill))
		?>

		<?php echo $this->element('resolutionitems_related', array('bill' => $bill))
		?>
	</div>
</div>