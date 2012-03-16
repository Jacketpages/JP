<?php
	App::import('Vendor', 'cas', array('file' => 'CAS-1.2.0' . DS . 'CAS.php'));
	class UsersController extends AppController
	{
		var $name = 'Users';

		function beforeFilter()
		{
			parent::beforeFilter();
		}

		function owner_view($id = null)
		{
			$this -> requireUser(array($id));
			$user = $this -> User -> read(null, $id);
			/**if(!isset($user['User']['id'])){
			 $this->log("New user $id intialized",'security');
			 $this->User->id = $id;
			 $this->User->save();
			 $user = $this->User->read(null, $id);
			 */
			$this -> setOrganizations($user);
			$this -> set('user', $user);
		}

		function setOrganizations($user)
		{
			$orgs = array();
			foreach ($user ['Organizations'] as $o)
			{
				$orgs[] = $o['organization_id'];
			}
			if (sizeof($orgs) > 0)
			{
				$this -> loadModel('Organization');
				$organizations = $this -> Organization -> find('list', array(
						'fields' => array(
								'Organization.id',
								'Organization.name'
						),
						'conditions' => array(
								'Organization.id' => $orgs,
								'Organization.status' => 'Active'
						)
				));
				$this -> set('organizations', $organizations);
			}
			else
			{
				$this -> set('organizations', null);
			}
		}

		function owner_edit($id = null)
		{
			$this -> requireUser(array($id));
			$user = $this -> User -> read(null, $id);
			if (!$id && empty($this -> data))
			{
				$this -> Session -> setFlash(__('Invalid user.', true));
				$this -> redirect('/');
			}
			if (!empty($this -> data))
			{
				if ($this -> User -> save($this -> data))
				{
					$this -> Session -> setFlash(__('Profile has been saved.', true));
					$this -> redirect('/owner/users/view/' . $id);
				}
				else
				{
					$this -> Session -> setFlash(__('Profile could not be saved. Please try again.', true));
				}
			}
			if (empty($this -> data))
			{
				$this -> data = $this -> User -> read(null, $id);
			}
			$this -> setOrganizations($user);
			$this -> set('user', $user);
		}

		function owner_delete($id = null)
		{
			$this -> requireUser(array($id));

			if ($this -> User -> delete($id))
			{
				$this -> Session -> setFlash(__('Profile deleted.', true));
				$this -> redirect(array('action' => 'add'));
			}
			else
			{
				$this -> Session -> setFlash(__('Profile was not deleted.', true));
			}
		}

		function login()
		{
			// Set debug mode
			phpCAS::setDebug();
			//Initialize phpCAS
			phpCAS::client(CAS_VERSION_2_0, Configure::read('CAS.hostname'), Configure::read('CAS.port'), Configure::read('CAS.uri'), false);
			// No SSL validation for the CAS server
			phpCAS::setNoCasServerValidation();
			// Force CAS authentication if required
			phpCAS::forceAuthentication();
			$gtUsername = phpCAS::getUser();
			if ($gtUsername != '')
			{
				$this -> Session -> write('User.level', 'student');
				$user = $this -> User -> find('first', array(
						'recursive' => -1,
						'conditions' => array('User.gtUsername' => $gtUsername)
				));
				$sga = $this -> User -> SgaPerson -> find('first', array(
						'recursive' => -1,
						'conditions' => array('SgaPerson.user_id' => $user['User']['id'])
				));
				if ($user['User']['level'] != "")
				{
					$this -> Session -> write('User.level', $user['User']['level']);
					$this -> Session -> write('User.name', $user['User']['name']);
					$this -> Session -> write('User.id', $user['User']['id']);
					$this -> Session -> write('User.gtUsername', $user['User']['gtUsername']);
					$this -> Session -> write('User.phone', $user['User']['phone']);
					$this -> Session -> write('User.email', $user['User']['email']);
				}
				else
				{
					$this -> Session -> write('User.gtUsername', $gtUsername);
				}
				if ($sga != null && $sga['SgaPerson']['house'] != '')
				{
					$this -> Session -> write('SgaPerson.house', $sga['SgaPerson']['house']);
					$this -> Session -> write('SgaPerson.id', $sga['SgaPerson']['id']);
				}
				$this -> redirect(array(
						'controller' => 'pages',
						'action' => 'home'
				));
			}
		}

		function admin_login($gtUsername = null)
		{
			// Commenting out this next line lets you login as an admin on your localhost
			// by going to localhost/JP/admin/users/login
			// $this->requireLevel('admin');
			if (!empty($this -> data))
			{
				$gtUsername = $this -> data['User']['gtUsername'];
			}
			if ($gtUsername != '')
			{
				$user = $this -> User -> find('first', array(
						'recursive' => -1,
						'conditions' => array('User.gtUsername' => $gtUsername)
				));
				$sga = $this -> User -> SgaPerson -> find('first', array(
						'recursive' => -1,
						'conditions' => array('SgaPerson.user_id' => $user['User']['id'])
				));
				$this -> Session -> write('User.level', 'student');
				if ($user['User']['level'] != "")
				{
					$this -> Session -> write('User.level', $user['User']['level']);
				}
				$this -> Session -> write('User.name', $user['User']['name']);
				$this -> Session -> write('User.gtUsername', $gtUsername);
				$this -> Session -> write('User.id', $user['User']['id']);
				if ($user['User']['gtUsername'] != "")
					$this -> Session -> write('User.gtUsername', $user['User']['gtUsername']);

				$this -> Session -> write('User.phone', $user['User']['phone']);
				$this -> Session -> write('User.email', $user['User']['email']);

				if ($sga != null && $sga['SgaPerson']['house'] != '')
				{
					$this -> Session -> write('SgaPerson.house', $sga['SgaPerson']['house']);
					$this -> Session -> write('SgaPerson.user_id', $sga['SgaPerson']['user_id']);
				}
			}
		}

		function logout()
		{
			$this -> Session -> delete('User');
			$this -> Session -> delete('SgaPerson');
			phpCAS::client(CAS_VERSION_2_0, Configure::read('CAS.hostname'), Configure::read('CAS.port'), Configure::read('CAS.uri'), false);
			phpCAS::setNoCasServerValidation();
			if (phpCAS::isAuthenticated())
			{
				phpCAS::logout(array('url' => 'http://jacketpages.sga.gatech.edu'));
			}
			$this -> redirect('/');
		}

		function admin_index($letter = "")
		{
			$this -> requireLevel('admin');
			$this -> User -> recursive = 0;
			$users = $this -> paginate($this -> _filterUsers($letter));
			$this -> set('users', $users);
		}

		function admin_view($id = null)
		{
			$this -> requireLevel('admin');
			if (!$id)
			{
				$this -> Session -> setFlash(__('Invalid user.', true));
				$this -> redirect(array('action' => 'index'));
			}
			$user = $this -> User -> read(null, $id);
			$this -> setOrganizations($user);
			$this -> set('user', $user);
		}

		function add()
		{
			$this -> requireLevel('student');
			if (!empty($this -> data))
			{
				$this -> User -> create();
				$this -> User -> set('level', 'user');
				if ($this -> User -> save($this -> data))
				{
					$this -> Session -> setFlash(__('Profile has been saved.', true));
					$this -> Session -> write('User.id', $this -> User -> id);
					$this -> Session -> write('User.level', 'user');
					$this -> Session -> write('User.name', $this -> data['User']['name']);
					$this -> Session -> write('User.phone', $this -> data['User']['phone']);
					$this -> Session -> write('User.email', $this -> data['User']['email']);
					$this -> redirect(array(
							'controller' => 'pages',
							'action' => 'home'
					));
				}
				else
				{
					$this -> Session -> setFlash('Profile could not be saved. Please try again.');
				}
			}
		}

		function admin_add()
		{
			$this -> requireLevel('admin');
			if (!empty($this -> data))
			{
				$this -> User -> create();
				if ($this -> User -> save($this -> data))
				{
					$this -> Session -> setFlash(__('Profile has been saved', true));
					$this -> redirect(array(
							'action' => 'view',
							$this -> User -> id
					));
				}
				else
				{
					$this -> Session -> setFlash(__('Profile could not be saved. Please try again.', true));
				}
			}
		}

		function admin_edit($id = null)
		{
			$this -> requireLevel('admin');
			if (!$id && empty($this -> data))
			{
				$this -> Session -> setFlash(__('Invalid user.', true));
				$this -> redirect(array('action' => 'index'));
			}
			$user = $this -> User -> read(null, $id);
			$this -> set('user', $user);
			if (!empty($this -> data))
			{
				if ($this -> User -> save($this -> data))
				{
					$this -> Session -> setFlash(__('Profile has been saved.', true));
					$this -> redirect(array(
							'action' => 'view',
							$id
					));
				}
				else
				{
					$this -> Session -> setFlash(__('Profile could not be saved. Please try again.', true));
				}
			}
			if (empty($this -> data))
			{
				$this -> data = $this -> User -> read(null, $id);
			}
		}

		function admin_delete($id = null)
		{
			$this -> requireLevel('admin');
			if (!$id)
			{
				$this -> Session -> setFlash(__('Invalid id for user.', true));
				$this -> redirect(array('action' => 'index'));
			}
			if ($this -> User -> delete($id))
			{
				$this -> Session -> setFlash(__('Profile deleted.', true));
				$this -> redirect(array('action' => 'index'));
			}
			$this -> Session -> setFlash(__('Profile was not deleted', true));
			$this -> redirect(array('action' => 'index'));
		}

		function _filterUsers($letter)
		{
			if (!isset($this -> params['named']['page']))
			{
				$this -> Session -> delete($this -> name . '.keyword');
			}

			if (!empty($this -> data) && isset($this -> data['User']['keyword']))
			{
				if (strlen(trim($this -> data['User']['keyword'])) >= 2)
				{
					$search = mysql_real_escape_string($this -> data['User']['keyword']);
				}
			}
			elseif ($this -> Session -> check($this -> name . '.keyword'))
			{
				$search = mysql_real_escape_string($this -> Session -> read($this -> name . '.keyword'));
				$this -> data['User']['keyword'] = $this -> Session -> read($this -> name . '.keyword');
			}
			else
			{
				$search = "";
				$this -> data['User']['keyword'] = "";
			}

			$this -> Session -> write($this -> name . '.keyword', $search);
			$search = low($search);

			$filters = array();

			if ($letter == "all")
			{
				$letter = "";
			}

			$search = low($search);
			$filters = array("(lower(User.name) like '%" . $search . "%' or lower(User.gtUsername) like '%" . $search . "%') and lower(User.name) like '" . $letter . "%'");
			$this -> Session -> write($this -> name . '.keyword', $search);

			return $filters;
		}

	}
?>
