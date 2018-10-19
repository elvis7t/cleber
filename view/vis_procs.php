<?php
	//session_start();
	require_once("../config/main.php");

	require_once("../model/recordset.php");
	require_once("../class/class.functions.php");
	require_once('../class/class.permissoes.php');
	date_default_timezone_set("America/Sao_Paulo");
	$fn = new functions();
	$rs = new recordset();
	$rs2 = new recordset();
	$per = new permissoes();
?>
	<table class="table table-striped table-condensed" id="vis_procs">
		<thead>
			<tr>
				<th>#</th>
				<th>Processo</th>
				<th>Departamento</th>
				<th>Criado Por</th>
				<th>Criado em</th>
				<th>A&ccedil;&otilde;es</th>
			</tr>	
		</thead>
		<tbody>
<?php
	//$con = $per->getPermissao("ver_all_docs", $_SESSION["usu_cod"]);
	$sql1 = "SELECT * FROM listagens a
				JOIN usuarios b 	ON b.usu_cod = a.lista_criadopor
				JOIN departamentos c ON a.lista_depto = c.dep_id
				WHERE 1";

	/*
	if($con["C"]==0){
		$sql1.=" AND doc_dep=".$_SESSION['dep'];
	}
	*/
	//$sql1.= " AND doc_data BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-t")." 23:59:59' ORDER BY doc_status ASC, doc_data DESC";
	/*REGRAS DA PESQUISA */

	
	/*
	regra dos 7 dias:
	$sql1.= " AND doc_data BETWEEN curdate() - interval 5 day and curdate() + interval 2 day"
	*/
	$sql1.=" ORDER BY lista_desc ASC";	
	$rs->FreeSql($sql1);
	//echo $rs->sql;

	if($rs->linhas==0):
	echo "<tr><td colspan=7> Nenhum documento...</td></tr>";
	else:
		while($rs->GeraDados()){
			?>
			<tr>
				<td><?=$rs->fld("lista_id");?></td>
				<td><?=$rs->fld("lista_desc");?></td>
				<td><?=$rs->fld("dep_nome");?></td>
				<td><?=$rs->fld("usu_nome");?></td>
				<td><?=$fn->data_hbr($rs->fld("lista_data"));?></td>
				<td class="">
					
				</td>
			</tr>
		<?php  
		}
		
	endif;
	?>
	</tbody>
</table>

<!--datatables-->
<script src="<?=$hosted;?>/sistema/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/datatables/dataTables.bootstrap.min.js"></script>

<script type="text/javascript">

	$(document).ready(function () {
		$('#vis_procs').DataTable({
				"columnDefs": [{
    			"defaultContent": "-",
    			"targets": "_all"
			}]
		});
	});

// Atualizar a cada 10 segundos
	 
	 setTimeout(function(){
		//$("#slc").load("vis_docs.php");		
		$("#alms").load(location.href+" #almsg");
	 },10500);

	 

	 // POPOVER
	$('[data-toggle="popover"]').popover();

</script>

			