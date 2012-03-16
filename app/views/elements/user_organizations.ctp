
<h3>Executive Positions</h3>



<?php if (!empty($user['President']) || !empty($user['Treasurer']) || !empty($user['Advisor']) || !empty($user['Officer'])):?>
<h4>Current:</h4>
<br />
<table cellpadding="0" cellspacing="0">




<?php foreach ($user['President'] as $President):
if (strtotime($President['since']) >= strtotime($this->getFiscalStartDate())) {
	if (isset($organizations[$President['organization_id']])) { ?>
	<tr>
		<td width="50%">
		<?php echo $this->Html->link(__($organizations[$President['organization_id']], true), array('controller' => 'organizations', 'action' => 'view', 'officer' => true, $President['organization_id'])); ?>
		</td>
		<td width="25%"><?php echo $President['title'];?></td>
		<td width="25%"><?php echo $President['since'];?></td>
	</tr>
	
	
	
	
	
	
	
	
	<?php } } endforeach; ?>
	<?php foreach ($user['Treasurer'] as $Treasurer): 
		if (strtotime($Treasurer['since']) >= strtotime($this->getFiscalStartDate())) {
		if (isset($organizations[$Treasurer['organization_id']])) { ?>
		<tr>
			<td width="50%">
				<?php echo $this->Html->link(__($organizations[$Treasurer['organization_id']], true), array('controller' => 'organizations', 'action' => 'view', 'officer' => true, $Treasurer['organization_id'])); ?>
			</td>
			<td width="25%"><?php echo $Treasurer['title'];?></td>
			<td width="25%"><?php echo $Treasurer['since'];?></td>
		</tr>
	<?php } } endforeach; ?>
	<?php foreach ($user['Advisor'] as $Advisor): 
		if (strtotime($Advisor['since']) >= strtotime($this->getFiscalStartDate())) {
		if (isset($organizations[$Advisor['organization_id']])) { ?>
		<tr>
			<td width="50%">
				<?php echo $this->Html->link(__($organizations[$Advisor['organization_id']], true), array('controller' => 'organizations', 'action' => 'view', 'officer' => true, $Advisor['organization_id'])); ?>
			</td>
			<td width="25%"><?php echo $Advisor['title'];?></td>
			<td width="25%"><?php echo $Advisor['since'];?></td>
		</tr>
	<?php } } endforeach; ?>
	<?php foreach ($user['Officer'] as $Officer): 
		if (strtotime($Officer['since']) >= strtotime($this->getFiscalStartDate())) {
		if (isset($organizations[$Officer['organization_id']])) { ?>
		<tr>
			<td width="50%">
				<?php echo $this->Html->link(__($organizations[$Officer['organization_id']], true), array('controller' => 'organizations', 'action' => 'view', 'officer' => true, $Officer['organization_id'])); ?>
			</td>
			<td width="25%"><?php echo $Officer['title'];?></td>
			<td width="25%"><?php echo $Officer['since'];?></td>
		</tr>
	<?php } } endforeach; ?>
	</table>

<h4>Previous:</h4>
<br />
<table cellpadding="0" cellspacing="0">




<?php foreach ($user['President'] as $President):
if (strtotime($President['since']) < strtotime($this->getFiscalStartDate())) {
	if (isset($organizations[$President['organization_id']])) { ?>
	<tr>
		<td width="50%">
		<?php echo $this->Html->link(__($organizations[$President['organization_id']], true), array('controller' => 'organizations', 'action' => 'view', 'owner' => false, $President['organization_id'])); ?>
		</td>
		<td width="25%"><?php echo $President['title'];?></td>
		<td width="25%"><?php echo $President['since'];?></td>
	</tr>
	
	
	
	
	
	
	
	
	<?php } } endforeach; ?>
	<?php foreach ($user['Treasurer'] as $Treasurer):
		if (strtotime($Treasurer['since']) < strtotime($this->getFiscalStartDate())) {
		if (isset($organizations[$Treasurer['organization_id']])) { ?>
		<tr>
			<td width="50%">
				<?php echo $this->Html->link(__($organizations[$Treasurer['organization_id']], true), array('controller' => 'organizations', 'action' => 'view', 'owner' => false, $Treasurer['organization_id'])); ?>
			</td>
			<td width="25%"><?php echo $Treasurer['title'];?></td>
			<td width="25%"><?php echo $Treasurer['since'];?></td>
		</tr>
	<?php } } endforeach; ?>
	<?php foreach ($user['Advisor'] as $Advisor):
		if (strtotime($Advisor['since']) < strtotime($this->getFiscalStartDate())) {
		if (isset($organizations[$Advisor['organization_id']])) { ?>
		<tr>
			<td width="50%">
				<?php echo $this->Html->link(__($organizations[$Advisor['organization_id']], true), array('controller' => 'organizations', 'action' => 'view', 'owner' => false, $Advisor['organization_id'])); ?>
			</td>
			<td width="25%"><?php echo $Advisor['title'];?></td>
			<td width="25%"><?php echo $Advisor['since'];?></td>
		</tr>
	<?php } } endforeach; ?>
	<?php foreach ($user['Officer'] as $Officer):
		if (strtotime($Officer['since']) < strtotime($this->getFiscalStartDate())) {
		if (isset($organizations[$Officer['organization_id']])) { ?>
		<tr>
			<td width="50%">
				<?php echo $this->Html->link(__($organizations[$Officer['organization_id']], true), array('controller' => 'organizations', 'action' => 'view', 'owner' => false, $Officer['organization_id'])); ?>
			</td>
			<td width="25%"><?php echo $Officer['title'];?></td>
			<td width="25%"><?php echo $Officer['since'];?></td>
		</tr>
	<?php } } endforeach; ?>
	</table>



	<?php else: ?>
