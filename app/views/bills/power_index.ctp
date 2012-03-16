<?php
	$this -> Paginator -> options(array(
			'update' => '#middle',
			'indicator' => '#indicator',
			'evalScripts' => true,
			'before' => $this -> Js -> get('#listing') -> effect('fadeOut', array('buffer' => false)),
			'complete' => $this -> Js -> get('#listing') -> effect('fadeIn', array('buffer' => false)),
	));
?>
<?php echo $this -> Html -> addCrumb('All Bills', '/power/bills/index/All');?>
<div id="sidebars">
	<ul>
		<li>
			<?php echo $this -> Html -> link(__('All Bills', true), array(
				'action' => 'index',
				'All'
			));
			?>
		</li>
		<li>
			<?php echo $this -> Html -> link(__('Status', true), array('action' => 'index'));?>
			<ul>
				<li>
					<?php echo $this -> Html -> link(__('On Agenda', true), array(
							'action' => 'index',
							'Agenda'
					));
					?>
				</li>
				<li>
					<?php echo $this -> Html -> link(__('Authored', true), array(
							'action' => 'index',
							'Authored'
					));
					?>
				</li>
				<li>
					<?php echo $this -> Html -> link(__('Awaiting Author', true), array(
							'action' => 'index',
							'Awaiting Author'
					));
					?>
				</li>
				<li>
					<?php echo $this -> Html -> link(__('Passed', true), array(
							'action' => 'index',
							'Passed'
					));
					?>
				</li>
				<li>
					<?php echo $this -> Html -> link(__('Failed', true), array(
							'action' => 'index',
							'Failed'
					));
					?>
				</li>
				<li>
					<?php echo $this -> Html -> link(__('Archived', true), array(
							'action' => 'index',
							'Archived'
					));
					?>
				</li>
			</ul>
		</li>
		<li>
			<?php echo $this -> Html -> link(__('Category', true), array('action' => 'index'));?>
			<ul>
				<li>
					<?php echo $this -> Html -> link(__('Joint', true), array(
							'action' => 'index',
							'Joint'
					));
					?>
				</li>
				<li>
					<?php echo $this -> Html -> link(__('Conference', true), array(
							'action' => 'index',
							'Conference'
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
					<?php echo $this -> Html -> link(__('Graduate', true), array(
							'action' => 'index',
							'Graduate'
					));
					?>
				</li>
			</ul>
		</li>
		<li>
			<?php echo $this -> Html -> link(__('New Bill', true), array(
					'power' => false,
					'action' => 'add'
			));
			?>
		</li>
		<li>
			<?php echo $this -> Html -> link('Export FY Data', array(
					'power' => false,
					'action' => 'export'
			));
			?>
		</li>
	</ul>
	<?php echo $this->element('sidebar')
	?>
</div>
<div id="middle">
	<div class="bills index">
		<h3>Bills</h3>
		<?php
			echo $this -> Form -> create();
			echo $this -> Form -> input('keyword', array(
					'label' => 'Search',
					'default' => $this -> Session -> read($this -> name . '.keyword')
			));
			echo $this -> Form -> end();
		?>
		<div id="listing">
			<table cellpadding="0" cellspacing="0">
				<tr>
					<th><?php echo $this -> Paginator -> sort('title');?></th>
					<th><?php echo $this -> Paginator -> sort('status');?></th>
					<th><?php echo $this -> Paginator -> sort('submit_date');?></th>
					<?php if(in_array('Agenda', $this->params['pass']) || in_array('Passed', $this->params['pass']) || in_array('Failed', $this->params['pass'])){
					?>
					<th><?php
						echo $this -> Paginator -> sort('number');
					?></th>
					<?php }?>
				</tr>
				<?php
$i = 0;
foreach ($bills as $bill):
$class = null;
if ($i++ % 2 == 0) {
$class = 'class="altrow"';
}
				?>
				<tr <?php echo $class;?>>
					<td><?php echo $this -> Html -> link($bill['Bill']['title'], array(
							'action' => 'view',
							$bill['Bill']['id']
					));
					?>&nbsp;</td>
					<td><?php echo $bill['Bill']['status'];?>&nbsp;</td>
					<td><?php echo $bill['Bill']['submit_date'];?>&nbsp;</td>
					<?php if(in_array('Agenda', $this->params['pass']) || in_array('Passed', $this->params['pass']) || in_array('Failed', $this->params['pass'])){
					?>
					<td><?php
						echo $bill['Bill']['number'];
					?></td>
					<?php }?>
				</tr>
				<?php endforeach;?>
			</table>
			<div class="paging">
				<?php echo $this -> Paginator -> prev('<< ' . __('previous', true), array(), null, array('class' => 'disabled'));?>
				| 	<?php echo $this -> Paginator -> numbers();?>
				|
				<?php echo $this -> Paginator -> next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
				<br>
				<br>
				<?php
					echo $this -> Paginator -> counter(array('format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)));
				?>
			</div>
		</div>
