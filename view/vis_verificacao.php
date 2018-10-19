<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start("portal");
$sec = "CHAMA";
$pag = "vis_verificacao.php";
require_once("../config/main.php");
require_once("../config/valida.php");
require_once("../config/mnutop.php");
require_once("../config/menu.php");
require_once("../config/modals.php");
require_once("../class/class.functions.php");

?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<!-- Content Header (Page header) -->
        <section class="content-header">
			<h1>
				Fichas de Verifica&ccedil;&atilde;o
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li>Solicita&ccedil;&atilde;o</li>
				<li class="active">Fichas</li>
			</ol>
        </section>

        <!-- Main content -->
        <section class="content">
			<?php
 
				if(isset($_SESSION['classe'])){$classe = $_SESSION['classe'];}
				else{$classe=0;}
			?>
			 	
				<div class="row">
					<div class="col-xs-12">
						<div class="box box-primary">
							<div class="box-header with-border">
								<h3 class="box-title">Pesquisa de Check-Lists</h3>
							</div>
							<div class="box-body">
								<div id="clientes" class="row">
									<div class="form-group col-md-6">
										<label for="sel_emp">Empresa:</label><br>
										<select class="select2" style="width:100%" name="sel_emp" id="sel_emp">
											<option value="">Selecione:</option>
										
										<?php
										$whr="ativo = 1";
										$rs->Seleciona("*","tri_clientes",$whr);
										while($rs->GeraDados()):	
										?>
											<option value="<?=$rs->fld("cod");?>"><?=$rs->fld("empresa");?></option>
										<?php
										endwhile;
										?>
										</select>
									</div>
									
									
									<div class="form-group col-md-2">
										<label for="verif_dtini">Data Inicio:</label>
										<input type="text" class="form-control dtp" name="verif_dtini" id="verif_dtini" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask/>
									</div>
									<div class="form-group col-md-2">
										<label for="verif_dtfim">Data Fim:</label>
										<input type="text" class="form-control dtp" name="verif_dtfim" id="verif_dtfim" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask/>
									</div>
									
								</div>
							</div>
							<div class="box-footer">
								<button class="btn btn-sm btn-primary" id="btn_verif_cham"><i class="fa fa-search"></i> Pesquisar</button>
								<a href="verificacao.php?token=<?=$_SESSION['token'];?>" class="btn btn-sm btn-success"><i class="fa fa-file"></i> Nova</a>
							</div>
						</div>
					</div>
					<div class="col-xs-12">
						<div class="box box-danger" id="firms">
							<div class="box-header with-border">
								<h3 class="box-title">Fichas Em Aberto</h3>
							</div><!-- /.box-header -->
							<div id="sl" class="box-body">
								 
								<?php 
									require_once('minhas_verif.php');
								?>
								
							</div>
							
						</div><!-- ./box -->
					</div><!-- ./col -->
					<div class="col-xs-12">
						<div class="box box-success" id="firms">
							<div class="box-header with-border">
								<h3 class="box-title">Fichas Encerradas</h3>
							</div><!-- /.box-header -->
							<div id="sl2" class="box-body">
								 
								<?php 
								//require_once('verif_fin.php');
								?>
								
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
<script src="<?=$hosted;?>/sistema/assets/js/maskinput.js"></script>
<script src="<?=$hosted;?>/sistema/js/action_chamados.js"></script>
<script src="<?=$hosted;?>/sistema/assets/js/jmask.js"></script>
<script src="<?=$hosted;?>/sistema/js/action_triang.js"></script>
<script src="<?=$hosted;?>/sistema/js/controle.js"></script>
<script src="<?=$hosted;?>/sistema/js/jquery.cookie.js"></script>
<script src="<?=$hosted;?>/sistema/js/functions.js"></script>
<script src="<?=$hosted;?>/sistema/assets/bootstrap/js/star-rating.js"></script>

    <script src="<?=$hosted;?>/sistema/assets/plugins/input-mask/jquery.inputmask.js"></script>
    <script src="<?=$hosted;?>/sistema/assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="<?=$hosted;?>/sistema/assets/plugins/input-mask/jquery.inputmask.extensions.js"></script>


<!-- SELECT2 TO FORMS
-->

<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
<!-- Validation -->
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script>
	/*------------------------|INICIA TOOLTIPS E POPOVERS|---------------------------------------*/
	$(document).ready(function () {
		
		$(".select2").select2({
			tags: true
		});
		$(".dtp").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/aaaa"});			
		setTimeout(function(){
			//$("#slc").load("meus_chamados.php");		
			$("#alms").load(location.href+" #almsg");
		 },10000);
	});
</script>

</body>
</html>	