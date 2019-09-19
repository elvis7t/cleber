<?php
require_once("../class/class.dashboard.php");
$count = new dashboard();
$classe = $_SESSION['classe'];
//echo $classe;
if($classe <=2 OR $classe >=8){$n = 7;}
else {$n = 6;}
?>
<!-- Main content -->
		<!-- Small boxes (Stat box) -->
        <div class="row">
        <?php
        	for($i=1; $i<=$n; $i++):?>
				<div class="col-lg-<?=$count->niveis[$classe][$i]["tam"];?> col-xs-6">
					<!-- small box -->
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
						</div><!-- /.info-box-content -->
					</div><!-- /.info-box -->	
	            </div><!-- ./col -->
	    <?php endfor; ?>
<script>
setTimeout(function(){
	$("#counters").load("../config/dash_index2.php");		
 },7500);
</script>
            