<table class="table table-striped table-responsive table-condensed" id="prodmens">
	<thead>
		<tr>
			<th>Colaborador</th>
			<th>Empresa</th>
			<th>Tarefas</th>
			<th>Completas</th>
			<th>Progresso</th>
			<th>Detalhes</th>
		</tr>	
	</thead>
	<tbody>
		<?php
		require_once("../config/main.php");
		require_once("../class/class.dashboard.php");
		$fn = new dashboard();
		$fn2 = new dashboard();
		$rs2 = new recordset();

		// First of all, I need to search for the companies depending on the filters filled up

		$dep = (isset($_GET['dep'])?$_GET['dep']:($_SESSION['classe']==1?'':$_SESSION['dep']));
		$usu = (isset($_GET['usu'])?$_GET['usu']:'');
		$comp = ((isset($_GET['comp']) AND $_GET['comp']!="")?$_GET['comp']:date("m/Y", strtotime("-1 month")));
		$timp = ((isset($_GET['timp']) AND $_GET['timp']!="")?$_GET['timp']:'');
		//echo $comp;
		$sql = "SELECT * FROM tri_clientes
					JOIN obrigacoes ON cod = ob_cod 	
				WHERE ativo=1 AND emp_vinculo = ".$_SESSION['usu_empcod'];
		if(!empty($usu)){
			$sql.= " AND carteira LIKE '%\"".$dep."\":{\"user\":\"".$usu."\"%'";
		}
		$sql .= " GROUP BY cod ORDER BY cod ASC";
		//echo $sql;
		$fn->FreeSql($sql);
		$content='';
		
		while($fn->GeraDados()){
			$emp = ($fn->fld("cod")<>""?$fn->fld("cod"):'');
			
			$arr = json_decode($fn->fld("carteira"),true);
			$mov 	= $fn2->getImpostoCad($dep, $usu, $emp,$timp);
			$ger 	= $fn2->getImposto($comp, 'env_gerado',	$dep, $usu, $emp,$timp);
			$con 	= $fn2->getImposto($comp, 'env_conferido', $dep, $usu, $emp,$timp);
			$env 	= $fn2->getImposto($comp, 'env_enviado', $dep, $usu, $emp,$timp);
			$feito 	= $ger+$con+$env;
			$movg 	= $mov*3;
			$per_geral = ($movg==0?0:($feito/$movg)*100);
			//echo $ger;
			$cor = $fn2->getColor($per_geral);
			$classe = ($per_geral==100?"success":"");
			$content .= '
				<tr class="'.$classe.'">
					<td>'.(empty($arr[$dep]["user"])?"":$rs2->pegar("usu_nome","usuarios","usu_cod=".(int)$arr[$dep]["user"])).'</td>
					<td>'.str_pad($fn->fld("cod"), 3,"0",STR_PAD_LEFT)." - ".$fn->fld("empresa").'</td>
					<td>'.$movg.'</td>
					<td>'.$feito.'</td>
					<td>
						<div id="pgb_status" class="progress progress-md '.($per_geral==100?"":"progress-striped").' active">
							<div class="progress-bar progress-bar-'.$cor.' role="progressbar" aria-valuenow="'.$feito.'" aria-valuemin="0" aria-valuemax="'.$movg.'" style="width:'.$per_geral.'%;">
								<span class="">'.number_format($per_geral,2)."% (".($per_geral==100?"Completo":"Em processo").")".'</span>
							</div>
						</div>
						
						
					</td>
					<td><button id="fakedash" data-cod="'.$fn->fld("cod").'" class="btn btn-xs btn-primary"><i class="fa fa-book"></i></button></td>
				</tr>
			';
		}
		echo $content;
		?>
	</tbody>
</table>


<script src="<?=$hosted;?>/sistema/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/datatables/dataTables.bootstrap.min.js"></script> 
<script>
	$(document).ready(function(){
		$('#prodmens').DataTable({
			"columnDefs": [{
			"defaultContent": "-",
			"targets": "_all"
			}]
		});
	});
</script>





