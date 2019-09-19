<?
require_once("class/class.dashboard.php");
$count = new dashboard();

?>
<!-- Main content -->
		<!-- Small boxes (Stat box) -->
        <div class="row">
			<div class="col-lg-3 col-xs-6">
				<!-- small box -->
				<div class="info-box bg-aqua">
					<span class="info-box-icon"><i class="fa fa-briefcase"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">Empresas</span>
						<span class="info-box-number"><?=$count->contagens("empresas");?></span>
						<div class="progress">
						<div class="progress-bar" style="width: 100%"></div>
						</div>
						<span class="progress-description">
							Empresas Cadastradas
						</span>
					</div><!-- /.info-box-content -->
				</div><!-- /.info-box -->	
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
				<!-- small box -->
				
				<div class="info-box bg-green">
					<span class="info-box-icon"><i class="fa fa-cloud-upload"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">Uploads</span>
						<span class="info-box-number"><?=$count->contagens("documentos");?></span>
						<div class="progress">
						<div class="progress-bar" style="width: 100%"></div>
						</div>
						<span class="progress-description">
							Dispon&iacute;veis
						</span>
					</div><!-- /.info-box-content -->
				</div><!-- /.info-box -->
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
				<!-- small box -->
				
				<div class="info-box bg-purple">
					<span class="info-box-icon"><i class="fa fa-user-plus"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">Usu&aacute;rios Ativos</span>
						<span class="info-box-number"><?=$count->contagens("usuarios");?></span>
						<div class="progress">
						<div class="progress-bar" style="width: 100%"></div>
						</div>
						<span class="progress-description">
							
						</span>
					</div><!-- /.info-box-content -->
				</div><!-- /.info-box -->
				
			</div><!-- ./col -->
			<div class="col-lg-3 col-xs-6">
				<!-- small box -->
				
				<div class="info-box bg-yellow">
					<span class="info-box-icon"><i class="fa fa-expeditedssl"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">Acessos</span>
						<span class="info-box-number"><?=$count->contagens("login");?></span>
						<div class="progress">
						<div class="progress-bar" style="width: 100%"></div>
						</div>
						<span class="progress-description">
							
						</span>
					</div><!-- /.info-box-content -->
				</div><!-- /.info-box -->
				
			
			</div><!-- ./col -->
		</div><!--.row -->
		