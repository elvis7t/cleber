<?php

session_start();
require_once("../class/class.user.php");
require_once("../class/class.historico.php");
$rs_usuarios = new usuarios();
$hist = new historico();
$result = array();
extract($_POST);

if ($acao == "inclusao") {
    $dados = array(
    "usu_nome" => $usu_ncp,
    "usu_senha" => md5($usu_senha),
    "usu_emp_cnpj" => $doc,
    "usu_classe" => 3, //classe de usuário comum. Só pode ser alterada pelo admin
    "usu_email" => $usu_user, // email
    "usu_ativo" => '1', // ativo
    "usu_online" => '0', // online
    "usu_foto" => '/sistema/assets/perfil/'.($usu_sexo == '1' ? 'masc':'fem').'.jpg'
    );
    $dados2 = array(
        "dados_nome" => $usu_ncp,
        "dados_rg" => $usu_rg,
        "dados_sexo" => $usu_sexo,
        "dados_cep" => $usu_cep,
        "dados_rua" => $usu_log,
        "dados_num" => $usu_num,
        "dados_compl" => $usu_compl,
        "dados_bairro" => $usu_bai,
        "dados_cidade" => $usu_cid,
        "dados_uf" => $usu_uf,
        "dados_usu_email" => $usu_user
    );
    if (!$rs_usuarios->add_user($dados)) {
        $resul["status"] = "ERRO";
        $resul["mensagem"] = "Falha na inclus&atilde;o";
    } else {
        $rs_usuarios->Insere($dados2, "dados_user");
        $hist->add_hist(3);
        $resul["status"] = "OK";
        $resul["mensagem"] = "Novo Usu&aacute;rio cadastrado!";
    }
    //echo $rs_usuarios->sql;
    echo json_encode($resul);
    exit;
}
if ($acao == "consulta") {
   $sql = "SELECT * FROM usuarios WHERE usu_email = '" . $usu_mail . "'";

    $rs_usuarios->FreeSQL($sql);
    $tbl = "";
    if ($rs_usuarios->linhas == 0) {
        $result['status'] = 0;
        $result['query'] = $sql;
    } else {
        /* Insere o evento na linha do tempo */
        $hist->add_hist(8);
        /* Fim Linha do Tempo */
        $result['status'] = 1;
        while ($rs_usuarios->GeraDados()) {
            $tbl.= "
			<tr>
				<td>" . $rs_usuarios->fld("usu_nome") . "</td>
				<td>" . $rs_usuarios->fld("usu_email") . "</td>
				<td>" . $rs_usuarios->fld("usu_classe") . "</td>
				<td>" . $rs_usuarios->fld("usu_ativo") . "</td>
				<td>".($_SESSION['classe']==1 ?"
					<div class='btn-group'>
						<a href='../view/desat_usu.php?cnpj=" . $rs_usuarios->fld("dados_cpf") . "&token=" . $_SESSION['token'] . "' class='btn btn-xs btn-danger' data-toggle='tooltip' data-placement='bottom' title='Desativar'><i class='fa fa-trash'></i> </a>
					</div>" :""
					)."
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
?>

