<?php
	App::import('Sanitize');
	/**
	 * Application level Controller
	 *
	 * This file is application-wide controller file. You can put all
	 * application-wide controller-related methods here.
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
	 * @subpackage    cake.cake.libs.controller
	 * @since         CakePHP(tm) v 0.2.9
	 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
	 */

	/**
	 * This is a placeholder class.
	 * Create the same file in app/app_controller.php
	 *
	 * Add your application-wide methods in the class below, your controllers
	 * will inherit them.
	 *
	 * @package       cake
	 * @subpackage    cake.cake.libs.controller
	 * @link http://book.cakephp.org/view/957/The-App-Controller
	 */
	class AppController extends Controller
	{
		var $components = array(
				'Session',
				'Email',
				'RequestHandler'
		);
		var $helpers = array(
				'Html',
				'Form',
				'Session',
				'Js',
				'Paginator'
		);
		function beforeFilter()
		{
			parent::beforeFilter();
			$this -> Security -> blackHoleCallback = 'blackhole';
		}

		function blackhole()
		{
			$this -> log('User: ' . $this -> getUser() . ' Controller: ' . $this -> name . ' Action: ' . $this -> action . ' blackhole', 'security');
			echo "<h1>Security Stop</h1><p>Tamper protection triggered</p>";
			exit();
		}

		function getLevel()
		{
			return $this -> Session -> read('User.level');
		}

		function isLevel($level)
		{
			$c = $this -> Session -> read('User.level');
			if ($level == 'student' && ($c == 'student' || $c == 'power' || $c == 'admin' || $c == 'user'))
				return true;
			if ($level == 'user' && ($c == 'power' || $c == 'admin' || $c == 'user'))
				return true;
			if ($level == 'power' && ($c == 'admin' || $c == 'power'))
				return true;
			if ($level == 'admin' && $c == 'admin')
				return true;
			return false;
		}

		function requireLevel($level)
		{
			if (!$this -> isLevel($level))
			{
				$this -> Session -> setFlash("Sorry, you do not have permission to view that page.");
				$this -> log('User: ' . $this -> getUser() . ' Controller: ' . $this -> name . ' Action: ' . $this -> action . ' requireLevel ' . $level . ' failed', 'security');
				$this -> redirect('/');
				return false;
			}
			return true;
		}

		function getUser()
		{
			return $this -> Session -> read('User.id');
		}

		function requireUser($valid)
		{
			$user = $this -> getUser();
			if (in_array($user, $valid))
				return true;
			$this -> Session -> setFlash("Sorry, you do not have ownership of that item to perform that operation.");
			$this -> log('User: ' . $this -> getUser() . ' Controller: ' . $this -> name . ' Action: ' . $this -> action . ' requireUser failed', 'security');
			$this -> redirect('/');
		}

		function getValidNumber($category)
		{
			$this -> loadModel('Bill');
			$number = $this -> getFiscalYear() + 1;
			if ($category == 'Undergraduate')
				$number .= 'U';
			if ($category == 'Graduate')
				$number .= 'G';
			if ($category == 'Joint')
				$number .= 'J';
			if ($category == 'Budget')
				$number .= 'B';
			$sql = "SELECT substr(number,4) as num FROM bills WHERE substr(number,1,3) = '$number' ORDER BY num DESC LIMIT 1";
			$num = $this -> Bill -> query($sql);
			if (empty($num))
			{
				$num = 1;
			}
			else
			{
				$num = $num[0][0]['num'] + 1;
			}
			$num = str_pad($num, 3, '0', STR_PAD_LEFT);
			$number .= $num;
			return $number;
		}

		function getFiscalYear()
		{
			return substr($this -> calculateFiscalYearForDate(date('n/d/y')), -2);
		}

		function calculateFiscalYearForDate($inputDate, $fyStart = "6/1/", $fyEnd = "5/31/")
		{
			$date = strtotime($inputDate);
			$inputyear = strftime('%y', $date);

			$startdate = strtotime($fyStart . $inputyear);
			$enddate = strtotime($fyEnd . $inputyear);

			if ($date > $startdate)
			{
				$fy = intval($inputyear);
			}
			else
			{
				$fy = intval(intval($inputyear) - 1);
			}
			return $fy;
		}

		function checkIfCurrentYear($inputDate)
		{
			return (getFiscalYear() == calculateFiscalYearForDate($inputDate));
		}

		function getFiscalStartDate($format = "Y-m-d", $fyStart = "6/1/")
		{
			return date($format, strtotime($fyStart . $this -> getFiscalYear()));
		}

		function getFiscalStart($fy, $format = "Y-m-d", $fyStart = "6/1/")
		{
			return date($format, strtotime($fyStart . $fy));
		}

	}
