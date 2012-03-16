<?php $this->Html->addCrumb('Memberships', '/officer/memberships'); ?>
<div id="sidebars">




<?php echo $this->element('sidebar')?>
</div>
<div id="middle">
	<h3>Positions</h3>
	<table cellpadding="0" cellspacing="0">
		<tr>
			<th width="50%"><?php echo $this->Paginator->sort('organization_id');?>
			</th>
			<th width="35%"><?php echo $this->Paginator->sort('role');?></th>
			<th width="15%"></th>
		</tr>
		
		
		
		
		
		
		
		
	<?php
	$i = 0;
	foreach ($memberships as $membership):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td width="50%">
			<?php echo $this->Html->link($membership['User']['name'], array('controller' => 'users', 'action' => 'view', $membership['User']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($membership['Organization']['name'], array('controller' => 'organizations', 'action' => 'view', $membership['Organization']['id'])); ?>
		</td>
		<td width="35%"><?php echo $membership['Membership']['role']; ?></td>
		<td width="15%">
			<?php echo $this->Html->link(__('Resign', true), array('action' => 'delete', $membership['Membership']['id']), null, sprintf(__('Are you sure you want to resign?', true))); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<div class="paging">




	<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
		|
		<?php echo $this->Paginator->numbers();?>
		|
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
		<br> <br>
		
		
		
		
		
		
		
		
		<?php
		echo $this->Paginator->counter(array('format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)));
		?>
		
	</div>
</div>
