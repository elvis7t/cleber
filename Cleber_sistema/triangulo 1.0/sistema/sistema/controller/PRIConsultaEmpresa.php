<?
session_start();
require_once("../class/class.empresas.php");
require_once("../class/class.historico.php");
$rs_empresas = new empresas();
$hist = new historico();
$result = array();
extract($_POST);
if($acao == "consulta"){
	if((!empty($emp_cnpj)) AND (!empty($emp_nfts))){
		$sql = "SELECT * FROM empresas WHERE emp_cnpj = '".$emp_cnpj."' OR emp_nome like '%".$emp_nfts."%'";
	}
	else{
		if(!empty($emp_cnpj)){
			$sql = "SELECT * FROM empresas WHERE emp_cnpj = '".$emp_cnpj."'";
		} else {
			$sql = "SELECT * FROM empresas WHERE emp_nome like '%".$emp_nfts."%'";
		}
	}
	$rs_empresas->FreeSQL($sql);
	$tbl="";
	if($rs_empresas->linhas == 0){
		$result['status'] = 0;
		$result['query'] = $sql;
	}
	else {
		/* Insere o evento na linha do tempo*/
		$hist->add_hist(1);
		/* Fim Linha do Tempo */
		$result['status'] = 1;
		while($rs_empresas->GeraDados()){
		$tbl.= "
			<tr>
				<td>".$rs_empresas->fld("emp_cnpj")."</td>
				<td>".$rs_empresas->fld("emp_razao")."</td>
				<td>".$rs_empresas->fld("emp_nome")."</td>
				<td>".$rs_empresas->fld("emp_resp")."</td>
				<td>
					<div class='btn-group'>
						<a href='../view/dados_emp.php?cnpj=".$rs_empresas->fld("emp_cnpj")."&token=".$_SESSION['token']."' class='btn btn-xs btn-info' data-toggle='tooltip' data-placement='bottom' title='Dados'><i class='fa fa-database'></i> </a>
						<a href='../view/desat_emp.php?cnpj=".$rs_empresas->fld("emp_cnpj")."&token=".$_SESSION['token']."' class='btn btn-xs btn-danger' data-toggle='tooltip' data-placement='bottom' title='Desativar'><i class='fa fa-trash'></i> </a>
					</div>
				</td>
			</tr>";
		}
		$tbl = str_replace("\t","",$tbl);
		$tbl = str_replace("\r","",$tbl);
		$tbl = str_replace("\n","",$tbl);
		$tbl = stripslashes($tbl);
		$result['mensagem'] = ltrim(rtrim(trim($tbl)));
	}
		echo json_encode($result);
	exit;
}
if($acao == "inclusao"){
	$dados = array(
	"emp_cnpj"		=> (string)$emp_cnpj,
	"emp_razao"		=> $emp_rzs,
	"emp_nome"		=> $emp_nft,
	"emp_ie" 		=> (string)$emp_iest,
	"emp_cep" 		=> $emp_cep,
	"emp_logr" 		=> $emp_log,
	"emp_num" 		=> $emp_num,
	"emp_compl" 	=> $emp_compl,
	"emp_bairro" 	=> $emp_bai,
	"emp_cidade" 	=> $emp_cid,
	"emp_uf" 		=> $emp_uf,
	"emp_resp" 		=> $emp_resp,
	"emp_im"		=> $emp_mun,
	"emp_cnae"		=> $emp_cnae,
	"emp_evento"	=> $emp_evt,
	"emp_crt"		=> $emp_crt,
	"emp_logo" 		=> ''
	);
	if( !$rs_empresas->add_novo($dados)){
		$resul["status"]="OK";
		$resul["mensagem"]="Nova empresa cadastrada";
		$hist->add_hist(2);
	}
	else{
		$resul["status"]	= "ERRO";
		$resul["mensagem"]	= "Falha na inclus&atilde;o";
	}
	//echo $rs_empresas->sql;
	echo json_encode($resul);
	exit;
}
if($acao == "documentos"){
	$dados = array(
		"doc_cli_cnpj" 	=> $doc_cli,
		"doc_tipo"		=> $doc_tipo,
		"doc_desc"		=> $doc_desc,
		"doc_ender"		=> $doc_end,
		"doc_dtenv"		=> date('Y-m-d'),
		"doc_user_env"	=> $doc_uenv
	);
	if( !$rs_empresas->Insere($dados,"documentos")){
		$resul["status"]="OK";
		$resul["mensagem"]="Novo Doc enviado";
		$hist->add_hist(6);
	}
	else{
		$resul["status"]	= "ERRO";
		$resul["mensagem"]	= "Falha na inclus&atilde;o";
	}
	exit;
}
if($acao == "dados"){
	$dados = array(
		"con_cli_cnpj" 	=> $con_cli_cnpj,
		"con_tipo"		=> $con_tp,
		"con_contato"	=> $con_cont
	);
	if( !$rs_empresas->Insere($dados,"contatos")){
		$resul["status"]="OK";
		$resul["mensagem"]="Novo contato OK";
		$hist->add_hist(5);
	}
	else{
		$resul["status"]	= "ERRO";
		$resul["mensagem"]	= "Falha na inclus&atilde;o";
	}
	exit;
}
?>