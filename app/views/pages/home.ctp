<div id="sidebars">
<?php echo $this->element('sidebar_nodivider')?>
</div>
<div id="middle">

	<!--NOTIFICATION AREA (rounded rectangle). First display login request if necessary. Use this area in the future to enable admins to publish important messages.-->
	
	
	
	
	<?php 
	if(!$this->isLevel('user')) {
	?> 
	<div>
		<br>
		<div class="roundedcornr_box">
			<div class="roundedcornr_top"><div></div></div>
				<div class="roundedcornr_content">
					<?php 
					if(!$this->isLevel('student')) {
					?>
						<div id="information">
							<p>Welcome, guest. Please login <?php echo $this->Html->link(__('here', true), array('controller' => 'users', 'action' => 'login'));?> to more fully use JacketPages.</p>
						</div>
					<?php
					} else if (!strlen($this->Session->read('User.name'))>0) {
					?>
						<p>Welcome, <?php echo $this->Session->read('User.gtUsername')?>. It appears that you have not yet created a JacketPages account. Please create a JacketPages profile <?php echo $this->Html->link('here','/users/add')?>.</p>
					<?php 
					} 
					?>
				</div>
			<div class="roundedcornr_bottom"><div></div></div>
		</div>
	</div>
	<?php 
	} 
	?>
	
	
	<h3>Welcome to JacketPages!</h3>
	<p>JacketPages serves the student body at Georgia Tech by connecting students with student organizations and student organizations with your Student Government Association (SGA). This allows you to browse student organizations, to get involved, and, if you're already involved, to communicate your needs to SGA.
	<br><br>
	Once you're logged in with your Georgia Tech account, depending on your user profile, you can use the menus and toolbar to search organizations, research campus events (and add them to your own calendar), and interact with SGA's bill submission system.</p>
	<br>
	<!-- <h3>Announcements</h3>
	<img alt="Jacketpages Open House" src="http://jacketpages.gatech.edu/css/images/jacketpagesopenhouse.jpg" width="750px" />-->
	<h3>Upcoming Events</h3>
	<div id="agenda">
	<iframe src="https://www.google.com/calendar/embed?showTitle=0&amp;showNav=0&amp;showDate=0&amp;showPrint=0&amp;showTabs=0&amp;showCalendars=0&amp;showTz=0&amp;mode=AGENDA&amp;height=125&amp;wkst=1&amp;bgcolor=%23FFFFFF&amp;src=4sjikgsht1i1rch9e03atfe588%40group.calendar.google.com&amp;color=%23691426&amp;ctz=America%2FNew_York" style=" border-width:0 " width="780" height="300" frameborder="0" scrolling="no"></iframe>
	</div>
</div>
<br />
</div>
