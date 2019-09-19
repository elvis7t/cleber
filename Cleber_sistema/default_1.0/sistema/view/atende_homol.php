<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start();
$sec = "Mens";
$pag = "dp_homologa.php";
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
				Homologa&ccedil;&otilde;es <small>Departamento Pessoal</small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li>Solicita&ccedil;&atilde;o</li>
				<li>Homologa&ccedil;&otilde;es</li>
				<li class="active">Atendimento</li>
			</ol>
        </section>

        <!-- Main content -->
        <section class="content">
        <div class="row">
					<div class="col-md-12">
						<div class="box box-success" id="firms">
							<div class="box-header with-border">
								<h3 class="box-title">Tr&acirc;mites desta homologa&ccedil;&atilde;o</h3>
							</div><!-- /.box-header -->
							<div class="box-body">
								 
								<?php require_once("hom_Ocorr.php"); ?>
								
							</div>
						</div><!-- ./box -->
					</div><!-- ./col -->
				</div>
			<?php
 				extract($_GET);
 				$rs2 = new recordset();
				$fn = new functions();
 				$sql = "SELECT * FROM homologacoes a 
 							LEFT JOIN tri_clientes e ON e.cod = a.hom_empresa 
 						WHERE hom_id = ".$homol;
 				$rs->FreeSql($sql);
 				$rs->GeraDados();
 				/*
 				if($acao==1){
 					$data = date("Y-m-d H:i:s");
 					$d = array("hom_realpor" => $_SESSION['usu_cod'], "hom_realdata"=>$data, "hom_status"=>92);
 					$w = "hom_id = ".$homol;
 					$rs2->Altera($d, "homologacoes",$w);
 				}
 				*/
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
						<form role="form" id="cad_atendhom">
							
							<div class="box-body">
								<!-- radio Clientes -->

								<div id="clientes" class="row">
									<div class="form-group col-md-1">
										<label for="emp_cnpj">#ID:</label>
										<input type="text" DISABLED class="form-control" name="hom_id" id="hom_id" value="<?=$rs->fld("hom_id");?>"/>
										<input type="hidden" name="token" id="token" value="<?=$_SESSION['token'];?>"/>
										<input type="hidden" name="token" id="cnpj" value="<?=$_SESSION['usu_empresa'];?>"/>
									</div>
									<div class="form-group col-md-2">
										<label for="emp_cnpj">Data:</label>
										<input type="text" DISABLED class="form-control" name="hom_task" id="hom_task" value="<?=$fn->data_br($rs->fld("hom_datahom"));?>"/>
									</div>
									
									<div class="form-group col-md-2">
										<label for="emp_cnpj">Hora:</label>
										<input type="text" DISABLED class="form-control" name="hom_slaII" id="hom_slaII" value="<?=$rs->fld("hom_horario");?>"/>
									</div>
                    				<div class="form-group col-md-7">
										<label for="emp_cnpj">Empresa:</label>
										<input type="text" DISABLED class="form-control" value="<?=$rs->fld("empresa");?>"/>
									</div>
								</div>
								<div class="row">
								
									<div class="form-group col-md-5">
										<label for="emp_cnpj">Nome do Homologado:</label>
										<input type="text" DISABLED class="form-control" name="hom_task" id="hom_task" value="<?=$rs->fld("hom_empregado");?>"/>
									</div>
									
									<div class="form-group col-md-3">
										<label for="emp_cnpj">SLA <small>(de solução)</small>:</label>
										<input type="text" DISABLED class="form-control" name="hom_slaII" id="hom_slaII" value="<?=($rs->fld("hom_realdata")==0?"-":$fn->calc_dh($rs->fld("hom_data"), $rs->fld("hom_realdata")));?>"/>
									</div>
									<div class="col-sm-4">
										<label for="emp_cnpj">Concluído:</label>
                      					<?php
										$sql="SELECT * FROM homologa_check a
												JOIN checklists b ON a.homchk_item = b.chk_id 
												JOIN homologacoes c ON c.hom_id = a.homchk_homId
												LEFT JOIN usuarios d ON d.usu_cod = a.homchk_seppor
											WHERE hom_id = ".$homol;
										$rs->FreeSql($sql);
										//echo $rs->sql;
										$rs2=new recordset();
										$num_check = $rs->linhas;
										$sql.=" AND homchk_ativo =1";
										$rs2->FreeSql($sql);
										$num_ativos = $rs2->linhas;
										$total = ($num_ativos/$num_check)*100;
										$percent = number_format($total, 2);
										$status = $rs->fld("hom_status");
										?>
                      					<div id="pgb_homol" class="progress progress-md">
											<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="13" aria-valuemin="0" aria-valuemax="100">
												<span class=""><?=$percent;?>%</span>
											</div>
										</div>
                    				</div>
                    			</div>
                    			
									<label>CheckList:</label>
									<table class="table table-striped table-condensed">

										<thead>
											<tr>
												<th>Documento:</th>
												<th>Conferido?</th>
												<th>Conferido Por:</th>
												<th>Data Confer&ecirc;ncia:</th>
												<th>A&ccedil;&otilde;es:</th>
											</tr>
										</thead>
										<tbody id="tchecklist">
											<?php

												while($rs->GeraDados()){ 
													?>
													<tr>
														<td><?=$rs->fld("chk_item");?></td>
														<td>	
														
															<input 
																type='checkbox' 
																class='checkdochomol'
																value=1
																id='homchk'<?=$rs->fld("homchk_id");?>
																onchange="mark_conf(<?=$rs->fld("homchk_homId");?>, this.checked, 'doc',<?=$rs->fld("homchk_id");?>, 'homchk<?=$rs->fld("homchk_id");?>',<?=$rs->fld("hom_empresa");?>);" 
																<?=($rs->fld("homchk_ativo")==1?'CHECKED':'');?>  
																data-onstyle='success'
																data-on="Sim"
																data-off="Não"
																data-size='mini' 
																data-toggle='toggle'
																>
														
														</td>
														<td><?=$rs->fld("usu_nome")?></td>
														<td><?=($rs->fld("homchk_dtsep")<>0?$fn->data_hbr($rs->fld("homchk_dtsep")):"-");?></td>
														<td>
															<?php
															 if($rs->fld("homchk_ativo")==0){?>
															 	<button type="button"
																	class="btn btn-xs btn-danger"
																	data-toggle='tooltip' 
																	data-placement='bottom'
																	onclick="javascript:del(<?=$rs->fld("homchk_id");?>,'excDocHom','o item de homologação');"
																	title='Excluir documento' target="_blank"><i class="fa fa-trash"></i>
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

								</div>
								<div class="row">
									<div class="form-group col-md-12">
										<label for="emp_cnpj">Observa&ccedil;&atilde;o:</label>
										<textarea class="form-control" name="hom_obs" id="editor1"></textarea>
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
								<button <?=($status==99 ? "DISABLED" :"");?>  class="btn btn-sm btn-info" type="button" id="bt_save_homol"><i class="fa fa-save"></i> Salvar</button>
								<?php 
								$cond='';
								if(!($percent==100) OR ($status==99) ){
									$cond = "DISABLED";
									} 
								;?>
								<button <?=$cond;?> class="btn btn-sm btn-success" type="button" id="bt_encerra_homol"><i class="fa fa-exclamation"></i> Encerrar</button>
								
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


<script type="text/javascript" src="<?=$hosted;?>/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script type="text/javascript" src="<?=$hosted;?>/assets/bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script type="text/javascript" src="<?=$hosted;?>/assets/plugins/fastclick/fastclick.min.js"></script>
<!-- AdminLTE App -->
<script type="text/javascript" src="<?=$hosted;?>/assets/dist/js/app.min.js"></script>
<!-- Slimscroll -->
<script type="text/javascript" src="<?=$hosted;?>/assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script type="text/javascript" src="<?=$hosted;?>/assets/js/maskinput.js"></script>
<script type="text/javascript" src="<?=$hosted;?>/assets/js/jmask.js"></script>
<script type="text/javascript" src="<?=$hosted;?>/assets/bootstrap/js/star-rating.js"></script>
<script type="text/javascript" src="<?=$hosted;?>/js/controle.js"></script>
<script type="text/javascript" src="<?=$hosted;?>/js/action_empresas.js"></script>
<script type="text/javascript" src="<?=$hosted;?>/js/jquery.cookie.js"></script>
<script type="text/javascript" src="<?=$hosted;?>/js/functions.js"></script>
<script type="text/javascript" src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
<!-- Ion Slider -->
<script type="text/javascript" src="<?=$hosted;?>/assets/plugins/ionslider/ion.rangeSlider.min.js"></script>
<!-- Bootstrap slider -->
<script type="text/javascript" src="<?=$hosted;?>/assets/plugins/bootstrap-slider/bootstrap-slider.js"></script>


<!-- SELECT2 TO FORMS
-->

<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
<!-- Validation -->
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script src="<?=$hosted;?>/assets/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>

<script type="text/javascript">
	/*------------------------|INICIA TOOLTIPS E POPOVERS|---------------------------------------*/
	$(document).ready(function () {
		$(".select2").select2({
			tags: true
		});

		$("#chatContent").scrollTop($("#msgs").height());					
		setTimeout(function(){
			$("#slc").load("cham_Ocorr.php");		
			$("#alms").load(location.href+" #almsg");
		},10000);
	
		$("#pgb_homol .progress-bar").animate({width: "<?=$percent;?>%"},1000);
		

	});
	$(function(){
		// Replace the <textarea id="editor1"> with a CKEditor
		// instance, using default configuration.
		CKEDITOR.replace('editor1');

	});
	
	function mark_conf(hom, check, acao, id, obj, emp){
		act = ( check == true ? "conf_"+acao : "desconf_"+acao);
		alb = ( check == true ? "Conferir" : "Desmarcar");
		ati = ( check == true ? 1 : 0);
        $.post("../controller/TRIEmpresas.php",
	        {
	            acao:    act,
	            homol: 	 hom,
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