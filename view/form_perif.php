<?php
/*inclusão dos principais itens da página */

$sec = "COMP";
$pag = "novo_periferico.php";
require_once("../config/main.php");
require_once("../config/valida.php");
require_once("../config/mnutop.php");
require_once("../config/menu.php");
require_once("../config/modals.php");
require_once("../class/class.functions.php");
require_once("../class/class.permissoes.php");
$per = new permissoes();
$con =$per->getPermissao($pag,$_SESSION['usu_cod']);
$rs= new recordset();
$rs2= new recordset();
$hide= "";
										
?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<!-- Content Header (Page header) -->
        <section class="content-header">
			<h1>
				Máquinas
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li>Solicita&ccedil;&atilde;o</li>
				<li class="active">Periféricos</li>
			</ol>
        </section>
        <!-- Main content -->
        <section class="content">
			<div class="row">
			<div class="col-md-12">
				<!-- general form elements -->
					<div class="box box-primary	">
						<div class="box-header with-border">
							<h3 class="box-title">Periféricos</h3>
						</div><!-- /.box-header -->
						<!-- form start -->
						<form role="form" id="cad_maq">
							<div class="box-body">
								<div class="row">
									<?php
									if(isset($_GET['perid'])){
										$whr = " WHERE per_id=".$_GET['perid'];
										$sql = "SELECT * FROM perifericos a
								        			LEFT JOIN maquinas b ON a.per_maqid = b.maq_id
								        		".$whr;
								        $rs2->FreeSql($sql);
								        //echo $rs2->sql;
								        if($rs2->linhas>0){
								        	$hide = "hide";
								        	$rs2->GeraDados();
								        }
										
									}
									?>
									<div class="form-group col-md-3">
										<label for="maq_login">Tipo:</label>
										<div class="input-group">
											<div class="input-group-btn">
											<button type="button"  <?=$hide;?> class="btn btn-warning dropdown-toggle" id="btac" data-toggle="dropdown">Selecione <span class="fa fa-caret-down"></span></button>
											<ul class="dropdown-menu">
												<li><a href="javascript:perf('Mouse','mouse-pointer','btac','per_tipo')"><i class="fa fa-mouse-pointer"></i>Mouse</a></li>
												<li><a href="javascript:perf('Teclado','keyboard-o','btac','per_tipo')"><i class="fa fa-keyboard-o"></i>Teclado</a></li>
												<li><a href="javascript:perf('Monitor','television','btac','per_tipo')"><i class="fa fa-television"></i>Monitor</a></li>
												<li class="divider"></li>
												<li><a href="javascript:perf('Estabilizador','plug','btac','per_tipo')"><i class="fa fa-plug"></i>Estabilizador</a></li>
												<li><a href="javascript:perf('HD_Externo','hdd-o','btac','per_tipo')"><i class="fa fa-hdd-o"></i>HD Externo</a></li>
												<li><a href="javascript:perf('Scanner','file-image-o','btac','per_tipo')"><i class="fa fa-file-image-o"></i>Scanner</a></li>
												<li><a href="javascript:perf('Toner','battery-full','btac','per_tipo')"><i class="fa fa-battery-full"></i>Toner</a></li>
												<li><a href="javascript:perf('Leitor_A3','credit-card','btac','per_tipo')"><i class="fa fa-credit-card"></i>Leitor A3</a></li>
											</ul>
											</div><!-- /btn-group -->
											<input type="text" class="form-control" disabled="" value="<?=$rs2->fld("per_tipo");?>" name="per_tipo" id="per_tipo"/>
											<input type="hidden" id="perid" value="<?=$rs2->fld("per_id");?>">
										</div><!-- /input-group -->
									</div>
									<div class="form-group col-md-3">
										<label for="maq_user">Modelo:</label>
										<input type="text" class="form-control" id="per_modelo" name="per_modelo" value="<?=$rs2->fld("per_modelo");?>" />
										<input type="hidden" value="<?=$_SESSION["token"];?>" id="token"/>
										<input type="hidden" value="<?=$_SESSION["cnpj_emp"];?>" id="cnpj"/>
									</div>

									<div class="form-group col-md-6">
										<label for="maq_user">Associar à máquina:</label>
										<select class="form-control select2" id="per_assoc" name="per_assoc" >
											<option value="0">Selecione...</option>
											<?php
												$sql = "SELECT maq_id, maq_ip, maq_user, maq_usuario, b.usu_nome FROM maquinas 
															JOIN usuarios b ON b.usu_cod = maq_user
														WHERE maq_ativa=1";
												$rs->FreeSql($sql);
												
												while($rs->GeraDados()){ ?>
													<option <?=($rs2->fld("per_maqid")==$rs->fld("maq_id") ? "SELECTED":"");?> value="<?=$rs->fld("maq_id");?>"><?=$rs->fld("maq_ip")." - ".$rs->fld("maq_usuario")." - ".$rs->fld("usu_nome");?></option>
												<?php }
											?>
										</select>
									</div>
								</div>

								<div class="row">
									<div class="form-group col-md-3">
										<label for="maq_sys">NSR <small> Serial Number</small>:</label>
										<input type="text" class="form-control" value="<?=$rs2->fld("per_status");?>" name="per_status" id="per_status"/>
									</div>
								
									<div class="form-group col-md-3">
										<div class="input-group">
											<label for="maq_sys">Status:</label><br>
											<input type="checkbox" <?=($rs2->fld("per_ativo")==1 ? "CHECKED" :"");?> name="per_ativo" id="per_ativo"> Item Ativo
										</div>
									</div>
								</div>
								
							<div id="consulta"></div>
							<div id="formerros1" class="clearfix" style="display:none;">
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
							<button class="btn btn-sm btn-success <?=$hide;?>" type="button" id="bt_newPer"><i class="fa fa-plus"></i> Adicionar</button>
							<?php
							if($con['A']==1 AND $hide<>""){ ?>
							<button class="btn btn-sm btn-primary" type="button" id="bt_altPer"><i class="fa fa-pencil"></i> Alterar</button>
							<?php } ?>
						</div>
						</form>
					</div><!-- ./box -->
									</div><!-- ./col -->
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

