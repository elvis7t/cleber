
	<div class="box box-warning">
		<div class="box-header with-border">
			<h3 class="box-title"><i class="fa fa-bar-chart"></i> Progresso</h3>
			<div class="box-tools pull-right">
				<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
			</div>
		</div>
		<div class="box-body chart-responsive">
		<!--|INICIO DOS FILTROS|-->
			<div id="filtros">
				<?php 
					require_once("vis_filtrosprogress.php"); 
				?>
			</div>
		<!--|FINAL DOS FILTROS|-->
			<div id="graficos">
				<?php 
					require_once("vis_grafprogress.php"); 
				?>
			</div>
		</div><!-- /.box-body -->
	</div><!-- /.box -->
