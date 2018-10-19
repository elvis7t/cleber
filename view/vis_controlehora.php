<?php
session_start("portal");
require_once("../class/class.functions.php");
date_default_timezone_set("America/Sao_Paulo");
$fn = new functions();
$rs = new recordset();
$rs2 = new recordset();
require_once("../class/class.permissoes.php");

$per = new permissoes();
?>
	

	<table class="table table-striped" id="tab_horas">
		<thead>
			<tr>
				<th>Colaborador</th>
				<th>Data</th>
				<th>Entrada</th>
				<th>Sa&iacute;da</th>
				<th class="hidden-xs">Banco</th>
				<th class="hidden-xs">Status</th>
				<th class="hidden-xs">Lanc.</th>
				<th class="hidden-xs">Hor&aacute;rio</th>
				<th class="hidden-xs">Dt Lanc.</th>
				<th class="hidden-xs">Aprov.</th>
				<th>A&ccedil;&otilde;es</th>
			</tr>	
		</thead>
		<tbody>
<?php
	$sql = "SELECT a.*, b.usu_cod ucod, b.usu_nome nome_colab, c.usu_nome nome_cad, 
				   b.usu_classe, e.usu_nome nome_aprov, st_icone, f.horario_entrada, f.horario_saida, f.horario_nome
				FROM controle_horas a
					JOIN usuarios b ON a.ch_colab = b.usu_cod
					JOIN usuarios c ON a.ch_usucad = c.usu_cod
					JOIN codstatus d ON a.ch_status = d.st_codstatus 
					LEFT JOIN usuarios e ON a.ch_aprovadopor = e.usu_cod
					JOIN horarios f ON a.ch_horario = f.horario_id
				WHERE b.usu_empcod = ".$_SESSION['usu_empcod'];
				
	/*
		| ALTERAÇÃO - CLEBER MARRARA - 29.05.2017					|
		| Verificação da permissão (36) de todos os departamentos	|
		| para mostrar todos os departamentos.						|

	*/
	$dep = $per->getPermissao("controle_depart",$_SESSION['usu_cod']);
	if($dep['C']==0){$sql.=" AND b.usu_dep=".$_SESSION['dep'];}
	/*
		| ALTERAÇÃO - CLEBER MARRARA - 29.05.2017					|
		| Verificação da permissão (34) de todos os funcionários	|
		| para mostrar todos os usuários. 							|

	*/
	$pus = $per->getPermissao("todos_func",$_SESSION['usu_cod']);
	if($pus['C']==0){$sql.=" AND b.usu_cod=".$_SESSION['usu_cod'];}

	if(isset($_GET['chr_dep'])){$sql.=" AND b.usu_dep =".$_GET['chr_dep'];}
	if(isset($_GET['chr_nome'])){$sql.=" AND b.usu_nome like '%".$_GET['chr_nome']."%'";}
	if(isset($_GET['chr_data'])){$sql.=" AND ch_data >= '".$fn->data_usa($_GET['chr_data'])."'";}
	else{
		$sql.= " AND ch_data >= '".date("Y")."-01-01'";
	}
	if(isset($_GET['chr_dataf'])){$sql.=" AND ch_data <= '".$fn->data_usa($_GET['chr_dataf'])."'";}
	else{
		$sql.= " AND ch_data <= '".date("Y")."-12-31'";
	}
	
	
	$sql.=" ORDER BY b.usu_dep ASC, ch_colab ASC, ch_data ASC";
	$rs->FreeSql($sql);
	//echo $rs->sql;
	//print_r($_GET);
	//echo $_SESSION['classe'];
	if($rs->linhas==0):
	echo "<tr><td colspan=11> Nenhuma solicita&ccedil;&atilde;o...</td></tr>";
	else:
		$soma = 0;
		$nome = "";			
		while($rs->GeraDados()){
			$dia = $fn->DiaDaSemana($rs->fld("ch_data"));
			//$sai_ent = 1020;
			$sai_ent = $fn->hora_decimal($rs->fld("horario_saida"))+($fn->hora_decimal($rs->fld("ch_hora_entrada"))-$fn->hora_decimal($rs->fld("horario_entrada")));
			//$num = ($fn->hora_decimal($rs->fld("ch_hora_saida"))-($dia==6 ? 450 : 1020))/60;
			$num = ($fn->hora_decimal($rs->fld("ch_hora_saida"))-($dia==6 ? $fn->hora_decimal($rs->fld("ch_hora_entrada")) : $sai_ent))/60;
			if($rs->fld("nome_colab")<>$nome AND $nome <> ""){ ?>
			<tr>
				<th><?=$nome;?></th>
				<th colspan=2>Total</th>
				<th><?=number_format($soma,2,",",".");?></th>
				<th colspan=8></th>
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
				<td><?=$rs->fld("ch_hora_entrada");?></td>
				<td><?=$rs->fld("ch_hora_saida");?></td>
				<td class="hidden-xs"><?=number_format($num,2,",",".");?></td>
				<td class="hidden-xs"><i class="<?=$rs->fld("st_icone");?>"></i></td>
				<td class="hidden-xs"><?=$rs->fld("nome_cad");?></td>
				<td class="hidden-xs"><?=$rs->fld("horario_nome");?></td>
				<td class="hidden-xs"><?=$fn->data_hbr($rs->fld("ch_horacad"));?></td>
				<td class="hidden-xs"><?=$rs->fld("nome_aprov");?></td>
				<td>
					<?php
					$apr = $per->getPermissao("chora_aprova",$_SESSION['usu_cod']);
					
					//echo $rs->fld("usu_classe");
					if(
						// Hora status 100 - Aguardando Autorização e;
						($rs->fld('ch_status')==100 && (
							// permissão 38 - Aprovar Horas (C) e Classe usuário Maior do que a classe do usuario da hora
							($apr["A"]==1) && ($_SESSION['usu_cod']) <> $rs->fld("ucod")
							)
						)){ 
							?>
						<a class="btn btn-xs btn-success" 
						data-toggle='tooltip' 
						data-placement='bottom' 
						title='Validar!' 
						id="bt_altch"
						href="javascript:baixa(<?=$rs->fld('ch_id');?>,'althoras','Deseja validar o apontamento');"><i class="fa fa-check"></i>
						</a> 
					<?php }
					if(($rs->fld("ucod")==$_SESSION['usu_cod'] AND $rs->fld("ch_status")<>90) OR $apr["E"]==1){
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
				<th colspan=7></th>
			</tr>
		<?php 
		echo "<tr><td colspan=11><strong>".$rs->linhas." Apontamentos</strong></td></tr>";
	endif;		
	?>
	</tbody>
</table>
<script>
 /*------------------------|INICIA TOOLTIPS E POPOVERS|---------------------------------------*/
	

	setTimeout(function(){
		//$("#slc").load("vis_controlehora.php");		
		$("#alms").load(location.href+" #almsg");
	 },10500);

	
</script>
<script src="<?=$hosted;?>/sistema/js/action_triang.js"></script>
<script src="<?=$hosted;?>/sistema/js/functions.js"></script>
