<?php
	require_once("../model/recordset.php");
	require_once("../class/class.functions.php");
	date_default_timezone_set("America/Sao_Paulo");
	$fn = new functions();
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
	<table class="table table-striped">
		<tr>
			<th>#</th>
			<th>Empresa</th>
			<th class="hidden-xs">Competencia</th>
			<th class="hidden-xs">Maquinas</th>
			<th>Status</th>
			<th class="hidden-xs" title="Service Labor Agreement - Acordo de tempo de Serviço">SLA</th>
			<th>A&ccedil;&otilde;es</th>
		</tr>	
	<?php
		$sql = "SELECT * FROM lista_verificacao 
					JOIN tri_clientes b ON b.cod = lista_empresa
				WHERE 1";
				
		
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
		$sql.= " ORDER BY lista_id ASC";
		/*
		echo $sql;
		echo "<pre>";
		print_r($_SESSION);
		echo "</pre>";
		*/
		$rs->FreeSql($sql);
		
		if($rs->linhas==0):
		echo "<tr><td colspan=7> Nenhuma solicita&ccedil;&atilde;o...</td></tr>";
		else:
			while($rs->GeraDados()){
				?>
				<tr>
					<td><?=$rs->fld('lista_id');?></td>
					<td><?=$rs->fld("empresa");?></td>
					<td class="hidden-xs" align="middle"><?=$rs->fld("lista_compet");?></td>
					<td class="hidden-xs" align="middle"><?=$rs2->pegar("count('lver_id')","listados","lver_listaId = ".$rs->fld('lista_id'));?></td>
					
					<td align="middle"></i></td>
					<td class="hidden-xs">
						<?php
							echo ($rs->fld("lista_datafin")<>0?$fn->simple_horas_uteis($rs->fld("lista_datacad"), $rs->fld("lista_datafin")):"-");
						?>	
					</td>
					<td class="">
						<a class="btn btn-xs btn-primary" href="new_checkitems.php?token=<?=$_SESSION['token'];?>&lista=<?=$rs->fld('lista_id');?>&emp=<?=$rs->fld('cod');?>"><i class="fa fa-plus"></i></a>
						<a class="btn btn-xs btn-info" href="vis_verificados.php?token=<?=$_SESSION['token'];?>&lista=<?=$rs->fld('lista_id');?>&emp=<?=$rs->fld('cod');?>"><i class="fa fa-search"></i></a>

					</td>
				</tr>
			<?php  
			}
		endif;		
		?>
	</table>
<script>
// Atualizar a cada 10 segundos
	 
	

	 /*------------------------|INICIA TOOLTIPS E POPOVERS|---------------------------------------*/
		$(function () {
			$('[data-toggle="tooltip"]').tooltip();
			$('[data-toggle="popover"]').popover();
		});


		setTimeout(function(){
			//$("#slc").load("meus_chamados.php");		
			$("#alms").load(location.href+" #almsg");
		 },10500);

	

</script>


			