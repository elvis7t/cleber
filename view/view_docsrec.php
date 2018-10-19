<?php
/*inclusão dos principais itens da página */
$sec = "Mens";
$pag = "view_docsrec.php";
require_once("../config/main.php");
require_once("../config/valida.php");
require_once("../config/mnutop.php");
require_once("../config/menu.php");
require_once("../config/modals.php");
require_once("../class/class.functions.php");
require_once("../class/class.permissoes.php");

$fn = new functions();

$per = new permissoes();
$con = $per->getPermissao("entrega_docs.php", $_SESSION['usu_cod']);
$deps = $per->getPermissao("todos_depart", $_SESSION['usu_cod']);

if($con['C']<>1){
  header("location:403.php?token=".$_SESSION['token']);
}
$pcli = (isset($_GET['cli'])?$_GET['cli']:0);
$pdep = (isset($_GET['dep'])?$_GET['dep']:0);
$pref = (isset($_GET['ref'])?$_GET['ref']:"");

?>

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				Envio de Documentos 
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li>Documentos</li>
				<li class="active">Enviar documento</li>
			</ol>
		</section>

		<!-- Main content -->
		<section class="content">
		<form role="form" id="publica_docs">
			<div class="row">
				<div class="col-md-12">
				<!-- general form elements -->
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">Enviar Documentos</h3>
						</div><!-- /.box-header -->
						<!-- form start -->
							<div class="box-body">
								<div class="row">
									<div class="form-group col-xs-4">
										<label for="publ_cli">Cliente:</label><br>
										<select class="form-control select2 input-sm" id="publ_cli" name="publ_cli">
											<option value="">Selecione:</option>
											<?php
												$whr="ativo = 1";
												$rs->Seleciona("*","tri_clientes",$whr);
												while($rs->GeraDados()):	
												?>
												<option <?=($pcli==$rs->fld("cod")?"SELECTED":"");?> value="<?=$rs->fld("cod");?>"><?=str_pad($rs->fld("cod"), 3,0,STR_PAD_LEFT)." - ".$rs->fld("empresa");?></option>
											<?php
												endwhile;
											?>
										</select>
									</div>

									<div class="form-group col-xs-3">
										<label for="publ_dep">Departamento:</label><br>
										<select class="form-control select2 input-sm" name="publ_dep" id="publ_dep" style="width:100%;">
											<option value="">Selecione:</option>
											<?php
												
												if($deps["C"]==1){$whr="dep_id <> ''";}
												else{$whr="dep_id=".$_SESSION['dep'];}
												/*
												$whr="dep_id <> ''";
												*/
												$rs->Seleciona("dep_id, dep_nome","departamentos",$whr);
												while($rs->GeraDados()):	
												?>
												<option <?=($pdep==$rs->fld("dep_id")?"SELECTED":"");?> value="<?=$rs->fld("dep_id");?>"><?=$rs->fld("dep_nome");?></option>
											<?php
												endwhile;
											?>
											
										</select>
									</div>

									
									<div class="form-group col-xs-2">
										<label for="publ_ref">Refer&ecirc;ncia</label>
										<input type="text" class="form-control input-sm shortdate" name="publ_ref" id="publ_ref" value="<?=$pref;?>"/>
									</div>
									<div class="form-group col-xs-3">
										<label for="publ_imposto">Imposto Relacionado:</label><br>
										<select class="form-control select2 input-sm" name="publ_imposto" id="publ_imposto" style="width:100%;">
											<?php
												$sql = "SELECT a.env_id, a.env_codEmp , b.imp_id, b.imp_nome FROM impostos_enviados a
													JOIN tipos_impostos b ON b.imp_id = a.env_codImp
													WHERE 1
														AND a.env_codEmp = {$pcli}
														AND a.env_compet = '{$pref}'
														AND b.imp_depto = {$pdep}
														AND a.env_conferido = 1
														AND a.env_enviado <> 1	";
												$rs->FreeSql($sql);
												if($rs->linhas>0){
													while($rs->GeraDados()){?>
														<option SELECTED value = <?=$rs->fld("imp_id");?>><?=$rs->fld("imp_nome");?></option>
													<?php }
												}
												else{?>
														<option SELECTED value="">Sem Impostos</option>
												<?php }
											?>					
										</select>
									</div>
								</div>
								
								<div class="row">
									<div class="form-group col-xs-12">
										<label for="doc_obs">Observa&ccedil;&atilde;o <small>(Opcional)</small></label>
										<textarea class="form-control input-sm" name="doc_obs" id="doc_obs"></textarea>
									</div>
								</div>
							</div>
							
						<div class="box-footer">
							<div id="consulta"></div>
						</div>
					</div><!-- ./box -->
					<div class="col-md-12">
						<div class="row">
							<div class="box-primary">
								<div class="box box-success">
									<div class="box-header with-border">
										<h3 class="box-title">Arraste aqui seus arquivos</h3>
										<div class="box-body" id="dropZone">
											<span class="btn btn-success fileinput-button">
												<i class="fa fa-plus"></i>
												<span>Adicionar...</span>
												<!-- The file input field used as target for the file upload widget -->     
												<input id="fileupload" type="file" name="attachments[]" multiple>
												<input type="hidden" value="<?=$_SESSION["usuario"];?>" id="publ_uenv"/>
											</span>
											<br>
											<br>
											<!-- The global progress bar -->
											<div id="progress" class="progress">
												<div class="progress-bar progress-bar-success"></div>
											</div>
											<!-- The container for the uploaded files -->
											<div id="files" class="files"></div>
										</div>
										<div class="box-footer">
											<div id="formerros_publ" class="clearfix" style="display:none;">
												<div class="callout callout-danger">
													<h4>Erros no preenchimento do formul&aacute;rio.</h4>
													<p>Verifique os erros no preenchimento acima:</p>
													<ol>
														<!-- Erros são colocados aqui pelo validade -->
													</ol>
												</div>
											</div>
											<button class="btn btn-success" id="btnEnvia" DISABLED><i class="fa fa-cloud"></i> Enviar Arquivos</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div><!-- ./row -->
			</form>
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
<script src="<?=$hosted;?>/sistema/js/controle.js"></script>
<script src="<?=$hosted;?>/sistema/js/action_documentos.js"></script>
<script src="<?=$hosted;?>/sistema/js/jquery.cookie.js"></script>
<script src="<?=$hosted;?>/sistema/js/functions.js"></script>	
<!-- File Upload Plugins -->
<script src="<?= $hosted; ?>/sistema/assets/jQueryFileUpload/js/vendor/jquery.ui.widget.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="//blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="//blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
<!--<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>-->
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="<?= $hosted; ?>/sistema/assets/jQueryFileUpload/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="<?= $hosted; ?>/sistema/assets/jQueryFileUpload/js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="<?= $hosted; ?>/sistema/assets/jQueryFileUpload/js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="<?= $hosted; ?>/sistema/assets/jQueryFileUpload/js/jquery.fileupload-image.js"></script>
<!-- The File Upload audio preview plugin -->
<script src="<?= $hosted; ?>/sistema/assets/jQueryFileUpload/js/jquery.fileupload-audio.js"></script>
<!-- The File Upload video preview plugin -->
<script src="<?= $hosted; ?>/sistema/assets/jQueryFileUpload/js/jquery.fileupload-video.js"></script>
<!-- The File Upload validation plugin -->
<script src="<?= $hosted; ?>/sistema/assets/jQueryFileUpload/js/jquery.fileupload-validate.js"></script>

