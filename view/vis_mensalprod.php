<?php

require_once("../class/class.functions.php");
require_once("../class/class.permissoes.php");
if(!isset($_SESSION)){session_start();}
$rs_eve = new recordset();
$rs1 = new recordset();
$rs2 = new recordset();

//$hist = new historico();
$fn = new functions();
$per = new permissoes();
//$resul = array();
extract($_GET);

$con = $per->getPermissao("ver_impostos", $_SESSION['usu_cod']);
	$sql = "SELECT cod, empresa, apelido, tribut FROM tri_clientes a
				LEFT JOIN obrigacoes b ON a.cod = b.ob_cod
			WHERE emp_vinculo = ".$_SESSION['usu_empcod']."
			AND a.ativo=1";
	if(isset($empre) AND $empre<>""){
		$sql.= " AND cod = ".$empre;
	}
	if(isset($usua) AND $usua<>""){
		$usr = explode(",", $usua);
		for($i=0; $i<sizeof($usr);$i++){
			$sql.= ($i==0?" AND (":" OR "). "carteira LIKE '%\"user\":\"".$usr[$i]."\"%'";
		}
	$sql.=")";
	}
	if(isset($impos) AND $impos<>""){
		$sql.= " AND ob_titulo = ".$impos." AND ob_ativo=1";
	}
	else{
		$sql.= " AND ob_titulo = 140 AND ob_ativo=1";	
	}


	$sql.=" GROUP BY a.cod ORDER BY cod ASC";
	$tbl = "";
	$rs_eve->FreeSql($sql);
	$dd = $sql;
	if($rs_eve->linhas>0){
		$ano = date("Y");
		while($rs_eve->GeraDados()){
			
			$tbl .= "
					 <tr>
					 	<td>".str_pad($rs_eve->fld("cod"),3,"0",STR_PAD_LEFT)."</td>
					 	<td>".$rs_eve->fld("apelido")."</td>
					 	<td>".$rs_eve->fld("tribut")."</td>
					";
			for($i=1; $i<=12; $i++){
				$sql2 = "SELECT env_conferidodata, env_conferido, env_conferidouser FROM impostos_enviados a
							JOIN usuarios b ON a.env_conferidouser = b.usu_cod
						WHERE env_codEmp = ".$rs_eve->fld("cod");

				
				if(isset($impos) AND $impos<>""){
					$sql2.= " AND env_codImp = ".$impos;
				}
				else{
					$sql2.= " AND env_codImp = 140";	
				}

				if(isset($compet) AND $compet<>""){
					$sql2.= " AND env_compet = '".str_pad($i,2,"0",STR_PAD_LEFT)."/".$compet."'";
				}
				else{
					$sql2.= " AND env_compet = '".str_pad($i,2,"0",STR_PAD_LEFT)."/".$ano."'";
				}
				$sql2.=" AND env_conferido=1";
				$rs2->FreeSql($sql2);
				$rs2->GeraDados();
				$menv='';
				if($rs2->fld("env_conferido")==1){
					$menv.="Conferido: ".$rs1->pegar("usu_nome","usuarios","usu_cod=".$rs2->fld("env_conferidouser"))." em ".$fn->data_hbr($rs2->fld("env_conferidodata"));
				}
				
				$tbl.="	<td align='center' class='".($rs2->linhas==1?"success":"danger")."'>
							<span class='text-green' title='".$menv."' data-toggle='tooltip'>".($rs2->linhas==1?"<i class='fa fa-check-circle'></i>":"-")."</span>
						</td>";
				/*
				echo $dd."<br>";
				*/
			}
		}
	$tbl.="</tr>";
	}
	else{
		$tbl.="<tr>
					<td colspan=5>Tudo conferido!</td>
				</tr>

				";
	}
echo $tbl;

?>