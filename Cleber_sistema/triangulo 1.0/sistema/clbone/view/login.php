<?php
require_once("../config/sessions.php");
require_once("../../sistema/config/modals.php");
/*
echo "<pre>";
	print_r($_SESSION);
echo "</pre>";
*/
//session_destroy();
?>
<body class="hold-transition login-page">
    <div class="login-box">
		<div class="login-box-body">
			<div class="login-logo">
				<a href="<?=$_SESSION['dominio'];?>/clbone"><img src="<?=$_SESSION['dominio']."/".$_SESSION['logo'];?>" width="100"/></a>
			</div><!-- /.login-logo -->
			<p class="login-box-msg">Entre com suas credenciais:</p>
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
					</div><!-- /.col -->
					<div class="col-xs-4">
						<button type="button" id="bt_entrar" class="btn btn-primary btn-block btn-flat">Entrar</button>
					</div><!-- /.col -->
				</div>
			</form>
			<div class="row" id="ers">
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
    <script src="<?=$hosted;?>/sistema/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <!-- iCheck -->
    <script src="<?=$hosted;?>/sistema/assets/plugins/iCheck/icheck.min.js"></script>
	
    <script src="<?=$hosted;?>/sistema/assets/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?=$hosted;?>/js/scripts.js"></script>
	<script src="<?=$hosted;?>/clbone/js/login.js"></script>
    <script>
    JQuery(document).ready(function(){
      $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
          checkboxClass: 'icheckbox_minimal-blue',
          radioClass: 'iradio_minimal-blue'
        });
    });
    </script>
  </body>
  </html>