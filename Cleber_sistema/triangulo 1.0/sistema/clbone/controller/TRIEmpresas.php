<?php
date_default_timezone_set('America/Sao_Paulo');

session_start();
require_once('../../model/recordset.php');
require_once('../../sistema/class/class.historico.php');
require_once('../class/class.functions.php');
$rs_eve = new recordset();
$rs1 = new recordset();
$hist = new historico();
$fn = new functions();
$resul = array();
extract($_POST);

if($acao == "inclusao"){
	
	$dados = array(
		"sol_emp" => $emp_nome,
		"sol_data" => date("Y-m-d H:i:s"),
		"sol_datareal" => 0,
		"sol_tel" => $emp_tel,
		"sol_cont" => $emp_res,
		"sol_fcom" => $emp_fcom,
		"sol_obs" => $emp_obs,
		"sol_por" => $_SESSION['usu_cod']
	);
	 if (!$rs_eve->Insere($dados,"tri_solic")) {
        $resul["status"] = "OK";
        $resul["mensagem"] = "Novo evento cadastrado!";
        $resul["sql"] = $rs_eve->sql;
    } else {
        $hist->add_hist(11);
		$resul["status"] = "ERRO";
        $resul["mensagem"] = "Falha na inclus&atilde;o";
        $resul["sql"] = $rs_eve->sql;
    }
	echo json_encode($resul);
    exit;
	
}
if($acao == "ligacao"){
	
	$dados = array(
		"sol_emp" => $emp_nome,
		"sol_data" => date("Y-m-d H:i:s"),
		"sol_datareal" => date("Y-m-d H:i:s"),
		"sol_tel" => $emp_tel,
		"sol_cont" => $emp_res,
		"sol_fcom" => $emp_fcom,
		"sol_obs" => $emp_obs,
		"sol_real_por" => $_SESSION['usu_cod'],
		"sol_pres" => $emp_pres,
		"sol_status" => 99
	);
	 if (!$rs_eve->Insere($dados,"tri_ligac")) {
        $resul["status"] = "OK";
        $resul["mensagem"] = "Novo contato cadastrado!";
        $resul["sql"] = $rs_eve->sql;
    } else {
        $hist->add_hist(11);
		$resul["status"] = "ERRO";
        $resul["mensagem"] = "Falha na inclus&atilde;o";
        $resul["sql"] = $rs_eve->sql;
    }
	echo json_encode($resul);
    exit;
	
}


