<?php

session_start();
require_once('../class/class.eventos.php');
require_once("../class/class.functions.php");
require_once("../class/class.historico.php");
$func = new functions();
$rs_eve = new eventos();
$hist = new historico();
$result = array();
extract($_POST);

if($acao == "inclusao"){
	list($dt_ini, $dt_fin) = split("-",$eve_data);
	$dados = array(
		"eve_local" => $eve_local,
		"eve_data"	=> $func->data_usa(trim($dt_ini)),
		"eve_dataate"=> $func->data_usa(trim($dt_fin)),
		"eve_desc"	=> $eve_det,
		"eve_cep"	=> $eve_cep,
		"eve_log"	=> $eve_log,
		"eve_num"	=> $eve_num,
		"eve_compl"	=> $eve_compl,
		"eve_bai"	=> $eve_bai,
		"eve_cid"	=> $eve_cid,
		"eve_uf"	=> $eve_uf,
		"eve_valor"	=> $eve_valor,
		"eve_empresa"=> $eve_emp,
		"eve_ativo" => $eve_ativo
	);
	 if (!$rs_eve->novo_evento($dados)) {
        $resul["status"] = "ERRO";
        $resul["mensagem"] = "Falha na inclus&atilde;o";
    } else {
        $hist->add_hist(9);
        $resul["status"] = "OK";
        $resul["mensagem"] = "Novo evento cadastrado!";
    }
	echo json_encode($result);
    exit;
}

if($acao == "Participar"){
	$dados = array(
		"epart_evento" 	 => $evento,
		"epart_emp_cnpj" => $cnpj ,
		"epart_valor" 	 => $valor,
		"epart_venc1" 	 => $func->data_usa(trim($venc1)),
		"epart_venc2" 	 => $func->data_usa(trim($venc2)),
		"epart_formapag" => $forma,
		"epart_manual"	 => (isset($manual) ? $manual : "0")
	);
	if(!$rs_eve->Insere($dados,"evpartic")){
		$result["st"] = "OK";
		$result["ms"] = "Dados cadastrados";
		$result["sql"] = $rs_eve->sql;
	} else{
		$result["st"] = "NOK";
		$result["ms"] = "Dados não cadastrados";
		$result["sql"] = $rs_eve->sql;
	}
	
	echo json_encode($result);
    exit;
}

if ($acao == "consulta") {
    if(!empty($eve_data)){
		list($dt_ini, $dt_fin) = split("-",$eve_data);
        $sql = "SELECT * FROM eventos WHERE eve_data BETWEEN '" . $func->data_usa(trim($dt_ini)) . " 'AND '" .$func->data_usa(trim($dt_fin)). "'";
		$sql.= "ORDER BY eve_data ASC";
    }
    $rs_eve->FreeSQL($sql);
    $tbl = "";
    if ($rs_eve->linhas == 0) {
        $result['status'] = 0;
        $result['query'] = $sql;
        $result['mensagem'] = $dt_fin;
		
    } else {
		$result['query'] = $sql;
        /* Insere o evento na linha do tempo */
        $hist->add_hist(10); // pesquisa de evento
        /* Fim Linha do Tempo */
        $result['status'] = 1;
        while ($rs_eve->GeraDados()) {
            $tbl.= "
			<tr>
				<td>" . $func->data_br($rs_eve->fld("eve_data")) . "</td>
				<td>" . $rs_eve->fld("eve_local") . "</td>
				<td>R$" . number_format($rs_eve->fld("eve_valor"),2,",",".") . "</td>
				<td>R$" . number_format(( $rs_eve->fld("eve_valor")/2 ),2,",",".") . "</td>
				<td>
					<div class='btn-group'>
						<a href='../view/visual_eve.php?evento=" . $rs_eve->fld("eve_id") . "&cnpj=" . $rs_eve->fld("eve_empresa") . "&token=" . $_SESSION['token'] . "' class='btn btn-xs btn-info' data-toggle='tooltip' data-placement='bottom' title='Visualizar'><i class='fa fa-eye'></i> </a>
					</div>
				</td>
			</tr>";
        }
        $tbl = str_replace("\t", "", $tbl);
        $tbl = str_replace("\r", "", $tbl);
        $tbl = str_replace("\n", "", $tbl);
        $tbl = stripslashes($tbl);
        $result['mensagem'] = ltrim(rtrim(trim($tbl)));
    }
    echo json_encode($result);
    exit;
}