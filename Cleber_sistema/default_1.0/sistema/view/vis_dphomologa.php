<?php
	session_start();
	require_once("../model/recordset.php");
	require_once("../class/class.functions.php");
	date_default_timezone_set("America/Sao_Paulo");
	require_once('../class/class.permissoes.php');

	$per = new permissoes();
	$fn = new functions();
	$rs = new recordset();
	$rs2 = new recordset();
	$pag = $_SERVER['SCRIPT_NAME'];
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
	<table class="table table-striped table-condensed">
		<thead>
			<tr>
				<th>#</th>
				<th>Homologado</th>
				<th class="hidden-xs">Solic. por</th>
				<th class="hidden-xs">Tratado por</th>
				<th class="hidden-xs">Data</th>
				<th class="hidden-xs">Hora</th>
				<th>Status</th>
				<th class="hidden-xs">SLA</th>
				<th>A&ccedil;&otilde;es</th>
			</tr>
		</thead>	
<?php
	$sql = "SELECT *, b.usu_nome nmb, c.usu_nome nmc FROM homologacoes a
				JOIN usuarios b ON a.hom_cadpor = b.usu_cod
				LEFT JOIN usuarios c ON a.hom_realpor = c.usu_cod
				JOIN codstatus d ON d.st_codstatus = a.hom_status
			WHERE hom_empvinculo = {$_SESSION["sys_id"]}
			";
	
	/*-------------------------|ALTERAÇÃO|-------------------------*\
	|	Criando a condição para aprimorar a pesquisa caso 			|
	|	os filtros estejam vazios (entrada da página) 				|
	|	27.10.2016 - Cleber Marrara Prado 							|
	\*-------------------------------------------------------------*/
		// se os GETS forem setados, adiciona pesquisa por filtro
	if(isset($_GET['user']) && $_GET['user']<>""){ $sql.= "AND hom_cadpor = '".$_GET['user']."'";}
	if(isset($_GET['dtini']) && $_GET['dtini']<>""){ $sql.= "AND hom_data >= '".$fn->data_usa($_GET['dtini'])." 00:00:00'";}
	if(isset($_GET['dtfim']) && $_GET['dtfim']<>""){ $sql.= "AND hom_data <= '".$fn->data_usa($_GET['dtfim'])." 23:59:59'";}
	if(isset($_GET['status']) && $_GET['status']<>""){ $sql.= "AND hom_status = ".$_GET['status'];} else{ /*$sql.= " AND a.hom_status <> 99";*/}
	
	$sql.= " ORDER BY hom_status DESC, hom_datahom ASC";
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
				<td><?=$rs->fld('hom_id');?></td>
				<td><?=$rs->fld("hom_empregado");?></td>
				<td class="hidden-xs"><?=$rs->fld("nmb");?></td>
				<td class="hidden-xs"><?=$rs->fld("nmc");?></td>
				<td class="hidden-xs"><?=$fn->data_br($rs->fld("hom_datahom"));?></td>
				<td class="hidden-xs"><?=$rs->fld("hom_horario");?></td>
				<td><?=$rs->fld("st_desc");?></td>
				<td class="hidden-xs">
					<?php
					echo ($rs->fld("hom_realdata")<>0?$fn->calc_dh($rs->fld("hom_data"), $rs->fld("hom_realdata")):"-");
					?>	
				</td>
				<td class="">
					<a 	href="atende_homol.php?token=<?=$_SESSION['token'];?>&homol=<?=$rs->fld('hom_id');?>&acao=1"
						class="btn btn-xs btn-info"
						data-toggle='tooltip' 
						 data-placement='bottom' 
						 title='Atender Homologa&ccedil;&atilde;o'><i class="fa fa-search"></i>
					</a>
				<?php
					if($rs->fld("hom_status")==94){ ?>
					<a 	href="homol_checks.php?token=<?=$_SESSION['token'];?>&homol=<?=$rs->fld('hom_id');?>"
						class="btn btn-xs btn-primary"
						data-toggle='tooltip' 
						data-placement='bottom' 
						title='Check-List dos Documentos' target="_blank"><i class="fa fa-print"></i>
					</a>
					<button
						class="btn btn-xs btn-success"
						onclick="javascript:baixa(<?=$rs->fld('hom_id');?>,'chkHomol','Marcar como realizado a homologação')"
						data-toggle='tooltip' 
						data-placement='bottom' 
						title='Marcar como Feito' target="_blank"><i class="fa fa-check"></i>
					</button>
				<?php 
				} 
				
				$exchm = $per->getPermissao("homologa",$_SESSION['usu_cod']);
				if($exchm['E']==1){
					if(($rs->fld("hom_status")<>90) AND ($rs->fld("hom_status")<>99)){ ?>
						<button type="button"
							class="btn btn-xs btn-danger"
							data-toggle='tooltip' 
							data-placement='bottom'
							id="bt_exchom"
							title='Excluir Solicita&ccedil;&atilde;o' target="_blank"
							onclick="javascript:del(<?=$rs->fld('hom_id');?>,'excHomol','a homologação')"><i class="fa fa-trash"></i>
						</button>
				<?php 
					}
				}				
				?>
					
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
