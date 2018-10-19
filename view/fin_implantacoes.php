<?php
	session_start("portal");
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
				<th>Empresa</th>
				<th>Obs.</th>
				<th class="hidden-xs">Tratado por</th>
				<th class="hidden-xs">Data</th>
				<th>Status</th>
				<th>Valor</th>
				<th class="hidden-xs">Gerar boletos?</th>
				<th>A&ccedil;&otilde;es</th>
			</tr>
		</thead>	
<?php
	$sql = "SELECT *, b.usu_nome nmb, c.usu_nome nmc FROM implantacoes a
				JOIN usuarios b ON a.impla_cadpor = b.usu_cod
				LEFT JOIN usuarios c ON a.impla_realpor = c.usu_cod
				JOIN codstatus d ON d.st_codstatus = a.impla_status
				JOIN tri_clientes e ON a.impla_empresa = e.cod
			WHERE impla_vinc = {$_SESSION["sys_id"]}
			";
	
	/*-------------------------|ALTERAÇÃO|-------------------------*\
	|	Criando a condição para aprimorar a pesquisa caso 			|
	|	os filtros estejam vazios (entrada da página) 				|
	|	27.10.2016 - Cleber Marrara Prado 							|
	\*-------------------------------------------------------------*/
		// se os GETS forem setados, adiciona pesquisa por filtro
	if(isset($_GET['user']) && $_GET['user']<>""){ $sql.= "AND impla_cadpor = '".$_GET['user']."'";}
	if(isset($_GET['dtini']) && $_GET['dtini']<>""){ $sql.= "AND impla_data >= '".$fn->data_usa($_GET['dtini'])." 00:00:00'";}
	if(isset($_GET['dtfim']) && $_GET['dtfim']<>""){ $sql.= "AND impla_data <= '".$fn->data_usa($_GET['dtfim'])." 23:59:59'";}
	$sql.= " AND a.impla_status = 99";
	
	$sql.= " ORDER BY impla_dtbol ASC, impla_valor ASC";
	/*
	echo $sql;
	echo "<pre>";
	print_r($_SESSION);
	echo "</pre>";
	*/
	$rs->FreeSql($sql);
	$soma = 0;
	if($rs->linhas==0):
	echo "<tr><td colspan=7> Nenhuma solicita&ccedil;&atilde;o...</td></tr>";
	else:
		while($rs->GeraDados()){
			if($rs->fld("impla_dtbol")==1){
				$soma+=$rs->fld("impla_valor");
			}
			?>
			<tr>
				<td><?=$rs->fld('impla_id');?></td>
				<td><?=$rs->fld("impla_empresa")." - ".$rs->fld("apelido");?></td>
				<td><?=$rs->fld("impla_obs")?></td>
				<td class="hidden-xs"><?=$rs->fld("nmc");?></td>
				<td class="hidden-xs"><?=$fn->data_hbr($rs->fld("impla_data"));?></td>
				<td><?=$rs->fld("st_desc");?></td>
				<td>R$<?=number_format($rs->fld("impla_valor"),2,",",".");?></td>
				<td class="text-<?=($rs->fld("impla_dtbol")==1?"green":"red");?>">
					<strong><center><?=($rs->fld("impla_dtbol")==1?"Sim":"Não");?></center></strong>
				</td>
				<td class="">
					<a 	href="atende_impla.php?token=<?=$_SESSION['token'];?>&impla=<?=$rs->fld('impla_id');?>&acao=1"
						class="btn btn-xs btn-info"
						data-toggle='tooltip' 
						 data-placement='bottom' 
						 title='Ver Implanta&ccedil;&atilde;o'><i class="fa fa-search"></i>
					</a>
					
					
				</td>
			</tr>
		<?php  
		}
	endif;		
	?>
	<tr>
		<th colspan=5><?=($rs->linhas<>0?$rs->linhas:"Nenhum");?> registro(s) encontrado(s)</th>
		<th>Total:</th>
		<th>R$<?=number_format($soma,2,",",".");?></th>
		<th colspan=2></th>
	</tr>
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
