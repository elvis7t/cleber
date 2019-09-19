<?php
date_default_timezone_set('America/Sao_Paulo');

session_start();
require_once('../model/recordset.php');
require_once('../class/class.historico.php');
require_once('../class/class.functions.php');
require_once('../class/class.permissoes.php');

$rs_eve = new recordset();
$rs1 = new recordset();
$rs2 = new recordset();
$hist = new historico();
$fn = new functions();
$per = new permissoes();
$resul = array();
extract($_POST);

if($acao == "fila_arquivo"){
	$con = $per->getPermissao("ver_empresas", $_SESSION['usu_cod']);
	$sql = "SELECT a.tarq_id,
				 a.tarq_nome, 
				 a.tarq_depart,
				 c.cliarq_venc, 
				 e.carteira, 
				 e.cod as CodO, 
				 e.apelido as EmpO
				FROM tipos_arquivos a 
					LEFT JOIN clientes_arquivos c ON c.cliarq_arqId = a.tarq_id 
					LEFT JOIN tri_clientes e ON e.cod = c.cliarq_empresa
					LEFT JOIN trata_arquivos d ON d.trata_cliarqarqid = c.cliarq_arqId  AND d.trata_cliarqEmp = c.cliarq_empresa
					WHERE 1";
		
		$fila_outro= $per->getPermissao("fila_outro",$_SESSION['usu_cod']);
		if($fila_outro['C']==0){
			$sql.=" AND trata_resp=".$_SESSION['usu_cod'];
		}
		if($_SESSION["classe"]>=5){
			$sql.= " AND tarq_depart=".$_SESSION['dep'];
		}
		
		if($con['C']==0){
			$sql.= " AND e.carteira LIKE '%\"user\":\"".$_SESSION['usu_cod']."\"%'";
		}
		
		if($emp<>""){
			$sql.=" AND (e.cod = ".$emp.")";
		}
		
		if($imp<>""){
			$sql.=" AND tarq_id = ".$imp;
		}
		
		if($usu<>""){
			$sql.=" AND carteira LIKE '%\"user\":\"".$usu."\"%'";
		}

	$sql.=" AND c.cliarq_ativo=1 ORDER BY d.trata_mov DESC, d.trata_status DESC, c.cliarq_venc ASC, d.trata_erro ASC, d.trata_movdata ASC";
	$tbl = "";
	//echo $sql."<br>";
	$rs_eve->FreeSql($sql);
	if($rs_eve->linhas>0){
		$i=0;
		while($rs_eve->GeraDados()){
			$i++;
			$colab = json_decode($rs_eve->fld("carteira"),true);
	
			$emp_im = $rs_eve->fld("CodO");
			$emp_no = $rs_eve->fld("EmpO");
			$hide = (empty($emp_no)?"disabled":"");
			$mes_cp = '';
			$sql1 = "SELECT * FROM trata_arquivos a
						JOIN codstatus b ON a.trata_status = b.st_codstatus
						WHERE trata_cliarqarqid = ".$rs_eve->fld("tarq_id");

			
			
			if(isset($comp) AND $comp<>""){
				list($mes, $ano) = explode("/",$comp);
				$mes_vn = date("m/Y", strtotime($ano."-".(str_pad(($mes),2,"0",STR_PAD_LEFT))."+1 month"));
				$mes_cp = $comp;
				$sql1.=" AND trata_competencia = '".$comp."'";

			}
			else{
				$mes_cp = ( date('d') > 26 ? date("m/Y", strtotime("first day of this month")) : date("m/Y", strtotime("-1 month")) );
				$mes_vn = ( date('d') > 26 ? date("m/Y", strtotime("first day of next month")) : date("m/Y") );
				$sql1.=" AND trata_competencia = '".$mes_cp."'";
			}
			if($emp_no<>""){
				$sql1.=" AND trata_cliarqEmp = ".$emp_im;
			}
			

			$rs1->FreeSql($sql1);
			//echo $sql1.";<br>";
			//echo $colab[$rs_eve->fld("imp_depto")]["user"];
			//if($rs1->linhas>0){

				$rs1->GeraDados();
				$vn = str_pad($rs_eve->fld("cliarq_venc"),2,"0",STR_PAD_LEFT)."/".$mes_vn;
				$fura = $per->getPermissao("fura_fila",$_SESSION['usu_cod']);
				$mmov = $menv = '';
				if($rs1->fld("trata_mov")==1){$mmov.="Movimento gerado por: em: <br>";}
				if($rs1->fld("trata_status")==99){
					$menv.="Enviado: ".$rs2->pegar("usu_nome","usuarios","usu_cod=".$rs1->fld("trata_finpor"))." em ".$fn->data_hbr($rs1->fld("trata_stdata"));
				}
				$tbl .= "<input type='hidden' name='empresa".$rs_eve->fld("tarq_id")."' id='empresa".$rs_eve->fld("tarq_id")."' value='{$emp_im}'>
						 <input type='hidden' name='compet' id='compet' value='".$mes_cp."'>
						 <tr>
						 	<td>".$rs1->fld("trata_id")."</td>
						 	<td>".$emp_im." - ". $emp_no."</td>
							<td>".$rs_eve->fld("tarq_nome")."</td>
							<td>".$mes_cp."</td>
							<td>".$vn."</td>
							<td>".($colab[$rs_eve->fld("tarq_depart")]["user"]==0?"-":$rs2->pegar("usu_nome","usuarios","usu_cod=".$colab[$rs_eve->fld("tarq_depart")]["user"]))."</td>
							<td>".($rs1->fld("trata_resp")==0?"-":$rs2->pegar("usu_nome","usuarios","usu_cod=".$rs1->fld("trata_resp")))."</td>
							<td>
								<select class='select2' id='sel_impmov".$rs_eve->fld("tarq_id").$emp_im."'
										onchange=mark_disp('".$emp_im."','".$mes_cp."','".$rs_eve->fld("tarq_id")."',this.value,'mov','ckimpmov".$rs_eve->fld("tarq_id").$emp_im."')>
									<option ".($rs1->linhas==0?'SELECTED':'')." value=''>Selecione:</option>
									<option ".($rs1->fld("trata_mov")==1?'SELECTED':'')." value='1'>Sim</option>
									<option ".($rs1->linhas<>0 && $rs1->fld("trata_mov")==0?'SELECTED':'')." value='0'>Não</option>
								</select>

							</td>
							<td>".$rs1->fld("st_desc")."</td>
							<td>";
					if($rs1->fld("trata_mov")==1 && $rs1->fld("trata_status")==92){
						$tbl.="
								<a 
									class='btn btn-xs btn-info pesq '".(($i>1 AND $fura['C']==0)?'disabled':'active')."
									title='Iniciar processo de importação'
									href=".(($i>1 AND $fura['C']==0)?"javascript:alert('Indisponivel');":"tratamento_arquivos.php?arq=".$rs1->fld("trata_id")."&token=".$_SESSION["token"])."
									role='button'>
									<i class='fa fa-check-square-o'></i> 
								</a>";
					}
					if(($rs1->fld("trata_status")==0 OR $rs1->fld("trata_status")==-1) AND $rs1->fld("trata_mov")<>0){
						$tbl.="
								<a 
									class='btn btn-xs btn-primary pesq'
									title='Disponibilizar para importação'
									href=tratamento_arquivos.php?arq=".$rs1->fld("trata_id")."&token=".$_SESSION["token"]."
									role='button'>
									<i class='fa fa-mail-forward'></i> 
								</a>";
					}
					$tbl.="</td></tr>";
			}
		//}
	}
	else{
		$tbl.="<tr>
					<td colspan=9>Sem arquivos para a empresa {$emp}!</td>
				</tr>";
	}
echo $tbl;

exit;
}

