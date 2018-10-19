<?php
date_default_timezone_set('America/Sao_Paulo');

session_start("portal");
require_once('../model/recordset.php');
require_once('../class/class.historico.php');
require_once('../class/class.functions.php');
require_once('../class/class.permissoes.php');

$rs_eve = new recordset();
$rs1 = new recordset();
$rs2 = new recordset();
$hist = new historico();
$fn = new functions();
$per = new permissoes();
$resul = array();
extract($_POST);

if($acao == "entra_docs"){
	foreach ($doc as $value) {
		$cod = $rs_eve->autocod("doc_id","entrada_docs");
		$dados['doc_id']		= $cod;
		$dados['doc_tipo'] 		= addslashes($value);
		$dados['doc_ref'] 		= $ref;
		$dados['doc_cli']		= $emp;
		$dados['doc_empresa']	= $_SESSION['usu_empcod'];
		$dados['doc_dep']		= $dep;
		$dados['doc_resp']		= $res;
		$dados['doc_data'] 		= date("Y-m-d H:i:s");
		$dados['doc_status'] 	= 0;
		$dados['doc_obs']		= $obs;
		$dados['doc_local']		= $loc;
		$dados['doc_origem']	= $ori;
		if(!$rs_eve->Insere($dados, "entrada_docs")){
			$dados2['drec_docId'] 	= addslashes($value);
			$dados2['drec_entId'] 	= $cod;
			$dados2['drec_empCod'] 	= $emp;
			$dados2['drec_compet'] 	= $ref;
			$rs2->Insere($dados2, "entradas_recebidos");
			$resul['status'] = "OK";
			$resul['mensagem']="Documento dispon&iacute;vel para o departamento";
			$resul['sql']=$rs_eve->sql;
		}
		else{
			$resul['status']="NOK";
			$resul['mensagem']="Falha no SQL";
			$resul['sql']=$rs_eve->sql;
		}
	}
	echo json_encode($resul);
    exit;
}

if($acao == "entra_docsext"){
	foreach ($doc as $value) {
		
		$cod = $rs_eve->autocod("doc_id","entrada_docs");
		$dados['doc_id']		= $cod;
		$dados['doc_tipo'] 		= addslashes($value);
		$dados['doc_ref'] 		= $ref;
		$dados['doc_empresa']	= $_SESSION['usu_empcod'];
		$dados['doc_cli']		= $emp;
		$dados['doc_dep']		= $dep;
		$dados['doc_resp']		= $res;
		$dados['doc_data'] 		= date("Y-m-d H:i:s");
		$dados['doc_datarec'] 	= date("Y-m-d H:i:s");
		$dados['doc_status'] 	= 99;
		$dados['doc_obs']		= $obs;
		$dados['doc_local']		= $loc;
		$dados['doc_origem']	= $ori;
		$dados['doc_recpor']	= $_SESSION['usu_cod'];

		if(!$rs_eve->Insere($dados, "entrada_docs")){
			$dados2['drec_docId'] 	= addslashes($value);
			$dados2['drec_entId'] 	= $cod;
			$dados2['drec_empCod'] 	= $emp;
			$dados2['drec_compet'] 	= $ref;
			$rs2->Insere($dados2, "entradas_recebidos");
			$resul['status'] = "OK";
			$resul['mensagem']="Documento recebido!";
			$resul['sql']=$rs_eve->sql;
		}
		else{
			$resul['status']="NOK";
			$resul['mensagem']="Falha no SQL";
			$resul['sql']=$rs_eve->sql;
		}
	}
	echo json_encode($resul);
    exit;
}

