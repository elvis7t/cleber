<div class="row">
	<div class="col-md-12">
		<div class="box box-success" id="firms">
			<div class="box-header with-border">
				<h3 class="box-title">Lista de Arquivos</h3>
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
				$perm = $per->getPermissao("form_arquivos", $_SESSION['usu_cod']);
			?>

				<table class="table table-striped" id="emparq">
					<thead>
						<tr>
							<th>Arquivo</th>
							<th class="hidden-xs">Formato</th>
							<th>Detalhes</th>
							<th>Prox. Vencimento</th>
							<th class="hidden-xs">Depto.</th>
							<th class="hidden-xs">Status</th>
							<th>A&ccedil;&otilde;es</th>
						</tr>	
					</thead>
					<tbody>
			<?php
				$sql = "SELECT * FROM clientes_arquivos a 
							JOIN tipos_arquivos b ON a.cliarq_arqId = b.tarq_id 
							JOIN departamentos c ON c.dep_id = b.tarq_depart 
						WHERE cliarq_empresa=".$cod." ORDER BY cliarq_ativo DESC, cliarq_venc ASC";
				$rs->FreeSql($sql);
				//echo $rs->sql;
				if($rs->linhas==0):
				echo "<tr><td colspan=7> Nenhum arquivo...</td></tr>";
				else:
					while($rs->GeraDados()){
					?>
						<tr>
							<td><?=$rs->fld("tarq_nome");?></td>
							<td><?=$rs->fld("tarq_formato");?></td>
							<td><?=$rs->fld("cliarq_detalhes");?></td>
							<td><?=str_pad($rs->fld("cliarq_venc"),2,"0",STR_PAD_LEFT)."/".date("m/Y");?></td>
							<td class="hidden-xs"><?=$rs->fld("dep_nome");?></td>
							<td><?=($rs->fld("cliarq_ativo")==1?"Ativo":"Inativo");?></td>
							
							<td class="">
								<a class='btn btn-xs btn-info' data-toggle='tooltip' data-placement='bottom' title='Visualizar' href="form_arquivos.php?token=<?=$_SESSION['token']?>&clicod=<?=$rs->fld('cliarq_empresa')?>&arq_id=<?=$rs->fld('cliarq_id')?>">
								<i class='fa fa-search'></i> </a>
								<?php
							
								if($perm["E"] == 1){ ?>
								<a class="btn btn-xs btn-danger" data-toggle='tooltip' data-placement='bottom' title='Excluir' href="javascript:desativ(<?=$cod.",".$rs->fld('cliarq_id');?>,'exc_Arquivo','O Arquivo');"><i class="fa fa-trash"></i></a>
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
				<a class='btn btn-sm btn-success' data-toggle='tooltip' data-placement='bottom' title='Novo Arquivo' href="form_arquivos.php?token=<?=$_SESSION['token']?>&clicod=<?=$cod;?>"><i class="fa fa-plus"></i> Nova</a>
			</div>
		</div><!-- ./box -->
	</div><!-- ./col -->
</div>
<script src="<?=$hosted;?>/sistema/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/datatables/dataTables.bootstrap.min.js"></script> 
<script>
	$(document).ready(function(){
		$('#emparq').DataTable({
			"columnDefs": [{
			"defaultContent": "-",
			"targets": "_all"
		}]
		});
	});
</script>