<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start();
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
					<h3 class="page-header">
						<img src="<?=$hosted."/".$rs_rel->pegar("emp_logo","empresas","emp_cnpj = '".$_SESSION['usu_empresa']."'");?>" width="75" class="img-responsiive"/> <?=$rs_rel->pegar("emp_nome","empresas","emp_cnpj = '".$_SESSION['usu_empresa']."'");?>
						
						<small class="pull-right">Data: <?=date("d/m/Y");?></small>
							
					</h3>
				  </div><!-- /.col -->
				</div>
				<!-- info row -->
				<div class="row invoice-info">
					<?php

					$recid = $_GET['recid'];
					
					//Início dos Dados
					$sql = "SELECT * FROM irrf a
						JOIN empresas b 
							ON a.ir_cli_id = b.emp_codigo
						LEFT JOIN irpf_recibo f
							ON a.ir_reciboId = f.irec_id
				
						WHERE irec_id=".$recid;
						
						$sql.=" GROUP BY ir_Id";
						$rs_rel->FreeSql($sql);
						//echo $rs_rel->sql;
						$rs_rel->GeraDados();
						$_cliente 	= $rs_rel->fld("emp_razao");
						$_documen	= $rs_rel->fld("emp_cnpj");
					?>
					<div class="col-sm-4 invoice-col">
						<small>
							Cliente
							<address>
								<p class="text-uppercase"><strong><?=$_cliente;?></strong><br>
								<i class="fa fa-file"></i> <?=$_documen;?></p>
							</address>
						</small>
					</div><!-- /.col -->
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
							<i class="fa fa-tag"></i> <strong><?=$recid;?></strong></p>
						</address>
					</div><!-- /.col -->
					
				</div><!-- /.row -->
				<div class="col-xl-12">
					
					<h2 class="page-header">
						Recibo de IRPF - Informe de Servi&ccedil;os Prestados
					</h2>
					<div class="row">
					<div class="col-xs-12 table-responsive">
						<table class="table table-striped table-condensed">
							<thead>
								<tr>
									<th>#</th>
									<th>Servi&ccedil;o</th>
									<th>Complemento</th>
									<th>Valor</th>
									
								</tr>
							</thead>
							<tbody id="rls">
								<?php

								$rs_rel->FreeSql($sql);
								$total = 0;
								while($rs_rel->GeraDados()){
								?>
								<tr>
									<td><?=$rs_rel->fld("ir_Id"); ?></td>
									<td><?=$rs_rel->fld("ir_tipo"); ?> - Exerc&iacute;cio <?=$rs_rel->fld("ir_ano")+1;?> | Ano <?=$rs_rel->fld("ir_ano");?></td>
									<td><?=$rs_rel->fld("ir_compl"); ?></td>
									<td>R$<?=number_format($rs_rel->fld("ir_valor"),2,",","."); ?></td>
									
								</tr>
								<?php 
								$total += $rs_rel->fld("ir_valor");
								} ?>
								<tr>
									<td colspan="2" align="right"><strong><h4>Total</h4></strong></td>
									<td><h4>R$<?=number_format($total,2,",","."); ?></h4></td>
								</tr>
								<tr>
									<td colspan="3">
										Caso deseje efetuar o pagamento atrav&eacute;s de dep&oacute;sito:<br>
										<address>
											Banco Itau: Ag.: 0046 | C/C.: 73665-8<br>
											Banco Bradesco: Ag.: 2501 | C/C.: 19380-1<br>
										<strong>Favor enviar comprovante no e-mail: </strong><br>
										nilza@triangulocontabil.com.br<br>
										triangulo_sp@uol.com.br
										</address>
									</td>
									<td>Recebemos em: ___/___/______</td>
								</tr>
							</tbody>
						</table>
					</div><!-- /.col -->
				</div><!-- /.row -->
				</div>
				<h6>1a Via - Cliente</h6>
				<i class="fa fa-scissors"></i>----------------------------------------------------------------------------------------------------------------------------------------------

				<div class="row invoice-info">
					<div class="col-sm-4 invoice-col">
						<small>
							Cliente
							<address>
								<p class="text-uppercase"><strong><?=$_cliente;?></strong><br>
								<i class="fa fa-file"></i> <?=$_documen;?></p>
							</address>
						</small>
					</div><!-- /.col -->
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
							<i class="fa fa-tag"></i> <strong><?=$recid;?></strong></p>
						</address>
					</div><!-- /.col -->
				</div><!-- /.row -->
				<div class="col-xl-12">
					
					<h2 class="page-header">
						Recibo de IRPF - Informe de Servi&ccedil;os Prestados
					</h2>
					<div class="row">
					<div class="col-xs-12 table-responsive">
						<table class="table table-striped table-condensed">
								<thead>
								<tr>
									<th>#</th>
									<th>Servi&ccedil;o</th>
									<th>Complemento</th>
									<th>Valor</th>
									
								</tr>
							</thead>
							<tbody id="rls">
								<?php
								$rs_rel->FreeSql($sql);
								$total = 0;
								while($rs_rel->GeraDados()){
									?>
									<tr>
									<td><?=$rs_rel->fld("ir_Id"); ?></td>
									<td><?=$rs_rel->fld("ir_tipo"); ?> - Exerc&iacute;cio <?=$rs_rel->fld("ir_ano")+1;?> | Ano <?=$rs_rel->fld("ir_ano");?></td>
									<td><?=$rs_rel->fld("ir_compl"); ?></td>
									<td>R$<?=number_format($rs_rel->fld("ir_valor"),2,",","."); ?></td>
									
								</tr>
									<?php 
										$total += $rs_rel->fld("ir_valor");
									}
									?>
								<tr>
									<td colspan="2" align="right"><strong><h4>Total</h4></strong></td>
									<td><h4>R$<?=number_format($total,2,",","."); ?></h4></td>
								</tr>
								
							</tbody>
						</table>
					</div><!-- /.col -->
				</div><!-- /.row -->
				</div>
				<h6>2a Via - Tri&acirc;ngulo Cont&aacute;bil</h6>
			</section><!-- /.content -->
		</div><!-- ./wrapper -->

		<!-- AdminLTE App -->
		<script src="../assets/dist/js/app.min.js"></script>
	</body>
</html>
