<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start();
$sec = "Rels";
$pag = "../rel/rel_saidas.php";
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
				Relat&oacute;rios - Sa&iacute;das
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li>Relat&oacute;rios</li>
				<li class="active">Sele&ccedil;&atilde;o</li>
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
									<div class="form-group col-xs-4">
										<label for="sai_emp">Empresa:</label><BR>
										<select class="select2 input-sm" name="sai_emp" id="sai_emp" style="width:100%;">
											<option value="">Selecione:</option>
											<?php
											$sql = "SELECT * FROM tri_clientes WHERE ativo = 1";
											$rs_rel->FreeSql($sql);
											while($rs_rel->GeraDados()){
											?>
												<option value="<?=$rs_rel->fld("cod");?>"><?=$rs_rel->fld("cod")." - ".$rs_rel->fld("empresa");?></option>
											<?php
											}
											?>
										</select>
									</div>	
									<div class="form-group col-xs-2">
										<label for="dsai_di">Data Inicial:</label>
										<input type="text" class="form-control input-sm date" name="dsai_di" id="dsai_di" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask/>
									</div>
									<div class="form-group col-xs-2">
										<label for="dsai_df">Data Final:</label>
										<input type="text" class="form-control input-sm date" name="dsai_df" id="dsai_df" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask/>
									</div>
									<div class="form-group col-xs-3">
										<label for="sai_status">Status:</label><br>
										<select class="input-sm select2" name="sai_status" id="sai_status" style="width:100%;">
											<option value="">Selecione:</option>
											<?php
											$sql = "SELECT * FROM codstatus WHERE st_opcaode='[SOLIC]'";
											$rs_rel->FreeSql($sql);
											while($rs_rel->GeraDados()){
											?>
												<option value="<?=$rs_rel->fld("st_codstatus");?>"><?=$rs_rel->fld("st_desc");?></option>
											<?php
											}
											?>
										</select>
									</div>
								</div>
								
							</div>
							
							<div class="box-footer">
								<button class="btn btn-sm btn-primary" type="button" id="bt_ver_saidas"><i class="fa fa-pie-chart"></i> Gerar Relat&oacute;rio</button>
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
									  <tr><th colspan=4><h2>Relat&oacute;rio de Documentos</h2></th></tr>
									  <tr>
										<th>Empresa</th>
										<th>Data</th>
										<th>Cadast. Por</th>
										<th>Status</th>
										
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
								  <a id="bt_saidas_excel" href="#" class="btn btn-success pull-right" style="margin-right: 5px;"><i class="fa fa-file-excel-o"></i> Gerar Excel</a>
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
		 $(".chosen").chosen({
		 	no_results_text: "Sem resultados!"
		 }); 

		$(".select2").select2({
			tags: true
		});
		$('[data-toggle="popover"]').popover({html:true});
		$(".date").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/aaaa"});		
		
	</script>

</body>
</html>	