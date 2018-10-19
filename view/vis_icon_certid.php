<!--|CERTIDOES|-->
<li class="dropdown notifications-menu">
	<?php
		$sql = "SELECT a.certid_validade, b.cod, b.apelido, c.tipocertid_desc FROM certidoes a 
			JOIN tri_clientes b ON a.certid_cod = b.cod
			JOIN tipos_certidoes c ON a.certid_tipoId= c.tipocertid_id
			WHERE certid_status = 1 AND a.certid_validade <= CURDATE() + INTERVAL 
				(SELECT tipocertid_dias FROM tipos_certidoes WHERE tipocertid_id = a.certid_tipoId) DAY 
			ORDER BY a.certid_validade ASC";
		$nlin = 0;
		//echo $sql;
		$rsa->FreeSql($sql);

		$nlin = $rsa->linhas;
		$rsa->GeraDados();
	
	?>
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		<i class="fa fa-exchange"></i>
			<span class="label label-danger"><?=($nlin==0?"":$nlin);?></span>
			<!--<input type="hidden" id="nova" value=<?=$nova;?> />-->
			
	</a>
	<ul class="dropdown-menu">
		<li class="header">Voc&ecirc; <?=($nlin==0?"não":"");?> tem <?=($nlin==0?"":$nlin);?> certid&otilde;es expirando</li>
		<li>
		<!-- inner menu: contains the actual data -->
			<ul class="menu">
				<?php
				if($nlin<>0){
					$rsa->FreeSql($sql);
					while($rsa->GeraDados()){
					?>
					<li><!-- start message -->
						<a href="clientes.php?token=<?=$_SESSION['token'];?>&clicod=<?=$rsa->fld("cod");?>&tab=certid">
							<div class="pull-left">
								<i class="fa fa-exchange text-info"></i> <?="[".str_pad($rsa->fld("cod"),3,"000",STR_PAD_LEFT)."] - ". (strlen($rsa->fld("tipocertid_desc"))>20?substr($rsa->fld("tipocertid_desc"),0,25)."...":$rsa->fld("tipocertid_desc"));?>
							</div>
						</a>
					</li><!-- end message -->
					<?php 
					}
				}
				?>
				<!--<li class="footer"><a href="#">Veja todas as Mensagens</a></li>-->
			</ul>
		</li>
	</ul>	
</li>

<!--|FIM CERTIDOES|-->
