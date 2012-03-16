<?php
class ChartersController extends AppController
{
	
	var $name = 'Charters';

	function edit($orgid = null)
	{
		if ($orgid != null)
		{
			$org = $this->Charter->Organization->read ( null, $orgid );
			if ($org ['Organization'] ['status'] == 'Frozen')
			{
				$this->Session->setFlash ( __ ( 'Invalid organization', true ) );
				$this->redirect ( array ('controller' => 'organizations', 'action' => 'index') );
			}
			$this->set ( 'org', $org );
			$this->requireUser ( array ($org ['President'] ['id'], $org ['Treasurer'] ['id']) );
			$this->_updateCharter ( $orgid );
		}
		else
		{
			$this->Session->setFlash ( "Invalid organization." );
			$this->redirect ( array ('controller' => 'pages', 'action' => 'home', 'owner' => false) );
		}
	}

	function index($orgid = null)
	{
		if ($orgid != null)
		{
			$org = $this->Charter->Organization->read ( null, $orgid );
			if ($org ['Organization'] ['status'] == 'Frozen')
			{
				$this->Session->setFlash ( __ ( 'Invalid organization', true ) );
				$this->redirect ( array ('controller' => 'organizations', 'action' => 'index') );
			}
			$this->set ( 'organization', $org );
			$this->set ( 'isOfficer', $this->_isOfficer ( $orgid ) );
			$this->Charters->recursive = 0;
			$this->set ( 'documents', $this->paginate ( array ('Charter.organization_id' => $orgid) ) );
		}
		else
		{
			$this->Session->setFlash ( "Invalid organization." );
			$this->redirect ( array ('controller' => 'organizations', 'action' => 'index') );
		}
	}

	function addcharter($id = null)
	{
		$org = $this->Charter->Organization->read ( null, $id );
		if ($org ['Organization'] ['status'] == 'Frozen')
		{
			$this->Session->setFlash ( __ ( 'Invalid organization', true ) );
			$this->redirect ( array ('controller' => 'organizations', 'action' => 'index') );
		}
		if (! $id)
		{
			$this->Session->setFlash ( __ ( 'Invalid organization.', true ) );
			$this->redirect ( array ('action' => 'index') );
		}
		if (! $this->isLevel ( 'admin' ) && ! $this->_isOfficer ( $id ))
		{
			$this->Session->setFlash ( __ ( 'You are not an officer of this organization.', true ) );
			$this->redirect ( array ('controller' => 'organizations', 'action' => 'view', $id) );
		}
		if (! empty ( $this->data ) && is_uploaded_file ( $this->data ['File'] ['doc'] ['tmp_name'] ))
		{
			//Configure::write('debug', 0);
			$fileData = fread ( fopen ( $this->data ['File'] ['doc'] ['tmp_name'], "r" ), $this->data ['File'] ['doc'] ['size'] );
			if ($this->data ['File'] ['doc'] ['size'] > 2086666) //1.99MB
			{
				$this->Session->setFlash ( __ ( 'File is too large.', true ) );
				$this->redirect ( '/charters/index/' . $id );
			}
			$this->Charter->create ();
			$this->Charter->set ( 'organization_id', $id );
			$this->Charter->set ( 'name', $this->data ['File'] ['doc'] ['name'] );
			$this->Charter->set ( 'type', $this->data ['File'] ['doc'] ['type'] );
			$this->Charter->set ( 'size', $this->data ['File'] ['doc'] ['size'] );
			$this->Charter->set ( 'file', $fileData );
			if ($this->Charter->save ())
			{
				$this->redirect ( array ('action' => 'index', $id) );
				exit ();
			}
			else
			{
				$this->Session->setFlash ( __ ( 'Error in upload.', true ) );
				$this->redirect ( array ('action' => 'index', $id) );
				exit ();
			}
		}
		$this->set ( 'organization', $this->Charter->Organization->read ( null, $id ) );
	}

