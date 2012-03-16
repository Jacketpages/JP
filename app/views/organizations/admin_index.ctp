<?php echo $this -> Html -> addCrumb('All Organizations', '/admin/organizations');?>
<div id="sidebars">
	<ul>
		<li>
			<?php echo $this -> Html -> link(__('Create Organization', true), array('action' => 'add'));?>
		</li>
		<li>
			<?php echo $this -> Html -> link('Export Organizations', array(
					'admin' => false,
					'action' => 'export'
			));
			?>
		</li>
	</ul>
	<div id="category">
		<ul>
			<li>
				Organization Category
			</li>
		</ul>
		<?php
			echo $this -> Form -> create(array('action' => 'index'));
			echo $this -> Form -> input('category', array(
					'label' => false,
					'default' => $cat,
					'options' => array(
							'all' => 'All',
							'CPC Sorority' => 'CPC Sorority',
							'Cultural/Diversity' => 'Cultural/Diversity',
							'Departmental Sponsored' => 'Departmental Sponsored',
							'Departments' => 'Departments',
							'Governing Boards' => 'Governing Boards',
							'Honor Society' => 'Honor Society',
							'IFC Fraternity' => 'IFC Fraternity',
							'Institute Recognized' => 'Institute Recognized',
							'MGC Chapter' => 'MGC Chapter',
							'None' => 'None',
							'NPHC Chapter' => 'NPHC Chapter',
							'Production/Performance/Publication' => 'Production/Performance/Publication',
							'Professional/Departmental' => 'Professional/Departmental',
							'Recreational/Sports/Leisure' => 'Recreational/Sports/Leisure',
							'Religious/Spiritual' => 'Religious/Spiritual',
							'Residence Hall Association' => 'Residence Hall Association',
							'Service/Political/Educational' => 'Service/Political/Educational',
							'Student Government' => 'Student Government',
							'Umbrella' => 'Umbrella',
							'Other' => 'Other'
					)
			));
			echo $this -> Form -> end(__('Search', true));
		?>
	</div>
	<?php echo $this->element('sidebar')?>
</div>
<div id="middle">
	<h3>Organizations</h3>
	<div id="alpha">
		<div id="leftHalf">
			<?php
				echo $this -> Form -> create();
				echo $this -> Form -> input('keyword', array(
						'label' => 'Search',
						'id' => 'orgName',
						'default' => $search
				));
				echo $this -> Form -> end();
			?>
		</div>
		<div id="rightHalf">
			<ul>
				<?php
// set up alphabet
$alpha = range('A','Z');
for ($i=0; $i < count($alpha); $i++) {
				?>
				<li>
					<?php
						echo $html -> link($alpha[$i], array(
								'controller' => strtolower($this -> params['controller']),
								'action' => 'index',
								strtolower($alpha[$i])
						));
					?>
					&nbsp
				</li><?php
					}
				?>
				<li>
					<?php echo $html -> link('ALL', array(
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
			<th width="12%"></th>
			<th width="40%"><?php echo $this -> Paginator -> sort('Name', 'name');?></th>
			<th width="33%"><?php echo $this -> Paginator -> sort('Description', 'description');?></th>
			<th width="15%"></th>
		</tr>
		<?php
//Fix styling mess up for Chrome and Safari
$i = 0;
foreach ($organizations as $organization):
$class = null;
if ($i++ % 2 == 0) {
$class = 'class="altrow"';
}
		?>
		<tr <?php echo $class;?>>
			<td><?php
				if (strlen($organization['Organization']['logo_name']) < 1)
				{
					echo $html -> image('/img/default_logo.gif', array('width' => '60'));
				}
				else
				{
					echo $html -> image(array(
							'controller' => 'organizations',
							'action' => 'getLogo',
							$organization['Organization']['id'],
							'admin' => false
					), array('width' => '60'));
				}
			?></td>
			<td><?php echo $this -> Html -> link($organization['Organization']['name'], array(
						'action' => 'view',
						$organization['Organization']['id']
				));
			?> &nbsp;</td>
			<td><?php echo $organization['Organization']['description'];?></td>
			<td class="right"><?php echo $this -> Html -> link(__('Edit', true), array(
						'action' => 'edit',
						$organization['Organization']['id']
				));
			?>
			<?php echo $this -> Html -> link(__('Delete', true), array(
						'action' => 'delete',
						$organization['Organization']['id']
				), null, sprintf(__('Are you sure you want to delete this organization?', true)));
			?></td>
		</tr>
		<?php endforeach;?>
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

		$("#orgName").autocomplete({
			minLength : 2,
			source : wr + 'ajax/orgName'
		});
	});

</script>
