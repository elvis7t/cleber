<?php
	session_start("portal");
	require_once("../model/recordset.php");
	require_once("..//class/class.functions.php");

	$fn = new functions();
	$rs = new recordset();
	$rs2 = new recordset();

	$sql = "SELECT * FROM tri_clientes a 
				LEFT JOIN porte_empresa c ON a.num_emp = c.port_id";
	$sql.= " WHERE ativo=1";

	if(isset($_GET["emp"]) AND $_GET["emp"]<>""){$sql.= " AND cod IN(".$_GET["emp"].")";}
	if(isset($_GET["tip"]) AND $_GET["tip"]<>""){$sql.= " AND carteira LIKE '%\"5\":{\"user\":\"".$_GET['tip']."\"%'";}
	
	$sql.= " GROUP BY cod ORDER BY apelido ASC";
	$rs->FreeSql($sql);
	//echo $rs->sql;
	if($rs->linhas==0):
		echo "<tr><td colspan=7> Nenhuma empresa</td></tr>";
	else:
		$soma = 0;
		while($rs->GeraDados()){
			?>
			<input type="hidden" name="clicod" value="<?=$rs->fld("cod");?>" />
			<tr>
				<td class="<?=(isset($_GET['r'])?"hide":"")?>"><input type="checkbox" name="emp_cods[]" value="<?=$rs->fld("cod");?>" /></td>
				<td><?=str_pad($rs->fld("cod"),3,"000",STR_PAD_LEFT);?></td>
				<td><?=$rs->fld("apelido");?></td>
				<?php
					$arr = json_decode($rs->fld("carteira"),true);
					//echo $rs->fld("carteira");
				?>
				<td><?=(empty($arr[5]["user"])?"":$rs2->pegar("usu_nome","usuarios","usu_cod=".(int)$arr[5]["user"]));?></td>
				<td><?=(empty($arr[5]["data"])?"":$arr[5]["data"]);?></td>
									
			</tr>
		<?php  
		}
	endif;
	?>