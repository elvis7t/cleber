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

	    ?>
        <!-- Main content -->
        <section class="content">
			<div class="row">
				<div class="col-xs-12">
					<div class="box box-success" id="machs">
						<div class="box-header with-border">
							<h3 class="box-title">Parque de Máquinas</h3>
						</div><!-- /.box-header -->
						<div class="box-body">
							<input type="hidden" id="token" value="<?=$_SESSION['token'];?>">
							<div class="row">
								<div class="form-group col-md-3">
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-laptop"></i>
										 </div>
										<input type="text" class="form-control" name="maq_ips" value="" id="maq_ips" data-inputmask="'alias': 'ip'" data-mask/>
									</div>
								</div>
								<div class="form-group col-md-3">
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-lock"></i>
										 </div>
										<select name="maq_usuario" id="maq_usuario" class="form-control select2">
											<option value="">Selecione...</option>
											<?php
												$rs2->Seleciona("maq_usuario","maquinas","maq_id<>0","","maq_id ASC");
												while($rs2->GeraDados()){ ?>
													<option value="<?=$rs2->fld("maq_usuario");?>"><?=$rs2->fld("maq_usuario");?></option>
											<?php
												}
											?>
										</select>
									</div>
								</div>

								<div class="form-group col-md-4">
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-user"></i> 
										 </div>
										<select name="maq_users" id="maq_users" class="form-control select2">
											<option value="">Selecione...</option>
											<?php
												$rs2->Seleciona("*","usuarios","usu_ativo='1' AND usu_emp_cnpj='".$_GET['cnpj']."'","","usu_nome ASC");
												while($rs2->GeraDados()){ ?>
													<option <?=($rs2->fld("usu_cod")==$rs->fld("maq_user") ? "SELECTED" :"");?> value="<?=$rs2->fld("usu_cod");?>"><?=$rs2->fld("usu_nome");?></option>
											<?php
												}
											?>
										</select>
									</div>
								</div>
								<div class="form-group col-md-2">
									<button class="btn btn-success btn-sm" id="bt_search"><i class="fa fa-search"></i></button>
								</div>
								
							</div>
							<div id="vis_maquinas">
								<?php require_once('vis_maquinas.php');?>
							</div>
						</div>
						<div class="box-footer">
								<a class="btn btn-sm btn-success" href="form_maquinas.php?token=<?=$_SESSION['token'];?>&novo=1"><i class="fa fa-desktop"></i> Nova Maquina</a>
						</div>
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

<script src="<?=$hosted;?>/sistema/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/datatables/dataTables.bootstrap.min.js"></script> 
<script>
	/*------------------------|INICIA TOOLTIPS E POPOVERS|---------------------------------------*/
	$(document).ready(function () {
		$("[data-mask]").inputmask();

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