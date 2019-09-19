<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start();
require_once("../config/main.php");
require_once("../model/recordset.php");
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
						<img align="left" src="<?=$hosted."/".$rs_rel->pegar("sys_logo","sistema","sys_cnpj = '".$_SESSION['usu_empresa']."'");?>" width="75" class="img-responsive"/>
						<br>
						<p>
							<?=$rs_rel->pegar("emp_nome","empresas","emp_cnpj = '".$_SESSION['usu_empresa']."'");?>
							<small class="pull-right">Data: <?=date("d/m/Y");?></small>
						</p>
						
							
					</h3>
				  </div><!-- /.col -->
				</div>
				<!-- info row -->
				<div class="row invoice-info">
					<?php

					$homol = $_GET['homol'];
					
					//Início dos Dados
					$sql = "SELECT * FROM homologacoes a
								JOIN homologa_check b ON a.hom_id = b.homchk_homId
								JOIN checklists c ON b.homchk_item = c.chk_id
								LEFT JOIN usuarios d ON d.usu_cod = b.homchk_seppor
								LEFT JOIN tri_clientes e ON a.hom_empresa = e.cod
							WHERE hom_id=".$homol;
						
						
						$rs_rel->FreeSql($sql);
						//echo $rs_rel->sql;
						$rs_rel->GeraDados();
						$_cliente 	= $rs_rel->fld("usu_nome");
						$_documen	= $rs_rel->fld("usu_email");
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
							<i class="fa fa-tag"></i> <strong><?=$rs_rel->fld("hom_id");?></strong></p>
							<strong>Local: </strong><?=$rs_rel->fld("hom_local");?>
						</address>
					</div><!-- /.col -->
				</div><!-- /.row -->
				<div class="col-xl-12">
					
					<h2 class="page-header">
						Homologa&ccedil;&atilde;o
					</h2>
					<div class="row">
					<div class="col-xs-12">
						<table class="table table-condensed">
							<thead>
								<tr>
									<th>Empresa:</th> 
									<th>Homologado:</th> 
									<th>Indenizado?</th> 
									<th>Data:</th>
									<th>Hora:</th>
									<th>Valor:</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?=$rs_rel->fld("apelido");?></td>
									<td><?=$rs_rel->fld("hom_empregado");?></td>
									<td><?=($rs_rel->fld("hom_indenizado")==1?"Sim":"Não");?></td>
									<td><?=$fn->data_br($rs_rel->fld("hom_datahom"));?></td>
									<td><?=$rs_rel->fld("hom_horario");?></td>
									<td>R$<?=number_format($rs_rel->fld("hom_horario"),2,",",".");?></td>
								</tr>
							</tbody>
						</table>
						<table class="table table-striped table-condensed">
							<thead>
								<tr>
									<th>#</th>
									<th>Documento</th>
									<th>Colaborador</th>
									<th>Conferido?</th>
									<th>Data da Conferência</th>
								</tr>
							</thead>
							<tbody id="rls">
								<?php

								$rs_rel->FreeSql($sql);
								$total = 0;
								while($rs_rel->GeraDados()){
								?>
								<tr>
									<td><?=$rs_rel->fld("homchk_id"); ?></td>
									<td><?=$rs_rel->fld("chk_item"); ?></td>
									<td><?=$rs_rel->fld("usu_nome"); ?></td>
									<td><?=($rs_rel->fld("homchk_ativo")==1?"Sim":"Não"); ?></td>
									<td><?=$fn->data_hbr($rs_rel->fld("homchk_dtsep")); ?></td>
									
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
