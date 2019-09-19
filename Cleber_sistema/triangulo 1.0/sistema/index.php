<?php
/*----------------------------------------------------------------------\
|	index.php															|
|	Armazena informações da página inicial								|
\----------------------------------------------------------------------*/
$sessao = "Home";
require_once("config/main.php");
require_once("config/menu.php");
include_once("config/analyticstracking.php");
?>
			<section id="home">
				<div class="row">
					<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
						<!-- Indicators -->
						<ol class="carousel-indicators">
							<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
							<li data-target="#carousel-example-generic" data-slide-to="1"></li>
							<li data-target="#carousel-example-generic" data-slide-to="2"></li>
							<li data-target="#carousel-example-generic" data-slide-to="3"></li>
							<li data-target="#carousel-example-generic" data-slide-to="4"></li>
						</ol>

						<!-- Wrapper for slides -->
						<div class="carousel-inner" role="listbox">
							<div class="item active">
								<img src="images/equilibrio.jpg" alt="Em Construção">
								<div class="carousel-caption">
								Equilibrio na tomada de decis&otilde;es
								</div>
							</div>
							<div class="item">
								<img src="images/qualidade.jpg" alt="Em Construção">
								<div class="carousel-caption">
								Qualidade e rapidez na informa&ccedil;&atilde;o!
								</div>
							</div>
							
							<div class="item">
								<img src="images/leveza.jpg" alt="Em Construção">
								<div class="carousel-caption">
								Leveza na regulariza&ccedil;&atilde;o de sua empresa
								</div>
							</div>
							
							<div class="item">
								<img src="images/tecnologia.jpg" alt="Em Construção">
								<div class="carousel-caption">
								Tecnologia nas suas rotinas fiscais, cont&aacute;beis e financeiras
								</div>
							</div>
							
							<div class="item">
								<img src="images/analise.jpg" alt="Em Construção">
								<div class="carousel-caption">
								An&aacute;lise e consultoria Tribut&aacute;ria.
								</div>
							</div>
						</div>

						<!-- Controls -->
						<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
							<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
							<span class="sr-only">Previous</span>
						</a>
						<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
							<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
							<span class="sr-only">Next</span>
						</a>
					</div>
				
				</div>
			</section>
			
			<section id="service">
				<?php require_once("view/servicos.php");?>
			</section>
			
			<section id="quemsomos">
				<?php require_once("view/quemsomos.php");?>
			</section>
			
			<section id="contatos">
				<?php require_once("view/contatos.php");?>
			</section>
			
		</div>
	</div>
	</div>
	<div id="rodape">
		<div id="page-wrapper"></div>
		
			<div class="col-lg-3 col-md-3 col-sm-3">
				<br>			
				<img src="images/logo_Origem.png" width=200 class="img-responsive img-thumbnail"/>	
			</div>
			
			<div class="col-lg-3 col-md-3 col-sm-3">
				<div class="teb">
					<h3 class="text-white">Mapa do Site</h3>
				</div>
					<ul class="">
						<li class="teb"><a class="text-white" href="#home">Home</a></li>
						<li class="teb"><a class="text-white"  href="#service">Servi&ccedil;os</a></li>
						<li class="teb"><a class="text-white"  href="#quemsomos">Quem Somos</a></li>
						<li class="teb"><a class="text-white"  href="#contatos">Contato</a></li>
						<li><a class="text-white"  href="/sistema">Login</a></li>
					</ul>
			</div>
			
			<div class="col-lg-3 col-md-3 col-sm-3">
				<div class="teb">
					<h3 class="text-white">Contatos</h3>
				</div>
				<ul class="text-white">
					<li><i class="glyphicon glyphicon-envelope"></i> contato@priorecontabil.com.br</li>
					<li><i class="glyphicon glyphicon-phone"></i> (11)9 5317-8482 (msg)</li>
					<li><i class="glyphicon glyphicon-phone-alt"></i> (11)  2600-4044 (hot)</li>
					<li><i class="glyphicon glyphicon-modal-window"></i> <a href="#">Chat Online</a></li>
				</ul>
			</div>	
	</div>
	<div>
		<footer class="main-footer">
			<div class="pull-right hidden-xs">
				<b>Version</b> 1.0.0
			</div>
			<strong>Copyright &copy; 2015 <a href="http://www.priorecontabil.com.br">PRIORE</a>.</strong> Todos os Direitos Reservados. | Deus &eacute; minha prioridade
		</footer>
	</div>
</body>

</html>