<?php require_once("../config/main.php"); ?>
<table class="table table-striped table-condensed" id="fila">
	<thead>
		<tr>
			<th>#</th>
			<th>Empresa</th>
			<th>Arquivo</th>
			<th>Compet&ecirc;ncia</th>
			<th>Vencimento</th>
			<th>Carteira</th>
			<th>Responsável</th>
			<th>Movimento?</th>
			<th>Status:</th>
			<th>A&ccedil;&otilde;es</th>
		</tr>
	</thead>
	<tbody id="tbl_fila">
		
	</tbody>
</table>


<script src="<?=$hosted;?>/assets/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('[data-toggle="popover"]').popover({
            html: true
        });
    });
	function mark_disp(emp, compet, imp, check, acao,id){

		act = ( check == true ? "inclui_"+acao : "exclui_"+acao);
		ati = ( check == true ? 1 : 0);
        $.post("../controller/TRIProdutividade.php",
            {
                acao:    act,
                empresa: emp,
                arquivo: imp,
                compet:  compet,
                ativo:   ati, 
            },
            function(data){
            	alert(data.mensagem);
            	$("#btn_pesfila").trigger("click");
            },
            "json"
        );
        
	}
</script>
            	