if ($acao == "realizar") {
	$dados = array();
	if($action == "RP"){
		$sql = "INSERT INTO tri_solic (sol_data, sol_por, sol_emp, sol_tel, sol_cont, sol_fcom, sol_obs)
				SELECT now(), sol_por, sol_emp, sol_tel, sol_cont, sol_fcom, sol_obs FROM tri_solic WHERE sol_cod = ".$solic;
		$rs_eve->FreeSQL($sql);
		$resul['mensagem']="Status Alterado";
		$resul['sql']=$rs_eve->sql;
		$resul['status'] = "OK";
	}
	else{

		switch($action){
			case "OK":
				$dados['sol_status'] = 99;
				$dados['sol_real_por'] = $_SESSION['usu_cod']; 
				$dados['sol_datareal'] = date("Y-m-d H:i:s");
				$resul['status'] = "OK";
				
				break;
			case "RE":
				$dados['sol_status'] = 4;
				$dados['sol_real_por'] = 0; 
				$dados['sol_data'] = date("Y-m-d H-i-s"); 
				$resul['status'] = "Reagendado";
				break;
			case "CN":
				$dados['sol_status'] = 97;
				$dados['sol_real_por'] = 0; 
				$dados['sol_data'] = date("Y-m-d H-i-s"); 
				$resul['status'] = "Cancelado";
				break;
			case "AG" OR "RT":
				$dados['sol_status'] = 0;
				$dados['sol_real_por'] = 0; 
				$dados['sol_data'] = date("Y-m-d H-i-s"); 
				$resul['status'] = "Aguardando";
				break;
		}
		$whr = "sol_cod = ".$solic;
		if(!$rs_eve->Altera($dados,"tri_solic",$whr)){
			$resul['mensagem']="Status Alterado";
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
if ($acao == "consulta") {
    if(!empty($sel_empresa)){
		$sql = "SELECT * FROM tri_clientes a
					
				WHERE cod ='".$sel_empresa."'";
		}
    $rs_eve->FreeSql($sql);
    $tbl = "";
    if ($rs_eve->linhas == 0) {
        $result['st'] = 0;
        $result['sql'] = $sql;
		
    } else {
		$result['st'] = "OK";
		$rs_eve->GeraDados();
		$result['empresa'] = $rs_eve->fld("empresa");
		$result['telefone'] = $rs_eve->fld("telefone");
		$result['responsavel'] = $rs_eve->fld("responsavel");
		$result['detalhes'] = $rs_eve->fld("obs");
		$result['sql'] = $sql;
    }
    echo json_encode($result);
    exit;
}
if($acao == "ChatEnvia"){
	extract($_POST);
	$dados = array();
	$dados["chat_msg"]	= addslashes($mensagem);
	$dados["chat_de"] 	= $usu_cod;
	$dados["chat_para"] = $para;
	$dados["chat_lido"]	= 0;
	$dados["chat_hora"] = date("Y-m-d H:i:s"); 
	if (!$rs_eve->Insere($dados,"chat")) {
        $resul["status"] = "OK";
        $resul["mensagem"] = "Novo evento cadastrado!";
        $resul["sql"] = $rs_eve->sql;
    } else {
		$resul["status"] = "ERRO";
        $resul["mensagem"] = "Falha no envio";
        $resul["sql"] = $rs_eve->sql;
    }
	echo json_encode($resul);
	exit;
}
if($acao == "alterar_cli"){
	extract($_POST);
	$dados = array();
	$dados['cnpj'] 		= $cli_cnpj;
	$dados['empresa'] 	= $cli_nome;
	$dados['apelido'] 	= $cli_apelido;
	$dados['responsavel'] = $cli_resp;
	$dados['obs'] 		= $cli_obs;
	$dados['regiao'] 	= $cli_reg;
	$dados['tipo_emp'] 	= $cli_tipo;
	$dados['num_emp'] 	= $cli_func;
	$dados['email']		= $cli_mail;
	$dados['site'] 		= $cli_site;
	$dados['telefone'] 	= $cli_tel;
	$dados['tribut'] 	= $cli_tribut;
	$dados['ativo'] 	= $cli_ativo;
    $whr = "cod=".$cli_cod;
	$fn->Audit("tri_clientes", $whr, $dados, $cli_cod, $_SESSION['usu_cod']);
	
	if (!$rs_eve->Altera($dados,"tri_clientes","cod=".$cli_cod)) {
        $resul["status"] 	= "OK";
        $resul["mensagem"] 	= "Cliente Alterado!";
        $resul["sql"] 		= $rs_eve->sql;
    } else {
		$resul["status"] 	= "ERRO";
        $resul["mensagem"] 	= "Falha no envio";
        $resul["sql"] 		= $rs_eve->sql;
    }
	echo json_encode($resul);
	exit;
}
if($acao == "irrf"){
	
	$dados = array(
		"ir_cli_id" => $ir_cod,
		"ir_dataent"=> date("Y-m-d H:i:s"),
		"ir_dataalt"=> 0,
		"ir_ano" 	=> $ir_ano,
		"ir_valor" 	=> $ir_valor,
		"ir_tipo"	=> $ir_tipo,
		"ir_compl"	=> $ir_compl,
		"ir_status" => 96,
		"ir_reciboId" => 0,
		"ir_cad_user" => $_SESSION['usu_cod'],
		"ir_ult_user" => $_SESSION['usu_cod']
	);
	 if (!$rs_eve->Insere($dados,"irrf")) {
	 	$resul["status"] = "OK";
        $resul["mensagem"] = "Novo evento cadastrado!";
        $resul["sql"] = $rs_eve->sql;
    } else {
        $hist->add_hist(11);
		$resul["status"] = "ERRO";
        $resul["mensagem"] = "Falha na inclus&atilde;o";
        $resul["sql"] = $rs_eve->sql;
    }
	echo json_encode($resul);
    exit;
	
}
if($acao == "alteracao_IR"){

	$dados['ir_status'] = $solic;
	$dados['ir_ult_user'] = $_SESSION['usu_cod']; 
	$dados['ir_dataalt'] = date("Y-m-d H:i:s");
	$resul['status'] = "OK";

	
		$whr = "ir_Id = ".$codigo;
		if(!$rs_eve->Altera($dados,"irrf",$whr)){
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
if($acao == "registra_ocorrencia"){

	$dados['irh_obs'] = $irh_obs;
	$dados['irh_usu_cod'] = $_SESSION['usu_cod']; 
	$dados['irh_dataalt'] = date("Y-m-d H:i:s");
	$dados["irh_ir_id"]	= $irh_id;
		if(!$rs_eve->Insere($dados,"irrf_historico")){
			$resul['status'] = "OK";
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

if($acao == "altera_IR"){
	$rs1->Seleciona("*","irrf","ir_id=".$ir_cod);
	$rs1->GeraDados();
	$mensagem = "";
	if($ir_valor <> $rs1->fld("ir_valor")){ $mensagem.="Valor alterado de R$ ".$rs1->fld("ir_valor")." para R$".$ir_valor;}
	if($ir_compl <> $rs1->fld("ir_compl")){ $mensagem.="Complemento alterado de ".$rs1->fld("ir_compl")." para ".$ir_compl;}
	if($ir_tipo <> $rs1->fld("ir_tipo")){ $mensagem.="Tipo alterado de ".$rs1->fld("ir_tipo")." para ".$ir_tipo;}
	$whr = "ir_id = ".$ir_cod;
	$dados['ir_valor'] = $ir_valor;
	$dados['ir_compl'] = $ir_compl;
	$dados['ir_tipo'] = $ir_tipo;
	if(!$rs_eve->Altera($dados, "irrf", $whr)){
		$resul['status'] = "OK";
		$resul['mensagem']="Valor Alterado!";
		$resul['sql']=$rs_eve->sql;
		$dados2['irh_ir_id'] = $ir_cod;
		$dados2['irh_usu_cod'] = $_SESSION['usu_cod'];
		$dados2['irh_dataalt'] = date("Y-m-d H:i:s");
		$dados2['irh_obs'] = $mensagem;
		$rs1->Insere($dados2, "irrf_historico");
	}
	else{
		$resul['status']="NOK";
		$resul['mensagem']="Falha no SQL";
		$resul['sql']=$rs_eve->sql;
	}
	echo json_encode($resul);
    exit;
}

if($acao == "gerar_recibo"){
//Primeira parte: Incluir o Recibo na Tabela
	
	$dados2 = array();
	$dados2['irec_emt_por'] = $_SESSION['usu_cod'] ;
	$dados2['irec_data'] = date("Y-m-d H:i:s");
	$dados2['irec_pago'] = 0;
	$dados2['irec_ativo'] = 1;
	$rs_eve->Insere($dados2,"irpf_recibo");
	
	$rs_eve->FreeSql("SELECT irec_id FROM irpf_recibo ORDER BY irec_id DESC");
	$rs_eve->GeraDados();
	
	$whr = "ir_id IN(".$irpfs.")";
	$dados['ir_reciboId'] = $rs_eve->fld("irec_id");
	if(!$rs_eve->Altera($dados, "irrf", $whr)){
		$resul['status'] = "OK";
		$resul['mensagem']="Recibo OK!";
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

if($acao == "canc_recibo"){
//Primeira parte: Incluir o Recibo na Tabela
	$dados['irec_ativo'] = 0;
	$whr = "irec_id = ".$idrec;
		
	if(!$rs_eve->Altera($dados, "irpf_recibo", $whr)){
		$dados2['ir_reciboId'] = 0;
		$rs1->Altera($dados2, "irrf", "ir_reciboId=".$idrec);
		$resul['status'] = "OK";
		$resul['mensagem']="Recibo Cancelado!";
		$resul['sql']="SQL CANCELAMENTO-> ".$rs_eve->sql." SQL ANULAÇÃO -> ".$rs1->sql;
	}
	else{
		$resul['status']="NOK";
		$resul['mensagem']="Falha no SQL";
		$resul['sql']=$rs_eve->sql;
	}
	echo json_encode($resul);
    exit;
}

if($acao == "altera_end"){
	$dados["emp_razao"] 	= $emp_razao;
	$dados["emp_cep"] 	= $emp_cep;
	$dados["emp_logr"] 	= $emp_log;
	$dados["emp_num"] 	= $emp_num;
	$dados["emp_compl"] 	= $emp_compl;
	$dados["emp_bairro"] 	= $emp_bai;
	$dados["emp_cidade"] 	= $emp_cid;
	$dados["emp_uf"] 	= $emp_uf;
	if (!$rs_eve->Altera($dados,"empresas","emp_codigo=".$emp_codigo)) {
        $resul["status"] = "OK";
        $resul["mensagem"] = "Dados Alterados!";
        $resul["sql"] = $rs_eve->sql;
    } else {
		$resul["status"] = "ERRO";
        $resul["mensagem"] = "Falha no envio";
        $resul["sql"] = $rs_eve->sql;
    }
	echo json_encode($resul);
	exit;
}

if($acao == "altera_perfil"){

	$arr_habil = implode(";",$habil);
	//echo $arr_habil;
	$dados["dados_escol"] 	= $escol;
	$dados["dados_cep"] 	= $cep;
	$dados["dados_rua"] 	= $log;
	$dados["dados_num"] 	= $num;
	$dados["dados_compl"] 	= $compl;
	$dados["dados_bairro"] 	= $bai;
	$dados["dados_cidade"] 	= $cid;
	$dados["dados_uf"] 		= $uf;
	$dados["dados_nasc"] 	= $fn->data_usa($data);
	$dados["dados_habil"] 	= $arr_habil;
	$dados["dados_notas"] 	= $notas;
	$dados["dados_usu_email"] = $usu_email;
	// Verificar se ja existe dados para o usuario. Se não, cadastrar
	$rs_pes = new recordset();
	$sql = "SELECT dados_id FROM dados_user WHERE dados_usu_email ='".$usu_email."'";
	$rs_pes->FreeSql($sql);
	
	if($rs_pes->linhas == 0){
		if(!$rs_eve->Insere($dados,"dados_user")){
	    	$resul["status"] = "OK";
	        $resul["mensagem"] = "Dados Cadastrados!";
	        $resul["sql"] = $rs_eve->sql;
	    } else {
			$resul["status"] = "ERRO";
	        $resul["mensagem"] = "Falha no envio";
	        $resul["sql"] = $rs_eve->sql;
	    }
	}
	else{
		if(!$rs_eve->Altera($dados, "dados_user","dados_usu_email ='".$usu_email."'")){
			$resul["status"] = "OK";
	        $resul["mensagem"] = "Dados Alterados!";
	        $resul["sql"] = $rs_eve->sql;
	    } else {
			$resul["status"] = "ERRO";
	        $resul["mensagem"] = "Falha no envio";
	        $resul["sql"] = $rs_eve->sql;
	    }
	}
	echo json_encode($resul);
	exit;
}

if($acao == "Altera_Senha"){
	$rs_pes = new recordset();
	$sql = "SELECT usu_senha FROM usuarios WHERE usu_email ='".$_SESSION['usuario']."'"; 
	$rs_pes->FreeSql($sql);
	$rs_pes->GeraDados();
	if(md5($senha) == $rs_pes->fld("usu_senha")){
		$dados["usu_senha"] = md5($nsenha);
		if(!$rs_eve->Altera($dados, "usuarios","usu_email ='".$_SESSION['usuario']."'")){
			$resul["status"] = "OK";
	        $resul["mensagem"] = "Senha Alterada!";
	        $resul["sql"] = $rs_eve->sql;
	    } else {
			$resul["status"] = "ERRO";
	        $resul["mensagem"] = "Falha no envio";
	        $resul["sql"] = $rs_eve->sql;
	    }
	}
	else{
		$resul["status"] = "ERRO";
        $resul["mensagem"] = "Senha atual Incorreta!";
        $resul["sql"] = $rs_pes->sql;
	}
	echo json_encode($resul);
	exit;
}

if($acao == "pagar_recibo"){
//Primeira parte: Incluir o Recibo na Tabela
	$dados['irec_pago'] = 1;
	$dados['irec_forma'] = $fpg;
	$dados['irec_pagodata'] = date("Y-m-d H:i:s");
	$dados['irec_obs'] = $obs;
	$dados['irec_valor'] = $valor;
	$dados['irec_compl'] = $compl;
	$dados['irec_recpor'] = $_SESSION['usu_cod'];

	$whr = "irec_id = ".$idrec;
		
	if(!$rs_eve->Altera($dados, "irpf_recibo", $whr)){
		$rs2 = new recordset();
		$rs2->Seleciona("ir_Id","irrf","ir_reciboId='".$idrec."'");
		while($rs2->GeraDados()){
			$dados2 = array();
			$dados2['irh_ir_id'] = $rs2->fld("ir_Id");
			$dados2['irh_usu_cod'] = $_SESSION['usu_cod'];
			$dados2['irh_dataalt'] = date("Y-m-d H:i:s");
			$dados2['irh_obs'] = $obs." (Recibo referente à esse honorário marcado como pago no valor de R$".$valor.")";
			$rs1->Insere($dados2, "irrf_historico");
		}
		$resul['status'] = "OK";
		$resul['mensagem']="Recibo ".$idrec." marcado como PAGO!";
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

/* COMOBOX DINAMICO - Base no controle.js*/

if($acao == "combo_dep"){
	$rs_eve->Seleciona("*","usuarios","usu_dep = ".$id_dep." AND usu_ativo='1'");
	while($rs_eve->GeraDados()){
		echo "<option value='".$rs_eve->fld("usu_cod")."'>".$rs_eve->fld("usu_nome")."</option>";
	}
}

if($acao == "entra_docs"){
	$dados['doc_tipo'] 	= $doc;
	$dados['doc_ref'] 	= $ref;
	$dados['doc_cli']	= $emp;
	$dados['doc_dep']	= $dep;
	$dados['doc_resp']	= $res;
	$dados['doc_data'] 	= date("Y-m-d H:i:s");
	$dados['doc_status'] = 0;
	$dados['doc_obs']	= $obs;
	if(!$rs_eve->Insere($dados, "docs_entrada")){
		$resul['status'] = "OK";
		$resul['mensagem']="Documento dispon&iacute;vel para o departamento";
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

if ($acao == "recebe_doc") {
	$dados['doc_status'] = 99;
	$dados['doc_recpor'] = $_SESSION['usu_cod'];
	$dados["doc_datarec"] =  date("Y-m-d H:i:s");
	$resul['status'] = "OK";
	$whr = "doc_id = ".$solic;
		if(!$rs_eve->Altera($dados,"docs_entrada",$whr)){
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

if($acao == "retorno"){
	$dados['iret_ir_id'] 	= $irid;
	$dados['iret_tipo'] 	= $tipo;
	
	if($tipo == "IAP"){
		$dados['iret_valor'] 	= $valor;
		$dados['iret_cotas'] 	= $cotas;
		$dados['iret_pagto'] 	= $pagto;
		$dados['iret_datalib'] 	= date("Y-m-d");
		if(!$rs_eve->Insere($dados,"irpf_retorno")){
			$resul['status'] = "OK";
			$resul['mensagem']="Status: IAP";
			$resul['sql']=$rs_eve->sql;
			/*--|Cadastra dados para faturas DARF|--*/
			$dados2= array();
			$mes = 3;
			for($r=1;$r<=$cotas;$r++){
				$dados2['icot_ir_id'] = $irid;
				$dados2['icot_parc']  = $r;
				$dados2['icot_valor'] = $valor / $cotas;
				$ref = str_pad($mes+$r, 2 , "0",STR_PAD_LEFT)."/".date("Y"); // 04/2016
				$dados2['icot_ref']   = $ref;
				$rs1->Insere($dados2, "irpf_cotas");
			}
		}
		else{
			$resul['status']="NOK";
			$resul['mensagem']="Falha no SQL";
			$resul['sql']=$rs_eve->sql;
		}
	}

	if($tipo == "IAR"){
		$dados['iret_datalib'] 	= $fn->data_usa($dtlib);
		$dados['iret_pagto'] = $pagto;
		if(!$rs_eve->Insere($dados,"irpf_retorno")){
			$resul['status'] = "OK";
			$resul['mensagem']="Status: IAR";
			$resul['sql']=$rs_eve->sql;
		}
		else{
			$resul['status']="NOK";
			$resul['mensagem']="Falha no SQL";
			$resul['sql']=$rs_eve->sql;
		}
	}
	if($tipo == "SSI"){
		$dados['iret_datalib'] 	= date("Y-m-d");
		if(!$rs_eve->Insere($dados,"irpf_retorno")){
			$resul['status'] = "OK";
			$resul['mensagem']="Status: SSI";
			$resul['sql']=$rs_eve->sql;
		}
		else{
			$resul['status']="NOK";
			$resul['mensagem']="Falha no SQL";
			$resul['sql']=$rs_eve->sql;
		}
	}
	// Cadastro no historico do IRPF
	$dados2 = array(); // Limpando para reuso
	$dados2['irh_ir_id']	= $irid;
	$dados2['irh_usu_cod'] 	= $_SESSION['usu_cod'];
	$dados2['irh_obs'] 		= "Retorno da Receita: ".$tipo;
	$dados2['irh_dataalt'] 	= date('Y-m-d');
	$rs1->Insere($dados2, "irrf_historico");
	
	echo json_encode($resul);
	exit;
}

if ($acao == "selic") {
	$dados['isel_ref'] = $ref;
	$dados['isel_taxa'] = $taxa; 

	if(!$rs_eve->Insere($dados,"irpf_selic")){
		$resul['status'] = "OK";
		$resul['mensagem']="Nova Taxa Selic Cadastrada";
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

if ($acao == "excluir") {
	if(!$rs_eve->Exclui($tabela,"con_cod=".$codigo)){
		$resul['status'] = "OK";
		$resul['mensagem']="Dado excluido da tabela ".$tabela;
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
if ($acao == "exc_darf") {
	if(!$rs_eve->Exclui("irpf_retorno","iret_ir_id=".$codigo)){
		$rs1->Exclui("irpf_cotas","icot_ir_id=".$codigo);
		$resul['status'] = "OK";
		$resul['mensagem']="Dado excluido da tabela IRPF_RETORNO";
		$resul['sql']=$rs_eve->sql;
		$dados2 = array(); // Limpando para reuso
		$dados2['irh_ir_id']	= $codigo;
		$dados2['irh_usu_cod'] 	= $_SESSION['usu_cod'];
		$dados2['irh_obs'] 		= "Exclusão do Calculo DARF";
		$dados2['irh_dataalt'] 	= date('Y-m-d');
		$rs1->Insere($dados2, "irrf_historico");
	}
	else{
		$resul['status']="NOK";
		$resul['mensagem']="Falha no SQL";
		$resul['sql']=$rs_eve->sql;
	}
	echo json_encode($resul);
    exit;
}
if($acao == "exc_selic"){
	if(!$rs_eve->Exclui("irpf_selic","isel_id=".$selid)){
		$resul['status'] = "OK";
		$resul['mensagem']="Dado excluido da tabela IRPFSELIC";
		$resul['sql']=$rs_eve->sql;
	}
	exit;
}

if($acao == "evento"){
	$dados["eve_desc"]	= $desc;
	$dados["eve_cor"]	= $cor;
	$dados["eve_tema"]	= $tema;
	$dados["eve_dep"]	= "[".$_SESSION['usu_cod']."]";
	$rs_eve->Insere($dados, "Eventos");
	exit;
}

if($acao == "calendario"){
	
	$meses = array("Jan"=>1,"Feb"=>2,"Mar"=>3,"Apr"=>4,"May"=>5,"Jun"=>6, "Jul"=>7,"Aug"=>8, "Sep"=>9, "Oct"=>10, "Nov"=>11,"Dec"=>12);
	$dat_ = explode(" ",$dt);
	$dte = $dat_[3]."-".$meses[$dat_[1]]."-".$dat_[2];
	$us="";
	if(!empty($users)){
		foreach($users as $user){
			$us.= "[".$user."]";
		}
	}else{
		$us = "[".$_SESSION['usu_cod']."]";
	}
	
	$dados["cal_id"]		= $nc;
	$dados["cal_eveid"]		= $evento;
	$dados["cal_eveusu"]	= ($vpt == 1? "[9999]" : $us);
	$dados['cal_dataini']	= $dte;
	$dados['cal_datafim']	= $dte;
	$dados["cal_url"]		= "vis_evecal.php?calid=".$nc;
	$dados["cal_criado"]	= $_SESSION['usu_cod'];

	if(!$rs_eve->Insere($dados,"calendario")){
		$resul['mensagem'] = $fn->data_br($dte);
	}
	else{$resul["mensagem"] = "ERRO";}
	echo json_encode($resul);	
	exit;
}
if($acao == "alt_calendario"){
	$us="";
	if(!empty($eveusu)){
		foreach($eveusu as $user){
			$us.= "[".$user."]";
		}
	}else{
		$us = "[".$_SESSION['usu_cod']."]";
	}
	$dados['cal_dataini']	= $fn->data_usa($dataini);
	$dados['cal_datafim']	= $fn->data_usa($datafim);
	$dados['cal_horaini']	= $horaini;
	$dados['cal_horafim']	= $horafim;
	$dados["cal_eveusu"]	= $us;
	$dados['cal_obs']		= addslashes($obs);
	$whr = "cal_id = ".$calid;
	if(!$rs_eve->Altera($dados, "calendario", $whr)){
		$resul['status']	= "OK";
		$resul['mensagem']	= "Evento alterado com sucesso!";
		$resul['link']		= "calendar.php";
	}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs->sql;
	}
	echo json_encode($resul);
    exit;
}

if($acao == "novo_chamado"){
	$cod = $rs_eve->autocod("cham_id","chamados");
	$dados['cham_id']		= $cod;
	$dados['cham_dept']		= $cham_dept;
	$dados['cham_task']		= $cham_task;
	$dados['cham_solic']	= ($cham_cola == 0 ? $_SESSION['usu_cod'] : $cham_cola);
	$dados['cham_abert']	= date("Y-m-d H:i:s");
	
	if(!$rs_eve->Insere($dados, "chamados")){
		// INSERINDO OBSERVAÇÂO
		$rs2 = new recordset();
		$dados2 = array();
		$dados2['chobs_chamid'] = $cod;
		$dados2['chobs_obs'] 	= addslashes($cham_obs);
		$dados2['chobs_user']	= $_SESSION['usu_cod'];
		$dados2['chobs_horario']= date("Y-m-d H:i:s");
		if(!$rs2->Insere($dados2,"cham_obs")){
			$resul['status']	= "OK";
			$resul['mensagem']	= "Chamado cadastrado com sucesso!";
		}
	}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs->sql;
	}
	echo json_encode($resul);
    exit;
}

if($acao == "salva_chamado"){
	$dados['cham_percent']	= $cham_percent;
	$dados['cham_status']	= 91 ;
	$dados['cham_tratfim']	= date("Y-m-d H:i:s") ;
	
	$whr = "cham_id = ".$cham_id;
	
	if(!$rs_eve->Altera($dados, "chamados",$whr)){
		$resul['status']	= "OK";
		$resul['mensagem']	= "Chamado salvo!";
		$resul['sql']		= $rs_eve->sql;
		// INSERINDO OBSERVAÇÂO
		if(!empty($cham_obs)){
			$rs2 = new recordset();
			$dados2 = array();
			$dados2['chobs_chamid'] = $cham_id;
			$dados2['chobs_obs'] 	= addslashes($cham_obs);
			$dados2['chobs_user']	= $_SESSION['usu_cod'];
			$dados2['chobs_horario']= date("Y-m-d H:i:s");
			$rs2->Insere($dados2,"cham_obs");
			// PREPARA MENSAGEM VIA CHAT
			$dados2 = array();
			
			$user1 = $rs2->pegar("cham_trat","chamados",$whr);
			$user2 = $rs2->pegar("cham_solic","chamados",$whr);
			$dados2["chat_msg"]	= "O seu chamado (#".$cham_id.") foi alterado. Msg: ".addslashes($cham_obs);
			$dados2["chat_de"] 	= ($_SESSION['usu_cod']==$user1 ? $user1 : $user2);
			$dados2["chat_para"] = ($_SESSION['usu_cod']<>$user2 ? $user2 : $user1);
			$dados2["chat_lido"] = 0;
			$dados2["chat_hora"] = date("Y-m-d H:i:s"); 
			$rs2->Insere($dados2,"chat");
		}

	}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs_eve->sql;
	}
	echo json_encode($resul);
    exit;
}

if($acao == "encerra_chamado"){
	//$dados['cham_sla']		= $cham_sla;
	$dados['cham_percent']	= 100 ;
	$dados['cham_status']	= 99 ;
	$dados['cham_aval']		= $cham_aval ;
	
	$whr = "cham_id = ".$cham_id;
	
	if(!$rs_eve->Altera($dados, "chamados",$whr)){
		$resul['status']	= "OK";
		$resul['mensagem']	= "Chamado salvo!";
		$resul['sql']		= $rs_eve->sql;
	}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs_eve->sql;
	}
	echo json_encode($resul);
    exit;
}

if($acao == "controle_horas"){
	// Consulta para ver se não há colaborador na data digitada
	$sql = "SELECT * FROM controle_horas WHERE ch_data='".$fn->data_usa($ch_data)."' AND ch_colab=".$ch_colab." AND ch_status IN(100,101)";
	$rs2 = new recordset();
	$rs2->FreeSql($sql);
	if($rs2->linhas >0){
		$resul['mensagem']	= "Já existe um dado de hor&aacuterio para o colaborador no dia digitado";
		$resul['sql']		= $rs2->sql;	
	}
	else{
	// Se não houver -->
		$cod = $rs_eve->autocod("ch_id","controle_horas");
		$dados['ch_id'] 			= $cod;
		$dados['ch_data'] 			= $fn->data_usa($ch_data);
		$dados['ch_colab'] 			= $ch_colab;
		$dados['ch_hora_saida'] 	= $ch_hora_saida;
		$dados['ch_usucad'] 		= $_SESSION['usu_cod'];
		$dados['ch_horacad'] 		= date("Y-m-d H:i:s");
		$dados['ch_status']			= ( ( $_SESSION['usu_cod'] == $ch_colab AND ( $_SESSION['lider']=='Y' OR $_SESSION['classe']<>1)) ? 100 : 101);
		

		if(!$rs2->Insere($dados,"controle_horas")){
				$resul['status']	= "OK";
				$resul['mensagem']	= "Dados inseridos controle de horas!";
			}
		else{
			$resul['mensagem']	= "Ocorreu um erro...";
			$resul['sql']		= $rs->sql;
		}	
	}
	
	echo json_encode($resul);
    exit;
}
if($acao == "exclui_horas"){
	$dados['ch_status'] = 90;
	if(!$rs_eve->Altera($dados, "controle_horas","ch_id=".$ch_id)){
		$resul['status']	= "OK";
		$resul['mensagem']	= "Dados excluídos do controle de horas!";
		}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs->sql;
	}	
	echo json_encode($resul);
    exit;
}

if($acao == "valida_horas"){
	$dados['ch_status'] = 101;
	$dados['ch_aprovadopor'] = $_SESSION['usu_cod'];
	if(!$rs_eve->Altera($dados, "controle_horas","ch_id=".$ch_id)){
		$resul['status']	= "OK";
		$resul['mensagem']	= "Dados validados no controle de horas!";
		}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs->sql;
	}	
	echo json_encode($resul);
    exit;
}

if($acao == "incluir_cli"){
	$dados['cod'] 			= $cli_cod;
	$dados['cnpj'] 			= $cli_cnpj;
	$dados['empresa'] 		= addslashes($cli_nome);
	$dados['apelido'] 		= addslashes($cli_apelido);
	$dados['regiao'] 		= $cli_reg;
	$dados['responsavel']	= $cli_resp;
	$dados['tipo_emp']		= $cli_tipo;
	$dados['num_emp']		= $cli_func;
	$dados['email'] 		= $cli_mail;
	$dados['site'] 			= $cli_site;
	$dados['telefone'] 		= $cli_tel;
	$dados['obs'] 			= $cli_obs;
	if(!$rs_eve->Insere($dados,"tri_clientes")){
				$resul['status']	= "OK";
				$resul['mensagem']	= "Cliente Ok!";
	}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs->sql;
	}	

	
	echo json_encode($resul);
    exit;
	
}

if($acao == "inclui_usuario"){
	$dados['usu_nome'] 		= $usu_nome;
	$dados['usu_senha']		= (md5($usu_senha));
	$dados['usu_emp_cnpj']	= ($_SESSION['usu_empresa']);	
	$dados['usu_classe']	= $sel_class;
	$dados['usu_email'] 	= $usu_email;
	$dados['usu_ativo'] 	= '1';
	$dados['usu_dep']	    = $sel_depto;
	$dados['usu_lider']	    = $sel_lider;
	$dados['usu_ramal']		= $usu_ramal;
	$dados['usu_pausa']		= $usu_pausa;
	$dados['usu_online']	= '0'; 
	
	
	if(!$rs_eve->Insere($dados,"usuarios")){
				$resul['status']	= "OK";
				$resul['mensagem']	= "Usuario ok!";
	}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs->sql;
	}	

	
	echo json_encode($resul);
    exit;
	
}


if($acao == "exclui_empresa"){
	$dados['ativo'] = 0;
	if(!$rs_eve->Altera($dados, "tri_clientes","cod=".$emp_cod)){
		$resul['status']	= "OK";
		$resul['mensagem']	= "Empresa marcada como inativa!";
		}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs->sql;
	}	
	echo json_encode($resul);
    exit;
}

if($acao == "inclui_servico"){
	
	$cod = $rs_eve->autocod("ser_id","servicos");
	$dados['ser_id']		= $cod;
	$dados['ser_data'] 		= date("Y-m-d H:i:s");
	$dados['ser_usuario'] 	= $_SESSION['usu_cod'];
	$dados['ser_cliente'] 	= addslashes($serv_cli);
	$dados['ser_obs']		= $serv_obs;
	
	if(!$rs_eve->Insere($dados,"servicos")){
				$resul['status']	= "OK";
				$resul['mensagem']	= "Servi&ccedil;o cadastrado!";
		}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs->sql;
	}
	
	echo json_encode($resul);
    exit;
	
}

if($acao == "gerar_saida"){
//Primeira parte: Incluir o Recibo na Tabela
	
	$dados2 = array();
	$cod = $rs_eve->autocod("said_id","serv_saidas");
	$dados2['said_id']	= $cod;
	$dados2['said_usuario'] = $_SESSION['usu_cod'] ;
	$dados2['said_data'] = date("Y-m-d H:i:s");
	$dados2['said_venc'] = $fn->data_usa($servn);
	$dados2['said_status'] = 0;
	$dados2['said_ativo'] = 1;
	//$dados2['serv_venc'] = 1;
	$rs_eve->Insere($dados2,"serv_saidas");
	
		
	$whr = "ser_id IN(".$servs.")";
	$dados['ser_lista'] = $cod;
	if(!$rs_eve->Altera($dados, "servicos", $whr)){
		$resul['status'] = "OK";
		$resul['mensagem']="Servi&ccedil;os OK!";
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

if($acao == "exclui_saidas"){
	$dados['said_status'] = 90;
	$dados['said_useralt'] = $_SESSION['usu_cod'];
	$dados['said_dataalt'] = date("Y-m-d H:i:s");
	if(!$rs_eve->Altera($dados, "serv_saidas","said_id=".$said_id)){
		
		// retirar os itens da lista cancelada
		$dados2 = array();
		$dados2['ser_lista'] = 0;
		$rs2 = new recordset();
		$rs2->Altera($dados2, "servicos", "ser_lista=".$said_id);
		$resul['status'] = "OK";
		$resul['mensagem']="Dados Cancelados!";
		$resul['sql']="SQL CANCELAMENTO-> ".$rs_eve->sql." SQL ANULAÇÃO -> ".$rs2->sql;
	}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs->sql;
	}	
	echo json_encode($resul);
    exit;
}

if($acao == "real_saidas"){
	$dados['said_status'] = 91;
	$dados['said_useralt'] = $_SESSION['usu_cod'];
	$dados['said_dataalt'] = date("Y-m-d H:i:s");
	if(!$rs_eve->Altera($dados, "serv_saidas","said_id=".$said_id)){
		$resul['status'] = "OK";
		$resul['mensagem']="Marcado como Em atendimento!";
		$resul['sql']=$rs_eve->sql;
	}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs->sql;
	}	
	echo json_encode($resul);
    exit;
}

if($acao == "comp_saida"){
	$dados['said_status'] = 99;
	$dados['said_useralt'] = $_SESSION['usu_cod'];
	$dados['said_dataalt'] = date("Y-m-d H:i:s");
	if(!$rs_eve->Altera($dados, "serv_saidas","said_id=".$said_id)){
		$resul['status'] = "OK";
		$resul['mensagem']="Marcado completo!";
		$resul['sql']=$rs_eve->sql;
	}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs->sql;
	}	
	echo json_encode($resul);
    exit;
}

if($acao == "exclui_item"){
	
	if(!$rs_eve->Exclui("servicos","ser_id=".$ser_id)){
		
		$resul['status'] = "OK";
		$resul['mensagem']="Dados Excluídos!";
		
	}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs->sql;
	}	
	echo json_encode($resul);
    exit;
}

if($acao == "save_item"){
	
	$dados['ser_status']= 99;
	
	if(!$rs_eve->Altera($dados,"servicos","ser_id=".$ser_id)){
		$dados2= array();
		$rs2 = new recordset();
		$dados2['shist_id'] = $rs2->autocod("shist_id", "serv_hist");
		$dados2['shist_serid'] = $ser_id;
		$dados2['shist_data'] = date("Y-m-d H:i:s");
		$dados2['shist_user'] = $_SESSION['usu_cod'];
		$dados2['shist_obs'] = $ser_obs;
		$rs2->Insere($dados2,"serv_hist");

		$resul['status']	= "OK";
		$resul['mensagem']	= "Servi&ccedil;o cadastrado!";
	}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs_eve->sql;
	}
	
	echo json_encode($resul);
    exit;
	
}

if($acao == "relist_item"){
	
	$dados['ser_status']= 0;
	$dados['ser_lista']= 0;
	
	if(!$rs_eve->Altera($dados,"servicos","ser_id=".$ser_id)){
		$dados2= array();
		$rs2 = new recordset();
		$dados2['shist_id'] = $rs2->autocod("shist_id", "serv_hist");
		$dados2['shist_serid'] = $ser_id;
		$dados2['shist_data'] = date("Y-m-d H:i:s");
		$dados2['shist_user'] = $_SESSION['usu_cod'];
		$dados2['shist_obs'] = $ser_obs;
		$rs2->Insere($dados2,"serv_hist");

		$resul['status']	= "OK";
		$resul['mensagem']	= "Servi&ccedil;o cadastrado!";
	}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs_eve->sql;
	}
	
	echo json_encode($resul);
    exit;
	
}

if($acao == "cancel_item"){
	
	$dados['ser_status']= 91;
	
	if(!$rs_eve->Altera($dados,"servicos","ser_id=".$ser_id)){
		$dados2= array();
		$rs2 = new recordset();
		$dados2['shist_id'] = $rs2->autocod("shist_id", "serv_hist");
		$dados2['shist_serid'] = $ser_id;
		$dados2['shist_data'] = date("Y-m-d H:i:s");
		$dados2['shist_user'] = $_SESSION['usu_cod'];
		$dados2['shist_obs'] = $ser_obs;
		$rs2->Insere($dados2,"serv_hist");

		$resul['status']	= "OK";
		$resul['mensagem']	= "Servi&ccedil;o cadastrado!";
	}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs_eve->sql;
	}
	
	echo json_encode($resul);
    exit;
	
}

if($acao == "consulta_emp"){
	$rs_eve->Seleciona("*","tri_clientes","cod=".$emp_cod);
	if($rs_eve->linhas >0){
		$rs_eve->GeraDados();
		$resul['status'] 		= "OK";
		$resul['cnpj']			= $rs_eve->fld("cnpj");
		$resul['apelido']		= $rs_eve->fld("apelido");
		$resul['empresa']		= $rs_eve->fld("empresa");
		$resul['reg']		= $rs_eve->fld("regiao");
		$resul['resp']	= $rs_eve->fld("responsavel");
		$resul['email']			= $rs_eve->fld("email");
		$resul['site']			= $rs_eve->fld("site");
		$resul['tel']		= $rs_eve->fld("telefone");	
		$resul['obs']			= $rs_eve->fld("obs");
	}
	else{
		$resul['mensagem']	= "Código disponível para uso!";
		$resul['sql']		= $rs_eve->sql;
	}
	
	echo json_encode($resul);
    exit;
}

if($acao == "cli_cadSenha"){
	$cod = $rs_eve->autocod("sen_id","senhas");
	$dados['sen_id']			= $cod;
	$dados['sen_cod'] 			= $sen_clicod;
	$dados['sen_desc'] 			= addslashes($sen_desc);
	$dados['sen_acesso'] 		= addslashes($sen_acesso);
	$dados['sen_user']			= addslashes($sen_user);
	$dados['sen_senha'] 		= addslashes($sen_senha);
	$dados['sen_obs']			= addslashes($sen_obs);
	$dados['sen_usercad'] 		= $_SESSION['usu_cod'];
	$dados['sen_dtcad']			= date('Y-m-d H:i:s');
	
	if(!$rs_eve->Insere($dados,"senhas")){
		$resul['status']	= "OK";
		$resul['mensagem']	= "Senha cadastrada!";
		$resul['sql']		= $rs_eve->sql;
	}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs_eve->sql;
	}
	echo json_encode($resul);
    exit;
}


if($acao == "cli_altSenha"){
	$dados['sen_cod'] 			= $sen_clicod;
	$dados['sen_desc'] 			= addslashes($sen_desc);
	$dados['sen_acesso'] 		= addslashes($sen_acesso);
	$dados['sen_user']			= addslashes($sen_user);
	$dados['sen_senha'] 		= addslashes($sen_senha);
	$dados['sen_obs']			= addslashes($sen_obs);
	$whr = "sen_id=".$sen_id;
	$fn->Audit("senhas", $whr, $dados, $sen_clicod, $_SESSION['usu_cod']);
	if(!$rs_eve->ALtera($dados,"senhas",$whr)){
		$resul['status']	= "OK";
		$resul['mensagem']	= "Senha cadastrada!";
		$resul['sql']		= $rs_eve->sql;
	}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs_eve->sql;
	}
	echo json_encode($resul);
    exit;
}
if($acao == "cli_cadPartic"){
	$cod = $rs_eve->autocod("part_id","particularidades");
	$dados['part_id']			= $cod;
	$dados['part_cod'] 			= $part_clicod;
	$dados['part_titulo'] 		= addslashes($part_titulo);
	$dados['part_usu'] 			= $_SESSION['usu_cod'];
	$dados['part_depto'] 		= $part_depto;
	$dados['part_data']			= date('Y-m-d H:i:s');
	$dados['part_obs']			= addslashes($part_obs);
	$dados['part_tipo']			= $part_tipo;
	$dados['part_ativo']		= $part_ativo;
	
	if(!$rs_eve->Insere($dados,"particularidades")){
		$resul['status']	= "OK";
		$resul['mensagem']	= "Particularidade cadastrada!";
		$resul['sql']		= $rs_eve->sql;
	}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs_eve->sql;
	}
	echo json_encode($resul);
    exit;
}

if($acao == "cli_altPartic"){
	$dados['part_cod'] 			= $part_clicod;
	$dados['part_titulo'] 		= addslashes($part_titulo);
	$dados['part_data']			= date('Y-m-d H:i:s');
	$dados['part_tipo']			= $part_tipo;
	$dados['part_obs']			= addslashes($part_obs);
	$dados['part_ativo']		= $part_ativo;
	$whr = "part_id=".$part_id;
	$fn->Audit("particularidades", $whr, $dados, $part_clicod, $_SESSION['usu_cod']);
	if(!$rs_eve->Altera($dados,"particularidades",$whr)){
		$resul['status']	= "OK";
		$resul['mensagem']	= "Particularidade alterada!";
		$resul['sql']		= $rs_eve->sql;
	}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs_eve->sql;
	}
	echo json_encode($resul);
    exit;
}

