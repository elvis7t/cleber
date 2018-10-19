<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start();
require_once("../config/main.php");
require_once("../../model/recordset.php");
require_once("../../sistema/class/class.functions.php");
$rs_rel = new recordset();
?>
	<body onload="window.print();">
		<div class="wrapper">
			<!-- Main content -->
			<section class="invoice">
				<!-- title row -->
				<div class="row">
				  <div class="col-xs-12">
					<h2 class="page-header">
						<i class="fa fa-globe"></i> <?=$rs_rel->pegar("emp_nome","empresas","emp_cnpj = '".$_SESSION['usu_empresa']."'");?>
						<small class="pull-right">Data: <?=date("d/m/Y");?></small>
					</h2>
				  </div><!-- /.col -->
				</div>
				<!-- info row -->
				<div class="row invoice-info">
					<div class="col-sm-4 invoice-col">
						Usu&aacute;rio
						<address>
							<strong><?=$_SESSION['nome_usu'];?></strong><br>
							<i class="fa fa-envelope"></i> <?=$_SESSION['usuario'];?>
						</address>
					</div><!-- /.col -->
				</div><!-- /.row -->

				<!-- Table row -->
				<div class="row">
					<div class="col-xs-12 table-responsive">
						<table class="table table-striped" id="empr">
							<tr>
								<th>#</th>
								<th>Categoria</th>
								<th>Descri&ccedil;&atilde;o</th>
								<th>M&iacute;nimo</th>
								<th>Quantidade</th>
								<th>&Uacute;ltimo Pre&ccedil;o</th>
								<th>Valor em estoque</th>
								
							</tr>	
							<?php
							$hide="";
							$sql = "SELECT 	b.mcad_id,
											c.mcat_desc, 
											b.mcad_desc, 
											b.mcad_minimo,
											b.mcad_ultpreco, 
											(a.alerta_matcomp - a.alerta_matentr) as qtd 
									FROM alerta_compras a 
									LEFT JOIN mat_cadastro b ON a.alerta_matId = b.mcad_id
									LEFT JOIN mat_categorias c ON b.mcad_catid=c.mcat_id ";

							
							$sql.= " ORDER BY b.mcad_desc ASC";
							$rs_rel->FreeSql($sql);
							//echo $rs_rel->sql;
							if($rs_rel->linhas==0):
							echo "<tr><td colspan=4> Nenhuma solicita&ccedil;&atilde;o...</td></tr>";
							else:
								while($rs_rel->GeraDados()){
									$n = $rs_rel->fld("qtd") * $rs_rel->fld("mcad_ultpreco");
									$soma+=$n;
								?>
									<tr>
										<td><?=$rs_rel->fld("mcad_id");?></td>
										<td><?=$rs_rel->fld("mcat_desc");?></td>
										<td><?=$rs_rel->fld("mcad_desc");?></td>
										<td><?=$rs_rel->fld("mcad_minimo");?></td>
										<td><?=$rs_rel->fld("qtd");?></td>
										<td><?=number_format($rs_rel->fld("mcad_ultpreco"),2,",","."); ?></td>
										<td><?=number_format($n,2,",","."); ?></td>
									
									</tr>
								
								<?php  
								}
								echo "<tr><td colspan=4><strong>".$rs_rel->linhas." Material(is) Encontrado(s)</strong></td></tr>";
							endif;		
							?>
								<tr>
									<th colspan=4 align="right">Em estoque (R$):</th>
									<th>R$<?=number_format($soma,2,",","."); ?></th>
								</tr>
						</table>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</section><!-- /.content -->
		</div><!-- ./wrapper -->

		<!-- AdminLTE App -->
   		<script src="<?=$hosted;?>/sistema/assets/dist/js/app.min.js"></script>
		<script src="<?=$hosted;?>/sistema/assets/plugins/datatables/jquery.dataTables.min.js"></script>
		<script src="<?=$hosted;?>/sistema/assets/plugins/datatables/dataTables.bootstrap.min.js"></script> 
	</body>
</html>
