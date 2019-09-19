<?php
	session_start();
	require_once("../model/recordset.php");
	require_once("../class/class.functions.php");

	$fn = new functions();
	$rs = new recordset();

	$sql = "SELECT * FROM irrf a
				JOIN empresas b 
					ON a.ir_cli_id = b.emp_codigo
				LEFT JOIN contatos c 
					ON b.emp_cnpj = c.con_cli_cnpj
				LEFT JOIN codstatus d 
					ON a.ir_status = d.st_codstatus
				LEFT JOIN usuarios e
					ON a.ir_ult_user = e.usu_cod
				LEFT JOIN irpf_recibo f
					ON a.ir_reciboId = f.irec_Id
				LEFT JOIN irrf_historico g
					ON a.ir_Id = g.irh_ir_id
				LEFT JOIN irpf_retorno h
					ON a.ir_id = h.iret_ir_id
				";
	/*--|alteração - Cleber Marrara 25/02/2016|
		|adequação de variaveis para reutilização do programa em relatórios|
	*/
	$rel = 0;
	if(isset($_GET['clicod'])){ $sql.= " WHERE ir_cli_id = ".$_GET['clicod'];}
	else{
		//print_r($_GET);
		$rel = 1;
		$sql.= " WHERE ir_status<>90";
		if(isset($_GET['di']) AND $_GET['di'] !=""){ $sql.=" AND ir_dataent >= '".$fn->data_usa($_GET['di'])."'";}
		if(isset($_GET['df']) AND $_GET['df'] !=""){ $sql.=" AND ir_dataent <= '".$fn->data_usa($_GET['df'])." 23:59:59'";}
		if(isset($_GET['status']) AND $_GET['status'] !=""){ $sql.=" AND ir_status = '".$_GET['status']."'";}
		if(isset($_GET['periodo']) AND $_GET['periodo'] !=""){ $sql.=" AND ir_ano = '".$_GET['periodo']."'";}
		if(isset($_GET['vlde']) AND $_GET['vlde'] !=""){ $sql.=" AND ir_valor >= '".$_GET['vlde']."'";}
		if(isset($_GET['vate']) AND $_GET['vate'] !=""){ $sql.=" AND ir_valor <= '".$_GET['vate']."'";}
		if(isset($_GET['altera']) AND $_GET['altera'] !=""){ $sql.=" AND ir_ult_user = '".$_GET['altera']."'";}
		if(isset($_GET['pago']) AND $_GET['pago'] !=""){ $sql.=" AND irec_pago = ".$_GET['pago'];}
		if(isset($_GET['pend']) AND $_GET['pend'] !=""){ $sql.=" AND ir_pendencia = ".$_GET['pend'];}
		if(isset($_GET['ret']) AND $_GET['ret'] !=""){ $sql.=" AND iret_tipo = '".$_GET['ret']."'";}

	}
	$sql.=" GROUP BY ir_Id";
	$rs->FreeSql($sql);
	//echo $rs->sql;
	if($rs->linhas==0):
	echo "<tr><td colspan=7> Nenhuma solicita&ccedil;&atilde;o IRPF...</td></tr>";
	else:
		
		while($rs->GeraDados()){
			//Adequação - Valor do IRPF anterior
			$sql2 = "SELECT ir_valor FROM irrf 
						WHERE ir_cli_id = ".$rs->fld('ir_cli_id')." 
						AND ir_tipo = '".$rs->fld("ir_tipo")."' 
						AND ir_ano = ".($rs->fld("ir_ano")-1);
			$rs1 = new recordset();
			$rs1->FreeSql($sql2);
			$rs1->GeraDados();
			?>
			<form id="lista_recibo" action="irpf_recibo.php" method="POST" target="_blank">
			<input type="hidden" name="clicod" value="<?=$rs->fld("emp_codigo");?>" />
			<tr>
				<td><?=$rs->fld("ir_Id");?></td>
				<td><?=$rs->fld("ir_tipo");?></td>
				<?php if($rel==1): ?>
				<td><?=$rs->fld("emp_cnpj");?></td>
				<td><p class="text-uppercase"><?=$rs->fld("emp_razao");?></p></td>
				<?php endif; ?>
				<td><?=$rs->fld("ir_ano");?></td>
				<td><?=($rs1->linhas <>0 ? "R$".number_format($rs1->fld("ir_valor"),2,",","."): "");?></td>
				<td><?=$fn->formata_din($rs->fld("ir_valor"));?></td>
				<td><?=$fn->data_hbr($rs->fld("ir_dataent"));?></td>
				<td><?=$rs->fld("st_desc");?></td>
				<td><?=$rs->fld("usu_nome");?></td>
			<?php if($rel == 0): ?>
				<td>
				<?php if($rs->fld("ir_status")<>90):?>
					<a 	href="irpf_ocorrencia.php?token=<?=$_SESSION['token']; ?>&clicod=<?=$_GET['clicod']; ?>&ircod=<?=$rs->fld("ir_Id"); ?>"
						class='btn btn-xs btn-info'
						data-toggle='tooltip' 
						data-placement='bottom' 
						title='Registro de Ocorr&ecirc;ncia'>
						<i class='fa fa-tags'></i>  
					</a>
					
					<?php
						if($rs->fld("st_codstatus") == 89): ?>
							<a 	href="irpf_receita.php?token=<?=$_SESSION['token']; ?>&clicod=<?=$_GET['clicod']; ?>&ircod=<?=$rs->fld("ir_Id"); ?>"
								class='btn btn-xs btn-primary'
								data-toggle='tooltip' 
								data-placement='bottom' 
								title='determinar Status na Receita Federal'>
								<i class='fa fa-eye'></i> 
							</a>
						<?php
						else: ?>
							<a 	href="irpf_alteracao.php?token=<?=$_SESSION['token']; ?>&clicod=<?=$_GET['clicod']; ?>&ircod=<?=$rs->fld("ir_Id"); ?>"
								class='btn btn-xs btn-warning'
								data-toggle='tooltip' 
								data-placement='bottom' 
								title='Alterar IRPF'>
								<i class='fa fa-terminal'></i> 
							</a>
						<?php
						endif;
					else: ?>
						<a 	href="irpf_ocorrencia.php?token=<?=$_SESSION['token']; ?>&clicod=<?=$_GET['clicod']; ?>&ircod=<?=$rs->fld("ir_Id"); ?>"
							class='btn btn-xs btn-danger'
							data-toggle='tooltip' 
							data-placement='bottom'>
							<i class='fa fa-thumbs-o-down'></i> 
						</a>
					<?php 
					endif;
					if($rs->fld("ir_pendencia")<>0): ?>
						<a 	href="irpf_ocorrencia.php?token=<?=$_SESSION['token']; ?>&clicod=<?=$_GET['clicod']; ?>&ircod=<?=$rs->fld("ir_Id"); ?>"
							class='btn btn-xs btn-danger'
							data-toggle='tooltip' 
							data-placement='bottom'
							title="Contêm Pend&ecirc;ncias">
							<i class='fa fa-times'></i> 
						</a>
					<?php else: ?>
						<a 	href="#"
							class='btn btn-xs btn-success'
							data-toggle='tooltip' 
							data-placement='bottom'
							title="Sem pend&ecirc;ncias">
							<i class='fa fa-check'></i> 
						</a>
					<?php endif;
					?>
					
				</td>
			<?php endif;?>				
				
			</tr>
		<?php  
		}
		?><tr>
				<td colspan=9>
					<strong><?=$rs->linhas; ?> Registro(s)</strong>
				</td>
				<?php if($rel == 0): ?>
				<td colspan=9></td>
				
				<?php endif;?>
			</tr>
			</form>
	<?php endif; ?>
