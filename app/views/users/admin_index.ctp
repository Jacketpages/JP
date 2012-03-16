<?php echo $this -> Html -> addCrumb('User Index', '/admin/users');?>
<div id="sidebars">
	<ul>
		<li>
			<?php echo $this -> Html -> link('Add User', array('action' => 'add'));?>
		</li>
		<li>
			<?php echo $this -> Html -> link('Add SGA Member', array(
					'controller' => 'sga_people',
					'action' => 'add'
			));
			?>
		</li>
	</ul>
	<?php echo $this->element('sidebar')
	?>
</div>
<div id="middle">
	<h3>Users</h3>
	<div id="alpha">
		<div id="leftHalf">
			<?php
				echo $this -> Form -> create();
				echo $this -> Form -> input('keyword', array(
						'label' => 'Search',
						'id' => 'userName',
						'default' => $this -> Session -> read('User.keyword')
				));
				echo $this -> Form -> end();
			?>
		</div>
		<div id="rightHalf">
			<ul>
				<?php
					// set up alphabet
					$alpha = range('A', 'Z');
					for ($i = 0; $i < count($alpha); $i++)
					{
						echo "<li>\n";
						echo $html -> link($alpha[$i], array(
								'controller' => strtolower($this -> params['controller']),
								'action' => 'index',
								strtolower($alpha[$i])
						));
						echo "&nbsp";
						echo "</li>\n";
					}
					echo "<li>\n";
					echo $html -> link('ALL', array(
							'controller' => strtolower($this -> params['controller']),
							'action' => 'index',
							'all'
					));
				?>
				</li>
			</ul>
		</div>
	</div>
	<table cellpadding="0" cellspacing="0">
		<tr>
			<th width="30%"><?php echo $this -> Paginator -> sort('name');?></th>
			<th width="30%"><?php echo $this -> Paginator -> sort('email');?></th>
			<th width="15%"><?php echo $this -> Paginator -> sort('phone');?></th>
			<th width="15%"><?php echo $this -> Paginator -> sort('level');?></th>
			<th width="10%"></th>
		</tr>
		<?php
$i = 0;
foreach ($users as $user):
$class = null;
if ($i++ % 2 == 0) {
$class = 'class="altrow"';
}
		?>
		<tr <?php echo $class;?>>
			<td><?php echo $this -> Html -> link(__($user['User']['name'], true), array(
					'action' => 'view',
					$user['User']['id']
			));
			?></td>
			<td><?php echo $user['User']['email'];?></td>
			<td><?php echo $user['User']['phone'];?></td>
			<td><?php echo $user['User']['level'];?></td>
			<td><?php echo $this -> Html -> link(__('Edit', true), array(
						'action' => 'edit',
						$user['User']['id']
				));
			?>
			<?php echo $this -> Html -> link(__('Delete', true), array(
						'action' => 'delete',
						$user['User']['id']
				), null, sprintf(__('Are you sure you want to delete %s?', true), $user['User']['name']));
			?></td>
			</tr> <?php endforeach;?>
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
<script type="text/javascript">
	$(document).ready(function() {

		$("#userName").autocomplete({
			minLength : 2,
			source : wr + 'ajax/name'
		});
	});

</script>
