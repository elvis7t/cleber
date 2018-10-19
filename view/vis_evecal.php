<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start();
$sec = "CALEN";
$pag = "calendar.php";
//$pag = "irrf.php";
require_once("../config/main.php");
require_once("../config/valida.php");
require_once("../config/mnutop.php");
require_once("../config/menu.php");
require_once("../config/modals.php");
require_once("../class/class.functions.php");
require_once("../class/class.permissoes.php");

$per = new permissoes();
$con =$per->getPermissao($pag, $_SESSION['usu_cod']);
?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<!-- Content Header (Page header) -->
        <section class="content-header">
			<h1>
				Visualizar Eventos
				<small>Painel de Controle</small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active">Eventos</li>
			</ol>
        </section>

        <!-- Main content -->
        <section class="content">
			 <div class="row">
				<!-- left column -->
				<div class="col-md-12">
				<!-- general form elements -->
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">Evento</h3>
						</div><!-- /.box-header -->
						<!-- form start -->
						<?php
							$calid = $_GET['calid'];
							$rs = new recordset();
							$rs2 = new recordset();
							$fn = new functions();
							$sql_cal = "SELECT * FROM calendario a 
											JOIN eventos b ON a.cal_eveid = b.eve_id
										WHERE cal_id=".$calid;
							$rs->FreeSql($sql_cal);
							$rs->GeraDados();
							if(($rs->fld("cal_criado")==$_SESSION['usu_cod'])OR($_SESSION['classe']==1)){$per = "";}
							else{$per="DISABLED";}
							//echo $per;
						?>
						<form role="form" id="cal_alt">
							<div class="box-body">
								<div class="row">
									<div class="form-group col-xs-4">
										<label for="vcal_id">Id#</label>
										<input type="text" class="form-control" id="vcal_id" name="vcal_id" value="<?=$rs->fld("cal_id");?>" READONLY >
										<input type="hidden" id="token" value="<?=$_SESSION['token'];?>">
									</div>
									<div class="form-group col-xs-5">
										<label for="vcal_desc">Descri&ccedil;&atilde;o:</label>
										<input type="text" class="form-control" id="vcal_desc" name="vcal_desc" value="<?=$rs->fld("eve_desc");?>" READONLY >
									</div>
									<div class="form-group col-xs-3">
										<label for="vcal_desc">Criado Por:</label>
										<input type="text" class="form-control" id="vcal_cr" name="vcal_cr" value="<?=$rs2->pegar("usu_nome","usuarios","usu_cod=".$rs->fld("cal_criado"));?>" READONLY >
									</div>
								</div>
								<div class="row">
									<div class="form-group col-xs-3">
										<label for="vcal_datai">Data In&iacute;cio:</label>
										<input type="text" class="form-control " id="vcal_datai" name="vcal_datai" value="<?=$fn->data_br($rs->fld("cal_dataini"));?>" <?=$per;?> data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
									</div>
									<div class="form-group col-xs-3">
										<label for="vcal_horai">Hora In&iacute;cio:</label>
										<input type="text" class="form-control time" id="vcal_horai" name="vcal_horai" value="<?=$rs->fld("cal_horaini");?>" <?=$per;?> >
									</div>
									<div class="form-group col-xs-3">
										<label for="vcal_dataf">Data Fim:</label>
										<input type="text" class="form-control " id="vcal_dataf" name="vcal_dataf" value="<?=$fn->data_br($rs->fld("cal_datafim"));?>" <?=$per;?> data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
									</div>
									<div class="form-group col-xs-3">
										<label for="vcal_horaf">Hora Fim:</label>
										<input type="text" class="form-control time" id="vcal_horaf" name="vcal_horaf" value="<?=$rs->fld("cal_horafim");?>" <?=$per;?>>
									</div>
								</div>
								<div class="row">
									<div class="form-group col-xs-12">
										<label for="vcal_qpv">Quem est&aacute; vendo:</small></label>
										<select class="form-control select2" name="vcal_eveusu" id="vcal_eveusu" MULTIPLE>
										<?php
										$seld = $rs->fld("cal_eveusu");
										$sq = "SELECT * FROM usuarios WHERE usu_ativo='1'";
										$rs2->FreeSql($sq);
										$n="";
										$needle="";
										while($rs2->GeraDados()){
											$slc="";
											$needle= "[".$rs2->fld("usu_cod")."]";
											if(strstr( $seld, $needle)){
												$slc = "SELECTED";
												$n.="[".$rs2->fld("usu_cod")."]";
											}
											?>
											<option value="<?=$rs2->fld("usu_cod")?>" <?=$slc;?> ><?=$rs2->fld("usu_nome");?></option>
										<?php 
										}
										?>
										</select>
										
									</div>
								</div>
								<div class="row">
									<div class="form-group col-xs-12">
										<label for="vcal_obs">Observa&ccedil;&atilde;o: <small>(Opcional)</small></label>
										<textarea name="vcal_obs" id="vcal_obs" class='form-control' <?=$per;?>><?=$rs->fld("cal_obs");?></textarea>
									</div>
								</div>
								<div id="consulta"></div>
								<div id="formerros3" class="" style="display:none;">
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
								<button type="button" class="btn btn-sm btn-primary" type="button" id="bt_cal_alt"><i class="fa fa-pencil"></i> Alterar</button> 
								<a class="btn btn-sm btn-info" type="button" href="javascript:history.go(-1);"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
								<?php
								if($con['E']==1){?>
									<a href="javascript:baixa('<?=$rs->fld("cal_id");?>','exc_evecal','Deseja realmente excluir o evento')" class="btn btn-sm btn-danger pull-right" id="del_evecal"><i class="fa fa-trash"></i> Excluir</a>

								<?php }?>
							</div>
						</form>
					</div><!-- ./box -->
					
				</div><!-- ./col -->
				
			</div><!-- ./row -->
		</section>
	</div>

	<?php
		require_once("../config/footer.php");
		//require_once("../config/sidebar.php");
	?>
	</div><!-- ./wrapper -->

	<script src="<?=$hosted;?>/sistema/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
	<script src="<?=$hosted;?>/triangulo/js/jquery.cookie.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?=$hosted;?>/sistema/assets/bootstrap/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?=$hosted;?>/sistema/assets/plugins/fastclick/fastclick.min.js"></script>
	
    <!-- AdminLTE App -->
    <script src="<?=$hosted;?>/sistema/assets/dist/js/app.min.js"></script>
	<script src="<?=$hosted;?>/sistema/assets/dist/js/demo.js"></script>

	<script src="<?=$hosted;?>/sistema/assets/plugins/input-mask/jquery.inputmask.js"></script>
    <script src="<?=$hosted;?>/sistema/assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="<?=$hosted;?>/sistema/assets/plugins/input-mask/jquery.inputmask.extensions.js"></script>
  
   <!-- Slimscroll -->
    <script src="<?=$hosted;?>/sistema/assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="<?=$hosted;?>/sistema/assets/js/maskinput.js"></script>
    <script src="<?=$hosted;?>/sistema/assets/js/jmask.js"></script>
    <script src="<?=$hosted;?>/sistema/js/controle.js"></script>
    <script src="<?=$hosted;?>/sistema/js/action_irrf.js"></script>
    <script src="<?=$hosted;?>/sistema/js/action_triang.js"></script>
    <script src="<?=$hosted;?>/sistema/js/functions.js"></script>
	<script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>

	<!-- Validation -->
    <!--<script src="<?=$hosted;?>/js/jquery-validation/dist/jquery.validate.min.js"></script>-->
	<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
	<!-- SELECT2 TO FORMS-->
	<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
	
	<script>
		$(document).ready(function () {
			$(".select2").select2({
				tags: true,
				theme:"classic"
			});
		});
	// Atualizar a cada 7 segundos
		setTimeout(function(){
			$("#irrf_cli tbody").load("irrf_conRet.php?token=<?=$_SESSION['token'];?>&clicod=<?=$_GET['clicod'];?>");					 
			$("#alms").load(location.href+" #almsg");	
		 },10000);
		 // POPOVER
		$("#iret_tipo").on("change", function(){
			var tipo =$(this).val();
			//console.log(tipo);
			$("#IAR, #IAP").addClass("hide");
			$("#"+tipo).removeClass("hide");
		});
		 $(function () {
			// Replace the <textarea id="editor1"> with a CKEditor
			// instance, using default configuration.
			CKEDITOR.replace('vcal_obs');
		});


		$(".date").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/aaaa"});		
		
	</script>
</body>
</html>