<?php

	$rs2 = new recordset();
	$fn = new functions();
	
	$dms = array(1=>31, 2=>28, 3=>31, 4=>30, 5=>31, 6=>30, 7=>31, 8=>31, 9=>30, 10=>31, 11=>30, 12=>31);
	if(date("d") >= $dms[date("m")]){$dia = 31 - $dms[date("m")];}
	else{$dia = date("d");}
	$df = $dia+5;
	$sql = "SELECT * FROM tipos_impostos a
						WHERE imp_venc >=".$dia." 
						AND imp_venc <=".$df." 
						AND imp_depto=".$_SESSION['dep']." 
						ORDER BY cast(imp_venc as unsigned integer) ASC";
	$rs->FreeSql($sql);
	//echo $sql;
?>
<table class="table table-striped" id="empr">
	<tr>
		<th>Imposto</th>
		<th>Vencimento <small>(esse m&ecirc;s)</small></th>
		<th>Empresas</th>
	</tr>
	<?php 
		if($rs->linhas==0):
			echo "<tr><td colspan=7> Nenhum dado</td></tr>";
			else:
				while($rs->GeraDados()){
				?>
				<tr>
					<td><?=$rs->fld("imp_nome");?></td>
					<td class="hidden-xs">
						<?php
							if($rs->fld("imp_regra")=="mes_subs"){
								$ref =  date("m")+$rs->fld("imp_venc")."/".date("Y");
								echo $fn->ultimo_dia_mes($ref);
							}
							else{
								echo $fn->data_br($fn->dia_util($rs->fld("imp_venc"),$rs->fld("imp_regra")));
							}
						?>
					</td>
					<td class="hidden-xs">
					<?php
					$tabela = ($rs->fld("imp_tipo")=="T"?"tributos":"obrigacoes");
					$campo = ($rs->fld("imp_tipo")=="T"?"tr_":"ob_");
					$sql = "SELECT ".$campo."cod FROM ".$tabela." a
								JOIN tri_clientes b ON a.".$campo."cod = b.cod
								WHERE ".$campo."titulo"."=".$rs->fld("imp_id") ."
								AND b.carteira LIKE '%\"".$_SESSION['dep']."\":{\"user\":";
					if($_SESSION['lider']=="N"){ $sql.= "\"".$_SESSION['usu_cod']."\""; }
					$sql.= "%'";
					//echo $sql;
					$rs2->FreeSql($sql);
					//echo $rs2->sql;
					$rs2->GeraDados();
					echo $rs2->linhas;
					?>
					</td>
				</tr>
			<?php  
			}
			echo "<tr><td colspan=7><strong>".$rs->linhas." Tributo(s) / Obriga&ccedil;&atilde;o(&ccedil;&otilde;es)</strong></td></tr>";
		endif;		
	?>
</table>
	