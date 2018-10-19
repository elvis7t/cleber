<?php
$enviados 	= $rs2->pegar("count(mds_id)","maildocumento","mds_status=1");
$rascunho 	= $rs2->pegar("count(mds_id)","maildocumento","mds_status=2");
$cxsaida 	= $rs2->pegar("count(mds_id)","maildocumento","mds_status=0");

$status = 1;
$comp = "";

if(isset($_GET['st'])){
	$status = $_GET['st'];
}

if(isset($_GET['comp'])){
	$comp = $_GET['comp'];
}


?>

<div class="col-md-3">
	<!--<a href="compose.html" class="btn btn-primary btn-block margin-bottom">Compose</a>-->
	<div class="box box-solid">
		<div class="box-header with-border">
			<h3 class="box-title">Pastas</h3>
			<div class="box-tools">
				<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
			</div>
		</div>
		<div class="box-body no-padding">
			<ul class="nav nav-pills nav-stacked">
				<li class="<?=($status==1?"active":"");?>">
					<a href="view_docsmail.php?token=<?=$_SESSION['token'];?>&st=1">
						<i class="fa fa-envelope-o"></i> Enviados 
						<span class="label label-primary pull-right"><?=$enviados?></span>
					</a>
				</li>
				
				<?php
					$sql = "SELECT DISTINCT(mds_comp)as competencia FROM maildocumento";
					$rs->FreeSql($sql);
					while($rs->GeraDados()){
						?>
						<li class="<?=($comp==$rs->fld("competencia")?"active":"");?>">
							<a href="view_docsmail.php?token=<?=$_SESSION['token'];?>&comp=<?=$rs->fld("competencia");?>">
								<i class="fa fa-calendar"></i> <?=$rs->fld("competencia");?> 
								<span class="label label-primary pull-right"><?=$rs2->pegar("count(mds_id)","maildocumento","mds_comp='".$rs->fld("competencia")."'");?></span>
							</a>
						</li>
						<?php		
					}
				?>

				<li class="<?=($status==2?"active":"");?>">
					<a href="view_docsmail.php?token=<?=$_SESSION['token'];?>&st=2">
						<i class="fa fa-pencil"></i> Rascunhos 
						<span class="label label-primary pull-right"><?=$rascunho;?></span>
					</a>
				</li>

				<li class="<?=($status==0?"active":"");?>">
					<a href="view_docsmail.php?token=<?=$_SESSION['token'];?>&st=0">
						<i class="fa fa-send"></i> Caixa de Sa&iacute;da 
						<span class="label label-primary pull-right"><?=$cxsaida;?></span>
					</a>
				</li>
			</ul>
		</div><!-- /.box-body -->
	</div><!-- /. box -->
</div><!-- /.col -->