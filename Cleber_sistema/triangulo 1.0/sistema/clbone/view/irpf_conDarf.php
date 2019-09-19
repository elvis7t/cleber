<?php
	session_start();
	require_once("../../model/recordset.php");
	require_once("../../sistema/class/class.functions.php");

	$fn = new functions();
	$rs = new recordset();

	$sql = "SELECT * FROM irpf_retorno a 
				LEFT JOIN irpf_cotas b ON a.iret_ir_id = b.icot_ir_id
			WHERE iret_ir_id=".$_GET['ircod'];
	//$sql.=" GROUP BY ir_Id";
	$rs->FreeSql($sql);
	//echo $rs->sql;
	if($rs->linhas==0):
	echo "<tr><td colspan=7> Nenhuma solicita&ccedil;&atilde;o IRPF...</td></tr>";
	else:
		while($rs->GeraDados()){
			?>
			<tr>
				<td><?=$rs->fld("iret_tipo");?></td>
				<td><?=$fn->data_br($rs->fld("iret_datalib"));?></td>
				<td>R$<?=number_format($rs->fld("icot_valor"),2,",",".");?></td>
				<td><?=$rs->fld("icot_parc");?></td>
				<td><?=($rs->fld("iret_tipo")=="IAP" ? $fn->ultimo_dia_mes($rs->fld("icot_ref")) : "-");?></td>
				<td>
				
					<a 	href="print_darf.php?token=<?=$_SESSION['token']; ?>&clicod=<?=$_GET['clicod']; ?>&irret=<?=$rs->fld("icot_id"); ?>"
						class='btn btn-xs btn-info'
						data-toggle='tooltip' 
						data-placement='bottom' 
						title='Imprimir DARF'>
						<i class='fa fa-print'></i> 
					</a>
					
					
				</td>
			</tr>
		<?php  
		}
		?><tr>
				<td>
					<strong><?=$rs->linhas; ?> Registro(s)</strong>
				</td>
				<?php if($rel == 0): ?>
				<td colspan=6></td>
				
				<?php endif;?>
			</tr>
			</form>
	<?php endif; ?>
	
