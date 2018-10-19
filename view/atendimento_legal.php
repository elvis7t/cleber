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
require_once("../class/class.functions.php");

extract($_GET);

?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<!-- Content Header (Page header) -->
        <section class="content-header">
			<h1>
				Chamados - Legaliza&ccedil;&atilde;o
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li>Solicita&ccedil;&atilde;o</li>
				<li>Chamados Legal</li>
				<li class="active">Atendimento</li>
			</ol>
        </section>

        <!-- Main content -->
        <section class="content">
        <div class="row">
					<div class="col-md-12">
						<div class="box box-success" id="firms">
							<div class="box-header with-border">
								<h3 class="box-title">Tr&acirc;mites deste Chamado</h3>
							</div><!-- /.box-header -->
							<div class="box-body">
								 
								<?php require_once("chamleg_Ocorr.php"); ?>
								
							</div>
						</div><!-- ./box -->
					</div><!-- ./col -->
				</div>
			<?php
 				extract($_GET);
 				$rs2 = new recordset();
 				$rs3 = new recordset();
				$fn = new functions();
 				$sql = "SELECT a.*, c.st_desc, d.cod, d.apelido, e.usu_nome, a.cleg_tratfim FROM chamados_legal a 
 							JOIN codstatus c ON a.cleg_status =c.st_codstatus
 							JOIN tri_clientes d ON a.cleg_empresa = d.cod
 							LEFT JOIN usuarios e ON a.cleg_trat = e.usu_cod 
 						WHERE cleg_id = ".$chamado;
 				//echo $sql;
 				$rs->FreeSql($sql);
 				$rs->GeraDados();
 				$perc = $rs->fld("cleg_percent");
 				if($rs->fld('cleg_trat')==0 && $acao==1){
 					$data = date("Y-m-d H:i:s");
 					$d = array("cleg_trat" => $_SESSION['usu_cod'], "cleg_tratini"=>$data, "cleg_status"=>92);
 					$w = "cleg_id = ".$chamado;
 					$rs2->Altera($d, "chamados_legal",$w);
 					header("Refresh:0");
 				}
			?>

			 <div class="row">
				<div class="col-md-12">
				<!-- general form elements -->
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">Feedback de Servi&ccedil;o</h3><div class="box-tools pull-right">
		                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		                  </div>
						</div><!-- /.box-header -->
						<!-- form start -->
						<form role="form" id="cad_atendlegal">
							
							<div class="box-body">
								<!-- radio Clientes -->
								<div id="clientes" class="row">
									<div class="form-group col-md-1">
										<label for="cleg_id">#ID:</label>
										<input type="text" DISABLED class="form-control" name="cleg_id" id="cleg_id" value="<?=$rs->fld("cleg_id");?>"/>
									</div>
									<div class="form-group col-md-2">
										<label for="cleg_sla">Atendimento</small>:</label>
										<input type="text" DISABLED class="form-control" name="cleg_sla" id="cleg_sla" value="<?=$fn->calc_dh($rs->fld("cleg_abert"), $rs->fld("cleg_tratini"));?>"/>
									</div>
									<div class="form-group col-md-2">
										<label for="cleg_slaII">SLA <small>(Tempo de solução)</small>:</label>
										<input type="text" DISABLED class="form-control" name="cleg_slaII" id="cleg_slaII" value="<?=($rs->fld("cleg_tratfim")==0?"-":$fn->calc_dh($rs->fld("cleg_tratini"), $rs->fld("cleg_tratfim")));?>"/>
									</div>

									<div class="form-group col-md-2">
										<label for="cleg_status">Status:</label>
										<input type="text" DISABLED class="form-control" name="cleg_status" id="cleg_status" value="<?=$rs->fld("st_desc");?>"/>
									</div>
								
									<div class="form-group col-md-3">
										<label for="cleg_slaII">Contato:</label>
										<input type="text" DISABLED class="form-control" name="cleg_contato" id="cleg_contato" value="<?=($rs->fld('cleg_contato')==''?'':$rs->fld('cleg_contato'));?> "/>
									</div>

									<div class="form-group col-md-2">
										<label for="cleg_slaII">Via:</label>
										<input type="text" DISABLED class="form-control" name="cleg_via" id="cleg_via" value="<?=($rs->fld('cleg_via')==''?'':$rs->fld('cleg_via'));?> "/>
									</div> 
								</div>

								<div class="row">

									<div class="form-group col-md-4">
										<label for="cleg_slaII">Cliente:</label>
										<input type="text" DISABLED class="form-control" name="cleg_via" id="cleg_via" value="<?=$rs->fld('cod')." - ".$rs->fld('apelido');?>"/>
									</div> 

									<div class="form-group col-md-2">
										<label for="emp_cnpj">Prazo:</label>
										<input type="text" DISABLED class="form-control" name="cleg_prazo" id="cleg_prazo" value="<?=$fn->data_br($rs->fld("cleg_datafim"));?>"/>
									</div>
									<div class="col-sm-6">
										<label for="emp_cnpj">Concluído:</label>
                      					<?php
										$num_check = 0;
										$num_ativos = 0;
                      					//Checar subtarefas
                      					$sql = "SELECT * FROM chamlegal_checklist 								
											WHERE clegchk_clegId = (SELECT cleg_subtar FROM chamados_legal WHERE cleg_id=".$chamado.")";
										$rs3->FreeSql($sql);
										$num_check += $rs3->linhas;
                      					$sql.=" AND clegchk_ativo =1";
										$rs3->FreeSql($sql);
										$num_ativos += $rs3->linhas;
										//echo $sql;

                      					//Checar tarefas principais
										$sql="SELECT * FROM chamlegal_checklist a
												JOIN checklists b 	ON a.clegchk_item = b.chk_id 
												LEFT JOIN usuarios d ON d.usu_cod = a.clegchk_seppor
											WHERE clegchk_clegId = ".$chamado;
										$sq1.=" ORDER BY b.chk_ordem ASC, clegchk_item ASC ";
										$rs3->FreeSql($sql.$sq1);
										
										$num_check += $rs3->linhas;
										$sql.=" AND clegchk_ativo =1";
										//echo $rs3->sql;
										
										$rs2->FreeSql($sql);
										$num_ativos += $rs2->linhas;
										$total = ($num_ativos/$num_check)*100;
										
										//echo $num_ativos;
										$percent = number_format($total, 2);
										//$status = $rs->fld("impla_status");
										?>
                      					<div id="pgb_chamlegal" class="progress progress-md">
											<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="13" aria-valuemin="0" aria-valuemax="100">
												<span class=""><?=$percent;?>%</span>
											</div>
										</div>
										<input type="hidden" id="cleg_percent" value="<?=$percent;?>"/>
										<input type="hidden" id="token" value="<?=$_SESSION['token'];?>"/>
										<input type="hidden" id="cnpj" value="<?=$_SESSION['cnpj_emp'];?>"/>
                    				</div>					
									
								</div>

								<label>CheckList:</label>
									<table class="table table-striped table-condensed">

										<thead>
											<tr>
												<th>#</th>
												<th>Documento:</th>
												<th>Gerado?</th>
												<th>Gerado Por:</th>
												<th>Data Confer&ecirc;ncia:</th>
												<th>A&ccedil;&otilde;es:</th>
											</tr>
										</thead>
										<tbody id="tchecklist">
											<?php

												while($rs3->GeraDados()){ 
													?>
													<tr>
														<td><?=$rs3->fld("clegchk_id");?></td>
														<td><?=$rs3->fld("chk_item");?></td>
														<td>	
														
															<input 
																type='checkbox' 
																class='checkdocimpla'
																value=1
																id='clegchk'<?=$rs3->fld("clegchk_id");?>
																onchange="mark_conf(<?=$rs3->fld("clegchk_clegId");?>,
																					 this.checked,
																					 'cleg',<?=$rs3->fld("clegchk_item");?>,
																					 'clegchk<?=$rs3->fld("clegchk_id");?>',
																					 <?=$rs3->fld("cleg_empresa");?>);"

																<?=($rs3->fld("clegchk_ativo")==1?'CHECKED':'');?>  
																data-onstyle='success'
																data-on="Sim"
																data-off="Não"
																data-size='mini' 
																data-toggle='toggle'
																>
														
														</td>
														<td><?=$rs3->fld("usu_nome")?></td>
														<td><?=($rs3->fld("clegchk_dtsep")<>0?$fn->data_hbr($rs3->fld("clegchk_dtsep")):"-");?></td>
														<td>
															<?php
															 if($rs3->fld("impchk_ativo")==0){?>
															 	<button type="button"
																	class="btn btn-xs btn-danger"
																	data-toggle='tooltip' 
																	data-placement='bottom'
																	onclick="javascript:del(<?=$rs3->fld("clegchk_id");?>,'excDocCham','o item do Checklist');"
																	title='Excluir Item do Checklist' target="_blank"><i class="fa fa-trash"></i>
																</button>
															 <?php }
															?>
														</td>
													</tr>
												<?php }
												?>
										</tbody>
									</table>
								<div class="row">
									<div class="form-group col-md-12">
										<label for="cleg_obs">Observa&ccedil;&atilde;o:</label>
										<textarea class="form-control" name="cleg_obs" id="cleg_obs"></textarea>
									</div>
									<div class="form-group col-md-4">
										<label for="score">Avaliação</small>:</label>
										<input id="score" DISABLED name="score" class="rating rating-loading xs" value="<?=$rs->fld("cleg_aval");?>" data-min="0" data-max="5" data-step="0.5" data-size="xs">
									</div>

								</div>

								<div id="consulta"></div>
								<div id="formerros_chamlegal" class="clearfix" style="display:none;">
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
									if($rs->fld('cleg_status')==0):	?>
									<a 	href="atendimento_legal.php?token=<?=$_SESSION['token'];?>&chamado=<?=$rs->fld('cleg_id');?>&acao=1"
										class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Atender</a>
									<?php
									
									else: ?>
										<button class="btn btn-sm btn-info <?=($rs->fld("cleg_status")==99 ? "hide" :"");?>" type="button" id="bt_save_cleg"><i class="fa fa-save"></i> Salvar</button>
									<?php
									endif;

									if($rs->fld("cleg_status")==99): ?>
										<div class="alert alert-success">Tarefa finalizada por <?=$rs->fld("usu_nome");?> em <?=$fn->data_hbr($rs->fld("cleg_tratfim"));?></div> 
									<?php
									else:
									
										if($rs->fld("cleg_subtar")<>0):?>
											<a href="atendimento_legal.php?token=<?=$_SESSION['token'];?>&chamado=<?=$rs->fld("cleg_subtar");?>&acao=0" class="btn btn-sm btn-warning"><i class="fa fa-eye"></i> Ver SubTarefa</a>

										<?php 
										else: 
											if(!$rs->fld("cleg_status")<>99):?>
												<a href="chamados_legal.php?token=<?=$_SESSION['token'];?>&chamado=<?=$_GET['chamado'];?>" class="btn btn-sm btn-primary"><i class="fa fa-tasks"></i> Criar SubTarefa</a>
										<?php
											endif;
										endif;
										?>
										
										<a href="chamados_legal.php?token=<?=$_SESSION['token'];?>&chamado=<?=$_GET['chamado'];?>&acao=alterar" class="btn btn-sm btn-warning pull-right <?=($rs->fld("cleg_percent")==100 ? "hide" :"");?>" type="button" id="altera_leg"><i class="fa fa-edit"></i> Alterar</a>

										<button class="btn btn-sm btn-success pull-right <?=($rs->fld("cleg_status")==102 ? "" :"hide");?>" type="button" id="bt_encerra_cleg"><i class="fa fa-exclamation"></i> Encerrar</button>
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


