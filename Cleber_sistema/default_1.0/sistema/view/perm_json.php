<?php
$prm = array();
// Administradores
$prm[1] = array("A"=>1,
				"E"=>1,
				"C"=>1,
				"I"=>1);
// Diretoria
$prm[2] = array("A"=>1,
				"E"=>0,
				"C"=>1,
				"I"=>1);
// Gerencia
$prm[3] = array("A"=>1,
				"E"=>0,
				"C"=>1,
				"I"=>1);
// Coordenação
$prm[4] = array("A"=>1,
				"E"=>1,
				"C"=>1,
				"I"=>1);
// Analistas
$prm[5] = array("A"=>1,
				"E"=>0,
				"C"=>1,
				"I"=>0);
// Assistentes
$prm[6] = array("A"=>1,
				"E"=>0,
				"C"=>1,
				"I"=>0);
// Auxiliares
$prm[7] = array("A"=>1,
				"E"=>0,
				"C"=>1,
				"I"=>0);
// Recepcionista
$prm[8] = array("A"=>0,
				"E"=>0,
				"C"=>1,
				"I"=>0);

echo "<pre>";
print_r($prm);
echo "</pre>";
echo json_encode($prm);

?>