<?php
	require_once("../class/class.functions.php");

	$fn = new functions();
	$rs = new recordset();

	$sql = "SELECT * FROM irrf a
				JOIN empresas b 
					ON a.ir_cli_id = b.emp_codigo
				LEFT JOIN contatos c 
					ON b.emp_cnpj = c.con_cli_cnpj
				JOIN codstatus d 
					ON a.ir_status = d.st_codstatus
				JOIN usuarios e
					ON a.ir_ult_user = e.usu_cod
				LEFT JOIN irpf_recibo f
					ON a.ir_Id = f.irec_Id
				LEFT JOIN irrf_historico g
					ON a.ir_Id = g.irh_ir_id
				";
	/*--|alteração - Cleber Marrara 25/02/2016|
		|adequação de variaveis para reutilização do programa em relatórios|
	*/
	$rel = 0;
	if(isset($_GET['clicod'])){ $sql.= "WHERE ir_cli_id = ".$_GET['clicod']." AND ir_reciboId=0";}
	else{
		//print_r($_GET);
		$rel = 1;
		$sql.= "WHERE ir_reciboId = 0 AND ir_status!=90 AND (ir_dataent between '".date("Y")."-01-01' AND '".date("Y")."-12-31') ";
		

	}
	$sql.=" GROUP BY ir_Id ORDER BY emp_razao ASC";
	$rs->FreeSql($sql);
	//echo $rs->sql;
	if($rs->linhas==0):
	echo "<tr><td colspan=7> Nenhuma solicita&ccedil;&atilde;o IRRF...</td></tr>";
	else: ?>
		<?php
		$soma = 0;
		while($rs->GeraDados()){
			$soma += $rs->fld("ir_valor");
			?>
			<input type="hidden" name="clicod" value="<?=$rs->fld("emp_codigo");?>" />
			<tr>
				<td><input type="checkbox" name="ir_cods[]" value="<?=$rs->fld("ir_Id");?>" /></td>
				<td><?=$rs->fld("ir_tipo");?></td>
				<td><?=$rs->fld("emp_cnpj");?></td>
				<td><p class="text-uppercase"><?=$rs->fld("emp_razao");?></p></td>
				<td><?=$rs->fld("ir_ano");?></td>
				<td>R$<?=number_format($rs->fld("ir_valor"),2,",",".");?></td>
				<td><?=$rs->fld("ir_reciboId");?></td>
					
			</tr>
		<?php  
		}
		?><tr>
				<td>
					<strong><?=$rs->linhas; ?> Registro(s)</strong>
				</td>
				<td><strong>Total a receber:</strong></td>
				<td>
					<strong>R$<?=number_format($soma,2,",",".");?></strong>
				</td>
				
			</tr>
		<?php endif;?>
	
