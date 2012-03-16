<?php echo $this -> Html -> addCrumb('All Bills', '/power/bills');?>
<?php
	if ($permitted)
	{
		echo $this -> Html -> addCrumb('My Bills', '/owner/bills');
	}
?>
<div id="sidebars" class="action">
	<ul>
		<li>
			<?php echo $this -> Html -> link('Update Bill', array(
					'action' => 'edit',
					$bill['Bill']['id']
			));
			?>
		</li>
		<?php
if($permitted && $bill['Bill']['status'] == 'Awaiting Author'):
if($bill['Bill']['type'] == 'Finance Request'):
		?>
		<li>
			<?php echo $this->Html->link('Add Line Item', array('controller' => 'line_items', 'action' => 'add', $bill['Bill']['id']))
			?>
		</li>
		<?php
			endif;
			endif;
		?>
		<li>
			<?php echo $this -> Html -> link(__('Delete Bill', true), array(
					'action' => 'delete',
					$bill['Bill']['id']
			), null, sprintf(__('Are you sure you want to delete this bill?', true)));
			?>
		</li>
		<?php
			if ($permitted)
			{
				echo('<li>' . $this -> Html -> link(__('All Bills', true), '/admin/bills') . '</li>');
				echo('<li>' . $this -> Html -> link(__('My Bills', true), '/owner/bills') . '</li>');
			}
			else
			{
				echo('<li>' . $this -> Html -> link(__('All Bills', true), '/admin/bills') . '</li>');
			}
		?>
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

		<?php echo $this->element('resolutionitems_related', array('bill' => $bill))
		?>

		<?php echo $this->element('budgetlineitems_related', array('bill' => $bill))
		?>
	</div>
</div>
