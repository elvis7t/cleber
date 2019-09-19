<?php
	session_start();
	require_once("../model/recordset.php");
	require_once("../class/class.functions.php");

	$fn = new functions();
	$rs = new recordset();

	$sql = "SELECT * FROM irpf_recibo a
				JOIN irrf b ON a.irec_id = b.ir_reciboId
				JOIN empresas c ON b.ir_cli_id = c.emp_codigo 
				WHERE 1 and ir_status!=90  GROUP BY irec_id ORDER BY irec_pago asc";
	/*--|alteração - Cleber Marrara 25/02/2016|
		|adequação de variaveis para reutilização do programa em relatórios|
	*/
	
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
				<td><?=$rs->fld("irec_id");?></td>
				<td><?=$rs->fld("emp_razao");?></td>
				<td><?="R$".number_format($rs->fld("ir_valor"),2,",",".");?></td>
				<td><?=($rs->fld("irec_ativo")==1?"Ativo":"Cancelado");?></td>
				<td><?=($rs->fld("irec_pago")==0?"N&atilde;o":"Sim");?></td>
				<td>
					<a href="dados_irpf.php?irecid=<?=$rs->fld("irec_id");?>&token=<?=$_SESSION['token'];?>"
						class='btn btn-sm btn-primary' 
						data-toggle='tooltip' 
						data-placement='bottom' 
						title='Ver Dados do Cliente'><i class='fa fa-book'></i> 
					</a> 
					<a href="irpf_reciboPrint.php?recid=<?=$rs->fld("irec_id");?>"
						id="ver_recibo"
						class='btn btn-sm btn-success' 
						data-toggle='tooltip' 
						data-placement='bottom' 
						title='Imprimir'><i class='fa fa-print'></i> 
					</a> 
					<?php 
						if($rs->fld("irec_pago")<>1): ?>
						<a
							href="javascript:pagar_reci(<?=$rs->fld('irec_id');?>,'pagar','Marcar como pago o codigo');"
							data-rec = "<?=$rs->fld("irec_id");?>" 
							class='btn btn-sm btn-info pagar_rec' 
							data-toggle='tooltip' 
							data-placement='bottom' 
							title='Marcar como Pago'><i class='fa fa-bank'></i>
						</a>
						<button 
							data-idrec="<?=$rs->fld("irec_id");?>"
							class='btn btn-sm btn-danger irec_cancela' 
							data-toggle='tooltip' 
							data-placement='bottom' 
							title='Cancelar'><i class='fa fa-trash'></i>
						</button>
					<?php endif; ?>
				</td>
					
			</tr>
		<?php  
		}
		?>		<?php endif;?>
	