if($acao == "inclui_mov"){
	$whr = "trata_cliarqEmp = {$empresa} AND trata_cliarqarqid = {$arquivo} AND trata_competencia = '{$compet}'";
	$dados['trata_mov']		= 1;
	$dados['trata_movdata'] = date("Y-m-d H:i:s");
	$dados['trata_movpor'] 	= $_SESSION['usu_cod'];
	$dados['trata_status'] 	= 0;
	$rs1->Seleciona("trata_mov","trata_arquivos",$whr);
	if($rs1->linhas==0){
		$dados['trata_cliarqEmp']	= $empresa;
		$dados['trata_cliarqarqid']	= $arquivo;
		$dados['trata_competencia']	= $compet;
		$fn->Audit("trata_arquivos", $whr, $dados, $empresa, $_SESSION['usu_cod'],7);
		if(!$rs_eve->Insere($dados, "trata_arquivos", $whr)){
			$result['status'] = "OK";
			$result['mensagem'] = "Arquivo ".$rs1->pegar("tarq_nome","tipos_arquivos","tarq_id=$arquivo")." marcado como DISPONÍVEL para a competência {$compet}!";
			$result['linhas'] = $rs1->linhas;

		}
		else{
			$result['status'] = "NOK";
			$result['mensagem'] = "Ocorreu um erro!";
		}
	}
	else{
		$fn->Audit("trata_arquivos", $whr, $dados, $empresa, $_SESSION['usu_cod'],1);
		if(!$rs_eve->Altera($dados, "trata_arquivos", $whr)){
			$result['status'] = "OK";
			$result['mensagem'] = "Movimento do Imposto ".$rs1->pegar("tarq_nome","tipos_arquivos","tarq_id=$arquivo")." marcado como DISPONÍVEL para a competência {$compet}!";
			$result['linhas'] = $rs1->linhas;
		}
		else{
			$result['status'] = "NOK";
			$result['mensagem'] = "Ocorreu um erro!";
		}
	}

echo json_encode($result);
exit;
}

