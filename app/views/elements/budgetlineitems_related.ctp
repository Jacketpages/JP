<?php if(!empty($bill['BudgetLineItem'])):?>
<div class="related">
	<h3>Budget Items</h3>
	<table cellpadding="0" cellspacing="0">
		<tr>
			<th>State</th>
			<th>Name</th>
			<th><?php __('Cost Per Unit'); ?></th>
			<th><?php __('Quantity'); ?></th>
			<th><?php __('Total Cost'); ?></th>
			<th><?php __('Amount'); ?></th>
			<th><?php __('Section'); ?></th>
			<th class="actions">Actions</th>
		</tr>
		
		
		
		
		
		
		
		
	<?php
		$i = 0;
		foreach ($bill['BudgetLineItem'] as $lineItem):
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr>
			<td><?php echo $lineItem['state'];?></td>
			<td><?php echo $lineItem['name'];?></td>
			<td><?php echo $lineItem['costPerUnit'];?></td>
			<td><?php echo $lineItem['quantity'];?></td>
			<td><?php echo $lineItem['totalCost'];?></td>
			<td><?php echo $lineItem['amount'];?></td>
			<td><?php echo $lineItem['section'];?></td>
			<td class="actions">
				<?php echo $this->Html->link('View', array('controller' => 'budget_line_items', 'action' => 'view', $lineItem['id'])); ?>
				<?php 
				if($this->isLevel('power')){
					echo $this->Html->link(__('Revise', true), array('power' => true, 'controller' => 'budget_line_items', 'action' => 'revise', $lineItem['id']));
					echo $this->Html->link(__('Edit', true), array('power' =>  true, 'controller' => 'budget_line_items', 'action' => 'edit', $lineItem['id']));
				}
				if($this->isLevel('admin'))
					echo $this->Html->link(__('Delete', true), array('admin' => true, 'controller' => 'budget_line_items', 'action' => 'delete', $lineItem['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $lineItem['id']));
				?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
	
	
	
	
	
	
	
	
<?php endif; ?>
</div>
