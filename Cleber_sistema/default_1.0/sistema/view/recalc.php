<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start();
$sec = "Mens";
$pag = "recalc.php";
require_once("../config/main.php");
require_once("../config/valida.php");
require_once("../config/mnutop.php");
require_once("../config/menu.php");
require_once("../config/modals.php");
require_once("../class/class.functions.php");
require_once("../class/class.permissoes.php");

$per = new permissoes();
$con = $per->getPermissao($pag);

$_hide = ($con['I']==0?"hide":"");
?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<!-- Content Header (Page header) -->
        <section class="content-header">
			<h1>
				Rec&aacute;lculos
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li>Solicita&ccedil;&atilde;o</li>
				<li class="active">Rec&aacute;lculos</li>
			</ol>
        </section>

        <!-- Main content -->
        <section class="content">
			<div class="row">
				<div class="col-md-12">
				<!-- general form elements -->
					<div class="box box-primary <?=$_hide;?>">
						<div class="box-header with-border">
							<h3 class="box-title">Solicitar Calculo</h3>
						</div><!-- /.box-header -->
						<!-- form start -->
						<form role="form" id="cad_Calc">
							<div class="box-body">
								<!-- radio Clientes -->
								<div id="clientes" class="row">
									<div class="form-group col-md-3">
										<label for="calc_emp">Cliente:</label><br>
										<select class="select2" name="calc_emp" id="calc_emp" style="width:100%;">
											<option value="">Selecione:</option>
										
										<?php
										$whr="ativo = 1";
										$rs->Seleciona("*","tri_clientes",$whr);
										while($rs->GeraDados()):	
										?>
											<option value="<?=$rs->fld("cod");?>"><?=$rs->fld("cod")." - ".$rs->fld("apelido");?></option>
										<?php
										endwhile;
										?>
										</select>
									</div>

									<div class="form-group col-md-3">
										<label for="calc_doc">Documento:</label><br>
										<select class="select2" name="calc_doc" id="calc_doc" style="width:100%;">
											<option value="0">Selecione:</option>
										
										<?php
										$whr="calc_id<>0";
										$rs->Seleciona("*","tipos_calc",$whr);
										while($rs->GeraDados()):	
										?>
											<option value="<?=$rs->fld("calc_id");?>"><?=$rs->fld("calc_desc");?></option>
										<?php
										endwhile;
										?>
										</select>
									</div>
								</div>
								<div class="row">
							
									<div class="form-group col-md-3">
										<label for="calc_comp">Compet&ecirc;ncia:</label>
										<input type="text" class="form-control input-sm shortdate" name="calc_comp" id="calc_comp"/>
									</div>
									
									<div class="form-group col-md-3">
										<label for="calc_qtd">Qtd:</label>
										<input type="text" class="form-control input-sm" name="calc_qtd" id="calc_qtd"/>
									</div>
									
									<div class="form-group col-md-3">
										<label for="calc_valor">Valor Un.:</label>
										<input type="text" class="form-control input-sm" name="calc_valor" id="calc_valor"/>
									</div>

									<div class="form-group col-md-3">
										<label for="calc_valort">Valor total:</label>
										<input type="text" READONLY class="form-control input-sm" name="calc_valort" id="calc_valort"/>
									</div>
									
									<div class="form-group col-md-12">
										<label for="calc_obs">Observa&ccedil;&atilde;o <small>(Opcional)</small></label>
										<textarea class="form-control input-sm" name="calc_obs" id="calc_obs"></textarea>
									</div>
									
								</div>
							<div id="consulta"></div>
							<div id="formerrosCalc" class="clearfix" style="display:none;">
								<div class="callout callout-danger">
									<h4>Erros no preenchimento do formul&aacute;rio.</h4>
									<p>Verifique os erros no preenchimento acima:</p>
									<ol>
										<!-- Erros são colocados aqui pelo validade -->
									</ol>
								</div>
							</div>
							
						</form>
					</div><!-- ./box -->
					<div class="box-footer">
						<button class="btn btn-sm btn-success" type="button" id="bt_recalc"><i class="fa fa-calculator"></i> Solicitar</button>
					</div>
					<?php
					/*
					$path = "C:";
					echo $path."\SYS_SQL.sql<br>";
					if(file_exists($path."SYS_SQL.sql")){
						echo "OK";
					}
					else{ echo "No";}
					*/
					?>
					
				</div><!-- ./row -->
				<div class="row">
					<div class="col-xs-12">
						<div class="box box-success" id="firms">
							<div class="box-header with-border">
								<h3 class="box-title">Rec&aacute;lculos Solicitados</h3>
							</div><!-- /.box-header -->
							<div class="box-body">
								 <div class="form-group col-md-4">
									<div class="row">
										<div class="input-group">
											<div class="input-group-addon">
												<i class="fa fa-lock"></i>
											 </div>
											<select name="rec_empresa" id="rec_empresa" class="form-control select2">
												<option value="">Selecione...</option>
												<?php
													$sql = "SELECT distinct(cod), apelido FROM tri_clientes a
																JOIN recalculos b ON a.cod = b.rec_cli 
															WHERE a.ativo = 1";
													$rs2->FreeSql($sql);
													while($rs2->GeraDados()){ ?>
														<option value="<?=$rs2->fld("cod");?>"><?=$rs2->fld("cod")." - ".$rs2->fld("apelido");?></option>
												<?php
													}
												?>
											</select>
										</div>
									</div>
								</div>

								<div class="form-group col-md-4">
										<div class="input-group">
											<div class="input-group-addon">
                        						<i class="fa fa-calendar"></i>
                      						</div>
                      						<input type="text" class="form-control pull-right" id="reservation">
                      						<input type="hidden" id="calc_di">
                      						<input type="hidden" id="calc_df">
										</div>
									
								</div>
								<div id="slc" class="box-body">
									<?php 
									require_once('vis_recalc.php');
									?>
								</div>
							
							</div>
							
						</div><!-- ./box -->
					</div><!-- ./col -->
				</div>
			</div>
		</section>
	</div>
	<?php
		require_once("../config/footer.php");
	?>
