<?php
/*----------------------------------------------------------------------\
|	contatos.php
	contém formulário para envio de mensagem ao(s) e-mail(s) de retorno cadastrado(s) na tabela sistema 
\----------------------------------------------------------------------*/
$sessao = "Contatos";
//require_once("../config/menu.php");
?>
			<!-- Page Heading -->
			
			<!-- /.row -->
			<div class="row">
				<div class="col-sm-6">
					<div class="page-header">
						<h3>Fale <b>Conosco</b></h3>
					</div>
						<form id="frm_Mail" method="POST">
							<div class="input-group" id="nome">
								<span class="input-group-addon" id="basic1"><i class="fa fa-user"></i></span>
								<input data-type="nome" type="text" name="nome" id="ctt_nome" class="form-control" placeholder="Seu Nome" aria-describedby="basic1" />
							</div>
							<br>
							<div class="input-group" id="email">
								<span class="input-group-addon" id="basic1"><i class="fa fa-envelope"></i></span>
								<input data-type="email" name="email" id="ctt_email" class="form-control" placeholder="Seu e-mail" aria-describedby="basic1" />
							</div>
							<br>
							<div class="input-group" id="telefone">
								<span class="input-group-addon" id="basic1"><i class="fa fa-whatsapp"></i></span>
								<input data-type="telefone" name="telefone" id="ctt_tel" class="form-control cel" placeholder="(99) 9 9999-9999" aria-describedby="basic1" />
							</div>
							<br>
							<div class="input-group" id="assunto">
								<span class="input-group-addon" id="basic1"><i class="fa fa-keyboard-o"></i></span>
								<input data-type="assunto" type="text" name="assunto" id="ctt_assunto" class="form-control" placeholder="Assunto" aria-describedby="basic1" />
							</div>
							<br>
							<div class="input-group" id="mensagem">
								<span class="input-group-addon" id="basic1"><i class="fa fa-book"></i></span>
								<textarea data-type="mensagem" type="text" name="mensagem" id="ctt_mens" class="form-control" placeholder="Mensagem" aria-describedby="basic1"></textarea>
							</div>
							<br>
							
							<div class="input-group">
								<button type="button" id="bt_Mail" class="btn btn-success"><i class="fa fa-send"></i> Enviar</button>
							</div>
							<br>
							<div id="frc">
								<ul class="has-error" id="erros_frm">
								</ul>
						
							</div>
						</form>
					
				</div>
				<div class="col-sm-6">
					<div class="page-header">
						<h2><small>Entre em <b>contato</b></small></h2>
					</div>
					<div class="row">
						<div class="panel panel-default">
							<ul class="list-group">
								
								
							</ul>
					</div>
				</div>
				
				</div>
			</div>
				<!-- /.row -->
