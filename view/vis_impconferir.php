<?php

require_once("../class/class.functions.php");
require_once("../class/class.permissoes.php");
if(!isset($_SESSION)){session_start("portal");}
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
	$sql = "SELECT e.cod, e.apelido, c.imp_nome, c.imp_tipo, c.imp_id, a.env_compet, a.env_movuser, e.carteira, a.env_codEmp FROM impostos_enviados a 
			LEFT JOIN tipos_impostos c ON a.env_codImp = c.imp_id
			LEFT JOIN tri_clientes e ON e.cod = a.env_codEmp
		WHERE 1 ";
		
		if($con['C']==0){
			$sql.= " AND e.carteira LIKE '%".$_SESSION['usu_cod']."%'";
		}
		//$sql.=" AND imp_depto = ".$_SESSION['dep'];

		$sql.=" 
				AND env_mov=1 
				AND env_gerado=1 
				AND (env_conferido IS NULL OR env_conferido=0)
				";

	$trib = $per->getPermissao("ver_somentetrib",$_SESSION['usu_cod']);
	if($trib['C']==1){
		$sql.= "AND imp_tipo='T'";
	}
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
	else{
		$sql.= " AND env_compet='".$compcorr."'";
	}

	$sql.=" ORDER BY e.cod ASC, imp_tipo ASC, cast(imp_venc as unsigned integer) ASC";
	$tbl = "";
	/*
	echo $sql;
	*/
	$rs_eve->FreeSql($sql);
	if($rs_eve->linhas>0){
		while($rs_eve->GeraDados()){
			$colab = json_decode($rs_eve->fld("carteira"),true);
			
			
			$tbl .= "<input type='hidden' name='empresa".$rs_eve->fld("imp_id")."' id='empresa".$rs_eve->fld("imp_id")."' value=''>
					 <input type='hidden' name='compet' id='compet' value='".date("m/Y", strtotime("-1 month"))."'>
					 <tr>
					 	<td>".str_pad($rs_eve->fld("cod"),3,"0",STR_PAD_LEFT)."</td>
					 	<td>".$rs_eve->fld("apelido")."</td>
						<td>[".$rs_eve->fld("imp_tipo")."] ".$rs_eve->fld("imp_nome")."</td>
						<td>".$rs_eve->fld("env_compet")."</td>
					 		<td>".$rs2->pegar("usu_nome","usuarios","usu_cod=".$rs_eve->fld("env_movuser"))."</td>
						
						<td>
							<button 
								class='btn btn-xs btn-success pesq'
								type='button'
								data-emp = ".$rs_eve->fld("env_codEmp")."
								data-imp = ".$rs_eve->fld("imp_id")."
								id='ckimpconf".$rs_eve->fld("imp_id").$rs_eve->fld("env_codEmp")."'
								onclick=mark_sent('".$rs_eve->fld("env_codEmp")."','".date("m/Y")."','".$rs_eve->fld("imp_id")."',true,'conferido','ckimpconf".$rs_eve->fld("imp_id").$rs_eve->fld("env_codEmp")."')>
								<i class='fa fa-check'></i> Conferir
								</button>
						</td>
					 </tr>";
		}
	}
	else{
		$tbl.="<tr>
					<td colspan=6>Tudo conferido!</td>
				</tr>";
	}
echo $tbl;

?>