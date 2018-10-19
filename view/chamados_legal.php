<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start("portal");
$sec = "SERV";
$pag = "vis_tarefaslegal.php";
require_once("../config/main.php");
require_once("../config/valida.php");
require_once("../config/mnutop.php");
require_once("../config/menu.php");
require_once("../config/modals.php");
require_once("../../sistema/class/class.functions.php");

$fn = new functions();

$cliente;
$solici;
$via;
$concluir;
$t_princ="";

$disabled = (isset($_GET['acao'])?"hide":"");

if(isset($_GET['chamado']) AND $_GET['chamado']<>""){
	$rs_eve = new recordset();
	$sql = "SELECT a.cleg_id, a.cleg_trat, a.cleg_empresa, b.usu_nome, a.cleg_datafim FROM chamados_legal a
			LEFT JOIN usuarios b ON a.cleg_trat = b.usu_cod 
			WHERE cleg_id =".$_GET['chamado'];
	$rs_eve->FreeSql($sql);
	$rs_eve->GeraDados();
	$t_princ 	= (isset($_GET['acao'])?0:$rs_eve->fld("cleg_id"));
	$cliente 	= $rs_eve->fld("cleg_empresa");
	$solici 	= $rs_eve->fld("usu_nome");
	$via 		= "Portal";
	$concluir 	= (isset($_GET['acao'])?"":$fn->data_br($rs_eve->fld("cleg_datafim")));
	//unset($rs_eve);
}	

