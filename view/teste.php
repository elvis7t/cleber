<?php
require_once('../class/class.functions.php');
$fn = new functions();

$dados['ativo'] 			= 1;
$dados['emp_vinculo']	= $_SESSION["sys_id"];
$whr = "cod=1";
$fn->Audit("tri_clientes", $whr, $dados, 1, 1,1);



/*
require_once('../../model/recordset.php');
session_start();
$rsalt = new recordset();
$rs2 = new recordset();
$rs3 = new recordset();
$dep = 3;
$user = 98;

$dados2 = array();
$dados2[$dep]["user"] = $user;
$dados2[$dep]["data"] = date("d/m/Y");

$rs3->Seleciona("cod","tri_clientes","cod<>0");
while($rs3->GeraDados()){
	$cods = $rs3->fld("cod");

	$rsalt = new recordset();
	$cart 	= json_decode($rs2->pegar("carteira","tri_clientes","cod=".$cods),true);
	$ncart 	= $dados2 + $cart;
	$json 	= json_encode($ncart);
	$dados['carteira'] = addslashes($json);
	
	$whr = "cod =".$cods;
	$fn->Audit("tri_clientes", $whr, $dados, $cods, $_SESSION['usu_cod'],1);
	$rsalt->Altera($dados, "tri_clientes", $whr);
	/*	
		$resul['status'] = "OK";
		$resul['mensagem']="Servi&ccedil;os OK!";
		$resul['sql']=$rs_eve->sql;
	}
	else{
		$resul['status']="NOK";
		$resul['mensagem']="Falha no SQL";
		$resul['sql']=$rs_eve->sql;
	}
} 
$resul['status'] = "OK";
echo json_encode($resul);
//echo json_encode($dados2);
exit;
*/
?>