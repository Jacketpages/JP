<?php
$fields = array('Number', 'Title', 'Description', 'Type', 'Category', 'Status', 'Organization', 'Undergraduate', 'Graduate', 'Submitter', 'AmountSubmitted', 'AmountJFC', 'AmountUndergrad', 'AmountGrad', 'AmountConference', 'AmountFinal', 'ResolutionSubmitted', 'ResolutionFinal');
$csv->addRow($fields);
foreach($bills as $bill){
	if($bill['Bill']['type'] != 'Resolution'){
		if($bill['Bill']['type'] == 'Finance Request')
		$tag = 'LineItem';
		elseif($bill['Bill']['type'] == 'Budget')
		$tag = 'BudgetItem';
		for($i=0;$i<count($bill[$tag]);$i++){
			$bill['Amounts'][$bill[$tag][$i]['state']] += $bill[$tag][$i]['amount'];
		}
	}elseif($bill['Bill']['type'] == 'Resolution'){
		for($i=0;$i<count($bill['ResolutionItem']);$i++){
			$bill['Resolutions'][$bill['ResolutionItem'][$i]['state']] .= $bill['ResolutionItem'][$i]['content'];
		}
	}
	$rowContents = array($bill['Bill']['number'], $bill['Bill']['title'], $bill['Bill']['description'], $bill['Bill']['type'], $bill['Bill']['category'], $bill['Bill']['status'], $bill['Organization']['name'], $bill['UndergradAuthor']['gtUsername'], $bill['GraduateAuthor']['gtUsername'], $bill['Submitter']['id'], $bill['Amounts']['submitted'], $bill['Amounts']['jfc'], $bill['Amounts']['Undergraduate'], $bill['Amounts']['Graduate'], $bill['Amounts']['conference'], $bill['Amounts']['final'], $bill['Resolutions']['submitted'], $bill['Resolutions']['final']);
	$csv->addRow($rowContents);
}
$csv->setFilename("FY$fy-Bills.csv");
echo $csv->render();
?>