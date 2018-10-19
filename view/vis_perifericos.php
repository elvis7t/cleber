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
	<input type="hidden" id="maqid" value="<?=(isset($_GET['maqid'])?$_GET['maqid']:"");?>"/>
	<table class="table table-striped">
		<tr>
			<th>#</th>
			<th class="hidden-xs">Tipo</th>
			<th class="hidden-xs">Modelo</th>
			<th class="hidden-xs">Na Máquina</th>
			<th>Status</th>
			<th>Dt Cad</th>
			<th>Usu Cad</th>
			<th>A&ccedil;&otilde;es</th>
		</tr>	
<?php
	$sql = "SELECT a.*, c.maq_id, c.maq_ip, b.usu_nome nmaq, d.usu_nome nus 
				FROM perifericos a 
				LEFT JOIN usuarios b ON a.per_usucad = b.usu_cod 
				LEFT JOIN maquinas c ON a.per_maqid = c.maq_id 
				LEFT JOIN usuarios d ON c.maq_user = d.usu_cod ";
		$sql.="WHERE per_empvinc=".$_SESSION['usu_empcod'];
	if(isset($_GET['maqid']) AND $_GET['maqid']<>""){$sql.=" AND per_maqid=".$_GET['maqid'];}
	if(isset($_GET['ip']) AND $_GET['ip']<>"" ){ $sql.= " AND maq_ip = '".$_GET['ip']."'";}
	if(isset($_GET['tipo']) AND $_GET['tipo']<>"" ){ $sql.= " AND per_tipo ='".$_GET['tipo']."'";}
	
	$sql .= " ORDER BY per_ativo DESC, per_modelo, per_tipo ASC, per_datacad ASC";
	$rs->FreeSql($sql);
	//echo $rs->sql;
	if($rs->linhas==0):
	echo "<tr><td colspan=9> Nenhum periférico</td></tr>";
	else:
		while($rs->GeraDados()){ ?>
			
			<tr>
				<td><?=$rs->fld("per_id");?></td>
				<td class="hidden-xs"><?=$rs->fld("per_tipo");?></td>
				<td class="hidden-xs"><?=$rs->fld("per_modelo");?></td>
				<td class="hidden-xs"><?=$rs->fld("nus");?></td>
				<td><?=($rs->fld("per_ativo")==1?"Ativo":"Inativo");?></td>
				<td><?=$fn->data_hbr($rs->fld("per_datacad"));?></td>
				<td><?=$rs->fld("nmaq");?></td>
				<td>
					<a id="bt_novoper" class="btn btn-xs btn-info" data-toggle='tooltip' data-placement='bottom' title='Gerenciar Periféricos' href="form_perif.php?token=<?=$_SESSION['token'];?>&maqid=<?=$rs->fld("maq_id");?>&perid=<?=$rs->fld("per_id");?>"><i class="fa fa-keyboard-o"></i></a>
					
					<?php 
					if($rs->fld("per_ativo")==1): ?>
					<button id="bt_delper" class="btn btn-xs btn-danger" data-toggle='tooltip' data-placement='bottom' title='Inativar'><i class="fa fa-trash"></i></button>
					<?php else: ?>
					<button id="bt_atvper" class="btn btn-xs btn-success" data-toggle='tooltip' data-placement='bottom' title='Ativar'><i class="fa fa-plug"></i></button>
					<?php
					endif;
					?>
				</td>
				
				
			</tr>
		<?php  
		}
		echo "<tr><td colspan=9><strong>".$rs->linhas." Periféricos</strong></td></tr>";
	endif;		
	?>
</table>
<script src="<?=$hosted;?>/sistema/js/functions.js"></script>
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
			$("#alms").load(location.href+" #almsg");
		 },10500);

	

</script>


			