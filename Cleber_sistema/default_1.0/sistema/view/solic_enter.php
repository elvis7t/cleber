<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start();
$sec = "Solics";
$pag = "solic_enter.php";
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
				Entrada de Contato Externo
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li>Contato Externo</li>
				<li class="active">Liga&ccedil;&otilde;es</li>
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
							<h3 class="box-title">Novo Contato</h3>
						</div><!-- /.box-header -->
						<!-- form start -->
						<form role="form" id="cad_sol">
							<div class="box-body">
								<!-- radio Clientes -->
								<div id="clientes" class="row">
									<div class="form-group col-xs-6">
										<label for="emp_cnpj">Cliente</label>
										<select class="select2 input-sm" name="sel_empresa" id="sel_empresa">
											<option value="">Selecione:</option>
										
										<?php
										$whr="ativo = 1";
										$rs->Seleciona("*","tri_clientes",$whr);
										while($rs->GeraDados()):	
										?>
											<option value="<?=$rs->fld("cod");?>"><?=$rs->fld("cod")." - ".$rs->fld("empresa");?></option>
										<?php
										endwhile;
										?>
										</select>
									</div>									
								</div>
								<!-- radio Avulso -->
								<div id="avulsos" class="row">
									<div class="form-group col-xs-4">
										<label for="emp_cnpj">Nome: </label>
										<input type="text" class="form-control input-sm" name="emp_nome" id="emp_nome"/>
									</div>
									<div class="form-group col-xs-3">
										<label for="emp_cnpj">Telefone: </label>
										<input type="text" class="form-control tel input-sm" disabled name="emp_tel" id="emp_tel"/>
									</div>
									<div class="form-group col-xs-3">
										<label for="emp_cnpj">Respons&aacute;vel: </label>
										<input type="text" class="form-control input-sm" name="emp_res" id="emp_res"/>
									</div>
									<div class="form-group col-xs-3">
										<label for="emp_cnpj">Falar Com: </label>
										<input type="text" class="form-control input-sm" name="emp_fcom" id="emp_fcom"/>
										<input type="checkbox" name="emp_pres" id="emp_pres"/> Atendimento Presencial
									</div>
									<div class="form-group col-xs-7">
										<label for="emp_cnpj">Observa&ccedil;&atilde;o: <small>(Opcional)</small></label>
										<textarea type="text" class="form-control input-sm" name="emp_obs" id="emp_obs"></textarea>
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
								<button class="btn btn-sm btn-success" type="button" id="bt_ent"><i class="fa fa-check"></i> Atendido</button>
								
							</div>
						</form>
					
				</div><!-- ./row -->
				<div class="row">
					<div class="col-xs-12">
						<div class="box box-success" id="firms">
							<div class="box-header with-border">
								<h3 class="box-title">Entradas</h3>
							</div><!-- /.box-header -->
							<div id="slc_e" class="box-body">
								 
								<?php require_once('vis_solic_entra.php');?>
								
							</div>
						</div><!-- ./box -->
					</div><!-- ./col -->
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
    <script src="<?=$hosted;?>/js/action_triang.js"></script>
    <script src="<?=$hosted;?>/js/jquery.cookie.js"></script>
    <script src="<?=$hosted;?>/js/functions.js"></script>
	<!-- SELECT2 TO FORMS
	-->
	<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
	<!-- Validation -->
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
	<script>
		$(document).ready(function(){
			$(".select2").select2({
				tags: true
			});
		});
			
		
	</script>

</body>
</html>	