<script type="text/javascript" src="<?=$hosted;?>/sistema/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script type="text/javascript" src="<?=$hosted;?>/sistema/assets/bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script type="text/javascript" src="<?=$hosted;?>/sistema/assets/plugins/fastclick/fastclick.min.js"></script>
<!-- AdminLTE App -->
<script type="text/javascript" src="<?=$hosted;?>/sistema/assets/dist/js/app.min.js"></script>
<!-- Slimscroll -->
<script type="text/javascript" src="<?=$hosted;?>/sistema/assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script type="text/javascript" src="<?=$hosted;?>/sistema/assets/js/maskinput.js"></script>
<script type="text/javascript" src="<?=$hosted;?>/sistema/assets/js/jmask.js"></script>
<script type="text/javascript" src="<?=$hosted;?>/sistema/assets/bootstrap/js/star-rating.js"></script>
<script type="text/javascript" src="<?=$hosted;?>/sistema/js/action_chamlegal.js"></script>
<script type="text/javascript" src="<?=$hosted;?>/sistema/js/controle.js"></script>
<script type="text/javascript" src="<?=$hosted;?>/sistema/js/jquery.cookie.js"></script>
<script type="text/javascript" src="<?=$hosted;?>/sistema/js/functions.js"></script>
<script type="text/javascript" src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
<!-- Ion Slider -->
<script type="text/javascript" src="<?=$hosted;?>/sistema/assets/plugins/ionslider/ion.rangeSlider.min.js"></script>
<!-- Bootstrap slider -->
<script type="text/javascript" src="<?=$hosted;?>/sistema/assets/plugins/bootstrap-slider/bootstrap-slider.js"></script>


