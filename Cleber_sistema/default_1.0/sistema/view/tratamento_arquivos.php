<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start();
$sec = "Dashboard";
$pag = "index.php";
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
				Documentos <small>Arquivos de Importa&ccedil;&atilde;o e Lan&ccedil;amentos</small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li>Arquivos</li>
				<li>Tratamentos</li>
				<li class="active">Arquivo do Cliente</li>
			</ol>
        </section>

        <!-- Main content -->
        <section class="content">
        <div class="row">
					<div class="col-md-12">
						<div class="box box-success" id="firms">
							<div class="box-header with-border">
								<h3 class="box-title">Tr&acirc;mites deste tratamento</h3>
							</div><!-- /.box-header -->
							<div class="box-body">
								 
								<?php require_once("trata_arqObs.php"); ?>
								
							</div>
						</div><!-- ./box -->
					</div><!-- ./col -->
				</div>
			<?php
 				extract($_GET);
 				$rs2 = new recordset();
				$fn = new functions();
 				$sql = "SELECT a.*, 
							 b.usu_nome as resp, 
							 c.usu_nome as Impor, 
							 e.empresa,
							 e.cod,
							 e.carteira,
							 d.cliarq_venc, 
							 f.tarq_nome,
							 f.tarq_depart 
						FROM trata_arquivos a 
							LEFT JOIN usuarios b ON b.usu_cod = a.trata_resp 
							LEFT JOIN usuarios c ON c.usu_cod = a.trata_finpor 
							LEFT JOIN tri_clientes e ON e.cod = a.trata_cliarqEmp 
							LEFT JOIN clientes_arquivos d ON a.trata_cliarqEmp = d.cliarq_empresa AND a.trata_cliarqarqid = d.cliarq_arqId	 
							LEFT JOIN tipos_arquivos f ON f.tarq_id = a.trata_cliarqarqid 
							WHERE trata_id = ".$arq;
 				$rs->FreeSql($sql);
 				$rs->GeraDados();
 				$colab = json_decode($rs->fld("carteira"),true);
 				$ccol = $colab[$rs->fld("tarq_depart")]["user"];
 				$ncol = ($colab[$rs->fld("tarq_depart")]["user"]==0?"-":$rs2->pegar("usu_nome","usuarios","usu_cod=".$colab[$rs->fld("tarq_depart")]["user"]));
 				$read = ($rs->fld("trata_status")<>0?"DISABLED":"");
 				//echo $sql;
 			?>

			 <div class="row">
				<div class="col-md-12">
				<!-- general form elements -->
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">Feedback de Servi&ccedil;o</h3><div class="box-tools pull-right">
		                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		                  </div>
						</div><!-- /.box-header -->
						<!-- form start -->
						<form role="form" id="cad_filaimporta">
							
							<div class="box-body">
								<!-- radio Clientes -->

								<div id="clientes" class="row">
									<div class="form-group col-md-1">
										<label for="emp_cnpj">#ID:</label>
										<input type="text" DISABLED class="form-control" name="trata_id" id="trata_id" value="<?=$rs->fld("trata_id");?>"/>
										<input type="hidden" id="token" value="<?=$_SESSION['token'];?>"/>
										<input type="hidden" id="cnpj" value="<?=$_SESSION['usu_empresa'];?>"/>
										<input type="hidden" id="cod_empresa" value="<?=$rs->fld("cod");?>"/>

									</div>
									
                    				<div class="form-group col-md-7">
										<label for="emp_cnpj">Empresa:</label>
										<input type="text" DISABLED class="form-control" value="<?=$rs->fld("empresa");?>"/>
									</div>
									<div class="form-group col-md-1">
										<label for="emp_cnpj">Prazo:</label>
										<input type="text" DISABLED id="trata_venc" name="trata_venc" class="form-control" value="<?=str_pad($rs->fld("cliarq_venc"),2,"0",STR_PAD_LEFT);?>"/>
									</div>

									<div class="form-group col-md-2">
										<label for="emp_cnpj">Compet&ecirc;ncia:</label>
										<input type="text" DISABLED class="form-control" name="trata_competencia" id="trata_competencia" value="<?=$rs->fld("trata_competencia");?>"/>
									</div>
								</div>
								<div class="row">
									<div class="form-group col-md-4">
										<label for="emp_cnpj">Carteira:</label>
										<input type="text" DISABLED class="form-control" name="trata_resp" id="trata_resp" value="<?=$ncol;?>"/>
										<input type="hidden" name="trata_respc" id="trata_respc" value="<?=$ccol;?>"/>
									</div>
									
									<div class="form-group col-md-4">
										<label for="emp_cnpj">Tratato Por:</label>
										<select style="width:100%;" class="form-control select2" name="trata_usu" id="trata_usu"/>
											<option value="">Selecione:</option>
											<?php
												$sql = "SELECT * FROM usuarios WHERE usu_ativo='1'";
												$cart = $per->getPermissao("todos_depart",$_SESSION['usu_cod']);
												if($cart['C']==0){
													$sql.=" AND usu_dep=".$_SESSION['dep'];
												}
												$sql.=" ORDER BY usu_nome ASC";
												$rs2->FreeSql($sql);
												while($rs2->GeraDados()){
													$disab = ($rs2->fld("usu_cod")==$rs->fld("trata_resp")?"SELECTED":"");
													
													?>
													<option <?=$disab;?> value="<?=$rs2->fld("usu_cod");?>" ><?=$rs2->fld("usu_nome");?></option>
											<?php
												}
											?>
										</select>
									</div>
									<div class="form-group col-md-4">
										<label for="emp_cnpj">Arquivo:</label>
										<input type="text" DISABLED class="form-control" name="trata_arqu" id="trata_arqu" value="<?=$rs->fld("tarq_nome");?>"/>
									</div>
                    			</div>
                    			
								
								<div class="row">
									<div class="form-group col-md-12">
										<label for="emp_cnpj">Observa&ccedil;&atilde;o:</label>
										<textarea class="form-control" name="hom_obs" id="editor1"></textarea>
									</div>
									

								</div>

								<div id="consulta"></div>
								<div id="formerrosFila" class="clearfix" style="display:none;">
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
									if($rs->fld("trata_status")==0 OR $rs->fld("trata_status")==-1):?>
										<button id="bt_dispArq" type="button" class="btn btn-sm btn-primary"><i class="fa fa-mail-forward"></i> Disponibilizar</button>
									<?php endif;
									if($rs->fld("trata_status")==92):?>
										<button id="bt_finArq" type="button" class="btn btn-sm btn-success"><i class="fa fa-check-square-o"></i> Finalizar</button>
										<button id="bt_errArq" type="button" class="btn btn-sm btn-danger"><i class="fa fa-times"></i> Cont&eacute;m Erros</button>
									<?php endif;
								?>
								
							</div>
						</form>
					</div><!-- ./box -->
					</div>
				</div><!-- ./row -->
				
				
			</div>
		</section>
	</div>
	<?php
		require_once("../config/footer.php");
	?></div><!-- ./wrapper -->


