<?php 
$value_a = "[{\"quiz_id\":1,\"answer\":2},{\"quiz_id\":2,\"answer\":2},{\"quiz_id\":3,\"answer\":1}]";
$array = json_decode($value_a);
foreach ($array as $key => $value) {
	echo $value->quiz_id."-".$value->answer."<br>";
}
?>