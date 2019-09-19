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
$result = array();
extract($_POST);

if($acao == "nova_maquina"){
	$cod = $rs_eve->autocod("maq_id","maquinas");
	$dados = array();
	$dados['maq_id']		= $cod;
	$dados['maq_ip']		= $maq_ip;
	$dados['maq_usuario']	= $maq_usuario;
	$dados['maq_user']		= $maq_user;
	$dados['maq_sistema']	= $maq_sistema;
	$dados['maq_memoria']	= $maq_memoria;
	$dados['maq_hd']		= $maq_hd;
	$dados['maq_tipo']		= $maq_tipo;
	$dados['maq_ativa']		= 1;

	if (!$rs_eve->Insere($dados,"maquinas")) {
        $resul["status"] = "OK";
        $resul["mensagem"] = "NovMaquina adicionada no parque!";
        $resul["sql"] = $rs_eve->sql;
    } else {
        //$hist->add_hist(11);
		$resul["status"] = "ERRO";
        $resul["mensagem"] = "Falha na inclus&atilde;o";
        $resul["sql"] = $rs_eve->sql;
    }
	echo json_encode($resul);
    exit;	
}

if($acao == "altera_maquina"){
	$dados = array();
	$dados['maq_usuario']	= $maq_usuario;
	$dados['maq_user']		= $maq_user;
	$dados['maq_sistema']	= $maq_sistema;
	$dados['maq_memoria']	= $maq_memoria;
	$dados['maq_hd']		= $maq_hd;
	$dados['maq_ativa']		= 1;
	$whr = "maq_ip = '".$maq_ip."'";
	if (!$rs_eve->Altera($dados,"maquinas", $whr)) {
        $resul["status"] = "OK";
        $resul["mensagem"] = "Maquina alterada!";
        $resul["sql"] = $rs_eve->sql;
    } else {
        //$hist->add_hist(11);
		$resul["status"] = "ERRO";
        $resul["mensagem"] = "Falha na inclus&atilde;o";
        $resul["sql"] = $rs_eve->sql;
    }
	echo json_encode($resul);
    exit;	
}

if($acao == "novo_perif"){
$cod = $rs_eve->autocod("per_id","perifericos");
	$dados = array();
	$dados['per_id']		= $cod;
	$dados['per_maqid']		= $per_maqid;
	$dados['per_tipo']		= $per_tipo;
	$dados['per_modelo']	= $per_modelo;
	$dados['per_status']	= $per_status;
	$dados['per_ativo']		= $per_ativo;
	$dados['per_datacad']	= date("Y-m-d H:i:s");
	$dados['per_usucad']	= $_SESSION['usu_cod'];

	if (!$rs_eve->Insere($dados,"perifericos")) {
        $resul["status"] = "OK";
        $resul["mensagem"] = "Novo Periférico adicionado!";
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

if($acao == "altera_perif"){
	$dados = array();
	$dados['per_maqid']		= $per_maqid;
	$dados['per_tipo']		= $per_tipo;
	$dados['per_modelo']	= $per_modelo;
	$dados['per_status']	= $per_status;
	$dados['per_ativo']		= $per_ativo;
	$dados['per_datacad']	= date("Y-m-d H:i:s");
	$dados['per_usucad']	= $_SESSION['usu_cod'];
	$whr = "per_id=".$per_id;
	if (!$rs_eve->Altera($dados,"perifericos",$whr)) {
        $resul["status"] = "OK";
        $resul["mensagem"] = "Periférico atualizado!";
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

/*---------------|FUNCAO PARA CADASTRAR A FABRICANTE|--------------\
	|	Author: 	Elvis Leite							    		| 
	|	E-mail: 	elvis7t@gmail.com								|
	|	Version:	1.0												|
	|	Date:       31/10/2016						   				|
	\--------------------------------------------------------------*/

if($acao == "cadFabricante"){
	
	$dados["fab_nome"]	= $fab_nome;
		
		if(!$rs_eve->Insere($dados,"fabricantes")){
				$resul['status']	= "OK";
				$resul['mensagem']	= "Fabricante ok!";
	}
	else{
		$resul['mensagem']	= "Ocorreu um erro...";
		$resul['sql']		= $rs->sql;
	}	

	
	echo json_encode($resul);
    exit;
	
}
/*---------------|FIM DO CADASTRO FABRICANTE |------------------*/	

/*---------------|FUNCAO PARA ALTERAR O FABRICANTE|--------------\
	|	Author: 	Elvis Leite							    		| 
	|	E-mail: 	elvis7t@gmail.com								|
	|	Version:	1.0												|
	|	Date:       31/10/2016						   				|
	\--------------------------------------------------------------*/

if($acao == "Altera_fab"){
	
	$dados = array();
	
	$dados['fab_nome']		= $fab_nome;
	
	$whr = "fab_id=".$fab_id;

	if (!$rs_eve->Altera($dados,"fabricantes",$whr)) {
        $resul["status"] = "OK";
        $resul["mensagem"] = "Fabricante atualizado!";
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
/*---------------|FIM DO ALTERA FABRICANTE |------------------*/	

/*---------------|FUNCAO PARA EXCLUIR O FABRICANTE|--------------\
	|	Author: 	Elvis Leite							    		| 
	|	E-mail: 	elvis7t@gmail.com								|
	|	Version:	1.0												|
	|	Date:       31/10/2016						   				|
	\--------------------------------------------------------------*/

if($acao == "exclui_fab"){
	
	if(!$rs_eve->Exclui("fabricantes","fab_id=".$fab_id)){
		
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
/*---------------|FIM DO CADASTRO FABRICANTE |------------------*/	