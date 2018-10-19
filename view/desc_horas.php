<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start();
$sec = "CHORAS";
$pag = "desc_horas.php";
require_once("../config/main.php");
require_once("../config/valida.php");
require_once("../config/mnutop.php");
require_once("../config/menu.php");
require_once("../config/modals.php");
require_once("../class/class.functions.php");
require_once("../class/class.permissoes.php");

$per = new permissoes();
$con = $per->getPermissao($pag, $_SESSION['usu_cod']);

if($con['C']<>1){
  header("location:403.php?token=".$_SESSION['token']);
}

?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<!-- Content Header (Page header) -->
        <section class="content-header">
			<h1>
				Controle de Horas
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li>Controle de Horas</li>
				<li class="active">Desconto...</li>
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
							<h3 class="box-title">Consultar Horas</h3>
						</div><!-- /.box-header -->
						<!-- form start -->
						<form role="form" id="desc_horas">
							<input type="hidden" id="emp_altera" value=0 />
							<div class="box-body">
								<!-- radio Clientes -->
								<div id="clientes" class="row">
									<div class="form-group col-md-4">
										<div class="input-group">
											<div class="input-group-addon">
												<i class="fa fa-user"></i>
											</div>
											<select class="select2" name="dhor_colab" id="dhor_colab" style="width:100%;">
												<option value="">Selecione:</option>
											
												<?php
												$whr="usu_empcod = ".$_SESSION['usu_empcod'];
												/*
													| ALTERAÇÃO - CLEBER MARRARA - 29.05.2017					|
													| Verificação da permissão (36) de todos os departamentos	|
													| para mostrar todos os departamentos.						|

												*/
												$dep = $per->getPermissao("controle_depart",$_SESSION['usu_cod']);
												if($dep['C']==0){$whr.=" AND usu_dep=".$_SESSION['dep'];}
												/*
													| ALTERAÇÃO - CLEBER MARRARA - 29.05.2017					|
													| Verificação da permissão (34) de todos os funcionários	|
													| para mostrar todos os usuários. 							|

												*/
												$pus = $per->getPermissao("todos_func",$_SESSION['usu_cod']);
												if($pus['C']==0){$whr.=" AND usu_cod=".$_SESSION['usu_cod'];}
												$rs->Seleciona("*","usuarios",$whr);
												$sql = $rs->sql;
												//echo $sql;
												while($rs->GeraDados()):	
												?>
													<option value="<?=$rs->fld("usu_cod");?>"><?=$rs->fld("usu_nome");?></option>
												<?php
												endwhile;
												?>
											</select>
										
											<span class="input-group-btn">
												<button type="button" id="pes_dhoras" class="btn btn-info"><i class="fa fa-search"></i></button>
											</span>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="form-group col-md-2">
										<label for="dhor_horas">Horas:</label>
										<input type="text" class="form-control input-sm text-right" id="dhor_disp" name="dhor_disp" value="" DISABLED>
									</div>
									<div class="form-group col-md-2">
										<label for="dhor_horas">Descontar: <small>[Ex.: 1,30]</small></label>
										<input type="text" class="form-control input-sm text-right" id="dhor_desc" name="dhor_desc" value="">
									</div>
									<div class="form-group col-md-2">
										<label for="dhor_horas">Saldo:</label>
										<input type="text" class="form-control input-sm text-right" id="dhor_saldo" name="dhor_saldo" value="" DISABLED>
									</div>
									<div class="form-group col-md-6">
										<label for="dhor_horas">Obs:</label>
										<input type="text" class="form-control input-sm" id="dhor_obs" name="dhor_obs" value="">
									</div>
								</div>
								<div id="consulta"></div>
								<div id="formerrosDesc" class="clearfix" style="display:none;">
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
								<?php
								if($con["I"]==1): ?>
									<button class="btn btn-sm btn-success" type="button" id="desc_salvar"><i class="fa fa-save"></i> Salvar</button>
								<?php
								endif;
								?>
								<a class="btn btn-sm btn-warning" href="desc_horas.php?token=<?=$_SESSION['token'];?>&cnpj=<?=$_SESSION['usu_empresa'];?>"><i class="fa fa-wrench"></i> Novo</a>

							</div>
						</form>	
						
					</div><!-- ./row -->
					<div class="row">
						<div class="col-xs-12">
							<div class="box box-success" id="firms">
								<div class="box-header with-border">
									<h3 class="box-title">Tr&acirc;mites Realizados:</h3>
								</div><!-- /.box-header -->
								<div id="slc" class="box-body">
									 
									<?php require_once('vis_deschoras.php');?>
									
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
<script src="<?=$hosted;?>/sistema/js/action_triang.js"></script>
<script src="<?=$hosted;?>/sistema/js/controle.js"></script>
<script src="<?=$hosted;?>/sistema/js/jquery.cookie.js"></script>
<script src="<?=$hosted;?>/sistema/js/functions.js"></script>


<!-- SELECT2 TO FORMS-->
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
<!--CHOSEN-->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.6.2/chosen.jquery.min.js"></script>
<!-- Validation -->
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script type="text/javascript">
	/*------------------------|INICIA TOOLTIPS E POPOVERS|---------------------------------------*/
	$(document).ready(function () {
		$("#bt_detalhe").click(function(){
			$("#emp_detalhe").modal({
				keyboard:true
			});
		});

		$(".select2").select2({
			tags: true
		});
		setTimeout(function(){
			$("#alms").load(location.href+" #almsg");
		 },7500);

		
	});
</script>

</body>
</html>	