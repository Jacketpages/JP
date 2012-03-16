<?php echo $this -> Html -> addCrumb('All Bills', '/power/bills');?>
<?php
	if ($permitted)
	{
		echo $this -> Html -> addCrumb('My Bills', '/owner/bills');
	}
?>
<div id="sidebars">
	<ul>
		<li>
			<?php echo $this->Html->link(__('View Details', true), array('action' => 'view', $this->Form->value('Bill.id')))
			?>
		</li>
		<li>
			<?php echo $this -> Html -> link(__('Delete', true), array(
					'action' => 'delete',
					$this -> Form -> value('Bill.id')
			), null, sprintf(__('Are you sure you want to delete # %s?', true), $this -> Form -> value('Bill.id')));
			?>
		</li>
		<li>
			<?php echo $this -> Html -> link(__('All Bills', true), array('action' => 'index'));?>
		</li>
	</ul>
	<?php echo $this->element('sidebar')
	?>
</div>
<div id="middle">
	<h3>SGA View | Update Bill</h3>
	<?php echo $this -> Form -> create('Bill');?>
	<fieldset>
		<?php
			echo $this -> Form -> input('title');
			echo $this -> Form -> input('description');
			echo $this -> Form -> input('number', array('readonly' => 'readonly'));
			echo $this -> Form -> hidden('number');
			echo $this -> Form -> input('fundrasing');
			echo $this -> Form -> input('type', array(
					'readonly' => 'readonly',
					'options' => array(
							'Finance Request' => 'Finance Request',
							'Resolution' => 'Resolution'
					)
			));
			echo $this -> Form -> input('category', array(
					'id' => 'categoryChoice',
					'options' => array(
							'Joint' => 'Joint',
							'Undergraduate' => 'Undergraduate',
							'Graduate' => 'Graduate',
							'Conference' => 'Conference'
					)
			));
			echo $this -> Form -> input('status', array('options' => array(
						'Awaiting Author' => 'Awaiting Author',
						'Authored' => 'Authored',
						'Agenda' => 'Agenda',
						'Passed' => 'Passed',
						'Failed' => 'Failed',
						'Archived' => 'Archived'
				)));
			echo $this -> Form -> input('organization_id', array('readonly' => 'readonly'));
			echo $this -> Form -> hidden('organization_id');
			echo $this -> Form -> input('underAuthor_id', array(
					'div' => 'underAuthor_id',
					'label' => 'Undergraduate Author',
					'options' => $underAuthors
			));
			echo $this -> Form -> input('underAuthorApproved', array(
					'div' => 'underAuthor_id',
					'label' => 'Reviewed by Author',
					'options' => array(
							'Not yet reviewed',
							'Reviewed'
					)
			));
			echo $this -> Form -> input('gradAuthor_id', array(
					'div' => 'gradAuthor_id',
					'label' => 'Graduate Author',
					'options' => $gradAuthors
			));
			echo $this -> Form -> input('gradAuthorApproved', array(
					'div' => 'gradAuthor_id',
					'label' => 'Reviewed by Author',
					'options' => array(
							'Not yet reviewed',
							'Reviewed'
					)
			));
		?>
		<div class="gss">
			<label>Graduate Student Senate Outcome:</label>
			<div id="outcome">
				<div id="date">
					<?php
						echo $this -> Form -> input('gss_date', array(
								'label' => 'Date',
								'dateFormat' => 'MDY'
						));
					?>
				</div>
				<?php
					echo $this -> Form -> input('gss_yeas', array('label' => 'Yeas'));
					echo $this -> Form -> input('gss_nays', array('label' => 'Nays'));
					echo $this -> Form -> input('gss_abst', array('label' => 'Abstains'));
					echo $this -> Form -> input('gss_py', array('label' => 'Prior Year Approved'));
					echo $this -> Form -> input('gss_co', array('label' => 'Capital Outlay Approved'));
					echo $this -> Form -> input('gss_glr', array('label' => 'GLR Approved'));
				?>
			</div>
		</div>
		<div class="uhr">
			<label>Undergraduate House of Representatives Outcome:</label>
			<div id="outcome">
				<div id="date">
					<?php
						echo $this -> Form -> input('uhr_date', array(
								'label' => 'Date',
								'dateFormat' => 'MDY'
						));
					?>
				</div>
				<?php
					echo $this -> Form -> input('uhr_yeas', array('label' => 'Yeas'));
					echo $this -> Form -> input('uhr_nays', array('label' => 'Nays'));
					echo $this -> Form -> input('uhr_abst', array('label' => 'Abstains'));
					echo $this -> Form -> input('uhr_py', array('label' => 'Prior Year Approved'));
					echo $this -> Form -> input('uhr_co', array('label' => 'Capital Outlay Approved'));
					echo $this -> Form -> input('uhr_glr', array('label' => 'ULR Approved'));
				?>
			</div>
		</div>
		<?php?>
	</fieldset>
	<?php echo $this -> Form -> end('Update');?>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		var cat = $("#categoryChoice option:selected").val();
		if(cat == "Joint") {
			$(".underAuthor_id").fadeIn("slow");
			$(".uhr").fadeIn("slow");
			$(".gradAuthor_id").fadeIn("slow");
			$(".gss").fadeIn("slow");
		} else if(cat == "Graduate") {
			$(".underAuthor_id").fadeOut("slow");
			$(".uhr").fadeOut("slow");
			$(".gradAuthor_id").fadeIn("slow");
			$(".gss").fadeIn("slow");
		} else if(cat == "Undergraduate") {
			$(".underAuthor_id").fadeIn("slow");
			$(".uhr").fadeIn("slow");
			$(".gradAuthor_id").fadeOut("slow");
			$(".gss").fadeOut("slow");
		}
	});

	$("#categoryChoice").change(function() {
		var cat = $("#categoryChoice option:selected").val();
		if(cat == "Joint") {
			$(".underAuthor_id").fadeIn("slow");
			$(".uhr").fadeIn("slow");
			$(".gradAuthor_id").fadeIn("slow");
			$(".gss").fadeIn("slow");
		} else if(cat == "Graduate") {
			$(".underAuthor_id").fadeOut("slow");
			$(".uhr").fadeOut("slow");
			$(".gradAuthor_id").fadeIn("slow");
			$(".gss").fadeIn("slow");
		} else if(cat == "Undergraduate") {
			$(".underAuthor_id").fadeIn("slow");
			$(".uhr").fadeIn("slow");
			$(".gradAuthor_id").fadeOut("slow");
			$(".gss").fadeOut("slow");
		}
	});