if($acao == "cli_Cadcom"){
	$cod = $rs_eve->autocod("com_id","comunicacao");
	$dados['com_id']			= $cod;
	$dados['com_cod'] 			= $com_clicod;
	$dados['com_canal'] 		= addslashes($com_canal);
	$dados['com_usu'] 			= $_SESSION['usu_cod'];
	$dados['com_depto'] 		= $com_depto;
	$dados['com_data']			= date('Y-m-d H:i:s');
	$dados['com_obs']			= addslashes($com_obs);
	$dados['com_ativo']		    = $com_ativo;
	
	if(!$rs_eve->Insere($dados,"comunicacao")){
		$resul['status']	= "OK";
		$resul['mensagem']	= "Comunica&ccedil;&atilde;o cadastrada";
		$resul['sql']		= $rs_eve->sql;
	}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs_eve->sql;
	}
	echo json_encode($resul);
    exit;
}

if($acao == "cli_Altcom"){
	$dados['com_cod'] 			= $com_clicod;
	$dados['com_canal'] 		= addslashes($com_canal);
	$dados['com_usu'] 			= $_SESSION['usu_cod'];
	$dados['com_depto'] 		= $com_depto;
	$dados['com_data']			= date('Y-m-d H:i:s');
	$dados['com_obs']			= addslashes($com_obs);
	$dados['com_ativo']		    = $com_ativo;
	$whr = "com_id =".$com_id;
	$fn->Audit("comunicacao", $whr, $dados, $com_clicod, $_SESSION['usu_cod']);
	if(!$rs_eve->Altera($dados,"comunicacao",$whr)){
		$resul['status']	= "OK";
		$resul['mensagem']	= "Comunica&ccedil;&atilde;o cadastrada";
		$resul['sql']		= $rs_eve->sql;
	}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs_eve->sql;
	}
	echo json_encode($resul);
    exit;
}

