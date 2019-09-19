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
$per = new permissoes();

?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<!-- Content Header (Page header) -->
        <section class="content-header">
			<h1>
				Pesquisar Bases de Conhecimento
				<small>Pesquisando por: <?=$_POST['q'];?></small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li>Pesquisas</li>
				<li class="active">Knowledge Bases</li>
			</ol>
        </section>

        <!-- Main content -->
        <section class="content">
			<?php
			$pesq = explode(" ",$_POST["q"]);
			$fn = new functions();
			$rs2 = new recordset();
			
			/*--------------|PESQUISA DE PARTICULARIDADES|-------------*\
			|	Este bloco inicia a pesquisa de PARTICULARIDADES 		|
			\*---------------------------------------------------------*/
			$sql = "SELECT * FROM particularidades WHERE 1";
			foreach($pesq as $val){
				$sql.=" AND part_titulo LIKE '%".$val."%' OR part_obs LIKE '%".$val."%'";
			}
			$sql.=" GROUP BY part_id";
			$rs->FreeSql($sql);
			$pag = "form_part.php";
			require_once("pesq_partic.php");

			/*--------------|PESQUISA DE CHAMADOS|---------------------*\
			|	Este bloco inicia a pesquisa de CHAMADOS 				|
			\*---------------------------------------------------------*/

			$sql = "SELECT *, b.usu_nome nmb, c.usu_nome nmc FROM chamados a
						JOIN usuarios b ON a.cham_solic = b.usu_cod
						LEFT JOIN usuarios c ON a.cham_trat = c.usu_cod
						JOIN codstatus d ON d.st_codstatus = a.cham_status
						JOIN cham_obs ON cham_id = chobs_chamId WHERE 1";
			
			foreach($pesq as $val){
				$sql.=" AND chobs_obs LIKE '%".$val."%'";
			}
			$sql.=" GROUP BY cham_id";
			$rs->FreeSql($sql);
			require_once("pesq_cham.php");

			/*--------------|PESQUISA DE OBRIGAÇÔES|-------------------*\
			|	Este bloco inicia a pesquisa de OBRIGAÇÔES 				|
			\*---------------------------------------------------------/

			$sql = "SELECT * FROM obrigacoes JOIN tipos_impostos ON imp_id = ob_titulo WHERE 1";
			foreach($pesq as $val){
				$sql.=" AND imp_nome LIKE '%".$val."%' OR imp_desc LIKE '%".$val."%'";
			}
			$sql.=" GROUP BY imp_id";
			$rs->FreeSql($sql);
			//require_once("pesqu_obrig.php");
			
			/*--------------|PESQUISA DE TRIBUTOS|---------------------*\
			|	Este bloco inicia a pesquisa de TRIBUTOS 				|
			\*---------------------------------------------------------/

			$sql = "SELECT * FROM tributos JOIN tipos_impostos ON imp_id = tr_titulo WHERE 1";
			foreach($pesq as $val){
				$sql.=" AND imp_nome LIKE '%".$val."%' OR imp_desc LIKE '%".$val."%'";
			}
			$sql.=" GROUP BY imp_id";
			$rs->FreeSql($sql);
			//require_once("pesq_tribut.php");
			*/
			?>

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

		$(".select2").select2({
			tags: true
		});
		

		
	});
</script>

</body>
</html>	