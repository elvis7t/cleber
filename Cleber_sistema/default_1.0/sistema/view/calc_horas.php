<?php

$entrada 	= strtotime("07:30:00");
$saida 		= strtotime("17:00:00");

$util = ($saida-$entrada)/3600; 

$abertura = date("Y-m-d H:i:s", strtotime("2017-03-19 09:35:00"));
$fechamento = date("Y-m-d H:i:s", strtotime("2017-03-19 15:50:00"));

$diaab = strtotime(date("Y-m-d", strtotime($abertura)));
$diafc = strtotime(date("Y-m-d", strtotime($fechamento)));

$horaab = strtotime(date("H:i:s", strtotime($abertura)));
$horafc = strtotime(date("H:i:s", strtotime($fechamento)));


$dias_inteiros = ((($diafc - $diaab)/86400)-1)*($util-1);
echo $dias_inteiros."<br>";
//Fecamento - Entrada

$horas_ab = (($horafc - ($entrada))/3600)-1;
echo $horas_ab."<br>";

//Saida - Abertura
$horas_fc = (($saida-$horaab)/3600)-1;

echo $horas_fc."<br>";
$m = ((strtotime($fechamento) - strtotime($abertura))/3600);
echo $m."<br>";
$n = ($dias_inteiros>0?$dias_inteiros+$horas_ab+$horas_fc:$m);
echo number_format($n,2,".",",");

?>
