<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start();
$sec = "Solics";
$pag = "solic.php";
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
				Solicita&ccedil;&atilde;o de Contato Externo
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li>Solicita&ccedil;&atilde;o</li>
				<li class="active">Contato Externo</li>
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
							<h3 class="box-title">Solicitar Contato</h3>
						</div><!-- /.box-header -->
						<!-- form start -->
						<form role="form" id="cad_sol">
							<input type="hidden" id="emp_altera" value=0 />
							<div class="box-body">
								<!-- radio Clientes -->
								<div id="clientes" class="row">
									<div class="form-group col-md-4">
										<label for="emp_cnpj">Cliente</label><br>
										<select class="select2" name="sel_empresa" id="sel_empresa">
											<option value="">Selecione:</option>
										
										<?php
										$whr="cod <> 0";
										$rs->Seleciona("*","tri_clientes",$whr);
										while($rs->GeraDados()):	
										?>
											<option value="<?=$rs->fld("cod");?>"><?=$rs->fld("cod")." - ".$rs->fld("apelido");?></option>
										<?php
										endwhile;
										?>
										</select>
									</div>	
								</div>
								<!-- radio Avulso -->
								<div id="avulsos" class="row">
									<div class="form-group col-md-4">
										<label for="emp_cnpj">Nome</label>
										<input type="text" class="form-control input-sm" name="emp_nome" id="emp_nome"/>
									</div>
									<div class="form-group col-md-2">
										<label for="emp_cnpj">Telefone</label>
										<input type="text" class="form-control input-sm tel" name="emp_tel" id="emp_tel"/>
									</div>
									<div class="form-group col-md-3">
										<label for="emp_cnpj">Respons&aacute;vel</label>
										<input type="text" class="form-control input-sm" name="emp_res" id="emp_res"/>
									</div>
									<div class="form-group col-md-3">
										<label for="emp_cnpj">Falar Com:</label>
										<input type="text" class="form-control input-sm" name="emp_fcom" id="emp_fcom"/>
									</div>
									<div class="form-group col-md-12">
										<label for="emp_cnpj">Observa&ccedil;&atilde;o <small>(Opcional)</small></label>
										<textarea class="form-control input-sm" name="emp_obs" id="emp_obs"></textarea>
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
							
						</form>
					</div><!-- ./box -->
					<div class="box-footer">
						<button class="btn btn-sm btn-success" type="button" id="bt_solic"><i class="fa fa-fax"></i> Solicitar</button>
						<span id="spload" style="display:none;"><i id="load"></i></span>
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
				<section class="col-sm-6 col-md-3" id="chat" style="position:fixed; bottom:0; right:0; background:#fff; z-index:9; ">
					<?php require_once("chatter.php");?>
				</section>
				<div class="row">
					<div class="col-xs-12">
						<div class="box box-success" id="firms">
							<div class="box-header with-border">
								<h3 class="box-title">Solicita&ccedil;&otilde;es</h3>
							</div><!-- /.box-header -->
							<div id="slc" class="box-body">
								 
								<?php require_once('vis_solic.php');?>
								
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
<script src="<?=$hosted;?>/js/action_triang.js"></script>
<script src="<?=$hosted;?>/js/controle.js"></script>
<script src="<?=$hosted;?>/js/jquery.cookie.js"></script>
<script src="<?=$hosted;?>/js/functions.js"></script>


<!-- SELECT2 TO FORMS-->
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
<!--CHOSEN-->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.6.2/chosen.jquery.min.js"></script>
<!-- Validation -->
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
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
		//	$("#alms").load(location.href+" #almsg");
			$("#slc").load("vis_solic.php");		
		 },7500);

		
	});
</script>

</body>
</html>	