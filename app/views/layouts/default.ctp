<?php
	/**
	 *
	 * PHP versions 4 and 5
	 *
	 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
	 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
	 *
	 * Licensed under The MIT License
	 * Redistributions of files must retain the above copyright notice.
	 *
	 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
	 * @link          http://cakephp.org CakePHP(tm) Project
	 * @package       cake
	 * @subpackage    cake.cake.libs.view.templates.layouts
	 * @since         CakePHP(tm) v 0.10.0.1076
	 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
	 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php echo $this -> Html -> charset();?>
		<title>JacketPages | <?php echo $title_for_layout;?></title>
		<script type="text/javascript">var wr = '<?php echo $this->webroot?>';</script>
		<?php
			echo $this -> Html -> meta('icon');
			echo $this -> Html -> css('style');
			echo $this -> Html -> css('ddsmoothmenu.css');
			echo $this -> Html -> css('print', 'stylesheet', array('media' => 'print'));
			echo $this -> Html -> css('ui-lightness/jquery-ui-1.8.14.custom.css');
			echo $this -> Html -> script('jquery-1.5.1.min.js');
			// Include jQuery library
			echo $this -> Html -> script('jquery-ui-1.8.14.custom.min.js');
			echo $this -> Html -> script('ddsmoothmenu.js');
			echo $this -> Html -> script('custom.js');
			echo $scripts_for_layout;
		?>
		<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
		<script>
			$(document).ready(function() {
				$("#tabs").tabs();
			});

		</script>
	</head>
	<body id="cas">
		<div id="header">
			<a href="/"><div id="logoWrapper"></div> </a>
			<div id="utilityBar">
				<div id="utilityBarWrapper" class="ddsmoothmenu">
					<ul>
						<li>
							<a href="#">My Account</a>
							<?php if(!$this->isLevel('student')){
							?>
							<ul>
								<li>
									<?php echo $this -> Html -> link(__('Login', true), array(
										'controller' => 'users',
										'action' => 'login'
									));
									?>
								</li>
							</ul>
						</li>
						<?php
							} else if ($this->isLevel('user')) {
						?>
						<ul>
							<li>
								<?php echo $this -> Html -> link('Account Profile', array(
									'owner' => true,
									'controller' => 'users',
									'action' => 'view',
									$this -> Session -> read('User.id')
								));
								?>
							</li>
							<li>
								<?php echo $this -> Html -> link('Logout', array(
									'admin' => false,
									'controller' => 'users',
									'action' => 'logout'
								));
								?>
							</li>
							<li>
								<?php echo $this -> Html -> link('JacketPages Home', '/');?>
							</li>
						</ul>
						</li>
						<li>
							<a href="#">Bills</a>
							<ul>
								<li>
									<?php echo $this -> Html -> link('Submit Bill', array(
										'admin' => false,
										'controller' => 'bills',
										'action' => 'add'
									));
									?>
								</li>
								<li>
									<?php echo $this -> Html -> link('View My Bills', array(
										'owner' => true,
										'controller' => 'bills',
										'action' => 'index'
									));
									?>
								</li>
								<li>
									<?php echo $this -> Html -> link('View All Bills', array(
										'controller' => 'bills',
										'action' => 'index','All'
									));
									?>
								</li>
							</ul>
						</li>
						<?php
							} else {
						?>
						<ul>
							<li>
								<?php echo $this -> Html -> link('Account Profile', array(
									'owner' => true,
									'controller' => 'users',
									'action' => 'view',
									$this -> Session -> read('User.id')
								));
								?>
							</li>
							<li>
								<?php echo $this -> Html -> link('Logout', array(
									'admin' => false,
									'controller' => 'users',
									'action' => 'logout'
								));
								?>
							</li>
							<li>
								<?php echo $this -> Html -> link('JacketPages Home', '/');?>
							</li>
						</ul>
						</li> <?php
							}
						?>
						<li>
							<a href="#">Organizations</a>
							<ul>
								<li>
									<?php echo $this->Html->link('View All Organizations', array('admin' => false, 'controller' => 'organizations', 'action' => 'index'))
									?>
								</li>
								<?php if($this->isLevel('user')) {
								?>
								<li>
									<?php echo $this->Html->link('My Organizations', array('owner' => true, 'controller' => 'organizations', 'action' => 'index'))
									?>
								</li>
								<?php
									}
								?>
							</ul>
						</li>
						</li>
						<li>
							<a href="#">Student Government</a>
							<ul>
								<?php if($this->isLevel('power')) {
								?>
								<li>
									<?php echo $this -> Html -> link('View My Bills', array(
										'owner' => true,
										'controller' => 'bills',
										'action' => 'index'
									));
									?>
								</li>
								<li>
									<?php echo $this -> Html -> link('View All Bills', array(
										'admin' => false,
										'controller' => 'bills',
										'action' => 'index'
									));
									?>
								</li>
								<li>
									<?php
										if ($this -> isLevel('admin'))
										{
											echo $this -> Html -> link('View Bills on Agenda', array(
												'controller' => 'bills',
												'action' => 'index',
												'Agenda',
												'admin' => true
											));
										}
										else
										if ($this -> isLevel('power'))
										{
											echo $this -> Html -> link('View Bills on Agenda', array(
												'controller' => 'bills',
												'action' => 'index',
												'Agenda',
												'power' => true
											));
										}
									?>
								</li>
								<?php
									}
								?>
								<?php if($this->isLevel('admin')) {
								?>
								<li>
									<?php echo $this -> Html -> link('View Budgets', array(
										'controller' => 'budgets',
										'action' => 'index',
										'admin' => true
									));
									?>
								</li>
								<?php
									}
								?>
								<li>
									<?php echo $this -> Html -> link('View SGA Members', array(
										'admin' => false,
										'controller' => 'sga_people',
										'action' => 'index'
									));
									?>
								</li>
							</ul>
						</li>
						<?php if($this->isLevel('admin')) {
						?>
						<li>
							<a href="#">Administration</a>
							<ul>
								<li>
									<?php echo $this -> Html -> link('Administer All Bills', array(
										'admin' => true,
										'controller' => 'bills',
										'action' => 'index'
									));
									?>
								</li>
								<li>
									<?php echo $this -> Html -> link('Administer SGA Members', array(
										'admin' => true,
										'controller' => 'sga_people',
										'action' => 'index'
									));
									?>
								</li>
								<li>
									<?php echo $this -> Html -> link('Administer Users', array(
										'admin' => true,
										'controller' => 'users',
										'action' => 'index'
									));
									?>
								</li>
								<li>
									<?php echo $this->Html->link('Administer Organizations', array('controller' => 'organizations', 'action' => 'index', 'admin' => true))
									?>
								</li>
								<li>
									<?php echo $this->Html->link('Login as Other User', array('admin' => true, 'controller' => 'users', 'action' => 'login'))
									?>
								</li>
								<li>
									<?php echo $this->Html->link('Submit Bill as Other User', array('admin' => true, 'controller' => 'bills', 'action' => 'add'))
									?>
								</li>
								<li>
									<?php echo $this->Html->link('Post Message', '/pages/message')
									?>
								</li>
							</ul>
						</li>
						<?php
							}
						?>
					</ul>
				</div>
			</div>
			<div id="breadcrumb">
				<div id="breadcrumbWrapper">
					<div id="left">
						<?php echo $this -> Html -> getCrumbs(' > ', 'Home');?>
					</div>
					<div id="right">
						<?php if (!(strlen($msg = $this->Session->flash()) > 0)) {
if(!$this->isLevel('student')) {
						?>
						<p>
							Welcome, guest. Please login <?php echo $this -> Html -> link(__('here', true), array(
								'controller' => 'users',
								'action' => 'login'
							));
							?>.
						</p>
						<?php
							} else if (!$this->isLevel('user')) {
						?>
						<p>
							Welcome, <?php echo $this->Session->read('User.gtUsername')
							?>.
							Please create a profile <?php echo $this->Html->link('here','/users/add')
							?>.
						</p>
						<?php
							} else {
						?>
						<p>
							Welcome, <?php echo $this->Session->read('User.name')
							?>.
						</p>
						<?php
							}
							} else {
						?>
						<b><?php echo $msg;
							}
						?></b>
					</div>
				</div>
			</div>
		</div>
		<div id="allcontent">
			<div id="content">
				<?php echo $this->Session->flash('email')
				?>

				<?php echo $content_for_layout;?>
			</div>
		</div>
		<div id="footerContent">
			<p>
				<?php echo date('Y');?>
				Georgia Tech Student Government Association
			</p>
		</div>
	</body>
</html>
