<?php
/*inclusão dos principais itens da página */
require_once("../config/main.php");
require_once("../class/class.functions.php");
$rs_atual = new recordset();
$rs_rel = new recordset();
$fn = new functions();
?>
	<body>
		<div class="wrapper">
			<!-- Main content -->
			<section class="invoice">
				<!-- title row -->
				<img class="img-responsive" src="<?=$hosted."/".$rs_rel->pegar("sys_logo","sistema","sys_id=2");?>" width="100px" align="left"/>
				<img class="img-responsive" src="<?=$hosted."/images/selo.jpg";?>" width="100px" align="right"/>
								<div class="row">
				  <div class="col-xs-12">
					<h2 class="page-header">
						<?=$rs_rel->pegar("emp_nome","empresas","emp_cnpj = '".$_SESSION['usu_empresa']."'");?>
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
					<div class="col-sm-4 invoice-col">
						
							<strong>CPC</strong><br>
							Cadastro Permanente de Clientes
						
					</div><!-- /.col -->
				</div><!-- /.row -->

				<!-- Table row -->
				<div class="row">
					<div class="col-xs-12">
						<table class="table table-bordered table-condensed table-responsive">
							
							<?php
							$hide="";
							$sql = "SELECT * FROM tri_clientes WHERE emp_vinculo={$_SESSION["sys_id"]}";
							//if(isset($_GET['cod']) AND $_GET['cod']<>""){$sql.=" AND cod=".$_GET['cod'];}
							if(isset($_GET['cod']) AND $_GET['cod']<>""){
								$sql.=" AND cod=".$_GET['cod'];
								$hide="hide";
							}
							$rs_rel->FreeSql($sql);
							//echo $rs_rel->sql;
							$rs_rel->GeraDados();
							?>
							<tr class="bg-gray disabled color-palette">
								<th colspan=12><i>I. Dados Internos</i></th>
							</tr>
							<tr>
								<th>Inicio das Atividades</th>
								<th class="col-md-3">NIRE / Reg. Cart&oacute;rio</th>
								<th class="col-md-3">Data JUCESP</th>
								<th class="col-md-3">Arquivo (C&oacute;digo Tri&acirc;ngulo)</th>
							</tr>	
							<tr>
								<td class="col-md-3"><?=$fn->data_br($rs_rel->fld("emp_inicio"));?></td>
								<td class="col-md-3"><?=$rs_rel->fld("emp_nire");?></td>
								<td class="col-md-3"><?=$fn->data_br($rs_rel->fld("emp_datajucesp"));?></td>
								<td class="col-md-3"><?=$rs_rel->fld("cod");?></td>
							</tr>
							
							<tr class="bg-gray disabled color-palette">
								<th colspan="12"><i>II. Identifica&ccedil;&atilde;o do Estabelecimento</i></th>
							</tr>
							<tr>
								<th colspan=3>01. Razão Social</th>
								<th>02. Repons&aacute;vel</th>
							</tr>
							<tr>
								<td class="text-uppercase" colspan=3><?=$rs_rel->fld("empresa");?></td>
								<td><?=$rs_rel->fld("responsavel");?></td>
							</tr>
							<tr>
								<th colspan="2">03. Logradouro</th>
								<th>04. N&uacute;mero</th>
								<th>05. Complemento</th>
							</tr>	
							<tr>
								<td colspan="2"><?=$rs_rel->fld("emp_logradouro");?></td>
								<td><?=$rs_rel->fld("emp_numero");?></td>
								<td><?=$rs_rel->fld("emp_complemento");?></td>
							</tr>
							<tr>
								<th>06. Bairro</th>
								<th>07. Cidade</th>
								<th>08. Estado</th>
								<th>09. Cep</th>
							</tr>	
							<tr>
								<td><?=$rs_rel->fld("emp_bairro");?></td>
								<td><?=$rs_rel->fld("emp_cidade");?></td>
								<td><?=$rs_rel->fld("emp_uf");?></td>
								<td><?=$rs_rel->fld("emp_cep");?></td>
							</tr>
							<tr>
								<th>10. Telefone</th>
								<th>11. WebSite</th>
								<th colspan="2">12. E-Mail</th>
							</tr>	
							<tr>
								<td><?=$rs_rel->fld("telefone");?></td>
								<td><?=$rs_rel->fld("site");?></td>
								<td colspan="2"><?=$rs_rel->fld("email");?></td>	
							</tr>
							<tr class="bg-gray disabled color-palette">
								<th colspan="12"><i>III. Inscri&ccedil;&otilde;es e C&oacute;digos</i></th>
							</tr>
							<tr>
								<th>01. Inscri&ccedil;&atilde;o Estadual</th>
								<th>02. Inscri&ccedil;&atilde;o Municipal</th>
								<th>03. CNPJ / CEI</th>
								<th>04. Tributa&ccedil;&atilde;o</th>
							</tr>	
							<tr>
								<td><?=$rs_rel->fld("inscr");?></td>
								<td><?=$rs_rel->fld("emp_inscmun");?></td>
								<td><?=$rs_rel->fld("cnpj");?></td>	
								<td><?=$rs_rel->fld("tribut");?></td>	
							</tr>
							<tr>
								<th>05. Data I.E.</th>
								<th>06. Data I.M.</th>
								<th>07. Data CNPJ</th>
								<th>08. Data Tribut.</th>
							</tr>	
							<tr>
								<td><?=$fn->data_br($rs_rel->fld("emp_dataie"));?></td>
								<td><?=$fn->data_br($rs_rel->fld("emp_dataim"));?></td>
								<td><?=$fn->data_br($rs_rel->fld("emp_datacnpj"));?></td>	
								<td><?=$fn->data_br($rs_rel->fld("emp_datatrib"));?></td>	
							</tr>
							<tr class="bg-gray disabled color-palette">
								<th colspan="12"><i>IV. Capital Social e Integraliza&ccedil;&atilde;o</i></th>
							</tr>
							<tr>
								<th>01. Capital Social</th>
								<th>02. Forma de Integraliza&ccedil;&atilde;o</th>
								<th>03. CNAE</th>
								<th>04. Descri&ccedil;&atilde;o das Atividades</th>
							</tr>	
							<tr>
								<td>R$<?=number_format($rs_rel->fld("emp_capital"),2,".",",");?></td>
								<td><?=$rs_rel->fld("emp_integraliza");?></td>
								<td><?=$rs_rel->fld("cnae");?></td>	
								<td><?=$rs_rel->fld("emp_atividades");?></td>	
							</tr>
							<tr class="bg-danger">
								<th colspan="12"><i>V. Hist&oacute;rico de Ocorr&ecirc;ncias</i></th>
							</tr>
							<?php 
								$sql = "SELECT * FROM particularidades a
											JOIN usuarios b ON b.usu_cod = a.part_usu
										WHERE part_cod = ".$rs_rel->fld("cod")." AND part_depto IN(5,6,7,8,9) AND part_ativo=1 AND part_tipo >=7";
								$sql.=" ORDER BY part_id DESC";
								//echo $sql;
								$rs_rel->FreeSql($sql);
								if($rs_rel->linhas==0){?>
								<tr>
									<td colspan="4">
										Sem registros atuais de hist&oacute;ricos
									</td>
								</tr>
								<?php }
								else{
									
									$rs_rel->GeraDados(); 
									?>
									<tr>
										<td><?=$rs_rel->fld("part_titulo");?></td>
										<td><?=$rs_rel->fld("usu_nome");?></td>
										<td>Registrado em <?=$fn->data_br($rs_rel->fld("part_dataoc"));?></td>
										<td>Alterado em <?=$fn->data_hbr($rs_rel->fld("part_data"));?></td>
									</tr>
									<tr>
										<td colspan=4><?=$rs_rel->fld("part_obs");?></td>
									</tr>	
	
									<?php 
									
								}
							$dados = array();
							$times = 0;
							$dados['cpc_cli'] 		= $_GET['cod'];
							$dados['cpc_usuario'] 	= $_SESSION['usu_cod'];
							$dados['cpc_lastseen'] 	= date('Y-m-d H:i:s');
							if($_GET['gera']==1){
								$rs_atual->Seleciona("*","cpcviews","cpc_cli = ".$_GET['cod']." AND cpc_usuario=".$_SESSION['usu_cod']);
								if($rs_atual->linhas >0){
									$rs_atual->GeraDados();
									$times = $rs_atual->fld("cpc_times")+1;
									$dados['cpc_times'] 	= $times;
									$rs_atual->Altera($dados,"cpcviews","cpc_cli = ".$_GET['cod']." AND cpc_usuario=".$_SESSION['usu_cod']);
								}
								else{
									$dados['cpc_times'] 	= 1;
									$rs_atual->Insere($dados,"cpcviews");
								}
							}
							?>
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
