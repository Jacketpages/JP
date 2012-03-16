<?php $this->Html->addCrumb('Memberships', '/memberships'); ?>
<div id="sidebars">
	<ul>
		<li><?php echo $this->Html->link(__('Edit Membership', true), array('action' => 'edit', $membership['Membership']['id'])); ?>
		</li>
		<li><?php echo $this->Html->link(__('Delete Membership', true), array('action' => 'delete', $membership['Membership']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $membership['Membership']['id'])); ?>
		</li>
		<li><?php echo $this->Html->link(__('List Memberships', true), array('action' => 'index')); ?>
		</li>
		<li><?php echo $this->Html->link(__('New Membership', true), array('action' => 'add')); ?>
		</li>
	</ul>
	
	
	
	
	
	
	
	
	<?php echo $this->element('sidebar')?>
</div>
<div id="middle">
	<h3>Membership</h3>
	<dl>



	<?php $i = 0; $class = ' class="altrow"';?>
		<dt    <?php if ($i % 2 == 0) echo $class;?>>
			
			
			
		<?php __('User'); ?></dt>
		<dd    <?php if ($i++ % 2 == 0) echo $class;?>>
			
			
			
			
		<?php echo $this->Html->link($membership['User']['name'], array('controller' => 'users', 'action' => 'view', $membership['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt    <?php if ($i % 2 == 0) echo $class;?>>
			
			
			
		<?php __('Organization'); ?></dt>
		<dd    <?php if ($i++ % 2 == 0) echo $class;?>>
			
			
			
			
		<?php echo $this->Html->link($membership['Organization']['name'], array('controller' => 'organizations', 'action' => 'view', $membership['Organization']['id'])); ?>
			&nbsp;
		</dd>
		<dt    <?php if ($i % 2 == 0) echo $class;?>>
			
			
			
		<?php __('Role'); ?></dt>
		<dd    <?php if ($i++ % 2 == 0) echo $class;?>>
			
			
			
			
		<?php echo $membership['Membership']['role']; ?>
			&nbsp;
		</dd>
		<dt    <?php if ($i % 2 == 0) echo $class;?>>
			
			
			
		<?php __('Title'); ?></dt>
		<dd    <?php if ($i++ % 2 == 0) echo $class;?>>
			
			
			
			
		<?php echo $membership['Membership']['title']; ?>
			&nbsp;
		</dd>
		<dt    <?php if ($i % 2 == 0) echo $class;?>>
			
			
			
		<?php __('Dues Last Paid'); ?></dt>
		<dd    <?php if ($i++ % 2 == 0) echo $class;?>>
			
			
			
			
		<?php echo $membership['Membership']['duesPaid']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
