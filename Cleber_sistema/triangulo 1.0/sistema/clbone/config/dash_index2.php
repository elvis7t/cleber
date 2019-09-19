<?php
require_once("../class/class.dashboard.php");
$count = new dashboard();
$classe = $_SESSION['classe'];
/*
echo $classe;
if($classe <=2 OR $classe >=8){$n = 7;}
else {$n = 6;}
*/
$n =  sizeof($count->niveis[$classe]);// Conta os elementos dentro do contador para a classe
?>
<!-- Main content -->
		<!-- Small boxes (Stat box) -->
        <div class="row">
        <?php
        	for($i=1; $i<=$n; $i++):?>
				<div class="col-lg-<?=$count->niveis[$classe][$i]["tam"];?> col-xs-6">
					<div class="small-box <?=$count->niveis[$classe][$i]["cor"];?>">
						<div class="inner">
							<h3><?=$count->quadro($classe,$i);?></h3>
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






					<!-- small box 
					<div class="info-box <?=$count->niveis[$classe][$i]["cor"];?>">
						<span class="info-box-icon"><i class="<?=$count->niveis[$classe][$i]["ico"];?>"></i></span>
						<div class="info-box-content">
							<span class="info-box-text"><?=$count->niveis[$classe][$i]["tit"];?></span>
							<span class="info-box-number"><?=$count->quadro($classe,$i);?></span>
							<div class="progress">
							<div class="progress-bar" style="width: 100%"></div>
							</div>
							<span class="progress-description">
								<?=$count->niveis[$classe][$i]["sub"];?>
							</span>
						</div><!-- /.info-box-content 
					</div><!-- /.info-box 	
	            </div><!-- ./col -->
	    <?php endfor; ?>
<script>
setTimeout(function(){
	$("#alms").load(location.href+" #almsg");
	$("#counters").load("../config/dash_index2.php");		
 },7500);


</script>
            