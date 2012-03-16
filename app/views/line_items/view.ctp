<?php echo $this->Html->addCrumb('All Bills', '/bills'); ?>
<?php echo $this->Html->addCrumb($lineItem['Bill']['title'], '/bills/view/'.$lineItem['Bill']['id']); ?>
<div id="sidebars">
	<ul>
		<li><?php echo $this->Html->link(__('Delete Line Item', true), array('action' => 'delete', $lineItem['LineItem']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $lineItem['LineItem']['id'])); ?>
		</li>
	</ul>
	
	
	
	
	
	
	
	
	<?php echo $this->element('sidebar')?>
</div>
<div id="middle">
	<div class="lineItems view">
		<h3>Line Item</h3>
		<dl>
			
			
			
		<?php $i = 0; $class = ' class="altrow"';?>
			<dt    <?php if ($i % 2 == 0) echo $class;?>>



			<?php __('Id'); ?></dt>
			<dd    <?php if ($i++ % 2 == 0) echo $class;?>>




			<?php echo $lineItem['LineItem']['id']; ?>
				&nbsp;
			</dd>
			<dt    <?php if ($i % 2 == 0) echo $class;?>>



			<?php __('Bill'); ?></dt>
			<dd    <?php if ($i++ % 2 == 0) echo $class;?>>




			<?php echo $this->Html->link($lineItem['Bill']['title'], array('controller' => 'bills', 'action' => 'view', $lineItem['Bill']['id'])); ?>
				&nbsp;
			</dd>
			<dt    <?php if ($i % 2 == 0) echo $class;?>>



			<?php __('Parent'); ?></dt>
			<dd    <?php if ($i++ % 2 == 0) echo $class;?>>




			<?php echo $this->Html->link($lineItem['Parent']['name'], array('controller' => 'line_items', 'action' => 'view', $lineItem['Parent']['id'])); ?>
				&nbsp;
			</dd>
			<dt    <?php if ($i % 2 == 0) echo $class;?>>



			<?php __('State'); ?></dt>
			<dd    <?php if ($i++ % 2 == 0) echo $class;?>>




			<?php echo $lineItem['LineItem']['state']; ?>
				&nbsp;
			</dd>
			<dt    <?php if ($i % 2 == 0) echo $class;?>>



			<?php __('Name'); ?></dt>
			<dd    <?php if ($i++ % 2 == 0) echo $class;?>>




			<?php echo $lineItem['LineItem']['name']; ?>
				&nbsp;
			</dd>
			<dt    <?php if ($i % 2 == 0) echo $class;?>>



			<?php __('CostPerUnit'); ?></dt>
			<dd    <?php if ($i++ % 2 == 0) echo $class;?>>




			<?php echo $lineItem['LineItem']['costPerUnit']; ?>
				&nbsp;
			</dd>
			<dt    <?php if ($i % 2 == 0) echo $class;?>>



			<?php __('Quantity'); ?></dt>
			<dd    <?php if ($i++ % 2 == 0) echo $class;?>>




			<?php echo $lineItem['LineItem']['quantity']; ?>
				&nbsp;
			</dd>
			<dt    <?php if ($i % 2 == 0) echo $class;?>>



			<?php __('TotalCost'); ?></dt>
			<dd    <?php if ($i++ % 2 == 0) echo $class;?>>




			<?php echo $lineItem['LineItem']['totalCost']; ?>
				&nbsp;
			</dd>
			<dt    <?php if ($i % 2 == 0) echo $class;?>>



			<?php __('Amount'); ?></dt>
			<dd    <?php if ($i++ % 2 == 0) echo $class;?>>




			<?php echo $lineItem['LineItem']['amount']; ?>
				&nbsp;
			</dd>
			<dt    <?php if ($i % 2 == 0) echo $class;?>>



			<?php __('Account'); ?></dt>
			<dd    <?php if ($i++ % 2 == 0) echo $class;?>>




			<?php echo $lineItem['LineItem']['account']; ?>
				&nbsp;
			</dd>
		</dl>
	</div>
	<div class="related">
		<h3>
			
			
			
		<?php __('Related Line Items');?></h3>
		
		
		
		
		
		
		
		
	<?php if (!empty($lineItem['Children'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('BillId'); ?></th>
		<th><?php __('ParentId'); ?></th>
		<th><?php __('State'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('CostPerUnit'); ?></th>
		<th><?php __('Quantity'); ?></th>
		<th><?php __('TotalCost'); ?></th>
		<th><?php __('Amount'); ?></th>
		<th><?php __('Account'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($lineItem['Children'] as $children):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $children['id'];?></td>
			<td><?php echo $children['bill_id'];?></td>
			<td><?php echo $children['parent_id'];?></td>
			<td><?php echo $children['state'];?></td>
			<td><?php echo $children['name'];?></td>
			<td><?php echo $children['costPerUnit'];?></td>
			<td><?php echo $children['quantity'];?></td>
			<td><?php echo $children['totalCost'];?></td>
			<td><?php echo $children['amount'];?></td>
			<td><?php echo $children['account'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'line_items', 'action' => 'view', $children['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'line_items', 'action' => 'edit', $children['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'line_items', 'action' => 'delete', $children['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $children['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
</div>
</div>
