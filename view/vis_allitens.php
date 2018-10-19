<?php
	session_start();
	require_once("../model/recordset.php");
	require_once("../class/class.functions.php");

	$fn = new functions();
	$rs = new recordset();

	$sql = "SELECT * FROM servicos a 
				LEFT JOIN tri_clientes b ON a.ser_cliente = b.cod
				JOIN codstatus c  ON a.ser_status = c.st_codstatus
				JOIN usuarios d ON a.ser_usuario = d.usu_cod
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
	$sql.= " WHERE ser_lista = 0 AND ser_status != 90 ";
	$sql.= " GROUP BY ser_id ORDER BY ser_venc ASC";
	$rs->FreeSql($sql);
	//echo $rs->sql;
	if($rs->linhas==0):
	echo "<tr><td colspan=7> Nenhuma solicita&ccedil;&atilde;o IRRF...</td></tr>";
	else: ?>
		<?php
		$soma = 0;
		while($rs->GeraDados()){
			?>
			<input type="hidden" name="clicod" value="<?=$rs->fld("emp_codigo");?>" />
			<tr>
				<td><input type="checkbox" name="serv_cods[]" value="<?=$rs->fld("ser_id");?>" /></td>
				<td><?=$rs->fld("ser_id");?></td>
				<td><?=$rs->fld("apelido");?></td>
				<td><?=$rs->fld("regiao");?></td>
				<td><?=$rs->fld("usu_nome");?></td>
				<td><?=$fn->data_hbr($rs->fld("ser_data"));?></td>
				<td>
					<a class='btn btn-xs btn-info btn-xs' data-toggle='popover' data-trigger="hover" data-placement='auto bottom' data-content='<?=$rs->fld("ser_obs");?>' title=' <?=$rs->fld("apelido");?>'><i class='fa fa-book'></i> </a>
				</td>
				
					
			</tr>
		<?php  
		}
		?>
		<?php endif;?>
	