<!-- InputMask -->
<script src="<?=$hosted;?>/sistema/assets/plugins/input-mask/jquery.inputmask.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/input-mask/jquery.inputmask.extensions.js"></script>

<script src="<?=$hosted;?>/sistema/assets/js/maskinput.js"></script>
<script src="<?=$hosted;?>/sistema/assets/js/jmask.js"></script>
<script src="<?=$hosted;?>/sistema/js/action_maquinas.js"></script>
<script src="<?=$hosted;?>/sistema/js/controle.js"></script>
<script src="<?=$hosted;?>/sistema/js/jquery.cookie.js"></script>
<script src="<?=$hosted;?>/sistema/js/functions.js"></script>


<!-- SELECT2 TO FORMS-->
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
<!--CHOSEN-->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.6.2/chosen.jquery.min.js"></script>
<!-- Validation -->
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script>
	/*------------------------|INICIA TOOLTIPS E POPOVERS|---------------------------------------*/
	$(document).ready(function () {
		$("[data-mask]").inputmask();

		$(".select2").select2({
			tags: true
		});

		$(".chosen").chosen({
		 	no_results_text: "Sem resultados!"
		 }); 

		$("#chatContent").scrollTop($("#msgs").height());					
		setTimeout(function(){
			$("#alms").load(location.href+" #almsg");
		 },10000);
	});
	function perf(peri, classe, bt, tx){
		$("#"+bt).html("<i class='fa fa-"+classe+"'></i>");
		$("#"+tx).val(peri);
		console.log(peri);
	}
</script>

</body>
</html>	