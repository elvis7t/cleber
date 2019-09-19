<?php
	session_start();
	require_once("../model/recordset.php");
	require_once("../class/class.functions.php");

	$fn = new functions();
	$rs = new recordset();
	$meses = array("Janeiro", "Fevereiro", "Mar&ccedil;o", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");
	$sql = "SELECT * FROM irpf_selic ORDER BY isel_ref ASC";
	$rs->FreeSql($sql);
	//echo $rs->sql;
	if($rs->linhas==0):
	echo "<tr><td colspan=7> Nenhuma solicita&ccedil;&atilde;o IRPF...</td></tr>";
	else:
		while($rs->GeraDados()){
			list($ano, $mes,) = explode("-", $rs->fld("isel_ref"));
			//if($mes==12){$mes=1;$ano++;}
			if($mes<10){$mes = substr($mes,0,2);}
			?>
			<tr>
				
				<td><?=$rs->fld("isel_id");?></td>
				<td><?=str_pad($mes, 2,"0",STR_PAD_LEFT)."/".$ano;?></td>
				<td><?=number_format($rs->fld("isel_taxa"),2,",",".");?></td>
				<td><button class="btn btn-xs btn-danger" onclick="javascript:del(<?=$rs->fld('isel_id');?>,'excSelic','Excluir taxa Selic');"><i class="fa fa-trash"></i></button></td>
			</tr>
		<?php  
		}
		?><tr>
				<td colspan="4">
					<strong><?=$rs->linhas; ?> Registro(s)</strong>
				</td>
			</tr>
			</form>
	<?php endif; ?>
	