if($acao == "cli_Cadobr"){
	$cod = $rs_eve->autocod("ob_id","obrigacoes");
	$dados['ob_id']			= $cod;
	$dados['ob_cod'] 			= $ob_clicod;
	$dados['ob_titulo'] 		= addslashes($ob_titulo);
	$dados['ob_depto'] 			= $ob_depto;
	$dados['ob_ativo']		    = $ob_ativo;
	
	if(!$rs_eve->Insere($dados,"obrigacoes")){
		$resul['status']	= "OK";
		$resul['mensagem']	= "Obriga&ccedil;&atilde;o cadastrada";
		$resul['sql']		= $rs_eve->sql;
	}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs_eve->sql;
	}
	echo json_encode($resul);
    exit;
}

if($acao == "cli_Altobr"){
	$dados['ob_cod'] 			= $ob_clicod;
	$dados['ob_titulo'] 		= addslashes($ob_titulo);
	$dados['ob_depto'] 			= $ob_depto;
	$dados['ob_ativo']		    = $ob_ativo;
	$whr = "ob_id =".$ob_id;
	$fn->Audit("obrigacoes", $whr, $dados, $ob_clicod, $_SESSION['usu_cod']);
	if(!$rs_eve->Altera($dados,"obrigacoes",$whr)){
		$resul['status']	= "OK";
		$resul['mensagem']	= "Obriga&ccedil;&atilde;o cadastrada";
		$resul['sql']		= $rs_eve->sql;
	}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs_eve->sql;
	}
	echo json_encode($resul);
    exit;
}

