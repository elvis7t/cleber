<div class="row">
	<div class="col-md-12">
		<div class="box box-success" id="firms">
			<div class="box-header with-border">
				<h3 class="box-title">Particularidades Cadastradas</h3>
				<div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
			</div><!-- /.box-header -->
			<div id="slc" class="box-body">
				<table class="table table-striped" id="empr">
					<tr>
						<th>#</th>
						<th>Titulo</th>
						<th>Data:</th>
						<th class="hidden-xs">Depto.</th>
						<th class="hidden-xs">Tipo</th>
						<th class="hidden-xs">Status</th>
						<th>A&ccedil;&otilde;es</th>
					</tr>	
			<?php
				
				//echo $rs->sql;
				if($rs->linhas==0):
				echo "<tr><td colspan=7> Nenhuma particularidade...</td></tr>";
				else:
					while($rs->GeraDados()){
					?>
						<tr>
							<td><?=$rs->fld("part_id");?></td>
							<td><?=$rs->fld("part_titulo");?></td>
							<td class="hidden-xs"><?=$fn->data_hbr($rs->fld("part_data"));?></td>
							<td class="hidden-xs"><?=$rs2->pegar("dep_nome","departamentos","dep_id=".$rs->fld("part_depto"));?></td>
							<td class="hidden-xs"><?=$rs2->pegar("tipobs_desc","tipos_obs", "tipobs_id =".$rs->fld("part_tipo"));?></td>
							<td><?=($rs->fld("part_ativo")==1?"Ativo":"Inativo");?></td>
							
							<td class="">
								<a class='btn btn-xs btn-info' data-toggle='tooltip' data-placement='bottom' title='Visualizar' href="form_part.php?token=<?=$_SESSION['token']?>&clicod=<?=$rs->fld('part_cod')?>&part_id=<?=$rs->fld('part_id')?>">
								<i class='fa fa-search'></i> </a>
								<?php
								if($con['E']==1):?>
									<a class="btn btn-xs btn-danger" data-toggle='tooltip' data-placement='bottom' title='Excluir' href="javascript:del(<?=$rs->fld("part_id");?>,'excPart','a particularidade')"><i class="fa fa-trash"></i></a>
								<?php endif; ?>
							</td>
						</tr>
					<?php  
					}
					echo "<tr><td colspan=8><strong>".$rs->linhas." Particularidade(s)</strong></td></tr>";
				endif;		
				?>
			</table>
			</div>
			
		</div><!-- ./box -->
	</div><!-- ./col -->
</div>

<script src="<?=$hosted;?>/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=$hosted;?>/assets/plugins/datatables/dataTables.bootstrap.min.js"></script> 
<script>
// Atualizar a cada 10 segundos
/*------------------------|INICIA TOOLTIPS E POPOVERS|---------------------------------------*/

setTimeout(function(){
	$("#alms").load(location.href+" #almsg");
},10500);

</script>


			