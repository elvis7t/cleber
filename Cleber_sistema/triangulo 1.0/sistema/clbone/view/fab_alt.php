<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclus�o dos principais itens da p�gina */
session_start();
$sec = "SERV";
$pag = "serv_feed_item.php";
require_once("../config/main.php");
require_once("../config/valida.php");
require_once("../config/mnutop.php");
require_once("../config/menu.php");
require_once("../../sistema/config/modals.php");
require_once("../../sistema/class/class.functions.php");

?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<!-- Content Header (Page header) -->
        <section class="content-header">
			<h1>
				Itens - Feedback
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li>Solicita&ccedil;&atilde;o</li>
				<li>Itens</li>
				<li class="active">Detalhes</li>
			</ol>
        </section>

        <!-- Main content -->
        <section class="content">
			<?php
				$menu = array(
							"P" => array("class" => "btn btn-primary btn-sm", "icone" => "fa fa-history", "id"=>"btn_pesItem","label"=>"Voltar"),
							"R" => array("class" => "btn btn-success btn-sm", "icone" => "fa fa-save", "id"=>"btn_saveItem","label"=>"Salvar"),
							"N" => array("class" => "btn btn-warning btn-sm", "icone" => "fa fa-recycle", "id"=>"btn_Altfab","label"=>"Alterar")
							);
 				extract($_GET);
 				$rs2 = new recordset();
 				$sql = "SELECT * FROM fabricantes WHERE fab_id = ".$serv;
 				$rs->FreeSql($sql);
 				$rs->GeraDados();
				
 				
			?>
			 <div class="row">
				<div class="col-md-12">
				<!-- general form elements -->
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">Feedback de Item</h3><div class="box-tools pull-right">
		                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		                  </div>
						</div><!-- /.box-header -->
						<!-- form start -->
						<form role="form" id="alt_fab">
							
							<div class="box-body">
								<!-- radio Clientes -->
								<div id="clientes" class="row">
									<div class="form-group col-xs-1">
										<label for="emp_cnpj">#ID:</label>
										<input type="text" DISABLED class="form-control" name="fab_id" id="fab_id" value="<?=$rs->fld("fab_id");?>"/>
										<input type="hidden" value="<?=$_SESSION['token'];?>" name="token" id="token">
										<input type="hidden" value="<?=isset($_GET['lista']) ? $_GET['lista']: 0 ;?>" name="lista" id="lista">
									</div>
									<div class="form-group col-xs-3">
										<label for="emp_cnpj">Fabricante:</label>
										<input type="text"  class="form-control" name="fab_nome" id="fab_nome" value="<?=$rs->fld("fab_nome");?>"/>
									</div>
									
								</div>
								
								<div id="consulta"></div>
								<div id="formerros1" class="clearfix" style="display:none;">
									<div class="callout callout-danger">
										<h4>Erros no preenchimento do formul&aacute;rio.</h4>
										<p>Verifique os erros no preenchimento acima:</p>
										<ol>
											<!-- Erros s�o colocados aqui pelo validade -->
										</ol>
									</div>
								</div>
							</div>
							
							<div class="box-footer">
								<button class="<?=$menu[$acao]['class'];?>" type="button" id="<?=$menu[$acao]['id'];?>"><i class="<?=$menu[$acao]['icone'];?>"></i> <?=$menu[$acao]['label'];?></button>
							</div>
						</form>
					</div><!-- ./box -->
					
				</div><!-- ./row -->
				
					
				
				
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
<script src="<?=$hosted;?>/clbone/js/action_ativos.js"></script>
<script src="<?=$hosted;?>/clbone/js/controle.js"></script>
<script src="<?=$hosted;?>/clbone/js/jquery.cookie.js"></script>
<script src="<?=$hosted;?>/clbone/js/functions.js"></script>


<!-- SELECT2 TO FORMS
-->

<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
<!-- Validation -->
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script>
	/*------------------------|INICIA TOOLTIPS E POPOVERS|---------------------------------------*/
	$(document).ready(function () {
		$(".select2").select2({
			tags: true,
			theme: "classic"
		});
	});
</script>

</body>
</html>	