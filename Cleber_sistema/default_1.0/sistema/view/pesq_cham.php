<div class="row">
	<div class="col-md-12">
		<div class="box box-success" id="firms">
			<div class="box-header with-border">
				<h3 class="box-title">Chamados</h3>
				<div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
			</div><!-- /.box-header -->
			<div id="slc" class="box-body">
				<table class="table table-striped">
					<tr>
						<th>#</th>
						<th>Tarefa</th>
						<th class="hidden-xs">Solic. por</th>
						<th class="hidden-xs">Tratado por</th>
						<th class="hidden-xs">Progresso</th>
						<th>Status</th>
						<th class="hidden-xs">SLA</th>
						<th>A&ccedil;&otilde;es</th>
					</tr>	
				<?php

				if($rs->linhas==0):
				echo "<tr><td colspan=7> Nenhuma solicita&ccedil;&atilde;o...</td></tr>";
				else:
					while($rs->GeraDados()){
						?>
						<tr>
							<td><?=$rs->fld('cham_id');?></td>
							<td><?=$rs->fld("cham_task");?></td>
							<td class="hidden-xs"><?=$rs->fld("nmb");?></td>
							<td class="hidden-xs"><?=$rs->fld("nmc");?></td>
							<td class="hidden-xs">
								<small class="pull-right"><?=$rs->fld("cham_percent");?>%</small>
			                    <div class="progress progress-xs">
			                    <div class="progress-bar progress-bar-<?=($rs->fld("cham_percent")<100?"red":"aqua");?>" style="width: <?=$rs->fld("cham_percent");?>%" role="progressbar" aria-valuenow="<?=$rs->fld("cham_percent");?>" aria-valuemin="0" aria-valuemax="100">
			                    </div>

							</td>
							<td><?=$rs->fld("st_desc");?></td>
							<td class="hidden-xs">
								<?php
								echo ($rs->fld("cham_tratfim")<>0?$fn->calc_dh($rs->fld("cham_tratini"), $rs->fld("cham_tratfim")):"-");
								?>	
							</td>
							<td class="">
								<a 	href="atendimento.php?token=<?=$_SESSION['token'];?>&chamado=<?=$rs->fld('cham_id');?>&acao=0"
										class="btn btn-xs btn-info"
										data-toggle='tooltip' 
										 data-placement='bottom' 
										 title='Ver Chamado'><i class="fa fa-search"></i>
								</a>
								
							</td>
						</tr>
					<?php  
					}
				endif;		
				?>
			</table>
		</div>
	</div>
</div>


<script>
// Atualizar a cada 10 segundos
	 
	

	 /*------------------------|INICIA TOOLTIPS E POPOVERS|---------------------------------------*/
		$(function () {
			$('[data-toggle="tooltip"]').tooltip();
			$('[data-toggle="popover"]').popover();
		});


		setTimeout(function(){
			//$("#slc").load("meus_chamados.php");		
			$("#alms").load(location.href+" #almsg");
		 },10500);

	

</script>


			