if($acao == "gera_email"){
	$con = $per->getPermissao("ver_all_docs", $_SESSION["usu_cod"]);
	
		$sql1 = "SELECT a.tarq_id, a.tarq_nome, a.tarq_formato, a.tarq_depart, b.cliarq_detalhes FROM tipos_arquivos a
	JOIN clientes_arquivos b 	ON b.cliarq_arqId = a.tarq_id
	JOIN tri_clientes c			ON c.cod = b.cliarq_empresa
	-- LEFT JOIN tipos_impostos d 		ON d.imp_tdocId = a.tarq_id
	WHERE a.tarq_id NOT IN (SELECT doc_tipo FROM entrada_docs WHERE doc_cli = {$emp} AND doc_ref='{$ref}')
	AND c.cod = {$emp}
	";
	if(isset($dep) && $dep <>""){
		$sql1.= " AND tarq_depart = ".$dep;
	}
	$sql1.=" GROUP BY cliarq_id ORDER BY tarq_nome ASC";
	

	$rs_eve->FreeSql($sql1);
	//echo $rs_eve->sql;

	$items = "";
	if($rs_eve->linhas==0):
	$items = "<tr><td colspan=7> Nenhum documento...</td></tr>";
	else:
		$regs = $rs_eve->linhas;
		while($rs_eve->GeraDados()){
			$det = ($rs_eve->fld("cliarq_detalhes")==NULL?'':'['.$rs_eve->fld("cliarq_detalhes").']');
			$items .= "<tr><td>".htmlentities($rs_eve->fld('tarq_nome'))." ".$det."</td><td>".$rs_eve->fld('tarq_formato')."</td></tr>";
		}
	endif;

	$sql = "SELECT empresa, email FROM tri_clientes WHERE cod = ".$emp;
	$rs_eve->FreeSql($sql);
	$rs_eve->GeraDados();	
	$email = $rs_eve->fld("email");
	$hora = date("H");
	switch (true) {
		case ($hora<12):
			$mensagem = "Bom dia!";
			break;
		case ($hora <18):
			$mensagem = "Boa tarde!";
			break;
		case ($hora<23):
			$mensagem = "Boa boite!";
			break;
		
	}
	//Substituindo variaveis no HTML
	$body = file_get_contents("../view/LAY_OUT_DOCUMENTOS.html");
	$body = str_replace("{EMPRESA}"		, htmlentities($rs_eve->fld("empresa"))	, $body);
	$body = str_replace("{MENSAGEM}"	, $mensagem 			, $body);
	$body = str_replace("{COMPETENCIA}"	, $ref 					, $body);
	$body = str_replace("{ITENS}"		, $items 				, $body);
	$body = str_replace("{EMAIL}"		, $_SESSION['usuario']	, $body);
	$body = str_replace("{ASSINATURA}"	, $_SESSION['sign'] 	, $body);

	$cod = $rs_eve->autocod("mds_id","MailDocumento");
		
	$dados['mds_id']		= $cod;
	$dados['mds_dest']		= $email;
	$dados['mds_subj']		= "SOLICITAÇÃO DE DOCUMENTOS. FECHAMENTO REFERÊNCIA ".$ref;
	$dados['mds_body']		= addslashes($body);
	$dados['mds_comp']		= $ref;
	$dados['mds_sender'] 	= $_SESSION['usu_cod'];
	$dados['mds_hora']		= date('Y-m-d H:i:s');
	$dados['mds_status']	= 2;
	if(!$rs1->Insere($dados,"MailDocumento")){
		$resul['status'] = "OK";
		$resul['mensagem']="E-mail enviado para a caixa de Rascunho!";
		$resul['sql']=$rs1->sql;
	}
	else{
		$resul['status']="NOK";
		$resul['mensagem']="Falha no SQL";
		$resul['sql']=$rs1->sql;
	}
	echo json_encode($resul);
    exit;
}

if($acao == "combo_arquivo"){
	echo "<option value=''>Selecione:</option>";
	// Verifica quais titulos existem na tabela Obrigações para a empresa
	$impos = array();
	
	$sql = "SELECT * FROM clientes_arquivos a 
			JOIN tipos_arquivos b ON b.tarq_id = cliarq_arqId
				WHERE tarq_depart = {$dept} AND cliarq_empresa = {$codi}";
	
	
	$rs_eve->FreeSql($sql); 
	echo $rs_eve->sql;
	while($rs_eve->GeraDados()){
		$det = ($rs_eve->fld("cliarq_detalhes")==NULL?'':'['.$rs_eve->fld("cliarq_detalhes").']');
		//$disable = (!(in_array($rs_eve->fld("tarq_id"), $impos) && ($rs_eve->linhas>2))?"DISABLED":"");
		//$disable = ((in_array($rs_eve->fld("tarq_id"), $impos) && ($rs_eve->linhas>2) && ($rs_eve->fld("tarq_duplica")=='N'))?"DISABLED":"");
		echo "<option value=".$rs_eve->fld("tarq_id").">".$rs_eve->fld("tarq_nome")." ".$det."</option>";
	}
}

if ($acao == "recebe_doc") {
	$dados['doc_status'] = 99;
	$dados['doc_recpor'] = $_SESSION['usu_cod'];
	$dados["doc_datarec"] =  date("Y-m-d H:i:s");
	$resul['status'] = "OK";
	$whr = "doc_id = ".$solic;
		if(!$rs_eve->Altera($dados,"entrada_docs",$whr)){
			$resul['mensagem']="Status Alterado";
			$resul['sql']=$rs_eve->sql;
		}
		else{
			$resul['status']="NOK";
			$resul['mensagem']="Falha no SQL";
			$resul['sql']=$rs_eve->sql;
		}
	echo json_encode($resul);
    exit;
}

if($acao == "atualiza_envios"){
	$opt = "<option value = ''>Selecione:</option>";
	$sql = "SELECT a.env_id, a.env_codEmp , b.imp_id, b.imp_nome FROM impostos_enviados a
		JOIN tipos_impostos b ON b.imp_id = a.env_codImp
		WHERE 1
			AND a.env_codEmp = {$publ_cli}
			AND a.env_compet = '{$publ_ref}'
			AND b.imp_depto = {$publ_dep}
			AND a.env_conferido = 1
			AND a.env_enviado <> 1	";
	$rs_eve->FreeSql($sql);
	while($rs_eve->GeraDados()){
		$opt .= "<option value = ".$rs_eve->fld("imp_id").">".$rs_eve->fld("imp_nome")."</option>";
	}
	echo $opt;
	exit;
}