<?php
/*----------------------------------------------------------------------\
|	contatos.php
	contém formulário para envio de mensagem ao(s) e-mail(s) de retorno cadastrado(s) na tabela sistema 
\----------------------------------------------------------------------*/
$sessao = "Servi&ccedil;os";
//require_once("../config/menu.php");
?>
			<!-- Page Heading -->
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">
						Servi&ccedil;os
					</h1>
					
				</div>
			</div>
			<!-- /.row -->
			<div class="row">
				<?php
				$tipo_serv = array(1=>"success",2=>"info",3=>"warning",4=>"danger");
				$rs = new recordset();
				$rs->Seleciona("*","services","ser_id > 0","","","0,4");
				while($rs->GeraDados()){
				?>
				 <div class="col-sm-3 col-md-3">
					<div class="thumbnail">
						<a class="clps" role="button" data-toggle="collapse" href="#serid<?=$rs->fld("ser_id");?>" aria-expanded="false" aria-controls="serid1">	
							<img src="<?=$rs->fld("ser_imagem");?>" title="<?=$rs->fld("ser_tipo");?>" data-toggle="tooltip" data-placement="bottom"/>
						</a>
					</div>
				</div>
				<?php
				}
				?>
			</div>
			<!-- /.row -->
			<div class="row">

			  <!-- Nav tabs -->
			  <ul class="nav nav-tabs" role="tablist">
				<?php
				$rs->Seleciona("*","services","ser_id > 0","","","0,4");
				while($rs->GeraDados()){
				?>
					<li class="dropdown">
						<a class="dropdown btn btn-<?=$tipo_serv[$rs->fld("ser_id")];?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?=$rs->fld("ser_tipo");?> <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<?php
							$rs2 = new recordset();
							$rs2->Seleciona("*","tipo_serv","tip_ser_id = ".$rs->fld("ser_id"));
							while($rs2->GeraDados()){?>
								<li><a href="#serv<?=$rs2->fld("tip_cod");?>" aria-controls="serv<?=$rs2->fld("tip_cod");?>" role="tab" data-toggle="tab"><?=$rs2->fld("tip_serv");?></a></li>
							<?php
							}?>
						</ul>
					</li>
				<?php
				}
				?>
			  </ul>

			  <!-- Tab panes -->
			  <div class="tab-content">
				<div role="tabpanel" class="tab-pane fade in active" id="home"></div>
				<div role="tabpanel" class="tab-pane fade" id="profile"></div>
				<div role="tabpanel" class="tab-pane fade" id="messages"></div>
				<div role="tabpanel" class="tab-pane fade" id="settings"></div>
			  </div>

			</div>