if($acao == "exclui_mov"){
	$con = $per->getPermissao("cancela_fila", $_SESSION['usu_cod']);
	if($con["C"]==0){
		$result['status'] = "NOK";
		$result['mensagem'] = "Sem permissão para cancelar importação da fila!";
	}
	else{


		$whr = "trata_cliarqEmp = {$empresa} AND trata_cliarqarqid = {$arquivo} AND trata_competencia = '{$compet}'";

		$dados['trata_mov']		= 0;
		$dados['trata_movdata'] = date("Y-m-d H:i:s");
		$dados['trata_movpor'] 	= $_SESSION['usu_cod'];
		$dados['trata_status'] 	= 90;
		$rs1->Seleciona("*","trata_arquivos",$whr);
		if($rs1->linhas==0){
			$dados['trata_cliarqEmp']	= $empresa;
			$dados['trata_cliarqarqid']	= $arquivo;
			$dados['trata_competencia']	= $compet;
			$fn->Audit("trata_arquivos", $whr, $dados, $empresa, $_SESSION['usu_cod'],7);
			if(!$rs_eve->Insere($dados, "trata_arquivos", $whr)){
				$result['status'] = "OK";
				$result['mensagem'] = "Arquivo ".$rs1->pegar("tarq_nome","tipos_arquivos","tarq_id=$arquivo")." marcado como DISPONÍVEL para a competência {$compet}!";
				$result['linhas'] = $rs1->sql;
			}
			else{
				$result['status'] = "NOK";
				$result['mensagem'] = "Ocorreu um erro!";
			}
		}
		else{
			$rs1->GeraDados();
			if($rs1->fld("trata_status")==-2){
				$result['status'] = "OK";
				$result['mensagem'] = "Esse imposto já foi IMPORTADO pelo usuário ".$rs_eve->pegar("usu_nome","usuarios","usu_cod={$rs1->fld("trata_finpor")}");
				$result['linhas'] = $rs1->linhas;
			}
			else{
				$fn->Audit("trata_arquivos", $whr, $dados, $empresa, $_SESSION['usu_cod'],1);
				if(!$rs_eve->Altera($dados, "trata_arquivos", $whr)){
					$result['status'] = "OK";
					$result['mensagem'] = "Movimento do Arquivo ".$rs1->pegar("tarq_nome","tipos_arquivos","tarq_id=$arquivo")." marcado como NÃO!";
					$result['linhas'] = $rs1->linhas;
				}
				else{
					$result['status'] = "NOK";
					$result['mensagem'] = "Ocorreu um erro!";
				}
			}
				
		}
	}
echo json_encode($result);
exit;
}

