<?php
	/**
	 * Manages bills that come through the Jacketpage system.
	 */
	class BillsController extends AppController
	{

		var $paginate = array(
				'limit' => 10,
				'order' => array(
						'Bill.number' => 'ASC',
						'Bill.title' => 'DESC'
				),
				'contain' => array(
						'Organization.name',
						'Organization.id',
						'UndergradAuthor' => array(
								'User.id',
								'User.name'
						),
						'GraduateAuthor' => array(
								'User.id',
								'User.name'
						),
						'Submitter.id',
						'Submitter.name'
				)
		);
		var $helpers = array(
				'Html',
				'Form',
				'Session',
				'Js',
				'Paginator',
				'Csv'
		);
		var $name = 'Bills';

		/**
		 * (non-PHPdoc)
		 * @see Controller::beforeFilter()
		 */
		function beforeFilter()
		{
			parent::beforeFilter();
			$this -> requireLevel('student');
		}

		/**
		 * Handles the logic to create an index of all of the bills that correspond to a specific user.
		 * Based on which category has been chosen will show bills that are in one of the following
		 * stages: "Awating Author", "Authored", "Agenda", "Passed", "Failed", "Archived." Defaults to showing
		 * all of the bills.
		 */
		function owner_index()
		{
			if (in_array('All', $this -> params['pass']))
			{
				$this -> Session -> delete($this -> name . '.keyword');
				$this -> paginate = array(
						'order' => array('submit_date' => 'desc'),
						'conditions' => array('AND' => array(
									'OR' => array(
											'Bill.user_id LIKE' => $this -> getUser(),
											'GraduateAuthor.user_id LIKE' => $this -> getUser(),
											'UndergradAuthor.user_id LIKE' => $this -> getUser()
									)
							))
				);
				$this -> set('bills', $this -> paginate('Bill'));
			}
			else if (in_array('Awaiting Author', $this -> params['pass']))
			{
				$this -> paginate = array(
						'order' => array('submit_date' => 'desc'),
						'conditions' => array('AND' => array(
									$this -> _filterBills(),
									'Bill.status' => 'Awaiting Author',
									'OR' => array(
											'Bill.user_id LIKE' => $this -> getUser(),
											'GraduateAuthor.user_id LIKE' => $this -> getUser(),
											'UndergradAuthor.user_id LIKE' => $this -> getUser()
									)
							))
				);
				$this -> set('bills', $this -> paginate('Bill'));
			}
			elseif (in_array('Authored', $this -> params['pass']))
			{
				$this -> paginate = array(
						'order' => array('submit_date' => 'desc'),
						'conditions' => array('AND' => array(
									$this -> _filterBills(),
									'Bill.status' => 'Authored',
									'OR' => array(
											'Bill.user_id LIKE' => $this -> getUser(),
											'GraduateAuthor.user_id LIKE' => $this -> getUser(),
											'UndergradAuthor.user_id LIKE' => $this -> getUser()
									)
							))
				);
				$this -> set('bills', $this -> paginate('Bill'));
			}
			elseif (in_array('Agenda', $this -> params['pass']))
			{
				$this -> paginate = array(
						'order' => array('submit_date' => 'desc'),
						'conditions' => array('AND' => array(
									$this -> _filterBills(),
									'Bill.status' => 'Agenda',
									'OR' => array(
											'Bill.user_id LIKE' => $this -> getUser(),
											'GraduateAuthor.user_id LIKE' => $this -> getUser(),
											'UndergradAuthor.user_id LIKE' => $this -> getUser()
									)
							))
				);
				$this -> set('bills', $this -> paginate('Bill'));
			}
			elseif (in_array('Passed', $this -> params['pass']))
			{
				$this -> paginate = array(
						'order' => array('submit_date' => 'desc'),
						'conditions' => array('AND' => array(
									$this -> _filterBills(),
									'Bill.status' => 'Passed',
									'OR' => array(
											'Bill.user_id LIKE' => $this -> getUser(),
											'GraduateAuthor.user_id LIKE' => $this -> getUser(),
											'UndergradAuthor.user_id LIKE' => $this -> getUser()
									)
							))
				);
				$this -> set('bills', $this -> paginate('Bill'));
			}
			elseif (in_array('Failed', $this -> params['pass']))
			{
				$this -> paginate = array(
						'order' => array('submit_date' => 'desc'),
						'conditions' => array('AND' => array(
									$this -> _filterBills(),
									'Bill.status' => 'Failed',
									'OR' => array(
											'Bill.user_id LIKE' => $this -> getUser(),
											'GraduateAuthor.user_id LIKE' => $this -> getUser(),
											'UndergradAuthor.user_id LIKE' => $this -> getUser()
									)
							))
				);
				$this -> set('bills', $this -> paginate('Bill'));
			}
			elseif (in_array('Archived', $this -> params['pass']))
			{
				$this -> paginate = array(
						'order' => array('submit_date' => 'desc'),
						'conditions' => array('AND' => array(
									$this -> _filterBills(),
									'Bill.status' => 'Archived',
									'OR' => array(
											'Bill.user_id LIKE' => $this -> getUser(),
											'GraduateAuthor.user_id LIKE' => $this -> getUser(),
											'UndergradAuthor.user_id LIKE' => $this -> getUser()
									)
							))
				);
				$this -> set('bills', $this -> paginate('Bill'));
			}
			elseif (in_array('Joint', $this -> params['pass']))
			{
				$this -> paginate = array(
						'order' => array('submit_date' => 'desc'),
						'conditions' => array('AND' => array(
									$this -> _filterBills(),
									'Bill.category' => 'Joint',
									'OR' => array(
											'Bill.user_id LIKE' => $this -> getUser(),
											'GraduateAuthor.user_id LIKE' => $this -> getUser(),
											'UndergradAuthor.user_id LIKE' => $this -> getUser()
									)
							))
				);
				$this -> set('bills', $this -> paginate('Bill'));
			}
			elseif (in_array('Conference', $this -> params['pass']))
			{
				$this -> paginate = array(
						'order' => array('submit_date' => 'desc'),
						'conditions' => array('AND' => array(
									$this -> _filterBills(),
									'Bill.category' => 'Conference',
									'OR' => array(
											'Bill.user_id LIKE' => $this -> getUser(),
											'GraduateAuthor.user_id LIKE' => $this -> getUser(),
											'UndergradAuthor.user_id LIKE' => $this -> getUser()
									)
							))
				);
				$this -> set('bills', $this -> paginate('Bill'));
			}
			elseif (in_array('Undergraduate', $this -> params['pass']))
			{
				$this -> paginate = array(
						'order' => array('submit_date' => 'desc'),
						'conditions' => array('AND' => array(
									$this -> _filterBills(),
									'Bill.category' => 'Undergraduate',
									'OR' => array(
											'Bill.user_id LIKE' => $this -> getUser(),
											'GraduateAuthor.user_id LIKE' => $this -> getUser(),
											'UndergradAuthor.user_id LIKE' => $this -> getUser()
									)
							))
				);
				$this -> set('bills', $this -> paginate('Bill'));
			}
			elseif (in_array('Graduate', $this -> params['pass']))
			{
				$this -> paginate = array(
						'order' => array('submit_date' => 'desc'),
						'conditions' => array('AND' => array(
									$this -> _filterBills(),
									'Bill.category' => 'Graduate',
									'OR' => array(
											'Bill.user_id LIKE' => $this -> getUser(),
											'GraduateAuthor.user_id LIKE' => $this -> getUser(),
											'UndergradAuthor.user_id LIKE' => $this -> getUser()
									)
							))
				);
				$this -> set('bills', $this -> paginate('Bill'));
			}
			else
			{
				$this -> paginate = array(
						'order' => array('submit_date' => 'desc'),
						'conditions' => array('AND' => array(
									$this -> _filterBills(),
									'OR' => array(
											'Bill.user_id LIKE' => $this -> getUser(),
											'GraduateAuthor.user_id LIKE' => $this -> getUser(),
											'UndergradAuthor.user_id LIKE' => $this -> getUser()
									)
							))
				);
				$this -> set('bills', $this -> paginate('Bill'));
			}
		}

		/**
		 * A general view of a bill. Redirects admin and power users to their
		 * corresponding view.
		 */
		function view($id = null)
		{
			if ($this -> isLevel('admin'))
			{
				$this -> redirect('/admin/bills/view/' . $id);
			}
			else
			if ($this -> isLevel('power'))
			{
				$this -> redirect('/power/bills/view/' . $id);
			}

			$this -> requireLevel('user');
			if (!$id)
			{
				$this -> Session -> setFlash(__('Invalid bill', true));
				$this -> redirect(array('action' => 'index'));
			}
			$this -> Bill -> contain = array(
					'Organization.name',
					'Organization.id',
					'UndergradAuthor' => array(
							'User.id',
							'User.name'
					),
					'GraduateAuthor' => array(
							'User.id',
							'User.name'
					),
					'Submitter.id',
					'Submitter.name'
			);
			$this -> Bill -> recursive = 2;
			$bill = $this -> Bill -> read(null, $id);
			$this -> set('bill', $bill);
			$valid = array(
					$bill['Bill']['user_id'],
					$bill['UndergradAuthor']['user_id'],
					$bill['GraduateAuthor']['user_id']
			);
			$permitted = false;
			if (in_array($this -> getUser(), $valid))
			{
				$permitted = true;
				$this -> redirect('/owner/bills/view/' . $id);
			}
			$this -> set('permitted', $permitted);
		}

		/**
		 * Exports the bills to a CSV file.
		 */
		function export($fy = null)
		{
			$this -> requireLevel('power');
			if ($fy == null)
				$fy = $this -> getFiscalYear() + 1;
			$this -> Bill -> contain = array(
					'Organization.name',
					'Organization.id',
					'UndergradAuthor' => array(
							'fields' => array('user_id'),
							'User' => array('fields' => array(
										'id',
										'name'
								))
					),
					'GraduateAuthor' => array(
							'fields' => array('user_id'),
							'User' => array('fields' => array(
										'id',
										'name'
								))
					),
					'Submitter.id',
					'Submitter.name'
			);
			$bills = $this -> Bill -> find('all', array('conditions' => array('Bill.number like' => $fy . "%")));
			$this -> set('bills', $bills);
			$this -> set('fy', $fy);
			$this -> layout = 'csv';
		}

		/**
		 * Creates a new bill. Redirects to admin_add if user is an administrator.
		 */
		function add()
		{
			if ($this -> isLevel('admin'))
			{
				$this -> redirect('/admin/bills/add/');
			}
			else
			{
				if (!empty($this -> data))
				{
					/*if($this->data['Bill']['type'] == 'Budget')
					 {
					 $otherBudgets = $this->Bill->find('list', array('conditions' => array('Bill.organization_id' => $org['Organization']['id'], 'Bill.type' => 'Budget',
					 'Bill.number LIKE' => $this->getFiscalYear()."%")));
					 if(count($otherBudgets) > 0)
					 {
					 $this->Session->setFlash("This organization already has a budget submitted for this fiscal year.");
					 $this->redirect(array('action' => 'add'));
					 }
					 }
					 Not using this implementation of Budgets but keeping the code until we decide to completely purge this implementation option.
					 */

					$this -> Bill -> create();

					$this -> loadModel('User');
					//$ids = $this -> User -> find('all', array(
					//		'fields' => array('User.id'),
					//		'conditions' => array('User.gtUsername' => $this -> data['Bill']['gtUsername'])
					//));
					$this -> Bill -> set('user_id', $this -> getUser());
					$org = $this -> Bill -> Organization -> read(null, $this -> data['Bill']['organization_id']);
					$this -> data['Bill']['dues'] = $org['Organization']['dues'];
					if ($this -> Bill -> save($this -> data))
					{
						$this -> Session -> setFlash(__('The bill has been created.', true));
						//Email selected bill authors.
						$this -> _updateBillOwners($this -> Bill -> id);
						$this -> redirect(array(
								'owner' => true,
								'controller' => 'line_items',
								'action' => 'add',
								$this -> Bill -> id
						));
					}
					else
					{
						$this -> Session -> setFlash(__('The bill could not be saved. Please try again.', true));
						$this -> log("User: " . $this -> getUser() . " bills/add", 'bugs');
					}
				}
			}

			$this -> set('user', $this -> getUser());
			$this -> setGradAuthors();
			$this -> setUnderAuthors();
			$this -> setMyOrganizations();

		}

		/**
		 * Handles the logic to create an admin index of all of the bills in the system.
		 * Based on which category has been chosen will show bills that are in one of the following
		 * stages: "Awating Author", "Authored", "Agenda", "Passed", "Failed", "Archived." Defaults to showing
		 * all of the bills.
		 */
		function admin_index()
		{
			$this -> requireLevel('admin');
			if (in_array('All', $this -> params['pass']))
			{
				$this -> Session -> delete($this -> name . '.keyword');
				$this -> paginate = array(
						'order' => array('submit_date' => 'desc')
				);
				$this -> set('bills', $this -> paginate('Bill'));
			}
			else if (in_array('Awaiting Author', $this -> params['pass']))
			{
				$this -> paginate = array(
						'order' => array('submit_date' => 'desc'),
						'conditions' => array('AND' => array(
									$this -> _filterBills(),
									'Bill.status' => 'Awaiting Author'
							))
				);
				$this -> set('bills', $this -> paginate('Bill'));
			}
			elseif (in_array('Authored', $this -> params['pass']))
			{
				$this -> paginate = array(
						'order' => array('submit_date' => 'desc'),
						'conditions' => array('AND' => array(
									$this -> _filterBills(),
									'Bill.status' => 'Authored'
							))
				);
				$this -> set('bills', $this -> paginate('Bill'));
			}
			elseif (in_array('Agenda', $this -> params['pass']))
			{
				$this -> paginate = array(
						'order' => array('submit_date' => 'desc'),
						'conditions' => array('AND' => array(
									$this -> _filterBills(),
									'Bill.status' => 'Agenda'
							))
				);
				$this -> set('bills', $this -> paginate('Bill'));
			}
			elseif (in_array('Passed', $this -> params['pass']))
			{
				$this -> paginate = array(
						'order' => array('submit_date' => 'desc'),
						'conditions' => array('AND' => array(
									$this -> _filterBills(),
									'Bill.status' => 'Passed'
							))
				);
				$this -> set('bills', $this -> paginate('Bill'));
			}
			elseif (in_array('Failed', $this -> params['pass']))
			{
				$this -> paginate = array(
						'order' => array('submit_date' => 'desc'),
						'conditions' => array('AND' => array(
									$this -> _filterBills(),
									'Bill.status' => 'Failed'
							))
				);
				$this -> set('bills', $this -> paginate('Bill'));
			}
			elseif (in_array('Archived', $this -> params['pass']))
			{
				$this -> paginate = array(
						'order' => array('submit_date' => 'desc'),
						'conditions' => array('AND' => array(
									$this -> _filterBills(),
									'Bill.status' => 'Archived'
							))
				);
				$this -> set('bills', $this -> paginate('Bill'));
			}
			elseif (in_array('Joint', $this -> params['pass']))
			{
				$this -> paginate = array(
						'order' => array('submit_date' => 'desc'),
						'conditions' => array('AND' => array(
									$this -> _filterBills(),
									'Bill.category' => 'Joint'
							))
				);
				$this -> set('bills', $this -> paginate('Bill'));
			}
			elseif (in_array('Conference', $this -> params['pass']))
			{
				$this -> paginate = array(
						'order' => array('submit_date' => 'desc'),
						'conditions' => array('AND' => array(
									$this -> _filterBills(),
									'Bill.category' => 'Conference'
							))
				);
				$this -> set('bills', $this -> paginate('Bill'));
			}
			elseif (in_array('Undergraduate', $this -> params['pass']))
			{
				$this -> paginate = array(
						'order' => array('submit_date' => 'desc'),
						'conditions' => array('AND' => array(
									$this -> _filterBills(),
									'Bill.category' => 'Undergraduate'
							))
				);
				$this -> set('bills', $this -> paginate('Bill'));
			}
			elseif (in_array('Graduate', $this -> params['pass']))
			{
				$this -> paginate = array(
						'order' => array('submit_date' => 'desc'),
						'conditions' => array('AND' => array(
									$this -> _filterBills(),
									'Bill.category' => 'Graduate'
							))
				);
				$this -> set('bills', $this -> paginate('Bill'));
			}
			else
			{
				$this -> paginate = array(
						'order' => array('submit_date' => 'desc'),
						'conditions' => array('AND' => array($this -> _filterBills()))
				);
				$this -> set('bills', $this -> paginate('Bill'));
			}
		}

		/**
		 * Handles the logic to create a power index of all of the bills in the system.
		 * Redirects to admin_index if necessary.
		 * Based on which category has been chosen will show bills that are in one of the following
		 * stages: "Awating Author", "Authored", "Agenda", "Passed", "Failed", "Archived." Defaults to showing
		 * all of the bills.
		 */
		function power_index()
		{
			if ($this -> isLevel('admin'))
			{
				$this -> redirect('/admin/bills/index/All');
			}
			$this -> requireLevel('power');
			$this -> Bill -> recursive = 2;
			if (in_array('All', $this -> params['pass']))
			{
				$this -> Session -> delete($this -> name . '.keyword');
				$this -> paginate = array(
						'order' => array('submit_date' => 'desc')
				);
				$this -> set('bills', $this -> paginate('Bill'));
			}
			else if (in_array('Awaiting Author', $this -> params['pass']))
			{
				$this -> paginate = array(
						'order' => array('submit_date' => 'desc'),
						'conditions' => array('AND' => array(
									$this -> _filterBills(),
									'Bill.status' => 'Awaiting Author'
							))
				);
				$this -> set('bills', $this -> paginate('Bill'));
			}
			elseif (in_array('Authored', $this -> params['pass']))
			{
				$this -> paginate = array(
						'order' => array('submit_date' => 'desc'),
						'conditions' => array('AND' => array(
									$this -> _filterBills(),
									'Bill.status' => 'Authored'
							))
				);
				$this -> set('bills', $this -> paginate('Bill'));
			}
			elseif (in_array('Agenda', $this -> params['pass']))
			{
				$this -> paginate = array(
						'order' => array('submit_date' => 'desc'),
						'conditions' => array('AND' => array(
									$this -> _filterBills(),
									'Bill.status' => 'Agenda'
							))
				);
				$this -> set('bills', $this -> paginate('Bill'));
			}
			elseif (in_array('Passed', $this -> params['pass']))
			{
				$this -> paginate = array(
						'order' => array('submit_date' => 'desc'),
						'conditions' => array('AND' => array(
									$this -> _filterBills(),
									'Bill.status' => 'Passed'
							))
				);
				$this -> set('bills', $this -> paginate('Bill'));
			}
			elseif (in_array('Failed', $this -> params['pass']))
			{
				$this -> paginate = array(
						'order' => array('submit_date' => 'desc'),
						'conditions' => array('AND' => array(
									$this -> _filterBills(),
									'Bill.status' => 'Failed'
							))
				);
				$this -> set('bills', $this -> paginate('Bill'));
			}
			elseif (in_array('Archived', $this -> params['pass']))
			{
				$this -> paginate = array(
						'order' => array('submit_date' => 'desc'),
						'conditions' => array('AND' => array(
									$this -> _filterBills(),
									'Bill.status' => 'Archived'
							))
				);
				$this -> set('bills', $this -> paginate('Bill'));
			}
			elseif (in_array('Joint', $this -> params['pass']))
			{
				$this -> paginate = array(
						'order' => array('submit_date' => 'desc'),
						'conditions' => array('AND' => array(
									$this -> _filterBills(),
									'Bill.category' => 'Joint'
							))
				);
				$this -> set('bills', $this -> paginate('Bill'));
			}
			elseif (in_array('Conference', $this -> params['pass']))
			{
				$this -> paginate = array(
						'order' => array('submit_date' => 'desc'),
						'conditions' => array('AND' => array(
									$this -> _filterBills(),
									'Bill.category' => 'Conference'
							))
				);
				$this -> set('bills', $this -> paginate('Bill'));
			}
			elseif (in_array('Undergraduate', $this -> params['pass']))
			{
				$this -> paginate = array(
						'order' => array('submit_date' => 'desc'),
						'conditions' => array('AND' => array(
									$this -> _filterBills(),
									'Bill.category' => 'Undergraduate'
							))
				);
				$this -> set('bills', $this -> paginate('Bill'));
			}
			elseif (in_array('Graduate', $this -> params['pass']))
			{
				$this -> paginate = array(
						'order' => array('submit_date' => 'desc'),
						'conditions' => array('AND' => array(
									$this -> _filterBills(),
									'Bill.category' => 'Graduate'
							))
				);
				$this -> set('bills', $this -> paginate('Bill'));
			}
			else
			{
				$this -> paginate = array(
						'order' => array('submit_date' => 'desc'),
						'conditions' => array('AND' => array($this -> _filterBills()))
				);
				$this -> set('bills', $this -> paginate('Bill'));
			}
		}

		function officer_index()
		{
			$this -> requireLevel('user');
			if (in_array('All', $this -> params['pass']))
			{
				$this -> Session -> delete($this -> name . '.keyword');
				$this -> paginate = array(
						'order' => array('submit_date' => 'desc')
				);
				$this -> set('bills', $this -> paginate('Bill'));
			}
			else if (in_array('Awaiting Author', $this -> params['pass']))
			{
				$this -> paginate = array(
						'order' => array('submit_date' => 'desc'),
						'conditions' => array('AND' => array(
									$this -> _filterBills(),
									'Bill.status' => 'Awaiting Author'
							))
				);
				$this -> set('bills', $this -> paginate('Bill'));
			}
			elseif (in_array('Authored', $this -> params['pass']))
			{
				$this -> paginate = array(
						'order' => array('submit_date' => 'desc'),
						'conditions' => array('AND' => array(
									$this -> _filterBills(),
									'Bill.status' => 'Authored'
							))
				);
				$this -> set('bills', $this -> paginate('Bill'));
			}
			elseif (in_array('Agenda', $this -> params['pass']))
			{
				$this -> paginate = array(
						'order' => array('submit_date' => 'desc'),
						'conditions' => array('AND' => array(
									$this -> _filterBills(),
									'Bill.status' => 'Agenda'
							))
				);
				$this -> set('bills', $this -> paginate('Bill'));
			}
			elseif (in_array('Passed', $this -> params['pass']))
			{
				$this -> paginate = array(
						'order' => array('submit_date' => 'desc'),
						'conditions' => array('AND' => array(
									$this -> _filterBills(),
									'Bill.status' => 'Passed'
							))
				);
				$this -> set('bills', $this -> paginate('Bill'));
			}
			elseif (in_array('Failed', $this -> params['pass']))
			{
				$this -> paginate = array(
						'order' => array('submit_date' => 'desc'),
						'conditions' => array('AND' => array(
									$this -> _filterBills(),
									'Bill.status' => 'Failed'
							))
				);
				$this -> set('bills', $this -> paginate('Bill'));
			}
			elseif (in_array('Archived', $this -> params['pass']))
			{
				$this -> paginate = array(
						'order' => array('submit_date' => 'desc'),
						'conditions' => array('AND' => array(
									$this -> _filterBills(),
									'Bill.status' => 'Archived'
							))
				);
				$this -> set('bills', $this -> paginate('Bill'));
			}
			elseif (in_array('Joint', $this -> params['pass']))
			{
				$this -> paginate = array(
						'order' => array('submit_date' => 'desc'),
						'conditions' => array('AND' => array(
									$this -> _filterBills(),
									'Bill.category' => 'Joint'
							))
				);
				$this -> set('bills', $this -> paginate('Bill'));
			}
			elseif (in_array('Conference', $this -> params['pass']))
			{
				$this -> paginate = array(
						'order' => array('submit_date' => 'desc'),
						'conditions' => array('AND' => array(
									$this -> _filterBills(),
									'Bill.category' => 'Conference'
							))
				);
				$this -> set('bills', $this -> paginate('Bill'));
			}
			elseif (in_array('Undergraduate', $this -> params['pass']))
			{
				$this -> paginate = array(
						'order' => array('submit_date' => 'desc'),
						'conditions' => array('AND' => array(
									$this -> _filterBills(),
									'Bill.category' => 'Undergraduate'
							))
				);
				$this -> set('bills', $this -> paginate('Bill'));
			}
			elseif (in_array('Graduate', $this -> params['pass']))
			{
				$this -> paginate = array(
						'order' => array('submit_date' => 'desc'),
						'conditions' => array('AND' => array(
									$this -> _filterBills(),
									'Bill.category' => 'Graduate'
							))
				);
				$this -> set('bills', $this -> paginate('Bill'));
			}
			else
			{
				$this -> paginate = array(
						'order' => array('submit_date' => 'desc'),
						'conditions' => array('AND' => array($this -> _filterBills()))
				);
				$this -> set('bills', $this -> paginate('Bill'));
			}
		}

		/**
		 * Handles the logic to create a general index of all of the bills in the system.
		 * Redirects to admin and power indexes if necessary.
		 * Based on which category has been chosen will show bills that are in one of the following
		 * stages: "Awating Author", "Authored", "Agenda", "Passed", "Failed", "Archived." Defaults to showing
		 * all of the bills.
		 */
		function index()
		{
			if ($this -> isLevel('admin'))
			{
				$this -> redirect('/admin/bills/index/All');
			}
			else if ($this -> isLevel('power'))
			{
				$this -> redirect('/power/bills/index/All');
			}
			$this -> requireLevel('user');
			$this -> Bill -> recursive = 2;
			if (in_array('All', $this -> params['pass']))
			{
				$this -> Session -> delete($this -> name . '.keyword');
				$this -> paginate = array(
						'order' => array('submit_date' => 'desc')
				);
				$this -> set('bills', $this -> paginate('Bill'));
			}
			else if (in_array('Awaiting Author', $this -> params['pass']))
			{
				$this -> paginate = array(
						'order' => array('submit_date' => 'desc'),
						'conditions' => array('AND' => array(
									$this -> _filterBills(),
									'Bill.status' => 'Awaiting Author'
							))
				);
				$this -> set('bills', $this -> paginate('Bill'));
			}
			elseif (in_array('Authored', $this -> params['pass']))
			{
				$this -> paginate = array(
						'order' => array('submit_date' => 'desc'),
						'conditions' => array('AND' => array(
									$this -> _filterBills(),
									'Bill.status' => 'Authored'
							))
				);
				$this -> set('bills', $this -> paginate('Bill'));
			}
			elseif (in_array('Agenda', $this -> params['pass']))
			{
				$this -> paginate = array(
						'order' => array('submit_date' => 'desc'),
						'conditions' => array('AND' => array(
									$this -> _filterBills(),
									'Bill.status' => 'Agenda'
							))
				);
				$this -> set('bills', $this -> paginate('Bill'));
			}
			elseif (in_array('Passed', $this -> params['pass']))
			{
				$this -> paginate = array(
						'order' => array('submit_date' => 'desc'),
						'conditions' => array('AND' => array(
									$this -> _filterBills(),
									'Bill.status' => 'Passed'
							))
				);
				$this -> set('bills', $this -> paginate('Bill'));
			}
			elseif (in_array('Failed', $this -> params['pass']))
			{
				$this -> paginate = array(
						'order' => array('submit_date' => 'desc'),
						'conditions' => array('AND' => array(
									$this -> _filterBills(),
									'Bill.status' => 'Failed'
							))
				);
				$this -> set('bills', $this -> paginate('Bill'));
			}
			elseif (in_array('Archived', $this -> params['pass']))
			{
				$this -> paginate = array(
						'order' => array('submit_date' => 'desc'),
						'conditions' => array('AND' => array(
									$this -> _filterBills(),
									'Bill.status' => 'Archived'
							))
				);
				$this -> set('bills', $this -> paginate('Bill'));
			}
			else
			{
				$this -> paginate = array(
						'order' => array('submit_date' => 'desc'),
						'conditions' => array('AND' => array($this -> _filterBills()))
				);
				$this -> set('bills', $this -> paginate('Bill'));
			}
		}

		/**
		 * A power view of a bill.
		 * Redirects to admin_view if necessary.
		 */
		function power_view($id = null)
		{
			if ($this -> isLevel('admin'))
			{
				$this -> redirect('/admin/bills/view/' . $id);
			}

			$this -> requireLevel('power');
			if (!$id)
			{
				$this -> Session -> setFlash(__('Invalid bill', true));
				$this -> redirect(array('action' => 'index'));
			}
			$this -> Bill -> contain = array(
					'Organization.name',
					'Organization.id',
					'UndergradAuthor' => array(
							'User.id',
							'User.name'
					),
					'GraduateAuthor' => array(
							'User.id',
							'User.name'
					),
					'Submitter.id',
					'Submitter.name'
			);
			$this -> Bill -> recursive = 2;
			$bill = $this -> Bill -> read(null, $id);
			$this -> set('bill', $bill);
			$valid = array(
					$bill['Bill']['user_id'],
					$bill['UndergradAuthor']['user_id'],
					$bill['GraduateAuthor']['user_id']
			);
			$permitted = false;
			if (in_array($this -> getUser(), $valid))
				$permitted = true;
			$this -> set('permitted', $permitted);
		}

		/**
		 * A admin view of a bill.
		 */
		function admin_view($id = null)
		{
			$this -> requireLevel('admin');
			if (!$id)
			{
				$this -> Session -> setFlash(__('Invalid bill', true));
				$this -> redirect(array('action' => 'index'));
			}
			$this -> Bill -> contain = array(
					'Organization.name',
					'Organization.id',
					'UndergradAuthor' => array(
							'User.id',
							'User.name'
					),
					'GraduateAuthor' => array(
							'User.id',
							'User.name'
					),
					'Submitter.id',
					'Submitter.name'
			);
			$this -> Bill -> recursive = 2;
			$bill = $this -> Bill -> read(null, $id);
			$this -> set('bill', $bill);
			$valid = array(
					$bill['Bill']['user_id'],
					$bill['UndergradAuthor']['user_id'],
					$bill['GraduateAuthor']['user_id']
			);
			$permitted = false;
			if (in_array($this -> getUser(), $valid))
				$permitted = true;
			$this -> set('permitted', $permitted);
		}

		/**
		 * An owner view of a bill.
		 * Redirects to admin_view or power_view if necessary.
		 */
		function owner_view($id = null)
		{
			if ($this -> isLevel('admin'))
			{
				$this -> redirect('/admin/bills/view/' . $id);
			}
			else
			if ($this -> isLevel('power'))
			{
				$this -> redirect('/power/bills/view/' . $id);
			}
			else
			{
				if (!$id)
				{
					$this -> Session -> setFlash(__('Invalid bill', true));
					$this -> redirect(array('action' => 'index'));
				}
				$this -> Bill -> contain = array(
						'Organization.name',
						'Organization.id',
						'UndergradAuthor' => array(
								'User.id',
								'User.name'
						),
						'GraduateAuthor' => array(
								'User.id',
								'User.name'
						),
						'Submitter.id',
						'Submitter.name'
				);
				$this -> Bill -> recursive = 2;
				$bill = $this -> Bill -> read(null, $id);
				$this -> requireUser(array(
						$bill['Bill']['user_id'],
						$bill['GraduateAuthor']['user_id'],
						$bill['UndergradAuthor']['user_id']
				));
				$this -> set('bill', $bill);
				$valid = array(
						$bill['Bill']['user_id'],
						$bill['UndergradAuthor']['user_id'],
						$bill['GraduateAuthor']['user_id']
				);
				$permitted = false;
				if (in_array($this -> getUser(), $valid))
					$permitted = true;
				$this -> set('permitted', $permitted);
			}
		}

		/**
		 * An officer view of a bill.
		 * Redirects to admin_view or power_view if necessary.
		 */
		function officer_view($id = null)
		{
			if ($this -> isLevel('admin'))
			{
				$this -> redirect('/admin/bills/view/' . $id);
			}
			else
			if ($this -> isLevel('power'))
			{
				$this -> redirect('/power/bills/view/' . $id);
			}
			else
			{
				if (!$id)
				{
					$this -> Session -> setFlash(__('Invalid bill', true));
					$this -> redirect(array('action' => 'index'));
				}
				$this -> Bill -> contain = array(
						'Organization.name',
						'Organization.id',
						'UndergradAuthor' => array(
								'User.id',
								'User.name'
						),
						'GraduateAuthor' => array(
								'User.id',
								'User.name'
						),
						'Submitter.id',
						'Submitter.name'
				);
				$this -> Bill -> recursive = 2;
				$bill = $this -> Bill -> read(null, $id);
				$this -> requireUser(array(
						$bill['Bill']['user_id'],
						$bill['GraduateAuthor']['user_id'],
						$bill['UndergradAuthor']['user_id']
				));
				$this -> set('bill', $bill);
				$valid = array(
						$bill['Bill']['user_id'],
						$bill['UndergradAuthor']['user_id'],
						$bill['GraduateAuthor']['user_id']
				);
				$permitted = false;
				if (in_array($this -> getUser(), $valid))
					$permitted = true;
				$this -> set('permitted', $permitted);
			}
		}

		/**
		 * Creates a bill.
		 */
		function admin_add()
		{
			$this -> requireLevel('admin');
			if (!empty($this -> data))
			{
				$this -> Bill -> create();

				$this -> loadModel('User');
				//$ids = $this -> User -> find('all', array(
				//		'fields' => array('User.id'),
				//		'conditions' => array('User.gtUsername' => $this -> data['Bill']['gtUsername'])
				//));
				$this -> Bill -> set('user_id', $this -> getUser());
				$org = $this -> Bill -> Organization -> read(null, $this -> data['Bill']['organization_id']);
				$this -> data['Bill']['dues'] = $org['Organization']['dues'];
				if ($this -> Bill -> save($this -> data))
				{
					$this -> Session -> setFlash(__('The bill has been saved. Please add line items.', true));

					//Email selected bill authors.
					$this -> _updateBillOwners($this -> Bill -> id);

					$this -> redirect(array(
							'owner' => true,
							'controller' => 'line_items',
							'action' => 'add',
							$this -> Bill -> id
					));
				}
				else
				{
					$this -> Session -> setFlash(__('The bill could not be saved. Please, try again.', true));
				}
			}
			$this -> setGradAuthors();
			$this -> setUnderAuthors();
			$this -> setOrganizations();
		}

		/**
		 * Allows power users to edit a bill.
		 */
		function power_edit($id = null)
		{
			$this -> requireLevel('power');
			if (!$id && empty($this -> data))
			{
				$this -> Session -> setFlash(__('Invalid bill.', true));
				$this -> redirect(array('action' => 'index'));
			}
			if (!empty($this -> data))
			{
				if ($this -> data['Bill']['status'] == 'Awaiting Author')
				{
					if ($this -> data['Bill']['category'] == 'Joint' && $this -> data['Bill']['underAuthorApproved'] == '1' && $this -> data['Bill']['gradAuthorApproved'] == '1')
					{
						$this -> data['Bill']['status'] = 'Authored';
					}
					else
					if ($this -> data['Bill']['category'] == 'Graduate' && $this -> data['Bill']['gradAuthorApproved'] == '1')
					{
						$this -> data['Bill']['status'] = 'Authored';
					}
					else
					if ($this -> data['Bill']['category'] == 'Undergraduate' && $this -> data['Bill']['underAuthorApproved'] == '1')
					{
						$this -> data['Bill']['status'] = 'Authored';
					}
				}
				if ($this -> Bill -> save($this -> data))
				{
					$this -> Session -> setFlash(__('The bill has been saved.', true));
					$this -> redirect(array(
							'action' => 'view',
							$id
					));
				}
				else
				{
					$this -> Session -> setFlash(__('The bill could not be saved. Please try again.', true));
				}
			}
			if (empty($this -> data))
			{
				//$this->Bill->contain = array('Organization.name', 'Organization.id', 'UndergradAuthor' => array('User.id', 'User.name'), 'GraduateAuthor' =>
				// array('User.id', 'User.name'), 'Submitter.id', 'Submitter.name');
				$this -> data = $this -> Bill -> read(null, $id);
			}
			$this -> setGradAuthors();
			$this -> setUnderAuthors();
			$this -> setOrganizations();
			$this -> Bill -> contain = array(
					'Organization.name',
					'Organization.id',
					'UndergradAuthor' => array(
							'User.id',
							'User.name'
					),
					'GraduateAuthor' => array(
							'User.id',
							'User.name'
					),
					'Submitter.id',
					'Submitter.name'
			);
			$this -> Bill -> recursive = 2;
			$bill = $this -> Bill -> read(null, $id);
			//$this->requireUser(array($bill['Bill']['user_id'], $bill['GraduateAuthor']['user_id'], $bill['UndergradAuthor']['user_id']));
			$this -> set('bill', $bill);
			$valid = array(
					$bill['Bill']['user_id'],
					$bill['UndergradAuthor']['user_id'],
					$bill['GraduateAuthor']['user_id']
			);
			$permitted = false;
			if (in_array($this -> getUser(), $valid))
				$permitted = true;
			$this -> set('permitted', $permitted);
		}

		/**
		 * Allows admins to place bills on the "Agenda", in other words, change the state of the bill.
		 */
		function admin_place($id = null)
		{
			$this -> requireLevel('admin');
			if (!$id && empty($this -> data))
			{
				$this -> Session -> setFlash(__('Invalid bill', true));
				$this -> redirect(array('action' => 'index'));
			}
			$this -> Bill -> contain = array(
					'Organization.name',
					'Organization.id',
					'UndergradAuthor' => array(
							'User.id',
							'User.name'
					),
					'GraduateAuthor' => array(
							'User.id',
							'User.name'
					),
					'Submitter.id',
					'Submitter.name'
			);
			$this -> Bill -> recursive = 0;
			$bill = $this -> Bill -> read(null, $id);
			if ($bill['Bill']['status'] == 'Authored')
			{
				if (($bill['Bill']['underAuthorApproved'] && $bill['Bill']['gradAuthorApproved']) || ($bill['Bill']['category'] == 'Undergraduate' && $bill['Bill']['underAuthorApproved']) || ($bill['Bill']['category'] == 'Graduate' && $bill['Bill']['gradAuthorApproved']))
				{
					$this -> Bill -> set('status', 'Agenda');

					if (empty($bill['Bill']['number']))
					{
						if ($bill['Bill']['type'] == 'Budget')
							$this -> Bill -> set('number', $this -> getValidNumber('Budget'));
						$this -> Bill -> set('number', $this -> getValidNumber($bill['Bill']['category']));
					}

					if ($this -> Bill -> save())
					{
						$this -> Session -> setFlash(__('The bill has been moved to Agenda status.', true));
					}
					else
					{
						$this -> Session -> setFlash(__('The bill could not be moved to Agenda status.', true));
					}
				}
				else
				{
					$this -> Session -> setFlash("The bill must be approved by all authors before being moved to Agenda status.", true);
				}
			}
			$this -> redirect(array(
					'action' => 'view',
					$id
			));
		}

		/**
		 * Allows admins to edit a bill.
		 */
		function admin_edit($id = null)
		{
			$this -> Bill -> contain = array(
					'Organization.name',
					'Organization.id',
					'UndergradAuthor' => array(
							'User.id',
							'User.name'
					),
					'GraduateAuthor' => array(
							'User.id',
							'User.name'
					),
					'Submitter.id',
					'Submitter.name'
			);
			$this -> Bill -> recursive = 2;
			$bill = $this -> Bill -> read(null, $id);
			//$this->requireUser(array($bill['Bill']['user_id'], $bill['GraduateAuthor']['user_id'], $bill['UndergradAuthor']['user_id']));
			$this -> set('bill', $bill);
			$valid = array(
					$bill['Bill']['user_id'],
					$bill['UndergradAuthor']['user_id'],
					$bill['GraduateAuthor']['user_id']
			);
			$permitted = false;
			if (in_array($this -> getUser(), $valid))
				$permitted = true;
			$this -> set('permitted', $permitted);
			if (!$this -> isLevel('admin'))
			{
				$this -> redirect('/power/bills/edit/' . $id);
			}
			else
			{
				$this -> requireLevel('admin');
				if (!$id && empty($this -> data))
				{
					$this -> Session -> setFlash(__('Invalid bill', true));
					$this -> redirect(array('action' => 'index'));
				}
				if (!empty($this -> data))
				{
					if ($this -> data['Bill']['status'] == 'Awaiting Author')
					{
						if ($this -> data['Bill']['category'] == 'Joint' && $this -> data['Bill']['underAuthorApproved'] == '1' && $this -> data['Bill']['gradAuthorApproved'] == '1')
						{
							$this -> data['Bill']['status'] = 'Authored';
						}
						else
						if ($this -> data['Bill']['category'] == 'Graduate' && $this -> data['Bill']['gradAuthorApproved'] == '1')
						{
							$this -> data['Bill']['status'] = 'Authored';
						}
						else
						if ($this -> data['Bill']['category'] == 'Undergraduate' && $this -> data['Bill']['underAuthorApproved'] == '1')
						{
							$this -> data['Bill']['status'] = 'Authored';
						}
					}
					if ($this -> Bill -> save($this -> data))
					{
						$this -> Session -> setFlash(__('The bill has been saved.', true));
						$this -> redirect(array(
								'action' => 'view',
								$id
						));
					}
					else
					{
						$this -> Session -> setFlash(__('The bill could not be saved. Please try again.', true));
					}
				}
				if (empty($this -> data))
				{
					$this -> Bill -> contain = array(
							'Organization.name',
							'Organization.id',
							'UndergradAuthor' => array(
									'User.id',
									'User.name'
							),
							'GraduateAuthor' => array(
									'User.id',
									'User.name'
							),
							'Submitter.id',
							'Submitter.name'
					);
					$this -> data = $this -> Bill -> read(null, $id);
				}
			}
			$this -> setGradAuthors();
			$this -> setUnderAuthors();
			$this -> setOrganizations();
			$this -> loadModel('User');
			$username = $this -> User -> read(null, $this -> getUser());
			$this -> set('username', $username['User']['name']);
		}

		/**
		 * Allows admins to delete a bill.
		 */
		function admin_delete($id = null)
		{
			$this -> requireLevel('admin');
			if (!$id)
			{
				$this -> Session -> setFlash(__('Invalid ID for bill', true));
				$this -> redirect(array('action' => 'index'));
			}
			if ($this -> Bill -> delete($id))
			{
				$this -> Session -> setFlash(__('Bill deleted.', true));
				$this -> redirect(array('action' => 'index'));
			}
			$this -> Session -> setFlash(__('Bill was not deleted.', true));
			$this -> redirect(array('action' => 'index'));
		}

		/**
		 * Allows power users to delete a bill.
		 */
		function power_delete($id = null)
		{
			$this -> requireLevel('power');
			if (!$id)
			{
				$this -> Session -> setFlash(__('Invalid ID for bill', true));
				$this -> redirect(array('action' => 'index'));
			}
			if ($this -> Bill -> delete($id))
			{
				$this -> Session -> setFlash(__('Bill deleted.', true));
				$this -> redirect(array('action' => 'index'));
			}
			$this -> Session -> setFlash(__('Bill was not deleted.', true));
			$this -> redirect(array('action' => 'index'));
		}

		/**
		 * Allows owners to delete a bill that they own.
		 */
		function owner_delete($id = null)
		{
			$bill = $this -> Bill -> read(null, $id);
			$this -> requireUser(array(
					$bill['Bill']['user_id'],
					$bill['GraduateAuthor']['user_id'],
					$bill['UndergradAuthor']['user_id']
			));

			if (!$id)
			{
				$this -> Session -> setFlash(__('Invalid ID for bill', true));
				$this -> redirect(array('action' => 'index'));
			}

			if ($this -> Bill -> delete($id))
			{
				$this -> Session -> setFlash(__('Bill deleted.', true));
				$this -> redirect(array('action' => 'index'));
			}
			$this -> Session -> setFlash(__('Bill was not deleted.', true));
			$this -> redirect(array('action' => 'index'));
		}

		/**
		 * Creates and sends an email to all of the owners of a bill.
		 */
		function _updateBillOwners($id)
		{
			$this -> Bill -> contain = array(
					'Organization.name',
					'Organization.id',
					'UndergradAuthor' => array(
							'User.id',
							'User.name'
					),
					'GraduateAuthor' => array(
							'User.id',
							'User.name'
					),
					'Submitter.id',
					'Submitter.name'
			);
			$this -> Bill -> recursive = 2;
			$bill = $this -> Bill -> read(null, $id);
			$authors = array();
			if (strlen($bill['GraduateAuthor']['user_id']) > 0)
				$authors[] = $bill['GraduateAuthor']['User']['email'];
			if (strlen($bill['UndergradAuthor']['user_id']) > 0)
				$authors[] = $bill['UndergradAuthor']['User']['email'];
			$authors[] = $bill['Submitter']['email'];
			$this -> Email -> delivery = 'mail';
			$this -> Email -> from = 'JacketPages <gtsgacampus@gmail.com>';
			$this -> Email -> to = $authors;
			$this -> Email -> subject = 'New Bill';
			$this -> Email -> template = 'newbill';
			$this -> Email -> sendAs = 'both';
			$this -> set('bill', $bill);
			$this -> Email -> send();
		}

		/**
		 * Sets the Undergraduate Authors.
		 * Form:
		 * Name -- Department
		 */
		function setUnderAuthors()
		{
			if ($this -> Session -> read('SgaPerson.house') == 'Undergraduate')
				$underAuthors[$this -> Session -> read('SgaPerson.id')] = $this -> Session -> read('User.name');
			$underAuthors[''] = 'Unknown';
			$names = $this -> Bill -> UndergradAuthor -> find('list', array(
					'recursive' => 0,
					'fields' => array(
							'UndergradAuthor.id',
							'User.name'
					),
					'order' => array('User.name ASC'),
					'conditions' => array(
							'UndergradAuthor.house' => 'Undergraduate',
							'UndergradAuthor.id <>' => $this -> Session -> read('SgaPerson.id')
					)
			));
			$departments = $this -> Bill -> UndergradAuthor -> find('list', array(
					'recursive' => 0,
					'fields' => array(
							'User.name',
							'department'
					),
					'order' => array('User.name ASC'),
					'conditions' => array(
							'UndergradAuthor.house' => 'Undergraduate',
							'UndergradAuthor.id <>' => $this -> Session -> read('SgaPerson.id')
					)
			));
			$this -> loadModel('SgaPerson');
			foreach ($names as $key => $name)
			{
				$status = $this -> SgaPerson -> read('SgaPerson.status', $key);
				$status = $status['SgaPerson']['status'];
				if ($status == 'Active')
					$choices[$key] = $name . " -- " . $departments[$name];
			}
			$underAuthors['SGA'] = $choices;
			$this -> set('underAuthors', $underAuthors);
		}

		/**
		 * Sets the organizations that correspond to a specific user.
		 */
		function setMyOrganizations()
		{
			$id = $this -> getUser();
			$this -> loadModel('Membership');
			$orgs[''] = 'Select Organization';
			$ids = $this -> _setOrgs();
			$orgs['My Organizations'] = $this -> Bill -> Organization -> find('list', array('conditions' => array(
						'Organization.id' => $ids,
						'Organization.status' => 'Active'
				)));
			//the org_id for "N/A" is found below
			$ind_id = key($this -> Bill -> Organization -> find('list', array('conditions' => array('Organization.name' => 'N/A'))));
			$orgs['My Organizations'][$ind_id] = 'N/A';
			$this -> set('organizations', $orgs);
		}

		/**
		 * Sets all of the organizations.
		 */
		function setOrganizations()
		{
			$id = $this -> getUser();
			$this -> loadModel('Membership');
			$orgs[''] = 'Select Organization';
			$ids = $this -> Membership -> find('all', array(
					'fields' => array('Membership.organization_id'),
					'recursive' => -1,
					'conditions' => array('Membership.user_id' => $id)
			));
			$orgs['My Organizations'] = $this -> Bill -> Organization -> find('list', array('conditions' => array('Organization.id' => Set::extract('/Membership/organization_id', $ids))));
			//the org_id for "N/A" is found below
			$ind_id = key($this -> Bill -> Organization -> find('list', array('conditions' => array('Organization.name' => 'N/A'))));
			$orgs['My Organizations'][$ind_id] = 'N/A';
			$orgs['All'] = $this -> Bill -> Organization -> find('list');
			$this -> set('organizations', $orgs);
		}

		/**
		 * Sets the Graduate Authors.
		 * Form:
		 * Name -- Department
		 */
		function setGradAuthors()
		{
			if ($this -> Session -> read('SgaPerson.house') == 'Graduate')
			{
				$gradAuthors[$this -> Session -> read('SgaPerson.id')] = $this -> Session -> read('User.name');
			}
			$gradAuthors[''] = 'Unknown';
			$names = $this -> Bill -> GraduateAuthor -> find('list', array(
					'recursive' => 0,
					'order' => array('User.name ASC'),
					'fields' => array(
							'GraduateAuthor.id',
							'User.name'
					),
					'conditions' => array(
							'GraduateAuthor.house' => 'Graduate',
							'GraduateAuthor.id <>' => $this -> Session -> read('SgaPerson.id')
					)
			));
			$departments = $this -> Bill -> GraduateAuthor -> find('list', array(
					'recursive' => 0,
					'order' => array('User.name ASC'),
					'fields' => array(
							'User.name',
							'department'
					),
					'conditions' => array(
							'GraduateAuthor.house' => 'Graduate',
							'GraduateAuthor.id <>' => $this -> Session -> read('SgaPerson.id')
					)
			));
			$this -> loadModel('SgaPerson');
			foreach ($names as $key => $name)
			{
				$status = $this -> SgaPerson -> read('SgaPerson.status', $key);
				$status = $status['SgaPerson']['status'];
				if ($status == 'Active')
					$choices[$key] = $name . " -- " . $departments[$name];
			}
			$gradAuthors['SGA'] = $choices;
			$this -> set('gradAuthors', $gradAuthors);
		}

		/**
		 * Filters which bills show based on a given keyword. Returns all bills whose
		 * title, number, or description match the given keyword.
		 * @TODO This currently resets the search keyword when trying to go to the second
		 * page of results and loses the filter. Try to fix this issue.
		 */
		function _filterBills()
		{
			if (!empty($this -> data)) // && strlen(trim($this -> data['Bill']['keyword'])) >= 2) # this line take out because it was messing up searching for nothing returning everything
				$search = mysql_real_escape_string($this -> data['Bill']['keyword']);
			else if ($this -> Session -> check($this -> name . '.keyword'))
				$search = mysql_real_escape_string($this -> Session -> read($this -> name . '.keyword'));

			$filters = array();
			if (!isset($search))
			{
				$search = "";
			}
			$search = low($search);
			
			$filters = array("lower(Bill.title) like '%" . $search . "%' or lower(Bill.number) like '%" . $search . "%' or lower(Bill.description) like '%" . $search . "%' or lower(Submitter.name) like '%" . $search . "%'");
			$this -> Session -> write($this -> name . '.keyword', $search);
			return $filters;
		}

		/**
		 * Sets the organizations with their Presidents, Treasurers, Room Reservers, Officers,
		 * Advisors, and Members.
		 */
		function _setOrgs()
		{

			$this -> loadModel('Organization');
			$orgs = array();

			$this -> loadModel('Membership');
			$id = $this -> getUser();

			$org_ids = $this -> Membership -> find('list', array(
					'fields' => array('Membership.organization_id'),
					'conditions' => array(
							'Membership.user_id' => $id,
							'Membership.status' => 'Active'
					)
			));

			$organizations = $this -> Organization -> find('all', array('conditions' => array(
						'Organization.id' => $org_ids,
						'Organization.status' => 'Active'
				)));

			foreach ($organizations as $org)
			{
				foreach ($org ['Member'] as $o)
				{
					if ($o['status'] == 'Active')
					{
						if ($o['user_id'] == $id)
						{
							$orgs[] = $o['organization_id'];
						}
					}
				}
				$recent = current($org['President']);
				$count = 0;
				foreach ($org ['President'] as $o)
				{
					if ((strtotime($o['since']) > strtotime($recent['since'])))
					{
						if ($o['user_id'] == $id)
						{
							$recent = $o;
						}
					}
					if (strtotime($o['since']) >= strtotime($this -> getFiscalStartDate()))
					{
						if ($o['user_id'] == $id)
						{
							$orgs[] = $o['organization_id'];
						}
						$count++;
					}
				}
				if ($count == 0 && $recent['user_id'] == $id)
				{
					$orgs[] = $recent['organization_id'];
				}

				$recent = current($org['Treasurer']);
				$count = 0;
				foreach ($org ['Treasurer'] as $o)
				{
					if ((strtotime($o['since']) > strtotime($recent['since'])))
					{
						if ($o['user_id'] == $id)
						{
							$recent = $o;
						}
					}
					if (strtotime($o['since']) >= strtotime($this -> getFiscalStartDate()))
					{
						if ($o['user_id'] == $id)
						{
							$orgs[] = $o['organization_id'];
						}
						$count++;
					}
				}
				if ($count == 0 && $recent['user_id'] == $id)
				{
					$orgs[] = $recent['organization_id'];
				}

				$recent = current($org['Officer']);
				$count = 0;
				foreach ($org ['Officer'] as $o)
				{
					if ((strtotime($o['since']) > strtotime($recent['since'])))
					{
						if ($o['user_id'] == $id)
						{
							$recent = $o;
						}
					}
					if (strtotime($o['since']) >= strtotime($this -> getFiscalStartDate()))
					{
						if ($o['user_id'] == $id)
						{
							$orgs[] = $o['organization_id'];
						}
						$count++;
					}
				}
				if ($count == 0 && $recent['user_id'] == $id)
				{
					$orgs[] = $recent['organization_id'];
				}

				$recent = current($org['RoomReserver']);
				$count = 0;
				foreach ($org ['RoomReserver'] as $o)
				{
					if ((strtotime($o['since']) > strtotime($recent['since'])))
					{
						if ($o['user_id'] == $id)
						{
							$recent = $o;
						}
					}
					if (strtotime($o['since']) >= strtotime($this -> getFiscalStartDate()))
					{
						if ($o['user_id'] == $id)
						{
							$orgs[] = $o['organization_id'];
						}
						$count++;
					}
				}

				if ($count == 0 && $recent['user_id'] == $id)
				{
					$orgs[] = $recent['organization_id'];
				}

				$recent = current($org['Advisor']);
				$count = 0;
				foreach ($org ['Advisor'] as $o)
				{
					if ((strtotime($o['since']) > strtotime($recent['since'])))
					{
						if ($o['user_id'] == $id)
						{
							$recent = $o;
						}
					}
					if (strtotime($o['since']) >= strtotime($this -> getFiscalStartDate()))
					{
						if ($o['user_id'] == $id)
						{
							$orgs[] = $o['organization_id'];
						}
						$count++;
					}
				}
				if ($count == 0 && $recent['user_id'] == $id)
				{
					$orgs[] = $recent['organization_id'];
				}
			}
			return array_unique($orgs);
		}

	}
?>