<script type="text/javascript" src="<?=$hosted;?>/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script type="text/javascript" src="<?=$hosted;?>/assets/bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script type="text/javascript" src="<?=$hosted;?>/assets/plugins/fastclick/fastclick.min.js"></script>
<!-- AdminLTE App -->
<script type="text/javascript" src="<?=$hosted;?>/assets/dist/js/app.min.js"></script>
<!-- Slimscroll -->
<script type="text/javascript" src="<?=$hosted;?>/assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script type="text/javascript" src="<?=$hosted;?>/assets/js/maskinput.js"></script>
<script type="text/javascript" src="<?=$hosted;?>/assets/js/jmask.js"></script>
<script type="text/javascript" src="<?=$hosted;?>/assets/bootstrap/js/star-rating.js"></script>
<script type="text/javascript" src="<?=$hosted;?>/js/action_empresas.js"></script>
<script type="text/javascript" src="<?=$hosted;?>/js/controle.js"></script>
<script type="text/javascript" src="<?=$hosted;?>/js/jquery.cookie.js"></script>
<script type="text/javascript" src="<?=$hosted;?>/js/functions.js"></script>
<script type="text/javascript" src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
<!-- Ion Slider -->
<script type="text/javascript" src="<?=$hosted;?>/assets/plugins/ionslider/ion.rangeSlider.min.js"></script>
<!-- Bootstrap slider -->
<script type="text/javascript" src="<?=$hosted;?>/assets/plugins/bootstrap-slider/bootstrap-slider.js"></script>


<!-- SELECT2 TO FORMS
-->

<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
<!-- Validation -->
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script src="<?=$hosted;?>/assets/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>

<script type="text/javascript">
	/*------------------------|INICIA TOOLTIPS E POPOVERS|---------------------------------------*/
	$(document).ready(function () {
		$(".select2").select2({
			tags: true
		});

		$("#chatContent").scrollTop($("#msgs").height());					
		setTimeout(function(){
			$("#slc").load("cham_Ocorr.php");		
			$("#alms").load(location.href+" #almsg");
		},10000);
	
		$("#pgb_homol .progress-bar").animate({width: "<?=$percent;?>%"},1000);
		

	});
	$(function(){
		// Replace the <textarea id="editor1"> with a CKEditor
		// instance, using default configuration.
		CKEDITOR.replace('editor1');

	});
	
	function mark_conf(hom, check, acao, id, obj, emp){
		act = ( check == true ? "conf_"+acao : "desconf_"+acao);
		alb = ( check == true ? "Conferir" : "Desmarcar");
		ati = ( check == true ? 1 : 0);
        $.post("../controller/TRIEmpresas.php",
	        {
	            acao:    act,
	            homol: 	 hom,
	            doc: 	 id,
	            ativo:   ati,
	            empresa: emp
	        },
	        function(data){
	            alert(data.mensagem);
        		location.reload();
	        },
	        "json"
        );
    
    }

</script>

</body>
</html>	