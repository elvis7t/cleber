<div class="row">
	<div class="col-md-12">
		<div class="box box-success" id="firms">
			<div class="box-header with-border">
				<h3 class="box-title">Particularidades Cadastradas</h3>
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
						<th>Titulo</th>
						<th class="hidden-xs">Usu&aacute;rio</th>
						<th>Data:</th>
						<th class="hidden-xs">Depto.</th>
						<th class="hidden-xs">Tipo</th>
						<th class="hidden-xs">Status</th>
						<th>A&ccedil;&otilde;es</th>
					</tr>	
			<?php
				$cod = (isset($_GET['clicod']) ? $_GET['clicod'] : 477);
				$sql = "SELECT * FROM particularidades WHERE part_cod=".$cod;
				$rs->FreeSql($sql);
				//echo $rs->sql;
				if($rs->linhas==0):
				echo "<tr><td colspan=7> Nenhuma solicita&ccedil;&atilde;o...</td></tr>";
				else:
					while($rs->GeraDados()){
					?>
						<tr>
							<td><?=$rs->fld("part_titulo");?></td>
							<td><?=$rs2->pegar("usu_nome","usuarios","usu_cod=".$rs->fld("part_usu"));?></td>
							<td class="hidden-xs"><?=$fn->data_hbr($rs->fld("part_data"));?></td>
							<td class="hidden-xs"><?=$rs2->pegar("dep_nome","departamentos","dep_id=".$rs->fld("part_depto"));?></td>
							<td class="hidden-xs"><?=$rs2->pegar("tipobs_desc","tipos_obs", "tipobs_id =".$rs->fld("part_tipo"));?></td>
							<td><?=($rs->fld("part_ativo")==1?"Ativo":"Inativo");?></td>
							
							<td class="">
								<a class='btn btn-xs btn-info' data-toggle='tooltip' data-placement='bottom' title='Visualizar' href="form_part.php?token=<?=$_SESSION['token']?>&clicod=<?=$rs->fld('part_cod')?>&part_id=<?=$rs->fld('part_id')?>">
								<i class='fa fa-search'></i> </a>
								<a class="btn btn-xs btn-danger" data-toggle='tooltip' data-placement='bottom' title='Excluir' href="#"><i class="fa fa-trash"></i></a>
							</td>
						</tr>
					<?php  
					}
					echo "<tr><td colspan=7><strong>".$rs->linhas." Particularidade(s)</strong></td></tr>";
				endif;		
				?>
			</table>
			</div>
			<div class="box-footer">
				<a class='btn btn-sm btn-success' data-toggle='tooltip' data-placement='bottom' title='Nova Particularidade' href="form_part.php?token=<?=$_SESSION['token']?>&clicod=<?=$cod;?>"><i class="fa fa-plus"></i> Nova</a>
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


			