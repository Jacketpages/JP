<?php echo $this->Html->addCrumb('My Bills', '/owner/bills'); ?>
<?php echo $this->Html->addCrumb($budgetLineItem['Bill']['title'], '/owner/bills/view/'.$budgetLineItem['Bill']['id']); ?>
<div id="sidebars">
	<ul>
		<li><?php echo $this->Html->link(__('New Budget Line Item for Bill', true), array('action' => 'add', $budgetLineItem['BudgetLineItem']['bill_id'])); ?>
		</li>
	</ul>
	
	
	
	
	
	
	
	
	<?php echo $this->element('sidebar')?>
</div>
<div id="middle">
	<div class="budgetLineItems view">
		<h3>Budget Line Item</h3>
		<dl>
			
			
			
		<?php $i = 0; $class = ' class="altrow"';?>
			<dt    <?php if ($i % 2 == 0) echo $class;?>>



			<?php __('Bill'); ?></dt>
			<dd    <?php if ($i++ % 2 == 0) echo $class;?>>




			<?php echo $this->Html->link($budgetLineItem['Bill']['title'], array('controller' => 'bills', 'action' => 'view', $budgetLineItem['Bill']['id'])); ?>
				&nbsp;
			</dd>
			
			
			
			
			
			
			
			
		<?php 
		if($budgetLineItem['Parent2']['id'] != null):
		?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Parent2'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($budgetLineItem['Parent2']['name'], array('controller' => 'budget_line_items', 'action' => 'view', $budgetLineItem['Parent2']['id'])); ?>
			&nbsp;
		</dd>
		<?php endif; ?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('State'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $budgetLineItem['BudgetLineItem']['state']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $budgetLineItem['BudgetLineItem']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('CostPerUnit'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $budgetLineItem['BudgetLineItem']['costPerUnit']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Quantity'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $budgetLineItem['BudgetLineItem']['quantity']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('TotalCost'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $budgetLineItem['BudgetLineItem']['totalCost']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('AmountRequested'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $budgetLineItem['BudgetLineItem']['amount']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Section'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $budgetLineItem['BudgetLineItem']['section']; ?>
			&nbsp;
		</dd>
	</dl>
	</div>
	<div class="related">
		<h3>
			
			
			
		<?php __('Budget Items');?></h3>
		
		
		
		
		
		
		
		
	<?php if (!empty($budgetLineItem['Children2'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('State'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('CostPerUnit'); ?></th>
		<th><?php __('Quantity'); ?></th>
		<th><?php __('TotalCost'); ?></th>
		<th><?php __('AmountRequested'); ?></th>
		<th><?php __('Section'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($budgetLineItem['Children2'] as $children):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $children['state'];?></td>
			<td><?php echo $children['name'];?></td>
			<td><?php echo $children['costPerUnit'];?></td>
			<td><?php echo $children['quantity'];?></td>
			<td><?php echo $children['totalCost'];?></td>
			<td><?php echo $children['amount'];?></td>
			<td><?php echo $children['section'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'budget_line_items', 'action' => 'view', $children['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
</div>
</div>
