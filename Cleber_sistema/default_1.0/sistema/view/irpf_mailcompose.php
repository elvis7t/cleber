<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start();
$sec = "IRRF";
$pag = "irpf_mail.php";
require_once("../config/main.php");
require_once("../config/valida.php");
require_once("../config/mnutop.php");
require_once("../config/menu.php");
require_once("../config/modals.php");
require_once("../class/class.functions.php");

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
				<li class="active">IRPF - E-mails</li>
			</ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
              <?php
              require_once("irpf_mailmenu.php");
              ?>
             <div class="col-md-9">
              <div class="box box-primary">
                <div class="box-header with-border">
					<h3 class="box-title">Nova Mensagem</h3>
                </div><!-- /.box-header -->
                <?php
                	$rs = new recordset();
                	$sql = "SELECT * FROM irpf_mailsender a 
                				WHERE ims_id={$_GET["mail_cod"]}";
                	$rs->FreeSql($sql);
                	$rs->GeraDados();
                	$dis = ($rs->fld("ims_enviado")==1?"disabled":"");
                ?>
                <div class="box-body">
                  <div class="form-group">
                    <input class="form-control" <?=$dis;?> placeholder="De:" id="ims_de" name="ims_de" value="Nilza@triangulocontabil.com.br"  readyonly>
                  </div>
                  <div class="form-group">
                    <input class="form-control" <?=$dis;?> placeholder="Para:" id="ims_dest" name="ims_dest" value="<?=$rs->fld("ims_dest");?>"">
                  </div>
                  <div class="form-group">
                    <textarea id="ims_message" class="form-control" style="height: 300px">
                    	<?=$rs->fld("ims_message");?>
                    </textarea>
                    <input type="hidden" value="" id="mail_acao"/>
                    <input type="hidden" value="<?=$_GET['mail_cod'];?>" id="mail_cod"/>
                  </div>

                  <div class="box box-success no-padding">
                       	<div class="box-header with-border">
                			<h3 class="box-title">Documentos Dispon&iacute;veis:</h3>
                           	<div class="box-tools">
	                    		<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
	                  		</div>
                		</div>

                    <div class="box-body table-responsive mailbox-messages">
                      <table class="table table-hover table-striped">
                        <tbody>
                          <tr>
                            <th>
                              <button class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
                            </th>
                            <th>Nome Arquivo</th>
                            <th>Visualizar</th>
                          </tr>

                          <?php
                          $doc = $rs->fld("ims_clicpf");
                          $rs1 = new recordset();
                          $fn1 = new functions();
                          $sql = "SELECT * FROM documentos WHERE doc_cli_cnpj = '{$doc}'";
                          $rs1->FreeSql($sql);
                          if($rs1->linhas==0){?>
                            <tr><td colspan=2>Nenhum arquivo</td></tr>
                            <?php }
                            else{ 
                            while($rs1->GeraDados()){ 
                            $arq = explode("|",$rs->fld("ims_arquivo"));
                            $chk = (in_array($rs1->fld("doc_ender"), $arq)?"checked":"");
                            ?>
                            <tr>
                              <td><input type="checkbox" <?=$chk;?> id="chk_file[]" name="chk_file[]" value="<?=$rs1->fld("doc_ender");?>"></td>
                              <td><?=substr($rs1->fld("doc_ender"),stripos($rs1->fld("doc_ender"), "files/")+6);?></td>
                              <td><a href="<?=$rs1->fld("doc_ender");?>" class="btn btn-xs btn-primary" target="_blank"><i class="fa fa-book"></i></a></td>
                            </tr>
                          <?php 
                          }	
                          }
                          ?>
                        </tbody>
                      </table>
                    </div>  
                    <div id="consulta"></div>
                  </div>
                    
                </div><!-- /.box-body -->
                <div class="box-footer">
                  <div class="pull-right">
                    <?php
                    if($rs->fld("ims_enviado")<>1){ ?>
	                    <button class="btn btn-default" onmouseover="envia(2);" id="bt_salva_mail"><i class="fa fa-pencil"></i> Salvar Rascunho</button>
	                    <button class="btn btn-primary" onmouseover="envia(0);" id="bt_salva_mail"><i class="fa fa-envelope-o"></i> Enviar</button>
                    <?php }
                    else{?>
                    	<button class="btn btn-default" disabled=""><i class="fa fa-plane"></i> Essa mensagem foi enviada em <?=$fn1->data_hbr($rs->fld("ims_hora"));?> por <?=$rs->fld("ims_user");?></button>
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
<script src="<?=$hosted;?>/js/action_irrf.js"></script>
<script src="<?=$hosted;?>/js/controle.js"></script>
<script src="<?=$hosted;?>/js/jquery.cookie.js"></script>
<script src="<?=$hosted;?>/js/functions.js"></script>
<script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
<!-- iCheck -->
<script src="<?=$hosted;?>/assets/plugins/iCheck/icheck.min.js"></script>


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
			CKEDITOR.replace('ims_message');
		});
	 function envia(acao){
	 	$("#mail_acao").val(acao);
	 }
</script>

</body>
</html>	