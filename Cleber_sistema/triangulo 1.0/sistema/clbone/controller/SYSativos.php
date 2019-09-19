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
	|	Date:       18/11/2016						   				|
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