<?php
/*inclusão dos principais itens da página */
$sec = "COMP";
$pag = "maquinas.php";
require_once("../config/main.php");
require_once("../config/valida.php");
require_once("../config/mnutop.php");
require_once("../config/menu.php");
require_once("../config/modals.php");
require_once("../class/class.functions.php");
require_once("../class/class.permissoes.php");
$per = new permissoes();
$con =$per->getPermissao($pag,$_SESSION['usu_cod']);
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
				<li class="active">Máquinas</li>
			</ol>
        </section>
        <?php
        
        	$hide="";
	        $iplocal = (isset($_GET['ip']) ? $_GET['ip'] : getenv('REMOTE_ADDR'));
	        if(isset($_GET['novo'])){$iplocal="";}
	        $rs = new recordset();
	        $rs2 = new recordset();
	        $sql = "SELECT * FROM maquinas a
	        			LEFT JOIN usuarios b ON a.maq_user = b.usu_cod
	        		WHERE maq_ip = '".$iplocal."'";
	        $rs->FreeSql($sql);
	        //echo $rs->sql;
	        $maqId="";
	        if($rs->linhas>0){
	        	$hide = "hide";
	        	$rs->GeraDados();
	        	$maqId = $rs->fld("maq_id");
	        }
	       //print_r($_SESSION);
	    ?>
        <!-- Main content -->
        <section class="content">
			<div class="row">

				<div class="col-md-12">
					<!-- general form elements -->
						<div class="box box-primary <?=($con["A"]<>1?"hide":"");?>">
							<div class="box-header with-border">
								<h3 class="box-title">Novo Equipamento</h3>
							</div><!-- /.box-header -->
							<!-- form start -->
							<form role="form" id="cad_maq">
								<div class="box-body">
									<div class="row">
										<div class="form-group col-md-2">
											<label for="maq_ip">IP:</label>
											<div class="input-group">
												<div class="input-group-addon">
							                       	<i class="fa fa-laptop"></i>
							                     </div>
												<input type="text" class="form-control" <?=($con['A']==1?"":"DISABLED");?> name="maq_ip" value="<?=$iplocal;?>" id="maq_ip" data-inputmask="'alias': 'ip'" data-mask/>
												<input type="hidden" id="maq_id" value="<?=$maqId;?>">
												<input type="hidden" value="<?=$_SESSION["token"];?>" id="token"/>
												<input type="hidden" value="<?=$_SESSION["cnpj_emp"];?>" id="cnpj"/>
											</div>
										</div>
										<div class="form-group col-md-3">
											<label for="maq_login">Login:</label>
											<div class="input-group">
												<div class="input-group-addon">
							                       	<i class="fa fa-lock"></i>
							                     </div>
												<input type="text" class="form-control" value="<?=($rs->fld("maq_usuario")!==NULL ? $rs->fld("maq_usuario") : gethostbyaddr($_SERVER['REMOTE_ADDR']));?>" name="maq_login" id="maq_login"/>
											</div>
										</div>
										<div class="form-group col-md-4">
											<label for="maq_empresa">Empresa:</label>
											<input type="hidden"  value="<?=$_SESSION['usu_cod'];?>">
											<div class="input-group">
												<div class="input-group-addon">
							                       	<i class="fa fa-building"></i>
							                     </div>
												<select name="maq_empresa" id="maq_empresa" class="form-control select2">
													<option value="">Selecione...</option>
													<?php
														$rs2->Seleciona("*","tri_clientes","ativo=1 AND emp_vinculo=".$_SESSION['usu_empcod'],"","cod ASC");
														while($rs2->GeraDados()){ ?>
															<option <?=($rs2->fld("cod")==$rs->fld("maq_cliente")?"SELECTED":"");?> value="<?=$rs2->fld("cod");?>"><?=$rs2->fld("empresa");?></option>
													<?php
														}
													?>
												</select>
											</div>
										</div>
										<div class="form-group col-md-3">
											<label for="maq_user">Usuário:</label>
											<input type="hidden"  value="<?=$_SESSION['usu_cod'];?>">
											<div class="input-group">
												<div class="input-group-addon">
							                       	<i class="fa fa-user"></i>
							                     </div>
												<select name="maq_user" id="maq_user" class="form-control select2">
													<option value="">Selecione...</option>
													<?php
														$rs2->Seleciona("*","usuarios","usu_ativo='1' AND usu_empcod=".$_SESSION['usu_empcod'],"","usu_nome ASC");
														while($rs2->GeraDados()){ ?>
															<option <?=($rs2->fld("usu_cod")==$rs->fld("maq_user") ? "SELECTED" :"");?> value="<?=$rs2->fld("usu_cod");?>"><?=$rs2->fld("usu_nome");?></option>
													<?php
														}
													?>
												</select>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="form-group col-md-3">
											<label for="maq_sys">Sistema Oper.:</label>
											<div class="input-group">
												<div class="input-group-addon">
							                       	<i class="fa fa-windows"></i>
							                     </div>
												<input type="text" class="form-control" value="<?=$rs->fld("maq_sistema");?>" name="maq_sys" id="maq_sys"/>
											</div>
										</div>

										<div class="form-group col-md-2">
											<label for="maq_mem">Memória:</label>
											<div class="input-group">
												<div class="input-group-addon">
							                       	<i class="fa fa-flash"></i>
							                     </div>
												<input type="text" class="form-control" value="<?=$rs->fld("maq_memoria");?>" name="maq_mem" id="maq_mem"/>
											</div>
										</div>

										<div class="form-group col-md-3">
											<label for="maq_hd">HD:</label>
											<div class="input-group">
												<div class="input-group-addon">
							                       	<i class="fa fa-hdd-o"></i>
							                     </div>
												<input type="text" class="form-control" value="<?=$rs->fld("maq_hd");?>" name="maq_hd" id="maq_hd"/>
											</div>
										</div>
										<div class="form-group col-md-4">
											<label for="maq_login">Tipo:</label>
											<div class="input-group">
												<div class="input-group-btn">
												<button type="button" class="btn btn-warning dropdown-toggle" id="btac" data-toggle="dropdown">Selecione <span class="fa fa-caret-down"></span></button>
												<ul class="dropdown-menu">
													<li><a href="javascript:perf('Notebook','laptop')"><i class="fa fa-laptop"></i>Notebook</a></li>
													<li><a href="javascript:perf('Desktop','desktop')"><i class="fa fa-desktop"></i>Desktop</a></li>
													<li><a href="javascript:perf('Impressora','print')"><i class="fa fa-print"></i>Impressora</a></li>
												</ul>
												</div><!-- /btn-group -->
												<input type="text" class="form-control" disabled="" value="<?=$rs->fld("maq_tipo");?>" name="maq_tipo" id="maq_tipo"/>
											</div><!-- /input-group -->
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
								<button class="btn btn-sm btn-success <?=$hide;?>" type="button" id="bt_newMaq"><i class="fa fa-plus"></i> Adicionar</button>
							
								<?php
								
								if($con['A']==1 AND $hide<>""){ ?>
								<button class="btn btn-sm btn-primary" type="button" id="bt_altMaq"><i class="fa fa-pencil"></i> Alterar</button>
							
								<?php } ?>
							</div>
							</form>
						</div><!-- ./box -->
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

<script src="<?=$hosted;?>/sistema/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/datatables/dataTables.bootstrap.min.js"></script> 
<script>
	/*------------------------|INICIA TOOLTIPS E POPOVERS|---------------------------------------*/
	$(document).ready(function () {
		$("[data-mask]").inputmask();

		$(".chosen").chosen({
		 	no_results_text: "Sem resultados!"
		 }); 

		$(".select2").select2({
			tags: true
			
		});

		$("#chatContent").scrollTop($("#msgs").height());					
		setTimeout(function(){
			//$("#slc").load("vis_maquinas.php");		
			$("#alms").load(location.href+" #almsg");
		 },10000);

	});
	function perf(peri, classe){
		$("#btac").html("<i class='fa fa-"+classe+"'></i>");
		$("#maq_tipo").val(peri);
		console.log(peri);
	}
</script>

</body>
</html>	