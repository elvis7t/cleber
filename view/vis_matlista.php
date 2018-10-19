<?php
	session_start();
	require_once("../../model/recordset.php");
	require_once("../../sistema/class/class.functions.php");

	$fn = new functions();
	$rs = new recordset();

	$sql = "SELECT * FROM alerta_compras a 
			LEFT JOIN mat_cadastro b ON a.alerta_matId = b.mcad_id
			WHERE (a.alerta_matcomp - a.alerta_matentr) <= a.alerta_matmin
			AND a.alerta_matId NOT IN (SELECT mat_cadId FROM mat_historico WHERE mat_operacao = 'I' AND mat_lista IS NOT NULL )
			";
	/*--|alteração - Cleber Marrara 25/02/2016|
		|adequação de variaveis para reutilização do programa em relatórios|
	$rel = 0;
	if(isset($_GET['clicod'])){ $sql.= "WHERE ir_cli_id = ".$_GET['clicod']." AND ir_reciboId=0";}
	else{
		//print_r($_GET);
		$rel = 1;
		

	}
	$sql.=" GROUP BY ir_Id ORDER BY emp_razao ASC";
	*/
	$rs->FreeSql($sql);
	//echo $rs->sql;
	if($rs->linhas==0):
	echo "<tr><td colspan=5> Nenhum produto para compras</td></tr>";
	else: ?>
		<?php
		$soma = 0;
		while($rs->GeraDados()){
			$saldo = $rs->fld("alerta_matcomp") - $rs->fld("alerta_matentr");
			?>
			<tr>
				<td><input type="checkbox" name="serv_cods[]" value="<?=$rs->fld("alerta_matId");?>" /></td>
				<td><?=$rs->fld("alerta_matId");?></td>
				<td><?=$rs->fld("mcad_desc");?></td>
				<td><?=$saldo;?></td>
				<td><?=$rs->fld("alerta_matmin");?></td>
				<td><?=$rs->fld("alerta_matqtdcp");?></td>
				
				
					
			</tr>
		<?php  
		}
		?>
		<?php endif;?>
	
