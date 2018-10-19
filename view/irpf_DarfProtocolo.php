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
					$quoid = $_GET['quoid'];
					
					//Início dos Dados
					$sql = "SELECT * FROM irpf_cotas a
								JOIN irrf b ON a.icot_ir_id = b.ir_Id
								JOIN empresas c ON b.ir_cli_id = c.emp_codigo
							WHERE icot_id = ".$recid;
					
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
						Recibo de DARF - <?=$rs_rel->fld("icot_parc"); ?>ª Quota | IRPF <?=$rs_rel->fld("ir_ano"); ?>
					</h2>
					<div class="row">
					<div class="col-xs-12 table-responsive">
						<table class="table table-striped table-condensed">
							<thead>
								<tr>
									<th>Serviço</th>
									<th>Ref</th>
									<th>Valor</th>
									
								</tr>
							</thead>
							<tbody id="rls">
								<?php

								$rs_rel->FreeSql($sql);
								$total = 0;
								while($rs_rel->GeraDados()){
									/* ADEQUAÇÃO - DARF COM VALOR ATUALIZADO SELIC */
									$rs_selic = new recordset();
									list($mes,$ano) = explode("/", $rs_rel->fld("icot_ref"));
									//$mes--;
									$ref_selic = $ano."-".str_pad($mes, 2,"0",STR_PAD_LEFT);
									$valor = $rs_rel->fld("icot_valor");
									$sql_selic = "SELECT isel_taxa FROM irpf_selic WHERE isel_ref BETWEEN '".$ano."-05' AND '".$ref_selic."'";
									$rs_selic->FreeSql($sql_selic);
									//echo $rs_selic->sql."<br>";
									$tselic = 0;
									$ano--;
									while($rs_selic->GeraDados()){
										$tselic += $rs_selic->fld("isel_taxa");
									}

									$nv = 0;
									$jur = 0;
									echo $tselic."<br>";
									if($rs_rel->fld("icot_parc")>1){
										$jur = ($valor*$tselic/100);
										$nv = $valor +$valor*($tselic/100);
									}
									else{
										$nv = $valor;
									}
								?>
								<tr>
									
									<td>Darf referente à <?=$rs_rel->fld("icot_parc"); ?>ª quota, mês <?=$rs_rel->fld("icot_ref"); ?> </td>
									<td><?=$rs_rel->fld("icot_ref"); ?></td>
									<td>R$<?=number_format($nv,2,",","."); ?></td>
									
								</tr>
								<?php 
								$total += $nv;
								} ?>
								<tr>
									<td colspan="2" align="right"><strong><h4>Total</h4></strong></td>
									<td><h4>R$<?=number_format($total,2,",","."); ?></h4></td>
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
						<?php 
						$rs_rel->FreeSql($sql);
						$rs_rel->GeraDados();
						?>
						Recibo de DARF - <?=$rs_rel->fld("icot_parc"); ?>ª Quota | IRPF <?=$rs_rel->fld("ir_ano"); ?>
					</h2>
					<div class="row">
						<div class="col-xs-12 table-responsive">
							<table class="table table-striped table-condensed">
								<thead>
									<tr>
										<th>Serviço</th>
										<th>Ref</th>
										<th>Valor</th>
										
									</tr>
								</thead>
								<tbody id="rls">
									<?php

									$rs_rel->FreeSql($sql);
									$total = 0;
									$cota = $rs_rel->fld("icot_parc");
									while($rs_rel->GeraDados()){
										/* ADEQUAÇÃO - DARF COM VALOR ATUALIZADO SELIC */
										$rs_selic = new recordset();
										list($mes,$ano) = explode("/", $rs_rel->fld("icot_ref"));
										//$mes--;
										$ref_selic = $ano."-".str_pad($mes, 2,"0",STR_PAD_LEFT);
										$valor = $rs_rel->fld("icot_valor");
										$sql_selic = "SELECT isel_taxa FROM irpf_selic WHERE isel_ref BETWEEN '".$ano."-05' AND '".$ref_selic."'";
										$rs_selic->FreeSql($sql_selic);
										//echo $rs_selic->sql."<br>";
										$tselic = 0;
										$ano--;
										while($rs_selic->GeraDados()){
											$tselic += $rs_selic->fld("isel_taxa");
										}

										$nv = 0;
										$jur = 0;
										//echo $tselic."<br>";
										if($rs_rel->fld("icot_parc")>1){
											$jur = ($valor*$tselic/100);
											$nv = $valor +($valor*$tselic/100);
										}
										else{
											$nv = $valor;
										}
									?>
									<tr>
										
										<td>Darf referente à <?=$rs_rel->fld("icot_parc"); ?>ª quota, mês <?=$rs_rel->fld("icot_ref"); ?> </td>
										<td><?=$rs_rel->fld("icot_ref"); ?></td>
										<td>R$<?=number_format($nv,2,",","."); ?></td>
										
									</tr>
									<?php 
									$total += $nv;
									} ?>
									<tr>
										<td colspan="2" align="right"><strong><h4>Total</h4></strong></td>
										<td><h4>R$<?=number_format($total,2,",","."); ?></h4></td>
									</tr>
									<tr>
										<td colspan="3">
											<address>
												Eu, <?=$_cliente;?>,<br>declaro que recebi na presente data, o <br>
												DARF de IRPF, referente à <?=$cota;?>ª quota<br>
											</address>
										</td>
									</tr>
								</tbody>
							</table>
							<br>Data: ___/___/______</td><td><br><br>Ass.:___________________________
						</div><!-- /.col -->
					</div>
				</div>
				<h6>2a Via - Tri&acirc;ngulo Cont&aacute;bil</h6>
			</section><!-- /.content -->
		</div><!-- ./wrapper -->

		<!-- AdminLTE App -->
		<script src="../../dist/js/app.min.js"></script>
	</body>
</html>