	function delete($id = null)
	{
		$doc = $this->Charter->read ( null, $id );
		if (! $this->isLevel ( 'admin' ) && ! $this->_isOfficer ( $doc ['Charter'] ['organization_id'] ))
		{
			$this->Session->setFlash ( __ ( 'You are not an officer of this organization.', true ) );
			$this->redirect ( array ('action' => '/') );
		}
		$this->Charter->delete ( $id );
		$this->redirect ( array ('action' => 'index', $doc ['Charter'] ['organization_id']) );
		exit ();
	}

	function view($id)
	{
		if (! $id)
		{
			$this->Session->setFlash ( __ ( 'Invalid file.', true ) );
			$this->redirect ( array ('action' => '/') );
		}
		$this->set ( 'inpage', false );
		//Configure::write('debug', 0);
		$file = $this->Charter->findById ( $id );
		$document = array ();
		$document ['name'] = $file ['Charter'] ['name'];
		$document ['type'] = $file ['Charter'] ['type'];
		$document ['data'] = $file ['Charter'] ['file'];
		
		if ($document ['data'] == null)
		{
			$this->Session->setFlash ( __ ( 'Invalid file.', true ) );
			$this->redirect ( array ('action' => '/') );
		}
		else
		{
			$this->set ( 'file', $document );
			$this->render ( 'download', 'document' );
			return true;
		}
	}

