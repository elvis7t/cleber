<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start();
$sec = "Mens";
$pag = "view_docsmail.php";
require_once("../config/main.php");
require_once("../config/valida.php");
require_once("../config/mnutop.php");
require_once("../config/menu.php");
require_once("../config/modals.php");
require_once("../../sistema/class/class.functions.php");
require_once("../class/class.permissoes.php");

$per = new permissoes();
$rs = new recordset();
$rs2 = new recordset();


$fn = new functions();											
?>
 <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<!-- Content Header (Page header) -->
        
	<section class="content-header">
		<h1>
			Envio de E-mail
			<small>Solicitar Documentos</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#"><i class="fa fa-suitcase"></i> Documentos</a></li>
			<li class="active">Mailbox</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<?php
			require_once("view_docsmailmenu.php");
			$sql = "SELECT * FROM maildocumento WHERE 1";
			if(isset($_GET['st'])){
				$sql.=" AND mds_status = ".$_GET['st'];
			}

			if(isset($_GET['comp'])){
				$sql .= " AND mds_comp='".$_GET['comp']."'";
			}

			$rs->FreeSql($sql);
			?>
            	
            	<div class="col-md-9">
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">Enviadas</h3>
							<div class="box-tools pull-right">
                				<div class="has-feedback">
                  					<input type="text" class="form-control input-sm" placeholder="Search Mail">
                  					<span class="glyphicon glyphicon-search form-control-feedback"></span>
                				</div>
							</div><!-- /.box-tools -->
						</div><!-- /.box-header -->
							<div class="box-body no-padding">
								<div class="mailbox-controls">
								<!-- Check all button -->
									<button class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
									<div class="btn-group">
										<button class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
										<button class="btn btn-default btn-sm"><i class="fa fa-reply"></i></button>
										<button class="btn btn-default btn-sm"><i class="fa fa-share"></i></button>
									</div><!-- /.btn-group -->
									<button class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
									<div class="pull-right">
										<div class="btn-group">
											<a href="#" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></a>
											<a href="#" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></a>
										</div><!-- /.btn-group -->
									</div><!-- /.pull-right -->
								</div>
								<div class="table-responsive mailbox-messages">
									<table class="table table-hover table-striped">
										<tbody>
											<tr>
												<th></th>
												<th></th>
												<th>Destinat&aacute;rio</th>
												<th>Assunto</th>
												<th>Remetente</th>
												<th>Enviado em</th>
											</tr>

											<?php if($rs->linhas==0): ?>

											<?php else: 
												while($rs->GeraDados()): ?>
													<tr>
														<td><input type="checkbox"></td>
														<td class="mailbox-star"><a href="#"><i class="fa fa-star text-yellow"></i></a></td>
														<td class="mailbox-name"><strong><a href="docsmail_compose.php?token=<?=$_SESSION['token'];?>&mail_cod=<?=$rs->fld("mds_id");?>"><?=(strlen($rs->fld("mds_dest"))>30?substr($rs->fld("mds_dest"),0,30)."...":$rs->fld("mds_dest"));?></a></strong></td>
														<td class="mailbox-subject"><?=substr($rs->fld("mds_subj"),0,20);?>...</td>
														<td class="mailbox-name"><?=$rs2->pegar("usu_nome","usuarios","usu_cod=".$rs->fld("mds_sender"));?></td>
														<td class="mailbox-date"><?=$fn->data_hbr($rs->fld("mds_hora"));?></td>
													</tr>
												<?php endwhile;
											endif;
											?>
										</tbody>
									</table><!-- /.table -->
								</div><!-- /.mail-box-messages -->
							</div><!-- /.box-body -->
                <div class="box-footer no-padding">
                  <div class="mailbox-controls">
                    <!-- Check all button -->
                    <button class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
                    <div class="btn-group">
                      <button class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
                      <button class="btn btn-default btn-sm"><i class="fa fa-reply"></i></button>
                      <button class="btn btn-default btn-sm"><i class="fa fa-share"></i></button>
                    </div><!-- /.btn-group -->
                    <button class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
                    <div class="pull-right">
                      
                      <div class="btn-group">
                        <a href="irpf_mail.php?token=<?=$_SESSION['token'];?>&mail_st=<?=$mailst.$complem;?>" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></a>
						<a href="irpf_mail.php?token=<?=$_SESSION['token'];?>&mail_st=<?=$mailst;?>&ini=<?=$proini;?>&fim=<?=$profim;?>" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></a>
                      </div><!-- /.btn-group -->
                    </div><!-- /.pull-right -->
                  </div>
                </div>
              </div><!-- /. box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

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
    <script src="<?=$hosted;?>/triangulo/js/controle.js"></script>
    <script src="<?=$hosted;?>/triangulo/js/action_empresas.js"></script>
    <script src="<?=$hosted;?>/triangulo/js/action_irrf.js"></script>
    <script src="<?=$hosted;?>/triangulo/js/functions.js"></script>
	<!-- SELECT2 TO FORMS
	-->
	<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
	<!-- Validation -->
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
	<script src="<?=$hosted;?>/triangulo/js/jquery.cookie.js"></script>
	<script src="<?=$hosted;?>/sistema/assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
	<script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
	<!-- iCheck -->
    <script src="<?=$hosted;?>/sistema/assets/plugins/iCheck/icheck.min.js"></script>

	<script type="text/javascript">
		$(function () {
        //Enable iCheck plugin for checkboxes
        //iCheck for checkbox and radio inputs
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

        //Handle starring for glyphicon and font awesome
        $(".mailbox-star").click(function (e) {
          e.preventDefault();
          //detect type
          var $this = $(this).find("a > i");
          var glyph = $this.hasClass("glyphicon");
          var fa = $this.hasClass("fa");

          //Switch states
          if (glyph) {
            $this.toggleClass("glyphicon-star");
            $this.toggleClass("glyphicon-star-empty");
          }

          if (fa) {
            $this.toggleClass("fa-star");
            $this.toggleClass("fa-star-o");
          }
        });
		// Replace the <textarea id="editor1"> with a CKEditor
		// instance, using default configuration.
		CKEDITOR.replace('emp_obs');
      });

		setInterval(function(){

			$("#chatContent").load(location.href+" #msgs");	
			$("#chatContent").scrollTop($("#msgs").height());
			
			
			if($.cookie('msg_lido')==0) {
				notify($.cookie("user"), $.cookie("mensagem"),$.cookie("pag"));
				$.cookie("msgant");
				$.cookie('msg_lido',1);
			}
		},3500);

	$(".select2").select2({
		tags: true
	});
	 

	</script>

</body>
</html>	
