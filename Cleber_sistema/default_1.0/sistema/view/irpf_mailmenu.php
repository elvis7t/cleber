<?php
$enviados = $rs2->pegar("count(ims_id)","irpf_mailsender","ims_enviado=1");
$rascunho = $rs2->pegar("count(ims_id)","irpf_mailsender","ims_enviado=2");
$excluido = $rs2->pegar("count(ims_id)","irpf_mailsender","ims_enviado=3");
$cxsaida = $rs2->pegar("count(ims_id)","irpf_mailsender","ims_enviado=0");

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
				<li class="<?=($mailst==1?'active':'');?>">
					<a href="irpf_mail.php?token=<?=$_SESSION['token'];?>&mail_st=1">
						<i class="fa fa-envelope-o"></i> Enviados 
						<span class="label label-primary pull-right"><?=$enviados;?></span>
					</a>
				</li>
				<li class="<?=($mailst==2?'active':'');?>">
					<a href="irpf_mail.php?token=<?=$_SESSION['token'];?>&mail_st=2">
						<i class="fa fa-file-text-o"></i> Drafts 
						<span class="label label-primary pull-right"><?=$rascunho;?></span>
					</a>
				</li>
				<!-- caso coloque exclusão
				<li class="<?=($mailst==3?'active':'');?>">
					<a href="irpf_mail.php?token=<?=$_SESSION['token'];?>&mail_st=3">
						<i class="fa fa-trash-o"></i> Trash 
						<span class="label label-primary"><?=$excluido;?></span>
					</a>
				</li>
				-->
				<li class="<?=($mailst==0?'active':'');?>">
					<a href="irpf_mail.php?token=<?=$_SESSION['token'];?>&mail_st=0">
						<i class="fa fa-plane"></i> Caixa de Sa&iacute;da 
						<span class="label label-primary pull-right"><?=$cxsaida;?></span>
					</a>
				</li>
			</ul>
		</div><!-- /.box-body -->
	</div><!-- /. box -->
</div><!-- /.col -->