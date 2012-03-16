<?php
class Bill extends AppModel {
	var $name = 'Bill';
	var $displayField = 'name';
	var $actsAs = array('Containable');
	public function __construct($id=false,$table=null,$ds=null){
		parent::__construct($id,$table,$ds);
		if($this->getID()){
			$this->virtualFields = array(
	    	"amount_submitted" => "SELECT COALESCE(SUM(LineItem.amount), 0) FROM line_items AS LineItem, bills AS Bill WHERE LineItem.state = 'submitted' AND LineItem.bill_id = Bill.id AND LineItem.bill_id = '".$this->getID()."'",
			"amount_submitted_py" => "SELECT COALESCE(SUM(LineItem.amount), 0) FROM line_items AS LineItem, bills AS Bill WHERE LineItem.state = 'submitted' AND LineItem.bill_id = Bill.id AND LineItem.bill_id = '".$this->getID()."' AND LineItem.account = 'PY'",
			"amount_submitted_co" => "SELECT COALESCE(SUM(LineItem.amount), 0) FROM line_items AS LineItem, bills AS Bill WHERE LineItem.state = 'submitted' AND LineItem.bill_id = Bill.id AND LineItem.bill_id = '".$this->getID()."' AND LineItem.account = 'CO'",
			"amount_jfc" => "SELECT COALESCE(SUM(LineItem.amount), 0) FROM line_items AS LineItem, bills AS Bill WHERE LineItem.state = 'jfc' AND LineItem.bill_id = Bill.id AND LineItem.bill_id = '".$this->getID()."'",
			"amount_jfc_py" => "SELECT COALESCE(SUM(LineItem.amount), 0) FROM line_items AS LineItem, bills AS Bill WHERE LineItem.state = 'jfc' AND LineItem.bill_id = Bill.id AND LineItem.bill_id = '".$this->getID()."' AND LineItem.account = 'PY'",
			"amount_jfc_co" => "SELECT COALESCE(SUM(LineItem.amount), 0) FROM line_items AS LineItem, bills AS Bill WHERE LineItem.state = 'jfc' AND LineItem.bill_id = Bill.id AND LineItem.bill_id = '".$this->getID()."' AND LineItem.account = 'CO'",
			"amount_final" => "SELECT COALESCE(SUM(LineItem.amount), 0) FROM line_items AS LineItem, bills AS Bill WHERE LineItem.state = 'final' AND LineItem.bill_id = Bill.id AND LineItem.bill_id = '".$this->getID()."'",
			"amount_final_py" => "SELECT COALESCE(SUM(LineItem.amount), 0) FROM line_items AS LineItem, bills AS Bill WHERE LineItem.state = 'final' AND LineItem.bill_id = Bill.id AND LineItem.bill_id = '".$this->getID()."' AND LineItem.account = 'PY'",
			"amount_final_co" => "SELECT COALESCE(SUM(LineItem.amount), 0) FROM line_items AS LineItem, bills AS Bill WHERE LineItem.state = 'final' AND LineItem.bill_id = Bill.id AND LineItem.bill_id = '".$this->getID()."' AND LineItem.account = 'CO'",
			"amount_conference" => "SELECT COALESCE(SUM(LineItem.amount), 0) FROM line_items AS LineItem, bills AS Bill WHERE LineItem.state = 'conference' AND LineItem.bill_id = Bill.id AND LineItem.bill_id = '".$this->getID()."'",
			"amount_conference_py" => "SELECT COALESCE(SUM(LineItem.amount), 0) FROM line_items AS LineItem, bills AS Bill WHERE LineItem.state = 'conference' AND LineItem.bill_id = Bill.id AND LineItem.account = 'PY' AND LineItem.bill_id = '".$this->getID()."'",
			"amount_conference_co" => "SELECT COALESCE(SUM(LineItem.amount), 0) FROM line_items AS LineItem, bills AS Bill WHERE LineItem.state = 'conference' AND LineItem.bill_id = Bill.id AND LineItem.account = 'CO' AND LineItem.bill_id = '".$this->getID()."'",
			"amount_conference_ulr" => "SELECT COALESCE(SUM(LineItem.amount), 0) FROM line_items AS LineItem, bills AS Bill WHERE LineItem.state = 'conference' AND LineItem.bill_id = Bill.id AND LineItem.account = 'ULR' AND LineItem.bill_id = '".$this->getID()."'",
			"amount_conference_glr" => "SELECT COALESCE(SUM(LineItem.amount), 0) FROM line_items AS LineItem, bills AS Bill WHERE LineItem.state = 'conference' AND LineItem.bill_id = Bill.id AND LineItem.account = 'GLR' AND LineItem.bill_id = '".$this->getID()."'",
			"amount_graduate" => "SELECT COALESCE(SUM(LineItem.amount), 0) FROM line_items AS LineItem, bills AS Bill WHERE LineItem.state = 'Graduate' AND LineItem.bill_id = Bill.id AND LineItem.bill_id = '".$this->getID()."'",
			"amount_graduate_py" => "SELECT COALESCE(SUM(LineItem.amount), 0) FROM line_items AS LineItem, bills AS Bill WHERE LineItem.state = 'Graduate' AND LineItem.bill_id = Bill.id AND LineItem.account = 'PY' AND LineItem.bill_id = '".$this->getID()."'",
			"amount_graduate_co" => "SELECT COALESCE(SUM(LineItem.amount), 0) FROM line_items AS LineItem, bills AS Bill WHERE LineItem.state = 'Graduate' AND LineItem.bill_id = Bill.id AND LineItem.account = 'CO' AND LineItem.bill_id = '".$this->getID()."'",
			"amount_graduate_glr" => "SELECT COALESCE(SUM(LineItem.amount), 0) FROM line_items AS LineItem, bills AS Bill WHERE LineItem.state = 'Graduate' AND LineItem.bill_id = Bill.id AND LineItem.account = 'GLR' AND LineItem.bill_id = '".$this->getID()."'",
			"amount_undergraduate" => "SELECT COALESCE(SUM(LineItem.amount), 0) FROM line_items AS LineItem, bills AS Bill WHERE LineItem.state = 'Undergraduate' AND LineItem.bill_id = Bill.id AND LineItem.bill_id = '".$this->getID()."'",
			"amount_undergraduate_py" => "SELECT COALESCE(SUM(LineItem.amount), 0) FROM line_items AS LineItem, bills AS Bill WHERE LineItem.state = 'Undergraduate' AND LineItem.bill_id = Bill.id AND LineItem.account = 'PY' AND LineItem.bill_id = '".$this->getID()."'",
			"amount_undergraduate_co" => "SELECT COALESCE(SUM(LineItem.amount), 0) FROM line_items AS LineItem, bills AS Bill WHERE LineItem.state = 'Undergraduate' AND LineItem.bill_id = Bill.id AND LineItem.account = 'CO' AND LineItem.bill_id = '".$this->getID()."'",
			"amount_undergraduate_ulr" => "SELECT COALESCE(SUM(LineItem.amount), 0) FROM line_items AS LineItem, bills AS Bill WHERE LineItem.state = 'Undergraduate' AND LineItem.bill_id = Bill.id AND LineItem.account = 'ULR' AND LineItem.bill_id = '".$this->getID()."'",
			"budget_submitted" => "SELECT COALESCE(SUM(BudgetLineItem.amount), 0) FROM budget_line_items AS BudgetLineItem, bills AS Bill WHERE BudgetLineItem.state = 'submitted' AND BudgetLineItem.bill_id = Bill.id AND BudgetLineItem.bill_id = '".$this->getID()."'",
			"budget_jfc" => "SELECT COALESCE(SUM(BudgetLineItem.amount), 0) FROM budget_line_items AS BudgetLineItem, bills AS Bill WHERE BudgetLineItem.state = 'jfc' AND BudgetLineItem.bill_id = Bill.id AND BudgetLineItem.bill_id = '".$this->getID()."'",
			"budget_final" => "SELECT COALESCE(SUM(BudgetLineItem.amount), 0) FROM budget_line_items AS BudgetLineItem, bills AS Bill WHERE BudgetLineItem.state = 'final' AND BudgetLineItem.bill_id = Bill.id AND BudgetLineItem.bill_id = '".$this->getID()."'",
			"budget_conference" => "SELECT COALESCE(SUM(BudgetLineItem.amount), 0) FROM budget_line_items AS BudgetLineItem, bills AS Bill WHERE BudgetLineItem.state = 'conference' AND BudgetLineItem.bill_id = Bill.id AND BudgetLineItem.bill_id = '".$this->getID()."'",
			"budget_graduate" => "SELECT COALESCE(SUM(BudgetLineItem.amount), 0) FROM budget_line_items AS BudgetLineItem, bills AS Bill WHERE BudgetLineItem.state = 'Graduate' AND BudgetLineItem.bill_id = Bill.id AND BudgetLineItem.bill_id = '".$this->getID()."'",
			"budget_undergraduate" => "SELECT COALESCE(SUM(BudgetLineItem.amount), 0) FROM budget_line_items AS BudgetLineItem, bills AS Bill WHERE BudgetLineItem.state = 'Undergraduate' AND BudgetLineItem.bill_id = Bill.id AND BudgetLineItem.bill_id = '".$this->getID()."'",
			);
		}
	}
	var $hasMany = array(
		'LineItem' => array(
			'className' => 'LineItem',
			'foreignKey' => 'bill_id',
			'dependent' => true,
	),
		'BudgetLineItem' => array(
			'className' => 'BudgetLineItem',
			'foreignKey' => 'bill_id',
			'dependent' => true,
	),
		'ResolutionItem' => array(
			'className' => 'ResolutionItem',
			'foreignKey' => 'bill_id',
			'dependent' => true,
	),
	);
	var $belongsTo = array(
		'Organization' => array(
			'className' => 'Organization',
			'foreignKey' => 'organization_id',
	),
		'UndergradAuthor' => array(
			'className' => 'SgaPerson',
			'foreignKey' => 'underAuthor_id',
			'conditions' => 'UndergradAuthor.house = "Undergraduate"',
	),
		'GraduateAuthor' => array(
			'className' => 'SgaPerson',
			'foreignKey' => 'gradAuthor_id',
			'conditions' => 'GraduateAuthor.house = "Graduate"',
	),
		'Submitter' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
	),
	);
	var $order = array('Bill.submit_date' => 'asc');
	var $validate = array(
		'title' => array(
			'declared' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => 'Must be numbers and letters and cannot be blank.',
	),
	),
		'description' => array(
			'declared' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => 'Must be numbers and letters and cannot be blank.',
	),
	),
		'organization_id' => array(
			'declared' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => 'You must enter an organization.',
	),
	),
		'type' => array(
			'rule' => array('inList', array('Resolution','Finance Request', 'Budget')),
			'message' => 'Invalid type',
	),
		'category' => array(
			'rule' => array('inList', array('Joint', 'Undergraduate', 'Graduate', 'Conference')),
	),
		'status' => array(
			'rule' => array('inList', array('Awaiting Author', 'Authored', 'Agenda', 'Passed', 'Failed', 'Archived')),
	),
	);
}
