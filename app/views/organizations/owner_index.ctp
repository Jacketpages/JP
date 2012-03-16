<?php echo $this -> Html -> addCrumb('My Organizations', '/owner/organizations');?>
<div id="sidebars">
	<?php echo $this->element('sidebar')?>
</div>
<div id="middle">
	<h3>My Organizations and Positions</h3>
	<?php echo $this -> element('user_organizations', array(
				$user,
				$organizations
		));
	?>
</div>
