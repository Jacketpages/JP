<?php $this->Html->addCrumb('Resolution Items', 'users/resolution_items'); ?>
<div id="sidebars">
	<ul>
		<li><?php echo $this->Html->link(__('Edit Resolution Item', true), array('action' => 'edit', $resolutionItem['ResolutionItem']['id'])); ?>
		</li>
		<li><?php echo $this->Html->link(__('Delete Resolution Item', true), array('action' => 'delete', $resolutionItem['ResolutionItem']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $resolutionItem['ResolutionItem']['id'])); ?>
		</li>
		<li><?php echo $this->Html->link(__('List Resolution Items', true), array('action' => 'index')); ?>
		</li>
		<li><?php echo $this->Html->link(__('New Resolution Item', true), array('action' => 'add')); ?>
		</li>
		<li><?php echo $this->Html->link(__('List Line Items', true), array('controller' => 'line_items', 'action' => 'index')); ?>
		</li>
		<li><?php echo $this->Html->link(__('New Parent', true), array('controller' => 'resolution_items', 'action' => 'add')); ?>
		</li>
		<li><?php echo $this->Html->link(__('List Bills', true), array('controller' => 'bills', 'action' => 'index')); ?>
		</li>
		<li><?php echo $this->Html->link(__('New Bill', true), array('controller' => 'bills', 'action' => 'add')); ?>
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



			<?php __('Id'); ?></dt>
			<dd    <?php if ($i++ % 2 == 0) echo $class;?>>




			<?php echo $resolutionItem['ResolutionItem']['id']; ?>
				&nbsp;
			</dd>
			<dt    <?php if ($i % 2 == 0) echo $class;?>>



			<?php __('Bill'); ?></dt>
			<dd    <?php if ($i++ % 2 == 0) echo $class;?>>




			<?php echo $this->Html->link($resolutionItem['Bill']['title'], array('controller' => 'bills', 'action' => 'view', $resolutionItem['Bill']['id'])); ?>
				&nbsp;
			</dd>
			<dt    <?php if ($i % 2 == 0) echo $class;?>>



			<?php __('Parent'); ?></dt>
			<dd    <?php if ($i++ % 2 == 0) echo $class;?>>




			<?php echo $this->Html->link($resolutionItem['Parent']['name'], array('controller' => 'resolution_items', 'action' => 'view', $resolutionItem['Parent']['id'])); ?>
				&nbsp;
			</dd>
			<dt    <?php if ($i % 2 == 0) echo $class;?>>



			<?php __('State'); ?></dt>
			<dd    <?php if ($i++ % 2 == 0) echo $class;?>>




			<?php echo $resolutionItem['ResolutionItem']['state']; ?>
				&nbsp;
			</dd>
			<dt    <?php if ($i % 2 == 0) echo $class;?>>



			<?php __('Content'); ?></dt>
			<dd    <?php if ($i++ % 2 == 0) echo $class;?>>




			<?php echo $resolutionItem['ResolutionItem']['content']; ?>
				&nbsp;
			</dd>
		</dl>
	</div>
	<div class="related">
		<h3>
			
			
			
		<?php __('Related Resolution Items');?></h3>
		
		
		
		
		
		
		
		
	<?php if (!empty($resolutionItem['Children'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('BillId'); ?></th>
		<th><?php __('ParentId'); ?></th>
		<th><?php __('State'); ?></th>
		<th><?php __('Content'); ?></th>
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
			<td><?php echo $children['id'];?></td>
			<td><?php echo $children['bill_id'];?></td>
			<td><?php echo $children['parent_id'];?></td>
			<td><?php echo $children['state'];?></td>
			<td><?php echo $children['content'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'resolution_items', 'action' => 'view', $children['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'resolution_items', 'action' => 'edit', $children['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'resolution_items', 'action' => 'delete', $children['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $children['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link('New Children', array('controller' => 'resolution_items', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
</div>
