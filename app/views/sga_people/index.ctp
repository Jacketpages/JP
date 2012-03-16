<?php $this -> Html -> addCrumb('SGA People', 'users/sga_people');?>
<div id="sidebars" class="action">
	<ul>
		<li>
			<?php echo $this -> Html -> link(__('All Members', true), array('action' => 'index', ));?>
		<ul>
			<li>
				<?php echo $this -> Html -> link (__('Graduate', true), array ('action' => 'index', 'Graduate')); ?>
			</li>
			<li>
				<?php echo $this -> Html -> link (__('Undergraduate', true), array ('action' => 'index', 'Undergraduate')); ?>
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
			<th width="40%"><?php echo $this -> Paginator -> sort('Name', 'User.name');?></th>
			<th width="30%"><?php echo $this -> Paginator -> sort('House', 'house');?></th>
			<th width="30%"><?php echo $this -> Paginator -> sort('Department', 'department');?></th>
		</tr>
		<?php
$i = 0;
foreach ($sgaPeople as $sgaPerson):
	if ($sgaPerson['SgaPerson']['status'] == 'Active'):
$class = null;
if ($i++ % 2 == 0) {
$class = ' class="altrow"';
}
		?>
		<tr<?php echo $class;?>>
			<td width="40%"><?php echo $sgaPerson['User']['name'];?></td>
			<td width="30%"><?php echo $sgaPerson['SgaPerson']['house'];?>&nbsp;</td>
			<td width="30%"><?php echo $sgaPerson['SgaPerson']['department'];?>&nbsp;</td>
			</tr> <?php endif;
			endforeach;?>
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
