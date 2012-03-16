<?php $this -> Html -> addCrumb('Memberships', '/memberships');?>
<div id="sidebars">
	<ul>
		<li>
			<?php echo $this -> Html -> link(__('New Membership', true), array('action' => 'add'));?>
		</li>
		<li>
			<?php echo $this -> Html -> link(__('List Organizations', true), array(
					'controller' => 'organizations',
					'action' => 'index'
			));
			?>
		</li>
	</ul>
	<?php echo $this->element('sidebar')
	?>
</div>
<div id="middle">
	<h3>Memberships</h3>
	<table cellpadding="0" cellspacing="0">
		<tr>
			<th><?php echo $this -> Paginator -> sort('user_id');?></th>
			<th><?php echo $this -> Paginator -> sort('organization_id');?></th>
			<th><?php echo $this -> Paginator -> sort('role');?></th>
			<th class="actions"><?php __('Actions');?></th>
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
			<td><?php echo $this -> Html -> link($membership['User']['name'], array(
					'controller' => 'users',
					'action' => 'view',
					$membership['User']['id']
			));
			?></td>
			<td><?php echo $this -> Html -> link($membership['Organization']['name'], array(
						'controller' => 'organizations',
						'action' => 'view',
						$membership['Organization']['id']
				));
			?></td>
			<td><?php echo $this -> Html -> link($membership['Membership']['role'], array(
						'action' => 'view',
						$membership['Membership']['id']
				));
			?>&nbsp;</td>
			<td class="actions"><?php echo $this -> Html -> link(__('Edit', true), array(
						'action' => 'edit',
						$membership['Membership']['id']
				));
			?>
			<?php echo $this -> Html -> link(__('Delete', true), array(
						'action' => 'delete',
						$membership['Membership']['id']
				), null, sprintf(__('Are you sure you want to delete # %s?', true), $membership['Membership']['id']));
			?></td>
			</tr> <?php endforeach;?>
	</table>
	<p>
		<?php
			echo $this -> Paginator -> counter(array('format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)));
		?>
	</p>
	<div class="paging">
		<?php echo $this -> Paginator -> prev('<< ' . __('previous', true), array(), null, array('class' => 'disabled'));?>
		|
		<?php echo $this -> Paginator -> numbers();?>
		|
		<?php echo $this -> Paginator -> next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
