<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start("portal");
require_once("../config/main.php");
require_once("../model/recordset.php");
require_once("../class/class.functions.php");
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
							<thead>
								<tr>
									
									<th>#</th>
									<th>IP</th>
									<th>Usu&aacute;rio</th>
									<?php
										$sql = "SELECT * FROM tarefas WHERE task_tipo = 'VER'";
										$rs_rel->FreeSql($sql);
										while($rs_rel->GeraDados()):
											?>
												<th><?=$rs_rel->fld("task_desc");?></th>
											<?php
										endwhile;
									?>
									
								</tr>	
							</thead>
							<tbody>
								<?php
									$sql = "SELECT * FROM lista_verificacao a 
												JOIN listados b ON a.lista_id = b.lver_listaId
												JOIN maquinas c ON b.lver_maquina = c.maq_id
												JOIN usuarios d ON c.maq_user = usu_cod
											WHERE lista_id = ".$_GET['lista'];
									$rs_rel->FreeSql($sql);
									while($rs_rel->GeraDados()):
										$json = $rs_rel->fld("lver_respostas");
										?>
											<tr>
												<td><?=$rs_rel->fld("lver_id");?></td>
												<td><?=$rs_rel->fld("maq_ip");?></td>
												<td><?=$rs_rel->fld("usu_nome");?></td>
												<?php
												$data = json_decode($json,true);
												foreach ($data as $d1 => $dval) {
													foreach ($dval as $d2 => $d2va) {
														echo "<td>".$d2va."</td>";
														
													}
												}
												?>
											</tr>
										<?php
									endwhile;
									?>
							</tbody>
							
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
