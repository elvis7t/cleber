<?php
	session_start("portal");

	require_once("../class/class.functions.php");
	date_default_timezone_set("America/Sao_Paulo");
	require_once("../class/class.permissoes.php");
	$fn = new functions();
	$rs = new recordset();
	$rs2 = new recordset();
	$per = new permissoes();
	$con = $per->getPermissao("sol_mat.php", $_SESSION['usu_cod']);

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
		<tr>
			<th>#</th>
			<th class="hidden-xs">Material</th>
			<th class="hidden-xs">Opera&ccedil;&atilde;o</th>
			<th class="hidden-xs">Sol. h&aacute;</th>
			<th class="hidden-xs">Entregue em:</th>
			<th class="hidden-xs">Quant.</th>
			<th class="hidden-xs">Status</th>
			<th>Solic Por</th>
			<th class="hidden-xs">Realizado Por</th>
			<th>A&ccedil;&otilde;es</th>
		</tr>	
<?php
	$sql = "SELECT a.*, c.mcad_desc, d.usu_nome AS nomeSol, e.usu_nome AS nomeDes, d.usu_cod AS codSol, f.st_codstatus  FROM mat_historico a 
				JOIN mat_cadastro c ON a.mat_cadId = c.mcad_id 
				LEFT JOIN usuarios d ON a.mat_usuSol = d.usu_cod 
				LEFT JOIN usuarios e ON a.mat_usuDisp = e.usu_cod 
			   	JOIN codstatus f ON a.mat_status = f.st_codstatus

			WHERE a.mat_empcod = 2 AND  mat_lista IS NULL";
				
	if($con['I']==0){
		$sql.=" AND mat_usuSol=".$_SESSION['usu_cod']." AND mat_operacao='O'";
	}
	
	
		
	$sql.=" AND mat_status<>90 GROUP BY mat_id ORDER BY mat_status ASC, mat_id DESC";
	$rs->FreeSql($sql);
	//echo $rs->sql;
	/*
	echo "<pre>";
	print_r($con);
	echo "</pre>";
	*/
	if($rs->linhas==0):
	echo "<tr><td colspan=8> Nenhuma solicita&ccedil;&atilde;o...</td></tr>";
	else:
		while($rs->GeraDados()){
			?>
			<tr>
				<td><?=$rs->fld("mat_id");?></td>
				<td class="hidden-xs"><?=$rs->fld("mcad_desc");?></td>
				<td class="hidden-xs"><?=($rs->fld("mat_operacao")=="I"?"Compra":"Solicita&ccedil;&atilde;o");?></td>
				<td class="hidden-xs"><?=$fn->calc_dh($rs->fld("mat_data"));?></td>
				<td class="hidden-xs"><?=($rs->fld("mat_entregue")<>0?$fn->simple_horas_uteis($rs->fld("mat_data"),$rs->fld("mat_entregue")):"-");?></td>
				<td class="hidden-xs"><?=$rs->fld("mat_qtd");?></td>
				<td class="hidden-xs"><?=($rs->fld("st_codstatus")==0?'<span class="text-danger"><i class="fa fa-hourglass-start"></i></span>':'<span class="text-success"><i class="fa fa-check-square-o"></i></span>');?></td>
				<td class="hidden-xs"><?=$rs->fld("nomeSol");?></td>
				<td><?=$rs->fld("nomeDes");?></td>
				<td class="">
					<?php if($rs->fld("mat_status")==0){ ?> 
					<a 	class="btn btn-danger btn-xs" 	
						data-toggle='tooltip' 
						data-placement='bottom' 
						title='N&aacute;o Entregue'
						a href="javascript:baixa(<?=$rs->fld("mat_id");?>,'neg_mat','Deseja cancelar o pedido');">
						<i class="fa fa-thumbs-o-down"></i>
					</a> 
					<?php 
						if($_SESSION["classe"]<=4 OR $_SESSION['usu_cod'] <> $rs->fld("codSol")){?>
							<a 	class="btn btn-success btn-xs"
								data-toggle='tooltip' 
								data-placement='bottom' 
								title='Entregue'
								a href="javascript:baixa(<?=$rs->fld("mat_id");?>,'ent_mat','Deseja entregar o material do pedido');">
								<i class="fa fa-thumbs-o-up"></i>
							</a>
						 <?php
						 } 
					?>
					 
					<?php 
					}
					?>
					<a class='btn btn-xs btn-primary' data-toggle='popover' data-trigger="hover" data-placement='auto right' data-content="<?=$rs->fld("mat_obs");?>" title='Solicitante: <?=$rs->fld("nomeSol");?>'><i class='fa fa-book'></i> </a>
				</td>
			</tr>
		<?php  
		}
		echo "<tr><td colspan=8><strong>".$rs->linhas." Solicita&ccedil;&otilde;es</strong></td></tr>";
	endif;
	/* DEBUG	
	echo "<pre>";
	print_r($_SESSION);
	echo "</pre>";
	*/
	?>
</table>
<script src="<?=$hosted;?>/sistema/js/functions.js"></script>
<script type="text/javascript">
// Atualizar a cada 10 segundos
	 
	

	 /*------------------------|INICIA TOOLTIPS E POPOVERS|---------------------------------------*/
		$(function () {
			$('[data-toggle="tooltip"]').tooltip();
			$('[data-toggle="popover"]').popover({
		        html:true,
		        container: 'table'
		    });
		});
		setTimeout(function(){
			$("#slc").load("vis_solmat.php");		
		 },7500);

	

</script>


			