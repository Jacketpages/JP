<?php if (!empty($bill['ResolutionItem'])): ?>
<div class="related">

	<h3>Related Resolution Items</h3>
	<table cellpadding="0" cellspacing="0">
		<tr>
			<th><?php __('Id'); ?></th>
			<th><?php __('BillId'); ?></th>
			<th><?php __('Content'); ?></th>
			<th class="actions"><?php __('Actions');?></th>
		</tr>
		
		
		
		
		
		
		
		
	<?php
		$i = 0;
		foreach ($bill['ResolutionItem'] as $resolutionItem):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $resolutionItem['id'];?></td>
			<td><?php echo $resolutionItem['bill_id'];?></td>
			<td><?php echo $resolutionItem['content'];?></td>
			<td class="actions">
				<?php echo $this->Html->link('View', array('controller' => 'resolution_items', 'action' => 'view', $lineItem['id'])); ?>
				<?php 
				if($this->isLevel('power')){
					echo $this->Html->link(__('Revise', true), array('power' => true, 'controller' => 'resolution_items', 'action' => 'revise', $lineItem['id']));
					echo $this->Html->link(__('Edit', true), array('power' => true, 'controller' => 'resolution_items', 'action' => 'edit', $lineItem['id']));
				}
				if($this->isLevel('admin'))
					echo $this->Html->link(__('Delete', true), array('admin' => true, 'controller' => 'resolution_items', 'action' => 'delete', $lineItem['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $lineItem['id']));
				?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
</div>


<?php endif; ?>
