<?php echo $this -> Html -> addCrumb('All Organizations', '/organizations');?>
<?php echo $this -> Html -> addCrumb($organization['Organization']['name'], '/owner/organizations/view/' . $organization['Organization']['id']);?>
<?php echo $this -> Html -> addCrumb('Roster', '/organizations/roster/' . $organization['Organization']['id']);?>
<div id="sidebars">
	<ul>
		<li>
			<?php echo $this -> Html -> link(__('Add Membership', true), array(
					'controller' => 'memberships',
					'action' => 'add',
					$organization['Organization']['id']
			));
			?>
		</li>
	</ul>
	<?php echo $this->element('sidebar')
	?>
</div>
<div id="middle">
	<?php echo $this->element('roster', array('set' => $organization))
	?>
</div>