if($acao == "disp_arquivo"){
	// Ver se a data do vencimento é maior que hoje
	$t_atual = $rs_eve->pegar("trata_finpor","trata_arquivos","trata_id=".$arq);
	$data = date("Y-m-d", strtotime((date("Y-m-")).$venc));
	$hoje = date("Y-m-d");
	$dados['trata_status'] 	= 92;
	$dados['trata_resp'] 	= (($data < $hoje && $t_atual==0)?$cart:$resp);
	$dados['trata_stdata'] 	= date("Y-m-d H:i:s");
	$whr = "trata_cliarqEmp = {$empresa} AND trata_id = {$arq} AND trata_competencia = '{$compet}'";

	if(!$rs_eve->Altera($dados,"trata_arquivos",$whr)){
		$result['status'] = "OK";
		$result['mensagem'] = "Arquivo {$arq} alterado!";
		
		$dados2 = array();
		$msg = "Arquivo disponibilizado!<br>";
		$dados2['traobs_obs']		= $msg.addslashes($obs);
		$dados2['traobs_trataId'] 	= $arq;
		$dados2['traobs_usuario'] 	= $_SESSION['usu_cod'];
		$dados2['traobs_data']		= date("Y-m-d H:i:s");
		$rs1->Insere($dados2, "trata_arquivos_obs");
	
	}
	else{
		$result['status'] = "NOK";
		$result['mensagem'] = "Ocorreu um erro!";
	}
echo json_encode($result);
exit;
}

if($acao == "fin_arquivo"){
	// Ver se a data do vencimento é maior que hoje
	$dados['trata_status'] 	= -2;
	$dados['trata_stdata'] 	= date("Y-m-d H:i:s");
	$whr = "trata_id=".$arq;
	if(!$rs_eve->Altera($dados,"trata_arquivos",$whr)){
		$result['status'] = "OK";
		$result['mensagem'] = "Arquivo {$arq} Finalizado!";
		$dados2 = array();
		$msg = "Arquivo Finalizado!<br>";
		$dados2['traobs_obs']		= $msg.addslashes($obs);
		$dados2['traobs_trataId'] 	= $arq;
		$dados2['traobs_usuario'] 	= $_SESSION['usu_cod'];
		$dados2['traobs_data']		= date("Y-m-d H:i:s");
		$rs1->Insere($dados2, "trata_arquivos_obs");
	}
	else{
		$result['status'] = "NOK";
		$result['mensagem'] = "Ocorreu um erro!";
	}
echo json_encode($result);
exit;
}

if($acao == "err_arquivo"){
	// Ver se a data do vencimento é maior que hoje
	$whr = "trata_id={$arq}";
	$dados['trata_erro'] 	= $rs_eve->pegar("trata_erro","trata_arquivos",$whr) + 1;
	$dados['trata_status'] 	= -1;
	$dados['trata_stdata'] 	= date("Y-m-d H:i:s");
	$whr = "trata_id=".$arq;
	if(!$rs_eve->Altera($dados,"trata_arquivos",$whr)){
		$result['status'] = "OK";
		$result['mensagem'] = "Arquivo {$arq} Contém Erros!";
		$dados2 = array();
		$msg = "Arquivo Devolvido para a Fila. Contém erros!<br>";
		$dados2['traobs_obs']		= $msg.addslashes($obs);
		$dados2['traobs_trataId'] 	= $arq;
		$dados2['traobs_usuario'] 	= $_SESSION['usu_cod'];
		$dados2['traobs_data']		= date("Y-m-d H:i:s");
		$rs1->Insere($dados2, "trata_arquivos_obs");
	}
	else{
		$result['status'] = "NOK";
		$result['mensagem'] = "Ocorreu um erro!";
	}
echo json_encode($result);
exit;
}