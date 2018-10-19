<?php
	session_start("portal");
	require_once("../class/class.functions.php");
	date_default_timezone_set("America/Sao_Paulo");
	$fn = new functions();
	$rs = new recordset();
	$rs2 = new recordset();
	$pag = $_SERVER['SCRIPT_NAME'];
?>
	<table class="table table-striped">
		<tr>
			<th>#</th>
			<th>Tarefa</th>
			<th class="hidden-xs">Solic. por</th>
			<th class="hidden-xs">Tratado por</th>
			<th class="hidden-xs">Progresso</th>
			<th>Status</th>
			<th class="hidden-xs">Rate</th>
			<th>A&ccedil;&otilde;es</th>
		</tr>	
<?php
	$sql = "SELECT *, b.usu_nome nmb, c.usu_nome nmc, d.st_icone FROM chamados a
				JOIN usuarios b ON a.cham_solic = b.usu_cod
				LEFT JOIN usuarios c ON a.cham_trat = c.usu_cod
				JOIN codstatus d ON d.st_codstatus = a.cham_status
			WHERE cham_empvinc = ".$_SESSION['usu_empcod'];
	if($_SESSION['classe']<>1){
		$sql.= " AND  (cham_solic = ".$_SESSION['usu_cod']." OR (cham_dept=".$_SESSION['dep']."";
		if($_SESSION['lider']<>'Y'){
			$sql.= " AND cham_trat IN(0,".$_SESSION['usu_cod'].")))";
		}
		else{ $sql.= "))";}
	}
	/*-------------------------|ALTERAÇÃO|-------------------------*\
	|	Criando a condição para aprimorar a pesquisa caso 			|
	|	os filtros estejam vazios (entrada da página) 				|
	|	27.10.2016 - Cleber Marrara Prado 							|
	\*-------------------------------------------------------------*/
		// se os GETS forem setados, adiciona pesquisa por filtro
	if(isset($_GET['user']) && $_GET['user']<>""){ $sql.= " AND cham_solic = '".$_GET['user']."'";}
	if(isset($_GET['dtini']) && $_GET['dtini']<>""){ $sql.= " AND cham_abert >= '".$fn->data_usa($_GET['dtini'])." 00:00:00'";}
	if(isset($_GET['dtfim']) && $_GET['dtfim']<>""){ $sql.= " AND cham_abert <= '".$fn->data_usa($_GET['dtfim'])." 23:59:59'";}
	if(isset($_GET['tarefa']) && $_GET['tarefa']<>""){ $sql.= " AND cham_task like '%".$_GET['tarefa']."%'";}
	//if(isset($_GET['status']) && $_GET['status']<>""){ $sql.= "AND cham_status = 99";} else{ $sql.=" AND cham_status<>99";}
	
	$sql.= " AND cham_status=99 ORDER BY cham_tratfim DESC, cham_status DESC, cham_percent ASC";
	/*
	echo $sql;
	echo "<pre>";
	print_r($_SESSION);
	echo "</pre>";
	*/
	$rs->FreeSql($sql);
	
	if($rs->linhas==0):
	echo "<tr><td colspan=7> Nenhuma solicita&ccedil;&atilde;o...</td></tr>";
	else:
		$ta=0;
		$ac=0;
		while($rs->GeraDados()){
			$ta += $rs->fld("cham_aval");
			?>
			<tr>
				<td><?=$rs->fld('cham_id');?></td>
				<td><?=$rs->fld("cham_task");?></td>
				<td class="hidden-xs"><?=$rs->fld("nmb");?></td>
				<td class="hidden-xs"><?=$rs->fld("nmc");?></td>
				<td class="hidden-xs">
					<small class="pull-right"><?=$rs->fld("cham_percent");?>%</small>
                    <div class="progress progress-xs">
                    <div class="progress-bar progress-bar-<?=($rs->fld("cham_percent")<100?"red":"aqua");?>" style="width: <?=$rs->fld("cham_percent");?>%" role="progressbar" aria-valuenow="<?=$rs->fld("cham_percent");?>" aria-valuemin="0" aria-valuemax="100">
                    </div>
				</td>
				<td align="middle"><i title='<?=$rs->fld("st_desc");?>' class='<?=$rs->fld("st_icone");?>'></i></td>
			
				<td><?=number_format($rs->fld("cham_aval"),1,",",".");?> <i class="fa fa-star text-yellow"></i></td>
				<td class="">
					
					<a 	href="atendimento.php?token=<?=$_SESSION['token'];?>&chamado=<?=$rs->fld('cham_id');?>&acao=0"
							class="btn btn-xs btn-info"
							data-toggle='tooltip' 
							 data-placement='bottom' 
							 title='Ver Chamado'><i class="fa fa-search"></i>
					</a>
					
				</td>
			</tr>
		<?php  
		}
	endif;	
	$ac = ($rs->linhas==0?0:$ta / $rs->linhas);
	?>
	<tr>
		<td colspan=7></td><td><?=number_format($ac,1,",",".");?> <i class="fa fa-star text-yellow"></i></td>
		<td></td>
	</tr>
</table>
<script>
// Atualizar a cada 10 segundos
	 
	

	 /*------------------------|INICIA TOOLTIPS E POPOVERS|---------------------------------------*/
		$(function () {
			$('[data-toggle="tooltip"]').tooltip();
			$('[data-toggle="popover"]').popover();
		});


		setTimeout(function(){
			//$("#slc").load("meus_chamados.php");		
			$("#alms").load(location.href+" #almsg");
		 },10500);

	

</script>


			