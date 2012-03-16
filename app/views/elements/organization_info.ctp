<div id="desc">
	<div id="descLeft">
		<h3><?php echo $organization['Organization']['name']
		?></h3>
		<h4>Officers:</h4>
		<br />
		<table cellpadding="0" cellspacing="0">
			<?php
$i = 0;
foreach ($presidents as $president):
			?>
			<tr>
				<td width="40%"><?php
					if ($this -> isLevel('user'))
					{
						echo $this -> Html -> link($president['User']['name'], 'mailto:' . $president['User']['email']);
					}
					else
					{
						echo $president['User']['name'];
					}
				?></td>
				<td width="60%"><?php echo $president_title[$president['User']['id']];?>&nbsp;</td>
			</tr>
			<?php $i++;
				endforeach;
			?>
			<?php
foreach ($treasurers as $treasurer):
			?>
			<tr>
				<td width="40%"><?php
					if ($this -> isLevel('user'))
					{
						echo $this -> Html -> link($treasurer['User']['name'], 'mailto:' . $treasurer['User']['email']);
					}
					else
					{
						echo $treasurer['User']['name'];
					}
				?></td>
				<td width="60%"><?php echo $treasurer_title[$treasurer['User']['id']];?>
				&nbsp;</td>
			</tr>
			<?php $i++;
				endforeach;
			?>
			<?php
foreach ($officers as $officer):
			?>
			<tr>
				<td width="40%"><?php
					if ($this -> isLevel('user'))
					{
						echo $this -> Html -> link($officer['User']['name'], 'mailto:' . $officer['User']['email']);
					}
					else
					{
						echo $officer['User']['name'];
					}
				?></td>
				<td width="60%"><?php echo $officer_title[$officer['User']['id']];?>
				&nbsp;</td>
			</tr>
			<?php $i++;
				endforeach;
			?>
			<?php
foreach ($advisors as $advisor):
			?>
			<tr>
				<td width="40%"><?php
					if ($this -> isLevel('user'))
					{
						echo $this -> Html -> link($advisor['User']['name'], 'mailto:' . $advisor['User']['email']);
					}
					else
					{
						echo $advisor['User']['name'];
					}
				?></td>
				<td width="60%"><?php echo $advisor_title[$advisor['User']['id']];?>
				&nbsp;</td>
			</tr>
			<?php $i++;
				endforeach;
			?>
			<?php
foreach ($reservers as $reserver):
			?>
			<tr>
				<td width="40%"><?php
					if ($this -> isLevel('user'))
					{
						echo $this -> Html -> link($reserver['User']['name'], 'mailto:' . $reserver['User']['email']);
					}
					else
					{
						echo $reserver['User']['name'];
					}
				?></td>
				<td width="60%"> Room Reserver
				&nbsp; </td>
			</tr>
			<?php $i++;
				endforeach;
				if ($i == 0) {
			?>
			<h5>No officer information available.</h5>
			<?php }?>
		</table>
	</div>
	<div id="descRight">
		<?php
			if (strlen($organization['Organization']['logo_name']) < 1)
			{
				echo $html -> image('/img/default_logo.gif', array('width' => '80'));
			}
			else
			{
				echo $html -> image(array(
						'controller' => 'organizations',
						'action' => 'getLogo',
						$organization['Organization']['id'],
						'admin' => false,
						'owner' => false,
						'officer' => false
				), array('width' => '80'));
			}
		?>
	</div>
</div>
<div id="desc">
	<h3>Description</h3>
	<h5><?php echo nl2br(Sanitize::html($organization['Organization']['description'], array('remove' => true)));
	?></h5>
	<br />
	<br />
	<ul>
		<?php if ($this->isLevel('admin')) {
		?>
		<li>
			<?php echo "Status: " . $organization['Organization']['status'];?>
		</li>
		<?php }?>
		<?php if(strlen($organization['Organization']['organization_contact']) > 0) {
		?>
		<li>
			<?php echo "Organization Contact: " . $this -> Html -> link($organization['Organization']['organization_contact'], 'mailto:' . $organization['Organization']['organization_contact_campus_email']);?>
		</li>
		<?php }?>
		<?php if(strlen($organization['Organization']['website']) > 0) {
		?>
		<li>
			<?php
				if (stristr($organization['Organization']['website'], "http://") == FALSE)
				{
					$site = "http://" . $organization['Organization']['website'];
				}
				else
				{
					$site = $organization['Organization']['website'];
				}
				echo "Website: " . $this -> Html -> link($site, $site, array('target' => '_blank'));
			?>
		</li>
		<?php }?>
		<?php if(strlen($organization['Organization']['meeting_info']) > 0) {
		?>
		<li>
			<?php echo "Meetings: " . $organization['Organization']['meeting_info'];
			if (strlen($organization['Organization']['meeting_frequency']) > 0)
				echo "; " . $organization['Organization']['meeting_frequency'];
			?>
		</li>
		<?php }?>
		<?php if(strlen($organization['Organization']['annual_events']) > 0) {
		?>
		<li>
			<?php echo "Events: " . $organization['Organization']['annual_events'];?>
		</li>
		<?php }?>
		<?php if(strlen($organization['Organization']['dues']) > 0) {
		?>
		<li>
			<?php echo "Dues: " . $organization['Organization']['dues'];?>
		</li>
		<?php }?>
	</ul>
	<br />
</div>
