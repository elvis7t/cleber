<?php
/*---------------------------------------------------------*\
|	TCCadResUser.php										|
|	Cadastra o resultado od teste para um usuario
\*---------------------------------------------------------*/
require_once("../model/recordset.php");
$rs = new recordset();

$dados	= array();
$status = array();

$dados['rus_teste_cod'] 	= $_POST['testes'];
$dados['rus_valor'] 	= $_POST['pontos'];
$dados['rus_user']		= $_POST['usuario'];


if(empty($_POST['testes'])){
	$status['st'] = "NOK";
	$status['ms'] = "digite a op&ccedil;&atilde;o!";
}
else{
	$rs->Insere($dados,"Result_users");
	$status['st']	= "OK";
	$status['ms']	= "Resultados e Valores OK!";
}
echo json_encode($status);
?>