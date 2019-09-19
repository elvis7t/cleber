<?php
/*---------|MENU_TOP.PHP|------------------*\
| @author:	Cleber Marrara Prado
| @contact:	cleber.marrara.prado@gmail.com
| @version:	1.0
| @date:	06-20-2016
\*-----------------------------------------*/
?>
<body>
	<section id="menu">
		<header class="clearfix">
			<div class="col-md-2">
				<div id="logo">
					<h1>
						<a href="<?=$hosted;?>/str/index.php">
							<img src="<?=$hosted;?>/str/images/logo.png" width="150" class="img-responsive"/>
						</a>
					</h1>
				</div>
			</div>
			<div class="col-md-10">
				<br><br><br>
				<div id="menu">
					<nav class="navbar navbar-default">
						<div class="container-fluid">
							<!-- Brand and toggle get grouped for better mobile display -->
							<div class="navbar-header">
								<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
									<span class="sr-only">Toggle navigation</span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
								</button>
							</div>
							<!-- Collect the nav links, forms, and other content for toggling -->
							<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
								<ul class="nav navbar-nav">
									<li class="active"><a class="page-scroll" href="#page-top">Home <span class="sr-only">(current)</span></a></li>
									<li><a class="page-scroll" href="#about">Quem Somos</a></li>
									<li class="dropdown">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Serviços <span class="caret"></span></a>
										<ul class="dropdown-menu">
											<li><a href="#">Action</a></li>
											<li><a href="#">Another action</a></li>
											<li><a href="#">Something else here</a></li>
											<li role="separator" class="divider"></li>
											<li><a href="#">Separated link</a></li>
											<li role="separator" class="divider"></li>
											<li><a href="#">One more separated link</a></li>
										</ul>
									</li>
									<li><a href="#">Notícias</a></li>
									<li><a href="#">Contatos</a></li>
									<li class="dropdown">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Sites <span class="caret"></span></a>
										<ul class="dropdown-menu">
											<li><a href="#">Action</a></li>
											<li><a href="#">Another action</a></li>
											<li><a href="#">Something else here</a></li>
											<li role="separator" class="divider"></li>
											<li><a href="#">Separated link</a></li>
											<li role="separator" class="divider"></li>
											<li><a href="#">One more separated link</a></li>
										</ul>
									</li>
								</ul>
									<form class="navbar-form navbar-left" role="search">
										<div class="input-group">
											<input type="text" class="form-control" placeholder="pesquisa">
											<span class="input-group-addon"><i class="fa fa-search"></i></span>
										</div>
										
									</form>
									<ul class="nav navbar-nav navbar-right">
										<li><a href="#">Atendimento</a></li>
										<!--
										<li class="dropdown">
											<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
											<ul class="dropdown-menu">
												<li><a href="#">Action</a></li>
												<li><a href="#">Another action</a></li>
												<li><a href="#">Something else here</a></li>
												<li role="separator" class="divider"></li>
												<li><a href="#">Separated link</a></li>
											</ul>
										</li>-->
									</ul>
								</div><!-- /.navbar-collapse -->
							</div><!-- /.container-fluid -->
					</nav>
				</div>
			</div>
		</header>
	</section>
	<hr>