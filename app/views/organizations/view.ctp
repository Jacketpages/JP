<?php echo $this -> Html -> addCrumb('All Organizations', '/organizations');?>
<?php echo $this -> Html -> addCrumb($organization['Organization']['name'], '/organizations/view/' . $organization['Organization']['id']);?>
<div id="sidebars">
	<ul>
		<?php if(!$isMember && $this->isLevel('user')) {
		?>
		<li>
			<?php echo $this -> Html -> link(__('Join Organization', true), array(
					'action' => 'join',
					$organization['Organization']['id'],
					'admin' => false,
					'owner' => false,
					'officer' => false
			), null, sprintf(__('Are you sure you want to join %s?', true), $organization['Organization']['name']));
			?>
		</li>
		<?php }
		if ($this -> isLevel('user'))
		{
			echo "<li>";
		echo $this -> Html -> link(__('View Documents', true), array(
					'controller' => 'charters',
					'action' => 'index',
					$organization['Organization']['id'],
					'admin' => false
			));
			echo "<li>";
		}
			?>
	</ul>
	<?php echo $this->element('sidebar')
	?>
</div>
<div id="middle">
	<?php echo $this->element('organization_info')
	?>
	<br />
	<?php if($isMember) echo $this->element('related_budgets', array('set' => $organization))
	?>
	<br/>
	<?php if ($isMember) echo $this->element('related_bills', array('set' => $organization))
	?>
	<br/>
	<?php if ($isMember) echo $this->element('related_members', array('set' => $organization))
	?>
</div>
