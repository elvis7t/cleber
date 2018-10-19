<div class="row">
	<div class="col-md-12">
		<div class="box box-success" id="firms">
			<div class="box-header with-border">
				<h3 class="box-title">Recalculos</h3>
			</div><!-- /.box-header -->
			<div id="slc" class="box-body">
			<?php
				require_once("../model/recordset.php");
				require_once("../class/class.functions.php");
				date_default_timezone_set("America/Sao_Paulo");
				$fn = new functions();
				$rs = new recordset();
				$rs2 = new recordset();
			?>
					
				<table class="table table-striped table-condensed" id="arqlegal">
					<thead>
						<tr>
							<th>#</th>
							<th>Tipo</th>
							<th class="hidden-xs">Valor</th>
							<th>A&ccedil;&otilde;es</th>
						</tr>
					</thead>
					<tbody>
			<?php
				$sql = "SELECT * FROM tipos_calc WHERE 1";
				$sql.= " ORDER BY calc_desc ASC ";
				$rs->FreeSql($sql);
				//echo $rs->sql;
				if($rs->linhas==0):
				echo "<tr><td colspan=3> Nenhum dado</td></tr>";
				else:
					while($rs->GeraDados()){
					?>
						<tr>
							<td><?=$rs->fld("calc_id");?></td>
							<td><?=$rs->fld("calc_desc");?></td>
							<td><?=number_format($rs->fld("calc_preco"),2,",",".");?></td>
							
							<td class="">
								<a class='btn btn-xs btn-info' data-toggle='tooltip' data-placement='bottom' title='Visualizar' href="form_cadarquivos.php?token=<?=$_SESSION['token']?>&tarqid=<?=$rs->fld('calc_id')?>">
								<i class='fa fa-search'></i> </a>
								<a class="btn btn-xs btn-danger" data-toggle='tooltip' data-placement='bottom' title='Excluir' href="#"><i class="fa fa-trash"></i></a>
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
				<a class='btn btn-sm btn-success' data-toggle='tooltip' data-placement='bottom' title='Novo Arquivo' href="form_recalculos.php?token=<?=$_SESSION['token']?>"><i class="fa fa-plus"></i> Novo</a>
			</div>
		</div><!-- ./box -->
	</div><!-- ./col -->
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$("#arqlegal").DataTables({
				"columnDefs": [{
				"defaultContent": "-",
				"targets": "_all"
			}]
		});
	});
</script>