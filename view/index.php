<?php
//sujeira embaixo do tapete :(
//error_reporting(E_ALL & E_NOTICE & E_WARNING);

//session_start("portal");
/*inclusão dos principais itens da página */
$sec = "Dashboard";
$pag = "index.php";
require_once("../config/main.php");
require_once("../config/valida.php");
require_once("../config/mnutop.php");
require_once("../config/menu.php");
require_once("../config/modals.php");
require_once("../class/class.functions.php");
require_once("../class/class.irpf.php");
require_once("../class/class.permissoes.php");
require_once("../class/class.mensagens.php");

$per = new permissoes();
$men = new mensagens();
					
?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
			<h1>
				Dashboard
				<small>Painel</small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active">Dashboard</li>
			</ol>
				
				
        
			<div class="row">
				<div class="col-md-12" id="counters">
					<?php 
						require_once("../config/dash_index_new.php");
					?>
				</div>

			</div>

		
		<?php require_once("avisos_dash.php"); ?>	
		
        </section>
		
		<?php

		$con = $per->getPermissao("metas_dash",$_SESSION["usu_cod"]);
		if($con['C']==1): // Verifica permissão para ver as metas
		 	$mou = $per->getPermissao("minhas_metas.php",$_SESSION['usu_cod']); // metas outros usuarios ?>			
				<div class="col-md-12">
					<div class="box box-danger">
						<div class="box-header with-border">
							<h3 class="box-title">Lista de Tarefas</h3>
							<div class="box-tools pull-right">
								<input type="hidden" id="metas_depart" value="<?=$_SESSION['dep'];?>">
								<input type="hidden" id="metas_colab" value=<?=($mou['C']==0?$_SESSION['usu_cod']:"");?> >
								<input type="hidden" id="metas_dtini" value="<?=date("d/m/Y");?>">
								<input type="hidden" id="metas_dtfim" value="">
								<button class="btn btn-box-tool" id="btn_pesqmetas"><i class="fa fa-refresh"></i></button>
			                </div><!--/box title-->
						</div><!-- /.box-header -->
						<div id="vismetas" class="box-body">		
				
						</div>
					</div>
				</div>
			
		<?php
		endif;	

		$con = $per->getPermissao("excluienvio",$_SESSION["usu_cod"]);
		if($con['C']==1): // A partir de coordenador, vê os impostos e obrigações ?>
			<div class="row">
				<div class="col-md-12">		
					<?php
						require_once("view_pesquisa.php");
						/*

						*/
					?>
				</div><!--/row	-->
			</div>
		<?php endif;
		
		$con = $per->getPermissao("proxenvios",$_SESSION["usu_cod"]);
		if($con['C']==1): ?>
			<div class="row">
				<div class="col-md-12">		
					<?php
						require_once("view_proximposto.php");
					?>
				</div><!--/row	-->
			</div>
		<?php endif;

		$con = $per->getPermissao("pend_conf",$_SESSION["usu_cod"]);
		if($con['C']==1): // A partir de coordenador, vê os impostos e obrigações ?>
			<div class="row">
				<div class="col-md-12" id="view_pendconf">		
						<?php
						require_once("view_pendconf.php");
						/* Páginas referenciadas:
							-| imp_pesquisaconf
							  -|vis_impconferir
						*/
					?>
				</div><!--/row	-->
			</div>
		
		<?php
		endif;
		$con = $per->getPermissao("pend_env",$_SESSION["usu_cod"]);
		if($con['C']==1): // Verifica permissão para ver os pendentes de envio ?>
			<div class="row">
				<div class="col-md-12" id="view_pendenv">		
					<?php
						require_once("view_pendenv.php");
						/*
						-| imp_pesquisaenv
						  -|vis_impenviar
						*/
					?>
				</div><!--/row	-->
			</div>
		<?php
		endif;
		
		$con = $per->getPermissao("conf_env",$_SESSION["usu_cod"]);
		if($con['C']==1): // Verifica permissão para ver os pendentes de envio ?>
			<div class="row">
				<div class="col-md-12" id="view_confenv">		
					<?php
						require_once("view_confenv.php");
						/*
						-| imp_conferefenv
						  -| vis_confenviar 
						*/
					?>
				</div><!--/row	-->
			</div>
		<?php
		endif;


		?>

		
		
		<?php 
		$con = $per->getPermissao("graf_irpf",$_SESSION["usu_cod"]);
		if($con['C']==1 ):?>
    		<section class="content" id="linha_do_tempo">
				<div class="row">	
					<div class="col-md-6">
						<div class="box box-danger">
			                <div class="box-header with-border">
			                  <h3 class="box-title">IRPF <?=date("Y")-1;?></h3>
			                  <div class="box-tools pull-right">
			                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
			                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
			                  </div>
			                </div>
			                <div class="box-body">
			                    <canvas id="pieChart" style="height:250px"></canvas>
			                   		<?php
					                    $irpf = new irpf();
					                    //print_r($irpf->status_ir());
					       				$status = $irpf->status_ir($sql);
					                    $cores = array(0=>"#f56954",1=>"#00a65a",2=>"#00c0ef",3=>"#3c8dbc",4=>"#f39c12",5=>"#d2d6de",6=>"#940000");
					                    $color = array(0=>"#f56954",1=>"#00a65a",2=>"#00c0ef",3=>"#3c8dbc",4=>"#f39c12",5=>"#d2d6de",6=>"#940000");
					                    $table="";
					                    $bts = "";
								        for($i=0;$i<sizeof($status); $i++){ 
								          $table .= '
								          {
								            value: '.$status[$i]["valor"].',
								            color: "'.$cores[$i].'",
								            highlight: "'.$cores[$i].'",
								            label: "'.$status[$i]["desc"].'"
								          },
								          ';
								          $bts .= "
								          	<div class='col-md-4'>
								          		<div style='width:10px; height:10px; background-color:".$cores[$i].";'>
								          		</div>".$status[$i]['desc']."
								          	</div>";
								    	}
								    	$jparam = substr($table,0,-2);
								    	echo $bts;
				                    ?>
				            </div><!-- /.box-body -->
		            	</div><!-- /.box -->
		            </div><!-- ./md-6 -->

		            <div class="col-md-6">
		            	<!-- DONUT CHART -->
			            <div class="box box-info">
			                <div class="box-header with-border">
			                	<h3 class="box-title">Pagos x N&atilde;o Pagos</h3>
			                  	<div class="box-tools pull-right">
			                    	<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
			                    	<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
			                	</div>
			                </div>
			                <div class="box-body chart-responsive">
			                	<?php
			                		$pagos = $irpf->pagos_ir();
			                		$devem = $irpf->devem_ir();
			                		$sem_r = $irpf->sem_boleto();
			                		$dado_pagos = ' {label: "Pagos", value: '.$pagos.'},
					            					{label: "Nao Pagos", value: '.$devem.'},
					            					{label: "Sem Recibo", value: '.$sem_r.'}';

			                	?>
			                 	<div class="chart" id="irpf_pagos" style="height: 300px; position: relative;"></div>
			                </div><!-- /.box-body -->
			            </div><!-- /.box -->
		            </div>


		            <div class="col-md-12 bg-white">
			              <div class="box box-success">
			                <div class="box-header with-border">
			                  <h3 class="box-title">Anual</h3>
			                  <div class="box-tools pull-right">
			                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
			                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
			                  </div>
			                </div>
			                <div class="box-body chart-responsive">
			                
				                <?php
				                	//print_r($irpf->history_ir());
				                	$historico = $irpf->history_ir();
				                	$data="";
				                    //$bts = "";
							        for($i=0;$i<sizeof($historico); $i++){ 
							          $data .= "
			                			{y: '".$historico[$i]["ano"]."', a: ".$historico[$i]["valor"]."},
							          ";
							          $datahis = substr($data,0,-2);
							        }
							        //echo $datahis;
				                ?>
				              <div class="chart" id="bar-chart" style="height: 300px;"></div>
			                </div><!-- /.box-body -->
			            </div><!-- /.box -->
		            </div>
				</div><!--./row-->
			</section>
		<?php endif;?>
	
    </div><!-- /.content-wrapper -->
		
	<script type="text/javascript" src="<?=$hosted;?>/sistema/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script type="text/javascript" src="<?=$hosted;?>/sistema/assets/bootstrap/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script type="text/javascript" src="<?=$hosted;?>/sistema/assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <script type="text/javascript" src="<?=$hosted;?>/sistema/assets/plugins/fastclick/fastclick.min.js"></script>
	<!-- Main row -->
	<!-- Charts -->
	<script type="text/javascript" src="<?=$hosted;?>/sistema/assets/plugins/chartjs/Chart.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
	<script type="text/javascript" src="<?=$hosted;?>/sistema/assets/plugins/morris/morris.min.js"></script>
    <!-- AdminLTE App -->
    <script type="text/javascript" src="<?=$hosted;?>/sistema/assets/dist/js/app.min.js"></script>
	<script type="text/javascript" src="<?=$hosted;?>/sistema/assets/dist/js/demo.js"></script>

  
    <?php require_once("../config/footer.php"); ?>    