if($acao == "cli_Cadtrib"){
	$cod = $rs_eve->autocod("tr_id","tributos");
	$dados['tr_id']			= $cod;
	$dados['tr_cod'] 			= $tr_clicod;
	$dados['tr_titulo'] 		= addslashes($tr_titulo);
	$dados['tr_depto'] 			= $tr_depto;
	$dados['tr_ativo']		    = $tr_ativo;
	
	if(!$rs_eve->Insere($dados,"tributos")){
		$resul['status']	= "OK";
		$resul['mensagem']	= "Tributa&ccedil;&atilde;o cadastrada";
		$resul['sql']		= $rs_eve->sql;
	}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs_eve->sql;
	}
	echo json_encode($resul);
    exit;
}

if($acao == "cli_Alttrib"){
	$dados['tr_cod'] 			= $tr_clicod;
	$dados['tr_titulo'] 		= addslashes($tr_titulo);
	$dados['tr_depto'] 			= $tr_depto;
	$dados['tr_ativo']		    = $tr_ativo;
	$whr = "tr_id =".$tr_id;
	$fn->Audit("tributos", $whr, $dados, $tr_clicod, $_SESSION['usu_cod']);
	if(!$rs_eve->Altera($dados,"tributos",$whr)){
		$resul['status']	= "OK";
		$resul['mensagem']	= "Tributa&ccedil;&atilde;o cadastrada";
		$resul['sql']		= $rs_eve->sql;
	}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs_eve->sql;
	}
	echo json_encode($resul);
    exit;
}

