<div class="row">
	<div class="col-md-12">
		<div class="box box-success" id="firms">
			<div class="box-header with-border">
				<h3 class="box-title">Lista de Vencimentos</h3>
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

				<table class="table table-striped table-condensed" id="certids">
					<thead>
						<tr>
							<th>#</th>
							<th>Tipo</th>
							<th>Validade</th>
							<th>Lembrete</th>
							<th>Status</th>
							<th>A&ccedil;&otilde;es</th>
						</tr>	
					</thead>
					<tbody>
			<?php
				$sql = "SELECT b.tipocertid_desc, a.certid_tipoId, a.certid_validade, b.tipocertid_dias, a.certid_id, a.certid_status, a.certid_cod FROM certidoes a
							JOIN tipos_certidoes b ON a.certid_tipoId = b.tipocertid_id
						WHERE certid_cod=".$cod;
				//$sql.= ." AND tipocertid_tipo IN('C') ";
									
				$sql.=" ORDER BY certid_status DESC, certid_tipoId ASC";
				$rs->FreeSql($sql);
				//echo $rs->sql;
				if($rs->linhas==0):
				echo "<tr><td colspan=7> Nenhuma certid&atilde;o...</td></tr>";
				else:
					while($rs->GeraDados()){
					?>
						<tr>
							<td><?=$rs->fld("certid_id");?></td>
							<td><?=$rs->fld("tipocertid_desc");?></td>
							<td><?=$fn->data_br($rs->fld("certid_validade") );?></td>
							<td><?=$rs->fld("tipocertid_dias");?></td>
							<td><?=($rs->fld("certid_status")==1?"Ativo":"Inativo");?></td>
														
							<td class="">
								<a class='btn btn-xs btn-info' data-toggle='tooltip' data-placement='bottom' title='Visualizar' href="form_certid.php?token=<?=$_SESSION['token']?>&clicod=<?=$rs->fld('certid_cod')?>&certid_id=<?=$rs->fld('certid_tipoId')?>">
								<i class='fa fa-search'></i> </a>
								<?php
								if($perm["E"] == 1){ ?>
								<a class="btn btn-xs btn-danger" data-toggle='tooltip' data-placement='bottom' title='Excluir' href="javascript:desativ(<?=$cod.",".$rs->fld('certid_id');?>,'exc_Certids','a certidão');"><i class="fa fa-trash"></i></a>
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
				<a class='btn btn-sm btn-success' data-toggle='tooltip' data-placement='bottom' title='Nova certid&atilde;o' href="form_certid.php?token=<?=$_SESSION['token']?>&clicod=<?=$cod;?>"><i class="fa fa-plus"></i> Nova</a>
			</div>
		</div><!-- ./box -->
	</div><!-- ./col -->
</div>
<script src="<?=$hosted;?>/sistema/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/datatables/dataTables.bootstrap.min.js"></script> 
<script>
	$(document).ready(function(){
		$('#certids').DataTable({
			"columnDefs": [{
			"defaultContent": "-",
			"targets": "_all"
		}]
		});
	});
</script>