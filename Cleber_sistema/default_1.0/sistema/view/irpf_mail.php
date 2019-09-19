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
require_once("../class/class.permissoes.php");

$per = new permissoes();
$rs = new recordset();
$rs2 = new recordset();


$fn = new functions();
$mailst = (isset($_GET['mail_st'])?$_GET['mail_st']:1);
											
?>
 <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<!-- Content Header (Page header) -->
        
	<section class="content-header">
		<h1>
			Envio de E-mail [IRPF]
			<small>13 new messages</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Mailbox</li>
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
										<?php
										$ini = (isset($_GET['ini'])?$_GET['ini']:0);
										$fim = (isset($_GET['fim'])?$_GET['fim']:10);
										$sql = "SELECT * FROM irpf_mailsender a
													JOIN empresas b ON b.emp_cnpj = a.ims_clicpf
												WHERE ims_enviado={$mailst}";
										$rs->FreeSql($sql);
										$linhas = $rs->linhas;
										$sql.= " ORDER BY ims_hora DESC";
										$sql.= " LIMIT ". $ini .",10";
										$rs->FreeSql($sql);
										//echo $sql;

										echo $ini."-".$fim."/".$linhas;
										$antini = "";
										$antfim = "";
										$proini = $ini+10;
										$profim = $fim+10;
										if($fim>=20){
											$antini = $ini-10;
											$antfim = $fim-10;
											$complem = "&ini=$antini&fim=$antfim";
										}
										else{$complem="";}
										?>
										<div class="btn-group">
											<a href="irpf_mail.php?token=<?=$_SESSION['token'];?>&mail_st=<?=$mailst.$complem;?>" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></a>
											<a href="irpf_mail.php?token=<?=$_SESSION['token'];?>&mail_st=<?=$mailst;?>&ini=<?=$proini;?>&fim=<?=$profim;?>" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></a>
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
												<th>Anexo</th>
												<th>Enviado em</th>
											</tr>
											<?php
											
											if($rs->linhas==0){?>
											<tr>
												<td>Nenhuma mensagem enviada!</td>
												
											</tr>
											<?php }
											else{
											while($rs->GeraDados()){?>
											<tr>
												<td><input type="checkbox"></td>
												<td class="mailbox-star"><a href="#"><i class="fa fa-star text-yellow"></i></a></td>
												<td class="mailbox-name"><strong><a href="irpf_mailcompose.php?token=<?=$_SESSION['token'];?>&mail_cod=<?=$rs->fld("ims_id");?>"><?=$rs->fld("emp_razao");?></a></strong></td>
												<td class="mailbox-subject"><?=$rs->fld("ims_assunto");?></td>
												<td class="mailbox-attachment"><i class="fa fa-paperclip"></td>
												<td class="mailbox-date"><?=($rs->fld("ims_enviado")==1?"Há ".$fn->calc_dh($rs->fld("ims_hora")):"Não enviado");?></td>
											</tr>
											<?php 
											}
											}
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
                      <?=$ini."-".$fim."/".$linhas;?>
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
    <script src="<?=$hosted;?>/js/controle.js"></script>
    <script src="<?=$hosted;?>/js/action_empresas.js"></script>
    <script src="<?=$hosted;?>/js/action_irrf.js"></script>
    <script src="<?=$hosted;?>/js/functions.js"></script>
	<!-- SELECT2 TO FORMS
	-->
	<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
	<!-- Validation -->
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
	<script src="<?=$hosted;?>/js/jquery.cookie.js"></script>
	<script src="<?=$hosted;?>/assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
	<script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
	<!-- iCheck -->
    <script src="<?=$hosted;?>/assets/plugins/iCheck/icheck.min.js"></script>

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
