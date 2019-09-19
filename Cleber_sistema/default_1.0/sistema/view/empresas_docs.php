<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
//session_start();
require_once("../config/main.php");
require_once("../config/valida.php");
require_once("../config/mnutop.php");
$sec = "IRRF";
$pag = "empresas_docs.php";

require_once("../config/menu.php");
require_once("../config/modals.php");


if(isset($_POST['doc_pes'])):
$doc = $_POST['doc_pes'];
else:
    if(isset($_GET['doc_pes'])):
        $doc = $_GET['doc_pes'];
    else:
    $doc = $_SESSION["usu_empresa"];
    endif;
endif;
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Empresas
            <small>Uploads de Docs</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="">Empresas</li>
            <li class="active">Documentos</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content" id="docs">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Documentos <?= "| <b>".$rs->pegar("emp_razao", "empresas", "emp_cnpj = '".$doc."'")."</b>"; ?></h3>
                    </div><!-- /.box-header -->
                    <?php 
                    if($_SESSION['classe']==1 &&!isset($_POST['doc_pes'])): ?>
                        <form role="form" method="POST" action="empresas_docs.php?token=<?= $_SESSION['token']; ?>">
                            <div class="box-body" id="aba_con">
                                <div class="row">
                                    <div class="form-group col-xs-4">
                                        <label for="emp_cnpj">CPF</label>
                                        <input class="form-control cpf" name="doc_pes" id="emp_cnpj" placeholder="CPF">
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer">
                                <button type="submit" id="bt_doc_pes" class="btn btn-primary btn-sm"><i class="fa fa-search"></i> Procurar...</button>
                            </div>
                            <?php 
                            endif;
                            ?>
                        </form>
                        <div class="box-body">
                                <?php 
                                require_once("cons_arqs.php"); 
                                ?>
                        </div>
                    </div>
                     <?php
                    if(!empty($doc)) {require_once("envio_arquivos.php");}
                    ?>
            </div>
            <!--
            <div class="col-sm-6 col-md-6">
                    <div id="tabl_arqs">
                            <section>	
                                    <div class="box box-success col-md-12">
                                            <div class="box-header with-border">
                                                    <h3 class="box-title">Tabela de Documentos <?= "| <b>".$rs->pegar("emp_nome", "empresas", "emp_cnpj = '".$doc."'")."</b>"; ?></h3>
                                            </div><!-- /.box-header 
                                            <div class="box-body">
                                                    <? //require_once("tabl_arqs.php");?>
                                            </div>
                                    </div>
                            </section>
                    </div>
            </div>
            -->
        </div>

    </section>
</div>

<?php
require_once("../config/footer.php");
//require_once("../config/sidebar.php");
?>
</div><!-- ./wrapper -->

<script src="<?= $hosted; ?>/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="<?= $hosted; ?>/assets/bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="<?= $hosted; ?>/assets/plugins/fastclick/fastclick.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= $hosted; ?>/assets/dist/js/app.min.js"></script>
<!-- Slimscroll -->
<script src="<?= $hosted; ?>/assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="<?= $hosted; ?>/assets/js/maskinput.js"></script>
<script src="<?= $hosted; ?>/assets/js/jmask.js"></script>
<script src="<?=$hosted;?>/js/controle.js"></script>
<script src="<?=$hosted;?>/js/jquery.cookie.js"></script>
<script src="<?=$hosted;?>/js/functions.js"></script>
<script src="<?=$hosted;?>/js/action_empresas.js"></script>
<!-- File Upload Plugins -->
<script src="<?= $hosted; ?>/assets/jQueryFileUpload/js/vendor/jquery.ui.widget.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="//blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="//blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
<!--<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>-->
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="<?= $hosted; ?>/assets/jQueryFileUpload/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="<?= $hosted; ?>/assets/jQueryFileUpload/js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="<?= $hosted; ?>/assets/jQueryFileUpload/js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="<?= $hosted; ?>/assets/jQueryFileUpload/js/jquery.fileupload-image.js"></script>
<!-- The File Upload audio preview plugin -->
<script src="<?= $hosted; ?>/assets/jQueryFileUpload/js/jquery.fileupload-audio.js"></script>
<!-- The File Upload video preview plugin -->
<script src="<?= $hosted; ?>/assets/jQueryFileUpload/js/jquery.fileupload-video.js"></script>
<!-- The File Upload validation plugin -->
<script src="<?= $hosted; ?>/assets/jQueryFileUpload/js/jquery.fileupload-validate.js"></script>


<script>
    /*jslint unparam: true, regexp: true */
    /*global window, $ */
    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
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
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            autoUpload: false,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png|pdf|docx|xlsx|xls|xml)$/i,
            maxFileSize: 1024000000,
            // Enable image resizing, except for Android and Opera,
            // which actually support image resizing, but fail to
            // send Blob objects via XHR requests:
            disableImageResize: /Android(?!.*Chrome)|Opera/
                    .test(window.navigator.userAgent),
            previewMaxWidth: 100,
            previewMaxHeight: 100,
            previewCrop: true
        }).on('fileuploadadd', function (e, data) {
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
                data.context.find('button')
                        .text('Upload')
                        .prop('disabled', !!data.files.error);
            }
        }).on('fileuploadprogressall', function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                    'width',
                    progress + '%'
                    );
        }).on('fileuploaddone', function (e, data) {
            $.each(data.result.files, function (index, file) {
                if (file.url) {
                    var link = $('<a>')
                            .attr('target', '_blank')
                            .prop('href', file.url);
                    $(data.context.children()[index])
                            .wrap(link);
                    $.post("../controller/TRIConsultaEmpresa.php",
                            {
                                acao: "documentos",
                                doc_end: file.url,
                                doc_desc: file.name,
                                doc_cli: $("#doc_cli").val(),
                                doc_uenv: $("#doc_uenv").val(),
                                doc_tipo: file.type
                            }, function () {
                        $("#cons_arqs").fadeOut("slow");
                        $("#cons_arqs").load("cons_arqs.php?doc_pes=" + $("#doc_cli").val()).fadeIn("slow");
                        //$("#tabl_arqs").load("tabl_arqs.php").fadeIn("slow");
                    });
                } else if (file.error) {
                    var error = $('<span class="text-danger"/>').text(file.error);
                    $(data.context.children()[index])
                            .append('<br>')
                            .append(error);
                }
            });
        }).on('fileuploadfail', function (e, data) {
            $.each(data.files, function (index) {
                var error = $('<span class="text-danger"/>').text('Falha no envio.');
                $(data.context.children()[index])
                        .append('<br>')
                        .append(error);
            });
        }).prop('disabled', !$.support.fileInput)
                .parent().addClass($.support.fileInput ? undefined : 'disabled');
    });
</script>



</body>
</html>