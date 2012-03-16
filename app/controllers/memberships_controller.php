<?php
class MembershipsController extends AppController
{
	var $paginate = array ('Membership' => array ('contain' => array ('Organization.name', 'Organization.id', 'User.id', 'User.name')));
	var $name = 'Memberships';

	function beforeFilter()
	{
		parent::beforeFilter();
		$this->requireLevel('student');
	}

	function admin_index()
	{
		$this->requireLevel('admin');
		$members = $this->paginate();
		$this->set('memberships', $members);
	}

	function officer_index()
	{
		$members = $this->paginate(array ('Organization.id' => $this->_getOfficerOrgs()));
		$this->set('memberships', $members);
	}

	function admin_edit($id = null)
	{
		$this->redirect(array ('action' => 'edit', $id, 'admin' => false));
	}

	function officer_edit($id = null)
	{
		$this->redirect(array ('action' => 'edit', $id, 'owner' => false));
	}

	function edit($id = null)
	{
		if (!$id && empty($this->data))
		{
			$this->Session->setFlash(__('Invalid membership.', true));
			$this->redirect('/');
		}
		
		$mem = $this->Membership->read(null, $id);
		$orgId = $mem ['Membership'] ['organization_id'];
		$membership = $this -> Membership -> find ('first', array('conditions' => array('Membership.user_id' => $this -> getUser(), 'Membership.organization_id' => $orgId)));
		$role = $membership['Membership']['role'];
		$this -> set('role', $role);
		$userId = $mem ['Membership'] ['user_id'];
		$this->loadModel('User');
		$this->loadModel('Organization');
		$user = $this->User->find('all', array ('conditions' => array ('User.id' => $userId), 'recursive' => 0));
		$org = $this->Organization->find('all', array ('conditions' => array ('Organization.id' => $orgId), 'recursive' => 0));
		$this->set('user', $user);
		
		
		$this->set('org', $org);
		if (!$this->isLevel('admin') && !$this->_isOfficer($orgId))
		{
			$this->Session->setFlash(__('You are not an officer of this organization.', true));
			$this->redirect(array ('controller' => 'organizations', 'action' => 'view', $orgId));
		}
		
		if (!empty($this->data))
		{
			$this->set('membership', $mem);
			if ($this->Membership->save($this->data))
			{
				$this->Session->setFlash(__('The membership has been saved.', true));
				$this->redirect(array ('controller' => 'organizations', 'action' => 'roster', $orgId));
			}
			else
			{
				$this->Session->setFlash(__('The membership could not be saved. Please try again.', true));
			}
		}
		if (empty($this->data))
		{
			$this->data = $this->Membership->read(null, $id);
		}
	}

	function add($id = null)
	{
		if (!$id && empty($this->data))
		{
			$this->Session->setFlash(__('Invalid organization.', true));
			$this->redirect('/');
		}
		
		if ($id)
		{
			$orgId = $id;
			$userId = $this->getUser();
			$this->loadModel('User');
			$this->loadModel('Organization');
			$user = $this->User->find('all', array ('conditions' => array ('User.id' => $userId), 'recursive' => 0));
			$org = $this->Organization->find('all', array ('conditions' => array ('Organization.id' => $orgId), 'recursive' => 0));
			$this->set('user', $user);
			$this->set('org', $org);
			if (!$this->isLevel('admin') && !$this->_isOfficer($orgId))
			{
				$this->Session->setFlash(__('You are not an officer of this organization.', true));
				$this->redirect(array ('controller' => 'organizations', 'action' => 'view', $orgId));
			}
		}
		
		if (!empty($this->data))
		{
			$orgId = $this->data ['Membership'] ['organization_id'];
			$userId = $this->getUser();
			$this->loadModel('User');
			$this->loadModel('Organization');
			$user = $this->User->find('all', array ('conditions' => array ('User.id' => $userId), 'recursive' => 0));
			$org = $this->Organization->find('all', array ('conditions' => array ('Organization.id' => $orgId), 'recursive' => 0));
			$this->Membership->create();
			if ($this->Membership->save($this->data))
			{
				$this->Session->setFlash(__('The membership has been saved.', true));
				$this->redirect(array ('controller' => 'organizations', 'action' => 'roster', $this->data ['Membership'] ['organization_id'], 'admin' => false, 'officer' => false));
			}
			else
			{
				$this->Session->setFlash(__('The membership could not be saved. Please try again.', true));
			}
		}
	}

