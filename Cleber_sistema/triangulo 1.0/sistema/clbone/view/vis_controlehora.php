<?php
	session_start();
	require_once("../../model/recordset.php");
	require_once("../../sistema/class/class.functions.php");
	date_default_timezone_set("America/Sao_Paulo");
	$fn = new functions();
	$rs = new recordset();
	$rs2 = new recordset();
?>
	

	<table class="table table-striped" id="tab_horas">
		<tr>
			
			<th>Colaborador</th>
			<th>Data</th>
			<th>Sa&iacute;da</th>
			<th class="hidden-xs">Saldo</th>
			<th class="hidden-xs">Status</th>
			<th class="hidden-xs">Lanc.</th>
			<th class="hidden-xs">Dt Lanc.</th>
			<th class="hidden-xs">Aprov.</th>
			<th>A&ccedil;&otilde;es</th>
		</tr>	
<?php
	$sql = "SELECT a.*, b.usu_cod ucod, b.usu_nome nome_colab, c.usu_nome nome_cad, b.usu_classe, e.usu_nome nome_aprov, st_icone FROM controle_horas a
				JOIN usuarios b ON a.ch_colab = b.usu_cod
				JOIN usuarios c ON a.ch_usucad = c.usu_cod
				LEFT JOIN usuarios e ON a.ch_aprovadopor = e.usu_cod
				JOIN codstatus d ON a.ch_status = d.st_codstatus";
				
	if($_SESSION['classe']<=3){
		$sql.=" WHERE 1";
	}else{
		if($_SESSION['lider']=='Y'){$sql.=" WHERE b.usu_dep=".$_SESSION['dep'];}
		else{$sql.=" WHERE ch_colab=".$_SESSION['usu_cod'];}
	}
	if(isset($_GET['chr_dep'])){$sql.=" AND b.usu_dep =".$_GET['chr_dep'];}
	if(isset($_GET['chr_nome'])){$sql.=" AND b.usu_nome like '%".$_GET['chr_nome']."%'";}
	if(isset($_GET['chr_data'])){$sql.=" AND ch_data >= '".$fn->data_usa($_GET['chr_data'])."'";}
	if(isset($_GET['chr_dataf'])){$sql.=" AND ch_data <= '".$fn->data_usa($_GET['chr_dataf'])."'";}
	$sql.=" ORDER BY b.usu_dep ASC, ch_colab ASC, ch_data ASC";
	$rs->FreeSql($sql);
	//echo $rs->sql;
	//print_r($_GET);
	//echo $_SESSION['classe'];
	if($rs->linhas==0):
	echo "<tr><td colspan=7> Nenhuma solicita&ccedil;&atilde;o...</td></tr>";
	else:
		$soma = 0;
		$nome = "";			
		while($rs->GeraDados()){
			$dia = $fn->DiaDaSemana($rs->fld("ch_data"));
			$num = ($fn->hora_decimal($rs->fld("ch_hora_saida"))-($dia==6 ? 540 : 1020))/60;
			if($rs->fld("nome_colab")<>$nome AND $nome <> ""){ ?>
			<tr>
				<th><?=$nome;?></th>
				<th colspan=2>Total</th>
				<th><?=number_format($soma,2,",",".");?></th>
				<th colspan=5></th>
			</tr>
			<?php	
			$soma = 0;
			$soma += $num;
			$nome = "0";
			} else{
				if($rs->fld("ch_status")==101){
				$soma += $num;
				}
			}
			?>
			<tr>
				
				<td><?=$rs->fld("nome_colab");?></td>
				<td><?=$fn->data_br($rs->fld("ch_data"));?></td>
				<td><?=$rs->fld("ch_hora_saida");?></td>
				<td class="hidden-xs"><?=number_format($num,2,",",".");?></td>
				<td class="hidden-xs"><i class="<?=$rs->fld("st_icone");?>"></i></td>
				<td class="hidden-xs"><?=$rs->fld("nome_cad");?></td>
				<td class="hidden-xs"><?=$fn->data_hbr($rs->fld("ch_horacad"));?></td>
				<td class="hidden-xs"><?=$rs->fld("nome_aprov");?></td>
				<td>
					<?php 
					if(($rs->fld('ch_status')==100 && (($_SESSION['lider']=='Y' && $_SESSION['usu_cod']<>$rs->fld("ch_colab") || ($_SESSION['classe'])>$rs->fld("usu_classe") || $_SESSION['classe']<3)))){ ?>
						<a class="btn btn-xs btn-success" 
						data-toggle='tooltip' 
						data-placement='bottom' 
						title='Validar!' 
						id="bt_altch"
						href="javascript:baixa(<?=$rs->fld('ch_id');?>,'althoras','Deseja validar o apontamento');"><i class="fa fa-check"></i>
						</a> 
					<?php }
					if(($rs->fld("ucod")==$_SESSION['usu_cod'] AND $rs->fld("ch_status")<>90) OR $_SESSION['classe']==1 ){
					?>
					<a  class="btn btn-xs btn-danger" 
						data-toggle='tooltip' 
						data-placement='bottom' 
						title='Excluir' 
						id="bt_excch" 
						href="javascript:del(<?=$rs->fld('ch_id');?>,'excHoras','o apontamento');"><i class="fa fa-trash"></i></a> 
					<?php }
					?>
				</td>
	
			</tr>
		<?php
		$nome = $rs->fld("nome_colab");  
		}
		?>
			<tr>
				<th><?=$nome;?></th>
				<th colspan=2>Total</th>
				<th><?=number_format($soma,2,",",".");?></th>
				<th colspan=5></th>
			</tr>
		<?php 
		echo "<tr><td colspan=10><strong>".$rs->linhas." Apontamentos</strong></td></tr>";
	endif;		
	?>
</table>
<script>
 /*------------------------|INICIA TOOLTIPS E POPOVERS|---------------------------------------*/
	

	setTimeout(function(){
		//$("#slc").load("vis_controlehora.php");		
		$("#alms").load(location.href+" #almsg");
	 },10500);

	
</script>
<script src="<?=$hosted;?>/clbone/js/action_triang.js"></script>
<script src="<?=$hosted;?>/clbone/js/functions.js"></script>
