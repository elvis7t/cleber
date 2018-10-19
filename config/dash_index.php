<?php
require_once("../class/class.dashboard.php");
$count = new dashboard();

?>
<!-- Main content -->
		<!-- Small boxes (Stat box) -->
        <div class="row">
		<?php
		//DASHBOARD NÍVEL 100%
		if($_SESSION['classe']==1):?>
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
							Clientes Cadastrados
						</span>
					</div><!-- /.info-box-content -->
				</div><!-- /.info-box -->	
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
				<!-- small box -->
				
				<div class="info-box bg-green">
					<span class="info-box-icon"><i class="fa fa-file-o"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">IRPF</span>
						<span class="info-box-number"><?=$count->contagens("impostos");?></span>
						<div class="progress">
						<div class="progress-bar" style="width: 100%"></div>
						</div>
						<span class="progress-description">
							Declara&ccedil;&otilde;es
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
						<span class="info-box-number">
							<?php
								//echo $count->quadro(5,3);
								echo $count->contagens("usuarios");
								?>
							</span>
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
			<?php endif;
			// DASHBOARD NIVEL 2
			
			// DASHBOARD NÍVEL 3
			if($_SESSION['classe']>=3):
			?>
			<div class="col-lg-9 col-xs-9">
				<!-- small box -->
				<div class="info-box bg-green">
					<span class="info-box-icon"><i class="fa fa-suitcase"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">Clientes</span>
						<span class="info-box-number">
							<?php
								echo $count->carteira($_SESSION['usu_cod'],$_SESSION['dep']);
							?>
						</span>
						<div class="progress">
						<div class="progress-bar" style="width: 100%"></div>
						</div>
						<span class="progress-description">
							Carteira de Clientes
						</span>
					</div><!-- /.info-box-content -->
				</div><!-- /.info-box -->
			</div><!-- ./col -->
			<div class="col-lg-3 col-xs-3">
				<!-- small box -->
				
				<div class="info-box bg-yellow">
					<span class="info-box-icon"><i class="fa fa-expeditedssl"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">Acessos</span>
						<span class="info-box-number">
							<?php
								echo $count->acessos($_SESSION['usuario']);
							?>
						</span>
						<div class="progress">
						<div class="progress-bar" style="width: 100%"></div>
						</div>
						<span class="progress-description">
							Acessos ao Portal
						</span>
					</div><!-- /.info-box-content -->
				</div><!-- /.info-box -->
				
			</div><!-- ./col -->
			
		</div><!--.row -->
		<div class="row">
			<div class="col-lg-3 col-xs-3">
				<!-- small box -->
				<div class="info-box bg-blue">
					<span class="info-box-icon"><i class="fa fa-refresh"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">Simples Nacional</span>
						<span class="info-box-number">
							<?php
								echo $count->tribut("SN",$_SESSION['usu_cod'],$_SESSION['dep']);
							?>
						</span>
						<div class="progress">
						<div class="progress-bar" style="width: 100%"></div>
						</div>
						<span class="progress-description">
							Clientes Simples Nac.
						</span>
					</div><!-- /.info-box-content -->
				</div><!-- /.info-box -->
			</div><!-- ./col -->
			<div class="col-lg-3 col-xs-3">
				<!-- small box -->
				<div class="info-box bg-red">
					<span class="info-box-icon"><i class="fa fa-money"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">Lucro Real</span>
						<span class="info-box-number">
							<?php
								echo $count->tribut("LR",$_SESSION['usu_cod'],$_SESSION['dep']);
							?>
						</span>
						<div class="progress">
						<div class="progress-bar" style="width: 100%"></div>
						</div>
						<span class="progress-description">
							Clientes Lucro Real
						</span>
					</div><!-- /.info-box-content -->
				</div><!-- /.info-box -->
			</div><!-- ./col -->
			<div class="col-lg-3 col-xs-3">
				<!-- small box -->
				<div class="info-box bg-purple">
					<span class="info-box-icon"><i class="fa fa-tags"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">Lucro Presumido</span>
						<span class="info-box-number">
							<?php
								echo $count->tribut("LP",$_SESSION['usu_cod'],$_SESSION['dep']);
							?>
						</span>
						<div class="progress">
						<div class="progress-bar" style="width: 100%"></div>
						</div>
						<span class="progress-description">
							Clientes Lucro Presumido
						</span>
					</div><!-- /.info-box-content -->
				</div><!-- /.info-box -->
			</div><!-- ./col -->
		</div>
		<?php endif; ?>
		