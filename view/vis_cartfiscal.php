<?php
	session_start("portal");
	require_once("../model/recordset.php");
	require_once("../class/class.functions.php");

	$fn = new functions();
	$rs = new recordset();
	$rs2 = new recordset();

	$sql = "SELECT * FROM tri_clientes a 
				LEFT JOIN tributos b ON a.cod = b.tr_cod
				LEFT JOIN obrigacoes c ON a.cod = c.ob_cod";
	$sql.= " WHERE ativo=1";
	/*--|alteração - Cleber Marrara 25/02/2016|
		|adequação de variaveis para reutilização do programa em relatórios|
	*/

		//condcoes
	if(isset($_GET["tri"]) AND $_GET["tri"]<>""){$sql.= " AND tribut = '".$_GET["tri"]."'";}
	if(isset($_GET["emp"]) AND $_GET["emp"]<>""){$sql.= " AND cod IN(".$_GET["emp"].")";}
	if(isset($_GET["tip"]) AND $_GET["tip"]<>""){$sql.= " AND carteira LIKE '%\"2\":{\"user\":\"".$_GET['tip']."\"%'";}
	if(isset($_GET["imp"]) AND $_GET["imp"]<>""){
		$imp = urlencode($_GET['imp']);
		$sql.= " AND (c.ob_titulo = '".$imp."' OR b.tr_titulo = '".$imp."')";
	}

	$sql.= " GROUP BY cod ORDER BY cod ASC";
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
				<td class='<?=(isset($_GET['r'])?"hidden":"");?>'><input type="checkbox" name="emp_cods[]" value="<?=$rs->fld("cod");?>" /></td>
				<td><?=str_pad($rs->fld("cod"),3,"000",STR_PAD_LEFT);?></td>
				<td><?=$rs->fld("apelido");?></td>
				<td><?=$rs->fld("tribut");?></td>
				<?php
					$arr = json_decode($rs->fld("carteira"),true);
					//echo $rs->fld("carteira");
				?>
				<td><?=(empty($arr[2]["user"])?"":$rs2->pegar("usu_nome","usuarios","usu_cod=".(int)$arr[2]["user"]));?></td>
				<td><?=(empty($arr[2]["data"])?"":$arr[2]["data"]);?></td>
				
			</tr>
		<?php 
		}
	endif;
	?>
	<tr>
		<th colspan=6>Registros: <?=$rs->linhas;?></th>
	</tr>