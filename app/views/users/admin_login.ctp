<?php echo $this -> Html -> addCrumb('Login', '/admin/users');?>
<div id="sidebars">
	<?php echo $this->element('sidebar')
	?>
</div>
<div id="middle">
	<h3>Current User</h3>
	<h4><?php
		$s = $this -> Session -> read();
		if (isset($s['User']) && $s['User']['name'] != '')
		{
			echo "Welcome, " . $s['User']['name'] . "! We have you listed as '" . $s['User']['level'] . "'.\n";
		}
		else
		{
			echo "We do not have you in our system. We will recognize you as a student. Please click <a href=/users/add>here</a> to create a user.\n";
		}
		if (isset($s['SgaPerson']) && $s['SgaPerson']['house'] != '')
		{
			echo "We see you are a member of SGA. Your house is " . $s['SgaPerson']['house'] . ".\n";
		}
	?></h4>
	<br />
	<h3>Login as Other User</h3>
	<?php
		echo $this -> Form -> create('User');
		echo $this -> Form -> input('gtUsername', array(
				'value' => $this -> Session -> read('User.gtUsername'),
				'id' => 'gtUsername',
				'gtUsername' => 'gtUsername',
				'label' => 'GT Username'
		));
		echo $this -> Form -> end(__('Submit', true));
	?>
</div>
<script type="text/javascript">
	$(document).ready(function() {
	});
	$("#gtUsername").autocomplete({
		minLength : 2,
		source : wr + "ajax/username",
		focus : function(event, ui) {
			$("#submitterName").val(ui.item.name);
			return false;
		},
		select : function(event, ui) {
			$("#submitterName").val(ui.item.name);
			$("#gtUsername").val(ui.item.gtUsername);

			return false;
		}
	}).data("autocomplete")._renderItem = function(ul, item) {
		return $("<li></li>").data("item.autocomplete", item).append("<a>" + item.name + "<br>Username: " + item.gtUsername + "</a>").appendTo(ul);
	};
	$("#category").change(function() {
		var cat = $("#category option:selected").val();
		if(cat == "joint") {
			$(".underAuthor_id").fadeIn("slow");
			$(".gradAuthor_id").fadeIn("slow");
		} else if(cat == "grad") {
			$(".underAuthor_id").fadeOut("slow");
			$(".gradAuthor_id").fadeIn("slow");
		} else if(cat == "undergrad") {
			$(".underAuthor_id").fadeIn("slow");
			$(".gradAuthor_id").fadeOut("slow");
		}
	});
</script>
