<?php
	session_start();
	require_once("../../model/recordset.php");
	require_once("../../sistema/class/class.functions.php");

	$fn = new functions();
	$rs = new recordset();
	$rs2 = new recordset();

	$sql = "SELECT * FROM tri_clientes a 
				LEFT JOIN tributos b ON a.cod = b.tr_cod
				LEFT JOIN obrigacoes c ON a.cod = c.ob_cod";
	$sql.= " WHERE cod <> 0";
	/*--|alteração - Cleber Marrara 25/02/2016|
		|adequação de variaveis para reutilização do programa em relatórios|
	*/
	if(isset($_GET["tri"]) AND $_GET["tri"]<>""){$sql.= " AND tribut = '".$_GET["tri"]."'";}
	if(isset($_GET["emp"]) AND $_GET["emp"]<>""){$sql.= " AND cod IN(".$_GET["emp"].")";}
	if(isset($_GET["tip"]) AND $_GET["tip"]<>""){$sql.= " AND carteira LIKE '%\"2\":{\"user\":\"".$_GET['tip']."\"%'";}
	if(isset($_GET["imp"]) AND $_GET["imp"]<>""){
		$imp = urlencode($_GET['imp']);
		$sql.= " AND (c.ob_titulo = '".$imp."' OR b.tr_titulo = '".$imp."')";
	}

	$sql.= " GROUP BY cod ORDER BY empresa ASC";
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
				<td><input type="checkbox" name="emp_cods[]" value="<?=$rs->fld("cod");?>" /></td>
				<td><?=$rs->fld("cod");?></td>
				<td><?=$rs->fld("apelido");?></td>
				<td><?=$rs->fld("tribut");?></td>
				<?php
					$arr = json_decode($rs->fld("carteira"),true);
					//echo $rs->fld("carteira");
				?>
				<td><?=(empty($arr[2]["user"])?"":$rs2->pegar("usu_nome","usuarios","usu_cod=".(int)$arr[2]["user"]));?></td>
				<td><?=(empty($arr[2]["data"])?"":$arr[2]["data"]);?></td>
				<td>
					<a class='btn btn-xs btn-info btn-xs' data-toggle='popover' data-trigger="hover" data-placement='auto bottom' data-content='' title=' <?=$rs->fld("apelido");?>'><i class='fa fa-book'></i> </a>
				</td>
				
					
			</tr>
		<?php  
		}
		?>
		<tr><td colspan=8><strong>Encontrado(s): </strong><?=$rs->linhas;?> registro(s)</td></tr>
	<?php endif;?>