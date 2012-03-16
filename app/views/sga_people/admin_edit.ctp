<?php $this -> Html -> addCrumb('SGA People', '/admin/sga_people');?>
<?php $this -> Html -> addCrumb('Edit SGA Member', '/admin/sga_people/edit/' . $id);?>
<div id="sidebars">
	<?php echo $this->element('sidebar')
	?>
</div>
<div id="middle">
	<h3><?php echo $name
	?>
	Edit SGA Membership</h3>
	<?php echo $this -> Form -> create('SgaPerson');?>
	<fieldset>
		<?php
			echo $this -> Form -> input('house', array('options' => array(
						'Graduate' => 'Graduate',
						'Undergraduate' => 'Undergraduate'
				)));
			echo $this -> Form -> input('department');
			echo $this -> Form -> input('status', array('options' => array(
						'Active' => 'Active',
						'Inactive' => 'Inactive'
				)));
		?>
	</fieldset>
	<?php echo $this -> Form -> end(__('Submit', true));?>
</div>