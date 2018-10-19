				<div class="col-md-12">
					<div class="box box-danger <?=(isset($_GET['box'])?"":"collapsed-box");?>">
			            <div class="box-header with-border">
							<h3 class="box-title">
								Pendentes de Confer&ecirc;ncia
								<?php
								session_start("portal");
								require_once("../class/class.permissoes.php");
								$rspend = new recordset();
								$rs_campos = new recordset();
								$per = new permissoes();

								?>
							</h3>
							<div class="box-tools pull-right">
								<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
								<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
			                </div>
					    </div>
					    
				        <div class="box-body">
				        	<input type="hidden" id="token" value="<?=$_SESSION['token'];?>">
							<?php
								//require_once("imp_pendentesfiltro.php");
							?>							
				        	<div id="imp_pescf">
								<?php 
									require_once("imp_pesquisaconf.php");
								?>
							</div>
						</div>
					</div>
				</div><!--/col-->
				