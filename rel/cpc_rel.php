<?php
require_once("../../sistema/class/class.functions.php");
require_once("../../model/recordset.php");
	session_start();
	$rs_rel = new recordset();
	$rs		= new recordset();
	$func 	= new functions();
	/*
	echo "<pre>";
	print_r($_SESSION);
	echo "</pre>";
	*/
	extract($_GET);
	
	//$link = "rel_print.php?tabela=".$tabela."&di=".$di."&df=".$df."&nome=".$atend;
	$sql = "SELECT *, count(cpc_cli) as total FROM cpcviews a
				JOIN tri_clientes b ON a.cpc_cli = b.cod
			WHERE 1";
	$filtro = "";
	if(isset($emp) AND $emp<>""){
		$sql.=" AND cpc_cli = ".$emp;
		$filtro.= "Empresa: ".$emp."<br>";
	}

	if(isset($di) AND $di<>""){
		$sql.=" AND cpc_lastseen >='".$func->data_usa($di)." 00:00:00'";
		$filtro.= "Data Inicial: ".$di."<br>";
	}
	if(isset($df) AND $df<>""){
		$sql.=" AND cpc_lastseen <='".$func->data_usa($df)." 23:59:59'";
		$filtro.= "Data Final: ".$df."<br>";
	}
	
	
	
	$sql.=" GROUP BY cpc_cli ORDER BY empresa ASC, cpc_lastseen DESC";
	
	//echo $sql;
	$rs_rel->FreeSql($sql);
	//echo "<!--".$rs_rel->sql."-->";
	while($rs_rel->GeraDados()):

		$part = $rs->pegar("part_titulo","particularidades","part_cod = ".$rs_rel->fld("cpc_cli"),"","part_id DESC");
	?>
		
	<tr>
		<td><?=$rs_rel->fld("empresa");?></td>
		<td><?=$part;?></td>
		<td><?=$func->data_hbr($rs_rel->fld("cpc_lastseen"));?></td>
		<td><?=$rs_rel->fld("total");?></td>
		<td><a href="rel_cpcviews_func.php?emp=<?=$rs_rel->fld("cod");?>&di=<?=$di;?>&df=<?=$df;?>&token=<?=$_SESSION['token'];?>" title="ver por Funcionario" class="btn btn-xs btn-info" id="bt_cpc_func"><i class="fa fa-search"></i></a></td>
	
	<?php endwhile;
	echo "<tr><td colspan=5><strong>".$rs_rel->linhas." Registros</strong></td></tr>";
	echo "<tr><td colspan=5><address>".$filtro."</address></td></tr>";
	
	?>
<script>
	$(document).ready(function(){
		$('[data-toggle="popover"]').popover({html:true});
	});
</script>