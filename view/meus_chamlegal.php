<?php
	session_start("portal");
	require_once("../class/class.functions.php");
	require_once('../class/class.permissoes.php');

	date_default_timezone_set("America/Sao_Paulo");
	$fn = new functions();
	$rs = new recordset();
	$rs2 = new recordset();
	$per = new permissoes();
	$con = $per->getPermissao("cleg_vertodos", $_SESSION['usu_cod']);
	/* NESSA PERMISSÃO, OS PARAMETROS CONFIGURAM 
		C: Permite ver chamados para todos os usuários
		A: Permite ver chamados para todos os departamentos
		E: Permite atender um chamado aberto por si mesmo*/
?>
 	<table class="table table-striped table-condensed" id="tar_legal">
		<thead>
			<tr>
				<th>#</th>
				<th>Cliente</th>
				<th class="hidden-xs">Solic. por</th>
				<th class="hidden-xs">Solic. para</th>
				<th class="hidden-xs">Tratado por</th>
				<th class="hidden-xs">Progresso</th>
				<th class="hidden-xs">%</th>
				<th>Status</th>
				<th>Prazo</th>
				<th>A&ccedil;&otilde;es</th>
			</tr>	
		</thead>
		<tbody>
<?php
	$sql = "SELECT a.*, b.usu_nome nmb, c.usu_nome nmc, f.usu_nome nmf, d.st_desc, d.st_icone, e.apelido FROM chamados_legal a
				JOIN usuarios b 		ON a.cleg_solic = b.usu_cod
				JOIN usuarios f 		ON a.cleg_para = f.usu_cod
				LEFT JOIN usuarios c 	ON a.cleg_trat = c.usu_cod
				JOIN codstatus d 		ON d.st_codstatus = a.cleg_status
				JOIN tri_clientes e 		ON e.cod = a.cleg_empresa
			WHERE cleg_empvinc = ".$_SESSION['usu_empcod'];
			
	if($con['C']<>1){
		$sql.= " AND  (cleg_solic = ".$_SESSION['usu_cod']." OR (cleg_depto=".$_SESSION['dep']."";
		if($_SESSION['lider']<>'Y'){
			$sql.= " AND (cleg_para IN(0,".$_SESSION['usu_cod'].") OR cleg_trat IN(0,".$_SESSION['usu_cod'].")) ))";
		}
		else{ $sql.= "))";}
	}

	if($con['A']<>1){
		$sql.= " AND cleg_depto = ".$_SESSION['dep'];
	}
	
	/*-------------------------|ALTERAÇÃO|-------------------------*\
	|	Criando a condição para aprimorar a pesquisa caso 			|
	|	os filtros estejam vazios (entrada da página) 				|
	|	29.05.2018 - Cleber Marrara Prado 							|
	\*-------------------------------------------------------------*/
		// se os GETS forem setados, adiciona pesquisa por filtro
	if(isset($_GET['user']) && $_GET['user']<>""){ $sql.= " AND (cleg_para = '".$_GET['user']."' OR cleg_trat = '".$_GET['user']."')";}
	if(isset($_GET['dtini']) && $_GET['dtini']<>""){ 
		$sql.= " AND cleg_datafim >= '".$fn->data_usa($_GET['dtini'])."'";
	}
	else{
		$sql.= " AND yearweek(a.cleg_datafim) = yearweek(curdate())";
	}
	if(isset($_GET['dtfin']) && $_GET['dtfin']<>""){ $sql.= " AND cleg_datafim <= '".$fn->data_usa($_GET['dtfin'])."'";}
	if(isset($_GET['tarefa']) && $_GET['tarefa']<>""){ $sql.= " AND cleg_empresa = ".$_GET['tarefa'];}
	if(isset($_GET['status']) && $_GET['status']<>""){ $sql.= " AND cleg_status = 99";} else{ $sql.=" AND cleg_status<>99";}
	
	$sql .= " AND cleg_percent < 100 AND cleg_status <> 99";
	$sql.= " ORDER BY cleg_datafim ASC, cleg_status DESC, cleg_percent ASC";
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
	// Verificar datas para colorir caso esteja em atraso
		$total = 0;
		while($rs->GeraDados()){
			$date1 = date_create(date("Y-m-d"));
			$date2 = date_create($rs->fld("cleg_datafim"));
			$color="";
			if($date1==$date2){ $color="warning";}
			else{ if($date1>$date2){ $color="danger";}}

			//echo $color;

			$total += $rs->fld("cleg_percent");
			?>
			<tr class="<?=$color;?>">
				<td><?=str_pad($rs->fld('cleg_id'),2,"0",STR_PAD_LEFT);?></td>
				<td><?=$rs->fld("apelido");?></td>
				<td class="hidden-xs"><?=$rs->fld("nmb");?></td>
				<td class="hidden-xs"><?=$rs->fld("nmf");?></td>
				<td class="hidden-xs"><?=$rs->fld("nmc");?></td>
				<td class="hidden-xs">
					<div class="progress progress-xs">
                    <div class="progress-bar progress-bar-<?=$fn->getColor($rs->fld("cleg_percent"));?>" style="width: <?=$rs->fld("cleg_percent");?>%" role="progressbar" aria-valuenow="<?=$rs->fld("cleg_percent");?>" aria-valuemin="0" aria-valuemax="100">
                    </div>

				</td>
				
				<td>
					<span class="badge bg-<?=$fn->getColor($rs->fld("cleg_percent"),"bd");?>">
						<?=$rs->fld("cleg_percent");?>%
					</span>
				</td>

				<td align="middle"><i title='<?=$rs->fld("st_desc");?>' class='<?=$rs->fld("st_icone");?>'></i></td>
				<td class="hidden-xs"><?=$fn->data_br($rs->fld("cleg_datafim"));?></td>
				<td class="">
					<?php
						if( $con['E']==1 OR $rs->fld('cleg_status')<>0){
						?>
					
						<a 	href="atendimento_legal.php?token=<?=$_SESSION['token'];?>&chamado=<?=$rs->fld('cleg_id');?>&acao=0"
								class="btn btn-xs btn-info"
								data-toggle='tooltip' 
								 data-placement='bottom' 
								 title='Ver Chamado'><i class="fa fa-search"></i>
						</a>
						<?php
						}
					?>
					<?php
						if($rs->fld('cleg_status')==0){
						?>
						<a 	href="atendimento_legal.php?token=<?=$_SESSION['token'];?>&chamado=<?=$rs->fld('cleg_id');?>&acao=1"
							class="btn btn-xs btn-primary"
							 data-toggle='tooltip' 
							 data-placement='bottom' 
							 title='Atender'><i class="fa fa-edit"></i></a>
						<?php
						}
					?>
					
				</td>
			</tr>

			
		<?php  
		}
		
	endif;		
	
	?>
	</tbody>
</table>
<?php
if($rs->linhas > 0 ):
	$media = number_format($total / $rs->linhas,0);
	?>
    <div class="progress progress-md">
        <div class="progress-bar progress-bar-<?=$fn->getColor($media,"pb");?>" style="width: <?=$media;?>%" role="progressbar" aria-valuenow="<?=$media;?>" aria-valuemin="0" aria-valuemax="100">
        	<span class=""><?=number_format($media,2)."% (".($media==100?"Completo":"Em processo").")";?></span>
    	</div>
    </div>
<?php
endif;
?>

<script src="<?=$hosted;?>/sistema/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>	
<script src="<?=$hosted;?>/sistema/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/datatables/dataTables.bootstrap.min.js"></script> 

<script>
	$(document).ready(function(){
		$('#tar_legal').DataTable({
			"order": [[ 8, "asc" ],[0,"asc"]],
			"columnDefs": [{
			"defaultContent": "-",
			"targets": "_all",
			}]
		});
	});


	$(function () {
		$('[data-toggle="tooltip"]').tooltip();
		$('[data-toggle="popover"]').popover();
	});

	setTimeout(function(){
		//$("#slc").load("meus_chamados.php");		
		$("#alms").load(location.href+" #almsg");
	},10500);
</script>