	function setUsers($org)
	{
		$this->loadModel ( 'Organization' );
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
		$this->set ( 'id', $id );
		$this->loadModel ( 'Membership' );
		
		foreach ( $org ['Member'] as $o )
		{
			if ($o ['status'] == 'Active' && strtotime ( $o ['since'] ) >= strtotime ( $this->getFiscalStartDate () ))
			{
				$usrs [] = $o ['user_id'];
				$memrs [] = $o ['user_id'];
			}
			else 
				if ($o ['status'] == 'Pending' && strtotime ( $o ['since'] ) >= strtotime ( $this->getFiscalStartDate () ))
				{
					$usrs [] = $o ['user_id'];
					$pnd [] = $o ['user_id'];
				}
		}
		$memberships = $this->Membership->find ( 'list', array ('fields' => array ('Membership.user_id', 'Membership.id', 'Membership.organization_id'), 'conditions' => array ('Membership.organization_id' => $id, 'Membership.role' => 'Member')) );
		$this->set ( 'memberships', $memberships );
		
		$recent = current ( $org ['President'] );
		$count = 0;
		foreach ( $org ['President'] as $o )
		{
			if ((strtotime ( $o ['since'] ) > strtotime ( $recent ['since'] )))
			{
				$recent = $o;
			}
			if (strtotime ( $o ['since'] ) >= strtotime ( $this->getFiscalStartDate () ))
			{
				$usrs [] = $o ['user_id'];
				$prsdts [] = $o ['user_id'];
				if (! array_key_exists ( $o ['user_id'], $president_title ))
				{
					$president_title [$o ['user_id']] = $o ['title'];
				}
				$count ++;
			}
		}
		if ($count == 0 && ! array_key_exists ( $recent ['user_id'], $president_title ))
		{
			$prsdts [] = $recent ['user_id'];
			if (! array_key_exists ( $recent ['user_id'], $president_title ))
			{
				$president_title [$recent ['user_id']] = $recent ['title'];
			}
		}
		$president_memberships = $this->Membership->find ( 'list', array ('fields' => array ('Membership.user_id', 'Membership.id', 'Membership.organization_id'), 'conditions' => array ('Membership.organization_id' => $id, 'Membership.role' => 'President')) );
		$this->set ( 'president_memberships', $president_memberships );
		
		$recent = current ( $org ['Treasurer'] );
		$count = 0;
		foreach ( $org ['Treasurer'] as $o )
		{
			if ((strtotime ( $o ['since'] ) > strtotime ( $recent ['since'] )))
			{
				$recent = $o;
			}
			if (strtotime ( $o ['since'] ) >= strtotime ( $this->getFiscalStartDate () ))
			{
				$usrs [] = $o ['user_id'];
				$trsrs [] = $o ['user_id'];
				if (! array_key_exists ( $o ['user_id'], $treasurer_title ))
				{
					$treasurer_title [$o ['user_id']] = $o ['title'];
				}
				$count ++;
			}
		}
		if ($count == 0 && ! array_key_exists ( $recent ['user_id'], $treasurer_title ))
		{
			$trsrs [] = $recent ['user_id'];
			if (! array_key_exists ( $recent ['user_id'], $treasurer_title ))
			{
				$treasurer_title [$recent ['user_id']] = $recent ['title'];
			}
		}
		$treasurer_memberships = $this->Membership->find ( 'list', array ('fields' => array ('Membership.user_id', 'Membership.id', 'Membership.organization_id'), 'conditions' => array ('Membership.organization_id' => $id, 'Membership.role' => 'Treasurer')) );
		$this->set ( 'treasurer_memberships', $treasurer_memberships );
		
		$recent = current ( $org ['Officer'] );
		$count = 0;
		foreach ( $org ['Officer'] as $o )
		{
			if ((strtotime ( $o ['since'] ) > strtotime ( $recent ['since'] )))
			{
				$recent = $o;
			}
			if (strtotime ( $o ['since'] ) >= strtotime ( $this->getFiscalStartDate () ))
			{
				$usrs [] = $o ['user_id'];
				$offcrs [] = $o ['user_id'];
				if (! array_key_exists ( $o ['user_id'], $officer_title ))
				{
					$officer_title [$o ['user_id']] = $o ['title'];
				}
				$count ++;
			}
		}
		if ($count == 0 && ! array_key_exists ( $recent ['user_id'], $officer_title ))
		{
			$offcrs [] = $recent ['user_id'];
			if (! array_key_exists ( $recent ['user_id'], $officer_title ))
			{
				$officer_title [$recent ['user_id']] = $recent ['title'];
			}
		}
		$officer_memberships = $this->Membership->find ( 'list', array ('fields' => array ('Membership.user_id', 'Membership.id', 'Membership.organization_id'), 'conditions' => array ('Membership.organization_id' => $id, 'Membership.role' => 'Officer')) );
		$this->set ( 'officer_memberships', $officer_memberships );
		
		$recent = current ( $org ['RoomReserver'] );
		$count = 0;
		foreach ( $org ['RoomReserver'] as $o )
		{
			if ((strtotime ( $o ['since'] ) > strtotime ( $recent ['since'] )))
			{
				$recent = $o;
			}
			if (strtotime ( $o ['since'] ) >= strtotime ( $this->getFiscalStartDate () ))
			{
				$usrs [] = $o ['user_id'];
				$rmrsvrs [] = $o ['user_id'];
				$count ++;
			}
		}
		if ($count == 0)
		{
			$rmrsvrs [] = $recent ['user_id'];
		}
		$reservers_memberships = $this->Membership->find ( 'list', array ('fields' => array ('Membership.user_id', 'Membership.id', 'Membership.organization_id'), 'conditions' => array ('Membership.organization_id' => $id, 'Membership.role' => 'Room Reserver')) );
		$this->set ( 'reservers_memberships', $reservers_memberships );
		
		$recent = current ( $org ['Advisor'] );
		$count = 0;
		foreach ( $org ['Advisor'] as $o )
		{
			if ((strtotime ( $o ['since'] ) > strtotime ( $recent ['since'] )) && ! array_key_exists ( $o ['user_id'], $advisor_title ))
			{
				$recent = $o;
			}
			if (strtotime ( $o ['since'] ) >= strtotime ( $this->getFiscalStartDate () ))
			{
				$advsrs [] = $o ['user_id'];
				$advisor_title [$o ['user_id']] = $o ['title'];
				$count ++;
			}
		}
		if ($count == 0 && ! array_key_exists ( $recent ['user_id'], $advisor_title ))
		{
			$advsrs [] = $recent ['user_id'];
			$advisor_title [$recent ['user_id']] = $recent ['title'];
		}
		$advisor_memberships = $this->Membership->find ( 'list', array ('fields' => array ('Membership.user_id', 'Membership.id', 'Membership.organization_id'), 'conditions' => array ('Membership.organization_id' => $id, 'Membership.role' => 'Advisor')) );
		$this->set ( 'advisor_memberships', $advisor_memberships );
		
		$this->set ( 'president_title', $president_title );
		$this->set ( 'treasurer_title', $treasurer_title );
		$this->set ( 'officer_title', $officer_title );
		$this->set ( 'advisor_title', $advisor_title );
		
		if (sizeof ( $usrs ) > 0)
		{
			$this->loadModel ( 'User' );
			$users = $this->User->find ( 'all', array ('conditions' => array ('User.id' => $usrs), 'recursive' => 0) );
			$this->set ( 'users', $users );
		}
		else
		{
			$this->set ( 'users', array () );
		}
		if (sizeof ( $offcrs ) > 0)
		{
			$this->loadModel ( 'User' );
			$officers = $this->User->find ( 'all', array ('conditions' => array ('User.id' => $offcrs), 'recursive' => 0) );
			$this->set ( 'officers', $officers );
		}
		else
		{
			$this->set ( 'officers', array () );
		}
		if (sizeof ( $rmrsvrs ) > 0)
		{
			$this->loadModel ( 'User' );
			$reservers = $this->User->find ( 'all', array ('conditions' => array ('User.id' => $rmrsvrs), 'recursive' => 0) );
			$this->set ( 'reservers', $reservers );
		}
		else
		{
			$this->set ( 'reservers', array () );
		}
		if (sizeof ( $advsrs ) > 0)
		{
			$this->loadModel ( 'User' );
			$advisors = $this->User->find ( 'all', array ('conditions' => array ('User.id' => $advsrs), 'recursive' => 0) );
			$this->set ( 'advisors', $advisors );
		}
		else
		{
			$this->set ( 'advisors', array () );
		}
		if (sizeof ( $trsrs ) > 0)
		{
			$this->loadModel ( 'User' );
			$treasurers = $this->User->find ( 'all', array ('conditions' => array ('User.id' => $trsrs), 'recursive' => 0) );
			$this->set ( 'treasurers', $treasurers );
		}
		else
		{
			$this->set ( 'treasurers', array () );
		}
		if (sizeof ( $prsdts ) > 0)
		{
			$this->loadModel ( 'User' );
			$presidents = $this->User->find ( 'all', array ('conditions' => array ('User.id' => $prsdts), 'recursive' => 0) );
			$this->set ( 'presidents', $presidents );
		}
		else
		{
			$this->set ( 'presidents', array () );
		}
		if (sizeof ( $memrs ) > 0)
		{
			$this->loadModel ( 'User' );
			$members = $this->User->find ( 'all', array ('conditions' => array ('User.id' => $memrs), 'recursive' => 0) );
			$this->set ( 'members', $members );
		}
		else
		{
			$this->set ( 'members', array () );
		}
		if (sizeof ( $pnd ) > 0)
		{
			$this->loadModel ( 'User' );
			$pending = $this->User->find ( 'all', array ('conditions' => array ('User.id' => $pnd), 'recursive' => 0) );
			$this->set ( 'pending', $pending );
		}
		else
		{
			$this->set ( 'pending', array () );
		}
		return array ('members' => $members, 'presidents' => $presidents, 'treasurers' => $treasurers, 'officers' => $officers, 'advisors' => $advisors);
	}

	function _isOfficer($id = null)
	{
		$this->loadModel ( 'Organization' );
		$org = $this->Organization->read ( null, $id );
		$officers = array ();
		$officers = $this->setUsers ( $org );
		$myId = $this->getUser ();
		foreach ( $officers ['officers'] as $officer )
		{
			if ($officer ['User'] ['id'] == $myId)
			{
				return true;
			}
		}
		foreach ( $officers ['treasurers'] as $officer )
		{
			if ($officer ['User'] ['id'] == $myId)
			{
				return true;
			}
		}
		foreach ( $officers ['presidents'] as $officer )
		{
			if ($officer ['User'] ['id'] == $myId)
			{
				return true;
			}
		}
		foreach ( $officers ['advisors'] as $officer )
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
		$this->loadModel ( 'Membership' );
		$id = $this->getUser ();
		$orgs = $this->Membership->find ( 'list', array ('fields' => 'Membership.organization_id', 'conditions' => array ("and" => array ('user_id' => $id, 'role' => array ('Advisor', 'Officer', 'President', 'Treasurer', 'Room Reserver'), 'since >=' => $this->getFiscalStartDate ()))) );
		return $orgs;
	}
}
?>