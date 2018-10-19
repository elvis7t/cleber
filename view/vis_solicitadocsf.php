<?php
	session_start("portal");
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
			<th>Formato</th>
			<th>A&ccedil;&otilde;es</th>
		</tr>	
<?php
	extract($_GET);
	$con = $per->getPermissao("ver_all_docs", $_SESSION["usu_cod"]);
	/*
	$sql1 = "SELECT a.tarq_id, a.tarq_nome, d.doc_ref, b.imp_depto, e.dep_nome, d.doc_id, d.doc_datarec, d.doc_recpor FROM tipos_arquivos a
				LEFT JOIN tipos_impostos b ON a.tarq_id = b.imp_id
				LEFT JOIN doc_recebidos c ON a.tarq_id = c.drec_docId
				LEFT JOIN entrada_docs d ON c.drec_entId = d.doc_id
				JOIN departamentos e ON e.dep_id = b.imp_depto 
				WHERE b.imp_id IN(SELECT ob_titulo FROM obrigacoes WHERE ob_cod = ".$emp." and ob_depto = ".$_SESSION['dep'].")
				AND a.tarq_id NOT IN (SELECT drec_docId FROM doc_recebidos WHERE drec_empCod = ".$emp." AND drec_compet='".$ref."')
				-- AND d.doc_cli = 141 
   			GROUP BY a.tarq_id;";
	*/
   	$sql1 = "SELECT a.tarq_id, a.tarq_nome, a.tarq_formato, a.tarq_depart, b.cliarq_detalhes FROM tipos_arquivos a
	JOIN clientes_arquivos b 	ON b.cliarq_arqId = a.tarq_id
	JOIN tri_clientes c			ON c.cod = b.cliarq_empresa
	-- LEFT JOIN tipos_impostos d 		ON d.imp_tdocId = a.tarq_id
	WHERE a.tarq_id NOT IN (SELECT doc_tipo FROM entrada_docs WHERE doc_cli = {$emp} AND doc_ref='{$ref}')
	AND c.cod = {$emp}
	";
	if(isset($dep) && $dep <>""){
		$sql1.= " AND tarq_depart = ".$dep;
	}
	$sql1.=" GROUP BY cliarq_id ORDER BY tarq_nome ASC";
	$rs->FreeSql($sql1);
	//echo $rs->sql;

	if($rs->linhas==0):
	echo "<tr><td colspan=7> Nenhum documento...</td></tr>";
	else:
		$regs = $rs->linhas;
		while($rs->GeraDados()){
			$det = ($rs->fld("cliarq_detalhes")==NULL?'':'['.$rs->fld("cliarq_detalhes").']');
			?>
			<tr>
				<td><span data-toggle='tooltip' data-placement='bottom' title='<?=$rs->fld("tarq_nome");?>'><?=$rs->fld("tarq_nome")." ".$det;?></span></td>
				<td><span data-toggle='tooltip' data-placement='bottom' title='<?=$rs->fld("tarq_nome");?>'><?=$rs->fld("tarq_formato");?></span></td>
				<td>
					<a  class='btn btn-xs btn-success'
						onclick = "receber_docext('<?=$rs->fld('tarq_id');?>',$('#sel_emp').val(),'<?=$_SESSION["usu_cod"];?>','<?=$rs->fld("tarq_depart");?>','E-mail','<?=$_SESSION['usuario'];?>',$('#doc_ref').val());"
						title='E-mail'>
						<i class='fa fa-envelope'></i> 
					</a>
					<a  class='btn btn-xs btn-warning hidden-sm'
						onclick = "receber_docext('<?=$rs->fld('tarq_id');?>',$('#sel_emp').val(),'<?=$_SESSION["usu_cod"];?>','<?=$rs->fld("tarq_depart");?>','BOX-e/SIEG','Arquivos em Nuvem',$('#doc_ref').val());"
						title='Box-e/SIEG'>
						<i class='fa fa-inbox'></i>
					</a>
					<a  class='btn btn-xs btn-info hidden-sm'
						onclick = "receber_docext('<?=$rs->fld('tarq_id');?>',$('#sel_emp').val(),'<?=$_SESSION["usu_cod"];?>','<?=$rs->fld("tarq_depart");?>','OneDrive','',$('#doc_ref').val());"
						title='OneDrive'>
						<i class='fa fa-paperclip'></i> 
					</a>
				</td>
			</tr>
		<?php  
		}
		echo "<tr><td colspan=4><strong>".$rs->linhas." Documentos Faltando</strong></td></tr>";
	endif;		
	?>
</table>
<div id="consulta"></div>
<button id="bt_geraemail" class="btn btn-success btn-sm <?=($rs->linhas==0?"hide":"");?> ">
	<i class="fa fa-send"></i> Gerar Email
</button>
<script>
// Atualizar a cada 10 segundos
	 
	 setTimeout(function(){
		//$("#slc").load("vis_docs.php");		
		$("#alms").load(location.href+" #almsg");
	 },10500);

	 

	 // POPOVER
	$('[data-toggle="popover"]').popover();

</script>

			