<?php
/*inclusão dos principais itens da página */
$sec = "Dados";
$pag = "form_arquivos";
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
$cod = (isset($_GET['clicod']) ? $_GET['clicod'] : 477);

?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<!-- Content Header (Page header) -->
        <section class="content-header">
			<h1>
				Clientes - Novo Arquivo
				
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li>Gerenciamento</li>
				<li>Clientes</li>
				<li class="active">Arquivos</li>
				
			</ol>
        </section>

        <!-- Main content -->
        <section class="content">
				<div class="box box-primary">
					<form id="cad_arquivos" role="form">
						<div class="box-header with-border">
							<h3 class="box-title">Arquivos</h3>
							<small>[<?=$cod ." - ".$rs->pegar("empresa","tri_clientes","cod = ".$cod);?>]</small>
						</div><!-- /.box-header -->
						<?php
						//Caso haja o código e ação, consultar no banco de dados
						if(isset($_GET['arq_id']) && $_GET['arq_id'] <> "" ){
							$whr = "cliarq_id = ".$_GET['arq_id'];
							$rs2->Seleciona("*","clientes_arquivos", $whr);
							$rs2->GeraDados();
							$lin = $rs2->linhas;
							//echo $rs2->sql;
						}

						?>

						<!-- form start -->
						<div class="box-body">
							<div class="row">
								<div class="form-group col-md-4">
									<label for="arq_depto">Departamento:</label><br>
									<select class="select2" name="arq_depto" id="arq_depto" style="width:100%;">
										<option value="">Selecione:</option>
									
									<?php
									$con = $per->getPermissao("todos_depart",$_SESSION['usu_cod']);

									$whr = "dep_id<>0";
									if($con['C']<>1){$whr.= " AND dep_id=".$_SESSION['dep'];}
									$rs->Seleciona("*","departamentos",$whr);
									while($rs->GeraDados()):	
									?>
										<option value="<?=$rs->fld("dep_id");?>"><?=$rs->fld("dep_nome");?></option>
									<?php
									endwhile;
									?>
									</select>
								</div>


								<div class="form-group col-md-4">
									<label for="arq_titulo">Titulo:</label>
									<select id="arq_titulo" name="arq_titulo" multiple="multiple" class="form-control select2 m" style="width:100%">
										<option value="">Selecione:</option>
										
									</select>	
									<input type="hidden" value="<?=$cod;?>" id="arq_clicod">
									<input type="hidden" name="token" id="token" value="<?=$_SESSION['token']?>">
									<input type="hidden" name="cnpj" id="cnpj" value="<?=$_SESSION['usu_empresa']?>">
									<input type="hidden" name="acao" id="acao" value="<?=($rs2->linhas==1?"cli_Altarquivo":"cli_Cadarquivo");?>">
									<input type="hidden" name="arq_id" id="arq_id" value="<?=$rs2->fld("cliarq_id");?>">
								</div>
								
								<div class="form-group col-md-1">
									<label for="arq_ativo">Vencimento:</label>
									<input class="form-control" type="text" id="arq_venc" name="arq_venc" value="<?=$rs2->fld("cliarq_venc");?>">
								</div>
								
								<div class="form-group col-md-3">
									<label for="arq_ativo">Detalhes:</label>
									<input class="form-control" type="text" id="arq_detalhes" name="arq_detalhes" value="<?=$rs2->fld("cliarq_detalhes");?>">
								</div>
								
								<div class="form-group col-md-3">
									<label for="arq_ativo">Status</label><br>
									<input type="radio" value=1  id="arq_ativo" <?=($rs2->fld("cliarq_ativo")==1?"CHECKED":"");?> name="arq_ativo"> Ativo 
									<input type="radio" value=0  id="arq_ativo" <?=($rs2->fld("cliarq_ativo")==0?"CHECKED":"");?> name="arq_ativo"> Inativo
								</div>
							</div>
							<div id="consulta"></div>
							<div id="formerros_arquivos" class="clearfix" style="display:none;">
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
							$con =$per->getPermissao($pag, $_SESSION['usu_cod']);
							//echo $con["I"];
							
							if(isset($lin) AND $lin == 1){
								/* ALTERAÇÃO 07.02.2018 - SOLICITADO POR RAFAELA 
									RETIRAR CONDIÇÃO PARA ALTERAR A DATA DO ARQUIVO*/
								//if( ($con["A"] == 1 && ($_SESSION['lider']=="Y" || date('d')>=25 || date("d") <=6))){
								if( ($con["A"] == 1)){ ?>
									<button type="button" id="bt_cadArq" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Atualizar </button>
								<?php }
							}
							else{
								if(($con["I"] == 1)){ ?>
									<button type="button" id="bt_cadArq" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Salvar </button>
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
	 

	<script type="text/javascript">
	setInterval(function(){

		if($.cookie('msg_lido')==0) {
			notify($.cookie("user"), $.cookie("mensagem"),$.cookie("pag"));
			$.cookie("msgant");
			$.cookie('msg_lido',1);
		}
	},3500);

	 $(function () {
		// Replace the <textarea id="com_obs"> with a CKEditor
		// instance, using default configuration.
		CKEDITOR.replace('com_obs');
	});


	$(".select2").select2({
		tags: true
	});
	$(".select2.m").select2({
		theme:"classic",
		language: {
	    	noResults: function() {
	        	return "<a target='blank' href='form_cadarquivos.php?token=<?=$_GET["token"];?>&clicod='>Novo...</a>";
	    	}
	    },
	    escapeMarkup: function (markup) {
	        return markup;
	  	}
	});
	
	$(document).ready(function(){
		$("#empr").DataTables({
				"columnDefs": [{
				"defaultContent": "-",
				"targets": "_all"
			}]
		});
	});

	$("#arq_depto").change(function(){
		$("#arq_titulo").select2("val",0);
		$.post("../controller/TRIEmpresas.php",
		{
			acao: 	"opt_arquivo",
			dept: 	$("#arq_depto").val(),
			codi: 	$("#arq_clicod").val(),
			caid: 	$("#arq_id").val()
		},
		function(data){
			$("#arq_titulo").html(data);
			console.log(data);
		},
		"html");
	});
	
	
	</script>

</body>
</html>	