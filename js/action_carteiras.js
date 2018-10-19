$(document).ready(function () {
    var tipo = "";
    /*AjaxStart e AjaxStop*/
    $(document).ajaxStart(function () {
        console.log(tipo);
        $('#' + tipo).modal('show');
    });
    $(document).ajaxStop(function () {
        $('#' + tipo).modal('hide');
    });

	/*---------------|GERAR CARTEIRAS LEGAL|-----------------------*\
	| Author:   Cleber Marrara Prado                                |
	| Version:  1.0                                                 |
	| Email:    cleber.marrara.prado@gmail.com                      |
	| Date:     11/05/2018                                          |
	\*-------------------------------------------------------------*/
	$(document.body).on("change","#cl_colab",function(){
	    console.log($(this).val());
	    if($(this).val()==0){
	        $("#gcart5").attr("disabled",true);
	    }
	    else{
	        $("#gcart5").attr("disabled",false);
	        
	    }
	});

	$(document.body).on("click","#gcart5", function () {
	    $(this).html("<i class='fa fa-spinner fa-spin'></i> Gerando...");
	    
	    // solução para pegar todos os check de IR marcados para a geraçao do boleto
	    var checkeditems = $('input:checkbox[name="emp_codslegal[]"]:checked')
	                   .map(function() { return $(this).val() })
	                   .get()
	                   .join(",");
	    if(checkeditems==""){
	        alert("Escolha a empresa!");
	        
	    }
	    else{
	        $.post("../controller/TRIEmpresas.php",
	            {
	                acao     : "gerar_carteira",
	                empresas : checkeditems,
	                user     : $("#cl_colab").val(),
	                dep      : $("#el").val()
	            },
	            function(data){
	                if(data.status=="OK"){
	                        $("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> '+data.mensagem+' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
	                        location.reload();
	                        
	                    } else{
	                        $("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-times"></i> Ocorreu um erro! ('+data.mensagem+')<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
	                    }
	                    console.log(data.sql);//TO DO mensagem OK
	            },
	            "json"
	        );
	    }
	    $("#gcart5").html("<i class='fa fa-user'></i> Associar");
	});

});