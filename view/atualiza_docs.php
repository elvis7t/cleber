<?php
require_once("../../model/recordset.php");
$hosted = "http://192.168.0.104:8080/web";
date_default_timezone_set('America/Sao_Paulo');
//echo $hosted;
$rs=new recordset();
$dados = array();
$sql = "SELECT * FROM empresas WHERE 1";

$rs->FreeSql($sql);
while($rs->GeraDados()){
	
	$rs1=new recordset();
	$rs2=new recordset();
	$sql1 = "SELECT * FROM irpf_outrosdocs WHERE irdocs_cli_id=".$rs->fld('emp_codigo');
	//echo $sql1;
	$rs1->FreeSql($sql1);
	if($rs1->linhas==0){
		echo "Nada para alterar em {$rs->fld('emp_codigo')}\r\n ";
	}
	else{
		$rs1->GeraDados();
		$sql2 = "UPDATE empresas SET emp_benef='".$rs1->fld("irdocs_dado")."' WHERE emp_codigo=".$rs->fld('emp_codigo');
		
		if( !$rs2->FreeSql($sql2)){
			echo "OK - Alterado! Codigo: {$rs->fld('emp_codigo')}, Dado: {$rs1->fld("irdocs_dado")} \r\n";
		}
		else{
			echo "Erro: {$rs2->sql}";
		}
	}
	unset($rs1);
	unset($rs2);
}
?>
