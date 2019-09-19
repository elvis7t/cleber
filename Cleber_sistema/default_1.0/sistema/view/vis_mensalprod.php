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
	$sql = "SELECT * FROM tri_clientes a
				LEFT JOIN obrigacoes b ON a.cod = b.ob_cod
			WHERE emp_vinculo = ".$_SESSION['usu_empcod'];
	if(isset($empre) AND $empre<>""){
		$sql.= " AND cod = ".$empre;
	}
	if(isset($usua) AND $usua<>""){
		$sql.=" AND carteira LIKE '%\"user\":\"".$usua."\"%'";
	}
	if(isset($impos) AND $impos<>""){
		$sql.= " AND ob_titulo = ".$impos." AND ob_ativo=1";
	}
	else{
		$sql.= " AND ob_titulo = 53 AND ob_ativo=1";	
	}


	$sql.=" GROUP BY a.cod ORDER BY cod ASC";
	$tbl = "";
	$rs_eve->FreeSql($sql);
	//echo $sql;
	if($rs_eve->linhas>0){
		$ano = date("Y");
		while($rs_eve->GeraDados()){
			
			$tbl .= "
					 <tr>
					 	<td>".$rs_eve->fld("cod")." - ".$rs_eve->fld("apelido")."</td>
					";
			for($i=1; $i<=12; $i++){
				$sql2 = "SELECT * FROM impostos_enviados a
							JOIN usuarios b ON a.env_user = b.usu_cod
						WHERE env_codEmp = ".$rs_eve->fld("cod");

				
				if(isset($impos) AND $impos<>""){
					$sql2.= " AND env_codImp = ".$impos;
				}
				else{
					$sql2.= " AND env_codImp = 53";	
				}

				if(isset($compet) AND $compet<>""){
					$sql2.= " AND env_compet = '".str_pad($i,2,"0",STR_PAD_LEFT)."/".$compet."'";
				}
				else{
					$sql2.= " AND env_compet = '".str_pad($i,2,"0",STR_PAD_LEFT)."/".$ano."'";
				}
				$sql2.=" AND env_enviado=1";
				$rs2->FreeSql($sql2);
				$rs2->GeraDados();
				$menv='';
				if($rs2->fld("env_enviado")==1){
					$menv.="Enviado: ".$rs1->pegar("usu_nome","usuarios","usu_cod=".$rs2->fld("env_user"))." em ".$fn->data_hbr($rs2->fld("env_data"));
				}
				
				$tbl.="	<td align='center' class='".($rs2->linhas==1?"success":"danger")."'>
							<span title='".$menv."' data-toggle='tooltip'>".($rs2->linhas==1?"OK":"-")."</span>
						</td>";
				/*
				echo $sql2."<br>";
				*/
			}
		}
	$tbl.="</tr>";
	}
	else{
		$tbl.="<tr>
					<td colspan=5>Tudo conferido!</td>
				</tr>";
	}
echo $tbl;
?>