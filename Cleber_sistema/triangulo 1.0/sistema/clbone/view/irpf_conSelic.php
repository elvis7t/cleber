<?php
	session_start();
	require_once("../../model/recordset.php");
	require_once("../../sistema/class/class.functions.php");

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
			list($mes, $ano) = explode("/", $rs->fld("isel_ref"));
			if($mes==12){$mes = 0; $ano++;}
			if($mes<10){$mes = substr($mes,1,1);}
			?>
			<tr>
				
				<td><?=$rs->fld("isel_ref");?></td>
				<td><?=$rs->fld("isel_taxa");?></td>
				<td><button class="btn btn-xs btn-danger" id="btn_excSelic" data-registro="<?=$rs->fld("isel_id");?>"><i class="fa fa-trash"></i></button></td>
			</tr>
		<?php  
		}
		?><tr>
				<td>
					<strong><?=$rs->linhas; ?> Registro(s)</strong>
				</td>
			</tr>
			</form>
	<?php endif; ?>
	
