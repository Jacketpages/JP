<?php echo $this -> Html -> addCrumb('All Organizations', '/organizations');?>
<?php echo $this -> Html -> addCrumb('My Organizations', '/owner/organizations');?>
<?php echo $this -> Html -> addCrumb($organization['Organization']['name'], '/officer/organizations/view/' . $organization['Organization']['id']);?>
<div id="sidebars">
	<ul>
		<li>
			<?php echo $this -> Html -> link(__('Edit Information', true), array(
					'action' => 'edit',
					$organization['Organization']['id']
			));
			?>
		</li>
		<li>
			<?php echo $this -> Html -> link(__('Edit Logo', true), array(
					'action' => 'addlogo',
					$organization['Organization']['id'],
					'officer' => false,
					'admin' => false,
					'owner' => false
			));
			?>
		</li>
		<li>
			<?php echo $this -> Html -> link(__('Edit Officers/Roster', true), array(
					'controller' => 'organizations',
					'action' => 'roster',
					'officer' => false,
					$organization['Organization']['id']
			));
			?>
		</li>
		<li>
			<?php echo $this -> Html -> link(__('View/Add Documents', true), array(
					'controller' => 'charters',
					'action' => 'index',
					$organization['Organization']['id'],
					'admin' => false
			));
			?>
		</li>
		<li>
			<?php echo $this -> Html -> link(__('View/Add Budgets', true), array(
					'controller' => 'budgets',
					'action' => 'index',
					$organization['Organization']['id'],
					'admin' => false
			));
			?>
		</li>
		<li>
			<?php echo $this -> Html -> link(__('Leave Organization', true), array(
					'action' => 'leave',
					$organization['Organization']['id']
			), null, sprintf(__('Are you sure you want to leave %s?', true), $organization['Organization']['name']));
			?>
		</li>
	</ul>
	<?php echo $this->element('sidebar')
	?>
</div>
<div id="middle">
	<?php echo $this->element('organization_info')
	?>
	<br />
	<?php echo $this->element('related_budgets', array('set' => $organization))
	?>
	<br/>
	<?php echo $this->element('related_bills', array('set' => $organization))
	?>
	<br/>
	<?php echo $this->element('related_members', array('set' => $organization))
	?>
	<br/>
	<?php echo $this->element('pending_members', array('set' => $organization))
	?>
</div>
