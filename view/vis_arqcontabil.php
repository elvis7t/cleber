<div class="row">
	<div class="col-md-12">
		<div class="box box-success" id="firms">
			<div class="box-header with-border">
				<h3 class="box-title">Arquivos - Cont&aacute;bil</h3>
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
					
				<table class="table table-striped table-condensed id="arqcon">
					<thead>
						<tr>
							<th>#</th>
							<th>Nome</th>
							<th class="hidden-xs">Formato</th>
							<th class="hidden-xs">Status</th>
							<th class="hidden-xs">Multiplo</th>
							<th>A&ccedil;&otilde;es</th>
						</tr>
					</thead>
					<tbody>	
			<?php
				$cod = $_GET['imp'];
				$sql = "SELECT * FROM tipos_arquivos WHERE tarq_depart=1";
				$sql.= " ORDER BY tarq_nome ASC ";
				$rs->FreeSql($sql);
				//echo $rs->sql;
				if($rs->linhas==0):
				echo "<tr><td colspan=7> Nenhum dado</td></tr>";
				else:
					while($rs->GeraDados()){
					?>
						<tr>
							<td><?=$rs->fld("tarq_id");?></td>
							<td><?=$rs->fld("tarq_nome");?></td>
							<td class="hidden-xs"><?=$rs->fld("tarq_formato");?></td>
							<td><?=($rs->fld("tarq_status")==1?"Ativo":"Inativo");?></td>
							<td><?=($rs->fld("tarq_duplica")=='Y'?"Sim":"Não");?></td>
							
							<td class="">
								<a class='btn btn-xs btn-info' data-toggle='tooltip' data-placement='bottom' title='Visualizar' href="form_cadarquivos.php?token=<?=$_SESSION['token']?>&tarqid=<?=$rs->fld('tarq_id')?>">
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
				<a class='btn btn-sm btn-success' data-toggle='tooltip' data-placement='bottom' title='Novo Arquivo' href="form_cadarquivos.php?token=<?=$_SESSION['token']?>&clicod=<?=$cod;?>"><i class="fa fa-plus"></i> Novo</a>
			</div>
		</div><!-- ./box -->
	</div><!-- ./col -->
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$("#arqcon").DataTables({
				"columnDefs": [{
				"defaultContent": "-",
				"targets": "_all"
			}]
		});
	});
</script>