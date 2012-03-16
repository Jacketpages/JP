<?php $this->Html->addCrumb('Resolution Items', 'owner/resolution_items'); ?>
<div id="sidebars">
	<ul>
		<li><?php echo $this->Html->link(__('New Resolution Item for Bill', true), array('action' => 'add', $resolutionItem['ResolutionItem']['bill_id'])); ?>
		</li>
	</ul>
	
	
	
	
	
	
	
	
	<?php echo $this->element('sidebar')?>
</div>
<div id="middle">
	<div class="resolutionItems view">
		<h3>Resolution Item</h3>
		<dl>
			
			
			
		<?php $i = 0; $class = ' class="altrow"';?>
			<dt    <?php if ($i % 2 == 0) echo $class;?>>



			<?php __('Bill'); ?></dt>
			<dd    <?php if ($i++ % 2 == 0) echo $class;?>>




			<?php echo $this->Html->link($resolutionItem['Bill']['title'], array('controller' => 'bills', 'action' => 'view', $resolutionItem['Bill']['id'])); ?>
				&nbsp;
			</dd>
			
			
			
			
			
			
			
			
		<?php 
		if($resolutionItem['Parent']['id'] != null):
		?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Parent'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($resolutionItem['Parent']['name'], array('controller' => 'resolution_items', 'action' => 'view', $resolutionItem['Parent']['id'])); ?>
			&nbsp;
		</dd>
		<?php endif; ?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('State'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $resolutionItem['ResolutionItem']['state']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Content'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $resolutionItem['ResolutionItem']['content']; ?>
			&nbsp;
		</dd>
	</dl>
	</div>
	<div class="related">
		<h3>
			
			
			
		<?php __('Bill Resolution Items');?></h3>
		
		
		
		
		
		
		
		
	<?php if (!empty($resolutionItem['Children'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('State'); ?></th>
		<th><?php __('Content'); ?></th>
		<th><?php __('CostPerUnit'); ?></th>
		<th><?php __('Quantity'); ?></th>
		<th><?php __('TotalCost'); ?></th>
		<th><?php __('Amount'); ?></th>
		<th><?php __('Account'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($resolutionItem['Children'] as $children):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $children['state'];?></td>
			<td><?php echo $children['content'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'resolution_items', 'action' => 'view', $children['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
</div>
</div>