if($acao == "gerar_carteira"){
	$rs2 = new recordset();
	$dados2 = array();
	$dados2[$dep]["user"] = $user;
	$dados2[$dep]["data"] = date("d/m/Y");

	$cod = explode(",",$empresas);

	foreach($cod as $cods){
		$rsalt = new recordset();
		$cart 	= json_decode($rs2->pegar("carteira","tri_clientes","cod=".$cods),true);
		$ncart 	= $dados2 + $cart;
		$json 	= json_encode($ncart);
		$dados['carteira'] = addslashes($json);
		
		$whr = "cod =".$cods;
		$rsalt->Altera($dados, "tri_clientes", $whr);
		$fn->Audit("tri_clientes", $whr, $dados, $cods, $_SESSION['usu_cod']);
		/*	
			$resul['status'] = "OK";
			$resul['mensagem']="Servi&ccedil;os OK!";
			$resul['sql']=$rs_eve->sql;
		}
		else{
			$resul['status']="NOK";
			$resul['mensagem']="Falha no SQL";
			$resul['sql']=$rs_eve->sql;
		}*/
	} 
	$resul['status'] = "OK";
	echo json_encode($resul);
	//echo json_encode($dados2);
    exit;
}

if($acao == "cli_cadImposto"){
	$cod = $rs_eve->autocod("imp_id","tipos_impostos");
	$dados['imp_id']			= $cod;
	$dados['imp_nome'] 			= addslashes($imp_nome);
	$dados['imp_cadpor'] 		= $_SESSION['usu_cod'];
	$dados['imp_depto'] 		= $imp_depto;
	$dados['imp_dtcad']			= date('Y-m-d H:i:s');
	$dados['imp_desc']			= addslashes($imp_desc);
	$dados['imp_regra']			= $imp_regra;
	$dados['imp_venc']			= $imp_venc;
	$dados['imp_pasta']			= $imp_pasta;
	$dados['imp_arquivo']		= $imp_arquivo;
	$dados['imp_tipo']			= $imp_tipo;
	$dados['imp_ativo']			= 1;
	
	if(!$rs_eve->Insere($dados,"tipos_impostos")){
		$resul['status']	= "OK";
		$resul['mensagem']	= "Imposto cadastrada!";
		$resul['sql']		= $rs_eve->sql;
	}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs_eve->sql;
	}
	echo json_encode($resul);
    exit;
}

