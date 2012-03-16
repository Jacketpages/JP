<?php echo $this->Html->addCrumb('All Bills', '/admin/bills'); ?>
<div id="sidebars" class="action">
	<ul>
		<li><?php echo $this->Html->link(__('View Bills', true), array('action' => 'index'));?>
		</li>
	</ul>
	
	<?php echo $this->element('sidebar')?>
</div>
<div id="middle">
	<div class="post bills form type-post">
		<h3>Bill Creation</h3>	
		
<?php echo $this->Form->create('Bill');?>
	<fieldset>
	<?php
		echo $this->Form->input('title');
		echo $this->Form->input('description');
		echo $this->Form->input('fundraising', array('label' => 'Please describe related fundraising efforts'));
		echo $this->Form->input('type', array('id' => 'type', 'options' => array('Finance Request' => 'Finance Request','Resolution' => 'Resolution')));
		echo $this->Form->input('category', array('id' => 'categoryChoice', 'div' => 'category', 'options' => array('Joint' => 'Joint', 'Graduate' =>'Graduate', 'Undergraduate' => 'Undergraduate')));
		echo $this->Form->input('status', array('options' => array('Awaiting Author' => 'Awaiting Author','Authored' => 'Authored','Agenda' => 'Agenda', 'Passed' => 'Passed','Failed' => 'Failed','Archived' => 'Archived')));
		echo $this->Form->input('organization_id', array('label' => 'Organization', 'options' => $organizations, 'default' => 'Select Organization'));
		echo $this->Form->input('underAuthor_id', array('div' => 'underAuthor_id', 'label' => 'Undergraduate Author', 'options' => $underAuthors));
		echo $this->Form->input('gradAuthor_id', array('div' => 'gradAuthor_id', 'label' => 'Graduate Author', 'options' => $gradAuthors));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
Line items are added after submitting bill information.
</div>
</div>
<script type="text/javascript">
$(document).ready(function() {

});
$("#type").change(function () {
	var type = $("#type option:selected").val();
	var cat = $("#categoryChoice option:selected").val();
	if(type == "Budget"){
		$(".underAuthor_id").fadeOut("slow");
		$(".gradAuthor_id").fadeOut("slow");
		$(".category").fadeOut("slow");
	}else{
		if(cat == "Joint"){
			$(".underAuthor_id").fadeIn("slow");
			$(".gradAuthor_id").fadeIn("slow");
		}else if(cat == "Graduate"){
			$(".underAuthor_id").fadeOut("slow");
			$(".gradAuthor_id").fadeIn("slow");
		}else if(cat == "Undergraduate"){
			$(".underAuthor_id").fadeIn("slow");
			$(".gradAuthor_id").fadeOut("slow");
		}
		$(".category").fadeIn("slow");
	}
});
$("#categoryChoice").change(function () {
	var cat = $("#categoryChoice option:selected").val();
	if(cat == "Joint"){
		$(".underAuthor_id").fadeIn("slow");
		$(".gradAuthor_id").fadeIn("slow");
	}else if(cat == "Graduate"){
		$(".underAuthor_id").fadeOut("slow");
		$(".gradAuthor_id").fadeIn("slow");
	}else if(cat == "Undergraduate"){
		$(".underAuthor_id").fadeIn("slow");
		$(".gradAuthor_id").fadeOut("slow");
	}
});
$( "#gtUsername" ).autocomplete({
	minLength: 2,
	source: "/ajax/name",
	focus: function( event, ui ) {
		$( "#submitterName" ).val( ui.item.name );
		return false;
	},
	select: function( event, ui ) {
		$( "#submitterName" ).val( ui.item.name );
		$( "#gtUsername" ).val( ui.item.id );

		return false;
	}
})
.data( "autocomplete" )._renderItem = function( ul, item ) {
	return $( "<li></li>" )
		.data( "item.autocomplete", item )
		.append( "<a>" + item.name + "<br>Username: " + item.id + "</a>" )
		.appendTo( ul );
};

</script>
