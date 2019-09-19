<?php
/*---------------------------------------------------------*\
|	TCCadResult.php										|
|	Cadastra resultados possives do teste
\*---------------------------------------------------------*/
require_once("../model/recordset.php");
$rs = new recordset();

$dados	= array();
$status = array();

$dados['res_tes_cod'] 		= $_POST['rescod'];
$dados['res_valormin'] 		= $_POST['revmin'];
$dados['res_valomax']		= $_POST['revmax'];
$dados['res_desc']			= $_POST['redesc'];


if(empty($_POST['rescod'])){
	$status['st'] = "NOK";
	$status['ms'] = "digite a op&ccedil;&atilde;o!";
}
else{
	$rs->Insere($dados,"Result_Testes");
	$status['st']	= "OK";
	$status['ms']	= "Resultados e Valores OK!";
}
echo json_encode($status);
?>