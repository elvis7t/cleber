<?php
	session_start();
	require_once("../../model/recordset.php");
	require_once("../../sistema/class/class.functions.php");
	date_default_timezone_set("America/Sao_Paulo");
	$fn = new functions();
	$rs = new recordset();
	$rs2 = new recordset();
?>
	<table class="table table-striped">
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
<?php
	$token = (isset($_GET['token'])?$_GET['token']:$_SESSION['token']);
	$iplocal = getenv('REMOTE_ADDR');
	$sql = "SELECT * FROM maquinas a
				LEFT JOIN usuarios b ON a.maq_user = b.usu_cod
			WHERE 1";
				
	if($_SESSION['classe']<>1){
		$sql.=" AND maq_ip = '".$iplocal."'";
	}
	if(isset($_GET['ip']) AND $_GET['ip']<>"" ){ $sql.= " AND maq_ip = '".$_GET['ip']."'";}
	if(isset($_GET['user']) AND $_GET['user']<>"" ){ $sql.= " AND maq_user =".$_GET['user'];}
	if(isset($_GET['usuario']) AND $_GET['usuario']<>"" ){ $sql.= " AND maq_usuario ='".$_GET['usuario']."'";}
	
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
					<a id="bt_novoper" class="btn btn-xs btn-info" data-toggle='tooltip' data-placement='bottom' title='Gerenciar Periféricos' href="novo_periferico.php?token=<?=$_SESSION['token'];?>&maqid=<?=$rs->fld("maq_id");?>&perid=0"><i class="fa fa-keyboard-o"></i></a>
					<a class="btn btn-xs btn-warning" data-toggle='tooltip' data-placement='bottom' title='Alterar Usuário' href="maquinas.php?token=<?=$_GET['token'];?>&cnpj=<?=$_SESSION['usu_empresa'];?>&ip=<?=$rs->fld("maq_ip");?>"><i class="fa fa-user-plus"></i></a>
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
		echo "<tr><td colspan=9><strong>".$rs->linhas." Máquinas</strong></td></tr>";
	endif;		
	?>
</table>
<script src="<?=$hosted;?>/triangulo/js/functions.js"></script>
<script>
// Atualizar a cada 10 segundos
	 
	

	 /*------------------------|INICIA TOOLTIPS E POPOVERS|---------------------------------------*/
		$(function () {
			$('[data-toggle="tooltip"]').tooltip();
			$('[data-toggle="popover"]').popover({
		        html:true
		    });
		});


		setTimeout(function(){
			//$("#slc").load("vis_maquinas.php");		
			$("#alms").load(location.href+" #almsg");
		 },10500);

	

</script>


			