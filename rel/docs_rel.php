<?php
session_start("portal");
require_once("../class/class.functions.php");

	$rs_rel = new recordset();
	$rs		= new recordset();
	$func 	= new functions();
	/*echo "<pre>";
	print_r($_GET);
	echo "</pre>";*/
	extract($_GET);
	
	//$link = "rel_print.php?tabela=".$tabela."&di=".$di."&df=".$df."&nome=".$atend;
	$sql = "SELECT * FROM entrada_docs a
				JOIN tri_clientes b ON a.doc_cli = b.cod
				LEFT JOIN usuarios c ON a.doc_recpor = c.usu_cod
				LEFT JOIN departamentos d ON a.doc_dep = d.dep_id
				LEFT JOIN tipos_doc e ON e.tdoc_id = a.doc_tipo
			WHERE doc_empresa = ".$_SESSION['usu_empcod'];
	$filtro = "";
	if(isset($emp) AND $emp<>""){
		$sql.=" AND doc_cli = ".$emp;
		$filtro.= "Empresa: ".$emp."<br>";
	}

	if(isset($di) AND $di<>""){
		$sql.=" AND doc_data >='".$func->data_usa($di)." 00:00:00'";
		$filtro.= "Data Inicial: ".$di."<br>";
	}
	if(isset($df) AND $df<>""){
		$sql.=" AND doc_data <='".$func->data_usa($df)." 23:59:59'";
		$filtro.= "Data Final: ".$df."<br>";
	}
	if(isset($por) AND $por<>""){
		$sql.=" AND doc_recpor =".$por;
		$filtro.= "Atendente (Cód): ".$por."<br>";
	}
	if(isset($dep) AND $dep<>""){
		$sql.=" AND doc_dep =".$dep;
		$filtro.= "Departamento (Cód): ".$dep."<br>";
	}
	if(isset($ref) AND $ref<>""){
		$sql.=" AND doc_ref ='".$ref."'";
		$filtro.= "Ref: ".$ref."<br>";
	}
	
	$sql.=" ORDER BY doc_data DESC";
	
	//echo "<tr><td>$sql</td></tr>";
	$rs_rel->FreeSql($sql);
	//echo $rs_rel->sql;
	while($rs_rel->GeraDados()):
	?>
	<tr>
		<td><?=(strlen($rs_rel->fld("empresa"))>25?substr($rs_rel->fld("empresa"),0,25)." ...":$rs_rel->fld("empresa"));?></td>
		<td><?=$rs_rel->fld("dep_nome");?></td>
		<td><?=$rs_rel->fld("tdoc_tipo");?></td>
		<td><?=$rs_rel->fld("doc_ref");?></td>
		<td><?=$func->data_hbr($rs_rel->fld("doc_data"));?></td>
		<td><?=$rs_rel->fld("usu_nome");?></td>
		<td><?=$func->data_hbr($rs_rel->fld("doc_datarec"));?></td>
		<td><a class='btn btn-xs btn-primary' data-toggle='popover' data-trigger="hover" data-placement='auto bottom' data-content="<?=$rs_rel->fld("doc_obs");?>" title='<?=$rs_rel->fld("usu_nome");?>'><i class='fa fa-book'></i> </a></td>
	</tr>
	<?php endwhile;
	echo "<tr><td colspan=6><strong>".$rs_rel->linhas." Registros</strong></td></tr>";
	echo "<tr><td><address>".$filtro."</address></td></tr>";
	
	?>
<script>
	$(document).ready(function(){
		$('[data-toggle="popover"]').popover({html:true});
	});
</script>