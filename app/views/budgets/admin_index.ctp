<?php echo $this->Html->addCrumb('Budgets', '/admin/budgets/index/'); ?>
<div id="sidebars">
	<ul>
		<li>
		<?php echo $this->Html->link('View Archives', '/admin/budgets/index/archives')?>
		</li>
		<li>
		<?php echo $this->Html->link('View Current', '/admin/budgets/index/')?>
		</li>
	</ul>
	
	
	
	
	
	
	
	
	<?php echo $this->element('sidebar')?>
</div>
<div id="middle">




<?php if ($archives == '0') {?>
	<h3>Current Budgets</h3>
	
	
	
	
	
	
	
	
	<?php } else {?>
	<h3>Archived Budgets</h3>
	<?php }?>
	<?php 
	echo $this->Form->create();
	echo $this->Form->input('keyword', array('label' => 'Search', 'default' =>  $this->Session->read('Budget.keyword')));
	echo $this->Form->end();
	?>
	<?php if (!empty($budgets)) {?>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th width = "40%"><?php echo $this->Paginator->sort('organization_id');?></th>
			<th width = "30%"><?php echo $this->Paginator->sort('name') ?></th>
			<th width = "20%"><?php echo $this->Paginator->sort('updated');?></th>
			<?php if ($archives == '0') {?>
			<th width = "5%"></th>
			<?php }?>
			<th width = "5%"></th>
	</tr>
	<?php
	$i = 0;
	foreach ($budgets as $budget):
	?>
	<tr>
		<td><?php echo $budget['Organization']['name']?></td>
		<td><?php echo $this->Html->link(__($budget['Budget']['name'], true), '/budgets/view/'.$budget['Budget']['id']); ?></td>
		<td><?php echo $budget['Budget']['updated'];?></td>
		<?php if ($archives == '0') {?>
		<td><?php echo $this->Html->link(__('Archive', true), array('action' => 'archive', $budget['Budget']['id']), null, sprintf(__('Are you sure you want to archive this budget?', true)));?></td>
		<?php }?>
		<td><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $budget['Budget']['id']), null, sprintf(__('Are you sure you want to delete this budget?', true)));?></td>
	</tr>
<?php endforeach; ?>
	</table>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |	
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
		<br><br>
		<?php
		echo $this->Paginator->counter(array('format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)));
		?>		
	</div>
	<?php } else {?>
		<h4>No documents available.</h4>
	<?php } ?>
</div>
