<?php
require_once("../class/class.functions.php");
require_once("../model/recordset.php");

	$rs_rel = new recordset();
	$rs		= new recordset();
	$func 	= new functions();
	/*echo "<pre>";
	print_r($_GET);
	echo "</pre>";*/
	extract($_GET);
	
	//$link = "rel_print.php?tabela=".$tabela."&di=".$di."&df=".$df."&nome=".$atend;
	$sql = "SELECT * FROM servicos a
				JOIN usuarios b ON a.ser_usuario = b.usu_cod
				JOIN codstatus c ON a.ser_status = c.st_codstatus
				JOIN tri_clientes d ON a.ser_cliente = d.cod
				JOIN serv_saidas e on  a.ser_lista =e.said_id
			WHERE 1";
	$filtro = "";
	if(isset($emp) AND $emp<>""){
		$sql.=" AND ser_cliente = ".$emp;
		$filtro.= "Empresa: ".$emp."<br>";
	}

	if(isset($di) AND $di<>""){
		$sql.=" AND said_dataalt >='".$func->data_usa($di)." 00:00:00'";
		$filtro.= "Data Inicial: ".$di."<br>";
	}
	if(isset($df) AND $df<>""){
		$sql.=" AND said_dataalt <='".$func->data_usa($df)." 23:59:59'";
		$filtro.= "Data Final: ".$df."<br>";
	}
	
	if(isset($stat) AND $stat<>""){
		$sql.=" AND said_status =".$stat;
		$filtro.= "Status: ".$stat."<br>";
	}
	
	$sql.=" ORDER BY ser_data ASC";
	
	//echo $sql;
	$rs_rel->FreeSql($sql);
	//echo "<!--".$rs_rel->sql."-->";
	while($rs_rel->GeraDados()):
	?>
	<tr>
		<td><?=$rs_rel->fld("empresa");?></td>
		<td><?=$func->data_hbr($rs_rel->fld("said_dataalt"));?></td>
		<td><?=$rs_rel->fld("usu_nome");?></td>
		<td><?=$rs_rel->fld("st_desc");?></td>
	
	<?php endwhile;
	echo "<tr><td colspan=4><strong>".$rs_rel->linhas." Registros</strong></td></tr>";
	echo "<tr><td colspan=4><address>".$filtro."</address></td></tr>";
	
	?>
<script>
	$(document).ready(function(){
		$('[data-toggle="popover"]').popover({html:true});
	});
</script>