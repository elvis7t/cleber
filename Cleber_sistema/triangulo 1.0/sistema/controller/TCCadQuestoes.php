<?php
/*---------------------------------------------------------*\
|	TCCadquestoes.php										|
|	Cadastra as questoes do teste
\*---------------------------------------------------------*/
require_once("../model/recordset.php");
$rs = new recordset();

$dados	= array();
$status = array();

$dados['per_tes_cod'] 	= $_POST['qcod'];
$dados['per_desc'] 		= $_POST['qdesc'];


if(empty($_POST['qcod'])){
	$status['st'] = "NOK";
	$status['ms'] = "Fa&ccedil;a a pergunta!";
}
else{
	$rs->Seleciona("per_desc","Perguntas_testes","per_desc='".$dados['per_desc']."'");
	$lins = $rs->linhas;
	$status['st']	= "OK";
	$status['ms']	= $rs->sql;

	if($lins == 0){
		$rs->Insere($dados,"Perguntas_testes");
		$status['st']	= "OK";
		$status['ms']	= "Quest&atilde;o Cadastrada!";
	}	
	else{
		$status['st'] = "NOK";
		$status['ms'] = "teste j&aacute; cadastrado. Utilize outro nome.";
	}
}
echo json_encode($status);
?>