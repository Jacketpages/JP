<?php
	class LineItemsController extends AppController
	{

		var $name = 'LineItems';

		/**function index() {
		 $this->LineItem->recursive = 0;
		 $this->set('lineItems', $this->paginate());
		 */

		function admin_copyToJFC()
		{
			$this -> copyLineItems("JFC");
		}

		function admin_copyToUndergraduate()
		{
			$this -> copyLineItems("Undergraduate");
		}

		function admin_copyToGraduate()
		{
			$this -> copyLineItems("Graduate");
		}

		function admin_copyToConference()
		{
			$this -> copyLineItems("Conference");
		}

		function admin_copyToFinal()
		{
			$this -> copyLineItems("Final");
		}

		function power_copyToJFC()
		{
			$this -> copyLineItems("JFC");
		}

		function power_copyToUndergraduate()
		{
			$this -> copyLineItems("Undergraduate");
		}

		function power_copyToGraduate()
		{
			$this -> copyLineItems("Graduate");
		}

		function power_copyToConference()
		{
			$this -> copyLineItems("Conference");
		}

		function power_copyToFinal()
		{
			$this -> copyLineItems("Final");
		}

		function copyLineItems($state)
		{
			if (!empty($this -> data))
			{
				$items = $this -> data['LineItem'];
				$i = 0;
				foreach ($items as $item)
				{
					$this -> data[] = $this -> LineItem -> read(null, $item);
					$i++;
				}
				unset($this -> data['LineItem']);
				for ($i = 0; $i < count($this -> data); $i++)
				{
					$this -> data[$i]['LineItem']['state'] = $state;
					$this -> data[$i]['LineItem']['parent_id'] = $this -> data[$i]['LineItem']['id'];
					$this -> data[$i]['LineItem']['id'] = $this -> LineItem -> getInsertID();
					$this -> LineItem -> create();
				}
				$this -> LineItem -> saveAll($this -> data);
				$this -> redirect(array(
						'controller' => 'bills',
						'action' => 'view',
						$this -> data[0]['LineItem']['bill_id']
				));
			}
		}

		// Delete button looks ugly on the page. Imma leave this alone for now but this one line
		// should do all the work. It just needs checks and output.
		// function admin_deleteSubmitted($bill_id, $state)
		// {
			// $lineitems = $this -> LineItem -> deleteAll(array('conditions' => array("LineItem.bill_id" => $bill_id, "LineItem.state" => $state)));		
		// }
		
		function add($id = null)
		{
			$this -> redirect('/owner/line_items/add/' . $id);
		}

		function travel()
		{

		}

		function admin_view($id = null)
		{
			$this -> redirect('/owner/line_items/view/' . $id);
		}

		function view($id = null)
		{
			if (!$id)
			{
				$this -> Session -> setFlash(__('Invalid line item', true));
				$this -> redirect(array('action' => 'index'));
			}
			$this -> set('lineItem', $this -> LineItem -> read(null, $id));
		}

		function owner_view($id = null)
		{
			$this -> view($id);
		}

		function admin_add($id = null)
		{
			$this -> requireLevel('admin');
			$this -> power_add($id);
		}

		function power_add($id = null)
		{
			$this -> requireLevel('power');
			if ($id == null)
			{
				$id = $this -> data['LineItem']['bill_id'];
			}
			$bill = $this -> LineItem -> Bill -> find('first', array('conditions' => array('Bill.id' => $id)));
			if (!$this -> isLevel('admin'))
			{
				$this -> requireUser(array(
						$bill['Bill']['user_id'],
						$bill['UndergradAuthor']['user_id'],
						$bill['GraduateAuthor']['user_id']
				));
			}
			if (!empty($this -> data))
			{
				if ($this -> data['LineItem']['costPerUnit'] == null)
				{
					$this -> data['LineItem']['costPerUnit'] = '0';
				}
				if ($this -> data['LineItem']['quantity'] == null)
				{
					$this -> data['LineItem']['quantity'] = '0';
				}
				if ($this -> data['LineItem']['totalCost'] == null)
				{
					$this -> data['LineItem']['totalCost'] = '0';
				}
				if ($this -> data['LineItem']['amount'] == null)
				{
					$this -> data['LineItem']['amount'] = '0';
				}
				$this -> LineItem -> create();
				if ($this -> LineItem -> save($this -> data))
				{
					$this -> Session -> setFlash(__('The line item has been created.', true));
					$this -> redirect(array(
							'controller' => 'bills',
							'action' => 'view',
							$id
					));
				}
				else
				{
					$this -> Session -> setFlash(__('The line item could not be saved. Please try again.', true));
					$this -> redirect('/owner/line_items/add/' . $bill);
				}
			}
			$this -> set('bill', $bill);
		}

		function owner_add($id = null)
		{
			if ($id == null)
			{
				$id = $this -> data['LineItem']['bill_id'];
			}
			$bill = $this -> LineItem -> Bill -> find('first', array('conditions' => array('Bill.id' => $id)));
			if (!$this -> isLevel('admin'))
			{
				$this -> requireUser(array(
						$bill['Bill']['user_id'],
						$bill['UndergradAuthor']['user_id'],
						$bill['GraduateAuthor']['user_id']
				));
			}

			if ($bill['Bill']['status'] != 'Awaiting Author')
			{
				$this -> Session -> setFlash("No line items can be added to that bill as it has already entered the process.");

				//$this->redirect(array('controller' => 'bills', 'action' => 'view', $id));
			}
			if (!empty($this -> data))
			{
				if ($this -> data['LineItem']['costPerUnit'] == null)
				{
					$this -> data['LineItem']['costPerUnit'] = '0';
				}
				if ($this -> data['LineItem']['quantity'] == null)
				{
					$this -> data['LineItem']['quantity'] = '0';
				}
				if ($this -> data['LineItem']['totalCost'] == null)
				{
					$this -> data['LineItem']['totalCost'] = '0';
				}
				if ($this -> data['LineItem']['amount'] == null)
				{
					$this -> data['LineItem']['amount'] = '0';
				}
				$this -> LineItem -> create();
				if ($this -> LineItem -> save($this -> data))
				{
					$this -> Session -> setFlash(__('The line item has been created.', true));
					$this -> redirect(array(
							'controller' => 'bills',
							'action' => 'view',
							$id
					));
				}
				else
				{
					$this -> Session -> setFlash(__('The line item could not be saved. Please try again.', true));
					$this -> redirect('/owner/line_items/add/' . $bill);
				}
			}
			$this -> set('bill', $bill);
		}

		function owner_revise($id = null)
		{
			if (empty($this -> data))
			{
				$this -> data = $this -> LineItem -> read(null, $id);
			}
			else
			{
				$this -> LineItem -> $id = $id;
				if ($this -> LineItem -> save($this -> data))
				{
					$this -> Session -> setFlash(__('The line item has been created', true));
					$this -> redirect(array(
							'controller' => 'bills',
							'action' => 'view',
							$this -> data['LineItem']['bill_id']
					));
				}
				else
				{
					$this -> Session -> setFlash(__('The line item could not be saved. Please, try again.', true));
				}
			}
		}

		function power_revise($id = null)
		{
			$this -> requireLevel('power');
			if (!empty($this -> data))
			{
				//Finds the old line item so it can be used to decide whether to update the
				//existing line item or create a new one. Based on the LineItem's state.
				$oldLineItem = $this -> LineItem -> find('first', array('conditions' => array('LineItem.id' => $id)));

				if ($oldLineItem['LineItem']['state'] == $this -> data['LineItem']['state'])
				{
					$this -> LineItem -> $id = $id;
				}
				else
				{
					$this -> data['LineItem']['parent_id'] = $id;
					$this -> data['LineItem']['id'] = null;
					$this -> LineItem -> create();
				}

				if ($this -> LineItem -> save($this -> data))
				{
					$this -> Session -> setFlash(__('The line item has been created', true));
					$this -> redirect(array(
							'controller' => 'bills',
							'action' => 'view',
							$this -> data['LineItem']['bill_id']
					));
				}
				else
				{
					$this -> Session -> setFlash(__('The line item could not be saved. Please, try again.', true));
				}
			}
			if (empty($this -> data))
			{
				$this -> data = $this -> LineItem -> read(null, $id);
			}
		}

		function admin_revise($id = null)
		{
			$this -> requireLevel('admin');
			$this -> power_revise($id);
		}

		function power_edit($id = null)
		{
			$this -> requireLevel('power');
			if (!$id && empty($this -> data))
			{
				$this -> Session -> setFlash(__('Invalid line item', true));
				$this -> redirect(array('action' => 'index'));
			}
			if (!empty($this -> data))
			{
				if ($this -> LineItem -> save($this -> data))
				{
					$this -> Session -> setFlash(__('The line item has been saved', true));
					$this -> redirect(array('action' => 'index'));
				}
				else
				{
					$this -> Session -> setFlash(__('The line item could not be saved. Please, try again.', true));
				}
			}
			if (empty($this -> data))
			{
				$this -> data = $this -> LineItem -> read(null, $id);
			}
			$parents = $this -> LineItem -> Parent -> find('list');
			$bills = $this -> LineItem -> Bill -> find('list');
			$this -> set(compact('parents', 'bills'));
		}

		function admin_delete($id = null)
		{
			$this -> requireLevel('admin');
			if (!$id)
			{
				$this -> Session -> setFlash(__('Invalid id for line item', true));
				$this -> redirect(array(
						'controller' => 'bills',
						'action' => 'index'
				));
			}
			$item = $this -> LineItem -> read(null, $id);
			$bill_id = $item['LineItem']['bill_id'];
			if ($this -> LineItem -> delete($id))
			{
				$this -> Session -> setFlash(__('Line item deleted', true));
				$this -> redirect(array(
						'controller' => 'bills',
						'action' => 'view',
						$bill_id
				));
			}
			$this -> Session -> setFlash(__('Line item was not deleted', true));
			$this -> redirect(array(
					'controller' => 'bills',
					'action' => 'index'
			));
		}

		function power_delete($id = null)
		{
			$this -> requireLevel('power');
			if (!$id)
			{
				$this -> Session -> setFlash(__('Invalid id for line item', true));
				$this -> redirect(array(
						'controller' => 'bills',
						'action' => 'index'
				));
			}
			$item = $this -> LineItem -> read(null, $id);
			$bill_id = $item['LineItem']['bill_id'];
			if ($this -> LineItem -> delete($id))
			{
				$this -> Session -> setFlash(__('Line item deleted', true));
				$this -> redirect(array(
						'controller' => 'bills',
						'action' => 'view',
						$bill_id
				));
			}
			$this -> Session -> setFlash(__('Line item was not deleted', true));
			$this -> redirect(array(
					'controller' => 'bills',
					'action' => 'index'
			));
		}

		function owner_delete($id = null)
		{
			if (!$id)
			{
				$this -> Session -> setFlash(__('Invalid id for line item', true));
				$this -> redirect(array(
						'controller' => 'bills',
						'action' => 'index'
				));
			}
			$item = $this -> LineItem -> read(null, $id);
			$bill_id = $item['LineItem']['bill_id'];
			$bill = $this -> LineItem -> Bill -> find('first', array('conditions' => array('Bill.id' => $bill_id)));
			if (!$this -> isLevel('admin'))
			{
				$this -> requireUser(array(
						$bill['Bill']['user_id'],
						$bill['UndergradAuthor']['user_id'],
						$bill['GraduateAuthor']['user_id']
				));
				if ($bill['Bill']['status'] == 'Agenda' || $bill['Bill']['status'] == 'Authored')
				{
					$this -> Session -> setFlash(__('Line was not item deleted', true));
					$this -> redirect(array(
							'controller' => 'bills',
							'action' => 'view',
							$bill_id
					));
				}
			}
			if ($this -> LineItem -> delete($id))
			{
				$this -> Session -> setFlash(__('Line item deleted', true));
				$this -> redirect(array(
						'controller' => 'bills',
						'action' => 'view',
						$bill_id
				));
			}
			$this -> Session -> setFlash(__('Line item was not deleted', true));
			$this -> redirect(array(
					'controller' => 'bills',
					'action' => 'index'
			));
		}

	}
?>
