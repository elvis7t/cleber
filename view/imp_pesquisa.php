<?php require_once("../config/main.php"); ?>
<table class="table table-striped table-condensed" id="empr">
	<thead>
    	<tr>
    		<th>Cód</th>
            <th>Empresa</th>
    		<th>Imposto/ Obriga&ccedil;&atilde;o</th>
            <th>Vencimento <small>(esse m&ecirc;s)</small></th>
    		<th>Carteira</th>
    		<th>c/ Movimento?</th>
            <th><i title="Gerado" data-toggle='tooltip' class="fa fa-file-pdf-o"></i></th>
            <th><i title="Conferido" data-toggle='tooltip' class="fa fa-check-square-o"></i></th>
    		<th><i title="Enviado" data-toggle='tooltip' class="fa fa-envelope"></i></th>
    		
    	</tr>
    </thead>
	<tbody id="tbl_dados">
			
	</tbody>

</table>
<script src="<?=$hosted;?>/sistema/assets/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('[data-toggle="popover"]').popover({
            html: true
        });
    });
	function mark_sent(emp, compet, imp, check, acao,id){

        //$("#aguarde").modal("show");
        act = ( check == true ? "inclui_"+acao : "exclui_"+acao);
        ati = ( check == true ? 1 : 0);
        $.post("../controller/TRIEmpresas.php",
            {
                acao:    act,
                empresa: emp,
                imposto: imp,
                compet:  compet,
                ativo:   ati, 
            },
            function(data){
                /*
               */
                $("#btn_pesqImp").trigger("click");
                $("#imp_pescf").load("imp_pesquisaconf.php?emp="+emp);
                $("#imp_pesev").load("imp_pesquisaenv.php?emp="+emp);
                $("#imp_pesce").load("imp_confereenv.php?emp="+emp);
                if(data.status=="NOK"){
                    alert(data.mensagem);
                    //$("#"+id).bootstrapToggle("toggle");
                    $("#msgresp").html("");
                    $("#msgresp").html(data.mensagem);
                }
            },
            "json"
        );
        
	}
</script>
            	
	