</div><!-- ./wrapper -->
</div><!-- /.row -->
   <!-- Slimscroll -->
    <script type="text/javascript" src="<?=$hosted;?>/sistema/assets/js/maskinput.js"></script>
    <script type="text/javascript" src="<?=$hosted;?>/sistema/assets/js/jmask.js"></script>
    <script type="text/javascript" src="<?=$hosted;?>/sistema/js/action_triang.js"></script>
    <script type="text/javascript" src="<?=$hosted;?>/sistema/js/controle.js"></script>
    <script type="text/javascript" src="<?=$hosted;?>/sistema/js/functions.js"></script>
    <script type="text/javascript" src="<?=$hosted;?>/sistema/js/action_empresas.js"></script>
    <script type="text/javascript" src="<?=$hosted;?>/sistema/js/action_metas.js"></script>
    <script type="text/javascript" src="<?=$hosted;?>/sistema/js/jquery.cookie.js"></script>
    <script type="text/javascript" src="<?=$hosted;?>/sistema/js/date_format.js"></script>
    <!-- SELECT2 TO FORMS-->
	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
	<!-- Validation -->
    <!--<script type="text/javascript" src="<?=$hosted;?>/js/jquery-validation/dist/jquery.validate.min.js"></script>-->
	<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
	<script type="text/javascript" src="<?=$hosted;?>/sistema/assets/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>

	<script src="<?=$hosted;?>/sistema/assets/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="<?=$hosted;?>/sistema/assets/plugins/datatables/dataTables.bootstrap.min.js"></script> 


	<script type="text/javascript" type="text/javascript">
		$(document).ready(function(){

			$(".select2").select2({
				tags: true
			});
			$(".venc_prox").select2({
				tags: true,
				theme: 'classic'
			});

			

			$("#pend_enviar").DataTable({
				"order": [[ 0, "asc" ],[2,"asc"]],
				"columnDefs": [{
				"defaultContent": "-",
				"targets": "_all",
				}]
			});

			$("#pend_conferir").DataTable({
				"order": [[ 0, "asc" ],[2,"asc"]],
				"columnDefs": [{
				"defaultContent": "-",
				"targets": "_all",
				}]
			});

				

			$(document).on("click",".pesq", function(){
			 	$("#sel_emp").select2("val",$(this).data("emp"));
			 	$("#sel_imp").select2("val",$(this).data("imp"));
			 	//$("#pesq_conf").load("vis_impconferir.php");
			 	//console.log($(this).data("pesq"));
			});
			
				$('[data-toggle="tooltip"]').tooltip();
			
				$("#checkboximp").bootstrapToggle();
				
				// Get context with jQuery - using jQuery's .get() method.
		        var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
		        var pieChart = new Chart(pieChartCanvas);
		        var PieData = [
		          <?=$jparam;?>
		        ];
		        var pieOptions = {
		          //Boolean - Whether we should show a stroke on each segment
		          segmentShowStroke: true,
		          //String - The colour of each segment stroke
		          segmentStrokeColor: "#fff",
		          //Number - The width of each segment stroke
		          segmentStrokeWidth: 2,
		          //Number - The percentage of the chart that we cut out of the middle
		          percentageInnerCutout: 50, // This is 0 for Pie charts
		          //Number - Amount of animation steps
		          animationSteps: 100,
		          //String - Animation easing effect
		          animationEasing: "easeOutBounce",
		          //Boolean - Whether we animate the rotation of the Doughnut
		          animateRotate: true,
		          //Boolean - Whether we animate scaling the Doughnut from the centre
		          animateScale: false,
		          //Boolean - whether to make the chart responsive to window resizing
		          responsive: true,
		          // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
		          maintainAspectRatio: true,
		          //String - A legend template
		          legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
		        };
		        //Create pie or douhnut chart
		        // You can switch between pie and douhnut using the method below.
		        pieChart.Doughnut(PieData, pieOptions);

		        // Bar Chart Morris
		        var bar = new Morris.Bar({
		          element: 'bar-chart',
		          resize: true,
		          data: [
		           <?=$datahis; ?>
		          ],
		          barColors: ['#3C8DBC'],
		          xkey: 'y',
		          ykeys: ['a'],
		          labels: ['IRPF'],
		          hideHover: 'auto'
		        });

		        //DONUT CHART
				var donut = new Morris.Donut({
					element: 'irpf_pagos',
					resize: true,
					colors: ["#00a65a", "#f56954", "#3c8dbc"],
					data: [
					<?=$dado_pagos;?>
					],
					hideHover: 'auto'
				});


					
			setTimeout(function(){
				//$("#counters").load("../config/dash_index2.php");
				$("#alms").load(location.href+" #almsg");
				//$("#view_pendconf").load("view_pendconf.php?box=0");
	            //$("#view_pendenv").load("view_pendenv.php?box=0");
	            //$("#view_confenv").load("view_confenv.php?box=0");
	                
			 },7500);
			
			
		});
		
      	</script>