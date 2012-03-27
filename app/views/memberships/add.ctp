<?php $this->Html->addCrumb($org[0]['Organization']['name'], '/organizations/view/'.$org[0]['Organization']['id']); ?>
<?php $this->Html->addCrumb('Add Member', '/memberships/'.$org[0]['Organization']['id']); ?>
<div id="sidebars">

<?php echo $this->element('sidebar')?>
</div>
<div id="middle">
	<h3>Add Member</h3>
	
<?php echo $this->Form->create('Membership', array('action' => 'add', $org[0]['Organization']['id']));?>
	<fieldset>
	<?php
	echo $this->Form->input('org', array ('label' => 'Organization', 'default' => $org [0] ['Organization'] ['name'], 'readonly' => 'readonly'));
	echo $this->Form->hidden('organization_id', array ('default' => $org [0] ['Organization'] ['id']));
	echo $this->Form->input('username', array ('label' => 'Member Name (or gatech email prefix) -- You must select from suggestions when they appear', 'id' => 'userName'));
   echo "<div>Note: Usernames will not show up in the dropdown box for those who do not have a Jacketpages Account.</div>";
	echo $this->Form->input('role', array ('options' => array ('Officer' => 'Officer', 'Member' => 'Member', 'President' => 'President', 'Treasurer' => 'Treasurer', 'Advisor' => 'Advisor')));
	if ($this->isLevel('admin') || $user['Membership']['role'] == 'President')
	{
		echo $this->Form->input('reserver', array ('label' => 'Room Reserver', 'options' => array ('No' => 'No', 'Yes' => 'Yes')));
	}
	echo $this->Form->input('title', array ('label' => 'Title (please default to role name)', 'default' => '(role)'));
	echo $this->Form->input('status', array ('options' => array ('Active' => 'Active', 'Inactive' => 'Inactive', 'Pending' => 'Pending')));
	?>
		<div id="date">
			<?php echo $this->Form->input('since', array('label' => 'Start Date', 'dateFormat' => 'MDY'));?>
			<?php echo $this->Form->input('duesPaid', array('dateFormat' => 'MDY'));?>
		</div>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>

<script type="text/javascript">
$(document).ready(function() {

$( "#userName" ).autocomplete({
	minLength: 2,
	source: wr+'ajax/userName',
	focus: function( event, ui ) {
		$( "#userName" ).val( ui.item.name );
		return false;
	},
	select: function( event, ui ) {
		$( "#userName" ).val( ui.item.name );
		$( "#user_id" ).val( ui.item.id );
		return false;
	}
})
.data( "autocomplete" )._renderItem = function( ul, item ) {
	return $( "<li></li>" )
		.data( "item.autocomplete", item )
		.append( "<a>" + item.name + " (" + item.gtUsername + ")</a>")
		.appendTo( ul );
};
});
</script>
