<?php
require_once("../config/main.php");
require_once("../class/class.functions.php");
require_once("../class/class.permissoes.php");
if(!isset($_SESSION)){session_start();}
$rs_eve = new recordset();
$rs1 = new recordset();
$rs2 = new recordset();

//$hist = new historico();
$fn = new functions();
$per = new permissoes();
//$resul = array();
extract($_GET);
$ano = date("Y");
$sql = "SELECT usu_nome, usu_cod FROM usuarios WHERE 1 ";
$sql3 = "SELECT ob_cod FROM obrigacoes WHERE 1";

if(isset($dep) AND $dep<>""){
	$sql.= " AND usu_dep = ".$dep." AND usu_ativo = '1'";
	$sql3 .= " AND ob_depto =".$dep." AND ob_ativo=1";
}
else{
	$sql.= " AND usu_dep = ".$_SESSION['dep']." AND usu_ativo = '1'";	
	$sql3 .= " AND ob_depto =".$_SESSION['dep']." AND ob_ativo=1";	
}

if(isset($usuario) AND $usuario<>""){
	$sql.=" AND usu_cod = ".$usuario;
	$empresas = array();
	$sql_em = "SELECT cod FROM tri_clientes WHERE carteira LIKE '%\":{\"user\":\"".$usuario."\"%'";
	$rs2->FreeSql($sql_em);
	while($rs2->GeraDados()){
		$empresas[] = $rs2->fld("cod");
	}
	$emp_cods = implode(",", $empresas);
	$sql3 .= " AND ob_cod IN (".$emp_cods.")";
}

$rs2->FreeSql($sql3);
$metas = array();
for($m=1;$m<=12;$m++){
	$metas[$m] = $rs2->linhas;
}
$meta = implode(",", $metas);

$dados = array();
$rs_eve->FreeSql($sql);
$soma_dep = array(1=>0,2=>0,3=>0,4=>0,5=>0,6=>0,7=>0,8=>0,9=>0,10=>0,11=>0,12=>0);
while($rs_eve->GeraDados()){

	for($i=1;$i<=12;$i++){
		if(isset($envio) AND $envio<>""){
			$campo = $envio;
		}
		else{
			$campo = "env_data";
		}

		$sql2 = "SELECT COUNT(".$campo.") FROM impostos_enviados a 
				WHERE env_user = ".$rs_eve->fld("usu_cod");
		
		if(isset($competencia) AND $competencia<>""){
			$dta_ini = $competencia."-".str_pad($i,2,"0",STR_PAD_LEFT)."-01";
			$dta_fim = date("Y-m-t", strtotime($dta_ini));
			
			$sql2.= " AND ".$campo." BETWEEN '".$dta_ini."' AND '".$dta_fim." 23:59:59'";
		}
		else{
			$dta_ini = $ano."-".str_pad($i,2,"0",STR_PAD_LEFT)."-01";
			$dta_fim = date("Y-m-t", strtotime($dta_ini));
			
			$sql2.= " AND ".$campo." BETWEEN '".$dta_ini."' AND '".$dta_fim." 23:59:59'";
		}
		//echo $sql2.";<br>";
		$rs1->FreeSql($sql2);
		$rs1->GeraDados();
		$dados[$rs_eve->fld("usu_cod")][$i] = $rs1->fld("COUNT(".$campo.")");
		$soma_dep[$i] += $dados[$rs_eve->fld("usu_cod")][$i];
	}
}
$d1 = array();
foreach ($dados as $key => $value) {
	for($j=1;$j<=12;$j++){
		$d1[$key] = implode(",", $value);
		$somadep = implode(",", $soma_dep);
	}
}
$dados_grafico='';
foreach ($d1 as $key => $value) {
	$nome = $rs2->pegar("usu_nome","usuarios","usu_cod=".$key);
	$email = $rs2->pegar("usu_email","usuarios","usu_cod=".$key);
	$cor = 	$rs2->pegar("dados_usucor","dados_user","dados_usu_email='".$email."'");
	$dados_grafico .= '
	{
		label: "'.$nome.'",
		fillColor: "'.$cor.'",
		strokeColor: "'.$cor.'",
		pointColor: "'.$cor.'",
		pointStrokeColor: "'.$cor.'",
		pointHighlightFill: "#fff",
		pointHighlightStroke: "'.$cor.'",
		data: ['.$value.']
	},
	';
}
if(isset($usuario) AND $usuario<>""){
	$sdep = $d1[$usuario];
}
else {
	$sdep = $somadep;
}
$dados_barra = '
				{
					label: "Meta",
					fillColor: "#cfcb04",
					strokeColor: "#cfcb04",
					pointColor: "#cfcb04",
					pointStrokeColor: "#cfcb04",
					pointHighlightFill: "#fff",
					pointHighlightStroke: "#cfcb04",
					data: ['.$meta.']
				},
				{
					label: "Real",
					fillColor: "#6495ED",
					strokeColor: "#6495ED",
					pointColor: "#6495ED",
					pointStrokeColor: "#6495ED",
					pointHighlightFill: "#fff",
					pointHighlightStroke: "#6495ED",
					data: ['.$sdep.']
				}

			';

//echo $d1[$usuario];

