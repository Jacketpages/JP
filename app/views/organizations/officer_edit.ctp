<?php echo $this->Html->addCrumb('My Organizations', '/owner/organizations'); ?>
<?php echo $this->Html->addCrumb($organization['Organization']['name'], '/officer/organizations/view/'.$organization['Organization']['id']); ?>
<?php echo $this->Html->addCrumb('Edit Information', '/officer/organizations/edit/'.$organization['Organization']['id']); ?>
<div id="sidebars">
	<ul>
		<li><?php echo $this->Html->link(__('View/Add Documents', true), array('controller' => 'charters', 'action' => 'index', $organization['Organization']['id'], 'officer' => false)); ?>
		</li>
		<li><?php echo $this->Html->link(__('Edit Logo', true), array('action' => 'addlogo', $organization['Organization']['id'], 'officer' => false, 'admin' => false, 'owner' => false)); ?>
		</li>
		<li><?php echo $this->Html->link(__('Edit Officers/Roster', true), array('controller' => 'organizations', 'action' => 'roster', $organization['Organization']['id'], 'officer' => false)); ?>
		</li>
	</ul>
	
	
	
	
	
	
	
	
	<?php echo $this->element('sidebar')?>
</div>
<div id="middle">
	<h3>Edit Information</h3>
	
	
	
	
	
	
	
	
<?php echo $this->Form->create('Organization');?>
	<fieldset>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name', array('hidden' => false, 'readonly'=> 'readonly'));
		echo $this->Form->input('organization_contact', array('id' => 'primary_contact'));
		echo $this->Form->input('organization_contact_campus_email', array('id' => 'primary_email'));
		echo $this->Form->input('description');
		echo $this->Form->input('website');
		echo $this->Form->input('meeting_info');
		echo $this->Form->input('meeting_frequency');
		echo $this->Form->input('annual_events');
		echo $this->Form->input('dues');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<script type="text/javascript">
$(document).ready(function() {

$( "#primary_contact" ).autocomplete({
	minLength: 2,
	source: wr+'ajax/userName',
	focus: function( event, ui ) {
		$( "#primary_contact" ).val( ui.item.name );
		return false;
	},
	select: function( event, ui ) {
		$( "#primary_contact" ).val( ui.item.name );
		$( "#primary_email" ).val( ui.item.email );
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