?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<!-- Content Header (Page header) -->
        <section class="content-header">
        	
        	<h1>
				Tarefas - Legaliza&ccedil;&atilde;o
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li>Solicita&ccedil;&atilde;o</li>
				<li class="active">Chamados - Legal</li>
			</ol>
        </section>

        <!-- Main content -->
        <section class="content">
			<div class="row">
				<div class="col-md-12">
				<!-- general form elements -->
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">Solicitar Servi&ccedil;o</h3>
						</div><!-- /.box-header -->
						<!-- form start -->
						<form role="form" id="cad_chamleg">
							<input type="hidden" id="emp_altera" value=0 />
							<div class="box-body">
								<!-- radio Clientes -->
								<div class="row">
									<div class="form-group col-md-3">
										<label for="cleg_depto">Departamento:</label><br>
										<select class="select2" name="cleg_depto" id="cleg_depto"  style="width:100%;">
											<option value="">Selecione:</option>
											
											<?php
											$whr="dep_id < 10";
											$rs->Seleciona("*","departamentos",$whr);
											while($rs->GeraDados()):	
											?>
												<option <?=($rs->fld("dep_id")==$_SESSION['dep']?"SELECTED" :"");?> value="<?=$rs->fld("dep_id");?>"><?=$rs->fld("dep_nome");?></option>
											<?php
											endwhile;
											?>
										</select>
									</div>
									
									<div class="form-group col-md-3">
										<label for="cleg_colab">Colaborador:</label>
										<select class="select2" name="cleg_colab" id="cleg_colab" style="width:100%;">
											<option value="">Selecione:</option>
											<?php
											$whr="usu_ativo = '1' AND usu_empcod=".$_SESSION['sys_id'];
											$rs->Seleciona("*","usuarios",$whr,'','usu_nome ASC');
											while($rs->GeraDados()):	
											?>
												<option <?=($_SESSION['usu_cod']==$rs->fld("usu_cod")?"SELECTED":"");?> value="<?=$rs->fld("usu_cod");?>"><?=$rs->fld("usu_nome");?></option>
											<?php
											endwhile;
											?>
										</select>									
									</div>

									<div class="form-group col-md-3">
										<label for="cleg_cliente">Cliente:</label>
										<select class="select2" name="cleg_cliente" id="cleg_cliente" style="width:100%;">
											<option value="">Selecione:</option>
											<?php
											$whr = "ativo IN(1,2)";
											$rs->Seleciona("*","tri_clientes",$whr);
											while($rs->GeraDados()):	
											?>
												<option value="<?=$rs->fld("cod");?>" <?=($cliente==$rs->fld("cod")?"SELECTED":"");?>><?=$rs->fld("cod")." - ".$rs->fld("apelido");?></option>
											<?php
											endwhile;
											?>
										</select>									
									</div>

									<div class="form-group col-md-3 <?=$disabled;?>">
										<label for="cleg_tipo">Tipo:</label>
										<select class="select2" name="cleg_tipo" id="cleg_tipo" style="width:100%;">
											<option value="">Selecione:</option>
											<?php
											$whr="lista_id<>0";
											$rs->Seleciona("*","listagens",$whr,'','lista_desc ASC');
											while($rs->GeraDados()):	
											?>
												<option value="<?=$rs->fld("lista_id");?>"><?=$rs->fld("lista_desc");?></option>
											<?php
											endwhile;
											?>
										</select>									
									</div>	
								</div>								
								<div class="row">									

									<div class="form-group col-md-5">
										<label for="cleg_contato">Solicitado por:</label>
										<input type="text" class="form-control" <?=($solici<>""?"DISABLED":"");?> name="cleg_contato" id="cleg_contato" value="<?=$solici;?>"/>
									</div>

									<div class="form-group col-md-2">
										<label for="cleg_via">Solicitado via:</label>
										<select class="select2" name="cleg_via" id="cleg_via" <?=($via<>""?"DISABLED":"");?> style="width:100%;">
											<option value="">Selecione:</option>
											<option value="E-mail">E-Mail</option>
											<option value="Telefone">Telefone</option>
											<option value="Skype">Skype</option>
											<option value="Whatsapp">Whatsapp</option>
											<option value="Reunião">Reunião</option>
											<option <?=($via<>""?"SELECTED":"");?> value="Portal">Portal</option>
										</select>									
									</div>

									<div class="form-group col-md-2">
										<label for="cleg_datafim">Concluir até:</label>
										<input type="text" class="form-control dtp" name="cleg_datafim" id="cleg_datafim" <?=($concluir<>""?"DISABLED":"");?> data-inputmask="'alias': 'dd/mm/yyyy'" data-mask value="<?=$concluir;?>"/>
										
									</div>
									

										<div class="form-group col-md-2">
											<label for="cleg_datafim">Tarefa principal:</label>
											<input type="text" DISABLED class="form-control" name="cleg_id" id="cleg_id" value="<?=($t_princ<>""?$t_princ:$_GET['chamado']);?>" />
											
										</div>
								

								</div>

								<div class="row <?=$disabled;?>">
									<div class="form-group col-md-12">
										<label for="cleg_clist">Checklist do Chamado: </label>
										<span class="pull-right"><input id="cleg_allCheck" type="checkbox"> Todos</span>
										<select class="select3" name="cleg_clist" id="cleg_clist" multiple style="width:100%;">
											
										</select>									
									</div>
								</div>

								<div class="row">
									<div class="form-group col-md-12">
										<label for="cleg_obs">Descri&ccedil;&atilde;o:</label>
										<textarea class="form-control" name="cleg_obs" id="cleg_obs"></textarea>
									</div>
								</div>

								<div id="consulta"></div>
								<div id="formerros_chamaleg" class="clearfix" style="display:none;">
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
								if(isset($_GET['acao'])): ?>
									<button class="btn btn-sm btn-warning" type="button" id="bt_alt_chamleg"><i class="fa fa-cogs"></i> Alterar</button>
								<?php
								else:
									?>
									<button class="btn btn-sm btn-success" type="button" id="bt_chamleg"><i class="fa fa-cog"></i> Solicitar</button>
								<?php
								endif;
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
<script src="<?=$hosted;?>/sistema/js/action_chamlegal.js"></script>
<script src="<?=$hosted;?>/sistema/js/controle.js"></script>
<script src="<?=$hosted;?>/sistema/js/jquery.cookie.js"></script>
<script src="<?=$hosted;?>/sistema/js/functions.js"></script>
<script src="https://cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/input-mask/jquery.inputmask.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/input-mask/jquery.inputmask.extensions.js"></script>


<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
<!-- Validation -->
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script>
	/*------------------------|INICIA TOOLTIPS E POPOVERS|---------------------------------------*/
	$(document).ready(function () {
		$(".dtp").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/aaaa"});			
		$(".select2").select2({
			tags: true
		});
		$(".select3").select2({
			tags: true,
			theme: 'classic'
		});
		
		setTimeout(function(){
			$("#slc").load("meus_chamados.php");		
			$("#alms").load(location.href+" #almsg");
		 },10000);
	});

	 $(function () {
			// Replace the <textarea id="editor1"> with a CKEditor
			// instance, using default configuration.
			CKEDITOR.replace( 'cleg_obs', {
			    filebrowserUploadUrl: "upload.php" 
			});
		});
</script>

</body>
</html>	