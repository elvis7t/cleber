<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start("portal");
$sec = "Mens";
$pag = "view_docsmail.php";
require_once("../config/main.php");
require_once("../config/valida.php");
require_once("../config/mnutop.php");
require_once("../config/menu.php");
require_once("../config/modals.php");
require_once("../class/class.functions.php");
$fn1 = new functions();
$rs1 = new recordset();
?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<!-- Content Header (Page header) -->
        <section class="content-header">
			<h1>
				Enviar E-mails
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li>Solicita&ccedil;&atilde;o</li>
				<li class="active">Documentos - E-mails</li>
			</ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
              <?php
              require_once("view_docsmailmenu.php");
              ?>
             <div class="col-md-9">
              <div class="box box-primary">
                <div class="box-header with-border">
					<h3 class="box-title">Nova Mensagem</h3>
                </div><!-- /.box-header -->
                <?php
                	$rs = new recordset();
                	$sql = "SELECT * FROM maildocumento a 
                				WHERE mds_id ={$_GET["mail_cod"]}";
                    //echo $sql;
                	$rs->FreeSql($sql);
                	$rs->GeraDados();
                	$dis = ($rs->fld("mds_status")==1?"disabled":"");
                ?>
                <div class="box-body">
                    <div class="form-group">
                        <input class="form-control" <?=$dis;?> placeholder="De:" id="mds_sender" name="mds_sender" value="<?=$rs1->pegar("usu_email","usuarios","usu_cod=".$rs->fld("mds_sender"));?>"  readyonly>
                    </div>
                    <div class="form-group">
                        <input class="form-control" <?=$dis;?> placeholder="Para:" id="mds_dest" name="mds_dest" value="<?=$rs->fld("mds_dest");?>"">
                    </div>
                    <div class="form-group">
                        <textarea id="mds_body" class="form-control" style="height: 300px">
                    	   <?=$rs->fld("mds_body");?>
                        </textarea>
                    <input type="hidden" value="" id="mail_acao"/>
                    <input type="hidden" value="<?=$_GET['mail_cod'];?>" id="mail_cod"/>
                  </div>

                  <div id="consulta"></div>
                  </div>
                    
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <div class="pull-right">
                        <?php
                        if($rs->fld("mds_status")<>1){ ?>
	                       <button class="btn btn-default" onmouseover="envia(2);" id="bt_salva_mail"><i class="fa fa-pencil"></i> Salvar Rascunho</button>
	                       <button class="btn btn-primary" onmouseover="envia(0);" id="bt_salva_mail"><i class="fa fa-envelope-o"></i> Enviar</button>
                        <?php }
                    else{?>
                    	   <button class="btn btn-default" disabled=""><i class="fa fa-plane"></i> Essa mensagem foi enviada em <?=$fn1->data_hbr($rs->fld("mds_hora"));?> por <?=$rs1->pegar("usu_nome","usuarios","usu_cod=".$rs->fld("mds_sender"));?></button>
	                <?php }
                    ?>
                  </div>
                  <button class="btn btn-default"><i class="fa fa-times"></i> Cancelar</button>
                </div><!-- /.box-footer -->
              </div><!-- /. box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
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
<script src="<?=$hosted;?>/sistema/js/action_irrf.js"></script>
<script src="<?=$hosted;?>/sistema/js/controle.js"></script>
<script src="<?=$hosted;?>/sistema/js/jquery.cookie.js"></script>
<script src="<?=$hosted;?>/sistema/js/functions.js"></script>
<script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
<!-- iCheck -->
<script src="<?=$hosted;?>/sistema/assets/plugins/iCheck/icheck.min.js"></script>


<!-- SELECT2 TO FORMS
-->

<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
<!-- Validation -->
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script>
	/*------------------------|INICIA TOOLTIPS E POPOVERS|---------------------------------------*/
	$(document).ready(function () {
		$('.mailbox-messages input[type="checkbox"]').iCheck({
      checkboxClass: 'icheckbox_flat-blue',
      radioClass: 'iradio_flat-blue'
    });

    //Enable check and uncheck all functionality
    $(".checkbox-toggle").click(function () {
      var clicks = $(this).data('clicks');
      if (clicks) {
        //Uncheck all checkboxes
        $(".mailbox-messages input[type='checkbox']").iCheck("uncheck");
        $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
      } else {
        //Check all checkboxes
        $(".mailbox-messages input[type='checkbox']").iCheck("check");
        $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
      }
      $(this).data("clicks", !clicks);
    });

		$(".select2").select2({
			tags: true
		});
		setTimeout(function(){
			$("#slc").load("meus_chamados.php");		
			$("#alms").load(location.href+" #almsg");
		 },10000);
	});

	 $(function () {
			// Replace the <textarea id="editor1"> with a CKEditor
			// instance, using default configuration.
			CKEDITOR.replace('mds_body');
		});
	 function envia(acao){
	 	$("#mail_acao").val(acao);
	 }
</script>

</body>
</html>	