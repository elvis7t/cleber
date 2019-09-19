<div class="row">
	<div class="col-md-12">
		<div class="box box-success" id="firms">
			<div class="box-header with-border">
				<h3 class="box-title">Impostos e Obriga&ccedil;&otilde;es Cadastradas</h3>
			</div><!-- /.box-header -->
			<div id="slc" class="box-body">
			<?php
				session_start();
				require_once("../model/recordset.php");
				require_once("../class/class.functions.php");
				date_default_timezone_set("America/Sao_Paulo");
				$fn = new functions();
				$rs = new recordset();
				$rs2 = new recordset();
			?>

				<table class="table table-striped" id="empr">
					<tr>
						<th>#</th>
						<th>Nome</th>
						<th class="hidden-xs">Tipo</th>
						<th>Vencimento <small>(esse m&ecirc;s)</small></th>
						<th class="hidden-xs">Salvar como</th>
						<th class="hidden-xs">Salvar na pasta</th>
						<th class="hidden-xs">Data</th>
						<th class="hidden-xs">Status</th>
						<th>A&ccedil;&otilde;es</th>
					</tr>	
			<?php
				$cod = $_GET['impid'];
				$sql = "SELECT * FROM tipos_impostos WHERE imp_depto=1";
				$rs->FreeSql($sql);
				//echo $rs->sql;
				if($rs->linhas==0):
				echo "<tr><td colspan=7> Nenhum dado</td></tr>";
				else:
					while($rs->GeraDados()){
					?>
						<tr>
							<td><?=$rs->fld("imp_id");?></td>
							<td><?=$rs->fld("imp_nome");?></td>
							<td class="hidden-xs"><?=($rs->fld("imp_tipo")=="T"?"Tributo":"Obriga&ccedil;&atilde;o");?></td>
							<td class="hidden-xs">
								<?php
									if($rs->fld("imp_regra")=="mes_subs"){
										$mes = $rs->fld("imp_venc") - 1;
										$ref =  date("m/Y", strtotime("+".$mes." month"));
										echo $ref;
										//echo $fn->ultimo_dia_mes($ref);
									}
									else{
										echo $fn->data_br($fn->dia_util($rs->fld("imp_venc"),$rs->fld("imp_regra")));
									}
								?>
							</td>
							<td><?=$rs->fld("imp_arquivo");?></td>
							<td><?=$rs->fld("imp_pasta");?></td>
							<td class="hidden-xs"><?=$fn->data_hbr($rs->fld("imp_dtcad"));?></td>
							<td><?=($rs->fld("imp_ativo")==1?"Ativo":"Inativo");?></td>
							
							<td class="">
								<a class='btn btn-xs btn-info' data-toggle='tooltip' data-placement='bottom' title='Visualizar' href="form_impostos.php?token=<?=$_SESSION['token']?>&impid=<?=$rs->fld('imp_id')?>">
								<i class='fa fa-search'></i> </a>
								<a class="btn btn-xs btn-danger" data-toggle='tooltip' data-placement='bottom' title='Excluir' href="#"><i class="fa fa-trash"></i></a>
							</td>
						</tr>
					<?php  
					}
					echo "<tr><td colspan=7><strong>".$rs->linhas." Tributo(s) / Obriga&ccedil;&atilde;o(&ccedil;&otilde;es)</strong></td></tr>";
				endif;		
				?>
			</table>
			</div>
			<div class="box-footer">
				<a class='btn btn-sm btn-success' data-toggle='tooltip' data-placement='bottom' title='Nova Particularidade' href="form_impostos.php?token=<?=$_SESSION['token']?>&clicod=<?=$cod;?>"><i class="fa fa-plus"></i> Nova</a>
			</div>
		</div><!-- ./box -->
	</div><!-- ./col -->
</div>


			