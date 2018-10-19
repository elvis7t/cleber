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

if($acao == "inclusao"){
	
	$dados = array();
	$dados["sol_emp"] 		= $emp_nome;
	$dados["sol_data"] 		= date("Y-m-d H:i:s");
	$dados["sol_datareal"] 	= 0;
	$dados["sol_tel"] 		= $emp_tel;
	$dados["sol_cont"] 		= $emp_res;
	$dados["sol_fcom"] 		= $emp_fcom;
	$dados["sol_obs"] 		= $emp_obs;
	$dados["sol_por"] 		= $_SESSION['usu_cod'];
	$dados["sol_empcod"] 	= $_SESSION['usu_empcod'];

	 if (!$rs_eve->Insere($dados,"tri_solic")) {
        $resul["status"] = "OK";
        $resul["mensagem"] = "Novo evento cadastrado!";
        $resul["sql"] = $rs_eve->sql;
        //$hist->add_hist(11);
    } else {
		$resul["status"] = "ERRO";
        $resul["mensagem"] = "Falha na inclus&atilde;o";
        $resul["sql"] = $rs_eve->sql;
    }
	echo json_encode($resul);
    exit;
	
}

if($acao == "ligacao"){
	
	$dados = array();
	$dados["sol_emp"] = $emp_nome;
	$dados["sol_data"] = date("Y-m-d H:i:s");
	$dados["sol_datareal"] = date("Y-m-d H:i:s");
	$dados["sol_tel"] = $emp_tel;
	$dados["sol_cont"] = $emp_res;
	$dados["sol_fcom"] = $emp_fcom;
	$dados["sol_obs"] = $emp_obs;
	$dados["sol_real_por"] = $_SESSION['usu_cod'];
	$dados["sol_pres"] = $emp_pres;
	$dados["sol_status"] = 99;
	$dados["sol_empcod"] = $_SESSION['usu_empcod'];

	 if (!$rs_eve->Insere($dados,"tri_ligac")) {
        $resul["status"] = "OK";
        $resul["mensagem"] = "Novo contato cadastrado!";
        $resul["sql"] = $rs_eve->sql;
        $hist->add_hist(11);
    } else {
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
		$sql = "INSERT INTO tri_solic (sol_data, sol_por, sol_emp, sol_empcod, sol_tel, sol_cont, sol_fcom, sol_obs)
				SELECT now(), sol_por, sol_emp, sol_empcod, sol_tel, sol_cont, sol_fcom, sol_obs FROM tri_solic WHERE sol_cod = ".$solic;
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
			$hist->add_hist(12); // Realizou solicitação
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
	
	$dados['cnpj'] 				= $cli_cnpj;
	$dados['empresa'] 			= $cli_nome;
	$dados['apelido'] 			= $cli_apelido;
	$dados['cpr'] 				= $cli_cpr;
	$dados['cnae'] 				= $cli_cnae;
	$dados['emp_nire'] 			= $cli_nire;
	$dados['inscr'] 			= $cli_iest;
	$dados['emp_inscmun'] 		= $cli_imun;
	$dados['emp_datajucesp'] 	= $fn->data_usa($cli_juce);
	$dados['emp_inicio']		= $fn->data_usa($cli_inicio);
	$dados['emp_dataie']		= $fn->data_usa($cli_dataie);
	$dados['emp_dataim']		= $fn->data_usa($cli_dataim);
	$dados['emp_datatrib']		= $fn->data_usa($cli_datatrib);
	$dados['emp_datacnpj']		= $fn->data_usa($cli_datacnpj);
	$dados['emp_cep']			= $fn->sanitize($cli_cep);
	$dados['emp_logradouro']	= addslashes($cli_log);
	$dados['emp_numero']		= $cli_num;
	$dados['emp_complemento']	= $cli_compl;
	$dados['emp_bairro']		= $cli_bai;
	$dados['emp_cidade']		= $cli_cid;
	$dados['emp_uf']			= $cli_uf;
	$va_cap = str_replace(".", "", $cli_capital);
	$dados['emp_capital']		= str_replace(",", ".", $va_cap);
	$dados['emp_integraliza']	= $cli_integra;
	$dados['emp_atividades']	= $cli_atividade;
	$dados['responsavel'] 		= $cli_resp;
	$dados['regiao'] 			= $cli_reg;
	$dados['tipo_emp'] 			= $cli_tipo;
	$dados['num_emp'] 			= $cli_func;
	$dados['telefone'] 			= $cli_tel;
	$dados['email']				= $cli_email;
	$dados['site'] 				= $cli_site;
	$dados['tribut'] 			= $cli_tribut;
	$dados['ativo'] 			= $cli_ativo;
	$dados['uda'] 				= $cli_uda;
	$dados['malote'] 			= $cli_malote;
	$dados['mail'] 				= $cli_mail;
	$dados['emp_usaca']			= $cli_usaca;
	$dados['emp_capor']			= $cli_capor;
	$dados['emp_vinculo']	= $_SESSION["sys_id"];
    $whr = "cod=".$cli_cod;
	$fn->Audit("tri_clientes", $whr, $dados, $cli_cod, $_SESSION['usu_cod'],1);
	
	if (!$rs_eve->Altera($dados,"tri_clientes","cod=".$cli_cod)) {
        $resul["status"] 	= "OK";
        $resul["mensagem"] 	= "Cliente Alterado!";
        $resul["sql"] 		= $rs_eve->sql;
        $hist->add_hist(13);
        $rs2->Exclui("cpcviews", "cpc_cli=".$cli_cod);
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
		"ir_valor" 	=> str_replace(",", ".", $ir_valor),
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
        $hist->add_hist(14);
    } else {
		$resul["status"] = "ERRO";
        $resul["mensagem"] = "Falha na inclus&atilde;o";
        $resul["sql"] = $rs_eve->sql;
    }
	echo json_encode($resul);
    exit;
	
}

if($acao=="Send_IRPF"){
	$sq = "SELECT * FROM documentos a
	JOIN empresas b ON a.doc_cli_cnpj = b.emp_cnpj
	JOIN contatos c ON a.doc_cli_cnpj = c.con_cli_cnpj
	WHERE doc_cod={$cod} AND con_tipo='fa fa-envelope'";
	$rs1->FreeSql($sq);
	if($rs1->linhas==0){
		$resul["status"] = "NOK";
		$resul["mensagem"] = "Não encontramos destinatário para a mensagem!";
	}
	else{
		$rs1->GeraDados();
		$cod_ims = $rs_eve->autocod("ims_id","irpf_mailsender");
		$dados["ims_id"] = $cod_ims;
		$dados['ims_dest'] = $rs1->fld("con_contato");
		$message = file_get_contents("../view/template_ipfSender.html");
		$message = str_replace("{CLIENTE}", $rs1->fld("emp_razao"),$message);
		$dados['ims_message'] = stripslashes($message);
		$dados['ims_clicpf'] = $rs1->fld("doc_cli_cnpj");
		$dados['ims_user'] = $rs1->fld("doc_user_env");
		$dados['ims_enviado'] =2;
		if(!$rs_eve->Insere($dados,"irpf_mailsender")){
			$resul["status"] = "OK";
	        $resul["mensagem"] = "Novo evento cadastrado!";
	        $resul["sql"] = $rs1->sql;
	        $resul["codigo"] = $cod_ims;
	       	//$hist->add_hist(14);
		}
		else{
			$resul["status"] = "ERRO";
	        $resul["mensagem"] = "Falha na inclus&atilde;o";
	        $resul["sql"] = $rs_eve->sql;
		}
	}
	echo json_encode($resul);
 	exit;
}

if($acao=="mail_action"){
	$whr = "ims_id = ".$mail;
	$dados['ims_dest'] = $dests;
	$dados['ims_arquivo'] = $anexos;
	$dados['ims_user'] = $_SESSION['usuario'];
	$dados['ims_message'] = str_replace('"', '', $message);
	$dados['ims_enviado'] = $status;
	if(!$rs_eve->Altera($dados,"irpf_mailsender",$whr)){
		$resul["status"] = "OK";
        $resul["mensagem"] = "Salvo na pasta ".($status==0?"Itens Enviados":"Rascunho");
        $resul["sql"] = $rs_eve->sql;
        //$hist->add_hist(14);
	}
	else{
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

    if(!empty($tipo)){
    	goto ret;
    }
	else{
		echo json_encode($resul);
	}
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
			if(isset($irh_pend)){
				$dados2=array("ir_pendencia"=>$irh_pend);
				$rs1->Altera($dados2,"irrf","ir_id=".$irh_id);
			}
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
	$dados['ir_valor'] = str_replace(",", ".", $ir_valor);
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
		$resul['recibo']=$dados['ir_reciboId'];
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
	$dados["emp_cod_ac"] 	= $emp_cod_ac;
	$dados["emp_senha_ac"] 	= $emp_senha_ac;
	$dados["emp_validadesen"] 	= $fn->data_usa($emp_expsenha);
	$dados["emp_nasc"] 		= $fn->data_usa($emp_nasc);
	$dados["emp_benef"] 	= $emp_benef;
	$dados["emp_cep"] 		= $fn->sanitize($emp_cep);
	$dados["emp_logr"] 		= $emp_log;
	$dados["emp_num"] 		= $emp_num;
	$dados["emp_compl"] 	= $emp_compl;
	$dados["emp_bairro"] 	= $emp_bai;
	$dados["emp_cidade"] 	= $emp_cid;
	$dados["emp_uf"] 		= $emp_uf;
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

if($acao == "altera_obs"){
	$dados["emp_obs"] 	= $emp_obs;
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
	
	$dados["dados_notas"] 	= $notas;
	$dados["dados_usu_email"] = $usu_email;
	$dados["dados_usucor"] = $usu_cor;
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

if($acao == "atribuir_empresas"){
	$dados["usu_empresas"] = $empresas;
	if(!$rs_eve->Altera($dados, "usuarios","usu_cod ='".$user."'")){
		$resul["status"] = "OK";
        $resul["mensagem"] = "Empresas ".$empresas." atribuidas para o usuário ".$user;
        $resul["sql"] = $rs_eve->sql;
    } else {
		$resul["status"] = "ERRO";
        $resul["mensagem"] = "Falha no envio";
        $resul["sql"] = $rs_eve->sql;
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
	$dados['irec_valor'] = str_replace(",", ".", $valor);
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
	$opts = "<option SELECTED value=''>TODOS</option>";
	$rs_eve->Seleciona("*","usuarios","usu_dep = ".$id_dep." AND usu_ativo='1'");
	while($rs_eve->GeraDados()){
		$opts.= "<option value='".$rs_eve->fld("usu_cod")."'>".$rs_eve->fld("usu_nome")."</option>";
	}
	echo $opts;
}

/* COMBOBOX TELA METAS*/
if($acao == "combo_metas"){
	$sql  = "SELECT a.ob_titulo, b.imp_nome FROM obrigacoes a 
				JOIN tipos_impostos b ON a.ob_titulo = b.imp_id 
			WHERE a.ob_cod = ".$mcod;
			if($_SESSION['classe']<>1){
				$sql.=" AND a.ob_depto = ".$mdep;
			}
	$sql.=" GROUP BY imp_id ORDER BY imp_nome ASC";
	$rs_eve->FreeSql($sql);
	while($rs_eve->GeraDados()){
		echo "<option value='".$rs_eve->fld("ob_titulo")."'>".$rs_eve->fld("imp_nome")."</option>";
	}
}

/* COMBOBOX TELA PERMISSAO*/
/* COMOBOX DINAMICO - Base no controle.js*/

if($acao == "popula_func"){
	$rs_eve->Seleciona("*","usuarios","usu_classe = ".$cod." AND usu_ativo='1'");
	echo "<option value=''>Selecione:</option>";
	while($rs_eve->GeraDados()){
		
		echo "<option value='".$rs_eve->fld("usu_cod")."'>".$rs_eve->fld("usu_nome")."</option>";
	}
}

if($acao == "get_empregados"){
	$whr = "usu_dep = ".$dep." AND usu_ativo='1'";
	$con = $per->getPermissao("todos_func",$_SESSION['usu_cod']);
	if($con["C"]==0){
		$whr.= " AND usu_cod = ".$_SESSION['usu_cod'];
	}
	$rs_eve->Seleciona("*","usuarios",$whr);
	echo "<option value=''>Selecione:</option>";
	while($rs_eve->GeraDados()){
		
		echo "<option value='".$rs_eve->fld("usu_cod")."'>".$rs_eve->fld("usu_nome")."</option>";
	}
}


if($acao == "opt_obtitulo"){
	echo "<option value='0'>Selecione:</option>";
	// Verifica quais titulos existem na tabela Obrigações para a empresa
	$impos = array();
	$sql = "SELECT ob_titulo FROM obrigacoes WHERE ob_cod = {$codi}";
	if($obid<>""){
		$sql.= " AND ob_id=".$obid;
	}
	$rs_eve->FreeSql($sql);
	while($rs_eve->GeraDados()){
		$impos[] = $rs_eve->fld("ob_titulo");
	}

	$sql = "SELECT distinct(imp_id), imp_nome FROM tipos_impostos a 
				LEFT JOIN obrigacoes b ON a.imp_id = b.ob_titulo";
	$sql.=" WHERE imp_tipo IN(".$tipo.") AND imp_depto = ".$dept;
	if($obid<>""){
		$sql.= " AND ob_id=".$obid;
	}
	$sql.=" GROUP BY imp_id";
	$rs_eve->FreeSql($sql); 
	echo $rs_eve->sql;
	while($rs_eve->GeraDados()){
		$disable = ((in_array($rs_eve->fld("imp_id"), $impos) && ($rs_eve->linhas>2))?"DISABLED":"");
		echo "<option {$disable} value=".$rs_eve->fld("imp_id").">".$rs_eve->fld("imp_nome")."</option>";
	}
}

if($acao == "opt_arquivo"){
	echo "<option value=''>Selecione:</option>";
	// Verifica quais titulos existem na tabela Obrigações para a empresa
	$impos = array();
	$sql = "SELECT cliarq_arqId FROM clientes_arquivos WHERE cliarq_empresa = {$codi}";
	if($caid<>""){
		$sql.= " AND cliarq_id=".$caid;
	}
	$rs_eve->FreeSql($sql);
	while($rs_eve->GeraDados()){
		$impos[] = $rs_eve->fld("cliarq_arqId");
	}

	$sql = "SELECT distinct(tarq_id), tarq_nome, tarq_duplica FROM tipos_arquivos a 
				LEFT JOIN clientes_arquivos b ON a.tarq_id = b.cliarq_arqId";
	$sql.=" WHERE tarq_depart = ".$dept;
	if($caid<>""){
		$sql.= " AND cliarq_id=".$caid;
	}
	$sql.=" GROUP BY tarq_id";
	$rs_eve->FreeSql($sql); 
	echo $rs_eve->sql;
	while($rs_eve->GeraDados()){
		$disable = ((in_array($rs_eve->fld("tarq_id"), $impos) && ($rs_eve->linhas>2) && ($rs_eve->fld("tarq_duplica")=='N'))?"DISABLED":"");
		echo "<option {$disable} value=".$rs_eve->fld("tarq_id").">".$rs_eve->fld("tarq_nome")."</option>";
	}
}

if($acao == "combo_arquivo"){
	echo "<option value=''>Selecione:</option>";
	// Verifica quais titulos existem na tabela Obrigações para a empresa
	$impos = array();
	$sql = "SELECT cliarq_arqId FROM clientes_arquivos WHERE cliarq_empresa = {$codi}";
	if($caid<>""){
		$sql.= " AND cliarq_id=".$caid;
	}
	$rs_eve->FreeSql($sql);
	while($rs_eve->GeraDados()){
		$impos[] = $rs_eve->fld("cliarq_arqId");
	}

	$sql = "SELECT distinct(tarq_id), tarq_nome FROM tipos_arquivos a 
				LEFT JOIN clientes_arquivos b ON a.tarq_id = b.cliarq_arqId";
	$sql.=" WHERE tarq_depart = ".$dept;
	if($caid<>""){
		$sql.= " AND cliarq_id=".$caid;
	}
	$sql.=" GROUP BY tarq_id ORDER BY tarq_nome ASC";
	$rs_eve->FreeSql($sql); 
	echo $rs_eve->sql;
	while($rs_eve->GeraDados()){
		$disable = (!(in_array($rs_eve->fld("tarq_id"), $impos) && ($rs_eve->linhas>2))?"DISABLED":"");
		echo "<option {$disable} value=".$rs_eve->fld("tarq_id").">".$rs_eve->fld("tarq_nome")."</option>";
	}
}


if($acao == "entra_docs"){
	foreach ($doc as $value) {
		$cod = $rs_eve->autocod("doc_id","docs_entrada");
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
		if(!$rs_eve->Insere($dados, "docs_entrada")){
			$dados2['drec_docId'] 	= addslashes($value);
			$dados2['drec_entId'] 	= $cod;
			$dados2['drec_empCod'] 	= $emp;
			$dados2['drec_compet'] 	= $ref;
			$rs2->Insere($dados2, "doc_recebidos");
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
ret:
	$dados = array();
	$rs2 = new recordset();
	$dados['iret_ir_id'] 	= $irid;
	$dados['iret_tipo'] 	= $tipo;
	
	if($tipo == "IAP"){
		$dados['iret_valor'] 	= str_replace(",", ".", $valor);
		$dados['iret_cotas'] 	= $cotas;
		$dados['iret_pagto'] 	= $pagto;
		$dados['iret_datalib'] 	= date("Y-m-d");
		if(!$rs2->Insere($dados,"irpf_retorno")){
			$resul['status'] = "OK";
			$resul['mensagem']="Status: IAP";
			$resul['sql']=$rs2->sql;
			/*--|Cadastra dados para faturas DARF|--*/
			$dados2= array();
			$mes = 3;
			for($r=1;$r<=$cotas;$r++){
				$dados2['icot_ir_id'] = $irid;
				$dados2['icot_parc']  = $r;
				$dados2['icot_valor'] = str_replace(",", ".", $valor);
				$ref = str_pad($mes+$r, 2 , "0",STR_PAD_LEFT)."/".date("Y"); // 04/2016
				$dados2['icot_ref']   = $ref;
				$rs1->Insere($dados2, "irpf_cotas");
			}
		}
		else{
			$resul['stat']="NOK";
			$resul['mensagem']="Falha no SQL";
			$resul['sql']=$rs2->sql;
		}
	}

	if($tipo == "IAR"){
		$dados['iret_datalib'] 	= $fn->data_usa($dtlib);
		$dados['iret_pagto'] = $pagto;
		if(!$rs2->Insere($dados,"irpf_retorno")){
			$resul['stat'] = "OK";
			$resul['mensagem']="Status: IAR";
			$resul['sql']=$rs2->sql;
		}
		else{
			$resul['stat']="NOK";
			$resul['mensagem']="Falha no SQL";
			$resul['sql']=$rs2->sql;
		}
	}
	if($tipo == "SSI"){
		$dados['iret_datalib'] 	= date("Y-m-d");
		if(!$rs2->Insere($dados,"irpf_retorno")){
			$resul['stat'] = "OK";
			$resul['mensagem']="Status: SSI";
			$resul['sql']=$rs2->sql;
		}
		else{
			$resul['stat']="NOK";
			$resul['mensagem']="Falha no SQL";
			$resul['sql']=$rs2->sql;
		}
	}
	// Cadastro no historico do IRPF
	$dados2 = array(); // Limpando para reuso
	$dados2['irh_ir_id']	= $irid;
	$dados2['irh_usu_cod'] 	= $_SESSION['usu_cod'];
	$dados2['irh_obs'] 		= "Retorno da Receita: ".$tipo;
	$dados2['irh_dataalt'] 	= date('Y-m-d');
	$rs1->Insere($dados2, "irrf_historico");
	
	echo json_encode($resul,true);
	exit;

}

if ($acao == "selic") {
	list($m,$a) = explode("/",$ref);
	$dados['isel_ref'] = $a."-".str_pad($m, 2,"0",STR_PAD_LEFT);
	$dados['isel_taxa'] = str_replace(",", ".", $taxa); 

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
		$rs_exc = new recordset();
		$rs_exc->Exclui("irpf_cotas","icot_ir_id=".$codigo);
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

if($acao == "exclui_benef"){
	if(!$rs_eve->Exclui("irpf_outrosdocs","irdocs_id=".$codigo)){
		$resul['status'] = "OK";
		$resul['mensagem']="Dado excluido da tabela IRPF OUTROS DOC";
		$resul['sql']=$rs_eve->sql;
	}
	echo json_encode($resul);
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
	$dados['cham_empvinc']	= $_SESSION['usu_empcod'];
	$dados['cham_task']		= addslashes($cham_task);
	$dados['cham_maquina']	= $cham_maq;
	$dados['cham_solic']	= ($cham_cola == 0 ? $_SESSION['usu_cod'] : $cham_cola);
	$dados['cham_abert']	= date("Y-m-d H:i:s");
	
	if(!$rs_eve->Insere($dados, "chamados")){
		// INSERINDO OBSERVAÇÂO
		$rs2 = new recordset();
		$dados2 = array();
		$dados2['chobs_chamid'] = $cod;
		$dados2['chobs_obs'] 	= addslashes($cham_obs);
		$dados2['chobs_user']	= ($cham_cola == 0 ? $_SESSION['usu_cod'] : $cham_cola);
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
			// CHAT OBSOLETO VERSÃO 1.6
			/*
			$dados2 = array();
			
			$user1 = $rs2->pegar("cham_trat","chamados",$whr);
			$user2 = $rs2->pegar("cham_solic","chamados",$whr);
			$dados2["chat_msg"]	= "O seu chamado (#".$cham_id.") foi alterado. Msg: ".addslashes($cham_obs);
			$dados2["chat_de"] 	= ($_SESSION['usu_cod']==$user1 ? $user1 : $user2);
			$dados2["chat_para"] = ($_SESSION['usu_cod']<>$user2 ? $user2 : $user1);
			$dados2["chat_lido"] = 0;
			$dados2["chat_hora"] = date("Y-m-d H:i:s"); 
			$rs2->Insere($dados2,"chat");
			*/
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
		$resul['mensagem']	= "Já existe um dado de hor&aacute;rio para o colaborador no dia digitado";
		$resul['sql']		= $rs2->sql;	
	}
	else{
	// Se não houver -->
		$cod = $rs_eve->autocod("ch_id","controle_horas");
		$dados['ch_id'] 			= $cod;
		$dados['ch_data'] 			= $fn->data_usa($ch_data);
		$dados['ch_colab'] 			= $ch_colab;
		$dados['ch_hora_entrada'] 	= $ch_hora_entrada;
		$dados['ch_hora_saida'] 	= $ch_hora_saida;
		$dados['ch_horario'] 		= $ch_hora_tipo;
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
	$dados['cod'] 				= $cli_cod;
	$dados['cnpj'] 				= $cli_cnpj;
	$dados['empresa'] 			= $cli_nome;
	$dados['apelido'] 			= $cli_apelido;
	$dados['cpr'] 				= $cli_cpr;
	$dados['cnae'] 				= $cli_cnae;
	$dados['emp_nire'] 			= $cli_nire;
	$dados['inscr'] 			= $cli_iest;
	$dados['emp_inscmun'] 		= $cli_imun;
	$dados['emp_datajucesp'] 	= $fn->data_usa($cli_juce);
	$dados['emp_inicio']		= $fn->data_usa($cli_inicio);
	$dados['emp_dataie']		= $fn->data_usa($cli_dataie);
	$dados['emp_dataim']		= $fn->data_usa($cli_dataim);
	$dados['emp_datatrib']		= $fn->data_usa($cli_datatrib);
	$dados['emp_datacnpj']		= $fn->data_usa($cli_datacnpj);
	$dados['emp_cep']			= $fn->sanitize($cli_cep);
	$dados['emp_logradouro']	= $cli_log;
	$dados['emp_numero']		= $cli_num;
	$dados['emp_complemento']	= $cli_compl;
	$dados['emp_bairro']		= $cli_bai;
	$dados['emp_cidade']		= $cli_cid;
	$dados['emp_uf']			= $cli_uf;
	$va_cap = str_replace(".", "", $cli_capital);
	$dados['emp_capital']		= str_replace(",", ".", $va_cap);
	$dados['emp_integraliza']	= $cli_integra;
	$dados['emp_atividades']	= $cli_atividade;
	$dados['responsavel'] 		= $cli_resp;
	$dados['regiao'] 			= $cli_reg;
	$dados['tipo_emp'] 			= $cli_tipo;
	$dados['num_emp'] 			= $cli_func;
	$dados['telefone'] 			= $cli_tel;
	$dados['email']				= $cli_mail;
	$dados['site'] 				= $cli_site;
	$dados['tribut'] 			= $cli_tribut;
	$dados['ativo'] 			= $cli_ativo;
	$dados['uda'] 				= $cli_uda;
	$dados['malote'] 			= $cli_malote;
	$dados['mail'] 				= $cli_mail;
	$dados['emp_usaca']			= $cli_usaca;
	$dados['emp_capor']			= $cli_capor;
	$dados['emp_vinculo'] 		= $_SESSION["sys_id"];
	$fn->Audit("tri_clientes", "cod=".$cli_cod, $dados, $cli_cod, $_SESSION['usu_cod'],2);
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
	$dados['usu_nome'] 		= trim($usu_nome);
	$dados['usu_cpf'] 		= $usu_cpf;
	$dados['usu_senha']		= (md5($usu_senha));
	$dados['usu_emp_cnpj']	= ($_SESSION['usu_empresa']);	
	$dados['usu_classe']	= $sel_class;
	$dados['usu_email'] 	= $usu_email;
	$dados['usu_ativo'] 	= '1';
	$dados['usu_dep']	    = $sel_depto;
	$dados['usu_lider']	    = $sel_lider;
	$dados['usu_ramal']		= $usu_ramal;
	$dados['usu_pausa']		= $usu_pausa;
	$dados['usu_foto'] 		= '/sistema/assets/perfil/masc.jpg';
	$dados['usu_empcod'] 	=  $_SESSION['usu_empcod'];
	
	
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
	$fn->Audit("tri_clientes", "cod=".$emp_cod, $dados, $emp_cod, $_SESSION['usu_cod'],3);
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

if($acao == "exclui_obrigac"){
	$dados['ob_ativo'] = 0;
	if(!$rs_eve->Altera($dados, "obrigacoes","ob_id=".$ob_id." AND ob_cod=".$cod)){
		$resul['status']	= "OK";
		$resul['mensagem']	= "Imposto {$ob_id} da empresa {$cod} como inativo!";
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
	$fn->Audit("servicos", "ser_id=".$cod, $dados, $serv_cli, $_SESSION['usu_cod'],2);

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
	$fn->Audit("senhas", "sen_id=".$cod, $dados, $sen_clicod, $_SESSION['usu_cod'],2);	
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
	$fn->Audit("senhas", $whr, $dados, $sen_clicod, $_SESSION['usu_cod'],1);
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
	$dados['part_lei']			= $part_lei;
	$dados['part_link']			= $part_link;
	$dados['part_dataoc']		= $fn->data_usa($part_dataoc);
	$fn->Audit("particularidades", "part_id=".$cod, $dados, $part_clicod, $_SESSION['usu_cod'],2);
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
	$dados['part_dataoc']		= $fn->data_usa($part_dataoc);
	$whr = "part_id=".$part_id;
	$fn->Audit("particularidades", $whr, $dados, $part_clicod, $_SESSION['usu_cod'],1);
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
	$fn->Audit("comunicacao", "com_id=".$cod, $dados, $com_clicod, $_SESSION['usu_cod'],2);
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
	$fn->Audit("comunicacao", $whr, $dados, $com_clicod, $_SESSION['usu_cod'],1);
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
	foreach ($ob_titulo as $value) {
		
		$cod = $rs_eve->autocod("ob_id","obrigacoes");
		$dados['ob_id']				= $cod;
		$dados['ob_cod'] 			= $ob_clicod;
		$dados['ob_titulo'] 		= addslashes($value);
		$dados['ob_depto'] 			= $ob_depto;
		$dados['ob_venc'] 			= $ob_venc;
		$dados['ob_ativo']		    = $ob_ativo;
		$fn->Audit("obrigacoes", "ob_id=".$cod, $dados, $ob_clicod, $_SESSION['usu_cod'],2);
		if(!$rs_eve->Insere($dados,"obrigacoes")){
			$resul['status']	= "OK";
			$resul['mensagem']	= "Obriga&ccedil;&atilde;o cadastrada";
			$resul['sql']		= $rs_eve->sql;
		}
		else{
			$resul['mensagem']	= "Ocorreu um erro...";
			$resul['sql']		= $rs_eve->sql;
		}
	}
	echo json_encode($resul);
    exit;
}

if($acao == "cli_Altobr"){
	$dados['ob_cod'] 			= $ob_clicod;
	$dados['ob_titulo'] 		= $ob_titulo[0];
	$dados['ob_depto'] 			= $ob_depto;
	$dados['ob_venc'] 			= $ob_venc;
	$dados['ob_ativo']		    = $ob_ativo;
	$whr = "ob_id =".$ob_id;
	$fn->Audit("obrigacoes", $whr, $dados, $ob_clicod, $_SESSION['usu_cod'],1);
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
	$cod = $rs_eve->autocod("ob_id","obrigacoes");
	$dados['ob_id']		= $cod;
	$dados['ob_cod'] 	= $tr_clicod;
	$dados['ob_titulo']	= addslashes($tr_titulo);
	$dados['ob_depto'] 	= $tr_depto;
	$dados['ob_ativo']	= $tr_ativo;
	$dados['ob_venc'] 	= $tr_venc;
	$fn->Audit("obrigacoes", "ob_id=".$cod, $dados, $tr_clicod, $_SESSION['usu_cod'],2);
	
	if(!$rs_eve->Insere($dados,"obrigacoes")){
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
	$dados['ob_cod'] 	= $tr_clicod;
	$dados['ob_titulo'] = addslashes($tr_titulo);
	$dados['ob_depto'] 	= $tr_depto;
	$dados['ob_ativo']	= $tr_ativo;
	$dados['ob_venc'] 	= $tr_venc;
	$whr = "ob_id =".$tr_id;
	$fn->Audit("obrigacoes", $whr, $dados, $tr_clicod, $_SESSION['usu_cod'],1);
	if(!$rs_eve->Altera($dados,"obrigacoes",$whr)){
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

if($acao == "cli_CadCertid"){
	foreach ($certid_tipo as $value) {
		
		$cod = $rs_eve->autocod("certid_id","certidoes");
		$dados['certid_id']			= $cod;
		$dados['certid_cod'] 		= $certid_cod;
		$dados['certid_tipoId'] 	= addslashes($value);
		$dados['certid_validade']	= $fn->data_usa($certid_val);
		$dados['certid_status']	    = $certid_status;
		$fn->Audit("certidoes", "certid_id=".$cod, $dados, $certid_cod, $_SESSION['usu_cod'],2);
		if(!$rs_eve->Insere($dados,"certidoes")){
			$resul['status']	= "OK";
			$resul['mensagem']	= "Certid&atilde;o cadastrada";
			$resul['sql']		= $rs_eve->sql;
		}
		else{
			$resul['mensagem']	= "Ocorreu um erro...";
			$resul['sql']		= $rs_eve->sql;
		}
	}
	echo json_encode($resul);
    exit;
}

if($acao == "cli_AltCertid"){
	$dados['certid_cod'] 		= $certid_cod;
	$dados['certid_tipoId'] 		= $certid_tipo[0];
	$dados['certid_validade'] 	= $fn->data_usa($certid_val);
	$dados['certid_status']	    = $certid_status;
	$whr = "certid_id =".$certid_id;
	$fn->Audit("certidoes", $whr, $dados, $certid_cod, $_SESSION['usu_cod'],1);
	if(!$rs_eve->Altera($dados,"certidoes",$whr)){
		$resul['status']	= "OK";
		$resul['mensagem']	= "certid&atilde;o alterada";
		$resul['sql']		= $rs_eve->sql;
	}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs_eve->sql;
	}
	echo json_encode($resul);
    exit;
}

if($acao == "exclui_certid"){
	$dados['certid_status'] = 0;
	if(!$rs_eve->Altera($dados, "certidoes","certid_id=".$cert_id." AND certid_cod=".$cod)){
		$resul['status']	= "OK";
		$resul['mensagem']	= "Certidão {$cert_id} da empresa {$cod} como inativo!";
		}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs->sql;
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
		$fn->Audit("tri_clientes", $whr, $dados, $cods, $_SESSION['usu_cod'],1);
		$rsalt->Altera($dados, "tri_clientes", $whr);
		
	} 

	$resul['status'] = "OK";
	$resul['mensagem'] = "Carteira definida!";
	$resul['sql'] =  json_encode($dados2);
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
	$dados['imp_mes']			= $imp_mes;
	/*
	Não necessário na versão 1.1.6
	$dados['imp_pasta']			= $imp_pasta;
	$dados['imp_arquivo']		= $imp_arquivo;
	*/
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
	/*
    Obsoleto na versão 1.1.6
	$dados['imp_pasta']			= $imp_pasta;
	$dados['imp_arquivo']		= $imp_arquivo;
 	*/
	$dados['imp_venc']			= $imp_venc;
	$dados['imp_mes']			= $imp_mes;
	$dados['imp_tipo']			= $imp_tipo;
	$whr = "imp_id=".$imp_id;
	//$fn->Audit("tipos_impostos", $whr, $dados, $imp_id, $_SESSION['usu_cod']);
	if(!$rs_eve->Altera($dados,"tipos_impostos",$whr)){
		$resul['status']	= "OK";
		$resul['mensagem']	= "Imposto alterado!";
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

if($acao == "combo_mat"){
	$rs_eve->Seleciona("*", "mat_cadastro","mcad_catId=".$mcat_id);
	echo "<option value='0'>Selecione...</option>";
	while($rs_eve->GeraDados()){
		echo "<option value='".$rs_eve->fld("mcad_id")."'>".$rs_eve->fld("mcad_desc")."</option>";
	}
	exit;
}

if($acao == "cons_horas"){
	/*|INÍCIO: PESQUISAR PELAS HORAS APONTADAS NO CONTROLE DE HORAS|*/
	$sql = "SELECT * FROM controle_horas WHERE ch_colab={$usu_cod} AND ch_status=101";
	$rs_eve->FreeSql($sql);
	$horas = 0;
	$horasp = 0;
	$horasn = 0;
	if($rs_eve->linhas >0){
		while($rs_eve->GeraDados()){
			$dia = $fn->DiaDaSemana($rs_eve->fld("ch_data"));
			$num = ($fn->hora_decimal($rs_eve->fld("ch_hora_saida"))-($dia==6 ? 450 : 1020))/60;
			$horas += $num;
			$horasp += $num;
		}
		/*|APÓS, CONSULTA MESMO COLABORADOR AFIM DE VERIFICAR AS HORAS DESCONTADAS|*/
		$sql = "SELECT * FROM desconto_horas WHERE desc_colab={$usu_cod}";
		$rs_eve->FreeSql($sql);
		if($rs_eve->linhas >0){
			while($rs_eve->GeraDados()){
				$horas -= $rs_eve->fld("desc_horas");
				$horasn += $rs_eve->fld("desc_horas");
			}
		}
		$resul["status"] = "OK";
		$resul["disp"] = number_format($horas,2,",",".");
		$resul["sql"] = "horas positivas: ($horasp} Horas negativas:{$horasn}";
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
	$cod = $rs_eve->autocod("desc_id","desconto_horas");
	$dados['desc_id'] 		= $cod;
	$dados["desc_colab"] 	= $dhor_colab;
	$dados["desc_horas"] 	= str_replace(",", ".", $dhor_desc);
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

if($acao == "imp_pesq"){
	$con = $per->getPermissao("ver_impostos", $_SESSION['usu_cod']);
	$con1 = $per->getPermissao("ver_empresas", $_SESSION['usu_cod']);
	$sql = "SELECT a.imp_id,
				   a.imp_mes,a.imp_nome, a.imp_venc,
				   a.imp_regra, a.imp_tipo, a.imp_depto,
				   c.ob_venc,
				   e.carteira, e.cod as CodO, e.apelido as EmpO
				FROM tipos_impostos a
					LEFT JOIN obrigacoes c ON c.ob_titulo = a.imp_id
					LEFT JOIN tri_clientes e ON e.cod = c.ob_cod
				WHERE e.ativo = 1";
		if($con1['C']==0){
			$sql.= " AND imp_depto=".$_SESSION['dep'];
		}
		
		if($con['C']==0){
			$sql.= " AND e.carteira LIKE '%\"user\":\"".$_SESSION['usu_cod']."\"%'";
		}
		
		if($emp<>""){
			$sql.=" AND (e.cod = ".$emp.")";
		}
		
		if($imp<>""){
			$sql.=" AND imp_id = ".$imp;
		}

		if($dep<>""){
			$sql.=" AND imp_depto = ".$dep;
		}

		if(isset($itp) AND $itp<>""){
			$sql.= " AND imp_tipo ='".$itp."'";
		}
		
		if($usu<>""){
			$sql.=" AND carteira LIKE '%\"user\":\"".$usu."\"%'";
		}

	$sql.=" AND c.ob_ativo=1 ORDER BY e.apelido ASC, a.imp_id ASC";//, cast(a.imp_venc as unsigned integer) ASC";
	$tbl = "";
	//echo $sql."<br>";
	$rs_eve->FreeSql($sql);
	if($rs_eve->linhas>0){
		while($rs_eve->GeraDados()){
			$colab = json_decode($rs_eve->fld("carteira"),true);
	
			$emp_im = $rs_eve->fld("CodO");
			$emp_no = $rs_eve->fld("EmpO");
			$hide = (empty($emp_no)?"disabled":"");
			$mes_cp = '';
			$sql1 = "SELECT * FROM impostos_enviados 
						WHERE env_codImp = ".$rs_eve->fld("imp_id");
			$cc=(empty($rs_eve->fld("imp_mes"))?0:(date("m")-1)+$rs_eve->fld("imp_mes"));
			
			if(isset($comp) AND $comp<>""){
				$sql1.=" AND env_compet = '".$comp."'";
				$cc = substr($comp,0,2);
				$mcomp = str_pad($cc,2,"0",STR_PAD_LEFT);
				$mes_cp = $comp;
				if($rs_eve->fld("imp_regra")=="dia_spec"){
					$cc=substr($comp,0,2)+2;
				}
			}
			else{
				$mes_cp = ( date('d') > 28 ? date("m/Y", strtotime("last day of previous month")) : date("m/Y", strtotime("-1 month")) );
				$sql1.=" AND env_compet = '".$mes_cp."'";
			}
			if($emp_no<>""){
				$sql1.=" AND env_codEmp = ".$emp_im;
			}
			

			$rs1->FreeSql($sql1);
			//echo $sql1.";<br>";
			//echo $colab[$rs_eve->fld("imp_depto")]["user"];
			//if($rs1->linhas>0){

				$rs1->GeraDados();
				//echo (is_null($rs_eve->fld("imp_mes"))?"é":"Não");
				$vn = "";			
				if($rs_eve->fld("imp_regra")=="mes_subs"){
					$cc=substr($cc,0,2)+1;
					$mes = (is_null($rs_eve->fld("imp_mes"))?$cc:$rs_eve->fld("imp_mes")-1);
					$ref = date("m/Y", strtotime("+".$mes." month"));
					$ref2 = ((isset($comp) AND $comp<>"")?$cc+$mes:date("m")+$mes);
					$vaj = $rs_eve->fld("ob_venc"); 
					$vn = (($rs_eve->fld("ob_venc")<>"" AND $rs_eve->fld("ob_venc")<>0)?$fn->data_br($fn->dia_util($vaj,"dia_util",$ref2)):$fn->ultimo_dia_mes($ref));
				}
				else{
					
					$vn =  $fn->data_br($fn->dia_util($rs_eve->fld("ob_venc"),$rs_eve->fld("imp_regra"),$cc));
					

				}
				
				$mmov = $mger = $mconf = $menv ='';
				if($rs1->fld("env_mov")==1){$mmov.="Movimento gerado por: em: <br>";}
				if($rs1->fld("env_gerado")==1){
					$mger.="Gerado: ".$rs2->pegar("usu_nome","usuarios","usu_cod=".$rs1->fld("env_geradouser"))." em ".$fn->data_hbr($rs1->fld("env_geradodata"));
				}
				if($rs1->fld("env_conferido")==1){
					$mconf.="Conferido: ".$rs2->pegar("usu_nome","usuarios","usu_cod=".$rs1->fld("env_conferidouser"))." em ".$fn->data_hbr($rs1->fld("env_conferidodata"));
				}
				if($rs1->fld("env_enviado")==1){
					$menv.="Enviado: ".$rs2->pegar("usu_nome","usuarios","usu_cod=".$rs1->fld("env_user"))." em ".$fn->data_hbr($rs1->fld("env_data"));
				}
				$tbl .= "<input type='hidden' name='empresa".$rs_eve->fld("imp_id")."' id='empresa".$rs_eve->fld("imp_id")."' value='{$emp_im}'>
						 <input type='hidden' name='compet' id='compet' value='".$mes_cp."'>
						 <tr>
						 	<td>".str_pad($emp_im,3,"0",STR_PAD_LEFT)."</td>
						 	<td>". $emp_no."</td>
							<td>[".$rs_eve->fld("imp_tipo")."] ".$rs_eve->fld("imp_nome")."</td>
							<td>".$vn."</td>
							<td>".(!isset($colab[$rs_eve->fld("imp_depto")]["user"]) || $colab[$rs_eve->fld("imp_depto")]["user"]=="" ?"-":$rs2->pegar("usu_nome","usuarios","usu_cod=".$colab[$rs_eve->fld("imp_depto")]["user"]))."</td>
							<td>
								<select class='select2' id='sel_impmov".$rs_eve->fld("imp_id").$emp_im."'
										onchange=mark_sent('".$emp_im."','".$mes_cp."','".$rs_eve->fld("imp_id")."',this.value,'mov','ckimpmov".$rs_eve->fld("imp_id").$emp_im."')>
									<option ".($rs1->linhas==0?'SELECTED':'')." value=''>Selecione:</option>
									<option ".($rs1->fld("env_mov")==1?'SELECTED':'')." value='1'>Sim</option>
									<option ".($rs1->linhas<>0 && $rs1->fld("env_mov")==0?'SELECTED':'')." value='0'>Não</option>
								</select>

							</td>
							<td>
								<span title='".$mger."' data-toggle='tooltip'>
								<input 
									
									class='chk_imp' ".$hide."
									type='checkbox' 
									value=1
									id='ckimpger".$rs_eve->fld("imp_id").$emp_im."'
									onchange=mark_sent('".$emp_im."','".$mes_cp."','".$rs_eve->fld("imp_id")."',this.checked,'gerado','ckimpger".$rs_eve->fld("imp_id").$emp_im."')
									" .($rs1->fld("env_gerado")==1?'CHECKED':'') ."  
									data-onstyle='success' 
									data-size='mini' 
									data-toggle='toggle'
									".($rs1->fld("env_mov")==0?"disabled":"")."
									>
								</span>
							</td>
							<td>
								<span title='".$mconf."' data-toggle='tooltip'>
								<input 
									class='chk_imp' ".$hide."
									type='checkbox' 
									value=1
									id='ckimpconf".$rs_eve->fld("imp_id").$emp_im."'
									onchange=mark_sent('".$emp_im."','".$mes_cp."','".$rs_eve->fld("imp_id")."',this.checked,'conferido','ckimpconf".$rs_eve->fld("imp_id").$emp_im."')
									" .($rs1->fld("env_conferido")==1?'CHECKED':'') ."  
									data-onstyle='success' 
									data-size='mini' 
									data-toggle='toggle'
									".($rs1->fld("env_mov")==0?"disabled":"")."
									>
								</span>
							</td>
							<td>
								
								<span title='".$menv."' data-toggle='tooltip' class='text-center'>
								<input 
									class='chk_imp' ".$hide."
									type='checkbox' 
									value=1
									id='ckimpenv".$rs_eve->fld("imp_id").$emp_im."'
									onchange=mark_sent('".$emp_im."','".$mes_cp."','".$rs_eve->fld("imp_id")."',this.checked,'envio','ckimpenv".$rs_eve->fld("imp_id").$emp_im."')
									" .($rs1->fld("env_enviado")==1?'CHECKED':'') ."  
									data-onstyle='success' 
									data-size='mini' 
									data-toggle='toggle'
									".($rs1->fld("env_mov")==0?"disabled":"")."
									>
								</span>
							</td>
						 </tr>";
			}
		//}
	}
	else{
		$tbl.="<tr>
					<td colspan=8>Sem Impostos para a empresa {$emp}!</td>
				</tr>";
	}
echo $tbl;
//echo $sql;
exit;
}

if($acao == "inclui_mov"){
	$whr = "env_codEmp = {$empresa} AND env_codImp = {$imposto} AND env_compet = '{$compet}'";
	$dados['env_mov']			= 1;
	$dados['env_gerado']		= '';
	$dados['env_conferido']		= '';
	$dados['env_enviado']		= '';
	$dados['env_movdata'] 		= date("Y-m-d H:i:s");
	$dados['env_geradodata'] 	= 0;
	$dados['env_conferidodata']	= 0;
	$dados['env_confenvdata'] 	= 0;
	$dados['env_movuser'] 		= $_SESSION['usu_cod'];
	$dados['env_geradouser']	= '';
	$dados['env_conferidouser']	= '';
	$dados['env_user']			= '';
	$rs1->Seleciona("env_mov","impostos_enviados",$whr);
	if($rs1->linhas==0){
		$dados['env_codEmp']	= $empresa;
		$dados['env_codImp']	= $imposto;
		$dados['env_compet']	= $compet;
		$fn->Audit("impostos_enviados", $whr, $dados, $empresa, $_SESSION['usu_cod'],7);
		if(!$rs_eve->Insere($dados, "impostos_enviados", $whr)){
			$result['status'] = "OK";
			$result['mensagem'] = "Movimento do Imposto".$rs1->pegar("imp_nome","tipos_impostos","imp_id=$imposto")." marcado como SIM para a competência {$compet}!";
			$result['linhas'] = $rs1->linhas;

		}
		else{
			$result['status'] = "NOK";
			$result['mensagem'] = "Ocorreu um erro!";
		}
	}
	else{
		$fn->Audit("impostos_enviados", $whr, $dados, $empresa, $_SESSION['usu_cod'],1);
		if(!$rs_eve->Altera($dados, "impostos_enviados", $whr)){
			$result['status'] = "OK";
			$result['mensagem'] = "Movimento do Imposto ".$rs1->pegar("imp_nome","tipos_impostos","imp_id=$imposto")." marcado como SIM para a competência {$compet}!";
			$result['linhas'] = $rs1->linhas;
		}
		else{
			$result['status'] = "NOK";
			$result['mensagem'] = "Ocorreu um erro!";
		}
	}

echo json_encode($result);
exit;
}

if($acao == "inclui_gerado"){
	$sql = "SELECT * FROM impostos_enviados WHERE env_codEmp='".$empresa."' AND env_codImp='".$imposto."' AND env_compet='".$compet."' AND env_mov=1";
	$rs1->FreeSql($sql);
	if($rs1->linhas>0){
		$rs1->GeraDados();
		$codImp = $rs1->fld("env_id");
		$dados['env_gerado'] =	$ativo;
		$dados['env_geradodata'] =	date("Y-m-d H:i:s");
		$dados['env_geradouser'] =	$_SESSION['usu_cod'];
		/*|ADEQUAÇÃO
			Cleber Marrara - 14/03/2018
			Se  obrigação for do tipo L, preencher as colunas de Conferido e Enviado.
		|*/
		$lan = $rs_eve->pegar("imp_tipo","tipos_impostos","imp_id=".$imposto);
		if($lan == "L"){
			$dados['env_conferido'] =	$ativo;
			$dados['env_conferidodata'] =	date("Y-m-d H:i:s");
			$dados['env_conferidouser'] =	$_SESSION['usu_cod'];
			$dados['env_enviado'] =	$ativo;
			$dados['env_data'] =	date("Y-m-d H:i:s");
			$dados['env_user'] =	$_SESSION['usu_cod'];
		}
		$whr = "env_codEmp='".$empresa."' AND env_codImp='".$imposto."' AND env_compet='".$compet."' AND env_mov=1";
		$ntent = $rs_eve->pegar("env_geradotent","impostos_enviados",$whr);
		$dados['env_geradotent']=	(int)$ntent +1;
		$fn->Audit("impostos_enviados", $whr, $dados, $empresa, $_SESSION['usu_cod'],6);
		if(!$rs_eve->Altera($dados,"impostos_enviados","env_id=".$codImp)){
			$result['status'] = "OK";
			$result['mensagem'] = "Imposto ".$rs1->pegar("imp_nome","tipos_impostos","imp_id=$imposto")." marcado como GERADO para empresa {$empresa}!";
			$result['teste'] = $ntent;

		}
		else{
			$result['status'] = "NOK";
			$result['mensagem'] = "Ocorreu um erro!";
		}
	}
	else{
		$result['status'] = "NOK";
		$result['mensagem'] = "Antes de GERAR é necessário CRIAR MOVIMENTO para o Imposto/Obrigação!";
	}
	
echo json_encode($result);
exit;
}

if($acao == "inclui_conferido"){
	$sql = "SELECT * FROM impostos_enviados a
				LEFT JOIN tipos_impostos b ON a.env_codImp = b.imp_id
				WHERE env_codEmp='".$empresa."' 
					AND env_codImp='".$imposto."' 
					AND env_compet='".$compet."' 
					AND env_gerado=1";
	$rs1->FreeSql($sql);
	if($rs1->linhas>0){
		$rs1->GeraDados();
		$codImp = $rs1->fld("env_id");
		$con = $per->getPermissao("confere_proprio",$_SESSION['usu_cod']);
		if(($_SESSION['usu_cod'] == $rs1->fld("env_geradouser") && $rs1->fld("imp_tipo")=="A" ) && $con['C']==0){
			$result['status'] = "NOK";
			$result['mensagem'] = "O usuário que GEROU o Imposto/Obrigação não pode CONFERIR!";
		}
		else{
			$dados['env_conferido'] =	$ativo;
			$dados['env_conferidodata'] =	date("Y-m-d H:i:s");
			$dados['env_conferidouser'] =	$_SESSION['usu_cod'];
			/*|ADEQUAÇÃO
			Cleber Marrara - 22/08/2018
			Se  obrigação for do tipo A OU O, preencher as colunas de Enviado.
			|*/
			$lan = $rs_eve->pegar("imp_tipo","tipos_impostos","imp_id=".$imposto);
			if($lan == "A" || $lan == "O"){
				$dados['env_enviado'] =	$ativo;
				$dados['env_data'] =	date("Y-m-d H:i:s");
				$dados['env_user'] =	$_SESSION['usu_cod'];
			}
			$whr = "env_codEmp='".$empresa."' AND env_codImp='".$imposto."' AND env_compet='".$compet."' AND env_gerado=1";
			$ntent = $rs_eve->pegar("env_geradotent","impostos_enviados",$whr);
			$dados['env_conferidotent']=	(int)$ntent +1;
			$fn->Audit("impostos_enviados", $whr, $dados, $empresa, $_SESSION['usu_cod'],5);
			if(!$rs_eve->Altera($dados,"impostos_enviados","env_id=".$codImp)){
				$result['status'] = "OK";
				$result['mensagem'] = "Imposto ".$rs1->pegar("imp_nome","tipos_impostos","imp_id=$imposto")." marcado como CONFERIDO para empresa {$empresa}!";
			}
			else{
				$result['status'] = "NOK";
				$result['mensagem'] = "Ocorreu um erro!";
			}
		}
	}
	else{
		$result['status'] = "NOK";
		$result['mensagem'] = "Antes de CONFERIR é necessário GERAR o Imposto/Obrigação!";
	}
	
echo json_encode($result);
exit;
}

if($acao == "inclui_envio"){
	$sql = "SELECT * FROM impostos_enviados WHERE env_codEmp='".$empresa."' AND env_codImp='".$imposto."' AND env_compet='".$compet."' AND env_conferido=1";
	$whr = " env_codEmp='".$empresa."' AND env_codImp='".$imposto."' AND env_compet='".$compet."' AND env_conferido=1";
	$rs1->FreeSql($sql);
	if($rs1->linhas>0){
		$rs1->GeraDados();
		$codImp = $rs1->fld("env_id");
		$result['status'] = "NOK";
		$dados['env_enviado'] =	$ativo;
		$dados['env_data'] =	date("Y-m-d H:i:s");
		$dados['env_user'] =	$_SESSION['usu_cod'];
		$fn->Audit("impostos_enviados", $whr, $dados, $empresa, $_SESSION['usu_cod'],4);	
		if(!$rs_eve->Altera($dados,"impostos_enviados","env_id=".$codImp)){
			$result['status'] = "OK";
			$result['mensagem'] = "Imposto ".$rs1->pegar("imp_nome","tipos_impostos","imp_id=$imposto")." marcado como enviado para empresa {$empresa}!";
		}
		else{
			$result['status'] = "NOK";
			$result['mensagem'] = "Ocorreu um erro!";
		}
	
	}
	else{
		$result['status'] = "NOK";
		$result['mensagem'] = "Antes de ENVIAR é necessário CONFERIR o Imposto/Obrigação!";
	}
	
echo json_encode($result);
exit;
}

if($acao == "inclui_confenvio"){
	$sql = "SELECT * FROM impostos_enviados WHERE env_codEmp='".$empresa."' AND env_codImp='".$imposto."' AND env_compet='".$compet."' AND env_conferido=1 AND env_enviado=1";
	$whr = " env_codEmp='".$empresa."' AND env_codImp='".$imposto."' AND env_compet='".$compet."' AND env_conferido=1 AND env_enviado=1";
	$rs1->FreeSql($sql);
	if($rs1->linhas>0){
		$rs1->GeraDados();
		$codImp = $rs1->fld("env_id");
		$result['status'] = "NOK";
		$dados['env_confenv'] =	$ativo;
		$dados['env_confenvdata'] =	date("Y-m-d H:i:s");
		$dados['env_confenvuser'] =	$_SESSION['usu_cod'];
		$fn->Audit("impostos_enviados", $whr, $dados, $empresa, $_SESSION['usu_cod'],8);	
		if(!$rs_eve->Altera($dados,"impostos_enviados","env_id=".$codImp)){
			$result['status'] = "OK";
			$result['mensagem'] = "Conferido o envio do Imposto / Obrigação ".$rs1->pegar("imp_nome","tipos_impostos","imp_id=$imposto")." para empresa {$empresa}!";
		}
		else{
			$result['status'] = "NOK";
			$result['mensagem'] = "Ocorreu um erro!";
		}
	
	}
	else{
		$result['status'] = "NOK";
		$result['mensagem'] = "Antes de CONFERIR ENVIO é necessário ENVIAR o Imposto/Obrigação!";
	}
	
echo json_encode($result);
exit;
}

if($acao == "exclui_mov"){
	
	$whr = "env_codEmp = {$empresa} AND env_codImp = {$imposto} AND env_compet = '{$compet}'";
	$dados['env_mov']	= 0;
	$dados['env_gerado']		= 1;
	$dados['env_conferido']		= 1;
	$dados['env_enviado']		= 1;
	$dados['env_movdata'] 		= date("Y-m-d H:i:s");
	$dados['env_geradodata'] 	= date("Y-m-d H:i:s");
	$dados['env_conferidodata']	= date("Y-m-d H:i:s");
	$dados['env_data'] 			= date("Y-m-d H:i:s");
	$dados['env_movuser'] 		= $_SESSION['usu_cod'];
	$dados['env_geradouser']	= $_SESSION['usu_cod'];
	$dados['env_conferidouser']	= $_SESSION['usu_cod'];
	$dados['env_user'] 			= $_SESSION['usu_cod'];
	
	$rs1->Seleciona("env_mov, env_gerado, env_geradouser","impostos_enviados",$whr);
	if($rs1->linhas==0){
		$dados['env_codEmp']	= $empresa;
		$dados['env_codImp']	= $imposto;
		$dados['env_compet']	= $compet;
		$fn->Audit("impostos_enviados", $whr, $dados, $empresa, $_SESSION['usu_cod'],1);
		if(!$rs_eve->Insere($dados, "impostos_enviados", $whr)){
			$result['status'] = "OK";
			$result['mensagem'] = "Envio do Imposto ".$rs1->pegar("imp_nome","tipos_impostos","imp_id=$imposto")." marcado como NÃO!";
			$result['linhas'] = $rs1->linhas;

		}
		else{
			$result['status'] = "NOK";
			$result['mensagem'] = "Ocorreu um erro!";
		}
	}
	else{
		$rs1->GeraDados();
		if($rs1->fld("env_gerado")==1){
			$result['status'] = "OK";
			$result['mensagem'] = "Esse imposto já foi Gerado pelo usuário ".$rs_eve->pegar("usu_nome","usuarios","usu_cod={$rs1->fld("env_geradouser")}");
			$result['linhas'] = $rs1->linhas;
		}
		else{
			$fn->Audit("impostos_enviados", $whr, $dados, $empresa, $_SESSION['usu_cod'],1);
			if(!$rs_eve->Altera($dados, "impostos_enviados", $whr)){
				$result['status'] = "OK";
				$result['mensagem'] = "Envio do Imposto ".$rs1->pegar("imp_nome","tipos_impostos","imp_id=$imposto")." marcado como NÃO!";
				$result['linhas'] = $rs1->linhas;
			}
			else{
				$result['status'] = "NOK";
				$result['mensagem'] = "Ocorreu um erro!";
			}
		}
			
	}

echo json_encode($result);
exit;
}

if($acao == "exclui_gerado"){
	$con = $per->getPermissao("excluienvio", $_SESSION['usu_cod']);
	if($con['E']==1){
		$dados['env_gerado']	= 0;
		$dados['env_geradodata'] 	= date("Y-m-d H:i:s");
		$dados['env_geradouser'] 	= $_SESSION['usu_cod'];
		$whr = "env_codEmp = {$empresa} AND env_codImp = {$imposto} AND env_compet = '{$compet}'";
		$rs1->Seleciona("env_mov, env_conferido, env_conferidouser","impostos_enviados",$whr);
		$rs1->GeraDados();
		if($rs1->fld("env_conferido")==1){
			$result['status'] = "OK";
			$result['mensagem'] = "Esse imposto já foi Conferido pelo usuário ".$rs_eve->pegar("usu_nome","usuarios","usu_cod={$rs1->fld("env_conferidouser")}");
			$result['linhas'] = $rs1->linhas;
		}
		else{
			$fn->Audit("impostos_enviados", $whr, $dados, $empresa, $_SESSION['usu_cod'],1);
			if(!$rs_eve->Altera($dados, "impostos_enviados", $whr)){
					$result['status'] = "OK";
					$result['mensagem'] = "Imposto ".$rs1->pegar("imp_nome","tipos_impostos","imp_id=$imposto")." marcado como NÃO gerado!";
					$result['linhas'] = $rs1->linhas;
			}
			else{
				$result['status'] = "NOK";
				$result['mensagem'] = "Ocorreu um erro!";
			}
		}	
			
	}
	else{
		$result['status'] = "NOK";
		$result['mensagem'] = "Solicite permissão ao Administrador para poder excluir um envio!";
	}
echo json_encode($result);
exit;
}

if($acao == "exclui_conferido"){
	$con = $per->getPermissao("excluienvio", $_SESSION['usu_cod']);
	if($con['E']==1){
		$dados['env_conferido']	= 0;
		$dados['env_conferidodata'] 	= date("Y-m-d H:i:s");
		$dados['env_conferidouser'] 	= $_SESSION['usu_cod'];
		$whr = "env_codEmp = {$empresa} AND env_codImp = {$imposto} AND env_compet = '{$compet}'";
		$rs1->Seleciona("env_mov, env_enviado, env_user","impostos_enviados",$whr);
		$rs1->GeraDados();
		if($rs1->fld("env_enviado")==1){
			$result['status'] = "OK";
			$result['mensagem'] = "Esse imposto já foi Enviado pelo usuário ".$rs_eve->pegar("usu_nome","usuarios","usu_cod={$rs1->fld("env_user")}");
			$result['linhas'] = $rs1->linhas;
		}
		else{
			$fn->Audit("impostos_enviados", $whr, $dados, $empresa, $_SESSION['usu_cod'],1);
			if(!$rs_eve->Altera($dados, "impostos_enviados", $whr)){
					$result['status'] = "OK";
					$result['mensagem'] = "Imposto ".$rs1->pegar("imp_nome","tipos_impostos","imp_id=$imposto")." marcado como NÃO conferido!";
					$result['linhas'] = $rs1->linhas;
			}
			else{
				$result['status'] = "NOK";
				$result['mensagem'] = "Ocorreu um erro!";
			}
		}
	}
	else{
		$result['status'] = "NOK";
		$result['mensagem'] = "Solicite permissão ao Administrador para poder excluir um envio!";
	}
echo json_encode($result);
exit;
}

if($acao == "exclui_envio"){
	$con = $per->getPermissao("excluienvio", $_SESSION['usu_cod']);
	if($con['E']==1){
		$dados['env_enviado']	= 0;
		$dados['env_confenv']	= 0;
		$dados['env_data'] 	= date("Y-m-d H:i:s");
		$dados['env_user'] 	= $_SESSION['usu_cod'];
		$whr = "env_codEmp = {$empresa} AND env_codImp = {$imposto} AND env_compet = '{$compet}'";
		$fn->Audit("impostos_enviados", $whr, $dados, $empresa, $_SESSION['usu_cod'],3);
		if(!$rs_eve->Altera($dados, "impostos_enviados", $whr)){
				$result['status'] = "OK";
				$result['mensagem'] = "Imposto ".$rs1->pegar("imp_nome","tipos_impostos","imp_id=$imposto")." marcado como NÃO Enviado!";
				$result['linhas'] = $rs1->linhas;
		}
		else{
			$result['status'] = "NOK";
			$result['mensagem'] = "Ocorreu um erro!";
		}
	}
	else{
		$result['status'] = "NOK";
		$result['mensagem'] = "Solicite permissão ao Administrador para poder excluir um envio!";
	}
echo json_encode($result);
exit;
}

if($acao == "exclui_part"){
	$whr = "part_id = ".$part_id;
	$dados["part_ativo"] = 0;
	$dados["part_id"] = $part_id;
	$part_clicod = $rs_eve->pegar("part_cod","particularidades",$whr);
	$fn->Audit("particularidades", $whr, $dados, $part_clicod, $_SESSION['usu_cod'],3);
	if(!$rs_eve->Altera($dados,"particularidades", $whr)){
		$result['status'] = "OK";
		$result['mensagem'] = "Particularidade {$part_id} excluída!";
	}
	else{
		$result['status'] = "NOK";
		$result['mensagem'] = "Ocorreu um erro!";
	}
echo json_encode($result);
exit;
}

if($acao == "inclui_matSol"){
	$cod = $rs_eve->autocod("mat_id","mat_historico");
	$dados['mat_id']		= $cod;
	$dados['mat_empcod']	= $_SESSION['usu_empcod'];
	$dados['mat_catId'] 	= $mat_categoria;
	$dados['mat_cadId'] 	= $mat_cadastro;
	$dados['mat_qtd'] 		= $mat_qtd;
	$dados['mat_operacao'] 	= $mat_opera;
	$dados['mat_obs'] 		= $mat_obs;
	$dados['mat_status'] 	= 0;
	$dados['mat_usuSol'] 	= $_SESSION['usu_cod'];
	$dados['mat_data'] 		= date("Y-m-d H:i:s");
	if(!$rs_eve->Insere($dados,"mat_historico")){
		$result['status'] = "OK";
		$result['mensagem'] = "Pedido {$cod} enviado para o respons&aacute;vel!";
	}
	else{
		$result['status'] = "NOK";
		$result['mensagem'] = "Ocorreu um erro!";
	}
echo json_encode($result);
exit;
}

if($acao == "pesq_mat"){
	$ni=$nd=$nt =0;
	$rs_eve->FreeSql("SELECT sum(mat_qtd) FROM mat_historico WHERE mat_cadId = {$codId} 
			AND mat_catId = {$catId} AND mat_operacao ='I' AND mat_status = 99");
	$rs_eve->GeraDados();
	$nd = ($rs_eve->linhas >0 ? $rs_eve->fld("sum(mat_qtd)"): $rs_eve->linhas);
	$rs_eve->FreeSql("SELECT sum(mat_qtd) FROM mat_historico WHERE mat_cadId = {$codId} 
			AND mat_catId = {$catId} AND mat_operacao ='O'");
	$rs_eve->GeraDados();
	$ni = ($rs_eve->linhas >0 ? $rs_eve->fld("sum(mat_qtd)"): $rs_eve->linhas);
	
	$nt = $nd-$ni;
	echo $nt;
	exit;
}

if($acao == "entregar_mat"){
	
	$dados['mat_status']= 99;
	$dados['mat_usuDisp'] = $_SESSION['usu_cod'];
	$dados['mat_entregue'] = date("Y-m-d H:i:s");
	
	if(!$rs_eve->Altera($dados,"mat_historico","mat_id=".$mat_id)){
		$resul['status']	= "OK";
		$resul['mensagem']	= "Material entregue!";
	}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs_eve->sql;
	}
	
	echo json_encode($resul);
    exit;
	
}

if($acao == "nega_mat"){
	
	$dados['mat_status']= 90;
	$dados['mat_usuDisp'] = $_SESSION['usu_cod'];
	
	if(!$rs_eve->Altera($dados,"mat_historico","mat_id=".$mat_id)){
		$resul['status']	= "OK";
		$resul['mensagem']	= "Pedido Cancelado!";
	}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs_eve->sql;
	}
	
	echo json_encode($resul);
    exit;
}

if($acao == "inclui_matCad"){
	$cod = $rs_eve->autocod("mcad_id","mat_cadastro");
	$dados['mcad_id']		= $cod;
	$dados['mcad_catId'] 	= $mat_categorias;
	$dados['mcad_desc'] 	= $mat_desc;
	$dados['mcad_minimo']	= $mat_qtd;
	$dados['mcad_compra']	= $mat_commin;
	$dados['mcad_ultpreco']	= str_replace(",", ".", $mat_preco);
	
	if(!$rs_eve->Insere($dados,"mat_Cadastro")){
		$result['status'] = "OK";
		$result['mensagem'] = "Material {$cod} cadastrado!";
	}
	else{
		$result['status'] = "NOK";
		$result['mensagem'] = "Ocorreu um erro!";
	}
echo json_encode($result);
exit;
}

if($acao == "alt_matCad"){
	$dados['mcad_catId'] 	= $mat_categorias;
	$dados['mcad_desc'] 	= $mat_desc;
	$dados['mcad_minimo']	= $mat_qtd;
	$dados['mcad_compra']	= $mat_commin;
	$dados['mcad_ultpreco']	= str_replace(",", ".", $mat_preco);
	$whr = "mcad_id=".$prod;
	if(!$rs_eve->Altera($dados,"mat_Cadastro",$whr)){
		$result['status'] = "OK";
		$result['mensagem'] = "Material {$prod} alterado!";
	}
	else{
		$result['status'] = "NOK";
		$result['mensagem'] = "Ocorreu um erro!";
	}
echo json_encode($result);
exit;
}

if($acao == "inclui_alerta"){
	$dados['mcad_alerta'] = $ativo;
	if(!$rs_eve->Altera($dados,"mat_cadastro","mcad_id=".$material)){
		$resul['status']	= "OK";
		$resul['mensagem']	= "Alerta Ativo para o produto {$material}!";
	}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs_eve->sql;
	}
	
	echo json_encode($resul);
    exit;
}

if($acao == "exclui_alerta"){
	$dados['mcad_alerta'] = $ativo;
	if(!$rs_eve->Altera($dados,"mat_cadastro","mcad_id=".$material)){
		$resul['status']	= "OK";
		$resul['mensagem']	= "Alerta inativo para o produto {$material}!";
	}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs_eve->sql;
	}
	
	echo json_encode($resul);
    exit;
}

if($acao == "exclui_arquivo"){
	$dados['cliarq_ativo'] = 0;
	if(!$rs_eve->Altera($dados,"clientes_arquivos","cliarq_id=".$arq_id)){
		$resul['status']	= "OK";
		$resul['mensagem']	= "O arquivo {$arq_id} foi desativado!";
	}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs_eve->sql;
	}
	echo json_encode($resul);
    exit;
}


if($acao == "gerar_lista"){
//Primeira parte: Incluir a lista na Tabela
	
	$dados2 = array();
	$cod = $rs_eve->autocod("mlist_id","mat_listas");
	$dados2['mlist_id']	= $cod;
	$dados2['mlist_solic'] = $_SESSION['usu_cod'] ;
	$dados2['mlist_data'] = date("Y-m-d H:i:s");
	$dados2['mlist_venc'] = $fn->data_usa($servn);
	$dados2['mlist_status'] = 0;
	$dados2['mlist_ativo'] = 1;
	
	$rs_eve->Insere($dados2,"mat_listas");
// Segunda Parte: Consultar os registros marcados na lista
		
	$sql = "SELECT * FROM alerta_compras a
				JOIN mat_cadastro b ON a.alerta_matId = b.mcad_id 
			WHERE alerta_matid IN(".$servs.")";
	$rs_eve->FreeSql($sql);
// Terceira parte: Incluir os registros achados na solicitação de compras
	$erro = 0;
	$prod = 0;
	while($rs_eve->GeraDados()){
		$cod2 = $rs1->autocod("mat_id","mat_historico");
		$dados['mat_id']		= $cod2;
		$dados['mat_empcod'] 	= $_SESSION['usu_empcod'];
		$dados['mat_catId'] 	= $rs_eve->fld("mcad_catid");
		$dados['mat_cadId'] 	= $rs_eve->fld("mcad_id");
		$dados['mat_operacao'] 	= "I";
		$dados['mat_data'] 		= date("Y-m-d H:i:s");
		$dados['mat_qtd'] 		= $rs_eve->fld("alerta_matqtdcp");
		$dados['mat_status'] 	= 0;
		$dados['mat_obs'] 		= "Lista de Compras n. ".$cod;
		$dados['mat_usuSol'] 	= $_SESSION['usu_cod'];
		$dados['mat_lista'] 	= $cod;
		if(!$rs1->Insere($dados,"mat_historico")){
			$prod+=1;
		}
		else{
			$erro+=1;
		}
	}

	if($erro==0){
		$resul['status'] = "OK";
		$resul['mensagem']= $prod." Produtos. LISTA OK!";
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

if($acao == "real_compmat"){
	$dados['mlist_status'] = 91;
	$dados['mlist_useralt'] = $_SESSION['usu_cod'];
	$dados['mlist_dataalt'] = date("Y-m-d H:i:s");
	if(!$rs_eve->Altera($dados, "mat_listas","mlist_id=".$mlist_id)){
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

if($acao == "exclui_Lista"){
	$dados['mlist_status'] = 90;
	$dados['mlist_useralt'] = $_SESSION['usu_cod'];
	$dados['mlist_dataalt'] = date("Y-m-d H:i:s");
	if(!$rs_eve->Altera($dados, "mat_listas","mlist_id=".$mlist_id)){
		
		// retirar os itens da lista cancelada
		$dados2 = array();
		$rs2 = new recordset();
		$rs2->Exclui("mat_historico", "mat_lista=".$mlist_id);
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

if($acao == "comp_lista"){
	$dados['mlist_status'] = 99;
	$dados['mlist_useralt'] = $_SESSION['usu_cod'];
	$dados['mlist_dataalt'] = date("Y-m-d H:i:s");
	if(!$rs_eve->Altera($dados, "mat_listas","mlist_id=".$mlist_id)){
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

if($acao == "exclui_listas"){
	$dados['mlist_status'] = 90;
	$dados['mlist_useralt'] = $_SESSION['usu_cod'];
	$dados['mlist_dataalt'] = date("Y-m-d H:i:s");
	if(!$rs_eve->Altera($dados, "mat_listas","mlist_id=".$mlist_id)){
		
		// retirar os itens da lista cancelada
		$rs2 = new recordset();
		$rs2->Exclui("mat_historico", "mat_lista=".$mlist_id);
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

if($acao == "exclui_doc"){
	//First of all, select the doc to be deleted and returns the file path
	$whr = "doc_cod = ".$doc_id;
	$sql = "SELECT * FROM documentos WHERE ".$whr;
	$rs_eve->FreeSql($sql);
	$rs_eve->GeraDados();
	$_arquivo = $rs_eve->fld("doc_ender");
	$d="Arquivo Apagado!";
	if(!$rs_eve->Exclui("documentos", $whr)){
		if(!file_exists($_arquivo)){
			if(!@unlink($_arquivo)){
				$d = "Arquivo não apagado!";			
			}
		}
		$result['status'] = "OK";
		$result['mensagem'] = "Documento {$doc_id} excluído! [{$d}]";
	}
	else{
		$result['status'] = "NOK";
		$result['mensagem'] = "Ocorreu um erro!";
	}
echo json_encode($result);
exit;
}

if($acao == "calc_docs"){
	$rs_eve->Seleciona("calc_preco","tipos_calc","calc_id = ".$doc_cod);
	$rs_eve->GeraDados();
	$n = ($rs_eve->linhas==0?0:$rs_eve->fld("calc_preco"));
	echo $n;
}

if($acao == "novo_calculo"){
	$cod = $rs_eve->autocod("calc_id","tipos_calc");
	$dados['calc_id']		= $cod;
	$dados['calc_desc'] 	= $calc_desc;
	
	 if (!$rs_eve->Insere($dados,"tipos_calc")) {
        $resul["status"] = "OK";
        $resul["mensagem"] = "Item {$cod} OK - Novo calculo cadastrado!";
        $resul["sql"] = $rs_eve->sql;
    } else {
		$resul["status"] = "ERRO";
        $resul["mensagem"] = "Falha na inclus&atilde;o";
        $resul["sql"] = $rs_eve->sql;
    }
	echo json_encode($resul);
    exit;
}

if($acao == "inclui_recalculo"){
	$cod = $rs_eve->autocod("rec_id","recalculos");
	$dados['rec_id']		= $cod;
	$dados['rec_data'] 		= date("Y-m-d H:i:s");
	$dados['rec_doc'] 		= $calc_doc;
	$dados['rec_user']		= $_SESSION['usu_cod'];
	$dados['rec_cli']		= $calc_empresa;
	$dados['rec_compet']	= $calc_comp;
	$dados['rec_emp']		= $_SESSION['usu_empcod'];
	$dados['rec_qtd']		= $calc_qtd;
	$dados['rec_val']		= str_replace(",", ".", $calc_valor);
	$dados['rec_obs']		= $calc_obs;
	$dados['rec_status']	= 87;
	
	 if (!$rs_eve->Insere($dados,"recalculos")) {
        $resul["status"] = "OK";
        $resul["mensagem"] = "Item {$cod} OK - Novo calculo cadastrado!";
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
/*--------------|PERMISSOES INDIVIDUAIS E GRUPOS DE ACESSO|--------------------*\
| @Author: 	Ademir Leonel, Cleber Marrara, Elvis Leite 							|
| @Version: 1.0 																|
| @Date:	28/03/2017 															|
| @Description: Allows a user to have a permission regardless the group he is in|
\*-----------------------------------------------------------------------------*/

if($acao == "inclui_perm"){
	$tabela = "permissoes";
	$whr = "pem_pag = '".$pagina."'";
	if(isset($func) AND !empty($func) ){
		$tabela.="_indiv";
		$whr .=" AND pem_user=".$func;
		//pesquisa para ver se á registro
		$pm = $rs1->pegar("pem_permissoes", $tabela, $whr);
		if($pm==""){
			//caso não ache permissoes, volta as variaveis para pegar as permissoes do grupo
			$tabela = "permissoes";
			$whr = "pem_pag = '".$pagina."'";
		}

	}
	$rs_eve->Seleciona("pem_desc, pem_permissoes", $tabela, $whr);
	$rs_eve->GeraDados();
	$arr = array();
	$arr = json_decode($rs_eve->fld("pem_permissoes"), true);
	$arr[$classe][$tipo]=1;
	$dados['pem_permissoes'] = addslashes(json_encode($arr));
	if(isset($func) AND !empty($func) ){
		$dados["pem_user"] 	= $func;
		$rs_eve->Seleciona("pem_id","permissoes_indiv","pem_pag='".$pagina."' AND pem_user=".$func);
		if($rs_eve->linhas==1){
			if(!$rs1->Altera($dados,"permissoes_indiv","pem_pag='".$pagina."' AND pem_user=".$func)){
				$resul["mensagem"] = "Permissão {$tipo} da página para a classe {$classe} alterada para 1 - Permitido";
			}
			else{
				$resul["mensagem"] = "Ocorreu um erro";
			}
		}
		else{
			//$dados["pem_id"] 	= $permissao;
			$dados["pem_pag"] 	= $pagina;
			if(!$rs1->Insere($dados,"permissoes_indiv")){
				$resul["mensagem"] = "Permissão {$tipo} da página para a classe {$classe} alterada para 1 - Permitido";	
				$resul["sql"]= $rs1->sql;
			}
			else{
				$resul["mensagem"] = "Ocorreu um erro";	
				$resul["sql"]= $rs1->sql;
			}
		}
	}
	else{
		if(!$rs_eve->Altera($dados,"permissoes","pem_id=".$permissao)){
			$resul["mensagem"] = "Permissão {$tipo} da página {$rs_eve->fld("pem_desc")} para a classe {$classe} alterada para 1 - Permitido";
			$resul["sql"]= $rs_eve->sql;
		}
		else{
			$resul["mensagem"] = "Ocorreu um erro";
			$resul["sql"]= $rs_eve->sql;
		}
	}

	
	echo json_encode($resul);
    exit;

}

if($acao == "exclui_perm"){
	$tabela = "permissoes";
	$whr = "pem_pag = '".$pagina."'";
	if(isset($func) AND !empty($func) ){
		$tabela.="_indiv";
		$whr .=" AND pem_user=".$func;
		//pesquisa para ver se á registro
		$pm = $rs1->pegar("pem_permissoes", $tabela, $whr);
		if($pm==""){
			//caso não ache permissoes, volta as variaveis para pegar as permissoes do grupo
			$tabela = "permissoes";
			$whr = "pem_pag = '".$pagina."'";
		}

	}
	$rs_eve->Seleciona("pem_desc, pem_permissoes", $tabela, $whr);
	$rs_eve->GeraDados();
	$arr = array();
	$arr = json_decode($rs_eve->fld("pem_permissoes"), true);
	$arr[$classe][$tipo]=0;
	$dados['pem_permissoes'] = addslashes(json_encode($arr));
	if(isset($func) AND !empty($func) ){
		$dados["pem_user"] 	= $func;
		$rs_eve->Seleciona("pem_id","permissoes_indiv","pem_pag='".$pagina."' AND pem_user=".$func);
		if($rs_eve->linhas==1){
			if(!$rs1->Altera($dados,"permissoes_indiv","pem_pag='".$pagina."' AND pem_user=".$func)){
				$resul["mensagem"] = "Permissão {$tipo} da página para a classe {$classe} alterada para 0 - Negado";
			}
			else{
				$resul["mensagem"] = "Ocorreu um erro";
			}
		}
		else{
			//$dados["pem_id"] 	= $permissao;
			$dados["pem_pag"] 	= $pagina;
			if(!$rs1->Insere($dados,"permissoes_indiv")){
				$resul["mensagem"] = "Permissão {$tipo} da página para a classe {$classe} alterada para 0 - Negado";	
				$resul["sql"]= $rs1->sql;
			}
			else{
				$resul["mensagem"] = "Ocorreu um erro";	
				$resul["sql"]= $rs1->sql;
			}
		}
	}
	else{
		if(!$rs_eve->Altera($dados,"permissoes","pem_id=".$permissao)){
			$resul["mensagem"] = "Permissão {$tipo} da página {$rs_eve->fld("pem_desc")} para a classe {$classe} alterada para 0 - Negado";
			$resul["sql"]= $rs_eve->sql;
		}
		else{
			$resul["mensagem"] = "Ocorreu um erro";
			$resul["sql"]= $rs_eve->sql;
		}
	}

	echo json_encode($resul);
    exit;
}

if($acao == "exclui_evecal"){
	if(!$rs_eve->Exclui("calendario","cal_id=".$evecal)){
		$resul['status'] = "OK";
		$resul['mensagem']="Evento {$evecal} excluído!";
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

if($acao=="save_calc"){
	$dados['rec_status'] = 99;
	$dados['rec_usuSol'] = $_SESSION['usu_cod'];
	$whr = "rec_id=".$rec_id;
	if(!$rs_eve->Altera($dados,"recalculos",$whr)){
		$resul["status"] = "OK";
		$resul["mensagem"] = "Cálculo {$rec_id} realizado";
	}
	else{
		$resul["status"] = "NOK";
		$resul["mensagem"] = "Ocorreu um erro em ". $rs_eve->sql;	
	}
	echo json_encode($resul);
    exit;	
}

if($acao=="canc_calc"){
	$dados['rec_status'] = 90;
	$dados['rec_usuSol'] = $_SESSION['usu_cod'];
	$whr = "rec_id=".$rec_id;
	if(!$rs_eve->Altera($dados,"recalculos",$whr)){
		$resul["status"] = "OK";
		$resul["mensagem"] = "Cálculo {$rec_id} cancelado";
	}
	else{
		$resul["status"] = "NOK";
		$resul["mensagem"] = "Ocorreu um erro em ". $rs_eve->sql;	
	}
	echo json_encode($resul);
    exit;	
}

if($acao=="fat_recalc"){
	$dados['rec_status'] = 93;
	$dados['rec_usuSol'] = $_SESSION['usu_cod'];
	$whr = "rec_id=".$rec_id;
	if(!$rs_eve->Altera($dados,"recalculos",$whr)){
		$resul["status"] = "OK";
		$resul["mensagem"] = "Cálculo {$rec_id} faturado";
	}
	else{
		$resul["status"] = "NOK";
		$resul["mensagem"] = "Ocorreu um erro em ". $rs_eve->sql;	
	}
	echo json_encode($resul);
    exit;	
}

if($acao == "imp_empresas"){
	$cond = '"user":"'.$us_cart.'"';
	$sql = "SELECT * FROM tri_clientes WHERE carteira LIKE '%{$cond}%' ";
	$rs_eve->FreeSql($sql);
	$html = "<option value=''>Selecione:</option>";
	while($rs_eve->GeraDados()){
		$html .= "<option value='".$rs_eve->fld("cod")."'>".$rs_eve->fld("cod")." - ".$rs_eve->fld("apelido")."</option>";
	}
	echo $html;
	exit;
}

if($acao == "imp_impostos"){
	$sql = "SELECT * FROM tipos_impostos b
				JOIN  obrigacoes a ON a.ob_titulo = b.imp_id 
				WHERE ob_cod = {$em_cod} AND ob_depto = {$em_dep}";
	
	$rs_eve->FreeSql($sql);
	$html = "<option value=''>Selecione:</option>";
	while($rs_eve->GeraDados()){
		$html .= "<option value='".$rs_eve->fld("imp_id")."'>".$rs_eve->fld("imp_nome")."</option>";
	}
	echo $html;
	exit;
}

if($acao == "inclui_homologacao"){
	$docshom = explode(",", $hom_chk); 
	$cod = $rs_eve->autocod("hom_id","homologacoes");
	$dados['hom_id']		= $cod;
	$dados['hom_empvinculo']= $_SESSION['usu_empcod'];
	$dados['hom_data']		= date("Y-m-d H:i:s");
	$dados['hom_datahom']	= $fn->data_usa($hom_datahom);
	//$dados['hom_docs']	= $hom_chk;
	$dados['hom_empresa']	= $hom_emp;
	$dados['hom_empregado']	= $hom_nome;
	$dados['hom_inden']		= $hom_inden;
	$dados['hom_local']		= $hom_local;
	$dados['hom_horario']	= $hom_horario;
	$dados['hom_valor']		= str_replace(",", ".", $hom_valor);
	$dados['hom_status']	= 0;
	$dados['hom_cadpor']	= $_SESSION['usu_cod'];
	
	if(!$rs_eve->Insere($dados, "homologacoes")){
		$x = 0;
		foreach ($docshom as $value) {
			$dados2['homchk_homId'] = $cod;
			$dados2['homchk_ativo'] = 0;
			$dados2['homchk_item'] = $value;
			$rs2->Insere($dados2, "homologa_check");
			$x+=1;
		}
		// Insere no Calendário
		
		$resul['status']	= "OK";
		$resul['mensagem']	= "Homologação cadastrada com sucesso! \n".$x." documentos adicionados para CheckList";
		$dados2 = array();
	}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs->sql;
	}
	echo json_encode($resul);
    exit;
}

if($acao == "conf_doc"){
	$sql = "SELECT * FROM homologa_check WHERE homchk_homId='".$homol."' AND homchk_id=".$doc;
	$rs1->FreeSql($sql);
	if($rs1->linhas>0){
		$rs1->GeraDados();
		//$codImp = $rs1->fld("env_id");
		$dados['homchk_ativo'] =	$ativo;
		$dados['homchk_dtsep'] =	date("Y-m-d H:i:s");
		$dados['homchk_seppor'] =	$_SESSION['usu_cod'];
		$whr = "homchk_homId='".$homol."' AND homchk_id=".$doc;
		$fn->Audit("homologa_check", $whr, $dados, $empresa, $_SESSION['usu_cod'],6);
		if(!$rs_eve->Altera($dados,"homologa_check",$whr)){
			$result['status'] = "OK";
			$result['mensagem'] = "Documento ".$rs1->pegar("chk_item","checklists","chk_id=$doc")." marcado como CONFERIDO para homologação {$homol}!";
		}
		else{
			$result['status'] = "NOK";
			$result['mensagem'] = "Ocorreu um erro!";
		}
	}
	else{
		$result['status'] = "NOK";
		$result['mensagem'] = "Nada alterado";
	}
	
echo json_encode($result);
exit;
}

if($acao == "salva_homolog"){
	$dados['hom_status']	= 92 ;
	$dados['hom_realdata']	= date("Y-m-d H:i:s") ;
	$dados['hom_realpor']	= $_SESSION['usu_cod'] ;
	
	$whr = "hom_id = ".$hom_id;
	
	if(!$rs_eve->Altera($dados, "homologacoes",$whr)){
		$resul['status']	= "OK";
		$resul['mensagem']	= "Homologação salva!";
		$resul['sql']		= $rs_eve->sql;
		// INSERINDO OBSERVAÇÂO
		if(!empty($hom_obs)){
			$rs2 = new recordset();
			$dados2 = array();
			$dados2['homobs_homId'] = $hom_id;
			$dados2['homobs_obs'] 	= addslashes($hom_obs);
			$dados2['homobs_user']	= $_SESSION['usu_cod'];
			$dados2['homobs_data']= date("Y-m-d H:i:s");
			$rs2->Insere($dados2,"homologa_obs");
			// PREPARA MENSAGEM VIA CHAT
		}

	}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs_eve->sql;
	}
	echo json_encode($resul);
    exit;
}

if($acao == "encerra_homolog"){
	$dados['hom_status']	= 94;	
	$dados['hom_realdata']	= date("Y-m-d H:i:s") ;
	$dados['hom_realpor']	= $_SESSION['usu_cod'] ;
	$whr = "hom_id = ".$hom_id;
	
	if(!$rs_eve->Altera($dados, "homologacoes",$whr)){
		$resul['status']	= "OK";
		$resul['mensagem']	= "Homologação salva!";
		$resul['sql']		= $rs_eve->sql;
	}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs_eve->sql;
	}
	echo json_encode($resul);
    exit;
}

if($acao == "cli_Cadarquivo"){
	foreach ($arq_titulo as $value) {
		$cod = $rs_eve->autocod("cliarq_id","clientes_arquivos");
		$dados['cliarq_id']			= $cod;
		$dados['cliarq_empresa'] 	= $arq_clicod;
		$dados['cliarq_venc'] 		= $arq_venc;
		$dados['cliarq_arqId'] 		= addslashes($value);
		$dados['cliarq_ativo']		= $arq_ativo;
		$dados['cliarq_detalhes']	= $arq_detalhes;
		$fn->Audit("clientes_arquivos", "cliarq_id=".$cod, $dados, $arq_clicod, $_SESSION['usu_cod'],2);
		
		if(!$rs_eve->Insere($dados,"clientes_arquivos")){
			$resul['status']	= "OK";
			$resul['mensagem']	= "Arquivo Cadastrado";
			$resul['sql']		= $rs_eve->sql;
		}
		else{
			$resul['mensagem']	= "Ocorreu um erro...";
			$resul['sql']		= $rs_eve->sql;
		}
	}
	echo json_encode($resul);
    exit;
}

if($acao == "cli_Altarquivo"){
	foreach ($arq_titulo as $value) {
		$dados['cliarq_empresa'] 	= $arq_clicod;
		$dados['cliarq_venc'] 		= $arq_venc;
		$dados['cliarq_arqId'] 		= addslashes($value);
		$dados['cliarq_ativo']		= $arq_ativo;
		$dados['cliarq_detalhes']	= $arq_detalhes;
		$whr = "cliarq_id =".$arq_id;
		$fn->Audit("clientes_arquivos", $whr, $dados, $arq_clicod, $_SESSION['usu_cod'],1);
		if(!$rs_eve->Altera($dados,"clientes_arquivos",$whr)){
			$resul['status']	= "OK";
			$resul['mensagem']	= "Arquivo Cadastrado";
			$resul['sql']		= $rs_eve->sql;
		}
		else{
			$resul['mensagem']	= "Ocorreu um erro...";
			$resul['sql']		= $rs_eve->sql;
		}
	}
	echo json_encode($resul);
    exit;
}

if($acao == "exclui_homol"){
	$dados['hom_status'] = 90;
	$dados['hom_realpor'] = $_SESSION['usu_cod'];
	$dados['hom_realdata'] = date("Y-m-d H:i:s");
	if(!$rs_eve->Altera($dados, "homologacoes","hom_id=".$hom_cod)){
		$resul['status']	= "OK";
		$resul['mensagem']	= "Homologação Excluída!";
		}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs->sql;
	}	
	echo json_encode($resul);
    exit;	
}

if($acao == "ok_homol"){
	$dados['hom_status'] = 99;
	$dados['hom_realpor'] = $_SESSION['usu_cod'];
	$dados['hom_realdata'] = date("Y-m-d H:i:s");
	if(!$rs_eve->Altera($dados, "homologacoes","hom_id=".$hom_cod)){
		$resul['status']	= "OK";
		$resul['mensagem']	= "Homologação OK!";
		}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs->sql;
	}	
	echo json_encode($resul);
    exit;	
}


if($acao == "exclui_dochomol"){
	if(!$rs_eve->Exclui("homologa_check","homchk_id=".$doc_id)){
		$resul['status']	= "OK";
		$resul['mensagem']	= "Documento Excluído!";
		}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs->sql;
	}	
	echo json_encode($resul);
    exit;	
}

if($acao == "inclui_implantacao"){
	$docsimp = explode(",", $imp_chk); 
	$cod = $rs_eve->autocod("impla_id","implantacoes");
	$dados['impla_id']		= $cod;
	$dados['impla_vinc']	= $_SESSION['usu_empcod'];
	$dados['impla_data']	= date("Y-m-d H:i:s");
	$dados['impla_valor'] 	= str_replace(",", ".", $imp_valor);
	$dados['impla_dataimp']	= $fn->data_usa($imp_data);
	$dados['impla_obs']		= $imp_obs;
	$dados['impla_empresa']	= $imp_emp;
	$dados['impla_status']	= 0;
	$dados['impla_cadpor']	= $_SESSION['usu_cod'];
	
	if(!$rs_eve->Insere($dados, "implantacoes")){
		$x = 0;
		foreach ($docsimp as $value) {
			$dados2['impchk_impId'] = $cod;
			$dados2['impchk_ativo'] = 0;
			$dados2['impchk_item'] = $value;
			$rs2->Insere($dados2, "implanta_check");
			$x+=1;
		}
		// Insere no Calendário
		
		$resul['status']	= "OK";
		$resul['mensagem']	= "Implantação cadastrada com sucesso! \n".$x." documentos adicionados para CheckList";
		$dados2 = array();
	}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs->sql;
	}
	echo json_encode($resul);
    exit;
}

if($acao == "conf_impla"){
	$sql = "SELECT * FROM implanta_check WHERE impchk_impId='".$impla."' AND impchk_item=".$doc;
	$rs1->FreeSql($sql);
	if($rs1->linhas>0){
		$rs1->GeraDados();
		//$codImp = $rs1->fld("env_id");
		$dados['impchk_ativo'] =	$ativo;
		$dados['impchk_dtsep'] =	date("Y-m-d H:i:s");
		$dados['impchk_seppor'] =	$_SESSION['usu_cod'];
		$whr = "impchk_impId='".$impla."' AND impchk_item=".$doc;
		$fn->Audit("implanta_check", $whr, $dados, $empresa, $_SESSION['usu_cod'],6);
		if(!$rs_eve->Altera($dados,"implanta_check",$whr)){
			$result['status'] = "OK";
			$result['mensagem'] = "Documento ".$rs1->pegar("chk_item","checklists","chk_id=$doc")." marcado como CONFERIDO para Implantação {$impla}!";
		}
		else{
			$result['status'] = "NOK";
			$result['mensagem'] = "Ocorreu um erro!";
		}
	}
	else{
		$result['status'] = "NOK";
		$result['mensagem'] = "Nada alterado";
	}
	
echo json_encode($result);
exit;
}

if($acao == "salva_impla"){
	$dados['impla_status']	= 92 ;
	$dados['impla_dtreal']	= date("Y-m-d H:i:s") ;
	$dados['impla_realpor']	= $_SESSION['usu_cod'] ;
	
	$whr = "impla_id = ".$impla_id;
	
	if(!$rs_eve->Altera($dados, "implantacoes",$whr)){
		$resul['status']	= "OK";
		$resul['mensagem']	= "Implantação salva!";
		$resul['sql']		= $rs_eve->sql;
		// INSERINDO OBSERVAÇÂO
		if(!empty($impla_obs)){
			$rs2 = new recordset();
			$dados2 = array();
			$dados2['impobs_impId'] = $impla_id;
			$dados2['impobs_obs'] 	= addslashes($impla_obs);
			$dados2['impobs_user']	= $_SESSION['usu_cod'];
			$dados2['impobs_data']= date("Y-m-d H:i:s");
			$rs2->Insere($dados2,"implanta_obs");
			// PREPARA MENSAGEM VIA CHAT
		}

	}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs_eve->sql;
	}
	echo json_encode($resul);
    exit;
}

if($acao == "exclui_docimpla"){
	if(!$rs_eve->Exclui("implanta_check","impchk_id=".$doc_id)){
		$resul['status']	= "OK";
		$resul['mensagem']	= "Documento Excluído!";
		}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs->sql;
	}	
	echo json_encode($resul);
    exit;	
}

if($acao == "encerra_impla"){
	$dados['impla_status']	= 94;	
	$dados['impla_dtreal']	= date("Y-m-d H:i:s") ;
	$dados['impla_realpor']	= $_SESSION['usu_cod'] ;
	$whr = "impla_id = ".$impla_id;
	
	if(!$rs_eve->Altera($dados, "implantacoes",$whr)){
		$resul['status']	= "OK";
		$resul['mensagem']	= "Implantação salva!";
		$resul['sql']		= $rs_eve->sql;
	}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs_eve->sql;
	}
	echo json_encode($resul);
    exit;
}

if($acao == "ok_impla"){
	$dados['impla_status'] = 99;
	$dados['impla_realpor'] = $_SESSION['usu_cod'];
	$dados['impla_dtreal'] = date("Y-m-d H:i:s");
	if(!$rs_eve->Altera($dados, "implantacoes","impla_id=".$imp_cod)){
		$resul['status']	= "OK";
		$resul['mensagem']	= "Implantação OK!";
		}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs->sql;
	}	
	echo json_encode($resul);
    exit;	
}

if($acao == "exclui_impla"){
	$dados['impla_status'] = 90;
	$dados['impla_realpor'] = $_SESSION['usu_cod'];
	$dados['impla_dtreal'] = date("Y-m-d H:i:s");
	if(!$rs_eve->Altera($dados, "implantacoes","impla_id=".$imp_cod)){
		$resul['status']	= "OK";
		$resul['mensagem']	= "Implantação Excluída!";
		}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs->sql;
	}	
	echo json_encode($resul);
    exit;
}

if($acao == "add_checkitem"){
	$resps = explode(",", $quest);
	$rsp = array();
	$i=0;
	$rs1->Seleciona("task_id","tarefas","task_tipo='VER'");
	while($rs1->GeraDados()){
		$rsp[] = array($rs1->fld("task_id")=>$resps[$i]);
		$i++;
	}
	
	$dados['lver_listaId']		= $lista;
	$dados['lver_maquina']		= $maquina;
	$dados['lver_respostas']	= json_encode($rsp);
	$dados['lver_obs']	 		= addslashes($obs);
	$dados['lver_feitopor']		= $_SESSION['usu_cod'];

	if(!$rs_eve->Insere($dados, "listados")){
		$resul['status']	= "OK";
		$resul['mensagem']	= "Maquina adicionada!";
		$dados2 = array();
	}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs_eve->sql;
	}
	echo json_encode($resul);
    exit;
}
if($acao == "novo_listaver"){
	$cod = $rs_eve->autocod("lista_id","lista_verificacao");
	$dados['lista_id']		= $cod;
	$dados['lista_empresa']	= $lista_empresa;
	$dados['lista_empvinc']	= $_SESSION["sys_id"];
	$dados['lista_data']	= $fn->data_usa($lista_data);
	$dados['lista_compet']	= $lista_compet;
	$dados['lista_user']	= $lista_usuario;
	$dados['lista_datacad']	= date("Y-m-d H:i:s");

	if(!$rs_eve->Insere($dados, "lista_verificacao")){
		$resul['status']	= "OK";
		$resul['mensagem']	= "Lista de Verificação criada!";
		$dados2 = array();
	}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs->sql;
	}
	echo json_encode($resul);
    exit;
	
}
if($acao == "inclui_metatask"){
	$resul['status']="";
	$resul['mensagem']="";
	foreach ($lismetas_obrig as $impv) {
		foreach ($lismetas_compet as $compv) {
			$sql = "SELECT a.tarmetas_metasId as LISTA, 
					(c.env_enviado+c.env_gerado+c.env_conferido) AS TOTAL,
					b.metas_datafin as DF,
					d.imp_nome as IMPOSTO
				FROM tarmetas a
					LEFT JOIN metas b ON b.metas_id = a.tarmetas_metasId
					JOIN impostos_enviados c ON c.env_codImp = a.tarmetas_obri
					JOIN tipos_impostos d ON d.imp_id = a.tarmetas_obri
				WHERE 1
					AND tarmetas_emp = ".$lismetas_emp	."
					AND tarmetas_comp = '".$compv."'
					AND tarmetas_obri = ".$impv."
					AND c.env_compet = '".$compv."'
					AND c.env_codEmp= ".$lismetas_emp	."
				ORDER BY b.metas_id DESC";
			
			$rs1->FreeSql($sql);
			$lista_ex = 0;
			$status = 0;
			$final = 0;
			if($rs1->linhas>0){
				$rs1->GeraDados();
				$lista_ex 	= $rs1->fld("LISTA");
				$status 	= $rs1->fld("TOTAL");
				$final 		= $rs1->fld("DF");
			}
			$imposto 	= $rs1->fld("IMPOSTO");
			// INCLUI SEM AVISO
			if($lista_ex==0 || ($final < date("Y-m-d") AND $status < 3)){
					$cod = $rs_eve->autocod("tarmetas_id","tarmetas");
					$dados['tarmetas_id']		= $cod;
					$dados['tarmetas_metasId'] 	= $lismetas_lista;
					$dados['tarmetas_emp']		= $lismetas_emp;
					$dados['tarmetas_comp']		= $compv;
					$dados['tarmetas_obri']		= $impv;
					if(!$rs_eve->Insere($dados,"tarmetas") ){
						$resul['status']	= "OK";
						if($lista_ex==0){
							$resul['mensagem']	.= "<br>Obrigação: {$imposto} - Meta cadastrada";
						}
						else{
							$resul['mensagem']	.= "<br>Obrigação: {$imposto} - Meta não finalizada na lista {$lista_ex} cadastrada ";
						}
					}
					else{
						$resul['mensagem']	= "Ocorreu um erro...";
						$resul['sql']		= $rs->sql;
					}	
				}
			// NÃO INCLUI
			else{
				$resul['status']	= "NOK";
				if( $final > date("Y-m-d") ){
					$resul['mensagem']	.= "<br>Não é permitida a inclusão de tarefas para listas vencidas!";
				}				
				else{
					$resul['mensagem']	.= "<br>Obrigação: {$imposto} - Meta existe na lista $lista_ex ou já foi concluída!";
				}
				//$resul['sql']		= $rs->sql;
			}
		}
	}
	echo json_encode($resul);
	exit;
}

if($acao == "oc_metas"){
	if(strlen($metasobs_obs)<10) {
		$resul['mensagem']	= "Observação deve conter no mínimo 10 Caracteres!";
	}
	else{
		$cod = $rs_eve->autocod("metasobs_id","metas_ocorrencias");
		$dados['metasobs_id']		= $cod;
		$dados['metasobs_tarId']	= $metasobs_tarId;
		$dados['metasobs_data']		= date("Y-m-d H:i:s");
		$dados['metasobs_por']		= $_SESSION['usu_cod'];
		$dados['metasobs_obs']		= $metasobs_obs;

		if(!$rs_eve->Insere($dados, "metas_ocorrencias")){
			$resul['status']	= "OK";
			$resul['mensagem']	= "Ocorrencia OK!";
			$dados2 = array();
		}
		else{
			$resul['mensagem']	= "Ocorreu um erro...";
			$resul['sql']		= $rs->sql;
		}
	}
	echo json_encode($resul);
    exit;	
}

if($acao == "exclui_metaLista"){
	if(!$rs_eve->Exclui("tarmetas","tarmetas_id=".$tarmetas_id)){
		$resul['status']	= "OK";
		$resul['mensagem']	= "Meta {$tarmetas_id} excluída!";
		}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs->sql;
	}	
	echo json_encode($resul);
    exit;
}
if($acao == "custom_count"){
	$dados['usu_contagens'] = addslashes($conts);
	$whr = "usu_cod = ".$_SESSION['usu_cod'];
	if(!$rs_eve->Altera($dados, "usuarios",$whr)){
		$resul['status']="OK";
		$resul['mensagem']="Contagens alteradas";
		$resul['sql']=$rs_eve->sql;
	}
	echo json_encode($resul);
    exit;
}