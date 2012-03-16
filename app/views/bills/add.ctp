<?php echo $this -> Html -> addCrumb('My Bills', '/owner/bills');?>
<div id="sidebars" class="action">
	<ul>
		<li>
			<?php echo $this -> Html -> link(__('View My Bills', true), array('action' => 'index'));?>
		</li>
	</ul>
	<?php echo $this->element('sidebar')
	?>
</div>
<div id="middle">
	<div class="post bills form type-post">
		<h3>Bill Creation</h3>
		<?php echo $this -> Form -> create('Bill');?>
		<fieldset>
			<?php
				echo $this -> Form -> input('title');
				echo $this -> Form -> input('description');
				echo $this -> Form -> input('fundraising', array(
						'label' => 'Please describe related fundraising efforts',
						'default' => ''
				));
				echo $this -> Form -> input('type', array(
						'id' => 'type',
						'options' => array(
								'Finance Request' => 'Finance Request',
								'Resolution' => 'Resolution'
						)
				));
				echo $this -> Form -> input('category', array(
						'id' => 'categoryChoice',
						'div' => 'category',
						'options' => array(
								'Joint' => 'Joint',
								'Graduate' => 'Graduate',
								'Undergraduate' => 'Undergraduate'
						)
				));
				echo $this -> Form -> hidden('status', array('value' => 'Awaiting Author'));
				echo $this -> Form -> input('organization_id', array(
						'label' => 'Organization',
						'options' => $organizations,
						'default' => 'Select Organization'
				));
				echo $this -> Form -> input('underAuthor_id', array(
						'div' => 'underAuthor_id',
						'label' => 'Undergraduate Author',
						'options' => $underAuthors
				));
				echo $this -> Form -> input('gradAuthor_id', array(
						'div' => 'gradAuthor_id',
						'label' => 'Graduate Author',
						'options' => $gradAuthors
				));
				echo $this -> Form -> input('gtUsername', array(
						'value' => $this -> Session -> read('User.gtUsername'),
						'label' => 'Submitter GT Username'
				));
			?>
		</fieldset>
		<?php echo $this -> Form -> end(__('Submit', true));?>
		Line items are added after submitting bill information.
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {

	});
	$("#type").change(function() {
		var type = $("#type option:selected").val();
		var cat = $("#categoryChoice option:selected").val();
		if(type == "Budget") {
			$(".underAuthor_id").fadeOut("slow");
			$(".gradAuthor_id").fadeOut("slow");
			$(".category").fadeOut("slow");
		} else {
			if(cat == "Joint") {
				$(".underAuthor_id").fadeIn("slow");
				$(".gradAuthor_id").fadeIn("slow");
			} else if(cat == "Graduate") {
				$(".underAuthor_id").fadeOut("slow");
				$(".gradAuthor_id").fadeIn("slow");
			} else if(cat == "Undergraduate") {
				$(".underAuthor_id").fadeIn("slow");
				$(".gradAuthor_id").fadeOut("slow");
			}
			$(".category").fadeIn("slow");
		}
	});
	$("#categoryChoice").change(function() {
		var cat = $("#categoryChoice option:selected").val();
		if(cat == "Joint") {
			$(".underAuthor_id").fadeIn("slow");
			$(".gradAuthor_id").fadeIn("slow");
		} else if(cat == "Graduate") {
			$(".underAuthor_id").fadeOut("slow");
			$(".gradAuthor_id").fadeIn("slow");
		} else if(cat == "Undergraduate") {
			$(".underAuthor_id").fadeIn("slow");
			$(".gradAuthor_id").fadeOut("slow");
		}
	});

</script>
