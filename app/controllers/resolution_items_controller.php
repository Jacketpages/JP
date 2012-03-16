<?php
class ResolutionItemsController extends AppController
{
	
	var $name = 'ResolutionItems';

	function view($id = null)
	{
		if (! $id)
		{
			$this->Session->setFlash ( __ ( 'Invalid resolution item', true ) );
			$this->redirect ( array ('action' => 'index') );
		}
		$this->set ( 'resolutionItem', $this->ResolutionItem->read ( null, $id ) );
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
			$bill = $this->data ['ResolutionItem'] ['bill_id'];
		$bill = $this->ResolutionItem->Bill->find ( 'first', array ('conditions' => array ('Bill.id' => $bill)) );
		$this->set ( 'bill', $bill );
		$this->requireUser ( array ($bill ['Bill'] ['gtUsername'], $bill ['UndergradAuthor'] ['id'], $bill ['GraduateAuthor'] ['id']) );
		if ($bill ['Bill'] ['status'] == 'Awaiting Author')
		{
			$this->ResolutionItem->create ();
			if ($this->ResolutionItem->save ( $this->data ))
			{
				$this->Session->setFlash ( __ ( 'The resolution item has been created', true ) );
				$this->redirect ( array ('controller' => 'bills', 'action' => 'view', $this->data ['ResolutionItem'] ['bill_id']) );
			}
			else
			{
				$this->Session->setFlash ( __ ( 'The resolution item could not be saved. Please, try again.', true ) );
			}
		}
		else
		{
			$this->Session->setFlash ( "Sorry, the bill has already been approved by representatives." );
			$this->redirect ( array ('controller' => 'bills', 'action' => 'view', $this->data ['ResolutionItem'] ['bill_id']) );
		}
	}

	function power_revise($id = null)
	{
		$this->requireLevel ( 'power' );
		if (! empty ( $this->data ))
		{
			$this->ResolutionItem->create ();
			if ($this->ResolutionItem->save ( $this->data ))
			{
				$this->Session->setFlash ( __ ( 'The resolution item has been created', true ) );
				$this->redirect ( array ('controller' => 'bills', 'action' => 'view', $this->data ['ResolutionItem'] ['bill_id']) );
			}
			else
			{
				$this->Session->setFlash ( __ ( 'The resolution item could not be saved. Please, try again.', true ) );
			}
		}
		if (empty ( $this->data ))
		{
			$this->data = $this->ResolutionItem->read ( null, $id );
		}
		$this->data ['ResolutionItem'] ['parent_id'] = $this->data ['ResolutionItem'] ['id'];
		$this->data ['ResolutionItem'] ['id'] = null;
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
			$this->Session->setFlash ( __ ( 'Invalid resolution item', true ) );
			$this->redirect ( array ('action' => 'index') );
		}
		if (! empty ( $this->data ))
		{
			if ($this->ResolutionItem->save ( $this->data ))
			{
				$this->Session->setFlash ( __ ( 'The resolution item has been saved', true ) );
				$this->redirect ( array ('action' => 'index') );
			}
			else
			{
				$this->Session->setFlash ( __ ( 'The resolution item could not be saved. Please, try again.', true ) );
			}
		}
		if (empty ( $this->data ))
		{
			$this->data = $this->ResolutionItem->read ( null, $id );
		}
		$parents = $this->ResolutionItem->Parent->find ( 'list' );
		$bills = $this->ResolutionItem->Bill->find ( 'list' );
		$this->set ( compact ( 'parents', 'bills' ) );
	}

	function admin_delete($id = null)
	{
		$this->requireLevel ( 'admin' );
		if (! $id)
		{
			$this->Session->setFlash ( __ ( 'Invalid id for resolution item', true ) );
			$this->redirect ( array ('controller' => 'bills', 'action' => 'index') );
		}
		if ($this->ResolutionItem->delete ( $id ))
		{
			$this->Session->setFlash ( __ ( 'Resolution item deleted', true ) );
			$this->redirect ( array ('controller' => 'bills', 'action' => 'index') );
		}
		$this->Session->setFlash ( __ ( 'Resolution item was not deleted', true ) );
		$this->redirect ( array ('controller' => 'bills', 'action' => 'index') );
	}
}
?>