</script>
<div class="gss">
				<label>Graduate Student Senate Outcome:</label>
				<div id="outcome">
					<div id="date">
						<?php
							echo $this -> Form -> input('gss_date', array(
									'label' => 'Date',
									'dateFormat' => 'MDY'
							));
						?>
					</div>
					<?php
						echo $this -> Form -> input('gss_yeas', array('label' => 'Yeas'));
						echo $this -> Form -> input('gss_nays', array('label' => 'Nays'));
						echo $this -> Form -> input('gss_abst', array('label' => 'Abstains'));
					?>
				</div>
			</div>
			<div class="uhr">
				<label>Undergraduate House of Representatives Outcome:</label>
				<div id="outcome">
					<div id="date">
						<?php
							echo $this -> Form -> input('uhr_date', array(
									'label' => 'Date',
									'dateFormat' => 'MDY'
							));
						?>
					</div>
					<?php
						echo $this -> Form -> input('uhr_yeas', array('label' => 'Yeas'));
						echo $this -> Form -> input('uhr_nays', array('label' => 'Nays'));
						echo $this -> Form -> input('uhr_abst', array('label' => 'Abstains'));
					?>
				</div>
			</div>
			<?php if ($bill['Bill']['category'] == 'Conference'):
			?>
			<div class = "uhr">
				<label>Conference Outcomes:</label>
				<div id="outcome">
					<div id="date">
						<?php
							echo $this -> Form -> input('cc_date', array(
									'label' => 'Date',
									'dateFormat' => 'MDY'
							));
						?>
					</div>
					<?php
						echo $this -> Form -> input('gcc_yeas', array('label' => 'Graduate Yeas'));
						echo $this -> Form -> input('gcc_nays', array('label' => 'Graduate Nays'));
						echo $this -> Form -> input('gcc_abst', array('label' => 'Graduate Abstains'));
						echo $this -> Form -> input('ucc_yeas', array('label' => 'Undergraduate Yeas'));
						echo $this -> Form -> input('ucc_nays', array('label' => 'Undergraduate Nays'));
						echo $this -> Form -> input('ucc_abst', array('label' => 'Undergraduate Abstains'));
					?>
				</div>
			</div>
			<?php endif;?>
			<?php echo $this -> Form -> input('grad_pres_sign', array(
						'label' => 'Graduate President Signature',
						'options' => array(
								'Not Yet Signed' => 'Not Yet Signed',
								$username => $username
						)
				));
				echo $this -> Form -> input('grad_secr_sign', array(
						'label' => 'Graduate Secretary Signature',
						'options' => array(
								'Not Yet Signed' => 'Not Yet Signed',
								$username => $username
						)
				));
				echo $this -> Form -> input('ungr_pres_sign', array(
						'label' => 'Undergraduate President Signature',
						'options' => array(
								'Not Yet Signed' => 'Not Yet Signed',
								$username => $username
						)
				));
				echo $this -> Form -> input('ungr_secr_sign', array(
						'label' => 'Undergraduate Secretary Signature',
						'options' => array(
								'Not Yet Signed' => 'Not Yet Signed',
								$username => $username
						)
				));
				echo $this -> Form -> input('vp_fina_sign', array(
						'label' => 'Vice President of Finance Signature',
						'options' => array(
								'Not Yet Signed' => 'Not Yet Signed',
								$username => $username
						)
				));
			?>
		</fieldset>
		<?php  echo $this -> Form -> end(__('Update', true));?>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		var cat = $("#categoryChoice option:selected").val();
		if(cat == "Joint" || cat == "Conference") {
			$(".underAuthor_id").fadeIn("slow");
			$(".uhr").fadeIn("slow");
			$(".gradAuthor_id").fadeIn("slow");
			$(".gss").fadeIn("slow");
		} else if(cat == "Graduate") {
			$(".underAuthor_id").fadeOut("slow");
			$(".uhr").fadeOut("slow");
			$(".gradAuthor_id").fadeIn("slow");
			$(".gss").fadeIn("slow");
		} else if(cat == "Undergraduate") {
			$(".underAuthor_id").fadeIn("slow");
			$(".uhr").fadeIn("slow");
			$(".gradAuthor_id").fadeOut("slow");
			$(".gss").fadeOut("slow");
		}
	});

	$("#gtUsername").autocomplete({
		minLength : 2,
		source : "/ajax/name",
		focus : function(event, ui) {
			$("#gtUsername").val(ui.item.name);
			return false;
		},
		select : function(event, ui) {
			$("#gtUsername").val(ui.item.id);
			return false;
		}
	}).data("autocomplete")._renderItem = function(ul, item) {
		return $("<li></li>").data("item.autocomplete", item).append("<a>" + item.name + "<br>Username: " + item.id + "</a>").appendTo(ul);
	};
	$("#categoryChoice").change(function() {
		var cat = $("#categoryChoice option:selected").val();
		if(cat == "Joint" || cat == "Conference") {
			$(".underAuthor_id").fadeIn("slow");
			$(".uhr").fadeIn("slow");
			$(".gradAuthor_id").fadeIn("slow");
			$(".gss").fadeIn("slow");
		} else if(cat == "Graduate") {
			$(".underAuthor_id").fadeOut("slow");
			$(".uhr").fadeOut("slow");
			$(".gradAuthor_id").fadeIn("slow");
			$(".gss").fadeIn("slow");
		} else if(cat == "Undergraduate") {
			$(".underAuthor_id").fadeIn("slow");
			$(".uhr").fadeIn("slow");
			$(".gradAuthor_id").fadeOut("slow");
			$(".gss").fadeOut("slow");
		}
	});

</script>