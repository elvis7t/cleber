<?php 
$cua = $_SESSION["usu_cod"];
$sq_chat = "SELECT * FROM chat a 
				JOIN usuarios b ON  b.usu_cod = a.chat_para
				JOIN usuarios c ON  c.usu_cod = a.chat_de
				WHERE (chat_de = ".$cua. " AND chat_para = ".$para.") OR (chat_de = ".$para. " AND chat_para = ".$cua.") 
				GROUP BY chat_id
				ORDER BY chat_hora ASC";						
$rs2->FreeSql($sq_chat);

while($rs2->GeraDados()){
	if($rs2->fld("chat_de")==$cua):
	?>
		<div class="direct-chat-msg">
			<div class="direct-chat-info clearfix">
				<span class="direct-chat-name pull-left"><?=$rs2->fld("usu_nome");?></span>
				<span class="direct-chat-timestamp pull-right"><?=$rs2->fld("chat_hora");?></span>
			</div>
			<img class="direct-chat-img" alt="Message User Image" src="../..<?=$rs2->fld("usu_foto");?>">
			<div class="direct-chat-text"><?=$rs2->fld("chat_msg");?></div>
		</div>
	<?php 
	else:
	?>
		<div class="direct-chat-msg right">
			<div class="direct-chat-info clearfix">
				<span class="direct-chat-name pull-right"><?=$rs2->fld("usu_nome");?></span>
				<span class="direct-chat-timestamp pull-left"><?=$rs2->fld("chat_hora");?></span>
			</div>
			<img class="direct-chat-img" alt="Message User Image" src="../..<?=$rs2->fld("usu_foto");?>">
			<div class="direct-chat-text"> <?=$rs2->fld("chat_msg");?></div>
		</div>
	<?php
	endif; 
}
?>