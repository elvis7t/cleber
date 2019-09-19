<table>
	<tr>
		<th>Data</th>
		<th>Deb</th>
		<th>Cred</th>
		<th>Vlr</th>
		<th>Hist</th>
		<th>Compl.</th>
	</tr>

<?php
/*
require_once('../class/class.functions.php');

$fn = new functions();

echo $fn->dia_util(25,'dia_util');
*/

$myfile = fopen("CN24017A.RET","r") or die("Unable to open");
$arr = array();
while(!feof($myfile)) {
	$arr[] = fgets($myfile);
}
foreach ($arr as $key => $value) {
	
		
		echo "<tr>
				<td>".substr($value, 146,2)."/".substr($value, 148,2)."/".substr($value, 150,2)."</td>
				<td></td>
				<td></td>
				<td>".number_format(substr($value, 154,10)/100,2,",",".")."</td>
				<td></td>
				<td>".substr($value, 324,30)."</td>
			";
	
}

fclose($myfile);
?>
</table>