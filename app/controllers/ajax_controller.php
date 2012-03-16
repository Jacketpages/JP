<?php
	class AjaxController extends AppController
	{
		var $uses = array(
				'User',
				'Organization'
		);
		var $layout = 'ajax';

		function name()
		{
			$this -> requireLevel('user');
			$input = mysql_real_escape_string($_REQUEST['term']);
			$p = $this -> User -> find('list', array(
					'limit' => 15,
					'recursive' => 0,
					'fields' => array(
							'User.name',
							'User.gtUsername'
					),
					'conditions' => array("or" => array(
								'User.name LIKE' => '%' . $input . '%',
								'User.gtUsername LIKE' => '%' . $input . '%'
						))
			));
			$options = array();
			while ($user = current($p))
			{
				$options[] = key($p);
				next($p);
			}
			$this -> view = 'Json';
			$this -> set('json', $options);
		}

		function userName()
		{
			$this -> requireLevel('user');
			$input = mysql_real_escape_string($_REQUEST['term']);
			$p = $this -> User -> find('all', array(
					'limit' => 15,
					'recursive' => 0,
					'fields' => array(
							'User.name',
							'User.id',
							'User.gtUsername',
							'User.email'
					),
					'conditions' => array("or" => array(
								'User.name LIKE' => '%' . $input . '%',
								'User.gtUsername LIKE' => '%' . $input . '%'
						))
			));
			$options = array();
			while ($user = current($p))
			{
				$options[] = array(
						'name' => $user['User']['name'],
						'gtUsername' => $user['User']['gtUsername'],
						'id' => $user['User']['id'],
						'email' => $user['User']['email']
				);
				next($p);
			}
			$this -> view = 'Json';
			$this -> set('json', $options);
		}

		function orgName()
		{
			$input = mysql_real_escape_string($_REQUEST['term']);
			$p = $this -> Organization -> find('all', array(
					'limit' => 15,
					'recursive' => 0,
					'fields' => array('DISTINCT Organization.name'),
					'conditions' => array("or" => array(
								'Organization.name LIKE' => '%' . $input . '%',
								'Organization.short_name LIKE' => '%' . $input . '%'
						))
			));
			$options = array();
			while ($org = current($p))
			{
				$options[] = $org['Organization']['name'];
				next($p);
			}
			$this -> view = 'Json';
			$this -> set('json', $options);
		}

	}