<!-- SELECT2 TO FORMS
-->

<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
<!-- Validation -->
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script src="<?=$hosted;?>/sistema/assets/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>

<script type="text/javascript">
	/*------------------------|INICIA TOOLTIPS E POPOVERS|---------------------------------------*/
	$(document).ready(function () {
		$(".select2").select2({
			tags: true
		});

		setTimeout(function(){
			//$("#slc").load("cham_Ocorr.php");		
			$("#alms").load(location.href+" #almsg");
		},10000);

	});

	$("#pgb_chamlegal .progress-bar").animate({width: "<?=$percent;?>%"},1000);
	
	$(function () {
		// Replace the <textarea id="editor1"> with a CKEditor
		// instance, using default configuration.
		CKEDITOR.replace( 'cleg_obs', {
		    filebrowserUploadUrl: "upload.php" 
		});

		/*
		var ionstatus = <?=$perc;?>;
        $("#cleg_percent").ionRangeSlider({
          min: 0,
          max: 100,
          type: 'single',
          step: 1,
          postfix: " %",
          prettify: false,
          hasGrid: true,
          from: ionstatus
        });
         */
	});

	function mark_conf(cleg, check, acao, id, emp){
		act = ( check == true ? "conf_"+acao : "desconf_"+acao);
		alb = ( check == true ? "Conferir" : "Desmarcar");
		ati = ( check == true ? 1 : 0);
        $.post("../controller/TRIChamadosLegal.php",
	        {
	            acao:    act,
	            chamado: cleg,
	            doc: 	 id,
	            ativo:   ati,
	            empresa: emp
	        },
	        function(data){
	            alert(data.mensagem);
        		location.reload();
	        },
	        "json"
        );
    
    }


	
</script>

</body>
</html>	