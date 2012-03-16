<?php echo $this -> Html -> addCrumb('All Organizations', '/organizations');?>
<?php echo $this -> Html -> addCrumb($organization['Organization']['name'], '/power/organizations/view' . $organization['Organization']['id']);?>
<div id="sidebars">
	<ul>
		<li>
			<?php echo $this -> Html -> link(__('View Documents', true), array(
					'controller' => 'charters',
					'action' => 'index',
					$organization['Organization']['id'],
					'admin' => false
			));
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
</div>
