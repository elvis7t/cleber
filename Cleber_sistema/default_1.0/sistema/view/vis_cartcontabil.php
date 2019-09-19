<?php
	session_start();
	require_once("../model/recordset.php");
	require_once("../class/class.functions.php");

	$fn = new functions();
	$rs = new recordset();
	$rs2 = new recordset();

	$sql = "SELECT * FROM tri_clientes a"; 
				//LEFT JOIN tipos_empresas b ON a.tipo_emp = b.tipemp_cod
				//LEFT JOIN porte_empresa c ON a.num_emp = c.port_id";
	$sql.= " WHERE ativo = 1";

	if(isset($_GET["emp"]) AND $_GET["emp"]<>""){$sql.= " AND cod IN(".$_GET["emp"].")";}
	if(isset($_GET["tip"]) AND $_GET["tip"]<>""){$sql.= " AND carteira LIKE '%\"1\":{\"user\":\"".$_GET['tip']."\"%'";}
	//if(isset($_GET["por"]) AND $_GET["por"]<>""){$sql.= " AND num_emp=".$_GET["por"];}
	
	$sql.= " GROUP BY apelido ORDER BY cod ASC";
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
				<td><input type="checkbox" id="emp_cods" name="emp_cods[]" value="<?=$rs->fld("cod");?>" /></td>
				<td><?=$rs->fld("cod");?></td>
				<td><?=$rs->fld("apelido");?></td>
				<td class="hidden-xs"><?=$rs->fld("tribut");?></td>
				<?php
					$arr = json_decode($rs->fld("carteira"),true);
					//echo $rs->fld("carteira");
				?>
				<td><?=(empty($arr[1]["user"])?"":$rs2->pegar("usu_nome","usuarios","usu_cod=".(int)$arr[1]["user"]));?></td>
				<td><?=(empty($arr[1]["data"])?"":$arr[1]["data"]);?></td>
				<td class="hidden-xs">
					<a class='btn btn-xs btn-info btn-xs' data-toggle='popover' data-trigger="hover" data-placement='auto bottom' data-content='' title=' <?=$rs->fld("apelido");?>'><i class='fa fa-book'></i> </a>
				</td>
				
					
			</tr>
		<?php  
		}
		?>
		<tr><td colspan=8><strong>Encontrado(s): </strong><?=$rs->linhas;?> registro(s)</td></tr>
	<?php endif;?>