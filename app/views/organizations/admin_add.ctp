<?php echo $this->Html->addCrumb('Organizations', '/admin/organizations'); ?>
<?php echo $this->Html->addCrumb('Add Organization', '/admin/organizations/add'); ?>
<div id="sidebars">




<?php echo $this->element('sidebar')?>
</div>
<div id="middle">
	<h3>Add Organization</h3>
	
	
	
	
	
	
	
	
<?php echo $this->Form->create('Organization');?>
	<fieldset>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('status', array('options' => array('Active' => 'Active', 'Inactive' => 'Inactive', 'Frozen' => 'Frozen'), 'default' => 'Active'));
		echo $this->Form->input('category', array('options' => array('CPC Sorority' => 'CPC Sorority', 
			'Cultural/Diversity' => 'Cultural/Diversity', 'Departmental Sponsored' => 'Departmental Sponsored',
			'Departments' => 'Departments', 'Governing Boards' => 'Governing Boards', 'Honor Society' => 'Honor Society', 'IFC Fraternity' => 'IFC Fraternity',
			'Institute Recognized' => 'Institute Recognized', 'MGC Chapter' => 'MGC Chapter', 'None' => 'None', 'NPHC Chapter' => 'NPHC Chapter',
			'Production/Performance/Publication' => 'Production/Performance/Publication', 'Professional/Departmental' => 'Professional/Departmental',
			'Recreational/Sports/Leisure' => 'Recreational/Sports/Leisure', 'Religious/Spiritual' => 'Religious/Spiritual', 
			'Residence Hall Association' => 'Residence Hall Association', 'Service/Political/Educational' => 'Service/Political/Educational',
			'Student Government' => 'Student Government', 'Umbrella' => 'Umbrella', 'Other' => 'Other')));
		echo $this->Form->input('organization_contact', array('id' => 'primary_contact'));
		echo $this->Form->input('organization_contact_preferred_email', array('id' => 'primary_email'));
		echo $this->Form->input('description');
		echo $this->Form->input('website');
		echo $this->Form->input('meeting_info');
		echo $this->Form->input('meeting_frequency');
		echo $this->Form->input('annual_events');
		echo $this->Form->input('dues');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
Additional organization information (e.g., officers) can be edited on the following page.
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
