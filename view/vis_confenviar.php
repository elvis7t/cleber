<?php
session_start("portal");
require_once("../class/class.functions.php");
require_once("../class/class.permissoes.php");
//$hosted = "http://192.168.0.104:8080/web";
$rs_eve = new recordset();
$rs1 = new recordset();
$rs2 = new recordset();
//$hist = new historico();
$fn = new functions();
$per = new permissoes();
//$resul = array();
extract($_GET);
$mcorr = date("m")-1;
$mcorr = str_pad($mcorr, 2,"0",STR_PAD_LEFT);
$ycorr = date("Y");
$compcorr = $mcorr."/".$ycorr;
$con = $per->getPermissao("ver_impostos", $_SESSION['usu_cod']);
	$sql = "SELECT * FROM impostos_enviados a
			LEFT JOIN tipos_impostos c ON a.env_codImp = c.imp_id
			LEFT JOIN tri_clientes e ON e.cod = a.env_codEmp
		WHERE 1 ";
		
		if($con['C']==0){
			$sql.= " AND e.carteira LIKE '%".$_SESSION['usu_cod']."%' AND imp_depto = ".$_SESSION['dep'];
		}
		
		$sql.=" AND imp_tipo='T'
				AND env_mov=1 
				AND env_gerado=1 
				AND env_conferido=1
				AND env_enviado=1
				AND (env_confenv IS NULL OR env_confenv=0)
				AND env_compet='".$compcorr."'";
	/*|ALTERAÇÃO - CLEBER MARRARA
		SOLICITADO POR: ADEMIR
		Só visualizar Tributos na Conferência!
	$trib = $per->getPermissao("ver_somentetrib",$_SESSION['usu_cod']);
	if($trib['C']==1){
		$sql.= "AND imp_tipo='T'";
	}
	|*/
	if(isset($emp) AND $emp<>""){
		$sql.= " AND cod = ".$emp;
	}
	if(isset($imp) AND $imp<>""){
		$sql.= " AND imp_id = ".$imp;
	}
	if(isset($usu) AND $usu<>""){
		$sql.=" AND carteira LIKE '%\"user\":\"".$usu."\"%'";
	}
	
	if(isset($comp) AND $comp<>""){
		$sql.= " AND env_compet = '".$comp."'";
	}

	$sql.=" ORDER BY e.apelido ASC, imp_tipo ASC, cast(imp_venc as unsigned integer) ASC";
	$tbl = "";
	$rs_eve->FreeSql($sql);
	//echo $sql;
	if($rs_eve->linhas>0){
		while($rs_eve->GeraDados()){
			$colab = json_decode($rs_eve->fld("carteira"),true);
			$vn = "";			
			
			$tbl .= "<input type='hidden' name='empresa".$rs_eve->fld("imp_id")."' id='empresa".$rs_eve->fld("imp_id")."' value=''>
					 <input type='hidden' name='compet' id='compet' value='".date("m/Y", strtotime("-1 month"))."'>
					 <tr>
					 	<td>".$rs_eve->fld("cod")." - ".$rs_eve->fld("apelido")."</td>
						<td>[".$rs_eve->fld("imp_tipo")."] ".$rs_eve->fld("imp_nome")."</td>
						<td>".$rs_eve->fld("env_compet")."</td>
					 	<td>".$rs2->pegar("usu_nome","usuarios","usu_cod=".$colab[$rs_eve->fld("imp_depto")]["user"])."</td>
					 	<td>".$rs2->pegar("usu_nome","usuarios","usu_cod=".$rs_eve->fld("env_user"))."</td>
						
						<td>
							<button 
								class='btn btn-xs btn-success pesq'
								type='button'
								data-emp = ".$rs_eve->fld("env_codEmp")."
								data-imp = ".$rs_eve->fld("imp_id")."
								id='ckimpconf".$rs_eve->fld("imp_id").$rs_eve->fld("env_codEmp")."'
								onclick=mark_sent('".$rs_eve->fld("env_codEmp")."','".date("m/Y", strtotime("-1 month"))."','".$rs_eve->fld("imp_id")."',true,'confenvio','ckimpenv".$rs_eve->fld("imp_id").$rs_eve->fld("env_codEmp")."')>
								<i class='fa fa-check-square-o'></i> Conferir Envio
								</button>
						</td>
					 </tr>";
		}
	}
	else{
		$tbl.="<tr>
					<td colspan=6 valign='center'>Tudo conferido!</td>
				</tr>";
	}
	$tbl.="<tr><th colspan=6>".$rs_eve->linhas." registro(s) encontrado(s)</th></tr>";
echo $tbl;
?>