<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start();
$sec = "Solics";
require_once("../config/main.php");
require_once("../config/valida.php");
require_once("../config/mnutop.php");
require_once("../config/menu.php");
require_once("../config/modals.php");
require_once("../class/class.functions.php");
require_once("../class/class.permissoes.php");

?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<!-- Content Header (Page header) -->
        <section class="content-header">
			<div class="error-page">
			    <h2 class="headline text-red">403</h2>
			      <div class="error-content">
			        <h3><i class="fa fa-warning text-red"></i> Oops! Acesso negado.</h3>
			          <p>
			            Voc&ecirc; n&atilde;o tem permiss&atilde;o para acesar esse conte&uacute;do.
			            Sendo assim, voc&ecirc; pode <a href="index.php?token=<?=$_SESSION['token']?>">voltar ao painel</a> ou tentar fazer uma pesquisa.
			            </p>
			            <form action="pesquisa.php<?=$token;?>&cnpj=<?=$_SESSION['usu_empresa'];?>" method="POST" class="search-form">
			              <div class="input-group">
			                <input type="text" name="q" class="form-control" placeholder="Search">
			              <div class="input-group-btn">
			              <button type="submit" name="submit" class="btn btn-danger btn-flat"><i class="fa fa-search"></i></button>
			            </form>
			          </div>
			        </div><!-- /.input-group -->
			    </div>
			  </div><!-- /.error-page -->
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