/*
echo $dados_barra;
echo "<pre>";
print_r($soma_dep);
echo "</pre>";
*/
?>
<div class="row">
	<div class="col-md-6">
		<div class="box box-primary">
			<div class="box-header with-border">
	        	<h3 class="box-title">&Aacute;rea</h3>
	            	<div class="box-tools pull-right">
	                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
	                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
	                </div>
	            </div>
	            <div class="box-body">
					<div class="chart">
						<canvas id="areaChart" style="height:250px"></canvas>
					</div>
				</div>
			</div>
	</div>

	<div class="col-md-6">
		<div class="box box-info">
			<div class="box-header with-border">
	        	<h3 class="box-title">Linha</h3>
	            	<div class="box-tools pull-right">
	                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
	                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
	                </div>
	            </div>
					<div class="chart">
						<canvas id="lineChart" style="height:250px"></canvas>
					</div>
				</div>
			</div>
	</div>
	<div class="col-nd-12">
		<div class="box box-success">
			<div class="box-header with-border">
				<h3 class="box-title">Meta x Realizado</h3>
				<div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
				</div>
			</div>
			<div class="box-body">
				<div class="chart">
				<canvas id="barChart" style="height:230px"></canvas>
				</div>
			</div><!-- /.box-body -->
		</div><!-- /.box -->
	</div>
</div>



<script src="<?=$hosted;?>/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>

<!-- Charts -->
<script src="<?=$hosted;?>/assets/plugins/chartjs/Chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="<?=$hosted;?>/assets/plugins/morris/morris.min.js"></script>

 <script>
	$(function () {
		/* ChartJS
		* -------
		* Here we will create a few charts using ChartJS
		*/

		//--------------
		//- AREA CHART -
		//--------------

		// Get context with jQuery - using jQuery's .get() method.
		var areaChartCanvas = $("#areaChart").get(0).getContext("2d");
		// This will get the first returned node in the jQuery collection.
		var areaChart = new Chart(areaChartCanvas);

		var areaChartData = {
			labels: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
			datasets: [
				
				<?=$dados_grafico;?>
			]
		};

		var areaChartOptions = {
			//Boolean - If we should show the scale at all
			showScale: true,
			//Boolean - Whether grid lines are shown across the chart
			scaleShowGridLines: false,
			//String - Colour of the grid lines
			scaleGridLineColor: "rgba(0,0,0,.05)",
			//Number - Width of the grid lines
			scaleGridLineWidth: 1,
			//Boolean - Whether to show horizontal lines (except X axis)
			scaleShowHorizontalLines: true,
			//Boolean - Whether to show vertical lines (except Y axis)
			scaleShowVerticalLines: true,
			//Boolean - Whether the line is curved between points
			bezierCurve: true,
			//Number - Tension of the bezier curve between points
			bezierCurveTension: 0.3,
			//Boolean - Whether to show a dot for each point
			pointDot: false,
			//Number - Radius of each point dot in pixels
			pointDotRadius: 4,
			//Number - Pixel width of point dot stroke
			pointDotStrokeWidth: 1,
			//Number - amount extra to add to the radius to cater for hit detection outside the drawn point
			pointHitDetectionRadius: 20,
			//Boolean - Whether to show a stroke for datasets
			datasetStroke: true,
			//Number - Pixel width of dataset stroke
			datasetStrokeWidth: 2,
			//Boolean - Whether to fill the dataset with a color
			datasetFill: true,
			//String - A legend template
			legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
			//Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
			maintainAspectRatio: true,
			//Boolean - whether to make the chart responsive to window resizing
			responsive: true,
			multiTooltipTemplate: "<%= datasetLabel %> - <%= value %>"
		};

		//Create the line chart
		areaChart.Line(areaChartData, areaChartOptions);

		var lineChartCanvas = $("#lineChart").get(0).getContext("2d");
        var lineChart = new Chart(lineChartCanvas);
        var lineChartOptions = areaChartOptions;
        lineChartOptions.datasetFill = false;
        lineChart.Line(areaChartData, lineChartOptions);

		//- BAR CHART -
		//-------------
		var barChartCanvas = $("#barChart").get(0).getContext("2d");
		var barChart = new Chart(barChartCanvas);
		var barChartData = {
			labels: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
			datasets: [
				
				<?=$dados_barra;?>
			]
		};

		barChartData.datasets[1].fillColor = "#4169E1";
		barChartData.datasets[1].strokeColor = "#4169E1";
		barChartData.datasets[1].pointColor = "#4169E1";
			var barChartOptions = {
			//Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
			scaleBeginAtZero: true,
			//Boolean - Whether grid lines are shown across the chart
			scaleShowGridLines: true,
			//String - Colour of the grid lines
			scaleGridLineColor: "rgba(0,0,0,.05)",
			//Number - Width of the grid lines
			scaleGridLineWidth: 1,
			//Boolean - Whether to show horizontal lines (except X axis)
			scaleShowHorizontalLines: true,
			//Boolean - Whether to show vertical lines (except Y axis)
			scaleShowVerticalLines: true,
			//Boolean - If there is a stroke on each bar
			barShowStroke: true,
			//Number - Pixel width of the bar stroke
			barStrokeWidth: 2,
			//Number - Spacing between each of the X value sets
			barValueSpacing: 5,
			//Number - Spacing between data sets within X values
			barDatasetSpacing: 1,
			//String - A legend template
			legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
			//Boolean - whether to make the chart responsive
			responsive: true,
			maintainAspectRatio: true
		};

		barChartOptions.datasetFill = true;
		barChart.Bar(barChartData, barChartOptions);

	});
</script>