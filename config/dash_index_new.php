<?php
error_reporting(E_ALL & E_NOTICE & E_WARNING);
session_start("portal");
require_once("../class/class_newdashboard.php");
require_once("../class/class.permissoes.php");

$dash = new dashboard();
$rs = new recordset();
$per = new permissoes();
$con = $per->getPermissao("quadros_lider",$_SESSION['usu_cod']);
$comp = (isset($_GET['compet'])?$_GET['compet']:date('m/Y', strtotime("- 1 month")));

$cont2 = json_decode($rs->pegar("usu_contagens","usuarios","usu_cod=".$_SESSION['usu_cod']),true);
if(empty($cont2)){
	// Contagens Padrão
	$cont = array(
				1=>array("id_imp"=>57,	"tamanho"=>3, "cor"=>"bg-aqua",			"icone"=>"fa fa-suitcase"),
				2=>array("id_imp"=>147,	"tamanho"=>3, "cor"=>"bg-green", 		"icone"=>"fa fa-tag"),
				3=>array("id_imp"=>60,	"tamanho"=>3, "cor"=>"bg-yellow", 		"icone"=>"fa fa-gear"),
				4=>array("id_imp"=>59,	"tamanho"=>3, "cor"=>"bg-red", 			"icone"=>"fa fa-globe"),
				5=>array("id_imp"=>140,	"tamanho"=>4, "cor"=>"bg-blue", 		"icone"=>"fa fa-balance-scale"),
				6=>array("id_imp"=>114,	"tamanho"=>4, "cor"=>"bg-orange", 		"icone"=>"fa fa-calendar-check-o"),
				7=>array("id_imp"=>115,	"tamanho"=>4, "cor"=>"bg-olive", 		"icone"=>"fa fa-file-excel-o"),
			);
}
else{
	$cont = $cont2;
}
//echo $rs->pegar("usu_contagens","usuarios","usu_cod=".$_SESSION['usu_cod']);
?>
<div class="row">
<?php
foreach ($cont as $value) {
		$compet = date('m/Y', strtotime("-1 month"));
		$vlr = $dash->count_imposto($value['id_imp'], $_SESSION['dep'], $_SESSION['usu_cod'], $con['C'], $comp);
		?>
		<a href="javascript:ref(<?=$value['id_imp'];?>, '<?=$compet;?>');" style="display:block;">
			<div class="col-lg-<?=$value['tamanho'];?> col-xs-6">
				<div class="info-box <?=$value['cor'];?>" data-imposto="<?=$value['id_imp'];?>">
					
					<span class="info-box-icon"><i class="<?=$value['icone'];?>"></i></span>
					<div class="info-box-content">
						<span class="info-box-text"><?=$vlr['imposto'];?></span>
						<span class="info-box-number"><?=$vlr['real'];?>
							
						</span>
						<div class="progress">
							<?php
							$n = $vlr['real']/$vlr['meta']*100;
							?>
							<div class="progress-bar" style="width: <?=$n;?>%"></div>
						</div>
						<span class="progress-description">
							de <?=$vlr['meta'];?> (<?=number_format($n,2,".",",");?>%)
						</span>
					</div>
				</div>
			</div>
		</a>
<?php }
?>
</div>
	
<script>
$(document).ready(function(){
	setTimeout(function(){
		$("#alms").load(location.href+" #almsg");
		//$("#counters").load("../config/dash_index_new.php");		
	},7500);
});

function ref(imposto, compet){
	$("#sel_imp").select2("val",imposto);
	$("#sel_comp").val(compet);
	$("#btn_pesqImp").trigger("click");

}

</script>
            