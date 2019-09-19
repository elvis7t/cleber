<div class="row">
	<div class="col-md-12">
		<div class="box box-success" id="firms">
			<div class="box-header with-border">
				<h3 class="box-title">Canais de Comunicação</h3>
				<small>[<?=$cod ." - ".$rs->pegar("empresa","tri_clientes","cod = ".$cod);?>]</small>
			</div><!-- /.box-header -->
			<div id="slc" class="box-body">
			<?php
				session_start();
				require_once("../../model/recordset.php");
				require_once("../../sistema/class/class.functions.php");
				date_default_timezone_set("America/Sao_Paulo");
				$fn = new functions();
				$rs = new recordset();
				$rs2 = new recordset();
			?>

				<table class="table table-striped" id="empr">
					<tr>
						<th>Assunto</th>
						<th class="hidden-xs">Usu&aacute;rio</th>
						<th>Data:</th>
						<th class="hidden-xs">Depto.</th>
						<th class="hidden-xs">Status</th>
						<th>A&ccedil;&otilde;es</th>
					</tr>	
			<?php
				$sql = "SELECT * FROM comunicacao WHERE com_cod=".$cod;
				$rs->FreeSql($sql);
				//echo $rs->sql;
				if($rs->linhas==0):
				echo "<tr><td colspan=7> Nenhuma solicita&ccedil;&atilde;o...</td></tr>";
				else:
					while($rs->GeraDados()){
					?>
						<tr>
							<td><?=$rs->fld("com_canal");?></td>
							<td><?=$rs2->pegar("usu_nome","usuarios","usu_cod=".$rs->fld("com_usu"));?></td>
							<td class="hidden-xs"><?=$fn->data_hbr($rs->fld("com_data"));?></td>
							<td class="hidden-xs"><?=$rs2->pegar("dep_nome","departamentos","dep_id=".$rs->fld("com_depto"));?></td>
							<td><?=($rs->fld("com_ativo")==1?"Ativo":"Inativo");?></td>
							
							<td class="">
								<a class='btn btn-xs btn-primary' data-toggle='tooltip' data-placement='bottom' title='Alterar' href="form_comunic.php?token=<?=$_SESSION['token']?>&clicod=<?=$rs->fld('com_cod')?>&com_id=<?=$rs->fld('com_id')?>">
								<i class='fa fa-search'></i> </a>
								<a class="btn btn-xs btn-danger" data-toggle='tooltip' data-placement='bottom' title='Excluir' href="javascript:del(<?=$rs->fld('cod');?>,'excEmpresa','a empresa');"><i class="fa fa-trash"></i></a>
							</td>
						</tr>
					<?php  
					}
					echo "<tr><td colspan=7><strong>".$rs->linhas." Comunica&ccedil;&atilde;o(&otilde;es)</strong></td></tr>";
				endif;		
				?>
			</table>
			</div>
			<div class="box-footer">
				<a class='btn btn-sm btn-success' data-toggle='tooltip' data-placement='bottom' title='Nova Comunica&ccedil;o' href="form_comunic.php?token=<?=$_SESSION['token']?>&clicod=<?=$cod;?>"><i class="fa fa-plus"></i> Nova</a>
			</div>
		</div><!-- ./box -->
	</div><!-- ./col -->
</div>
 
<script src="<?=$hosted;?>/sistema/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/datatables/dataTables.bootstrap.min.js"></script> 
<script>
// Atualizar a cada 10 segundos
/*------------------------|INICIA TOOLTIPS E POPOVERS|---------------------------------------*/

setTimeout(function(){
	$("#alms").load(location.href+" #almsg");
},10500);

</script>