<h4>Not an executive officer of any organization.</h4>


<?php endif; ?>

<br />
<h3>General Affiliations</h3>


<?php if (!empty($user['Member']) || !empty($user['PendingMember']) || !empty($user['RoomReserver'])):?>
<h4>Current:</h4>
<br />
<table cellpadding="0" cellspacing="0">




<?php foreach ($user['Member'] as $Member):
if (strtotime($Member['since']) >= strtotime($this->getFiscalStartDate())) {
	if (isset($organizations[$Member['organization_id']])) { ?>
	<tr>
		<td width="50%">
		<?php if ($Member['status'] == 'Active') {
			echo $this->Html->link(__($organizations[$Member['organization_id']], true), array('controller' => 'organizations', 'action' => 'view', $Member['organization_id']));
		} else {
			echo $this->Html->link(__($organizations[$Member['organization_id']], true), array('controller' => 'organizations', 'action' => 'view', 'owner' => false, $Member['organization_id']));
		}?>
		</td>
		
		
		
		
		
		
		
		
			<?php if ($Member['status'] == 'Active') {?>
				<td width="25%">Member</td>
			<?php } else {?>
				<td width="25%">Pending Member</td>
			<?php }?>
			<td width="25%"><?php echo $Member['since'];?></td>
		</tr>
	
	
	
	
	
	
	
	
	<?php } } endforeach; ?>
	<?php foreach ($user['RoomReserver'] as $RoomReserver):
		if (strtotime($RoomReserver['since']) >= strtotime($this->getFiscalStartDate())) {
		if (isset($organizations[$RoomReserver['organization_id']])) { ?>
		<tr>
			<td width="50%">
				<?php echo $this->Html->link(__($organizations[$RoomReserver['organization_id']], true), array('controller' => 'organizations', 'action' => 'view', $RoomReserver['organization_id'])); ?>
			</td>
			<td width="25%"><?php echo $RoomReserver['title'];?></td>
			<td width="25%"><?php echo $RoomReserver['since'];?></td>
		</tr>
	<?php } } endforeach; ?>
	</table>
<h4>Previous:</h4>
<br />
<table cellpadding="0" cellspacing="0">




<?php foreach ($user['Member'] as $Member):
if (strtotime($Member['since']) < strtotime($this->getFiscalStartDate())) {
	if (isset($organizations[$Member['organization_id']])) { ?>
	<tr>
		<td width="50%">
		<?php echo $this->Html->link(__($organizations[$Member['organization_id']], true), array('controller' => 'organizations', 'action' => 'view', 'owner' => false, $Member['organization_id'])); ?>
		</td>
		
		
		
		
		
		
		
		
			<?php if ($Member['status'] == 'Active') {?>
				<td width="25%">Member</td>
			<?php } else {?>
				<td width="25%">Pending Member</td>
			<?php }?>
			<td width="25%"><?php echo $Member['since'];?></td>
		</tr>
	
	
	
	
	
	
	
	
	<?php } } endforeach; ?>
	<?php foreach ($user['RoomReserver'] as $RoomReserver):
		if (strtotime($RoomReserver['since']) < strtotime($this->getFiscalStartDate())) {
		if (isset($organizations[$RoomReserver['organization_id']])) { ?>
		<tr>
			<td width="50%">
				<?php echo $this->Html->link(__($organizations[$RoomReserver['organization_id']], true), array('controller' => 'organizations', 'action' => 'view', 'owner' => false, $RoomReserver['organization_id'])); ?>
			</td>
			<td width="25%"><?php echo $RoomReserver['title'];?></td>
			<td width="25%"><?php echo $RoomReserver['since'];?></td>
		</tr>
	<?php } } endforeach; ?>
	</table>


	<?php else: ?>
<h4>Not affliated with any organizations.</h4>


	<?php endif;?>
