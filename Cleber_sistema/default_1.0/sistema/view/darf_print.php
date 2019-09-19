<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start();
$sec = "IRRF";
$pag = "darf_print.php";
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
				Impress&atilde;o de DARF Mensal - IRPF
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li>IRPF</li>
				<li>DARF</li>
				<li class="active">de Impostos de Renda</li>
			</ol>
        </section>

        <!-- Main content -->
        <section class="content">
			<?php 
				if(isset($_SESSION['classe'])){$classe = $_SESSION['classe'];}
				else{$classe=0;}
			?>
			<!--<div class="row">
				<div class="col-md-12">
				<!-- general form elements >
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">Solicitar Contato</h3>
						</div><!-- /.box-header
						<!-- form start >
						<form role="form" id="cad_sol">
							
							<div class="box-body">
							<!-- radio Clientes 
								<div id="clientes" class="row">
									<div class="form-group col-xs-3">
										<label for="emp_cnpj">Cota</label><br>
										<select class="select2" name="rel_ref" id="rel_ref" style="width:100%">
											<option value=1>Cota 1</option>
											<option value=2>Cota 2</option>
											<option value=3>Cota 3</option>
											<option value=4>Cota 4</option>
											<option value=5>Cota 5</option>
											<option value=6>Cota 6</option>
											<option value=7>Cota 7</option>
											<option value=8>Cota 8</option>
						
										</select>
									</div>
								</div>
							</div>
							
							<div class="box-footer">
								<a class="btn btn-sm btn-success"
								href="#"
								id="bt_darf"
								><i class="fa fa-sort-alpha-desc"></i> Filtrar</a>
								
							</div>
						</form>
					</div><!-- ./box -->
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
								  <table id="tb_darf" class="table table-striped">
									<thead>
									<tr>
										<!--<th>Retorno</th>
										<th>Doc.</th>-->
										<th># ID Retorno</th>
										<th>Nome</th>
										<th>Dt Lib.</th>
										<th>Valor</th>
										<th>Parcela</th>
										<th>Data Pagto</th>
										<th>A&ccedil;&otilde;es</th>
									</tr>
								</thead>
									<tbody id="rls">
										<!-- Conteúdo dinamico PHP-->
										<?php require_once("irpf_conDarfQuota.php"); ?>
									 </tbody>
								  </table>
								</div><!-- /.col -->
							</div><!-- /.row -->
							<!--
							 <div class="row no-print">
								<div class="col-xs-12">
								  <a id="bt_IR_print" href="#" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Imprimir</a>
								  <!--<button class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-file-pdf-o"></i> Gerar PDF</button>
								  <a id="bt_excel" href="#" class="btn btn-success pull-right" style="margin-right: 5px;"><i class="fa fa-file-excel-o"></i> Gerar Excel</a>
								</div>
							  </div>
							  -->
							
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
        <script src="<?=$hosted;?>/js/controle.js"></script>
    <script src="<?=$hosted;?>/js/action_irrf.js"></script>
    <script src="<?=$hosted;?>/js/jquery.cookie.js"></script>
    <script src="<?=$hosted;?>/js/functions.js"></script>
	<!--SELECT2 TO FORMS-->
	<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
	<!-- Validation -->
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <!--datatables-->
    <script src="<?=$hosted;?>/assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?=$hosted;?>/assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script src="<?=$hosted;?>/js/dtables_pt.js"></script>
	<script>
		$(".select2").select2({
			tags: true,
			theme: "classic"
		});
	</script>

</body>
</html>	