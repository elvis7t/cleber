<?php
require_once("../../sistema/class/class.functions.php");
require_once("../class/class.permissoes.php");
session_start();
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
$sql = "SELECT * FROM trata_arquivos a
			LEFT JOIN tipos_arquivos c ON a.trata_cliarqarqid = c.tarq_id
			LEFT JOIN tri_clientes e ON e.cod = a.trata_cliarqEmp
			LEFT JOIN codstatus d ON d.st_codstatus = a.trata_status
		WHERE 1 ";
		$con = $per->getPermissao("fila_importa",$_SESSION["usu_cod"]);
		if($con['C']==0){
			$sql.= " AND e.carteira LIKE '%".$_SESSION['usu_cod']."%' AND tarq_depart = ".$_SESSION['dep'];
		}
		
		$sql.=" AND trata_competencia='".$compcorr."'";
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
	if(isset($arq) AND $arq<>""){
		$sql.= " AND trata_id = ".$arq;
	}
	if(isset($usu) AND $usu<>""){
		$sql.=" AND carteira LIKE '%\"user\":\"".$usu."\"%'";
	}
	/*
	if(isset($comp) AND $comp<>""){
		$sql.= " AND trata_competencia = '".$comp."'";
	}
	*/
	$sql.=" ORDER BY trata_status ASC, trata_erro ASC, trata_id ASC";
	$tbl = "";
	$rs_eve->FreeSql($sql);
	//echo $sql;
	if($rs_eve->linhas>0){
		$i=0;
		while($rs_eve->GeraDados()){
			$i++;
			$colab = json_decode($rs_eve->fld("carteira"),true);			
			
			$erro = ($rs_eve->fld("trata_status")==97?"text-danger":"");
			
			$tbl .= "<input type='hidden' name='empresa".$rs_eve->fld("trata_id")."' id='empresa".$rs_eve->fld("trata_id")."' value=''>
					 <input type='hidden' name='compet' id='compet' value='".date("m/Y", strtotime("-1 month"))."'>
					 <tr>
					 	<td>".$rs_eve->fld("cod")." - ".$rs_eve->fld("apelido")."</td>
						<td>".$rs_eve->fld("tarq_nome")."</td>
						<td>".$rs_eve->fld("trata_competencia")."</td>
					 	<td>".$rs2->pegar("usu_nome","usuarios","usu_cod=".$colab[$rs_eve->fld("tarq_depart")]["user"])."</td>
					 	<td>".$rs2->pegar("usu_nome","usuarios","usu_cod=".$rs_eve->fld("trata_resp"))."</td>
						<td><span class='".$erro."'>".$rs_eve->fld("st_desc")."</span></td>
					 	<td>";
			if($rs_eve->fld("trata_status")==0 || $rs_eve->fld("trata_status")==97){
				$tbl.="
							<a 
								class='btn btn-xs btn-primary pesq'
								title='Disponibilizar para importação'
								href=tratamento_arquivos.php?arq=".$rs_eve->fld("trata_id")."&token=".$_SESSION["token"].">
								<i class='fa fa-mail-forward'></i>
								</a>
						";
			}
			if($rs_eve->fld("trata_status")==92){
				$tbl.="
							<a 
								class='btn btn-xs btn-info pesq ".($i>1?'disabled':'')."'
								title='Iniciar processo de importação'
								href=tratamento_arquivos.php?arq=".$rs_eve->fld("trata_id")."&token=".$_SESSION["token"].">
								<i class='fa fa-check-square-o'></i> 
								</a>
						";
			}
			$tbl.="</td>
					 </tr>";
		}
	}
	else{
		$tbl.="<tr>
					<td colspan=7 valign='center'>Tudo conferido!</td>
				</tr>";
	}
	$tbl.="<tr><th colspan=7>".$rs_eve->linhas." registro(s) encontrado(s)</th></tr>";
echo $tbl;
?>