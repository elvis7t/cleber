<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start("portal");
$sec = "IRRF";
$pag = "irpf_rel.php";
require_once("../config/main.php");
require_once("../config/valida.php");
require_once("../config/mnutop.php");
require_once("../config/menu.php");
require_once("../config/modals.php");
require_once("../../sistema/class/class.functions.php");

$rs_rel = new recordset();
?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<!-- Content Header (Page header) -->
        <section class="content-header">
			<h1>
				Relat&oacute;rios - IRPF
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li>IRPF</li>
				<li>Relat&oacute;rios</li>
				<li class="active">de Impostos de Renda</li>
			</ol>
        </section>

        <!-- Main content -->
        <section class="content">
			<?php 
				if(isset($_SESSION['classe'])){$classe = $_SESSION['classe'];}
				else{$classe=0;}
			?>
			<div class="row">
				<div class="col-md-12">
				<!-- general form elements -->
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">Filtros</h3>
						</div><!-- /.box-header -->
						<!-- form start -->
						<form role="form" id="rels">
							<div class="box-body">
								<!-- radio Clientes -->
								<div class="row">
									<div class="form-group col-xs-2">
										<label for="rel_di">Data Inicial:</label>
										<input type="text" class="form-control input-sm date" name="rel_di" id="rel_di" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask/>
									</div>
									<div class="form-group col-xs-2">
										<label for="rel_df">Data Final:</label>
										<input type="text" class="form-control input-sm date" name="rel_df" id="rel_df" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask/>
									</div>
									<div class="form-group col-xs-1">
										<label for="rel_df">Periodo:</label>
										<input type="text" class="form-control input-sm" name="rel_per" id="rel_per" maxlength="4" />
									</div>
									<div class="form-group col-xs-2">
										<label for="rel_nome">Status <small>(opcional)</small>:</label><br>
										<select class="select2 input-sm" name="rel_status" id="rel_status" style="width:100%;">
											<option value="">Selecione:</option>
											<?php
											$sql = "SELECT st_codstatus, st_desc FROM codstatus WHERE st_opcaode like '%[IRPF]%'";
											$rs_rel->FreeSql($sql);
											while($rs_rel->GeraDados()){
											?>
												<option value="<?=$rs_rel->fld("st_codstatus");?>"><?=$rs_rel->fld("st_desc");?></option>
											<?php
											}
											?>
										</select>
									</div>

									<div class="form-group col-xs-4">
										<label for="rel_solic">Alterado Por <small>(opcional)</small>:</label><br>
										<select class="select2 input-sm" name="rel_altera" id="rel_altera">
											<option value="">Selecione:</option>
											<?php
											$sql = "SELECT usu_nome, usu_cod FROM usuarios WHERE usu_emp_cnpj='".$_SESSION['usu_empresa']."' AND usu_classe IN(1,2)";
											$rs_rel->FreeSql($sql);
											while($rs_rel->GeraDados()){
											?>
												<option value="<?=$rs_rel->fld("usu_cod");?>"><?=$rs_rel->fld("usu_nome");?></option>
											<?php
											}

											?>
										</select>
									</div>
								</div>
								<div class="row">
									<div class="form-group col-xs-2">
										<label for="rel_di">Valor de <small>(opcional)</small>:</label></label>
										<input type="text" class="form-control input-sm" name="rel_vlde" id="rel_vlde"/>
									</div>
									<div class="form-group col-xs-2">
										<label for="rel_df">Valor at&eacute; <small>(opcional)</small>:</label></label>
										<input type="text" class="form-control input-sm" name="rel_vate" id="rel_vate"/>
									</div>
									<div class="form-group col-xs-2">
										<label for="rel_df">Pago? <small>(opcional)</small>:</label></label>
										<select class="select2 form-control input-sm" name="rel_pago" id="rel_pago">
											<option value="" SELECTED>Selecione...</option>
											<option value=1>Sim</option>
											<option value=0>N&atilde;o</option>
										</select>
									</div>
									<div class="form-group col-xs-2">
										<label for="rel_df">Pend&ecirc;ncia? <small>(opcional)</small>:</label></label>
										<select class="select2 form-control input-sm" name="rel_pend" id="rel_pend">
											<option value="" SELECTED>Selecione...</option>
											<option value=1>Sim</option>
											<option value=0>N&atilde;o</option>
										</select>
									</div>
									<div class="form-group col-xs-3">
										<label for="rel_df">Retorno <small>(opcional)</small>:</label></label>
										<select class="select2 form-control input-sm" name="rel_retorno" id="rel_retorno">
											<option value="" SELECTED>Selecione...</option>
											<option value="SSI">Sem Saldo de Imposto</option>
											<option value="IAP">Imposto a Pagar</option>
											<option value="IAR">Imposto a Receber</option>
										</select>
									</div>
								</div>
							</div>
							
							<div class="box-footer">
								<button class="btn btn-sm btn-primary" type="button" id="bt_irver"><i class="fa fa-pie-chart"></i> Gerar Relat&oacute;rio</button>
								<span id="spload" style="display:none;"><i id="load"></i></span>
							</div>
						</form>
					</div><!-- ./box -->
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
				<!-- general form elements -->
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3>
								<i class="fa fa-globe"></i> <?=$rs_rel->pegar("emp_nome","empresas","emp_cnpj = '".$_SESSION['usu_empresa']."'");?>
								<small class="pull-right">Data: <?=date("d/m/Y");?></small>
							</h3>
						</div><!-- /.box-header -->
						
						
						<div class="box-body">
							<div class="row invoice-info">
								<div class="col-sm-4 invoice-col">
								  Usu&aacute;rio
								  <address>
									<strong><?=$_SESSION['nome_usu'];?></strong><br>
									<i class="fa fa-envelope"></i> <?=$_SESSION['usuario'];?>
								  </address>
								</div><!-- /.col -->
								
							</div><!-- /.row -->
							<div class="row">
								<div class="col-xs-12 table-responsive">
								  <table class="table table-striped">
									<thead>
									  <tr><th colspan=7><h2>Relat&oacute;rio de Declara&ccedil;&otilde;es IRPF</h2></th></tr>
									  <tr>
										<th>#</th>
										<th>Tipo</th>
										<th>Doc.</th>
										<th>Nome</th>
										<th>Periodo</th>
										<th>Valor Anterior</th>
										<th>Valor Atual</th>
										<th>Entrada</th>
										<th>Status</th>
										<th>&Uacute;lt. Altera&ccedil;&atilde;o</th>
									  </tr>
									</thead>
									<tbody id="rls">
										
									 </tbody>
								  </table>
								</div><!-- /.col -->
							</div><!-- /.row -->
							 <div class="row no-print">
								<div class="col-xs-12">
								  <a id="bt_IR_print" href="#" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Imprimir</a>
								  <!--<button class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-file-pdf-o"></i> Gerar PDF</button>-->
								  <a id="bt_excel" href="#" class="btn btn-success pull-right" style="margin-right: 5px;"><i class="fa fa-file-excel-o"></i> Gerar Excel</a>
								</div>
							  </div>
							
						</div>
							
						
					</div><!-- ./box -->
				</div>
			</div>
			
		</section>	
	</div>
	
	<?php
		require_once("../config/footer.php");
	?></div><!-- ./wrapper -->

<script src="<?=$hosted;?>/sistema/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="<?=$hosted;?>/sistema/assets/bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="<?=$hosted;?>/sistema/assets/plugins/fastclick/fastclick.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=$hosted;?>/sistema/assets/dist/js/app.min.js"></script>
<!-- Slimscroll -->
<script src="<?=$hosted;?>/sistema/assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="<?=$hosted;?>/sistema/assets/js/maskinput.js"></script>
<script src="<?=$hosted;?>/sistema/assets/js/jmask.js"></script>
<script src="<?=$hosted;?>/sistema/js/action_irrf.js"></script>
<script src="<?=$hosted;?>/sistema/js/controle.js"></script>
<script src="<?=$hosted;?>/sistema/js/jquery.cookie.js"></script>
<script src="<?=$hosted;?>/sistema/js/functions.js"></script>

<script src="<?=$hosted;?>/sistema/assets/plugins/input-mask/jquery.inputmask.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- SELECT2 TO FORMS
-->
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
<!-- Validation -->
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
	<script>
		$(".select2").select2({
			tags: true
		});
		$(".date").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/aaaa"});			
		
	</script>

</body>
</html>