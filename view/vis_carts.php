<div class="row">
	<div class="col-md-12">
		<div class="box box-success" id="firms">
			<div class="box-header with-border">
				<h3 class="box-title">Distribui&ccedil;&atilde;o de Carteira</h3>
				<small>[<?=$cod ." - ".$rs->pegar("empresa","tri_clientes","cod = ".$cod);?>]</small>
			</div><!-- /.box-header -->
			<div class="box-body">
			<?php
				require_once("../model/recordset.php");
				require_once("../class/class.functions.php");
				date_default_timezone_set("America/Sao_Paulo");
				$fn = new functions();
				$rs = new recordset();
				$rs2 = new recordset();
			?>

				<table class="table table-striped" id="empr">
					<tr>
						<th>Departamento</th>
						<th class="hidden-xs">Usu&aacute;rio</th>
						<th>Desde</th>
					</tr>	
			<?php
				$rs2 = new recordset();
				$cod = (isset($_GET['clicod']) ? $_GET['clicod'] : 477);
				$sql = "SELECT * FROM tri_clientes WHERE cod=".$cod;
				$rs->FreeSql($sql);
				//echo $rs->sql;
				if($rs->linhas==0):
				echo "<tr><td colspan=7> Nenhuma solicita&ccedil;&atilde;o...</td></tr>";
				else:
				$rs->GeraDados();
				$arr = json_decode($rs->fld("carteira"),true);
				/*
				echo "<pre>";
				print_r($arr);
				echo "</pre>";
				*/
				foreach($arr as $index=>$value){
				$nome = (is_numeric($value["user"])?$rs2->pegar("usu_nome","usuarios","usu_cod=".$value['user']):"-");
				
					?>
						<tr>
							<td><?=$rs2->pegar("dep_nome","departamentos","dep_id=".$index);?></td>
							<td><?=$nome;?></td>
							<td class="hidden-xs"><?=$value["data"];?></td>
						</tr>
					<?php  
					
				}
				endif;		
				?>
			</table>
			</div>
			<div class="box-footer">
				
			</div>
		</div><!-- ./box -->
	</div><!-- ./col -->
</div>
<script src="<?=$hosted;?>/sistema/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script> 
<script src="<?=$hosted;?>/sistema/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/datatables/dataTables.bootstrap.min.js"></script> 



			