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
				<div class="col-xs-12">
					<div class="box box-success" id="machs">
						<div class="box-header with-border">
							<h3 class="box-title">Instalados nessa Máquina</h3>
						</div><!-- /.box-header -->
						<div class="box-body">
						<input type="hidden" id="token" value="<?=$_SESSION['token'];?>">
							<div class="row">
								<div class="form-group col-md-3">
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-laptop"></i>
										 </div>
										<input type="text" class="form-control input-sm" name="per_ips" value="" id="per_ips" data-inputmask="'alias': 'ip'" data-mask/>
										<input type="hidden" value="<?=$_SESSION["token"];?>" id="token"/>
										<input type="hidden" value="<?=$_SESSION["cnpj_emp"];?>" id="cnpj"/>
									</div>
								</div>
								<div class="col-md-3">	
									<div class="input-group">
										<div class="input-group-btn">
										<button type="button" class="btn btn-warning btn-sm dropdown-toggle" id="btp" data-toggle="dropdown">Selecione <span class="fa fa-caret-down"></span></button>
										<ul class="dropdown-menu">
											<li><a href="javascript:perf('Mouse','mouse-pointer','btp','txps')"><i class="fa fa-mouse-pointer"></i>Mouse</a></li>
											<li><a href="javascript:perf('Teclado','keyboard-o','btp','txps')"><i class="fa fa-keyboard-o"></i>Teclado</a></li>
											<li><a href="javascript:perf('Monitor','television','btp','txps')"><i class="fa fa-television"></i>Monitor</a></li>
											<li class="divider"></li>
											<li><a href="javascript:perf('Estabilizador','plug','btp','txps')"><i class="fa fa-plug"></i>Estabilizador</a></li>
											<li><a href="javascript:perf('HD_Externo','hdd-o','btp','txps')"><i class="fa fa-hdd-o"></i>HD Externo</a></li>
											<li><a href="javascript:perf('Scanner','file-image-o','btp','txps')"><i class="fa fa-file-image-o"></i>Scanner</a></li>
											<li><a href="javascript:perf('Toner','battery-full','btp','txps')"><i class="fa fa-battery-full"></i>Toner</a></li>
											<li><a href="javascript:perf('Leitor_A3','credit-card','btp','txps')"><i class="fa fa-credit-card"></i>Leitor A3</a></li>
										</ul>
										</div><!-- /btn-group -->
										<input type="text" class="form-control input-sm" disabled="" value="" name="txps" id="txps"/>
									
									</div><!-- /input-group -->
								</div>
								<div class="form-group col-md-2">
									<button class="btn btn-success btn-sm" id="bt_searchp"><i class="fa fa-search"></i></button>
								</div>
							</div>
							<div id="vis_perifericos">	 
								<?php require_once('vis_perifericos.php');?>
							</div>
						</div>
						<div class="box-footer">
							<a class="btn btn-sm btn-success" href="form_perif.php?token=<?=$_SESSION['token'];?>"><i class="fa fa-keyboard-o"></i> Novo Periferico</a>
					
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