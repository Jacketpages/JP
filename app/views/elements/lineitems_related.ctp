<?php if (!empty($bill['LineItem'])):
?>
<h3>Line Items</h3>
<div id="tabs">
	<ul>
		<li>
			<a href="#Submitted">Submitted</a>
		</li>
		<li>
			<a href="#JFC">JFC</a>
		</li>
		<li>
			<a href="#Graduate">Graduate</a>
		</li>
		<li>
			<a href="#Undergraduate">Undergraduate</a>
		</li>
		<li>
			<a href="#Conference">Conference</a>
		</li>
		<li>
			<a href="#All">All</a>
		</li>
		<li>
			<a href="#Final">Final</a>
		</li>
	</ul>
	<?php
		global $submitted;
		global $jfc;
		global $undergraduate;
		global $graduate;
		global $conference;
		global $final;

		// Compares the names of the line items
		// and sorts based on their values.
		function cmp($a, $b)
		{
			return strcmp($a['name'], $b['name']);
		}

		// Fills out the above arrays with
		// their corresponding line items.
		fillLineItemArrays($bill);

		// Used to create "Copy All Line Items" buttons.
		function createCopyButton($this_alias, $fromstate, $tostate, $fromarray)
		{
			if ($this_alias -> isLevel('power'))
			{
				echo $this_alias -> Form -> create('LineItem', array('action' => 'copyTo' . $tostate));

				for ($i = 0; $i < count($fromarray); $i++)
				{
					echo $this_alias -> Form -> hidden("$i", array(
						'label' => 'LineItem',
						'value' => $fromarray[$i]['id']
					));
				}
				echo $this_alias -> Form -> end(__('Copy from ' . $fromstate, TRUE));
			}
		}
	?>

	<div id="Submitted">
		<?php
			if ($submitted)
			{
				printAllLineItems($submitted, $permitted, $this, $bill);
				createCopyButton($this, "Submitted", "JFC", $submitted);
			}
		?>
	</div>
	<div id="JFC">
		<?php
			if ($jfc)
			{
				printAllLineItems($jfc, $permitted, $this, $bill);
			}
			else
			{
				createCopyButton($this, "Submitted", "JFC", $submitted);
			}
		?>
	</div>
	<div id="Graduate">
		<?php
			if ($graduate)
			{
				printAllLineItems($graduate, $permitted, $this, $bill);
			}
			else
			{
				createCopyButton($this, "Submitted", "Graduate", $submitted);
				createCopyButton($this, "JFC", "Graduate", $jfc);
			}
		?>
	</div>
	<div id="Undergraduate">
		<?php
			if ($undergraduate)
			{
				printAllLineItems($undergraduate, $permitted, $this, $bill);
			}
			else
			{
				createCopyButton($this, "JFC", "Undergraduate", $jfc);
				createCopyButton($this, "Graduate", "Undergraduate", $graduate);
			}
		?>
	</div>
	<div id="Conference">
		<?php
			if ($conference)
			{
				printAllLineItems($conference, $permitted, $this, $bill);
			}
			else
			{
				createCopyButton($this, "Undergraduate", "Conference", $undergraduate);
				createCopyButton($this, "Graduate", "Conference", $graduate);
			}
		?>
	</div>
	<div id="All">
		<?php
			printHeader($bill);
			for ($i = 0; $i < count($submitted); $i++)
			{
				$lineNumber = $i + 1;
				$class = null;
				if ($i % 2 == 0)
				{
					$class = 'class="altrow"';
				}
				echo "<tr " . $class . ">";
				if ($submitted)
				{
					printLineItem($lineNumber, $permitted, $this, $bill, $submitted);
				}
				if ($jfc)
				{
					printLineItem($lineNumber, $permitted, $this, $bill, $jfc);
				}
				if ($undergraduate)
				{
					printLineItem($lineNumber, $permitted, $this, $bill, $undergraduate);
				}
				if ($graduate)
				{
					printLineItem($lineNumber, $permitted, $this, $bill, $graduate);
				}
				if ($conference)
				{
					printLineItem($lineNumber, $permitted, $this, $bill, $conference);
				}
				if ($final)
				{
					printLineItem($lineNumber, $permitted, $this, $bill, $final);
				}
			}
			echo "</table>";
			echo "</div>";
			echo "<div class='related'>";
			echo "<h3>Amounts</h3>";
			echo "<table class='list'>";
			printAmounts($bill, $submitted, true);
			printAmounts($bill, $jfc, true);
			printAmounts($bill, $graduate, true);
			printAmounts($bill, $undergraduate, true);
			printAmounts($bill, $conference, true);
			printAmounts($bill, $final, true);
			echo "</table>";
			echo "</div>";
		?>
		</div>
	<div id="Final">
		<?php
			if ($final)
			{
				printAllLineItems($final, $permitted, $this, $bill);
			}
			else
			{
				createCopyButton($this, "Submitted", "Final", $submitted);
				createCopyButton($this, "Undergraduate", "Final", $undergraduate);
				createCopyButton($this, "Graduate", "Final", $graduate);
				createCopyButton($this, "Conferece", "Final", $conference);
			}
			echo "</div>";
		?>
