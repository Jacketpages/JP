<?php echo $this->Html->addCrumb('All Organizations', '/organizations'); ?>
<?php echo $this->Html->addCrumb($organization['Organization']['name'], '/organizations/view/'.$organization['Organization']['id']); ?>
<?php echo $this->Html->addCrumb('Documents', '/charters/index/'.$organization['Organization']['id']); ?>
<div id="sidebars">
	<ul>




	<?php
	if ($isOfficer || $this->isLevel('admin')) {?>
		<li>
		<?php echo $this->Html->link('Add Documents', '/charters/addcharter/'.$organization['Organization']['id'])?>
		</li>
		
		
		
		
		
		
		
		
		<?php
		}?>
	</ul>
	
	
	
	
	
	
	
	
	<?php echo $this->element('sidebar')?>
</div>
<div id="middle">
	<h3>Documents</h3>
	
	
	
	
	
	
	
	
	<?php if (!empty($documents)) {?>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th width="90%"><?php echo $this->Paginator->sort('name');?></th>
			<th width="10%"></th>
	</tr>
	<?php
	$i = 0;
	foreach ($documents as $document):
	?>
	<tr>
		<td><?php echo $this->Html->link(__($document['Charter']['name'], true), '/charters/view/'.$document['Charter']['id']); ?></td>
		<td>
			<?php
			if ($isOfficer || $this->isLevel('admin')) {
				echo $this->Html->link(__('Delete', true), array('action' => 'delete', $document['Charter']['id']), null, sprintf(__('Are you sure you want to delete this document?', true)));
			}?>
		</td>
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
