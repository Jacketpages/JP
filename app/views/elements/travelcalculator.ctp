<form>
	<div>
		<label for="IBMR">IBMR (Mileage Rate): </label><input size="3"
			maxlength="3" type="text" value=".555" name="IBMR" />
	</div>
	<div>
		<label for="students">Students Traveling: </label><input size="4"
			maxlength="4" type="text" value="1" name="students" />
	</div>
	<div>
		<label for="distance">Total Mileage: </label><input size="4"
			maxlength="4" type="text" value="300" name="distance" />
	</div>
	<div>
		<span class="notice"></span><label for="funding">Maximum Funding: </label><input
			disabled size="4" maxlength="4" type="text" value="0" name="funding" />
	</div>
</form>
<script type="text/javascript">
$(document).ready(function() 
{
	calculate();
	$("input").change(calculate);
	$(".notice").hide();
});

/**
 * Calculates the maximum funding that can be received
 * for a trip and displays the amount to the page.
 */
function calculate()
{
	var IBMR = $("input[name=IBMR]").val();
	var students = $("input[name=students]").val();
	var miles = $("input[name=distance]").val(); 

	var maxMiles = 6000 * (Math.pow(students, -0.4));
	if (miles > maxMiles)
	{
		miles = maxMiles;
		$(".notice").html("Not all miles are being funded.");
		$(".notice").show();
	}

	var funding = .055 * students * IBMR * miles;
	var maxfunding = .055 * students * IBMR * maxMiles;

	$("input[name=funding]").val(Math.round(funding*100)/100);
}

/**
 * function oldCalculate() {
	var IBMR = $("input[name=IBMR]").val();
	var students = $("input[name=students]").val();
	var distance = $("input[name=distance]").val();
	var maxMiles = 1000;
	var rate = 2.8;
	if(students < 5){
		maxMiles = 6000;
		rate = .21;
	}else if(students < 9){
		maxMiles = 5000;
		rate = .42;
	}else if(students < 13){
		maxMiles = 4000;
		rate = .70;
	}else if(students < 29){
		maxMiles = 2000;
		rate = 1.4;
	}else if(students < 45){
		maxMiles = 1333;
		rate = 2.1;
	}
	var fundedMiles = 0;
	if(distance > 150){
		fundedMiles = Math.min(maxMiles, distance);
	}
	if(fundedMiles != distance){
		$(".notice").html("Not all miles are being funded.");
		$(".notice").show();
	}
	var maxFunding = fundedMiles * IBMR * rate * students;
	if(maxFunding > students * .40 * IBMR * 6000 * .21){
		maxFunding = students * .40 * IBMR * 6000 * .21;
		$(".notice").html("Odd rule hit.");
		$(".notice").show();
	}
	$("input[name=funding]").val(Math.round(maxFunding*100)/100);
}*/
</script>