if($acao == "cli_altImposto"){
	$dados['imp_nome'] 			= addslashes($imp_nome);
	$dados['imp_desc']			= addslashes($imp_desc);
	$dados['imp_regra']			= $imp_regra;
	$dados['imp_pasta']			= $imp_pasta;
	$dados['imp_arquivo']		= $imp_arquivo;
	$dados['imp_venc']			= $imp_venc;
	$dados['imp_tipo']			= $imp_tipo;
	$whr = "imp_id=".$imp_id;
	$fn->Audit("tipos_impostos", $whr, $dados, $imp_id, $_SESSION['usu_cod']);
	if(!$rs_eve->Altera($dados,"tipos_impostos",$whr)){
		$resul['status']	= "OK";
		$resul['mensagem']	= "Imposto alterada!";
		$resul['sql']		= $rs_eve->sql;
	}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs_eve->sql;
	}
	echo json_encode($resul);
    exit;
}

if($acao == "combo_func"){
	$rs_eve->Seleciona("*", "porte_empresa","port_tipo=".$emp_tipo);
	echo "<option>Selecione...</option>";
	while($rs_eve->GeraDados()){
		echo "<option value='".$rs_eve->fld("port_id")."'>".$rs_eve->fld("port_tam")." - ".$rs_eve->fld("port_func")."</option>";
	}
	exit;
}

