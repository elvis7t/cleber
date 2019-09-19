<div class="row">
	<div class="col-md-12">
		<div class="box box-success" id="firms">
			<div class="box-header with-border">
				<h3 class="box-title">Distribui&ccedil;&atilde;o de Carteira</h3>
				<small>[<?=$cod ." - ".$rs->pegar("empresa","tri_clientes","cod = ".$cod);?>]</small>
			</div><!-- /.box-header -->
			<div class="box-body">
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
				foreach($arr as $index=>$value){
				$cod = (is_numeric($value["user"])?$rs2->pegar("usu_nome","usuarios","usu_cod=".$value['user']):"-");
				
					?>
						<tr>
							<td><?=$rs2->pegar("dep_nome","departamentos","dep_id=".$index);?></td>
							<td><?=$cod;?></td>
							<td class="hidden-xs"><?=$value["data"];?></td>
							<!--
							<td class="">
								<a class='btn btn-xs btn-info' data-toggle='tooltip' data-placement='bottom' title='Visualizar' href="form_part.php?token=<?=$_SESSION['token']?>&clicod=<?=$rs->fld('part_cod')?>&part_id=<?=$rs->fld('part_id')?>">
								<i class='fa fa-search'></i> </a>
								<a class="btn btn-xs btn-danger" data-toggle='tooltip' data-placement='bottom' title='Excluir' href="#"><i class="fa fa-trash"></i></a>
							</td>
							-->
						</tr>
					<?php  
					
				}
				
					//echo "<tr><td colspan=7><strong>".$rs->linhas." Particularidade(s)</strong></td></tr>";
				endif;		
				?>
			</table>
			</div>
			<div class="box-footer">
				
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


			