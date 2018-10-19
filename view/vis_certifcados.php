<div class="row">
	<div class="col-md-12">
		<div class="box box-success" id="firms">
			<div class="box-header with-border">
				<h3 class="box-title">Certificados Digitais</h3>
				<small>[<?=$cod ." - ".$rs->pegar("empresa","tri_clientes","cod = ".$cod);?>]</small>
			</div><!-- /.box-header -->
			<div id="slc" class="box-body">
			<?php
			
				date_default_timezone_set("America/Sao_Paulo");
				$fn = new functions();
				$rs = new recordset();
				$rs2 = new recordset();
				$perm = $per->getPermissao("form_certid.php",$_SESSION['usu_cod']);
			?>

				<table class="table table-striped table-condensed" id="certifs">
					<thead>
						<tr>
							<th>#</th>
							<th>Tipo</th>
							<th>Mídia</th>
							<th>Entidade</th>
							<th>Validade</th>
							<th>PIN</th>
							<th>PUK</th>
							<th>Local</th>
							<th>Status</th>
							<th>A&ccedil;&otilde;es</th>
						</tr>	
					</thead>
					<tbody>
			<?php
				$sql = "SELECT * FROM certificados a
							
						WHERE cer_cli=".$cod;
									
				$sql.=" ORDER BY cer_status DESC, cer_validade DESC";
				$rs->FreeSql($sql);
				//echo $rs->sql;
				if($rs->linhas==0):
				echo "<tr><td colspan=10> Nenhum certificado...</td></tr>";
				else:
					while($rs->GeraDados()){
					?>
						<tr>
							<td><?=$rs->fld("cer_id");?></td>
							<td><?=$rs->fld("cer_tipo");?></td>
							<td><?=$rs->fld("cer_media");?></td>
							<td><?=$rs->fld("cer_entidade");?></td>
							<td><?=$fn->data_br($rs->fld("cer_validade") );?></td>
							<td><?=$rs->fld("cer_pin");?></td>
							<td><?=$rs->fld("cer_puk");?></td>
							<td><?=$rs->fld("cer_local");?></td>
							<td><?=($rs->fld("cer_status")==1?"Ativo":"Inativo");?></td>
														
							<td class="">
								<a class='btn btn-xs btn-info' data-toggle='tooltip' data-placement='bottom' title='Visualizar' href="form_certif.php?token=<?=$_SESSION['token']?>&clicod=<?=$rs->fld('cer_cli')?>&cer_id=<?=$rs->fld('cer_id')?>">
								<i class='fa fa-search'></i> </a>
								<?php
								if($perm["E"] == 1){ ?>
								<a class="btn btn-xs btn-danger" data-toggle='tooltip' data-placement='bottom' title='Excluir' href="javascript:desativ(<?=$cod.",".$rs->fld('cer_id');?>,'exc_Certifs','o certificado');"><i class="fa fa-trash"></i></a>
								<?php }?>
							</td>
						</tr>
					<?php  
					}
				endif;		
				?>
				</tbody>
			</table>
			</div>
			<div class="box-footer">
				<a class='btn btn-sm btn-success' data-toggle='tooltip' data-placement='bottom' title='Novo Certificado' href="form_certif.php?token=<?=$_SESSION['token']?>&clicod=<?=$cod;?>"><i class="fa fa-plus"></i> Novo</a>
			</div>
		</div><!-- ./box -->
	</div><!-- ./col -->
</div>
<script src="<?=$hosted;?>/sistema/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/datatables/dataTables.bootstrap.min.js"></script> 
<script>
	$(document).ready(function(){
		$('#certifs').DataTable({
			"columnDefs": [{
			"defaultContent": "-",
			"targets": "_all"
		}]
		});
	});
</script>