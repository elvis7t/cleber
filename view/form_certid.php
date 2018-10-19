<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
$sec = "Dados";
$pag = "form_certid.php";
require_once("../config/main.php");
require_once("../config/valida.php");
require_once("../config/mnutop.php");
require_once("../config/menu.php");
require_once("../config/modals.php");
require_once("../class/class.functions.php");
require_once("../class/class.permissoes.php");

$per = new permissoes();
$rs = new recordset();
$rs2 = new recordset();
$rs3 = new recordset();
$fn = new functions();
$cod = (isset($_GET['clicod']) ? $_GET['clicod'] : 477);
$con =$per->getPermissao($pag, $_SESSION['usu_cod']);

?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<!-- Content Header (Page header) -->
        <section class="content-header">
			<h1>
				Clientes - Novo Vencimento
				
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li>Gerenciamento</li>
				<li>Clientes</li>
				<li class="active">Detalhes</li>
				
			</ol>
        </section>

        <!-- Main content -->
        <section class="content">
				<div class="box box-primary">
					<form id="cad_cert" role="form">
						<div class="box-header with-border">
							<h3 class="box-title">Certid&otilde;es / Licen&ccedil;as / Procura&ccedil;&otilde;es</h3>
							<small>[<?=$cod ." - ".$rs->pegar("empresa","tri_clientes","cod = ".$cod);?>]</small>
						</div><!-- /.box-header -->
						<?php
						//echo $fn->data_br($fn->dia_util(10,"dia_util"));
						//Caso haja o código e ação, consultar no banco de dados
						if(isset($_GET['certid_id']) && $_GET['certid_id'] <> "" ){
							$whr = "certid_cod = ".$cod." AND certid_tipoId = ".$_GET['certid_id'];
							$rs2->Seleciona("*","certidoes", $whr);
							$rs2->GeraDados();
							
							$lin = $rs2->linhas;
						}
						?>
						<!-- form start -->
						<div class="box-body">
							<div class="row">
								
								<div class="form-group col-md-5">
									<label for="certid_tipo">Tipos de CLP:</label>
									<select id="certid_tipo" name="certid_tipo" class="form-control select2 m" multiple style="width:100%">
										<option value="">Selecione:</option>
										<?php
										$whr2 = "tipocertid_tipo IN ('C', 'L','P')";
										if($lin==1){$whr2 .= " AND tipocertid_id=".$_GET['certid_id'];}
										$rs->Seleciona("*","tipos_certidoes",$whr2);
										while($rs->GeraDados()){ 
											$des = $rs3->pegar("COUNT(certid_tipoId)", "certidoes", "certid_cod=".$cod." AND certid_tipoId=".$rs->fld("tipocertid_id"));
											?>
											<option <?=($des>0 && $lin==0?"disabled":"");?> value="<?=$rs->fld("tipocertid_id");?>" <?=($rs->fld("tipocertid_id")==$rs2->fld("certid_tipoId")?"SELECTED":"");?>><?=$rs->fld("tipocertid_desc");?></option>
										<?php }
										?>
									</select>	
									<input type="hidden" value="<?=$cod;?>" id="certid_cod">
									<input type="hidden" name="token" id="token" value="<?=$_SESSION['token']?>">
									<input type="hidden" name="cnpj" id="cnpj" value="<?=$_SESSION['usu_empresa']?>">
									<input type="hidden" name="acao" id="acao" value="<?=($rs2->linhas==1?"cli_AltCertid":"cli_CadCertid");?>">
									<input type="hidden" name="certid_id" id="certid_id" value="<?=$rs2->fld("certid_id");?>">
								</div>


								<div class="form-group col-md-2">
									<label for="ob_venc">Validade</label><br>
									<input type="text" class="form-control dtp" id="certid_val" name="certid_val" value="<?=$fn->data_br($rs2->fld("certid_validade"));?>" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask/>
									
								</div>
								
															
								<div class="form-group col-md-2">
									<label for="emp_uf">Status</label><br>
									<input type="radio" value=1  id="certid_status" <?=($rs2->fld("certid_status")==1?"CHECKED":"");?> name="certid_status"> Ativo 
									<input type="radio" value=0  id="certid_status" <?=($rs2->fld("certid_status")==0?"CHECKED":"");?> name="certid_status"> Inativo
								</div>
							</div>
							<div id="consulta"></div>
							<div id="formerros_cert" class="clearfix" style="display:none;">
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
							
							//echo $con["I"];
							if(isset($lin) AND $lin == 1){
								if($con["A"] == 1){ ?>
									<button type="button" id="bt_cadCertid" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Atualizar </button>
								<?php }
							}
							else{
								if($con["I"] == 1){ ?>
									<button type="button" id="bt_cadCertid" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Salvar </button>
								<?php }
							}
							?>
							<a href="javascript:history.go(-1);" class="btn btn-sm btn-danger"><i class="fa fa-hand-o-left"></i> Voltar </a>

						</div>
					</form>
					<div id="consulta"></div>
				</div>
			
		</section>
	</div>
	
		<?php 
			require_once("../config/footer.php");
			//require_once("../config/sidebar.php");
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
<script src="<?=$hosted;?>/sistema/js/controle.js"></script>
<script src="<?=$hosted;?>/sistema/js/action_empresas.js"></script>

<!-- SELECT2 TO FORMS
-->
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
<!-- Validation -->
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/datatables/dataTables.bootstrap.min.js"></script> 
<script src="<?=$hosted;?>/sistema/js/jquery.cookie.js"></script>
<script src="<?=$hosted;?>/sistema/js/functions.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/input-mask/jquery.inputmask.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/input-mask/jquery.inputmask.extensions.js"></script>

	<script type="text/javascript">
	setInterval(function(){

		if($.cookie('msg_lido')==0) {
			notify($.cookie("user"), $.cookie("mensagem"),$.cookie("pag"));
			$.cookie("msgant");
			$.cookie('msg_lido',1);
		}
	},3500);

	
		
	$(".select2").select2({
		tags: true
	});
	$(".select2.m").select2({
		theme:"classic"
	});
	
	$(".dtp").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/aaaa"});			
		
	
	</script>

</body>
</html>	