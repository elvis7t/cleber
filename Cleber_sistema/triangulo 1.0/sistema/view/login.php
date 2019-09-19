<?
session_start();
require_once("../config/sessions.php");
/*
echo "<pre>";
	print_r($_SESSION);
echo "</pre>";
*/
?>
<body class="hold-transition login-page">
    <div class="login-box">
		<div class="login-box-body">
			<div class="login-logo">
				<a href="<?=$_SESSION['dominio'];?>/sistema"><img src="<?=$_SESSION['dominio']."/".$_SESSION['logo'];?>" width="200"/></a>
			</div><!-- /.login-logo -->
			<p class="login-box-msg">Entre com seu usuário:</p>
			<form method="post" id="login">
				<div class="form-group has-feedback" id="email">
					<input data-type="email" class="form-control" id="lg_email" placeholder="Email">
					<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
				</div>
				<div class="form-group has-feedback" id="password">
					<input type="password" class="form-control" id="lg_password" placeholder="Password">
					<span class="glyphicon glyphicon-lock form-control-feedback"></span>
				</div>
				<div class="row">
					<div class="col-xs-8">
						<div class="checkbox icheck">
							<label>
								<input type="checkbox"> Mantenha-me conectado
							</label>
						</div>
					</div><!-- /.col -->
					<div class="col-xs-4">
						<button type="button" id="bt_entrar" class="btn btn-primary btn-block btn-flat">Entrar</button>
					</div><!-- /.col -->
				</div>
			</form>
			<div class="row">
				<ul id="erros_frm">
				</ul>
			</div>
			<!--
			<div class="social-auth-links text-center">
			  <p>- OR -</p>
			  <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using Facebook</a>
			  <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using Google+</a>
			</div><!-- /.social-auth-links -->
			<!--
			<a href="#">Esqueci minha senha</a><br>
			<a href="#" class="text-center">Nova Conta</a>
			-->
			
			<br><br>
		</div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <script src="<?=$_SESSION['dominio'];?>/sistema/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?=$_SESSION['dominio'];?>/sistema/assets/bootstrap/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="<?=$_SESSION['dominio'];?>/sistema/assets/plugins/iCheck/icheck.min.js"></script>
	<script src="<?=$_SESSION['dominio'];?>/js/scripts.js"></script>
	<script src="<?=$_SESSION['dominio'];?>/sistema/assets/js/login.js"></script>
	
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '40%' // optional
        });
      });
    </script>
  </body>
  </html>