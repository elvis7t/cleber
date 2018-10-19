<?php

	session_start("portal");
	require_once("../model/recordset.php");
	require_once("../class/class.functions.php");
	require_once("../class/class.dashboard.php");
	require_once("../class/class.permissoes.php");
	date_default_timezone_set("America/Sao_Paulo");
	$fn = new functions();
	$fn2 = new dashboard();
	$rs = new recordset();
	$rs2 = new recordset();
	$per = new permissoes();


	$con = $per->getPermissao("minhas_metas.php",$_SESSION['usu_cod']);
?>
	<table class="table table-striped table-condensed" id="tblmetas">
		<thead>
			<tr>
				<th>#</th>
				<th>Colaborador</th>
				<th class="hidden-xs">Data Inicio</th>
				<th class="hidden-xs">Data Fim</th>
				<th class="hidden-xs">Criado por</th>
				<th>Real / Meta</th>
				<th>Progresso</th>
				<th>%</th>
				<th>A&ccedil;&otilde;es</th>
			</tr>	
		</thead>
		<tbody>
	<?php
		$sql = "SELECT a.*, b.usu_nome as Colab, c.usu_nome as Criador FROM metas a 
					JOIN usuarios b ON b.usu_cod = a.metas_colab
					JOIN usuarios c ON c.usu_cod = a.metas_criadopor 
				WHERE 1";
				
		
		/*-------------------------|ALTERAÇÃO|-------------------------*\
		|	Criando a condição para aprimorar a pesquisa caso 			|
		|	os filtros estejam vazios (entrada da página) 				|
		|	Fevereiro.2018 - Cleber Marrara Prado						|
		\*-------------------------------------------------------------*/
		/* se os GETS forem setados, adiciona pesquisa por filtro
		*/
		if(isset($_GET['dep']) && $_GET['dep']<>""){ 
			$sql.= " AND b.usu_dep = ".$_GET['dep'];
		}
		else{
			$sql.= " AND b.usu_dep = ".$_SESSION['dep'];	
		}
		
		if($con['C'] == 0){
			$sql.= " AND metas_colab = ".$_SESSION['usu_cod'];
		}
		else{
			if(isset($_GET['emp']) && $_GET['emp']<>""){ 
				$sql.= " AND a.metas_colab IN(".$_GET['emp'].")";
			}
		}
		
		if(isset($_GET['di']) && $_GET['di']<>""){ 
			$sql.= " AND metas_datafin >= '".$fn->data_usa($_GET['di'])." 00:00:00'";
		}
		else{
			$sql.= " AND metas_datafin >= '".date("Y-m-d")." 00:00:00'";
		}

		if(isset($_GET['df']) && $_GET['df']<>""){ 
			$sql.= " AND metas_datafin <= '".$fn->data_usa($_GET['df'])." 23:59:59'";
		}
		

		$sql.= " ORDER BY metas_datafin ASC";
		
		/*
		echo $sql;
		echo $con['C'];
		echo "<pre>";
		print_r($_SESSION);
		echo "</pre>";
		*/
		$rs->FreeSql($sql);
		$tarmetas = array();
		if($rs->linhas==0):
		echo "<tr><td colspan=9> Nenhuma meta listada...</td></tr>";
		else:

			while($rs->GeraDados()){
				$num_tar = $rs2->pegar("count(tarmetas_id)","tarmetas","tarmetas_metasId=".$rs->fld('metas_id'));
				$sql1 = "SELECT tarmetas_emp, tarmetas_obri, tarmetas_comp FROM tarmetas WHERE tarmetas_metasId=".$rs->fld('metas_id');
				$rs2->FreeSql($sql1);
				$i=0;
				while($rs2->GeraDados()){
					$i++;
					$tarmetas[$i]['emp'] = $rs2->fld('tarmetas_emp');
					$tarmetas[$i]['comp'] = $rs2->fld('tarmetas_comp');
					$tarmetas[$i]['obri'] = $rs2->fld('tarmetas_obri');
				}
				?>
				<tr>
					<td><?=$rs->fld('metas_id');?></td>
					<td><?=$rs->fld("Colab");?></td>
					<td class="hidden-xs"><?=$fn->data_br($rs->fld("metas_dataini"));?></td>
					<td class="hidden-xs"><?=$fn->data_br($rs->fld("metas_datafin"));?></td>
					<td class="hidden-xs"><?=$rs->fld("Criador");?></td>

					
						<?php
							$envi = 0;
							$noprazo=0;
							for($i=1; $i<=$num_tar; $i++){
								$sql3 = "SELECT (c.env_gerado+c.env_conferido) AS TOTAL, env_conferidodata
											FROM tarmetas a 
												JOIN metas b 				ON a.tarmetas_metasId = b.metas_id
												JOIN impostos_enviados c	ON a.tarmetas_obri = c.env_codImp
											WHERE 1 
												AND c.env_codEmp = ".$tarmetas[$i]['emp']." 
												AND c.env_compet = '".$tarmetas[$i]['comp']."' 
												AND c.env_codImp = ".$tarmetas[$i]['obri']."
											GROUP BY c.env_codEmp;";
								//echo $sql3."<br>";
								$rs2->FreeSql($sql3);
								if($rs2->linhas > 0){
									$rs2->GeraDados();
									$envi +=$rs2->fld("TOTAL");
									
								}
								/*APRIMORAMENTO - SOLICITADO POR ADEMIR em 10/10/2018
								Mostrar "FORA DO PRAZO" quando a tarefa for concluída após a data da meta
								*/
								
								$sql3 = "SELECT (c.env_gerado+c.env_conferido) AS TOTAL,  env_conferidodata
											FROM tarmetas a 
												JOIN metas b 				ON a.tarmetas_metasId = b.metas_id
												JOIN impostos_enviados c	ON a.tarmetas_obri = c.env_codImp
											WHERE 1 
												AND env_conferidodata <= '".$rs->fld("metas_datafin")." 23:59:59'
											 	AND c.env_codEmp = ".$tarmetas[$i]['emp']." 
												AND c.env_compet = '".$tarmetas[$i]['comp']."' 
												AND c.env_codImp = ".$tarmetas[$i]['obri']."
											GROUP BY c.env_codEmp;";
								//echo $sql3."<br>";
								$rs2->FreeSql($sql3);
								if($rs2->linhas > 0){
									$rs2->GeraDados();
									$noprazo +=$rs2->fld("TOTAL");
								}
								

							}
							$res = (( $num_tar>0 ? $envi/($num_tar*2) : 1 ))*100;
							$cor = $fn->getColor($res);
							$cor2 = $fn->getColor($res,"bd");
							//echo $cor;
							//echo number_format($res,2);
						?>
					<td><?=sprintf('%03d',$envi)." / ".sprintf('%03d',$num_tar*2);?></td>
					<td>
						<div id="pgb_status" class="progress progress-md <?=($res==100?"":"progress-striped");?> active">
							<div class="progress-bar progress-bar-<?=$cor;?>" role="progressbar" aria-valuenow="<?=$res;?>" aria-valuemin="0" aria-valuemax="100" style="width:<?=$res;?>%;">
								<?=($noprazo < $envi?"Fora do Prazo":"");?>
								
							</div>
						</div>
					</td>


					<td><span class="badge bg-<?=$cor2;?>"><?=number_format($res,1)."%";?></span></td>
					<td class="">
						<a class="btn btn-xs btn-info" target="_blank" href="lista_metas.php?token=<?=$_SESSION['token'];?>&lista=<?=$rs->fld('metas_id');?>"><i class="fa fa-search"></i></a>

					</td>
				</tr>
			<?php  
			}
		endif;		
		?>
		</tbody>
	</table>
<script src="<?=$hosted;?>/sistema/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>	
<script src="<?=$hosted;?>/sistema/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/datatables/dataTables.bootstrap.min.js"></script> 

<script>
	$(document).ready(function(){
		$('#tblmetas').DataTable({
			"order": [[ 2, "asc" ],[1,"asc"]],
			"columnDefs": [{
			"defaultContent": "-",
			"targets": "_all"
			}]
		});
	});

	setTimeout(function(){
		//$("#slc").load("meus_chamados.php");		
		$("#alms").load(location.href+" #almsg");
	 },10500);
</script>