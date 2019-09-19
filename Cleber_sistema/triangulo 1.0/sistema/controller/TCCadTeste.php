<?php
/*---------------------------------------------------------*\
|	TCCadTeste.php											|
|	Cadastra os Testes
\*---------------------------------------------------------*/
require_once("../model/recordset.php");
$rs = new recordset();

$dados	= array();
$status = array();

$dados['tes_nome'] 		= $_POST['nteste'];
$dados['tes_desc'] 		= $_POST['ndescr'];
$dados['tes_icone']		= $_POST['nicone'];
$dados['tes_ativo'] 	= 1;
$dados['tes_cadpor']	= $_POST['npro'];


if(empty($_POST['nteste'])){
	$status['st'] = "NOK";
	$status['ms'] = "Nome do Teste vazio!";
}
else{
	$rs->Seleciona("tes_nome","Testes_Pers","tes_nome='".$dados['tes_nome']."'");
	$lins = $rs->linhas;
	if($lins == 0){
		$rs->Insere($dados,"Testes_Pers");
		$status['st']	= "OK";
		$status['ms']	= "Teste Cadastrado!";
	}	
	else{
		$status['st'] = "NOK";
		$status['ms'] = "teste j&aacute; cadastrado. Utilize outro nome.";
	}
}

echo json_encode($status);
?>