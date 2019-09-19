
<?php
	require_once("../class/class.permissoes.php");
	//session_start();
	require_once("../model/recordset.php");
	require_once("../class/class.functions.php");
	date_default_timezone_set("America/Sao_Paulo");
	$fn = new functions();
	$rs = new recordset();
	$rs2 = new recordset();
$pag = "recalc.php";
$per = new permissoes();
$con = $per->getPermissao($pag);
$_hide = ($con['I']==0?"hide":"");
?>
	<table class="table table-striped">
		<tr>
			<th>Empresa</th>
			<th class="hidden-xs">Tipo Calc</th>
			<th class="hidden-xs">Solicitado Por</th>
			<th class="hidden-xs">Qtd</th>
			<th class="hidden-xs  <?=$_hide;?>">Valor Un.</th>
			<th class="hidden-xs  <?=$_hide;?>">Valor total</th>
			<th class="hidden-xs">Realizado Por</th>
			<th>Status</th>
			<th>A&ccedil;&otilde;es</th>
		</tr>	
<?php
	$sql = "SELECT m.*, a.calc_desc, b.apelido, c.usu_nome AS solic, d.usu_nome as efet, e.st_desc
			FROM recalculos m
				JOIN tipos_calc a ON m.rec_doc = a.calc_id 
				JOIN tri_clientes b ON m.rec_cli = b.cod
				LEFT JOIN usuarios c ON m.rec_user = c.usu_cod
				LEFT JOIN usuarios d ON m.rec_usuSol = d.usu_cod
				JOIN codstatus e ON m.rec_status = e.st_codstatus
				WHERE rec_emp = ".$_SESSION['usu_empcod'];
				
	if($_SESSION['classe']>=3 AND $_SESSION['classe']<8){
		$sql.=" AND rec_status<>90";
	}
	else{
		$sql.=" AND rec_id<>0";
	}
	if(isset($_GET['comp']) && $_GET['comp']<>0 ){
		$sql.=" AND rec_cli=".$_GET['comp'];
	}
	$sql .=" Order BY rec_data DESC, rec_id ASC";
	$rs->FreeSql($sql);
	if($rs->linhas==0):
	echo "<tr><td colspan=9> Nenhum calculo solicitado</td></tr>";
	else:
		$soma = 0;
		$valor = 0;
		while($rs->GeraDados()){ 
			$valor = $rs->fld("rec_qtd")*$rs->fld("rec_val");
			$soma += ($rs->fld("rec_status")==90?0:$valor);
			?>
			<tr>
				<td><?=$rs->fld("apelido");?></td>
				<td class="hidden-xs"><?=$rs->fld("calc_desc");?></td>
				<td class="hidden-xs"><?=$rs->fld("solic");?></td>
				<td class="hidden-xs"><?=$rs->fld("rec_qtd");?></td>
				<td class="hidden-xs  <?=$_hide;?>"><?="R$".number_format($rs->fld("rec_val"),2,",",".");?></td>
				<td class="hidden-xs  <?=$_hide;?>"><?="R$".number_format($valor,2,",",".");?></td>
				<td class="hidden-xs"><?=$rs->fld("efet");?></td>
				<td><?=$rs->fld("st_desc");?></td>
				<td class="">
					<?php
					if($rs->fld("rec_status")==0): ?>
						<a href="javascript:baixa('<?=$rs->fld("rec_id");?>','save_recalc','Deseja salvar o recálculo');" class="btn btn-xs btn-success" data-toggle='tooltip' data-placement='bottom' title='Efetuar'><i class="fa fa-check"></i></a>
						<a href="javascript:baixa('<?=$rs->fld("rec_id");?>','exc_recalc','Deseja realmente cancelar o recálculo');" class="btn btn-xs btn-danger" data-toggle='tooltip' data-placement='bottom' title='Cancelar'><i class="fa fa-times"></i></a>
					<?php endif; ?>
					<?php
					if($rs->fld("rec_status")==99): ?>
						<a href="javascript:baixa('<?=$rs->fld("rec_id");?>','fat_recalc','Deseja faturar o recálculo');" class="btn btn-xs btn-primary" data-toggle='tooltip' data-placement='bottom' title='Faturar'><i class="fa fa-money"></i></a>
					<?php endif; ?>

				</td>
			</tr>
		<?php  
		}
		if($_hide==""){
		echo "<tr><td colspan=3 align='right'><strong>Total:</strong></td><td colspan=4><strong>R$".number_format($soma,2,",",".")."</strong></td></tr>";
		}
		echo "<tr><td colspan=9><strong>".$rs->linhas." calculos Solicitados</strong></td></tr>";
	endif;
	/* DEBUG	
	echo "<pre>";
	print_r($_SESSION);
	echo "</pre>";
	*/
	?>
</table>
<script src="<?=$hosted;?>/js/functions.js"></script>
<script type="text/javascript">
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
			//$("#slc").load("vis_recalc.php");		
		 },7500);

	

</script>


			