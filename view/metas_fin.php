<?php
	session_start();
	require_once("../../model/recordset.php");
	require_once("../../sistema/class/class.functions.php");
	require_once("../class/class.dashboard.php");
	date_default_timezone_set("America/Sao_Paulo");
	$fn = new functions();
	$fn2 = new dashboard();
	$rs = new recordset();
	$rs2 = new recordset();
?>
<!--
	<div class=" col-md-12">
		<form role="form" class="form form-inline" method="GET">
			<div class="form-group col-xs-3">
				Data Inicial:<br>
				<input type="text" name="di" class="form-control input-sm col-md-3" />
			</div>
			
			<div class="form-group col-xs-3">
				Data Final: <br>
				<input type="text" name="di" class="form-control input-sm col-md-3" />
			
			</div>
			<div class="form-group col-xs-3">
				<button type="submit" class="btn btn-info"><i class="fa fa-search"></i> Pesquisar</button>
			</div>					
		</form>
	</div>
-->
	<table class="table table-stripe table-condensed">
		<thead>
			<tr>
				<th>#</th>
				<th>Colaborador</th>
				<th class="hidden-xs">Data Inicio</th>
				<th class="hidden-xs">Data Fim</th>
				<th class="hidden-xs" title="Service Labor Agreement - Acordo de tempo de Serviço">Criado por</th>
				<th>Progresso</th>
				<th>A&ccedil;&otilde;es</th>
			</tr>	
		</thead>
		<tbody>
	<?php
		$sql = "SELECT a.*, b.usu_nome as Colab, c.usu_nome as Criador FROM metas a 
					JOIN usuarios b ON b.usu_cod = a.metas_colab
					JOIN usuarios c ON c.usu_cod = a.metas_criadopor 
				WHERE metas_datafin < '".date('Y-m-d')." 00:00:00'";
				
		
		/*-------------------------|ALTERAÇÃO|-------------------------*\
		|	Criando a condição para aprimorar a pesquisa caso 			|
		|	os filtros estejam vazios (entrada da página) 				|
		|	27.10.2016 - Cleber Marrara Prado 							|
		\*-------------------------------------------------------------*/
		/* se os GETS forem setados, adiciona pesquisa por filtro
		if(isset($_GET['user']) && $_GET['user']<>""){ $sql.= " AND cham_solic = '".$_GET['user']."'";}
		if(isset($_GET['dtini']) && $_GET['dtini']<>""){ $sql.= " AND cham_abert >= '".$fn->data_usa($_GET['dtini'])." 00:00:00'";}
		if(isset($_GET['dtfim']) && $_GET['dtfim']<>""){ $sql.= " AND cham_abert <= '".$fn->data_usa($_GET['dtfim'])." 23:59:59'";}
		if(isset($_GET['tarefa']) && $_GET['tarefa']<>""){ $sql.= " AND cham_task like '%".$_GET['tarefa']."%'";}
		if(isset($_GET['status']) && $_GET['status']<>""){ $sql.= " AND cham_status = 99";} else{ $sql.=" AND cham_status<>99";}
		*/
		if($_SESSION["classe"]<>1 && $_SESSION['lider']=="N"){ $sql.=" AND metas_colab = ".$_SESSION['usu_cod'];}
		$sql.= " ORDER BY metas_id ASC";
		/*
		echo $sql;
		echo "<pre>";
		print_r($_SESSION);
		echo "</pre>";
		*/
		$rs->FreeSql($sql);
		$tarmetas = array();
		if($rs->linhas==0):
		echo "<tr><td colspan=7> Nenhuma meta anterior à hoje</td></tr>";
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
					
					<td>
						<?php
							$envi = 0;
							for($i=1; $i<=$num_tar; $i++){
								$sql3 = "SELECT (c.env_enviado+c.env_gerado+c.env_conferido) AS TOTAL
											FROM tarmetas a 
												JOIN metas b 				ON a.tarmetas_metasId = b.metas_id
												JOIN impostos_enviados c	ON a.tarmetas_obri = c.env_codImp
											WHERE env_data <= '".$rs->fld("metas_datafin")." 23:59:59'
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
							}
							$res = ($envi/($num_tar*3))*100;
							$cor = $fn2->getColor($res);
							//echo number_format($res,2);
						?>
						<div id="pgb_status" class="progress progress-md <?=($res==100?"":"progress-striped");?>">
							<div class="progress-bar progress-bar-<?=$cor;?>" role="progressbar" aria-valuenow="<?=$res;?>" aria-valuemin="0" aria-valuemax="100" style="width:<?=$res;?>%;">
								<span class=""><?=number_format($res,2)."% (".($res==100?"Completo":"Não concluído").")";?></span>
							</div>
						</div>
						
					</td>
					<td class="">
						<a class="btn btn-xs btn-info" href="lista_metas.php?token=<?=$_SESSION['token'];?>&lista=<?=$rs->fld('metas_id');?>"><i class="fa fa-search"></i></a>

					</td>
				</tr>
			<?php  
			}
		endif;		
		?>
		</tbody>
	</table>
<script>
	$(document).ready(function () {
			$('[data-toggle="tooltip"]').tooltip();
			$('[data-toggle="popover"]').popover();
	});


	setTimeout(function(){
		//$("#slc").load("meus_chamados.php");		
		$("#alms").load(location.href+" #almsg");
	 },10500);
</script>