</div><!-- ./wrapper -->


<script src="<?=$hosted;?>/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="<?=$hosted;?>/js/jquery.cookie.js"></script>
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
<script src="<?=$hosted;?>/js/action_empresas.js"></script>
<script src="<?=$hosted;?>/js/controle.js"></script>
<script src="<?=$hosted;?>/js/functions.js"></script>


<!-- SELECT2 TO FORMS-->
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
<!--CHOSEN-->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.6.2/chosen.jquery.min.js"></script>
<!-- Validation -->
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<!-- date-range-picker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script src="<?=$hosted;?>/assets/plugins/daterangepicker/daterangepicker.js"></script>
<script src="<?=$hosted;?>/js/ui_datapicker_br.js"></script>

<script type="text/javascript">
	/*------------------------|INICIA TOOLTIPS E POPOVERS|---------------------------------------*/
	$(document).ready(function () {
		$(".chosen").chosen({
		 	no_results_text: "Sem resultados!"
		 });

		$("#bt_detalhe").click(function(){
			$("#emp_detalhe").modal({
				keyboard:true
			});
		});

		$(".select2").select2();
		setTimeout(function(){
			$("#alms").load(location.href+" #almsg");
		//	$("#slc").load("vis_recalc.php");		
		 },7500);

		$(document.body).on("keyup","#calc_qtd, #calc_valor",function(){
			var vt = ($("#calc_valor").val()==""?0:$("#calc_valor").val());
			var nqt = ($("#calc_qtd").val()==""?0:$("#calc_qtd").val());
			var num;
			num = vt * nqt;
			$("#calc_valort").val(num.toFixed(2));
		});
		
		$(document.body).on("change","#calc_doc",function(){
			$("#aguarde").modal("show");
			$.post("../controller/TRIEmpresas.php",
				{
					acao: 	"calc_docs",
					doc_cod:$(this).val() 	 
				},
				function(data){
					$("#calc_valor").val(data);
				},
				"html");
			$("#aguarde").modal("hide");
		});

		$('#reservation').daterangepicker({
			format: "DD/MM/YYYY",	
		},
		function(start, end){
			$("#calc_di").val(start.format("YYYY-MM-DD"));
			$("#calc_df").val(end.format("YYYY-MM-DD"));
		});
	});

</script>

</body>
</html>	