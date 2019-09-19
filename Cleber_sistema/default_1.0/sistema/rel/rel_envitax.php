<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start();
$sec = "Rels";
$pag = "../rel/rel_envitax.php";
require_once("../config/main.php");
require_once("../config/valida.php");
require_once("../config/mnutop.php");
require_once("../config/menu.php");
require_once("../config/modals.php");
require_once("../class/class.functions.php");

$rs_rel = new recordset();
?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<!-- Content Header (Page header) -->
        <section class="content-header">
			<h1>
				Relat&oacute;rios - Impostos
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li>Relat&oacute;rios</li>
				<li class="active">Envio de Impostos</li>
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
						<form role="form" id="rels_imp">
							<div class="box-body">
								<!-- radio Clientes -->
								<div class="row">
									<div class="form-group col-xs-2">
										<label for="imp_comp">Compet&ecirc;ncia:</label>
										<input type="text" class="form-control input-sm shortdate" name="imp_comp" id="imp_comp" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask/>
									</div>
									<div class="form-group col-xs-3">
										<label for="imp_dep">Departamento:</label><BR>
										<select class="select2 input-sm" name="imp_dep" id="imp_dep" style="width:100%;">
											<option value="">Selecione:</option>
											<?php
											$sql = "SELECT * FROM departamentos";
											$rs_rel->FreeSql($sql);
											while($rs_rel->GeraDados()){
											?>
												<option value="<?=$rs_rel->fld("dep_id");?>"><?=$rs_rel->fld("dep_nome");?></option>
											<?php
											}
											?>
										</select>
									</div>	
									<div class="form-group col-xs-3">
										<label for="imp_colab">Colaborador:</label><BR>
										<select class="select2 input-sm" name="imp_colab" id="imp_colab" style="width:100%;">
											<option value="">Selecione:</option>
											<?php
											$sql = "SELECT * FROM usuarios WHERE usu_ativo='1'";
											$rs_rel->FreeSql($sql);
											while($rs_rel->GeraDados()){
											?>
												<option value="<?=$rs_rel->fld("usu_cod");?>"><?=$rs_rel->fld("usu_nome");?></option>
											<?php
											}
											?>
										</select>
									</div>
									<div class="form-group col-xs-4">
										<label for="imp_empresa">Empresa:</label><BR>
										<select class="select2 input-sm" multiple name="imp_empresa" id="imp_empresa" style="width:100%;">
											<option value="">Todas</option>
											<?php
											$sql = "SELECT * FROM tri_clientes WHERE ativo=1";
											$rs_rel->FreeSql($sql);
											while($rs_rel->GeraDados()){
											?>
												<option value="<?=$rs_rel->fld("cod");?>"><?=$rs_rel->fld("cod")." - ".$rs_rel->fld("apelido");?></option>
											<?php
											}
											?>
										</select>
									</div>		
								</div>
								<div class="row">
									<div class="form-group col-xs-3">
										<label for="imp_mov">Mov. Por:</label><BR>
										<select class="select2 input-sm" name="imp_mov" id="imp_mov" style="width:100%;">
											<option value="">Selecione:</option>
											
										</select>
									</div>
									<div class="form-group col-xs-3">
										<label for="imp_ger">Gerado Por:</label><BR>
										<select class="select2 input-sm" name="imp_ger" id="imp_ger" style="width:100%;">
											<option value="">Selecione:</option>
											<?php
											$sql = "SELECT * FROM usuarios WHERE usu_ativo='1'";
											$rs_rel->FreeSql($sql);
											while($rs_rel->GeraDados()){
											?>
												<option value="<?=$rs_rel->fld("usu_cod");?>"><?=$rs_rel->fld("usu_nome");?></option>
											<?php
											}
											?>
										</select>
									</div>
									<div class="form-group col-xs-3">
										<label for="imp_conf">Conferido Por:</label><BR>
										<select class="select2 input-sm" name="imp_conf" id="imp_conf" style="width:100%;">
											<option value="">Selecione:</option>
											<?php
											$sql = "SELECT * FROM usuarios WHERE usu_ativo='1'";
											$rs_rel->FreeSql($sql);
											while($rs_rel->GeraDados()){
											?>
												<option value="<?=$rs_rel->fld("usu_cod");?>"><?=$rs_rel->fld("usu_nome");?></option>
											<?php
											}
											?>
										</select>
									</div>
									<div class="form-group col-xs-3">
										<label for="imp_env">Enviado Por:</label><BR>
										<select class="select2 input-sm" name="imp_env" id="imp_env" style="width:100%;">
											<option value="">Selecione:</option>
											<?php
											$sql = "SELECT * FROM usuarios WHERE usu_ativo='1'";
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
									<div class="form-group col-xs-3">
										<label for="imp_tipo">Imposto:</label><BR>
										<select class="select2 input-sm" name="imp_tipo" id="imp_tipo" style="width:100%;">
											<option value="">Selecione:</option>
											<?php
											$sql = "SELECT * FROM tipos_impostos WHERE imp_ativo=1";
											$rs_rel->FreeSql($sql);
											while($rs_rel->GeraDados()){
											?>
												<option value="<?=$rs_rel->fld("imp_id");?>"><?=$rs_rel->fld("imp_nome");?></option>
											<?php
											}
											?>
										</select>
									</div>
									<div class="form-group col-xs-3">
										<label for="imp_trib">Tributa&ccedil;&atilde;o Por:</label><BR>
										<select class="select2 input-sm" name="imp_trib" id="imp_trib" style="width:100%;">
											<option value="">Selecione:</option>
											<option value="LP">Lucro Presumido</option>
											<option value="LR">Lucro Real</option>
											<option value="SN">Simples Nacional</option>
											
										</select>
									</div>
								</div>
								<div id="consulta"></div>
								<div id="formerrosimps" class="clearfix" style="display:none;">
									<div class="callout callout-danger">
										<h4>Erros no preenchimento do formul&aacute;rio.</h4>
										<p>Verifique os erros no preenchimento acima:</p>
										<ol>
											<!-- Erros são colocados aqui pelo validade -->
										</ol>
									</div>
								</div>						
							</div>
							
							<div class="box-footer">
								<button class="btn btn-sm btn-primary" type="button" id="bt_ver_impenvios"><i class="fa fa-pie-chart"></i> Gerar Relat&oacute;rio</button>
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
								<div class="col-xs-12">
								  <table class="table  table-responsive table-condensed">
									<thead>
									  <tr><th colspan=4><h2>Relat&oacute;rio de Envio de Impostos</h2></th></tr>
									  <tr>
										<th>Imposto</th>
										<th>Compet.</th>
										<th>Mov</th>
										<th>Mov por</th>
										<th>Mov em</th>
										<th>Ger. por</th>
										<th>Ger. em</th>
										<th>Conf. por</th>
										<th>Conf. em</th>
										<th>Env. por</th>
										<th>Env. em</th>
										<!--<th>TTP</th>-->
										
									  </tr>
									</thead>
									<tbody id="rls">
										
									 </tbody>
								  </table>
								</div><!-- /.col -->
							</div><!-- /.row -->
							 <div class="row no-print">
								<div class="col-xs-12">
								 <!-- <a id="bt_print" href="#" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Imprimir</a>-->
								  <!--<button class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-file-pdf-o"></i> Gerar PDF</button>-->
								  <a id="bt_impenvios_excel" href="#" class="btn btn-success pull-right" style="margin-right: 5px;"><i class="fa fa-file-excel-o"></i> Gerar Excel</a>
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

