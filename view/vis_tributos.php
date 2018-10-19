<div class="row">
	<div class="col-md-12">
		<div class="box box-success" id="firms">
			<div class="box-header with-border">
				<h3 class="box-title">Lista de Tributos</h3>
				<small>[<?=$cod ." - ".$rs->pegar("empresa","tri_clientes","cod = ".$cod);?>]</small>
			</div><!-- /.box-header -->
			<div id="slc" class="box-body">
			<?php
				require_once("../model/recordset.php");
				require_once("../class/class.functions.php");
				date_default_timezone_set("America/Sao_Paulo");
				$fn = new functions();
				$rs = new recordset();
				$rs2 = new recordset();
				$perm = $per->getPermissao("form_tribut.php", $_SESSION['usu_cod']);
			?>

				<table class="table table-striped table-condensed" id="tributos">
					<thead>
						<tr>
							<th>Assunto</th>
							<th>Prox. Vencimento</th>
							<th class="hidden-xs">Depto.</th>
							<th class="hidden-xs">Status</th>
							<th>A&ccedil;&otilde;es</th>
						</tr>	
					</thead>
					<tbody>
			<?php
				$sql = "SELECT * FROM obrigacoes a 
							JOIN tipos_impostos b ON a.ob_titulo = b.imp_id
							JOIN departamentos c ON c.dep_id = b.imp_depto
						WHERE ob_cod=".$cod." AND imp_tipo='T'";
				if($_SESSION['classe']>=4){
					$sql.= " AND imp_depto = ".$_SESSION['dep'];
				}
				$sql.=" ORDER BY ob_ativo DESC, imp_venc ASC";
				$rs->FreeSql($sql);
				//echo $rs->sql;
				if($rs->linhas==0):
				echo "<tr><td colspan=7> Nenhum tributo...</td></tr>";
				else:
					while($rs->GeraDados()){
					?>
						<tr>
							<td><?=$rs->fld("imp_nome");?></td>
							<td><?=$fn->data_br($fn->dia_util($rs->fld("imp_venc"), $rs->fld("imp_regra")) );?></td>
							<td class="hidden-xs"><?=$rs->fld("dep_nome");?></td>
							<td><?=($rs->fld("ob_ativo")==1?"Ativo":"Inativo");?></td>
							
							<td class="">
								<a class='btn btn-xs btn-info' data-toggle='tooltip' data-placement='bottom' title='Visualizar' href="form_tribut.php?token=<?=$_SESSION['token']?>&clicod=<?=$rs->fld('ob_cod')?>&tr_id=<?=$rs->fld('ob_id')?>">
								<i class='fa fa-search'></i> </a>
								<?php
								if($perm["E"] == 1){ ?>
								<a class="btn btn-xs btn-danger" data-toggle='tooltip' data-placement='bottom' title='Excluir' href="javascript:desativ(<?=$cod.",".$rs->fld('ob_id');?>,'exc_Obrigac','a tributação');"><i class="fa fa-trash"></i></a>
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
				<a class='btn btn-sm btn-success' data-toggle='tooltip' data-placement='bottom' title='Nova Comunica&ccedil;o' href="form_tribut.php?token=<?=$_SESSION['token']?>&clicod=<?=$cod;?>"><i class="fa fa-plus"></i> Nova</a>
			</div>
		</div><!-- ./box -->
	</div><!-- ./col -->
</div>
<script src="<?=$hosted;?>/sistema/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/datatables/dataTables.bootstrap.min.js"></script> 
<script>
	$(document).ready(function(){
		$(function () {
			$('#tributos').DataTable({
				"columnDefs": [{
				"defaultContent": "-",
				"targets": "_all"
			}]
			});
		});
	});
</script>