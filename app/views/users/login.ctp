<?php
$s = $this->Session->read();
if(isset($s['User']) && $s['User']['name'] != ''){
	echo "Welcome ".$s['User']['name']."! We have you listed as a ".$s['User']['level'].".\n";
}else{
	echo "We do not have you in our system. We will recognize you as a student. Please click <a href=/users/add>here</a> to create a user.\n";
}
if(isset($s['SgaPerson']) && $s['SgaPerson']['house']  != ''){
	echo "We see you are a member of SGA. Your house is ".$s['SgaPerson']['house'].".\n";
}
?>
<br />


<?php
echo $this->Html->link("Home", '/');
?>
