
<?php
session_start("portal");
	require_once("../class/class.permissoes.php");
	//session_start();
	require_once("../model/recordset.php");
	require_once("../class/class.functions.php");
	date_default_timezone_set("America/Sao_Paulo");
	$fn = new functions();
	$rs = new recordset();
	$rs2 = new recordset();
$per = new permissoes();
$con = $per->getPermissao("recalc_vertodos", $_SESSION['usu_cod']);
$_hide = ($con['I']==0?"hide":"");
?>
	<table class="table table-striped table-condensed">
		<thead>
			<tr>
				<th>#</th>
				<th>Empresa</th>
				<th>Data</th>
				<th class="hidden-xs">Tipo Calc</th>
				<th class="hidden-xs">Comp.</th>
				<th class="hidden-xs">Solic. Por</th>
				<th class="hidden-xs">Qtd</th>
				<th class="hidden-xs <?=$_hide;?>">Valor Un.</th>
				<th>Valor total</th>
				<th class="hidden-xs">Realizado Por</th>
				<th>Status</th>
				<th>A&ccedil;&otilde;es</th>
			</tr>	
		</thead>
		<tbody>
<?php
	$sql = "SELECT m.*, a.calc_desc, b.cod, b.apelido, c.usu_nome AS solic, d.usu_nome as efet, e.st_desc, e.st_icone
			FROM recalculos m
				JOIN tipos_calc a ON m.rec_doc = a.calc_id 
				JOIN tri_clientes b ON m.rec_cli = b.cod
				LEFT JOIN usuarios c ON m.rec_user = c.usu_cod
				LEFT JOIN usuarios d ON m.rec_usuSol = d.usu_cod
				JOIN codstatus e ON m.rec_status = e.st_codstatus
				WHERE 1";
				
	$sql.=" AND rec_status<>90";
	
	if($con['C']==0){
		$sql.=" AND rec_user = ".$_SESSION['usu_cod'];
	}
	else{
		$sql.=" AND rec_id<>0";
	}
	
	if(isset($_GET['emp']) && $_GET['emp']<>0 ){
		$sql.=" AND rec_cli = ".$_GET['emp'];
	}

	if(isset($_GET['di']) && $_GET['di']<>0 ){
		$sql.=" AND rec_data >= '".$fn->data_usa($_GET['di'])." 00:00:00'";
	}
	

	if(isset($_GET['df']) && $_GET['df']<>0 ){
		$sql.=" AND rec_data <='".$fn->data_usa($_GET['df'])." 23:59:59'";
	}

	if(isset($_GET['col']) && $_GET['col']<>0){
		$sql.=" AND rec_user =".$_GET['col'];
	}
	if(isset($_GET['status']) && $_GET['status']<>0){
		$sql.=" AND rec_status =".$_GET['status'];
	}

	$sql .=" ORDER BY rec_data DESC, rec_id ASC";
	//echo $sql;
	$rs->FreeSql($sql);
	if($rs->linhas==0):
	echo "<tr><td colspan=12> Nenhum calculo solicitado</td></tr>";
	else:
		$soma = 0;
		$valor = 0;
		while($rs->GeraDados()){ 
			$nome = explode(" ",$rs->fld("solic"));
			$valor = $rs->fld("rec_qtd")*$rs->fld("rec_val");
			$soma += ($rs->fld("rec_status")==90?0:$valor);
			?>
			<tr>
				<td><?=$rs->fld("rec_id");?></td>
				<td><?=$rs->fld("cod")." - ".$rs->fld("apelido");?></td>
				<td><?=$fn->data_hbr($rs->fld("rec_data"));?></td>
				<td class="hidden-xs"><?=$rs->fld("calc_desc");?></td>
				<td><?=$rs->fld("rec_compet");?></td>
				<td class="hidden-xs"><?=$nome[0];?></td>
				<td class="hidden-xs"><?=$rs->fld("rec_qtd");?></td>
				<td class="hidden-xs  <?=$_hide;?>"><?="R$".number_format($rs->fld("rec_val"),2,",",".");?></td>
				<td><?="R$".number_format($valor,2,",",".");?></td>
				<td class="hidden-xs"><?=$rs->fld("efet");?></td>
				<td><?=$rs->fld("st_desc");?></td>
				<td class="">
					<?php
					if($rs->fld("rec_status")==0): ?>
						<a href="javascript:baixa('<?=$rs->fld("rec_id");?>','save_recalc','Deseja salvar o recálculo');" class="btn btn-xs btn-success" data-toggle='tooltip' data-placement='bottom' title='Efetuar'><i class="fa fa-check"></i></a>
						<a href="javascript:baixa('<?=$rs->fld("rec_id");?>','exc_recalc','Deseja realmente cancelar o recálculo');" class="btn btn-xs btn-danger" data-toggle='tooltip' data-placement='bottom' title='Cancelar'><i class="fa fa-times"></i></a>
					<?php endif; ?>
					<?php
					if($rs->fld("rec_status")==87): ?>
						<a href="javascript:baixa('<?=$rs->fld("rec_id");?>','fat_recalc','Deseja faturar o recálculo');" class="btn btn-xs btn-primary" data-toggle='tooltip' data-placement='bottom' title='Faturar'><i class="fa fa-money"></i></a>
					<?php endif; ?>

				</td>
			</tr>
		<?php  
		}
		if($_hide==""){
		echo "<tr><td colspan=3 align='right'><strong>Total:</strong></td><td colspan=4><strong>R$".number_format($soma,2,",",".")."</strong></td></tr>";
		}
		echo "<tr><td colspan=12><strong>".$rs->linhas." calculos Solicitados</strong></td></tr>";
	endif;
	?>
	</tbody>
</table>



			