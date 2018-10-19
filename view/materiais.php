<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start();
$sec = "Mater";
$pag = "materiais.php";
require_once("../config/main.php");
require_once("../config/valida.php");
require_once("../config/mnutop.php");
require_once("../config/menu.php");
require_once("../config/modals.php");
require_once("../../sistema/class/class.functions.php");
require_once("../class/class.permissoes.php");
$per = new permissoes();
$con = $per->getPermissao($pag);

if($con['C']<>1){
  header("location:403.php?token=".$_SESSION['token']);
}

?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<!-- Content Header (Page header) -->
        <section class="content-header">
			<h1>
				Cadastro de Materiais
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li>Cadastro</li>
				<li class="active">Material</li>
			</ol>
        </section>

        <!-- Main content -->
        <section class="content">
			 <div class="row">
				<div class="col-md-12">
				<!-- general form elements -->
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">Cadastrar Material</h3>
						</div><!-- /.box-header -->
						<!-- form start -->
						<form role="form" id="cad_cadMat">
							<div class="box-body">
								<!-- radio Clientes -->
								<div id="clientes" class="row">
									
									
									<div class="form-group col-md-2">
										<label for="mat_cat">Catergoria:</label><br>
										<select class="select2" name="mat_cat" id="mat_cat" style="width: 100%;"">
											<option value="0">Selecione:</option>
										
										<?php
										/*--|PESQUISA DE PRODUTO PARA ALTERAÇÃO |--*\
										|	Author: Cleber Marrara					|
										|	Descr.: Se houver o GET['PROD'],		|
										|	disponibiliza edição					|
										\*-----------------------------------------*/
										$rs1 = new recordset();
										$selec = "";
										$desc = "";
										$min = "";
										$id = "";
										$compra = "";
										$salv=""; // Botão salvar
										$alt="hide"; // Botão Alterar
										$cat = "";
										if(isset($_GET['prodid'])){
											$salv = "hide";
											$alt = "";
											$sq = "SELECT * FROM mat_cadastro WHERE mcad_id = ".$_GET['prodid'];
											$rs1->FreeSql($sq);
											$rs1->GeraDados();
										}
										$whr="mcat_id<>0";
										$rs->Seleciona("*","mat_categorias",$whr);
										while($rs->GeraDados()):
											$id = $rs1->fld("mcad_id");
											$desc = $rs1->fld("mcad_desc");
											$min = $rs1->fld("mcad_minimo");
											$compra = $rs1->fld("mcad_compra");
											$cat = $rs1->fld("mcad_catid");
											$preco = number_format($rs1->fld("mcad_ultpreco"),2,",",".");
											if($cat == $rs->fld("mcat_id")){$selec = "SELECTED";}
											else{$selec="";}

										?>
											<option <?=$selec;?> value="<?=$rs->fld("mcat_id");?>"><?=$rs->fld("mcat_desc");?></option>
										<?php
										endwhile;
										?>
										</select>
										
									</div>
									<input type="hidden" value="<?=$id;?>" id="mat_id"/>
									<div class="form-group col-md-3">
										<label for="mat_desc">Descri&ccedil;&atilde;o:</label>
										<input type="text" class="form-control input-sm" name="mat_desc" id="mat_desc" value="<?=$desc;?>"/>
									</div>

									<div class="form-group col-md-2">
										<label for="mat_qtd">Qtd. M&iacute;n:</label>
										<input type="text" class="form-control input-sm" name="mat_qtdmin" id="mat_qtdmin" maxlength=3 value='<?=$min;?>'>
									</div>
									
									<div class="form-group col-md-2">
										<label for="mat_qtd">Compra M&iacute;n:</label>
										<input type="text" class="form-control input-sm" name="mat_commin" id="mat_commin" maxlength=3 value="<?=$compra;?>">
									</div>
									<div class="form-group col-md-2">
										<label for="mat_qtd">&Uacute;ltimo Pre&ccedil;o:</label>
										<input type="text" class="form-control input-sm" name="mat_preco" id="mat_preco" value="<?=$preco;?>">
									</div>
									
								</div>
							<div id="consulta"></div>
							<div id="formerrosCadMateriais" class="clearfix" style="display:none;">
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
						<button class="btn btn-sm btn-success <?=$salv;?>" type="button" id="CadMat"><i class="fa fa-plus"></i> Cadastrar</button>
						<button class="btn btn-sm btn-info <?=$alt;?>" type="button" id="AltMat"><i class="fa fa-pencil"></i> Alterar</button>
						<span id="spload" style="display:none;"><i id="load"></i></span>
					</div>
					
					
				</div><!-- ./row -->
				<div class="row">
					<div class="col-xs-12">
						<div class="box box-success" id="materiais">
							<div class="box-header with-border">
								<h3 class="box-title">Solicita&ccedil;&otilde;es</h3>
							</div><!-- /.box-header -->
							<div id="slc" class="box-body">
								 
								<?php
								require_once("vis_matcad.php");
								?>
								
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
<script src="<?=$hosted;?>/sistema/js/action_empresas.js"></script>
<script src="<?=$hosted;?>/sistema/js/controle.js"></script>
<script src="<?=$hosted;?>/sistema/js/jquery.cookie.js"></script>
<script src="<?=$hosted;?>/sistema/js/functions.js"></script>


<!-- SELECT2 TO FORMS-->
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
<!--CHOSEN-->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.6.2/chosen.jquery.min.js"></script>
<!-- Validation -->
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script src="<?=$hosted;?>/sistema/assets/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>
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
		
		$(".check_alerta").bootstrapToggle({
            on: "Sim",
            off: "Não"
        });
		
	});


	function mark_alerta(mat, check){

		act = ( check == true ? "inclui_alerta" : "exclui_alerta");
		ati = ( check == true ? 1 : 0);
        $.post("../controller/TRIEmpresas.php",
            {
                acao:    act,
                material: mat,
                ativo:   ati 
            },
            function(data){
                alert(data.mensagem);
            },
            "json"
        );
        
	}

</script>

</body>
</html>	