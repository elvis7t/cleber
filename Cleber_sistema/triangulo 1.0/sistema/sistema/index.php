<?php
session_start();
if(!isset($_SESSION['nome_usu'])){
	header("location:view/login.php");
}
/*inclusão dos principais itens da página */
require_once("config/main.php");
require_once("config/mnutop.php");
//require_once("config/valida.php");
$sec = "home";
require_once("config/menu.php");
?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header" id="contagens">
			<h1>
				Dashboard
				<small>Painel</small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active">Dashboard</li>
			</ol>
			<? require_once("config/dash_index.php");?>
        </section>
        <section class="content" id="linha_do_tempo">
			<div class="row">	
				<div class="col-md-6 connectedSortable">
					<div class="box box-info collapsed-box">
						<div class="box-header with-border">
							<h3>
								Hist&oacute;rico
								<small>Linha do tempo</small>
							</h3>
							<div class="box-tools pull-right">
								<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
							</div><!-- /.box-tools -->
						</div><!--./box-header -->
						<div class="box-body">
							<? require_once("view/time_line.php");?>
						</div><!--./box-body -->	
					</div><!-- ./box -->
				</div><!-- ./md-6 -->
			
				<div class="col-md-6 connectedSortable">
				
				</div><!-- ./md-6 -->
			
			</div><!--./row-->
			
        </section>
		

		
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <? 
	  require_once("config/footer.php");
	  require_once("config/sidebar.php");
	  ?>    </div><!-- ./wrapper -->
</div><!-- /.row -->
		
	<!-- Main row -->

<?
require_once("config/bottompage.php");
?>