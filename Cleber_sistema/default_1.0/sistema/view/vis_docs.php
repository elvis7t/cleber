<?php
	session_start();
	require_once("../model/recordset.php");
	require_once("../class/class.functions.php");
	require_once('../class/class.permissoes.php');
	date_default_timezone_set("America/Sao_Paulo");
	$fn = new functions();
	$rs = new recordset();
	$rs2 = new recordset();
	$per = new permissoes();
?>
<!--
	<div class=" col-md-12">
		<form role="form" class="form form-inline" method="GET">
			<div class="form-group col-xs-3">
				Data Inicial:<br>
				<input type="text" name="di" class="form-control input-sm col-md-3" />
			</div>
			
			<div class="form-group col-xs-3">
				Data Final: <br>
				<input type="text" name="di" class="form-control input-sm col-md-3" />
			
			</div>
			<div class="form-group col-xs-3">
				<button type="submit" class="btn btn-info"><i class="fa fa-search"></i> Pesquisar</button>
			</div>					
		</form>
	</div>
-->	
	<table class="table table-striped">
		<tr>
			<th>#</th>
			<th>Empresa</th>
			<th>Tipo</th>
			<th>Departamento</th>
			<th>Respons&aacute;vel</th>
			<th>Recebido Por</th>
			<th>Recebido em</th>
			<th>A&ccedil;&otilde;es</th>
		</tr>	
<?php
	$con = $per->getPermissao("ver_all_docs", $_SESSION["usu_cod"]);
	$sql1 = "SELECT * FROM docs_entrada a
				JOIN codstatus b
					ON b.st_codstatus = a.doc_status
				JOIN tri_clientes c
					ON c.cod = a.doc_cli
				LEFT JOIN usuarios d 
					ON d.usu_cod = a.doc_resp
				JOIN departamentos e 
					ON e.dep_id = a.doc_dep
				JOIN tipos_doc f
					ON f.tdoc_id =  a.doc_tipo
				WHERE doc_empresa=".$_SESSION['usu_empcod'];

	if($con["C"]==0){
		$sql1.=" AND doc_dep=".$_SESSION['dep'];
	}
	//$sql1.= " AND doc_data BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-t")." 23:59:59' ORDER BY doc_status ASC, doc_data DESC";
	/*REGRAS DA PESQUISA */

	if(isset($_GET['di']) AND $_GET['di']<>""){$sql1.=" AND doc_data >='".$fn->data_usa($_GET['di'])." 00:00:00'";}
	else{$sql1.= " AND doc_data >='".date("Y-m")."-01 00:00:00'";}
	if(isset($_GET['df']) AND $_GET['df']<>""){$sql1.=" AND doc_data <='".$fn->data_usa($_GET['df'])." 23:59:59'";}
	else{$sql1.= " AND doc_data <='".date("Y-m-t")." 23:59:59'";}
	if(isset($_GET['depar']) AND $_GET['depar']<>""){$sql1.=" AND doc_dep =".$_GET['depar'];}
	if(isset($_GET['stat']) AND $_GET['stat']<>""){$sql1.=" AND doc_status ='".$_GET['stat']."'";}
	else{$sql1.=" AND doc_status=0";}

	/*
	regra dos 7 dias:
	$sql1.= " AND doc_data BETWEEN curdate() - interval 5 day and curdate() + interval 2 day"
	*/
	$sql1.=" ORDER BY doc_status ASC, doc_data DESC";	
	$rs->FreeSql($sql1);
	//echo $rs->sql;

	if($rs->linhas==0):
	echo "<tr><td colspan=7> Nenhum documento...</td></tr>";
	else:
		while($rs->GeraDados()){?>
			<tr>
				<td class="text-uppercase"><?=$rs->fld("doc_id");?></td>
				<td class="text-uppercase"><span data-toggle='tooltip' data-placement='bottom' title='<?=$rs->fld("apelido");?>'><?=(strlen($rs->fld("apelido"))>20 ? substr($rs->fld("apelido"),0,20)." ...":$rs->fld("apelido"));?></span></td>
				<td><span data-toggle='tooltip' data-placement='bottom' title='<?=$rs->fld("tdoc_tipo");?>'><?=$rs->fld("tdoc_tipo");?></span></td>
				<td><?=$rs->fld("dep_nome");?></td>
				<td><?=$rs->fld("usu_nome");?></td>
				<td><?=($rs->fld("doc_recpor")<>NULL ? $rs2->pegar("usu_nome","usuarios","usu_cod = ".$rs->fld("doc_recpor")):"");?></td>
				<td><?=($rs->fld("doc_datarec")==NULL ? $fn->data_hbr($rs->fld("doc_data")):$fn->calc_dh($rs->fld("doc_data"),$rs->fld("doc_datarec")));?>
				</td>
				<td class="">
					<a class='btn btn-xs btn-primary' data-toggle='popover' data-trigger="hover" data-placement='auto bottom' data-content="<?=$rs->fld("doc_obs");?>" title='Solicitante: <?=$rs->fld("usu_nome");?>'><i class='fa fa-book'></i> </a>
					<?php if($rs->fld("doc_status")<>99):?>
						<a class='btn btn-xs btn-success dlink' data-action="OK" data-solic="<?=$rs->fld("doc_id");?>" data-toggle='tooltip' data-placement='bottom' title='OK'><i class='fa fa-file-text'></i> </a>
						
					<?php endif; ?>
				</td>
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

			