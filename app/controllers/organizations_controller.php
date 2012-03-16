<?php

	class OrganizationsController extends AppController
	{

		var $name = 'Organizations';

		var $helpers = array(
				'Html',
				'Form',
				'Session',
				'Js',
				'Paginator',
				'Csv'
		);

		function index($letter = "")
		{
			$this -> Organization -> recursive = 0;
			$this -> paginate['fields'] = array(
					'DISTINCT name',
					'description',
					'logo_name'
			);
			$this -> set('organizations', $this -> paginate(array("and" => array(
						'Organization.status' => 'Active',
						$this -> _filterOrganizations($letter)
				))));
		}

		function owner_index()
		{
			$this -> requireLevel('user');
			$this -> loadModel('User');
			$id = $this -> getUser();
			$user = $this -> User -> read(null, $id);
			$this -> Organization -> recursive = 0;
			$this -> loadModel('Membership');
			$ids = $this -> Membership -> find('all', array(
					'fields' => array('Membership.organization_id'),
					'recursive' => -1,
					'conditions' => array(
							'Membership.user_id' => $this -> getUser(),
							'Membership.status' => 'Active'
					)
			));
			$this -> set('organizations', $this -> Organization -> find('list', array(
					'fields' => array(
							'Organization.id',
							'Organization.name'
					),
					'conditions' => ( array("and" => array(
								'Organization.id' => Set::extract('/Membership/organization_id', $ids),
								'Organization.status' => 'Active'
						)))
			)));
			$this -> set('user', $user);
		}

		function admin_index($letter = "")
		{
			$this -> requireLevel('admin');
			$this -> Organization -> recursive = 0;
			$this -> paginate['fields'] = array(
					'DISTINCT name',
					'description',
					'logo_name'
			);
			$this -> set('organizations', $this -> paginate($this -> _filterOrganizations($letter)));
		}

		function view($id = null)
		{
			if (!$id)
			{
				$this -> Session -> setFlash(__('Invalid organization.', true));
				$this -> redirect(array('action' => 'index'));
			}
			$org = $this -> Organization -> read(null, $id);
			if (($org['Organization']['status'] != 'Active') && !$this -> isLevel('admin'))
			{
				$this -> Session -> setFlash(__('Invalid organization.', true));
				$this -> redirect(array('action' => 'index'));
			}
			$isMember = ($this -> _isMember($id) || $this -> _isOfficer($id));
			$isOfficer = $this -> _isOfficer($id);
			$this -> set('isMember', $isMember);
			$this -> set('isOfficer', $isOfficer);

			if ($this -> isLevel('admin'))
			{
				$this -> redirect(array(
						'action' => 'view',
						$id,
						'admin' => true
				));
			}
			else
			if ($isOfficer)
			{
				$this -> redirect(array(
						'action' => 'view',
						$id,
						'officer' => true
				));
			}
			else
			if ($isMember)
			{
				$this -> redirect(array(
						'action' => 'view',
						$id,
						'owner' => true
				));
			}
			$this -> setUsers($org);
			$this -> set('organization', $org);
		}

		function export()
		{
			$this -> requireLevel('power');
			if ($fy == null)
				$fy = $this -> getFiscalYear();
			$orgs = $this -> Organization -> find('all', array(
					'fields' => array(
							'Organization.id',
							'Organization.name',
							'Organization.status',
							'Organization.organization_contact',
							'Organization.organization_contact_campus_email'
					),
					'recursive' => 0
			));
			$orgList = array();
			foreach ($orgs as $org)
			{
				$tempOrg = $this -> Organization -> read(null, $org['Organization']['id']);
				array_push($orgList, array(
						"Organization" => $org,
						"Members" => $this -> setUsers($tempOrg)
				));
			}
			$this -> set('organizations', $orgList);
			$this -> set('fy', $fy);
			$this -> layout = 'csv';
		}

		function setUsers($org)
		{
			$users = array();
			$usrs = array();
			$prsdts = array();
			$trsrs = array();
			$offcrs = array();
			$advsrs = array();
			$rmrsvrs = array();
			$memrs = array();
			$pnd = array();
			$officers = array();
			$presidents = array();
			$treasurers = array();
			$advisors = array();
			$reservers = array();
			$members = array();
			$pending = array();
			$president_title = array();
			$treasurer_title = array();
			$officer_title = array();
			$advisor_title = array();

			$id = $org['Organization']['id'];
			$this -> set('id', $id);
			$this -> loadModel('Membership');

			foreach ($org ['Member'] as $o)
			{
				if ($o['status'] == 'Active' && strtotime($o['since']) >= strtotime($this -> getFiscalStartDate()))
				{
					$usrs[] = $o['user_id'];
					$memrs[] = $o['user_id'];
				}
				else
				if ($o['status'] == 'Pending' && strtotime($o['since']) >= strtotime($this -> getFiscalStartDate()))
				{
					$usrs[] = $o['user_id'];
					$pnd[] = $o['user_id'];
				}
			}
			$memberships = $this -> Membership -> find('list', array(
					'fields' => array(
							'Membership.user_id',
							'Membership.id',
							'Membership.organization_id'
					),
					'conditions' => array(
							'Membership.organization_id' => $id,
							'Membership.role' => 'Member'
					)
			));
			$this -> set('memberships', $memberships);

			$recent = current($org['President']);
			$count = 0;
			foreach ($org ['President'] as $o)
			{
				if ((strtotime($o['since']) > strtotime($recent['since'])))
				{
					$recent = $o;
				}
				if (strtotime($o['since']) >= strtotime($this -> getFiscalStartDate()))
				{
					$usrs[] = $o['user_id'];
					$prsdts[] = $o['user_id'];
					if (!array_key_exists($o['user_id'], $president_title))
					{
						$president_title[$o['user_id']] = $o['title'];
					}
					$count++;
				}
			}
			if ($count == 0 && !array_key_exists($recent['user_id'], $president_title))
			{
				$prsdts[] = $recent['user_id'];
				if (!array_key_exists($recent['user_id'], $president_title))
				{
					$president_title[$recent['user_id']] = $recent['title'];
				}
			}
			$president_memberships = $this -> Membership -> find('list', array(
					'fields' => array(
							'Membership.user_id',
							'Membership.id',
							'Membership.organization_id'
					),
					'conditions' => array(
							'Membership.organization_id' => $id,
							'Membership.role' => 'President'
					)
			));
			$this -> set('president_memberships', $president_memberships);

			$recent = current($org['Treasurer']);
			$count = 0;
			foreach ($org ['Treasurer'] as $o)
			{
				if ((strtotime($o['since']) > strtotime($recent['since'])))
				{
					$recent = $o;
				}
				if (strtotime($o['since']) >= strtotime($this -> getFiscalStartDate()))
				{
					$usrs[] = $o['user_id'];
					$trsrs[] = $o['user_id'];
					if (!array_key_exists($o['user_id'], $treasurer_title))
					{
						$treasurer_title[$o['user_id']] = $o['title'];
					}
					$count++;
				}
			}
			if ($count == 0 && !array_key_exists($recent['user_id'], $treasurer_title))
			{
				$trsrs[] = $recent['user_id'];
				if (!array_key_exists($recent['user_id'], $treasurer_title))
				{
					$treasurer_title[$recent['user_id']] = $recent['title'];
				}
			}
			$treasurer_memberships = $this -> Membership -> find('list', array(
					'fields' => array(
							'Membership.user_id',
							'Membership.id',
							'Membership.organization_id'
					),
					'conditions' => array(
							'Membership.organization_id' => $id,
							'Membership.role' => 'Treasurer'
					)
			));
			$this -> set('treasurer_memberships', $treasurer_memberships);

			$recent = current($org['Officer']);
			$count = 0;
			foreach ($org ['Officer'] as $o)
			{
				if ((strtotime($o['since']) > strtotime($recent['since'])))
				{
					$recent = $o;
				}
				if (strtotime($o['since']) >= strtotime($this -> getFiscalStartDate()))
				{
					$usrs[] = $o['user_id'];
					$offcrs[] = $o['user_id'];
					if (!array_key_exists($o['user_id'], $officer_title))
					{
						$officer_title[$o['user_id']] = $o['title'];
					}
					$count++;
				}
			}
			if ($count == 0 && !array_key_exists($recent['user_id'], $officer_title))
			{
				$offcrs[] = $recent['user_id'];
				if (!array_key_exists($recent['user_id'], $officer_title))
				{
					$officer_title[$recent['user_id']] = $recent['title'];
				}
			}
			$officer_memberships = $this -> Membership -> find('list', array(
					'fields' => array(
							'Membership.user_id',
							'Membership.id',
							'Membership.organization_id'
					),
					'conditions' => array(
							'Membership.organization_id' => $id,
							'Membership.role' => 'Officer'
					)
			));
			$this -> set('officer_memberships', $officer_memberships);

			/*So this is saying that you can only have one room reserve I believe since it's sorting on 'since' time*/
			$recent = current($org['RoomReserver']);
			$count = 0;
			foreach ($org ['RoomReserver'] as $o)
			{
				if ((strtotime($o['since']) > strtotime($recent['since'])))
				{
					$recent = $o;
				}
				if (strtotime($o['since']) >= strtotime($this -> getFiscalStartDate()))
				{
					$usrs[] = $o['user_id'];
					$rmrsvrs[] = $o['user_id'];
					$count++;
				}
			}
			if ($count == 0)
			{
				$rmrsvrs[] = $recent['user_id'];
			}
			$reservers_memberships = $this -> Membership -> find('list', array(
					'fields' => array(
							'Membership.user_id',
							'Membership.id',
							'Membership.organization_id'
					),
					'conditions' => array(
							'Membership.organization_id' => $id,
							'Membership.role' => 'Room Reserver'
					)
			));
			$this -> set('reservers_memberships', $reservers_memberships);

			$recent = current($org['Advisor']);
			$count = 0;
			foreach ($org ['Advisor'] as $o)
			{
				if ((strtotime($o['since']) > strtotime($recent['since'])) && !array_key_exists($o['user_id'], $advisor_title))
				{
					$recent = $o;
				}
				if (strtotime($o['since']) >= strtotime($this -> getFiscalStartDate()))
				{
					$advsrs[] = $o['user_id'];
					$advisor_title[$o['user_id']] = $o['title'];
					$count++;
				}
			}
			if ($count == 0 && !array_key_exists($recent['user_id'], $advisor_title))
			{
				$advsrs[] = $recent['user_id'];
				$advisor_title[$recent['user_id']] = $recent['title'];
			}
			$advisor_memberships = $this -> Membership -> find('list', array(
					'fields' => array(
							'Membership.user_id',
							'Membership.id',
							'Membership.organization_id'
					),
					'conditions' => array(
							'Membership.organization_id' => $id,
							'Membership.role' => 'Advisor'
					)
			));
			$this -> set('advisor_memberships', $advisor_memberships);

			$this -> set('president_title', $president_title);
			$this -> set('treasurer_title', $treasurer_title);
			$this -> set('officer_title', $officer_title);
			$this -> set('advisor_title', $advisor_title);

			if (sizeof($usrs) > 0)
			{
				$this -> loadModel('User');
				$users = $this -> User -> find('all', array(
						'conditions' => array('User.id' => $usrs),
						'recursive' => 0
				));
				$this -> set('users', $users);
			}
			else
			{
				$this -> set('users', array());
			}
			if (sizeof($offcrs) > 0)
			{
				$this -> loadModel('User');
				$officers = $this -> User -> find('all', array(
						'conditions' => array('User.id' => $offcrs),
						'recursive' => 0
				));
				$this -> set('officers', $officers);
			}
			else
			{
				$this -> set('officers', array());
			}
			if (sizeof($rmrsvrs) > 0)
			{
				$this -> loadModel('User');
				$reservers = $this -> User -> find('all', array(
						'conditions' => array('User.id' => $rmrsvrs),
						'recursive' => 0
				));
				$this -> set('reservers', $reservers);
			}
			else
			{
				$this -> set('reservers', array());
			}
			if (sizeof($advsrs) > 0)
			{
				$this -> loadModel('User');
				$advisors = $this -> User -> find('all', array(
						'conditions' => array('User.id' => $advsrs),
						'recursive' => 0
				));
				$this -> set('advisors', $advisors);
			}
			else
			{
				$this -> set('advisors', array());
			}
			if (sizeof($trsrs) > 0)
			{
				$this -> loadModel('User');
				$treasurers = $this -> User -> find('all', array(
						'conditions' => array('User.id' => $trsrs),
						'recursive' => 0
				));
				$this -> set('treasurers', $treasurers);
			}
			else
			{
				$this -> set('treasurers', array());
			}
			if (sizeof($prsdts) > 0)
			{
				$this -> loadModel('User');
				$presidents = $this -> User -> find('all', array(
						'conditions' => array('User.id' => $prsdts),
						'recursive' => 0
				));
				$this -> set('presidents', $presidents);
			}
			else
			{
				$this -> set('presidents', array());
			}
			if (sizeof($memrs) > 0)
			{
				$this -> loadModel('User');
				$members = $this -> User -> find('all', array(
						'conditions' => array('User.id' => $memrs),
						'recursive' => 0
				));
				$this -> set('members', $members);
			}
			else
			{
				$this -> set('members', array());
			}
			if (sizeof($pnd) > 0)
			{
				$this -> loadModel('User');
				$pending = $this -> User -> find('all', array(
						'conditions' => array('User.id' => $pnd),
						'recursive' => 0
				));
				$this -> set('pending', $pending);
			}
			else
			{
				$this -> set('pending', array());
			}
			return array(
					'members' => $members,
					'presidents' => $presidents,
					'treasurers' => $treasurers,
					'officers' => $officers,
					'advisors' => $advisors
			);
		}

		function admin_view($id = null)
		{
			$this -> requireLevel('admin');
			$org = $this -> Organization -> read(null, $id);
			$this -> setUsers($org);
			$this -> set('organization', $org);
			$this -> set('isOfficer', $this -> _isOfficer($id));
			$this -> set('isMember', $this -> _isMember($id) || $this -> _isOfficer($id));
		}

		function owner_view($id = null)
		{
			if ($this -> isLevel('admin'))
			{
				$this -> redirect(array(
						'action' => 'view',
						$id,
						'admin' => true
				));
			}
			else
			if ($this -> _isOfficer($id))
			{
				$this -> redirect(array(
						'action' => 'view',
						$id,
						'officer' => true
				));
			}

			if (!$id)
			{
				$this -> Session -> setFlash(__('Invalid organization.', true));
				$this -> redirect(array('action' => 'index'));
			}
			$org = $this -> Organization -> read(null, $id);
			if ($org['Organization']['status'] != 'Active' && !$this -> isLevel('admin'))
			{
				$this -> Session -> setFlash(__('Invalid organization.', true));
				$this -> redirect(array('action' => 'index'));
			}
			if (!$this -> isLevel('admin') && !$this -> _isMember($id))
			{
				$this -> Session -> setFlash(__('You are not a member of this organization.', true));
				$this -> redirect(array(
						'action' => 'view',
						$id,
						'owner' => false,
						'admin' => false,
						'officer' => false
				));
			}
			$this -> setUsers($org);
			$this -> set('organization', $org);
			$isMember = ($this -> _isMember($id) || $this -> _isOfficer($id));
			$isOfficer = $this -> _isOfficer($id);
			$this -> set('isMember', $isMember);
			$this -> set('isOfficer', $isOfficer);
		}

		function officer_view($id = null)
		{
			if ($this -> isLevel('admin'))
			{
				$this -> redirect(array(
						'action' => 'view',
						$id,
						'admin' => true
				));
			}
			if (!$id)
			{
				$this -> Session -> setFlash(__('Invalid organization.', true));
				$this -> redirect(array('action' => 'index'));
			}
			$org = $this -> Organization -> read(null, $id);
			if ($org['Organization']['status'] != 'Active' && !$this -> isLevel('admin'))
			{
				$this -> Session -> setFlash(__('Invalid organization.', true));
				$this -> redirect(array('action' => 'index'));
			}
			if (!$this -> isLevel('admin') && !$this -> _isOfficer($id))
			{
				$this -> Session -> setFlash(__('You are not an officer of this organization.', true));
				$this -> redirect(array(
						'action' => 'view',
						$id,
						'owner' => false
				));
			}
			$this -> setUsers($org);
			$this -> set('organization', $org);
			$this -> set('isOfficer', $this -> _isOfficer($id));
			$this -> set('isMember', $this -> _isMember($id) || $this -> _isOfficer($id));
		}

		function owner_leave($id = null)
		{
			if (!$id)
			{
				$this -> Session -> setFlash(__('Invalid organization.', true));
				$this -> redirect(array('action' => 'index'));
			}
			$org = $this -> Organization -> read(null, $id);
			if ($org['Organization']['status'] != 'Active' && !$this -> isLevel('admin'))
			{
				$this -> Session -> setFlash(__('Invalid organization.', true));
				$this -> redirect(array('action' => 'index'));
			}
			if (!$this -> isLevel('admin') && !$this -> _isMember($id))
			{
				$this -> Session -> setFlash(__('You are not a member of this organization.', true));
				$this -> redirect(array(
						'action' => 'view',
						$id,
						'owner' => false
				));
			}
			$this -> loadModel('Membership');
			$user_id = $this -> getUser();
			$memberships = $this -> Membership -> find('list', array(
					'fields' => 'Membership.id, Membership.user_id',
					'conditions' => array("and" => array(
								'user_id' => $user_id,
								'organization_id' => $id
						))
			));
			foreach ($memberships as $membership)
			{
				$membership = each($memberships);
				$this -> Membership -> delete($membership['key']);
			}
			$this -> redirect(array(
					'action' => 'index',
					'owner' => true
			));
		}

		function admin_add()
		{
			$this -> requireLevel('admin');
			if (!empty($this -> data))
			{
				$this -> Organization -> create();
				if ($this -> Organization -> save($this -> data))
				{
					$this -> Organization -> Category -> create();
					$this -> Organization -> Category -> set('organization_id', $this -> Organization -> id);
					$this -> Organization -> Category -> set('category', $this -> data['Organization']['category']);
					if ($this -> Organization -> Category -> save())
					{
						$this -> Session -> setFlash(__('The organization has been saved.', true));
						$this -> redirect(array(
								'action' => 'view',
								$this -> Organization -> id
						));
					}
				}
				else
				{
					$this -> Session -> setFlash(__('The organization could not be saved. Please try again.', true));
				}
			}
		}

		function admin_edit($id = null)
		{
			$this -> requireLevel('admin');
			if (!$id && empty($this -> data))
			{
				$this -> Session -> setFlash(__('Invalid organization.', true));
				$this -> redirect(array('action' => 'index'));
			}
			if (!empty($this -> data))
			{
				if ($this -> Organization -> save($this -> data))
				{
					$this -> Session -> setFlash(__('The organization has been saved.', true));
					$this -> redirect(array(
							'action' => 'view',
							$id
					));
				}
				else
				{
					$this -> Session -> setFlash(__('The organization could not be saved. Please try again.', true));
				}
			}
			if (empty($this -> data))
			{
				$this -> data = $this -> Organization -> read(null, $id);
				$cat = $this -> Organization -> Category -> find('first', array(
						'fields' => array('Category.category'),
						'recursive' => -1,
						'conditions' => array("Category.organization_id" => $id)
				));
				if (!isset($cat['Category']['category']))
				{
					$cat['Category']['category'] = 'None';
				}
				$this -> data['Organization']['category'] = $cat['Category']['category'];
				$org = $this -> Organization -> read(null, $id);
				$this -> setUsers($org);
				$this -> set('organization', $org);
				$this -> set('isOfficer', $this -> _isOfficer($id));
				$this -> set('isMember', $this -> _isMember($id) || $this -> _isOfficer($id));
			}
		}

		function admin_delete($id = null)
		{
			$this -> requireLevel('admin');
			if (!$id)
			{
				$this -> Session -> setFlash(__('Invalid ID for organization.', true));
				$this -> redirect(array('action' => 'index'));
			}
			if ($this -> Organization -> delete($id))
			{
				$this -> Session -> setFlash(__('Organization deleted.', true));
				$this -> redirect(array('action' => 'index'));
			}
			$this -> Session -> setFlash(__('Organization was not deleted.', true));
			$this -> redirect(array('action' => 'index'));
		}

		function _filterOrganizations($letter)
		{
			if (!isset($this -> params['named']['page']))
			{
				$this -> Session -> delete($this -> name . '.keyword');
				$this -> Session -> delete($this -> name . '.category');
			}

			$search = "";
			if (!empty($this -> data) && isset($this -> data['Organization']['keyword']))
			{
				if (strlen(trim($this -> data['Organization']['keyword'])) >= 2)
				{
					$search = mysql_real_escape_string($this -> data['Organization']['keyword']);

					//Clean out html
				}
			}
			elseif ($this -> Session -> check($this -> name . '.keyword'))
			{
				$search = mysql_real_escape_string($this -> Session -> read($this -> name . '.keyword'));
			}

			$this -> Session -> write($this -> name . '.keyword', $search);
			$this -> set('search', $search);
			$search = low($search);

			$filters = array();

			if ($letter == "all")
			{
				$letter = "";
			}

			$this -> set('cat', 'all');
			if (!empty($this -> data) && isset($this -> data['Organization']['category']))
			{
				$cat = $this -> data['Organization']['category'];
				$this -> set('cat', $cat);
				if ($cat == "all")
				{
					$cat = "";
				}
			}
			else
			if ($this -> Session -> check($this -> name . '.category'))
			{
				$cat = $this -> Session -> read($this -> name . '.category');
				$this -> set('cat', $cat);
			}
			else
			{
				$cat = "";
			}

			$this -> Session -> write($this -> name . '.category', $cat);

			if ($cat != "")
			{
				$ids = $this -> Organization -> Category -> find('all', array(
						'fields' => array('Category.organization_id'),
						'recursive' => -1,
						'conditions' => array("Category.category like '%" . $cat . "%'")
				));
				$filters = array(
						"(lower(Organization.name) like '%" . $search . "%' or lower(Organization.type) like '%" . $search . "%' or lower(Organization.description) like '%" . $search . "%' or lower(Organization.short_name) like '%" . $search . "%') and lower(Organization.name) like '" . $letter . "%'",
						'Organization.id' => Set::extract('/Category/organization_id', $ids)
				);
			}
			else
			{
				$filters = array("(lower(Organization.name) like '%" . $search . "%' or lower(Organization.type) like '%" . $search . "%' or lower(Organization.description) like '%" . $search . "%' or lower(Organization.short_name) like '%" . $search . "%') and lower(Organization.name) like '" . $letter . "%'");
			}

			//$filters = Sanitize::clean($filters, array('encode' => FALSE));
			return $filters;
		}

		function officer_edit($id = null)
		{
			if (!$id && empty($this -> data))
			{
				$this -> Session -> setFlash(__('Invalid organization.', true));
				$this -> redirect(array('action' => 'index'));
			}
			$org = $this -> Organization -> read(null, $id);
			if ($org['Organization']['status'] != 'Active' && !$this -> isLevel('admin'))
			{
				$this -> Session -> setFlash(__('Invalid organization', true));
				$this -> redirect(array('action' => 'index'));
			}
			if (!empty($this -> data))
			{
				if ($this -> Organization -> save($this -> data))
				{
					$this -> Session -> setFlash(__('The organization has been saved.', true));
					$this -> redirect(array(
							'action' => 'view',
							$id
					));
				}
				else
				{
					$this -> Session -> setFlash(__('The organization could not be saved. Please try again.', true));
				}
			}
			if (empty($this -> data))
			{
				if (!$this -> _isOfficer($id))
				{
					$this -> Session -> setFlash(__('You are not an officer of this organization.', true));
					$this -> redirect(array(
							'action' => 'view',
							$id
					));
				}
				$this -> data = $this -> Organization -> read(null, $id);
				$org = $this -> Organization -> read(null, $id);
				$this -> setUsers($org);
				$this -> set('organization', $org);
				$this -> set('isOfficer', $this -> _isOfficer($id));
				$this -> set('isMember', $this -> _isMember($id) || $this -> _isOfficer($id));
			}
		}

		function addlogo($id = null)
		{
			$org = $this -> Organization -> read(null, $id);
			if ($org['Organization']['status'] != 'Active' && !$this -> isLevel('admin'))
			{
				$this -> Session -> setFlash(__('Invalid organization', true));
				$this -> redirect(array('action' => 'index'));
			}
			if (!$id)
			{
				$this -> Session -> setFlash(__('Invalid organization.', true));
				$this -> redirect(array('action' => 'index'));
			}
			if (!$this -> isLevel('admin') && !$this -> _isOfficer($id))
			{
				$this -> Session -> setFlash(__('You are not an officer of this organization.', true));
				$this -> redirect(array(
						'action' => 'view',
						$id
				));
			}
			if (!empty($this -> data) && is_uploaded_file($this -> data['File']['image']['tmp_name']))
			{
				Configure::write('debug', 0);
				$fileData = fread(fopen($this -> data['File']['image']['tmp_name'], "r"), $this -> data['File']['image']['size']);
				$permitted = array(
						'image/gif',
						'image/jpeg',
						'image/pjpeg',
						'image/png'
				);
				$typeOK = false;
				foreach ($permitted as $type)
				{
					if ($type == $this -> data['File']['image']['type'])
					{
						$typeOK = true;
						break;
					}
				}
				if (!$typeOK)
				{
					$this -> Session -> setFlash(__('Invalid image type.', true));
					$this -> redirect('/organizations/addlogo/' . $id);
				}
				$this -> Organization -> set('logo_name', $this -> data['File']['image']['name']);
				$this -> Organization -> set('logo_type', $this -> data['File']['image']['type']);
				$this -> Organization -> set('logo_size', $this -> data['File']['image']['size']);
				$this -> Organization -> set('logo', $fileData);
				if ($this -> data['File']['image']['size'] > 20000)
				{
					$this -> Session -> setFlash(__('Image is too large.', true));
					$this -> redirect('/organizations/addlogo/' . $id);
				}
				if ($this -> Organization -> save())
				{
					$this -> Session -> setFlash(__('Logo uploaded.', true));
					$this -> redirect(array(
							'action' => 'view',
							$id
					));
					exit();
				}
				else
				{
					$this -> Session -> setFlash(__('Error in upload.', true));
					$this -> redirect(array(
							'action' => 'view',
							$id
					));
					exit();
				}
			}

			$this -> set('organization', $this -> Organization -> read(null, $id));
		}

		function getLogo($id)
		{
			$org = $this -> Organization -> read(null, $id);
			if ($org['Organization']['status'] == 'Frozen' || !$id)
			{
				$this -> Session -> setFlash(__('Invalid organization', true));
				$this -> redirect(array('action' => 'index'));
			}

			$this -> set('inpage', true);

			Configure::write('debug', 0);
			$file = $this -> Organization -> findById($id);
			$logo = array();
			$logo['name'] = $file['Organization']['logo_name'];
			$logo['type'] = $file['Organization']['logo_type'];
			$logo['data'] = $file['Organization']['logo'];

			if ($logo['data'] == null)
			{
				return false;
			}
			else
			{
				$this -> set('file', $logo);
				$this -> render('download', 'image');
				return true;
			}
		}

		function test($id = null)
		{
			$this -> set('id', $id);
		}

		function deletelogo($id = null)
		{
			$org = $this -> Organization -> read(null, $id);
			if ($org['Organization']['status'] == 'Frozen' || !$id)
			{
				$this -> Session -> setFlash(__('Invalid organization.', true));
				$this -> redirect(array('action' => 'index'));
			}
			if (!$this -> isLevel('admin') && !$this -> _isOfficer($id))
			{
				$this -> Session -> setFlash(__('You are not an officer of this organization.', true));
				$this -> redirect(array(
						'action' => 'view',
						$id
				));
			}
			$this -> Organization -> set('logo_name', null);
			$this -> Organization -> set('logo_type', null);
			$this -> Organization -> set('logo_size', null);
			$this -> Organization -> set('logo', null);
			$this -> Organization -> save();

			$this -> Session -> setFlash(__('Logo removed.', true));
			$this -> redirect(array(
					'action' => 'view',
					$id
			));
			exit();
		}

		function _getMyOfficerOrgs()
		{
			$this -> loadModel('Membership');
			$id = $this -> getUser();
			$orgs = $this -> Membership -> find('list', array(
					'fields' => 'Membership.organization_id',
					'conditions' => array("and" => array(
								'user_id' => $id,
								'role' => array(
										'Advisor',
										'Officer',
										'President',
										'Treasurer',
										'Room Reserver'
								),
								'status' => 'Active',
								'since >=' => $this -> getFiscalStartDate()
						))
			));
			return $orgs;
		}

		function _getMyMemberOrgs()
		{
			$this -> loadModel('Membership');
			$id = $this -> getUser();
			$orgs = $this -> Membership -> find('list', array(
					'fields' => 'Membership.organization_id',
					'conditions' => array("and" => array(
								'user_id' => $id,
								'role' => array(
										'Member',
										'Pending Member'
								),
								'status' => 'Active',
								'since >=' => $this -> getFiscalStartDate()
						))
			));
			return $orgs;
		}

		function _isOfficer($id = null)
		{
			$org = $this -> Organization -> read(null, $id);
			$officers = array();
			$officers = $this -> setUsers($org);
			$myId = $this -> getUser();
			foreach ($officers ['officers'] as $officer)
			{
				if ($officer['User']['id'] == $myId)
				{
					return true;
				}
			}
			foreach ($officers ['treasurers'] as $officer)
			{
				if ($officer['User']['id'] == $myId)
				{
					return true;
				}
			}
			foreach ($officers ['presidents'] as $officer)
			{
				if ($officer['User']['id'] == $myId)
				{
					return true;
				}
			}
			foreach ($officers ['advisors'] as $officer)
			{
				if ($officer['User']['id'] == $myId)
				{
					return true;
				}
			}
			return false;
		}

		function _isMember($id = null)
		{
			$org = $this -> Organization -> read(null, $id);
			$members = array();
			$members = $this -> setUsers($org);
			$myId = $this -> getUser();
			foreach ($members ['members'] as $member)
			{
				if ($member['User']['id'] == $myId)
				{
					return true;
				}
			}
			return (false || $this -> _isOfficer($id));
		}

		function join($id = null)
		{
			$this -> requireLevel('user');
			if (!$id)
			{
				$this -> Session -> setFlash(__('Invalid organization.', true));
				$this -> redirect(array('action' => 'index'));
			}
			$org = $this -> Organization -> read(null, $id);
			if ($org['Organization']['status'] != 'Active' && !$this -> isLevel('admin'))
			{
				$this -> Session -> setFlash(__('Invalid organization.', true));
				$this -> redirect(array('action' => 'index'));
			}
			if ($this -> _isMember($id))
			{
				$this -> Session -> setFlash(__('You are already a member.', true));
				$this -> redirect(array(
						'action' => 'view',
						$id
				));
			}
			$this -> loadModel('Membership');
			$this -> Membership -> create();
			$this -> Membership -> set('user_id', $this -> getUser());
			$this -> Membership -> set('organization_id', $id);
			$this -> Membership -> set('role', 'Member');
			$this -> Membership -> set('title', 'Member');
			$this -> Membership -> set('status', 'Pending');
			$this -> Membership -> set('since', date("Y-m-d"));
			if ($this -> Membership -> save())
			{
				$this -> Session -> setFlash(__('Added as a pending member. Please await approval.', true));
				$this -> redirect(array(
						'action' => 'view',
						$id
				));
				exit();
			}
			else
			{
				$this -> Session -> setFlash(__('Error in joining.', true));
				$this -> redirect(array(
						'action' => 'view',
						$id
				));
				exit();
			}
		}

		function roster($id = null)
		{
			if (!$id)
			{
				$this -> Session -> setFlash(__('Invalid organization.', true));
				$this -> redirect(array('action' => 'index'));
			}
			$org = $this -> Organization -> read(null, $id);
			if ($org['Organization']['status'] != 'Active' && !$this -> isLevel('admin'))
			{
				$this -> Session -> setFlash(__('Invalid organization.', true));
				$this -> redirect(array('action' => 'index'));
			}
			if (!$this -> isLevel('admin') && !$this -> _isOfficer($id))
			{
				$this -> Session -> setFlash(__('You are not an officer of this organization.', true));
				$this -> redirect(array(
						'action' => 'view',
						$id,
						'owner' => false
				));
			}
			$this -> setUsers($org);
			$this -> set('organization', $org);
		}

	}
?>
