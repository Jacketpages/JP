<?php
class BudgetLineItemsController extends AppController
{
	/**
	 * 
	 * I believe this in a budget implementation that wasn't completed.
	 * The actual Georgia Tech budgets aren't in this format so this
	 * implementation wasn't able to be used. This controller will be left
	 * so that this implementation can be reworked and used at a later date.
	 * 
	 */
	
	
	
		var $name = 'BudgetLineItems';

	/**function index() {
		$this->LineItem->recursive = 0;
	$this->set('BudgetLineItems', $this->paginate());
	 */
	function travel()
	{
	
	}

	function view($id = null)
	{
		if (! $id)
		{
			$this->Session->setFlash ( __ ( 'Invalid line item', true ) );
			$this->redirect ( array ('action' => 'index') );
		}
		$this->set ( 'budgetLineItem', $this->BudgetLineItem->read ( null, $id ) );
	}

	function owner_view($id = null)
	{
		$this->view ( $id );
	}

	function admin_add($bill = null)
	{
		$this->requireLevel ( 'admin' );
		$this->owner_add ( $bill );
	}

	function owner_add($bill = null)
	{
		if ($bill == null)
			$bill = $this->data ['BudgetLineItem'] ['bill_id'];
		$bill = $this->BudgetLineItem->Bill->find ( 'first', array ('conditions' => array ('Bill.id' => $bill)) );
		$this->requireUser ( array ($bill ['Bill'] ['gtUsername'], $bill ['UndergradAuthor'] ['id'], $bill ['GraduateAuthor'] ['id']) );
		if ($bill ['Bill'] ['status'] != 'Awaiting Author')
		{
			$this->Session->setFlash ( "No line items can be added to that bill as it has already entered the process" );
			$this->redirect ( array ('controller' => 'bills', 'action' => 'view', $this->data ['BudgetLineItem'] ['bill_id']) );
		}
		if (! empty ( $this->data ))
		{
			$this->BudgetLineItem->create ();
			if ($this->BudgetLineItem->save ( $this->data ))
			{
				$this->Session->setFlash ( __ ( 'The line item has been created', true ) );
				$this->redirect ( array ('controller' => 'bills', 'action' => 'view', $this->data ['BudgetLineItem'] ['bill_id']) );
			}
			else
			{
				$this->Session->setFlash ( __ ( 'The line item could not be saved. Please, try again.', true ) );
			}
		}
		$this->set ( 'bill', $bill );
	}

	function power_revise($id = null)
	{
		$this->requireLevel ( 'power' );
		if (! empty ( $this->data ))
		{
			$this->BudgetLineItem->create ();
			if ($this->BudgetLineItem->save ( $this->data ))
			{
				$this->Session->setFlash ( __ ( 'The line item has been created', true ) );
				$this->redirect ( array ('controller' => 'bills', 'action' => 'view', $this->data ['BudgetLineItem'] ['bill_id']) );
			}
			else
			{
				$this->Session->setFlash ( __ ( 'The line item could not be saved. Please, try again.', true ) );
			}
		}
		if (empty ( $this->data ))
		{
			$this->data = $this->BudgetLineItem->read ( null, $id );
		}
		$this->data ['BudgetLineItem'] ['parent_id'] = $this->data ['BudgetLineItem'] ['id'];
		$this->data ['BudgetLineItem'] ['id'] = null;
	}

	function admin_revise($id = null)
	{
		$this->power_revise ( $id );
	}

	function power_edit($id = null)
	{
		$this->requireLevel ( 'power' );
		if (! $id && empty ( $this->data ))
		{
			$this->Session->setFlash ( __ ( 'Invalid line item', true ) );
			$this->redirect ( array ('action' => 'index') );
		}
		if (! empty ( $this->data ))
		{
			if ($this->BudgetLineItem->save ( $this->data ))
			{
				$this->Session->setFlash ( __ ( 'The line item has been saved', true ) );
				$this->redirect ( array ('action' => 'index') );
			}
			else
			{
				$this->Session->setFlash ( __ ( 'The line item could not be saved. Please, try again.', true ) );
			}
		}
		if (empty ( $this->data ))
		{
			$this->data = $this->BudgetLineItem->read ( null, $id );
		}
		$parents = $this->BudgetLineItem->Parent2->find ( 'list' );
		$bills = $this->BudgetLineItem->Bill->find ( 'list' );
		$this->set ( compact ( 'parents', 'bills' ) );
	}

	function admin_delete($id = null)
	{
		$this->requireLevel ( 'admin' );
		if (! $id)
		{
			$this->Session->setFlash ( __ ( 'Invalid id for line item', true ) );
			$this->redirect ( array ('controller' => 'bills', 'action' => 'index') );
		}
		if ($this->BudgetLineItem->delete ( $id ))
		{
			$this->Session->setFlash ( __ ( 'Line item deleted', true ) );
			$this->redirect ( array ('controller' => 'bills', 'action' => 'index') );
		}
		$this->Session->setFlash ( __ ( 'Line item was not deleted', true ) );
		$this->redirect ( array ('controller' => 'bills', 'action' => 'index') );
	}
}
?>
