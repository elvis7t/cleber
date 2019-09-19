<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start();
require_once("../config/main.php");
require_once("../money_formatdel/recordset.php");
require_once("../class/class.functions.php");
$rs_rel = new recordset();
$fn = new functions();

?>
	<body onload="window.print();">
	
		<div class="wrapper">
			<!-- Main content -->
			<section class="invoice">
				<!-- title row -->
				<div class="row">
				  <div class="col-xs-12">
					<h3 class="page-header">
						<img src="<?=$hosted."/".$rs_rel->pegar("sys_logo","sistema","sys_cnpj = '".$_SESSION['usu_empresa']."'");?>" width="75" class="img-responsiive"/> <?=$rs_rel->pegar("sys_empresa","sistema","sys_cnpj = '".$_SESSION['usu_empresa']."'");?>
						
						<small class="pull-right">Data: <?=date("d/m/Y");?></small>
							
					</h3>
				  </div><!-- /.col -->
				</div>
				<!-- info row -->
				<div class="row invoice-info">
					<?php

					$m_id = $_GET['imlist'];
					
					//Início dos Dados
					$sql = "SELECT * FROM mat_listas a
							LEFT JOIN mat_historico f ON a.mlist_id = f.mat_lista
							LEFT JOIN mat_cadastro b ON b.mcad_id = f.mat_cadId
						WHERE mlist_id=".$m_id;
						
						$sql.=" ORDER BY mlist_venc ASC ";
						$rs_rel->FreeSql($sql);
						//echo $rs_rel->sql;
						$rs_rel->GeraDados();
						//$_cliente 	= $rs_rel->fld("apelido");
						//$_documen	= $rs_rel->fld("cnpj");
					?>
					
					<div class="col-sm-4 invoice-col">
						<small>
							Usu&aacute;rio
							<address>
								<p class="text-uppercase"><strong><?=$_SESSION['nome_usu'];?></strong><br>
								<i class="fa fa-envelope"></i> <span class="text-lowercase"><small><?=$_SESSION['usuario'];?></small></span></p>
							</address>
						</small>
					</div><!-- /.col -->
					<div class="col-sm-4 invoice-col">
						<address>
							<i class="fa fa-tag"></i> <strong><?=$m_id;?></strong></p>
						</address>
					</div><!-- /.col -->
					
				</div><!-- /.row -->
				<div class="col-xl-12">
					
					<h2 class="page-header">
						Produtos para compra
					</h2>
					<div class="row">
					<div class="col-xs-12 table-responsive">
						<table class="table table-striped table-condensed">
							<thead>
								<tr>
									<th>#</th>
									<th>Material</th>
									<th>Quantidade</th>
									<th>Observa&ccedil;&otilde;es</th>
								</tr>
							</thead>
							<tbody id="rls">
								<?php

								$rs_rel->FreeSql($sql);
								$total = 0;
								while($rs_rel->GeraDados()){
								?>
								<tr>
									<td><?=$rs_rel->fld("mat_id"); ?></td>
									<td><?=$rs_rel->fld("mcad_desc"); ?></td>
									<td><?=$rs_rel->fld("mat_qtd"); ?></td>
									<td><?=$rs_rel->fld("mat_obs"); ?></td>
									
								</tr>
								<?php 
								
								} ?>
								
								</tr>
							</tbody>
						</table>
					</div><!-- /.col -->
				</div><!-- /.row -->
				
				
			</section><!-- /.content -->
		</div><!-- ./wrapper -->

		<!-- AdminLTE App -->
		<script src="../assets/dist/js/app.min.js"></script>
	</body>
</html>
