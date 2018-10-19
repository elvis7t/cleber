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
	<table class="table table-striped table-condensed" id="listam">
		<thead>
			<tr>
				<th><input type="checkbox" class="listados"></th>
				<th>Lista #</th>
				<th>Colaborador</th>
				<th>Empresa</th>
				<th class="hidden-xs">Obrigacao</th>
				<th class="hidden-xs">Competencia</th>
				<th>Progresso</th>
				<th>A&ccedil;&otilde;es</th>
				
			</tr>	
		</thead>
		<tbody>
	<?php
		$lista = $_GET['lista'];
		$sql = "SELECT a.*, c.imp_nome as Imposto, d.apelido as Empresa, d.cod as Codigo, b.metas_dataini, b.metas_datafin, e.usu_nome FROM tarmetas a
					JOIN metas b ON b.metas_id = a.tarmetas_metasId
					JOIN tipos_impostos c ON c.imp_id = a.tarmetas_obri
					JOIN tri_clientes d ON d.cod = a.tarmetas_emp
					JOIN usuarios e ON e.usu_cod = b.metas_colab
				WHERE tarmetas_metasId = {$lista}";
				
		
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
		$sql.= " ORDER BY Empresa ASC, Imposto ASC";
		/*
		echo $sql;
		echo "<pre>";
		print_r($_SESSION);
		echo "</pre>";
		*/
		$rs->FreeSql($sql);
		
		$con =$per->getPermissao("metas.php", $_SESSION['usu_cod']);
		if($rs->linhas==0):
		echo "<tr><td colspan=7> Nenhuma solicita&ccedil;&atilde;o...</td></tr>";
		else:
			while($rs->GeraDados()){
				$emp = $rs->fld("tarmetas_emp");
				$imp = $rs->fld("tarmetas_obri");
				$com = $rs->fld("tarmetas_comp");
				$sql1 = "SELECT a.env_gerado, a.env_conferido, a.env_enviado, env_conferidodata FROM  impostos_enviados a 
						 WHERE a.env_codImp = ".$imp." 
						 AND a.env_compet = '".$com."' 
						 AND a.env_codEmp = ".$emp;
				if(isset($_GET['sem']) AND $_GET['sem']==1){
					$sql1.=" AND a.env_conferidodata BETWEEN '".$rs->fld("metas_dataini")." 00:00:00' AND '".$rs->fld("metas_datafin")." 23:59:59';";
				}
				//echo $sql1."<br>";		 
				$num = 0;
				$rs2->FreeSql($sql1);
				if($rs2->linhas > 0){
					$rs2->GeraDados();
					$num = $rs2->fld("env_gerado")+$rs2->fld("env_conferido")+$rs2->fld("env_enviado");
				}
				$res = ($num / 3)*100;
				$cor = $fn2->getColor($res);

				$p = strtotime($rs->fld("metas_datafin")." 23:59:59");
				$c = strtotime($rs2->fld("env_conferidodata"));

				if($c > $p ){
					$color="danger";
				}
				else{$color="";}

				?>
				<tr class="<?=$color;?>">
					<td><input type="checkbox" name="listados[]" class="list_tar" value="<?=$rs->fld('tarmetas_id');?>"></td>
					<td><?=$rs->fld('tarmetas_metasId');?></td>
					<td><?=$rs->fld('usu_nome');?></td>
					<td><?=str_pad($rs->fld('Codigo'),3,"000",STR_PAD_LEFT)." - ".$rs->fld('Empresa');?></td>
					<td><?=$rs->fld("Imposto");?></td>
					<td class="hidden-xs"><?=$rs->fld("tarmetas_comp");?></td>
					<td class="hidden-xs">
						
						<div id="pgb_status" class="progress progress-md <?=($res==100?"":"progress-striped");?> active">
							<div class="progress-bar progress-bar-<?=$cor;?>" role="progressbar" aria-valuenow="<?=$res;?>" aria-valuemin="0" aria-valuemax="100" style="width:<?=$res;?>%;">
								<span class=""><?=number_format($res,2)."% (".($res==100?"Completo":"Em processo").")";?></span>
							</div>
						</div>
						
					<td>
						<a class="btn btn-xs btn-primary" title="Ver Ocorr&ecirc;ncias" href="metas_ocorrencias.php?token=<?=$_SESSION['token'];?>&tarefa=<?=$rs->fld('tarmetas_id');?>">
							<i class="fa fa-search"></i> 
							<small>(<?=$rs2->pegar("count(metasobs_id)","metas_ocorrencias","metasobs_tarId=".$rs->fld('tarmetas_id'));?>)
						</a>
						<?php
						if($con['E']==1): ?>
							<a class="btn btn-xs btn-danger" title="Excluir Meta da Lista" href="javascript:baixa(<?=$rs->fld('tarmetas_id');?>,'exc_metalista','Deseja excluir a meta');">
								<i class="fa fa-trash"></i>
							</a>
						<?php endif;?>
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
		$('.listados').on('change', function() {
   			$('.list_tar').prop('checked', this.checked);
		})

		$('#listam').DataTable({
			"columnDefs": [{
			"defaultContent": "-",
			"targets": "_all"
			}]
		});
	});
</script>