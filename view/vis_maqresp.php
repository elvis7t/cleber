<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start();
$sec = "CHAMA";
$pag = "vis_verificacaoP.php";
require_once("../config/main.php");
require_once("../config/valida.php");
require_once("../config/mnutop.php");
require_once("../config/menu.php");
require_once("../../sistema/config/modals.php");
require_once("../../sistema/class/class.functions.php");

$rs = new recordset();
$rs2 = new recordset();
$sql = "SELECT * FROM listados WHERE lver_id = ".$_GET['ver'];
?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<!-- Content Header (Page header) -->
        <section class="content-header">
			<h1>
				Item de checkList
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li>Solicita&ccedil;&atilde;o</li>
				<li>CheckList</li>
				<li class="active">Items</li>
			</ol>
        </section>

        <!-- Main content -->
        <section class="content">
			<?php
				$rs2->FreeSql($sql);
				$rs2->GeraDados();
				$json = $rs2->fld("lver_respostas");
				$data = json_decode($json,true);
				$maqId = $rs2->fld("lver_maquina");
				$obser = $rs2->fld("lver_obs");
				if(isset($_SESSION['classe'])){$classe = $_SESSION['classe'];}
				else{$classe=0;}
			?>
			 <div class="row">
				<div class="col-md-12">
				<!-- general form elements -->
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">Novo Item de CheckList</h3>
						</div><!-- /.box-header -->
						<!-- form start -->
						<form role="form" id="cad_cham">
							<input type="hidden" id="emp_altera" value=0 />
							<div class="box-body">
								<!-- radio Clientes -->
								<div id="clientes" class="row">

									<div class="form-group col-md-6">
										<label for="sel_emp">Empresa:</label><br>
										<input type="text" class="form-control" DISABLED  value="<?=$rs2->pegar("empresa","tri_clientes","cod = ".$_GET['emp']);?>" id="check_em" name="check_emp"/>
									</div>
									<div class="form-group col-md-5">
										<label for="sel_emp">Maquina:</label><br>
										<select class="select2" DISABLED style="width:100%" name="sel_maq" id="sel_maq">
											<?php
											
											$whr = " AND maq_id = ".$maqId;
											$sql = "SELECT maq_id, maq_ip, maq_user, b.usu_nome, maq_tipo, c.dep_nome FROM maquinas a
														LEFT JOIN usuarios b ON a.maq_user = b.usu_cod
														LEFT JOIN departamentos c ON b.usu_dep = c.dep_id
													WHERE maq_tipo <>'Impressora'";
											$sql.=$whr;
											$sql.=" ORDER BY usu_dep ASC, usu_nome ASC";
											$dp = "";
											$rs->FreeSql($sql); 
											
											while($rs->GeraDados()){
												if($rs->fld("dep_nome")!=$dp){
													$dp = $rs->fld("dep_nome");
													echo "<optgroup label = '".$dp."''>";
												}
												$disable = ((in_array($rs->fld("maq_id"), $impos) && ($rs->linhas>2))?"DISABLED":"");
												echo "<option {$disable} value=".$rs->fld("maq_id").">".$rs->fld("maq_ip")." [".$rs->fld("maq_tipo")." - ".$rs->fld("usu_nome")."]"."</option>";
											}								
											?>
										</select>
										
									</div>
									<div class="form-group col-md-1 pull-right">
										<label for="sel_emp">Lista:</label><br>
										<input type="text" class="form-control" DISABLED value="<?=$_GET['lista'];?>" id="check_id" name="check_id"/>
									</div>
								</div>
								<div class="row">	
									<?php
										$p = -1;
										$sql = "SELECT * FROM tarefas WHERE task_tipo = 'VER'";
										$rs->FreeSql($sql);
										while($rs->GeraDados()):
											$p++;
										?>	
											<div class="form-group col-md-3">
												<label for="item_<?=$rs->fld("task_id")?>"><?=$rs->fld("task_desc")?>:</label>
												<?php
												
												if($rs->fld("task_campo")=="VAL"){ ?>
													<input title="Campo Obrigatório" DISABLED reqired type="text" class="form-control quest" name="<?=$rs->fld("task_id")?>" id="<?=$rs->fld("task_id")?>" value="<?=$data[$p][$rs->fld("task_id")];?>"/>
												<?php
												}
												else{?>
													<select title="Campo Obrigatório" DISABLED required class="select2 quest" name="<?=$rs->fld("task_id");?>" id="<?=$rs->fld("task_id");?>" style="width:100%;">
														<option <?=($data[$p][$rs->fld("task_id")]==''?'SELECTED':'');?> value="">Selecione:</option>
														<option <?=($data[$p][$rs->fld("task_id")]=='OK'?'SELECTED':'');?> value="OK">Conforme</option>
														<option <?=($data[$p][$rs->fld("task_id")]=='NOK'?'SELECTED':'');?> value="NOK">Não Conforme</option>
												</select>
												<?php 
											} ?>	
											</div>
										<?php
										endwhile;	
										?>
								</div>
								<div class="row">
									<div class="form-group col-md-12 pull-right">
										<label for="sel_emp">Observa&ccedil;&otilde;es:</label><br>
										<textarea class="form-control" DISABLED id="check_obs" name="check_obs">
											<?=$obser;?>
										</textarea>
										<input type="hidden" value="" id="quest" name="quest"/>
										<input type="hidden" value="" id="resps" name="resps"/>
									</div>
								</div>

								<div id="consulta"></div>
								<div id="formerros1" class="clearfix" style="display:none;">
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
								<a class="btn btn-sm btn-danger" href="javascript:history.go(-1);"><i class="fa fa-hand-o-left"></i> Voltar</a>
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
<script src="<?=$hosted;?>/triangulo/js/action_chamados.js"></script>
<script src="<?=$hosted;?>/triangulo/js/controle.js"></script>
<script src="<?=$hosted;?>/triangulo/js/jquery.cookie.js"></script>
<script src="<?=$hosted;?>/triangulo/js/functions.js"></script>
<script src="https://cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script>

<script src="<?=$hosted;?>/sistema/assets/plugins/input-mask/jquery.inputmask.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/input-mask/jquery.inputmask.extensions.js"></script>



<!-- SELECT2 TO FORMS
-->

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

		setTimeout(function(){
			//$("#slc").load("meus_chamados.php");		
			$("#alms").load(location.href+" #almsg");
		 },10000);


	});
	$(function(){
		// Replace the <textarea id="editor1"> with a CKEditor
		// instance, using default configuration.
		CKEDITOR.replace( 'check_obs', {
		    filebrowserUploadUrl: "upload.php" 
		});

		$(document.body).on("click","#bt_add_check",function(){
			var quest = [];
			var resps = [];
			$(".quest").each(function(){
				resps.push(quest[$(this).attr("id")] = $(this).val());
			});


			$("#quest").val(JSON.parse(JSON.stringify(resps)));
			console.log(JSON.parse(JSON.stringify(resps)));
			
			$.post("../controller/TRIEmpresas.php",{
					acao: "add_checkitem",
					quest: 	$("#quest").val(),
					resps: 	$("#resps").val(),
					lista: 	$("#check_id").val(),
					maquina: $("#sel_maq").val(),
					obs: 	CKEDITOR.instances.check_obs.getData()
				},
				function(data){
					if(data.status=="OK"){
						$("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> '+data.mensagem+' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
						
							javascript:history.go(-1);
						
					} else{
						$("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-times"></i> Ocorreu um erro! ('+data.mensagem+')<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
					}
	                console.log(data.sql);//TO DO mensagem OK
				},
				"json"
			);
			
		});
	});


</script>

</body>
</html>	