</div>
<?php endif;?>
<?php
	function fillLineItemArrays($bill_alias)
	{
		global $submitted;
		global $jfc;
		global $undergraduate;
		global $graduate;
		global $conference;
		global $final;
		foreach ($bill_alias['LineItem'] as $lineItem)
		{
			if ($lineItem['state'] == "Submitted")
			{
				$submitted[] = $lineItem;
			}
			if ($lineItem['state'] == "JFC")
			{
				$jfc[] = $lineItem;
			}
			if ($lineItem['state'] == "Undergraduate")
			{
				$undergraduate[] = $lineItem;
			}
			if ($lineItem['state'] == "Graduate")
			{
				$graduate[] = $lineItem;
			}
			if ($lineItem['state'] == "Conference")
			{
				$conference[] = $lineItem;
			}
			if ($lineItem['state'] == "Final")
			{
				$final[] = $lineItem;
			}
		}
		//@TODO test if the arrays are null before calling usort.
		if (strtotime($bill_alias['Bill']['submit_date']) > strtotime("2012-01-24") && strtotime($bill_alias['Bill']['submit_date']) < strtotime("2012-02-04"))
		{
			usort($submitted, "cmp");
			usort($jfc, "cmp");
			usort($undergraduate, "cmp");
			usort($graduate, "cmp");
			usort($conference, "cmp");
			usort($final, "cmp");

		}
	}

	function printHeader($bill_alias)
	{
		echo <<<enddeclare
		<div class="related">
		<table cellpadding="0" cellspacing="0">
		<tr>
		<th>#</th>
		<th>Name</th>
enddeclare;
		echo "<th>";
		__('Cost/Unit');
		echo "</th>";
		echo "<th>";
		__('Qty');
		echo "</th>";
		echo "<th>";
		__('TC');
		echo "</th>";
		if ($bill_alias['Bill']['type'] != 'Resolution')
		{
			echo "<th>";
			__('AR');
			echo "</th>";
		}
		echo "<th>";
		__('Accnt');
		echo "</th>";
		echo <<<enddeclare
		<th>State</th>
		<th></th>
		</tr>
enddeclare;
	}

	function printLineItem($lineNumber, $permitted_alias, $this_alias, $bill_alias, $array)
	{
		$lineItem = $array[$lineNumber - 1];
		if ($lineItem)
		{
			// Print the Line Number
			echo "<td> $lineNumber </td>";

			echo "<td>";
			//If user is owner make name link to the owner's lineitem view
			//otherwise just print the lineitem name
			if ($permitted_alias)
			{
				echo $this_alias -> Html -> link($lineItem['name'], array(
					'controller' => 'line_items',
					'action' => 'view',
					$lineItem['id']
				));
			}
			else
			{
				echo $lineItem['name'];
			}

			echo "</td>";
			echo "<td>$" . number_format($lineItem['costPerUnit'], 2) . "</td>";
			echo "<td>" . $lineItem['quantity'] . "</td>";
			echo "<td>$" . number_format($lineItem['totalCost'], 2) . "</td>";
			if ($bill_alias['Bill']['type'] != 'Resolution')
			{
				echo "<td>$" . number_format($lineItem['amount'], 2) . "</td>";
			}
			echo "<td>" . $lineItem['account'] . "</td>";
			echo "<td>" . $lineItem['state'] . "</td>";
			echo "<td class='actions'>";

			//Show Owner Revision link for owners of the bill
			if ($permitted_alias && $lineItem['state'] == 'Submitted' && $bill_alias['Bill']['status'] == 'Awaiting Author')
			{
				echo $this_alias -> Html -> link(__('Owner Revision', true), array(
					'owner' => true,
					'controller' => 'line_items',
					'action' => 'revise',
					$lineItem['id']
				));
			}
			//Show SGA Revision link for power users
			else
			if ($this_alias -> isLevel('power'))
			{
				echo $this_alias -> Html -> link(__('SGA Revision', true), array(
					'power' => true,
					'controller' => 'line_items',
					'action' => 'revise',
					$lineItem['id']
				));
			}

			//Show Delete link for admins.
			if ($this_alias -> isLevel('admin'))
			{
				//echo '&nbsp;&nbsp;&nbsp;&nbsp;';
				//echo $this->Html->link(__('Edit Original', true), array('power' =>  true,
				//'controller' => 'line_items', 'action' => 'edit', $lineItem['id']));
				echo '&nbsp;&nbsp;&nbsp;&nbsp;';
				echo $this_alias -> Html -> link(__('Delete', true), array(
					'controller' => 'line_items',
					'action' => 'delete',
					$lineItem['id']
				), null, sprintf(__('Are you sure you want to delete this item?', true)));
				echo "</td></tr>";
			}
			else
			{
				//Show Delete Link for owners if bill is not on the Agenda
				if ($permitted_alias && $bill_alias['Bill']['status'] == 'Awaiting Author')
				{
					//echo '&nbsp;&nbsp;&nbsp;&nbsp;';
					//echo $this->Html->link(__('Edit Original', true), array('power' =>  true,
					//'controller' => 'line_items', 'action' => 'edit', $lineItem['id']));
					echo '&nbsp;&nbsp;&nbsp;&nbsp;';
					echo $this_alias -> Html -> link(__('Delete', true), array(
						'controller' => 'line_items',
						'action' => 'delete',
						$lineItem['id']
					), null, sprintf(__('Are you sure you want to delete this item?', true)));
				}
				echo "</td></tr>";
			}
		}
	}

	function printAllLineItems($array, $permitted_alias, $this_alias, $bill_alias)
	{
		printHeader($bill_alias);
		for ($i = 0; $i < count($array); $i++)
		{
			$lineNumber = $i + 1;

			// Row highlighting fix for Chrome and Safari
			if ($i % 2 == 0)
			{
				$class = 'class="altrow"';
			}
			else
			{
				$class = "";
			}
			echo "<tr " . $class . ">";
			// Row highlighting fix for Chrome and Safari
			printLineItem($lineNumber, $permitted_alias, $this_alias, $bill_alias, $array);
		}
		echo "</table>";
		echo "</div>";
		printAmounts($bill_alias, $array);
	}

	function amountPrinter($type, $prettyName, $bill_alias)
	{
		echo "<td class='label'>" . $prettyName . "</td>";
		echo "<td>$";
		echo number_format($bill_alias['Bill'][$type], 2);
		echo "&nbsp;</td>";
	}

	function printAmounts($bill_alias, $array, $allaccounts = false)
	{
		if (($bill_alias['Bill']['type'] == 'Finance Request' || $bill_alias['Bill']['type'] == 'Budget') && $array)
		{
			echo "<div class='related'>";
			if (!$allaccounts)
				echo "<h3>Amounts</h3>";

			if ($bill_alias['Bill']['amount_submitted'] > 0 || $bill_alias['Bill']['budget_submitted'] > 0)
			{
				if (!$allaccounts)
					echo "<table class='list'>";
				if ($allaccounts)
				{
					echo "<tr>";
					echo "<td class = 'label''>" . $array[0]['state'] . ":</td>";
				}
				amountPrinter('amount_' . strtolower($array[0]['state']) . "_py", "Prior Year", $bill_alias);
				amountPrinter('amount_' . strtolower($array[0]['state']) . "_co", "Capital Outlay", $bill_alias);
				amountPrinter('amount_' . strtolower($array[0]['state']), "Total", $bill_alias);
				if ($allaccounts)
					echo "</tr>";
				/*amountPrinter('amount_submitted', 'Submitted', $bill_alias);
				 amountPrinter('amount_jfc', 'JFC', $bill_alias);
				 amountPrinter('amount_undergraduate', 'Undergraduate', $bill_alias);
				 amountPrinter('amount_graduate', 'Graduate', $bill_alias);
				 amountPrinter('amount_conference', 'Conference', $bill_alias);
				 amountPrinter('amount_final', 'Final', $bill_alias);
				 amountPrinter('budget_submitted', 'Submitted', $bill_alias);
				 amountPrinter('budget_jfc', 'JFC', $bill_alias);
				 amountPrinter('budget_undergraduate', 'Undergraduate', $bill_alias);
				 amountPrinter('budget_graduate', 'Graduate', $bill_alias);
				 amountPrinter('budget_conference', 'Conference', $bill_alias);
				 amountPrinter('budget_final', 'Final', $bill_alias);*/
				if (!$allaccounts)
					echo "</table>";
			}
			echo "</div>";
		}
	}
?>