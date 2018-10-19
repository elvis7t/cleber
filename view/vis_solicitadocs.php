<?php
	session_start("portal");
	require_once("../model/recordset.php");
	require_once("../class/class.functions.php");
	require_once('../class/class.permissoes.php');
	date_default_timezone_set("America/Sao_Paulo");
	$fn = new functions();
	$rs = new recordset();
	$rs2 = new recordset();
	$per = new permissoes();
?>
	<table class="table table-striped">
		<tr>
		
			<th>Tipo</th>
			<th>Compet&ecirc;ncia</th>
			<th>Departamento</th>
			<th>Origem</th>
			<th>Cadastrado Em</th>
			<th>Recebido por</th>
			<th>Recebido Em</th>
			<th>Local</th>
		</tr>	
<?php
	extract($_GET);
	$con = $per->getPermissao("ver_all_docs", $_SESSION["usu_cod"]);
	/*
	$sql1 = "SELECT a.tdoc_tipo, d.doc_ref, b.imp_depto, e.dep_nome, d.doc_id, d.doc_data, d.doc_recpor, d.doc_status FROM tipos_doc a
				LEFT JOIN tipos_impostos b ON a.tdoc_id = b.imp_tdocId
				LEFT JOIN doc_recebidos c ON a.tdoc_id = c.drec_docId
				LEFT JOIN docs_entrada d ON c.drec_entId = d.doc_id
				JOIN departamentos e ON e.dep_id = b.imp_depto 
				WHERE b.imp_id IN(SELECT ob_titulo FROM obrigacoes WHERE ob_cod = ".$emp." AND ob_depto = ".$_SESSION['dep'].")
				AND a.tdoc_id IN (SELECT drec_docId FROM doc_recebidos WHERE drec_empCod = ".$emp." AND drec_compet='".$ref."')
				AND d.doc_cli = ".$emp."
   			GROUP BY a.tdoc_id;";
	*/
   	$sql1 = "SELECT e.tarq_nome, doc_ref, d.dep_nome, doc_recpor, doc_status, doc_origem, doc_local, doc_datarec, c.doc_data  FROM entradas_recebidos a
				LEFT JOIN tipos_impostos b 	ON b.imp_id = a.drec_docId  
				LEFT JOIN entrada_docs c 	ON c.doc_id = a.drec_entId
				JOIN departamentos d 		ON d.dep_id = c.doc_dep
				JOIN tipos_arquivos e 		ON e.tarq_id = a.drec_docId 
			WHERE drec_compet='".$ref."'";


	if(isset($emp) && $emp<>""){
		$sql1.= " AND drec_empCod = ".$emp;
	}

	if(isset($dep) && $dep <>""){
		$sql1.= " AND tarq_depart = ".$dep;
	}
	$sql1.=" GROUP BY tarq_id ORDER BY tarq_nome ASC";
	
	$rs->FreeSql($sql1);
	//echo $rs->sql;

	if($rs->linhas==0):
	echo "<tr><td colspan=7> Nenhum documento...</td></tr>";
	else:
		while($rs->GeraDados()){?>
			<tr>
				
				<td><span data-toggle='tooltip' data-placement='bottom' title='<?=$rs->fld("tarq_nome");?>'><?=$rs->fld("tarq_nome");?></span></td>
				<td><?=$rs->fld("doc_ref");?></td>
				<td><?=$rs->fld("dep_nome");?></td>
				<td><?=$rs->fld("doc_origem");?></td>
				<td><?=$fn->data_hbr($rs->fld("doc_data"));?></td>
				<td><?=($rs->fld("doc_recpor")<>NULL ? $rs2->pegar("usu_nome","usuarios","usu_cod = ".$rs->fld("doc_recpor")):"");?></td>
				<td><?=($rs->fld("doc_datarec")<>""?$fn->data_hbr($rs->fld("doc_datarec")):"");?></td>
				<td><?=$rs->fld("doc_local");?></td>
				
			</tr>
		<?php  
		}
		echo "<tr><td colspan=7><strong>".$rs->linhas." Documentos Recebidos</strong></td></tr>";
	endif;		
	?>
</table>
<script>
// Atualizar a cada 10 segundos
	 
	 setTimeout(function(){
		//$("#slc").load("vis_docs.php");		
		$("#alms").load(location.href+" #almsg");
	 },10500);

	 

	 // POPOVER
	$('[data-toggle="popover"]').popover();

</script>

			