	function delete($id = null)
	{
		if (!$id)
		{
			$this->Session->setFlash(__('Invalid ID for membership.', true));
			$this->redirect('/');
		}
		$mem = $this->Membership->read(null, $id);
		$orgId = $mem ['Membership'] ['organization_id'];
		
		if (!$this->isLevel('admin') && !$this->_isOfficer($orgId))
		{
			$this->Session->setFlash(__('You are not an officer of this organization.', true));
			$this->redirect(array ('controller' => 'organizations', 'action' => 'view', $orgId));
		}
		if ($this->Membership->delete($id))
		{
			$this->Session->setFlash(__('Membership deleted.', true));
			$this->redirect(array ('controller' => 'organizations', 'action' => 'roster', 'admin' => false, 'officer' => false, 'owner' => false, $orgId));
		}
		$this->Session->setFlash(__('Membership was not deleted.', true));
		$this->redirect(array ('controller' => 'organizations', 'action' => 'roster', 'admin' => false, 'officer' => false, 'owner' => false, $orgId));
	}

	/* TODO: Frankly this is a horribly long function that could easily be broken up 
	 * in to smaller functions, I believe.
	 */
	function setUsers($org)
	{
		$this->loadModel('Organization');
		$users = array ();
		$usrs = array ();
		$prsdts = array ();
		$trsrs = array ();
		$offcrs = array ();
		$advsrs = array ();
		$rmrsvrs = array ();
		$memrs = array ();
		$pnd = array ();
		$officers = array ();
		$presidents = array ();
		$treasurers = array ();
		$advisors = array ();
		$reservers = array ();
		$members = array ();
		$pending = array ();
		$president_title = array ();
		$treasurer_title = array ();
		$officer_title = array ();
		$advisor_title = array ();
		
		$id = $org ['Organization'] ['id'];
		$this->set('id', $id);
		$this->loadModel('Membership');
		
		foreach ($org ['Member'] as $o)
		{
			if ($o ['status'] == 'Active' && strtotime($o ['since']) >= strtotime($this->getFiscalStartDate()))
			{
				$usrs [] = $o ['user_id'];
				$memrs [] = $o ['user_id'];
			}
			else 
				if ($o ['status'] == 'Pending' && strtotime($o ['since']) >= strtotime($this->getFiscalStartDate()))
				{
					$usrs [] = $o ['user_id'];
					$pnd [] = $o ['user_id'];
				}
		}
		$memberships = $this->Membership->find('list', array ('fields' => array ('Membership.user_id', 'Membership.id', 'Membership.organization_id'), 'conditions' => array ('Membership.organization_id' => $id, 'Membership.role' => 'Member')));
		$this->set('memberships', $memberships);
		
		$recent = current($org ['President']);
		$count = 0;
		foreach ($org ['President'] as $o)
		{
			if ((strtotime($o ['since']) > strtotime($recent ['since'])))
			{
				$recent = $o;
			}
			if (strtotime($o ['since']) >= strtotime($this->getFiscalStartDate()))
			{
				$usrs [] = $o ['user_id'];
				$prsdts [] = $o ['user_id'];
				if (!array_key_exists($o ['user_id'], $president_title))
				{
					$president_title [$o ['user_id']] = $o ['title'];
				}
				$count++;
			}
		}
		if ($count == 0 && !array_key_exists($recent ['user_id'], $president_title))
		{
			$prsdts [] = $recent ['user_id'];
			if (!array_key_exists($recent ['user_id'], $president_title))
			{
				$president_title [$recent ['user_id']] = $recent ['title'];
			}
		}
		$president_memberships = $this->Membership->find('list', array ('fields' => array ('Membership.user_id', 'Membership.id', 'Membership.organization_id'), 'conditions' => array ('Membership.organization_id' => $id, 'Membership.role' => 'President')));
		$this->set('president_memberships', $president_memberships);
		
		$recent = current($org ['Treasurer']);
		$count = 0;
		foreach ($org ['Treasurer'] as $o)
		{
			if ((strtotime($o ['since']) > strtotime($recent ['since'])))
			{
				$recent = $o;
			}
			if (strtotime($o ['since']) >= strtotime($this->getFiscalStartDate()))
			{
				$usrs [] = $o ['user_id'];
				$trsrs [] = $o ['user_id'];
				if (!array_key_exists($o ['user_id'], $treasurer_title))
				{
					$treasurer_title [$o ['user_id']] = $o ['title'];
				}
				$count++;
			}
		}
		if ($count == 0 && !array_key_exists($recent ['user_id'], $treasurer_title))
		{
			$trsrs [] = $recent ['user_id'];
			if (!array_key_exists($recent ['user_id'], $treasurer_title))
			{
				$treasurer_title [$recent ['user_id']] = $recent ['title'];
			}
		}
		$treasurer_memberships = $this->Membership->find('list', array ('fields' => array ('Membership.user_id', 'Membership.id', 'Membership.organization_id'), 'conditions' => array ('Membership.organization_id' => $id, 'Membership.role' => 'Treasurer')));
		$this->set('treasurer_memberships', $treasurer_memberships);
		
		$recent = current($org ['Officer']);
		$count = 0;
		foreach ($org ['Officer'] as $o)
		{
			if ((strtotime($o ['since']) > strtotime($recent ['since'])))
			{
				$recent = $o;
			}
			if (strtotime($o ['since']) >= strtotime($this->getFiscalStartDate()))
			{
				$usrs [] = $o ['user_id'];
				$offcrs [] = $o ['user_id'];
				if (!array_key_exists($o ['user_id'], $officer_title))
				{
					$officer_title [$o ['user_id']] = $o ['title'];
				}
				$count++;
			}
		}
		if ($count == 0 && !array_key_exists($recent ['user_id'], $officer_title))
		{
			$offcrs [] = $recent ['user_id'];
			if (!array_key_exists($recent ['user_id'], $officer_title))
			{
				$officer_title [$recent ['user_id']] = $recent ['title'];
			}
		}
		$officer_memberships = $this->Membership->find('list', array ('fields' => array ('Membership.user_id', 'Membership.id', 'Membership.organization_id'), 'conditions' => array ('Membership.organization_id' => $id, 'Membership.role' => 'Officer')));
		$this->set('officer_memberships', $officer_memberships);
		
		$recent = current($org ['RoomReserver']);
		$count = 0;
		foreach ($org ['RoomReserver'] as $o)
		{
			if ((strtotime($o ['since']) > strtotime($recent ['since'])))
			{
				$recent = $o;
			}
			if (strtotime($o ['since']) >= strtotime($this->getFiscalStartDate()))
			{
				$usrs [] = $o ['user_id'];
				$rmrsvrs [] = $o ['user_id'];
				$count++;
			}
		}
		if ($count == 0)
		{
			$rmrsvrs [] = $recent ['user_id'];
		}
		$reservers_memberships = $this->Membership->find('list', array ('fields' => array ('Membership.user_id', 'Membership.id', 'Membership.organization_id'), 'conditions' => array ('Membership.organization_id' => $id, 'Membership.role' => 'Room Reserver')));
		$this->set('reservers_memberships', $reservers_memberships);
		
		$recent = current($org ['Advisor']);
		$count = 0;
		foreach ($org ['Advisor'] as $o)
		{
			if ((strtotime($o ['since']) > strtotime($recent ['since'])) && !array_key_exists($o ['user_id'], $advisor_title))
			{
				$recent = $o;
			}
			if (strtotime($o ['since']) >= strtotime($this->getFiscalStartDate()))
			{
				$advsrs [] = $o ['user_id'];
				$advisor_title [$o ['user_id']] = $o ['title'];
				$count++;
			}
		}
		if ($count == 0 && !array_key_exists($recent ['user_id'], $advisor_title))
		{
			$advsrs [] = $recent ['user_id'];
			$advisor_title [$recent ['user_id']] = $recent ['title'];
		}
		$advisor_memberships = $this->Membership->find('list', array ('fields' => array ('Membership.user_id', 'Membership.id', 'Membership.organization_id'), 'conditions' => array ('Membership.organization_id' => $id, 'Membership.role' => 'Advisor')));
		$this->set('advisor_memberships', $advisor_memberships);
		
		$this->set('president_title', $president_title);
		$this->set('treasurer_title', $treasurer_title);
		$this->set('officer_title', $officer_title);
		$this->set('advisor_title', $advisor_title);
		
		if (sizeof($usrs) > 0)
		{
			$this->loadModel('User');
			$users = $this->User->find('all', array ('conditions' => array ('User.id' => $usrs), 'recursive' => 0));
			$this->set('users', $users);
		}
		else
		{
			$this->set('users', array ());
		}
		if (sizeof($offcrs) > 0)
		{
			$this->loadModel('User');
			$officers = $this->User->find('all', array ('conditions' => array ('User.id' => $offcrs), 'recursive' => 0));
			$this->set('officers', $officers);
		}
		else
		{
			$this->set('officers', array ());
		}
		if (sizeof($rmrsvrs) > 0)
		{
			$this->loadModel('User');
			$reservers = $this->User->find('all', array ('conditions' => array ('User.id' => $rmrsvrs), 'recursive' => 0));
			$this->set('reservers', $reservers);
		}
		else
		{
			$this->set('reservers', array ());
		}
		if (sizeof($advsrs) > 0)
		{
			$this->loadModel('User');
			$advisors = $this->User->find('all', array ('conditions' => array ('User.id' => $advsrs), 'recursive' => 0));
			$this->set('advisors', $advisors);
		}
		else
		{
			$this->set('advisors', array ());
		}
		if (sizeof($trsrs) > 0)
		{
			$this->loadModel('User');
			$treasurers = $this->User->find('all', array ('conditions' => array ('User.id' => $trsrs), 'recursive' => 0));
			$this->set('treasurers', $treasurers);
		}
		else
		{
			$this->set('treasurers', array ());
		}
		if (sizeof($prsdts) > 0)
		{
			$this->loadModel('User');
			$presidents = $this->User->find('all', array ('conditions' => array ('User.id' => $prsdts), 'recursive' => 0));
			$this->set('presidents', $presidents);
		}
		else
		{
			$this->set('presidents', array ());
		}
		if (sizeof($memrs) > 0)
		{
			$this->loadModel('User');
			$members = $this->User->find('all', array ('conditions' => array ('User.id' => $memrs), 'recursive' => 0));
			$this->set('members', $members);
		}
		else
		{
			$this->set('members', array ());
		}
		if (sizeof($pnd) > 0)
		{
			$this->loadModel('User');
			$pending = $this->User->find('all', array ('conditions' => array ('User.id' => $pnd), 'recursive' => 0));
			$this->set('pending', $pending);
		}
		else
		{
			$this->set('pending', array ());
		}
		return array ('members' => $members, 'presidents' => $presidents, 'treasurers' => $treasurers, 'officers' => $officers, 'advisors' => $advisors);
	}

	function _isOfficer($id = null)
	{
		$this->loadModel('Organization');
		$org = $this->Organization->read(null, $id);
		$officers = array ();
		$officers = $this->setUsers($org);
		$myId = $this->getUser();
		foreach ($officers ['officers'] as $officer)
		{
			if ($officer ['User'] ['id'] == $myId)
			{
				return true;
			}
		}
		foreach ($officers ['treasurers'] as $officer)
		{
			if ($officer ['User'] ['id'] == $myId)
			{
				return true;
			}
		}
		foreach ($officers ['presidents'] as $officer)
		{
			if ($officer ['User'] ['id'] == $myId)
			{
				return true;
			}
		}
		foreach ($officers ['advisors'] as $officer)
		{
			if ($officer ['User'] ['id'] == $myId)
			{
				return true;
			}
		}
		return false;
	}

	function _getOfficerOrgs()
	{
		$id = $this->getUser();
		$orgs = $this->Membership->find('list', array ('fields' => 'Membership.organization_id', 'conditions' => array ("and" => array ('user_id' => $id, 'role' => array ('Advisor', 'Officer', 'President', 'Treasurer'), 'since >=' => $this->getFiscalStartDate()))));
		return $orgs;
	}

}
?>