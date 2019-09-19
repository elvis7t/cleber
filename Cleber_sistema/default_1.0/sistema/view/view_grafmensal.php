
	<div class="box box-info">
		<div class="box-header with-border">
			<h3 class="box-title"><i class="fa fa-check-circle"></i> Mensal Empresas</h3>
			<div class="box-tools pull-right">
				<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
			</div>
		</div>
		<div class="box-body chart-responsive">
		<!--|INICIO DOS FILTROS|-->
			<div id="filtros">
				<?php 
					require_once("vis_filtrosmensal.php"); 
				?>
			</div>
		<!--|FINAL DOS FILTROS|-->
			<div id="graficos">
				<?php 
					require_once("vis_prodmensal.php"); 
				?>
			</div>
		</div><!-- /.box-body -->
	</div><!-- /.box -->
