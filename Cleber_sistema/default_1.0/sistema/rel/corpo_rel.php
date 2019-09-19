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
	if($tabela == "tri_solic"){
		$tblsel = "Solicita&ccedil;&otilde;es";
		$campo = "sol_data";
	}
	else{
		$tblsel = "Liga&ccedil;&otilde;es";
		$campo = "sol_datareal";
	}
	$link = "rel_print.php?tabela=".$tabela."&di=".$di."&df=".$df."&nome=".$atend;
	$sql = "SELECT * FROM ".$tabela." 
				LEFT JOIN usuarios a ON a.usu_cod = sol_real_por
				WHERE sol_cod<>0 AND sol_status IN(0,99)";
	$filtro = "Tabela: ".$tblsel."<br>";
	if(isset($di) AND $di<>""){
		$sql.=" AND ".$campo." >='".$func->data_usa($di)." 00:00:00'";
		$filtro.= "Data Inicial: ".$di."<br>";
	}
	if(isset($df) AND $df<>""){
		$sql.=" AND ".$campo." <='".$func->data_usa($df)." 23:59:59'";
		$filtro.= "Data Final: ".$df."<br>";
	}
	if(isset($atend) AND $atend<>""){
		$sql.=" AND sol_real_por =".$atend;
		$filtro.= "Atendente (Cód): ".$atend;
	}
	if(isset($solic) AND $solic<>""){
		$sql.=($tabela == "tri_solic" ? " AND sol_por =".$solic : " AND sol_fcom like '%".$solic."%'");
		$filtro.= "<br>Solicitante (Cód): ".$solic;
	}
	if(isset($pres) AND $pres<>"" AND $tabela=="tri_ligac"){
		$sql.=" AND sol_pres =".$pres;
		$filtro.= "<br>Presencial?: ".($pres==1?"Sim":"N&atildeo");
	}
	
	$sql.=" ORDER BY sol_data";
	
	
	$rs_rel->FreeSql($sql);
	
	while($rs_rel->GeraDados()):
	?>
	<tr>
		<td><?=(strlen($rs_rel->fld("sol_emp"))>25?substr($rs_rel->fld("sol_emp"),0,25)." ...":$rs_rel->fld("sol_emp"));?></td>
		<td><?=$rs_rel->fld("sol_tel");?></td>
		<td><?=$rs_rel->fld("sol_fcom");?></td>
		<td><?=$rs->pegar("usu_nome","usuarios","usu_cod=".$rs_rel->fld("sol_por"));?></td>
		<td><?=$rs_rel->fld("usu_nome");?></td>
		<td><?=$func->data_hbr($rs_rel->fld("sol_datareal"));?></td>
		<?php if($tabela == "tri_ligac"): ?>
			<td><?=($rs_rel->fld("sol_pres")==1?"Sim":"N&atilde;o");?></td>
		<?php else: ?>
			<td align="center">-</td>
		<?php endif; ?>
	</tr>
	<?php endwhile;
	echo "<tr><td><strong>".$rs_rel->linhas." Registros</strong></td></tr>";
	echo "<tr><td><address>".$filtro."</address></td></tr>";
	echo $rs_rel->sql;
	
	?>
	