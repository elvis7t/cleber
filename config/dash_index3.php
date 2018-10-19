<?php
session_start("portal");
require_once("../class/class.dashboard_novo_quadro.php");

$count = new dashboard();
$classe = $_SESSION['classe'];
$tipo_quadro = array(1=>"Metas_Atrib", 2=>"Metas_Real");

$n =  sizeof($count->niveis[$classe]);// Conta os elementos dentro do contador para a classe
?>
<!-- Main content -->
		<!-- Small boxes (Stat box) -->
        <div class="row">
        <?php
        	for($i=1; $i<=$n; $i++):
			
        		?>
				<div class="col-lg-<?=$count->niveis[$classe][$i]["tam"];?> col-xs-6">
					<div class="small-box <?=$count->niveis[$classe][$i]["cor"];?>">
						<div class="inner">
							<h3><?=$count->quadro($classe, $i, $tipo_quadro[$i]);?></h3>
							<p><?=$count->niveis[$classe][$i]["sub"];?></p>
						</div>
						<div class="icon">
							<i class="<?=$count->niveis[$classe][$i]["ico"];?>"></i>
						</div>
						<a href="<?=(isset($count->niveis[$classe][$i]['link'])?$count->niveis[$classe][$i]['link']:"#");?>" target="_blank" class="small-box-footer">
							More info <i class="fa fa-arrow-circle-right"></i>
						</a>
					</div>
				
				</div><!-- ./col -->
	    <?php endfor; ?>
<script>
setTimeout(function(){
	$("#alms").load(location.href+" #almsg");
	$("#counters").load("../config/dash_index3.php");		
 },7500);


</script>
            