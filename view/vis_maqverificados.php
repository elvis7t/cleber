<?php
	session_start();
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
	<table class="table table-striped table-condensed" id="maq_verif">
		<thead>
			<tr>
				<th>#</th>
				<th>M&aacute;quina</th>
				<th class="hidden-xs">IP</th>
				<th class="hidden-xs">Sistema</th>
				<th class="hidden-xs">Usu&aacute;rio</th>
				<th>A&ccedil;&otilde;es</th>
			</tr>
		</thead>
		<tbody>
	<?php
		$sql = "SELECT * FROM listados a 
					JOIN maquinas b ON a.lver_maquina = b.maq_id
					JOIN usuarios c ON b.maq_user = c.usu_cod
					JOIN lista_verificacao d ON a.lver_listaId = d.lista_id
				WHERE lver_listaId = ".$_GET['lista'];
				
		
		$sql.= " ORDER BY lver_maquina ASC";
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
					<td><?=$rs->fld('lver_id');?></td>
					<td><?=$rs->fld("maq_usuario");?></td>
					<td><?=$rs->fld("maq_ip");?></td>
					<td><?=$rs->fld("maq_sistema");?></td>
					<td class="hidden-xs"><?=$rs->fld("usu_nome");?></td>
					
					<td class="">
						<a class="btn btn-xs btn-info" href="vis_maqresp.php?token=<?=$_SESSION['token'];?>&lista=<?=$rs->fld('lver_listaId');?>&emp=<?=$rs->fld('lista_empresa');?>&ver=<?=$rs->fld('lver_id');?>"><i class="fa fa-search"></i></a>

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
// Atualizar a cada 10 segundos
	 
	

	 /*------------------------|INICIA TOOLTIPS E POPOVERS|---------------------------------------*/
		$(function () {
			$('[data-toggle="tooltip"]').tooltip();
			$('[data-toggle="popover"]').popover();

			$('#maq_verif').DataTable({
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


			