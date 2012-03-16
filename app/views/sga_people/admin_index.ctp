<?php $this -> Html -> addCrumb('SGA People', 'admin/sga_people');?>
<div id="sidebars" class="action">
	<ul>
		<li>
			<?php echo $this -> Html -> link(__('Add SGA Member', true), array('action' => 'add'));?>
		</li>
		<li>
			<?php echo $this -> Html -> link(__('All Members', true), array('action' => 'index', ));?>
			<ul>
				<li>
					<?php echo $this -> Html -> link(__('Graduate', true), array(
						'action' => 'index',
						'Graduate'
					));
					?>
				</li>
				<li>
					<?php echo $this -> Html -> link(__('Undergraduate', true), array(
						'action' => 'index',
						'Undergraduate'
					));
					?>
				</li>
				<li>
					<?php echo $this -> Html -> link(__('Active', true), array(
						'action' => 'index',
						'Active'
					));
					?>
				</li>
				<li>
					<?php echo $this -> Html -> link(__('Inactive', true), array(
						'action' => 'index',
						'Inactive'
					));
					?>
				</li>
			</ul>
		</li>
	</ul>
	<?php echo $this->element('sidebar')
	?>
</div>
<div id="middle">
	<h3>SGA Records</h3>
	<table cellpadding="0" cellspacing="0">
		<tr>
			<th><?php echo $this -> Paginator -> sort('Name', 'User.name');?></th>
			<th><?php echo $this -> Paginator -> sort('House', 'house');?></th>
			<th><?php echo $this -> Paginator -> sort('Department', 'department');?></th>
			<th><?php echo $this -> Paginator -> sort('Status', 'status');?></th>
			<th><?php __('Actions');?></th>
		</tr>
		<?php
$i = 0;
foreach ($sgaPeople as $sgaPerson):
$class = null;
if ($i++ % 2 == 0) {
$class = 'class="altrow"';
}
		?>
		<tr <?php echo $class;?>>
			<td><?php echo $this -> Html -> link($sgaPerson['User']['name'], array(
				'controller' => 'users',
				'action' => 'view',
				$sgaPerson['User']['id']
			));
			?></td>
			<td><?php echo $sgaPerson['SgaPerson']['house'];?>&nbsp;</td>
			<td><?php echo $sgaPerson['SgaPerson']['department'];?>&nbsp;</td>
			<td><?php echo $sgaPerson['SgaPerson']['status'];?>&nbsp;</td>
			<td class="actions"><?php echo $this -> Html -> link(__('Edit', true), array(
					'action' => 'edit',
					$sgaPerson['SgaPerson']['id']
				));
			?>
			<?php echo $this -> Html -> link(__('Delete', true), array(
					'action' => 'delete',
					$sgaPerson['SgaPerson']['id']
				), null, sprintf(__('Are you sure you want to delete?', true)));
			?></td>
		</tr>
		<?php
			endforeach;
		?>
	</table>
	<div class="paging">
		<?php echo $this -> Paginator -> prev('<< ' . __('previous', true), array(), null, array('class' => 'disabled'));?>
		|
		<?php echo $this -> Paginator -> numbers();?>
		|
		<?php echo $this -> Paginator -> next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
		<br>
		<br>
		<?php
			echo $this -> Paginator -> counter(array('format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)));
		?>
	</div>
</div>
