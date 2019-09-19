<?php
/*---------------------------------------------------------*\
|	TCCadOpceos.php										|
|	Cadastra as opções de determinada questão
\*---------------------------------------------------------*/
require_once("../model/recordset.php");
$rs = new recordset();

$dados	= array();
$status = array();

$dados['opc_per_cod'] 	= $_POST['opcod'];
$dados['opc_desc'] 		= $_POST['opdesc'];
$dados['opc_valor']		= $_POST['opvalor'];


if(empty($_POST['opdesc'])){
	$status['st'] = "NOK";
	$status['ms'] = "digite a op&ccedil;&atilde;o!";
}
else{
	$rs->Seleciona("opc_desc","Opc_Perguntas","opc_desc='".$dados['opc_desc']."'");
	$lins = $rs->linhas;
	$status['st']	= "OK";
	$status['ms']	= $rs->sql;

	if($lins == 0){
		$rs->Insere($dados,"Opc_Perguntas");
		$status['st']	= "OK";
		$status['ms']	= "Op&ccedil;&atilde;o Cadastrada!";
	}	
	else{
		$status['st'] = "NOK";
		$status['ms'] = "Op&ccedil;&atilde;o j&aacute; cadastrada. Utilize outra.";
	}
}
echo json_encode($status);
?>