if($acao == "cons_horas"){
	/*|INÍCIO: PESQUISAR PELAS HORAS APONTADAS NO CONTROLE DE HORAS|*/
	$sql = "SELECT * FROM controle_horas WHERE ch_colab={$usu_cod} AND ch_status=101";
	$rs_eve->FreeSql($sql);
	$horas = 0;
	if($rs_eve->linhas >0){
		while($rs_eve->GeraDados()){
			$dia = $fn->DiaDaSemana($rs_eve->fld("ch_data"));
			$num = ($fn->hora_decimal($rs_eve->fld("ch_hora_saida"))-($dia==6 ? 540 : 1020))/60;
			$horas += $num;
		}
		/*|APÓS, CONSULTA MESMO COLABORADOR AFIM DE VERIFICAR AS HORAS DESCONTADAS|*/
		$sql = "SELECT * FROM desconto_horas WHERE desc_colab={$usu_cod}";
		$rs_eve->FreeSql($sql);
		if($rs_eve->linhas >0){
			while($rs_eve->GeraDados()){
				$horas -= $rs_eve->fld("desc_horas");
			}
		}
		$resul["status"] = "OK";
		$resul["disp"] = number_format($horas,2,",",".");
		$resul["sql"] = $rs_eve->sql;
		$resul["mensagem"] = "Horas disponíveis para desconto: ".number_format($horas,2,",",".");

	}
	else{
		$resul["status"] = "NOK";
		$resul["disp"] = number_format($horas,2,",",".");
		$resul["mensagem"] = "Nenhum apontamento encontrado!";
	}
	echo json_encode($resul);
	exit;	
}

if($acao == "desc_horas"){
	$dados["desc_colab"] 	= $dhor_colab;
	$dados["desc_horas"] 	= $dhor_desc;
	$dados["desc_data"]		= date("Y-m-d H:i:s");
	$dados["desc_usucad"]	= $_SESSION["usu_cod"];
	$dados["desc_obs"]		= addslashes($dhor_obs);
	if(!$rs_eve->Insere($dados,"desconto_horas")){
		$result["status"] 	= "OK";
		$result["mensagem"] = "Descontadas ".$dhor_desc."!";
		$result["sql"] 		= $rs_eve->sql;
	}
	else{
		$result["status"] 	= "NOK";
		$result["mensagem"] = "Erro ao descontar as horas:".$dhor_desc;
		$result["sql"] 		= $rs_eve->sql;
	}
echo json_encode($result);
exit;
}