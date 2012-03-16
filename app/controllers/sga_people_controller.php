<?php
	class SgaPeopleController extends AppController
	{

		var $name = 'SgaPeople';

		function index()
		{
			if ($this -> isLevel('admin'))
			{
				$this -> redirect('../admin/sga_people/');
			}
			if (in_array('Graduate', $this -> params['pass']))
			{
				$this -> paginate = array(
						'order' => array('name' => 'desc'),
						'conditions' => array('AND' => array('SgaPerson.house' => 'Graduate'))
				);
				$this -> SgaPerson -> recursive = 0;
				$this -> set('sgaPeople', $this -> paginate());
			}
			elseif (in_array('Undergraduate', $this -> params['pass']))
			{
				$this -> paginate = array(
						'order' => array('name' => 'desc'),
						'conditions' => array('AND' => array('SgaPerson.house' => 'Undergraduate'))
				);
				$this -> SgaPerson -> recursive = 0;
				$this -> set('sgaPeople', $this -> paginate());
			}
			else
			{
				$this -> SgaPerson -> recursive = 0;
				$this -> set('sgaPeople', $this -> paginate());
			}
		}

		function admin_index()
		{
			$this -> requireLevel('admin');
			if (in_array('Graduate', $this -> params['pass']))
			{
				$this -> paginate = array(
						'order' => array('name' => 'desc'),
						'conditions' => array('AND' => array('SgaPerson.house' => 'Graduate'))
				);
				$this -> SgaPerson -> recursive = 0;
				$this -> set('sgaPeople', $this -> paginate());
			}
			elseif (in_array('Undergraduate', $this -> params['pass']))
			{
				$this -> paginate = array(
						'order' => array('name' => 'desc'),
						'conditions' => array('AND' => array('SgaPerson.house' => 'Undergraduate'))
				);
				$this -> SgaPerson -> recursive = 0;
				$this -> set('sgaPeople', $this -> paginate());
			}
			elseif (in_array('Active', $this -> params['pass']))
			{
				$this -> paginate = array(
						'order' => array('name' => 'desc'),
						'conditions' => array('AND' => array('SgaPerson.status' => 'Active'))
				);
				$this -> SgaPerson -> recursive = 0;
				$this -> set('sgaPeople', $this -> paginate());
			}
			elseif (in_array('Inactive', $this -> params['pass']))
			{
				$this -> paginate = array(
						'order' => array('name' => 'desc'),
						'conditions' => array('AND' => array('SgaPerson.status' => 'Inactive'))
				);
				$this -> SgaPerson -> recursive = 0;
				$this -> set('sgaPeople', $this -> paginate());
			}
			else
			{
				$this -> SgaPerson -> recursive = 0;
				$this -> set('sgaPeople', $this -> paginate());
			}
		}

		function admin_add($id = null)
		{
			$this -> requireLevel('admin');
			$this -> loadModel('User');
			if (!empty($this -> data) && isset($this -> data['SgaPerson']['house']))
			{
				$this -> SgaPerson -> create();
				if ($this -> SgaPerson -> save($this -> data))
				{
					$user = $this -> User -> read(null, $this -> data['SgaPerson']['user_id']);
					$this -> User -> set('level', 'power');
					$this -> User -> save();
					$this -> Session -> setFlash(__('The user has been added to SGA.', true));
					$this -> redirect(array('action' => 'index'));
				}
				else
				{
					$this -> Session -> setFlash(__('Invalid user. User may already be assigned a role in SGA. Please try again.', true));
				}
			}
		}

		function admin_edit($id = null)
		{
			$this -> requireLevel('admin');
			if (!$id && empty($this -> data))
			{
				$this -> Session -> setFlash(__('No SGA record.', true));
				$this -> redirect(array('action' => 'index'));
			}
			if (!empty($this -> data) && isset($this -> data['SgaPerson']['house']))
			{
				if ($this -> SgaPerson -> save($this -> data))
				{
					$this -> Session -> setFlash(__('The user has been edited.', true));
					$this -> redirect(array('action' => 'index'));
				}
				else
				{
					$this -> Session -> setFlash(__('Error. Please try again.', true));
				}
			}
			if (empty($this -> data))
			{
				$this -> data = $this -> SgaPerson -> read(null, $id);
			}
			$sgaPerson = $this -> SgaPerson -> read(null, $id);
			$name = $sgaPerson['User']['name'];
			$this -> set('name', $name);
			$this -> set('id', $id);
		}

		function admin_delete($id = null)
		{
			$this -> requireLevel('admin');
			if (!$id)
			{
				$this -> Session -> setFlash(__('No SGA record.', true));
				$this -> redirect(array('action' => 'index'));
			}
			if ($this -> SgaPerson -> delete($id))
			{
				$this -> Session -> setFlash(__('SGA record deleted.', true));
				$this -> redirect(array('action' => 'index'));
			}
			$this -> Session -> setFlash(__('SGA record could not be deleted.', true));
			$this -> redirect(array('action' => 'index'));
		}

	}
?>
