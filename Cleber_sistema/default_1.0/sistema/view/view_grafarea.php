
	<div class="box box-danger">
		<div class="box-header with-border">
			<h3 class="box-title"><i class="fa fa-area-chart"></i> Produtividade</h3>
			<div class="box-tools pull-right">
				<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
			</div>
		</div>
		<div class="box-body chart-responsive">
		<!--|INICIO DOS FILTROS|-->
			<div id="filtros">
				<?php 
					require_once("vis_filtrosarea.php"); 
				?>
			</div>
		<!--|FINAL DOS FILTROS|-->
			<div id="areachart">
				<?php 
					require_once("vis_prodarea.php"); 
				?>
			</div>
		</div><!-- /.box-body -->
	</div><!-- /.box -->
