								<div class="box box-primary">
									<div class="box-body">
										<?php 
											require_once("tabl_arqs.php");
										?>
									
									</div>
									<div class="box-footer">
										<a href="empresas_docs.php?token=<?=$_SESSION['token'];?>&clicod=<?=$_GET['clicod']; ?>&doc_pes=<?=$doc;?>"
											class='btn btn-sm btn-success' 
											data-toggle='tooltip' 
											data-placement='bottom' 
											title='Novo DOC'><i class='fa fa-save'></i> Enviar Documento
										</a>
									</div>
								</div>