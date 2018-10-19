<?php
	//sujeira embaixo do tapete :(
	error_reporting(E_ALL & E_NOTICE & E_WARNING);

	session_start();
	require_once("../model/recordset.php");
	require_once("../class/class.functions.php");
	date_default_timezone_set("America/Sao_Paulo");
	$fn = new functions();
	$rs = new recordset();
	$rs2 = new recordset();
?>
	<table class="table table-striped table-condensed" id="vismachines">
		<thead>
			<tr>
				<th>#</th>
				<th class="hidden-xs">IP</th>
				<th class="hidden-xs">Login</th>
				<th class="hidden-xs">Usuário</th>
				<th class="hidden-xs">Sistema</th>
				<th>Memória</th>
				<th>HD</th>
				<th>Tipo</th>
				<th>Ativa</th>
				<th>A&ccedil;&otilde;es</th>
			</tr>	
		</thead>
		<tbody>	
<?php
	$token = (isset($_GET['token'])?$_GET['token']:$_SESSION['token']);
	$iplocal = getenv('REMOTE_ADDR');
	$sql = "SELECT * FROM maquinas a
				LEFT JOIN usuarios b ON a.maq_user = b.usu_cod
			WHERE maq_empvinc=".$_SESSION['usu_empcod'];
				
	if($_SESSION['classe']<>1){
		$sql.=" AND maq_ip = '".$iplocal."'";
	}
	if(isset($_GET['ip']) AND $_GET['ip']<>"" ){ $sql.= " AND maq_ip = '".$_GET['ip']."'";}
	if(isset($_GET['user']) AND $_GET['user']<>"" ){ $sql.= " AND maq_user =".$_GET['user'];}
	if(isset($_GET['usuario']) AND $_GET['usuario']<>"" ){ $sql.= " AND maq_usuario ='".$_GET['usuario']."'";}
	$sql.= " ORDER BY maq_usuario ASC";
	$rs->FreeSql($sql);
	//echo $rs->sql;
	if($rs->linhas==0):
	echo "<tr><td colspan=9> Nenhuma Máquina</td></tr>";
	else:
		while($rs->GeraDados()){ ?>
			
			<tr>
				<td><?=$rs->fld("maq_id");?></td>
				<td class="hidden-xs"><?=$rs->fld("maq_ip");?></td>
				<td class="hidden-xs"><?=$rs->fld("maq_usuario");?></td>
				<td class="hidden-xs"><?=$rs->fld("usu_nome");?></td>
				<td class="hidden-xs"><?=$rs->fld("maq_sistema");?></td>
				<td><?=$rs->fld("maq_memoria");?></td>
				<td><?=$rs->fld("maq_hd");?></td>
				<td><?=$rs->fld("maq_tipo");?></td>
				<td><?=($rs->fld("maq_ativa")==1?"Ativa":"Inativa");?></td>
				<td>
					<a class="btn btn-xs btn-primary" data-toggle='tooltip' data-placement='bottom' title='Alterar Equipamento' href="form_maquinas.php?token=<?=$_GET['token'];?>&cnpj=<?=$_SESSION['usu_empresa'];?>&ip=<?=$rs->fld("maq_ip");?>"><i class="fa fa-edit"></i></a>
					<a id="bt_novoper" class="btn btn-xs btn-success" data-toggle='tooltip' data-placement='bottom' title='Gerenciar Periféricos' href="novo_periferico.php?token=<?=$_SESSION['token'];?>&maqid=<?=$rs->fld("maq_id");?>&perid=0"><i class="fa fa-keyboard-o"></i></a>
					<?php 
					if($rs->fld("maq_ativa")==1): ?>
					<button id="bt_delmaq" class="btn btn-xs btn-danger" data-toggle='tooltip' data-placement='bottom' title='Inativar'><i class="fa fa-trash"></i></button>
					<?php else: ?>
					<button id="bt_atvmaq" class="btn btn-xs btn-success" data-toggle='tooltip' data-placement='bottom' title='Ativar'><i class="fa fa-plug"></i></button>
					<?php
					endif;
					?>
				</td>
				
				
			</tr>
		<?php  
		}
	endif;		
	?>
	</tbody>
</table>
<script src="<?=$hosted;?>/triangulo/js/functions.js"></script>

<script src="<?=$hosted;?>/sistema/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>	
<script src="<?=$hosted;?>/sistema/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/datatables/dataTables.bootstrap.min.js"></script> 
<script>
// Atualizar a cada 10 segundos
	$(function () {
		$('[data-toggle="tooltip"]').tooltip();
		$('[data-toggle="popover"]').popover({
	        html:true
	    });


		$('#vismachines').DataTable({
			"columnDefs": [{
			"defaultContent": "-",
			"targets": "_all"
			}]
		});
	});


	setTimeout(function(){
		//$("#slc").load("vis_maquinas.php");		
		$("#alms").load(location.href+" #almsg");
	 },10500);
</script>


			