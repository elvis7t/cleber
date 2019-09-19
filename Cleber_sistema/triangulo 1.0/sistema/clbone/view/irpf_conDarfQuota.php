<?php
	session_start();
	require_once("../../model/recordset.php");
	require_once("../../sistema/class/class.functions.php");

	$fn = new functions();
	$rs = new recordset();

	$ref = (isset($_GET["ref"])?$_GET["ref"]:date("m/Y"));

	$sql = "SELECT *, c.ir_cli_id, d.emp_razao FROM irpf_retorno a 
				LEFT JOIN irpf_cotas b ON a.iret_ir_id = b.icot_ir_id
				JOIN irrf c ON a.iret_ir_id = c.ir_Id
				JOIN empresas d ON c.ir_cli_id = d.emp_codigo
				LEFT JOIN documentos e ON d.emp_cnpj = e.doc_cli_cnpj
				LEFT JOIN usuarios f ON b.icot_quem = f.usu_cod
			WHERE icot_ref='".date("m/Y")."' AND iret_pagto<>'Debito'";
	//$sql.=" GROUP BY ir_Id";
	$rs->FreeSql($sql);
	//echo $rs->sql;
	if($rs->linhas==0):
	echo "<tr><td colspan=7> Nenhuma solicita&ccedil;&atilde;o IRPF...</td></tr>";
	else:
		while($rs->GeraDados()){
			?>
			<tr>
				<td><?=$rs->fld("iret_id");?></td>
				<td><?=$rs->fld("emp_razao");?></td>
				<td><?=$fn->data_br($rs->fld("iret_datalib"));?></td>
				<td>R$<?=number_format(round($rs->fld("icot_valor"),2),2,",",".");?></td>
				<td><?=$rs->fld("icot_parc");?></td>
				<td><?=$fn->ultimo_dia_mes($rs->fld("icot_ref"));?></td>
				<td>
				
					<a 	href="irpf_DarfProtocolo.php?token=<?=$_SESSION['token']; ?>&recid=<?=$rs->fld("icot_id"); ?>"
						class='btn btn-xs btn-success'
						data-toggle='tooltip' 
						data-placement='bottom' 
						title='Protocolo de Entrega'
						target="_blank">
						<i class='fa fa-tag'></i> 
					</a> 
					<a 	href="print_darf.php?token=<?=$_SESSION['token']; ?>&clicod=<?=$_GET['clicod']; ?>&irret=<?=$rs->fld("icot_id"); ?>"
						class='btn btn-xs btn-info'
						data-toggle='tooltip' 
						data-placement='bottom' 
						title='Imprimir DARF'
						target="_blank">
						<i class='fa fa-print'></i> 
					</a> 
					<?php
					if($rs->fld("icot_print")=="Y"):
						?>
						<span class="text-green"
						data-toggle='tooltip' 
						data-placement='bottom' 
						title='Impresso por <?=$rs->fld("usu_nome");?> em <?=$fn->data_hbr($rs->fld("icot_datas"));?>'><i class="fa fa-check"></i></span>
						<?php
						endif;
					?>
					<!--<button 
						id="bt_maildarf"
						class='btn btn-xs btn-success'
						data-toggle='tooltip' 
						data-placement='bottom'
						data-cota="<?=$rs->fld("icot_id"); ?>"
						title='Enviar por E-mail'>
						<i class='fa fa-envelope'></i> 
					</button>-->
					
					
					
				</td>
			</tr>
		<?php  
		}
		?>
			</form>
	<?php endif; ?>
	
