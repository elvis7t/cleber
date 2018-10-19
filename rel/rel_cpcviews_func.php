<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start();
$sec = "Rels";
$pag = "../rel/rel_cpcviews.php";
require_once("../config/main.php");
require_once("../config/valida.php");
require_once("../config/mnutop.php");
require_once("../config/menu.php");
require_once("../../sistema/config/modals.php");
require_once("../../sistema/class/class.functions.php");

$rs_rel = new recordset();
$func = new functions();
?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<!-- Content Header (Page header) -->
        <section class="content-header">
			<h1>
				Relat&oacute;rios - CPC por Funcion&aacute;rio
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li>Relat&oacute;rios</li>
				<li class="active">Sele&ccedil;&atilde;o</li>
			</ol>
        </section>

        <!-- Main content -->
        <section class="content">
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
									  <tr><th colspan=2><h2>CPCs - Por Colaborador</h2></th></tr>
									  <tr>
										<th>Colaborador</th>
										<th>Visto em</th>
																		
									  </tr>
									</thead>
										<tbody>
											<?php
												extract($_GET);
												if(isset($_SESSION['classe'])){$classe = $_SESSION['classe'];}
												else{$classe=0;}
												$sql = "SELECT * FROM cpcviews a
													JOIN tri_clientes b ON a.cpc_cli = b.cod
													JOIN usuarios ON a.cpc_usuario = usu_cod
												WHERE 1";
												$filtro = "";
												if(isset($emp) AND $emp<>""){
													$sql.=" AND cpc_cli = ".$emp;
													$filtro.= "Empresa: ".$emp."<br>";
												}

												if(isset($di) AND $di<>""){
													$sql.=" AND cpc_lastseen >='".$func->data_usa($di)." 00:00:00'";
													$filtro.= "Data Inicial: ".$di."<br>";
												}
												if(isset($df) AND $df<>""){
													$sql.=" AND cpc_lastseen <='".$func->data_usa($df)." 23:59:59'";
													$filtro.= "Data Final: ".$df."<br>";
												}
												$sql.=" GROUP BY usu_cod ORDER BY cpc_lastseen ASC";
												//echo $sql;
												$rs_rel->FreeSql($sql);
									
											while($rs_rel->GeraDados()):
												?>
													
												<tr>
													<td><?=$rs_rel->fld("usu_nome");?></td>
													<td><?=$func->data_hbr($rs_rel->fld("cpc_lastseen"));?></td>
												</tr>
													
												<?php endwhile;
												echo "<tr><td colspan=4><strong>".$rs_rel->linhas." Registros</strong></td></tr>";
												echo "<tr><td colspan=4><address>".$filtro."</address></td></tr>";

												?>
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

    <script src="<?=$hosted;?>/sistema/assets/plugins/input-mask/jquery.inputmask.js"></script>
    <script src="<?=$hosted;?>/sistema/assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="<?=$hosted;?>/sistema/assets/plugins/input-mask/jquery.inputmask.extensions.js"></script>

    <script src="<?=$hosted;?>/triangulo/js/jquery.cookie.js"></script>
    <script src="<?=$hosted;?>/sistema/assets/js/controle.js"></script>
    <script src="<?=$hosted;?>/triangulo/js/action_triang.js"></script>
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