<!--INPUT MASK -->
<script src="<?=$hosted;?>/sistema/assets/plugins/input-mask/jquery.inputmask.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/input-mask/jquery.inputmask.extensions.js"></script>


<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
<!-- Validation -->
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script>
	
	$(function(){
		$("#publ_ref").focus();
		var url = '../assets/jQueryFileUpload/server/php/',
                uploadButton = $('<button/>')
                .addClass('btn btn-primary')
                .prop('disabled', true)
                .text('Processando...')
                .on('click', function () {
                    var $this = $(this),
                            data = $this.data();
                    $this
                            .off('click')
                            .text('Abortar')
                            .on('click', function () {
                                $this.remove();
                                data.abort();
                            });
                    data.submit().always(function () {
                        $this.remove();
                    });
                });

		var files = $("#files");
		var url = '../documentos/uploads.php';
		
		$('#fileupload').fileupload({
			url: url,
			dropZone: '#dropZone',
			dataType: 'json',
			autoUpload: false
		}).on('fileuploadadd', function (e, data) {
			var fileTypeAllowed = /.\/.(gif|jpg|jpeg|png|xls|xlsx|pdf)$/i;
			var fileName = data.originalFiles[0]['name'];
			var fileSize = data.originalFiles[0]['size'];
			$('#progress .progress-bar').css('width','0%');
			if(fileTypeAllowed.test(fileName))
				$("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-times"></i> Verifique o formato do arquivo!<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
			else if(fileSize > 10485760 )//10Mb
				$("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-times"></i> Arquivo maior que o permitido [10Mb]<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
			else{
				data.context = $('<div/>').appendTo('#files');
	            $.each(data.files, function (index, file) {
	                var node = $('<p/>')
	                        .append($('<span/>').text(file.name));
	                if (!index) {
	                    node
	                            .append('<br>')
	                            .append(uploadButton.clone(true).data(data));
	                }
	                node.appendTo(data.context);
	            });
								
			}
		}).on('fileuploadprocessalways', function (e, data) {
            var index = data.index,
                    file = data.files[index],
                    node = $(data.context.children()[index]);
            if (file.preview) {
                node
                        .prepend('<br>')
                        .prepend(file.preview);
            }
            if (file.error) {
                node
                        .append('<br>')
                        .append($('<span class="text-danger"/>').text(file.error));
            }
            if (index + 1 === data.files.length) {
            	var container = $("#formerros_publ");
				//e.preventDefault;
				$("#publica_docs").validate({
					debug: true,
					errorClass: "error",
					errorContainer: container,
					errorLabelContainer: $("ol", container),
					wrapper: 'li',
					rules: {
						publ_cli 	: {required: true},
						publ_dep 	: {required: true},
						publ_ref 	: {required: true},
						publ_imposto: {required: true}
					},
					messages: {
						publ_cli 	: {required: "Selecione uma empresa"},
						publ_dep 	: {required: "Selecione departamento "},
						publ_ref 	: {required: "Informe a data de refer&ecirc;ncia"}, 
						publ_imposto: {required: "Informe o imposto/tributo/cálculo relacionado"} 
					},
					highlight: function(element) {
						$(element).closest('.form-group').addClass('has-error');
					},
					unhighlight: function(element) {
						$(element).closest('.form-group').removeClass('has-error');
					}
				});
				
				if($("#publica_docs").valid()==true){
					//data.submit();	

                	data.context.find('button')
                		.addClass('enviaArqs')
                        .text('Upload')
                        .prop('disabled', 'disabled');
                    $("#btnEnvia").prop('disabled','');
				}
								
            }
        }).on('fileuploaddone', function (e, data) {  
			var status = data.jqXHR.responseJSON.status;
			var msg = data.jqXHR.responseJSON.msg;
			if(status == 1){
				$("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> '+msg+'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
				location.href="index.php?token=<?=$_SESSION['token']?>";
			}
			else{
				$("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-times"></i> '+msg+'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
			}
		
		}).on('fileuploadprogressall', function (e, data) {
			console.log(data);
			var progress = parseInt(data.loaded / data.total * 100, 10);
			$('#progress .progress-bar').css('width',progress + '%');
		
		});
		$(document.body).on("click","#btnEnvia", function(){
			$(".enviaArqs").trigger("click");
		})

		/*$(document.body).on("blur","#publ_ref", function(){
			$.post("../controller/TRIDocumentos.php", {
            acao: "atualiza_envios",
            publ_cli: $("#publ_cli").val(),
            publ_dep: $("#publ_dep").val(),
            publ_ref: $("#publ_ref").val()
        },
                function (data) {
                    $("#publ_imposto").select2('val','');
                    $("#publ_imposto").html('');
                    $("#publ_imposto").html(data);
                }, "html");
		});
		*/	
		$(".select2").select2({
			tags: true
		});
		$(".seldocs").select2({
			tags: true,
			theme: "classic"
		});
	});
		
</script>
</body>
</html>	