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

    /*-------------------consulta cnpj-------------------------*/
    $("#bt_pes_emp").click(function () {
        //tipo do modal
        tipo = "aguarde";
        $(".table td").each(function () {
            $(this).remove();
        });
        if (($("#emp_cnpj").val().length < 14) && ($("#emp_nfts").val() == "")) {
            $("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-ban"></i> Verifique o CNPJ digitado! <a href="#" class="alert-link">Mais sobre CNPJ</a> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
        }
        else {
            $.post("../controller/PRIConsultaEmpresa.php",
                    {
                        acao: "consulta",
                        emp_cnpj: $("#emp_cnpj").val(),
                        emp_nfts: $("#emp_nfts").val()
                    },
            function (data) {
                $("#emp_cnpj").attr("readonly", true); //desabilita o preenchimento do CNPJ
                if (data.status == 0) {
                    $("<div></div>").addClass("alert alert-info alert-dismissable").html('<i class="fa fa-check"></i> Cliente n&atilde;o existe, prosseguir! <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
                    $("#firms").addClass("hide");
                    $("#cadastro").removeClass("hide");
                    $("#bt_pes_emp").addClass("hide");
                    $("#bt_cad_emp").removeClass("hide");
                    $("#bt_nova_pes").removeClass("hide");
                    console.log(data.query);
                }
                else {
                    //$("<div></div>").addClass("alert alert-warning alert-dismissable").html('<i class="fa fa-warning"></i> Cliente j&aacute; cadastrado <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
                    $("#firms").removeClass("hide");
                    $("#cadastro").addClass("hide");
                    $("#bt_pes_emp").addClass("hide");
                    $("#bt_nova_pes").removeClass("hide");
                    $(".table").append(data.mensagem);
                }
            }, "json");
        }
    });
    /*---------------------------------Nova Pesquisa ---------------------------------*/
    $("#bt_nova_pes").click(function () {
        $(this).addClass("hide");
        $("#bt_pes_emp").removeClass("hide");
        $("#bt_cad_emp").addClass("hide");
        $("#firms").addClass("hide");
        $("#cadastro").addClass("hide");
        $("#emp_cnpj").attr("readonly", false); //habilita o preenchimento do CNPJ
        $("#formerros").fadeOut();
		$(".alert-info").fadeOut();
		$(".alert-danger").fadeOut();

    });
    /*--------------------------------razao social ------------------------------------*/
    $("#emp_rzs").click(function () {
        $('.alert-dismissable').fadeOut();
    });

    /*--------------------------------Nome Fantasia------------------------------------*/
    $("#emp_nft").on('focus', function () {
        $(this).val($("#emp_nfts").val());
    });
	/*--------------------------------RadioButon Documento------------------------------------*/
	$(".rdbdoc").on("click", function() {
		var rdb = $(".rdbdoc:checked").data("doc");
			$("#emp_cnpj").removeClass("form-control cnpj cpf").addClass("form-control "+rdb);
			$("#emp_cnpj").attr("placeholder", rdb);
			console.log(rdb);
	});
    /*----------------------------cadastra empresa-------------------------------------*/
    $("#bt_cad_emp").click(function () {
        tipo = "cadastrar";
        var container = $("#formerros3");
        $("#cad_emp").validate({
            debug: true,
            errorClass: "error",
           errorContainer: container,
            errorLabelContainer: $('ol', container),
            wrapper: 'li',
            rules: {
                emp_cnpj: {required: true, minlength: 14},
                emp_rzs: {required: true, minlength: 5},
                emp_nft: {required: true, minlength: 5},
				emp_iest: {required: true, minlength: 15},
                cep: {required: true, minlength: 8},
                num: {required: true, minlength: 1},
                bai: {required: true, minlength: 3},
                cid: {required: true, minlength: 3},
                uf: {required: true, minlength: 2},
                resp: {required: true, minlength: 3}
            },
            messages: {
                emp_cnpj: {required: "CNPJ / CPF Deve ser Digitado", minlength: "O CNPJ deve ter 14 Numeros"},
                emp_rzs: {required: "Qual o nome razao da empresa?", minlenght: "Minimo 5 Letras"},
                emp_nft: {required: "Qual o nome Fantasia dessa empresa?", minlength: "Minimo 5 Letras"},
				emp_iest: {required: "Inscricao Estadual dessa empresa?", minlength: "Minimo 15 Letras"},
                cep: {required: "Qual o CEP? Pesquisa automatica :)", minlength: "Minimo 8 Numeros"},
                num: {required: "Numero do local.", minlength: "Minimo 1 Numero"},
                bai: {required: "Bairro da Localidade e Obrigatorio.", minlength: "Minimo 3 Letras"},
                cid: {required: "Cidade da Localidade e Obrigatorio.", minlength: "Minimo 3 Letras"},
                uf: {required: "Estado Obrigatorio.", minlength: "Min e Max 2 Letras"},
                emp_resp: {required: "Nome do contato Responsavel da Empresa.", minlength: "Minimo 3 Letras"}
            }
        });
        if ($("#cad_emp").valid() == true) {
            $.post("../controller/PRIConsultaEmpresa.php", {
                acao: "inclusao",
                emp_cnpj: $("#emp_cnpj").val(),
                emp_rzs: $("#emp_rzs").val(),
                emp_nft: $("#emp_nft").val(),
                emp_ie: $("#emp_iest").val(),
                emp_cep: $("#cep").val(),
                emp_log: $("#log").val(),
                emp_num: $("#num").val(),
                emp_compl: $("#compl").val(),
                emp_bai: $("#bai").val(),
                emp_cid: $("#cid").val(),
                emp_uf: $("#uf").val(),
                emp_resp: $("#emp_resp").val(),
                emp_mun: $("#emp_mun").val(),
                emp_cnae: $("#emp_cnae").val(),
                emp_evt: $("#emp_evt").val(),
                emp_crt: $("#emp_crt").val()
            },
                    function (data) {
                        $("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> ' + $("#emp_rzs").val() + ' cadastrada com sucesso na PRIORE! <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
                        console.log(data.status);//TO DO mensagem OK
                        //limpa_formulario_all();
                        $("#bt_nova_pes").trigger('click');
                    }, "json");
        }
    });

   
});