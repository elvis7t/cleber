<?php
			require_once("../config/main.php");

			require_once("../class/class.dashboard.php");
			$fn = new dashboard();
			//getImposto($compet, $tipo, $depart="", $user="", $empresa="")
			/*echo "<pre>";
			print_r($_GET);
			echo "</pre>";
			*/
			$dep = (isset($_GET['depto'])?$_GET['depto']:$_SESSION['depto']);
			$usu = (isset($_GET['usuario'])?$_GET['usuario']:$_SESSION['usu_cod']);
			$emp = (isset($_GET['empresa'])?$_GET['empresa']:"");
			$comp = ((isset($_GET['competencia']) AND $_GET['competencia']!="")?$_GET['competencia']:date("m/Y", strtotime("-1 month")));
			$mov 	= $fn->getImpostoCad($dep, $usu, $emp);
			
			$ger 	= $fn->getImposto($comp, 'env_gerado',		$dep, $usu, $emp);
			$nger 	= $mov - $ger;
			$per_ger = ($mov==0?0:($ger/$mov)*100);
			$con 	= $fn->getImposto($comp, 'env_conferido',	$dep, $usu, $emp);
			$ncon 	= $mov - $con;
			$per_con = ($mov==0?0:($con/$mov)*100);
			$env 	= $fn->getImposto($comp, 'env_enviado',		$dep, $usu, $emp);
			$nenv 	= $mov - $env;
			$per_env = ($mov==0?0:($env/$mov)*100);
			$feito 	= $ger+$con+$env;
			$movg= $mov*3;
			$general= ($movg) - $feito;
			$per_geral = ($movg==0?0:($feito/$movg)*100);

			?>
				<div class="col-md-3">
					<!-- DONUT CHART -->
					<?php
						$gerados = '{label: "Gerados", value: '.$ger.'},
									{label: "Não Gerados", value: '.$nger.'}';
						$cor = $fn->getColor($per_ger);
					?>
					<div class="chart" id="gerados_chart" style="height: 200px; position: relative;"></div>
					<div id="pgb_ger" class="progress progress-md <?=($per_ger==100?"":"progress-striped");?> active">
						<div class="progress-bar progress-bar-<?=$cor;?>" role="progressbar" aria-valuenow="<?=$ger;?>" aria-valuemin="0" aria-valuemax="<?=$mov?>">
							<span class=""><?=number_format($per_ger,2)."% (".($per_ger==100?"Completo":"Em processo").")";?></span>
						</div>
					</div>
					<div class="box-footer">
							Gerados: <?=$ger." de ".$mov;?> / <?=number_format($per_ger,2);?>%
					</div>
					
				</div>
		
				<div class="col-md-3">
					<?php
						$conferidos = '{label: "Conferidos", value: '.$con.'},
									{label: "Não conferidos", value: '.$ncon.'}';
						$cor = $fn->getColor($per_con);
					?>
					<div class="chart" id="conferidos_chart" style="height: 200px; position: relative;"></div>

					<div id="pgb_con" class="progress progress-md <?=($per_con==100?"":"progress-striped");?> active">
						<div class="progress-bar progress-bar-<?=$cor;?>" role="progressbar" aria-valuenow="<?=$con;?>" aria-valuemin="0" aria-valuemax="<?=$mov?>">
							<span class=""><?=number_format($per_con,2)."% (".($per_con==100?"Completo":"Em processo").")";?></span>
						</div>
					</div>
					<div class="box-footer">
							Conferidos: <?=$con." de ".$mov;?> / <?=number_format($per_con,2);?>%
					</div>
				</div>

				<div class="col-md-3">
					<?php
						$enviados = '{label: "Enviados", value: '.$env.'},
									{label: "Não enviados", value: '.$nenv.'}';
						$cor = $fn->getColor($per_env);

					?>
					<div class="chart" id="enviados_chart" style="height: 200px; position: relative;"></div>
					<div id="pgb_env" class="progress progress-md <?=($per_env==100?"":"progress-striped");?> active">
						<div class="progress-bar progress-bar-<?=$cor;?>" role="progressbar" aria-valuenow="<?=$env;?>" aria-valuemin="0" aria-valuemax="<?=$mov?>">
							<span class=""><?=number_format($per_env,2)."% (".($per_env==100?"Completo":"Em processo").")";?></span>
						</div>
					</div>
					<div class="box-footer">
							Enviados: <?=$env." de ".$mov;?> / <?=number_format($per_env,2);?>%
					</div>
				</div>

				<div class="col-md-3">
					<?php
						$geral = '{label: "Realizados", value: '.$feito.'},
								{label: "à realizar", value: '.$general.'}';
						$cor = $fn->getColor($per_geral);

					?>
					<div class="chart" id="geral_chart" style="height: 200px; position: relative;"></div>
					<div id="pgb_geral" class="progress progress-md <?=($per_geral==100?"":"progress-striped");?> active">
						<div class="progress-bar progress-bar-<?=$cor;?>" role="progressbar" aria-valuenow="<?=$geral;?>" aria-valuemin="0" aria-valuemax="<?=$movg;?>">
							<span class=""><?=number_format($per_geral,2)."% (".($per_geral==100?"Completo":"Em processo").")";?></span>
						</div>
					</div>
					<div class="box-footer">
							Geral: <?=$feito." de ".$movg;?> / <?=number_format($per_geral,2);?>%
					</div>
				</div><!-- /.col -->
			<script src="<?=$hosted;?>/sistema/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
			
			<!-- Charts -->
			<script src="<?=$hosted;?>/sistema/assets/plugins/chartjs/Chart.min.js"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
			<script src="<?=$hosted;?>/sistema/assets/plugins/morris/morris.min.js"></script>
	
			<script type="text/javascript">
				$(function(){
					//GRAFICO GERADOS
					var donut = new Morris.Donut({
						element: 'gerados_chart',
						resize: true,
						colors: ["#4682b4", "#add8e6"],
						data: [
						<?=$gerados;?>
						],
						hideHover: 'auto'
					});
					//GRAFICO CONFERIDOS
					var donut = new Morris.Donut({
						element: 'conferidos_chart',
						resize: true,
						colors: ["#4682b4", "#add8e6"],
						data: [
						<?=$conferidos;?>
						],
						hideHover: 'auto'
					});
					//GRAFICO ENVIADOS
					var donut = new Morris.Donut({
						element: 'enviados_chart',
						resize: true,
						colors: ["#4682b4", "#add8e6"],
						data: [
						<?=$enviados;?>
						],
						hideHover: 'auto'
					});
					//GRAFICO GERAL
					var donut = new Morris.Donut({
						element: 'geral_chart',
						resize: true,
						colors: ["#4682b4", "#add8e6"],
						data: [
						<?=$geral;?>
						],
						hideHover: 'auto'
					});

					$("#pgb_ger .progress-bar").animate({width: "<?=$per_ger;?>%"},1000);
					$("#pgb_con .progress-bar").animate({width: "<?=$per_con;?>%"},1000);
					$("#pgb_env .progress-bar").animate({width: "<?=$per_env;?>%"},1000);
					$("#pgb_geral .progress-bar").animate({width: "<?=$per_geral;?>%"},1000);

				});
			</script>