<script src="<?=$hosted;?>/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?=$hosted;?>/assets/bootstrap/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?=$hosted;?>/assets/plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?=$hosted;?>/assets/dist/js/app.min.js"></script>
   <!-- Slimscroll -->
    <script src="<?=$hosted;?>/assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="<?=$hosted;?>/assets/js/maskinput.js"></script>
    <script src="<?=$hosted;?>/assets/js/jmask.js"></script>

    <script src="<?=$hosted;?>/assets/plugins/input-mask/jquery.inputmask.js"></script>
    <script src="<?=$hosted;?>/assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="<?=$hosted;?>/assets/plugins/input-mask/jquery.inputmask.extensions.js"></script>

    <script src="<?=$hosted;?>/js/jquery.cookie.js"></script>
    <script src="<?=$hosted;?>/js/functions.js"></script>	

    <script src="<?=$hosted;?>/assets/js/controle.js"></script>
    <script src="<?=$hosted;?>/js/action_triang.js"></script>
	<!-- SELECT2 TO FORMS
	-->
	<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
	<!--CHOSEN-->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.6.2/chosen.jquery.min.js"></script>
	<!-- Validation -->
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
	<script>
		$(function(){
			$(".select2").select2({
				tags: true
			});
			$("#imp_empresa").select2({
				tags: true,
				theme:"classic"
			});

			$('[data-toggle="popover"]').popover({html:true});
			//$(".date").inputmask("mm/yyyy", {"placeholder": "mm/aaaa"});	
		
			
			
		});

	</script>

</body>
</html>	