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

/*-----------------------|CONSULTA CNPJ|----------------------------*\
| Author:   Cleber Marrara Prado                                     |
| Email:    cleber.marrara.prado@mail.com                            |
| Version:  1.0                                                      |
\*------------------------------------------------------------------*/

$("#bt_pes_emp").click(function () {
    //tipo do modal
    tipo = "aguarde";
    $(".table td").each(function () {
        $(this).remove();
    });
    if (($("#emp_cnpj").val().length < 14) && ($("#emp_nfts").val() == "")) {
        $("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-ban"></i> Verifique o documento digitado! <a href="#" class="alert-link">Mais sobre CNPJ</a> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
    }
    else {
        $.post("../controller/TRIConsultaEmpresa.php",
                {
                    acao: "consulta",
                    emp_cnpj: $("#emp_cnpj").val(),
                    emp_nfts: $("#emp_nfts").val()
                },
        function (data) {
            //$("#emp_cnpj").attr("readonly", true); //desabilita o preenchimento do CNPJ
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
/*-----------------------|NOVA_PESQUISA|----------------------------*\
| Author:   Cleber Marrara Prado                                     |
| Email:    cleber.marrara.prado@mail.com                            |
| Version:  1.0                                                      |
\*------------------------------------------------------------------*/

$("#bt_nova_pes").click(function () {
    $(this).addClass("hide");
    $("#bt_pes_emp").removeClass("hide");
    $("#bt_cad_emp").addClass("hide");
    $("#firms").addClass("hide");
    $("#cadastro").addClass("hide");
    //$("#emp_cnpj").attr("readonly", false); //habilita o preenchimento do CNPJ
    $("#formerros").fadeOut();
	$(".alert-info").fadeOut();
	$(".alert-danger").fadeOut();
});
/*-----------------------|RAZÃO SOCIAL|-----------------------------*\
| Author:   Cleber Marrara Prado                                     |
| Email:    cleber.marrara.prado@mail.com                            |
| Version:  1.0                                                      |
\*------------------------------------------------------------------*/

$("#emp_rzs").click(function () {
    $('.alert-dismissable').fadeOut();
});

/*-----------------------|NOME FANTASIA|----------------------------*\
| Author:   Cleber Marrara Prado                                     |
| Email:    cleber.marrara.prado@mail.com                            |
| Version:  1.0                                                      |
\*------------------------------------------------------------------*/

$("#emp_nft").on('focus', function () {
    $(this).val($("#emp_nfts").val());
});
/*-----------------------|RButton DOCUMENTO|------------------------*\
| Author:   Cleber Marrara Prado                                     |
| Email:    cleber.marrara.prado@mail.com                            |
| Version:  1.0                                                      |
\*------------------------------------------------------------------*/

$(".rdbdoc").on("click", function() {
	var rdb = $(".rdbdoc:checked").data("doc");
		$("#emp_cnpj").removeClass("form-control cnpj cpf").addClass("form-control "+rdb);
		$("#emp_cnpj").attr("placeholder", rdb);
		console.log(rdb);
});

/*-----------------------|CADASTRA DOCUMENTO|-----------------------*\
| Author:   Cleber Marrara Prado                                     |
| Email:    cleber.marrara.prado@mail.com                            |
| Version:  1.0                                                      |
\*------------------------------------------------------------------*/

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
            cep: {required: true, minlength: 8},
            num: {required: true, minlength: 1},
            bai: {required: true, minlength: 3},
            cid: {required: true, minlength: 3},
            uf: {required: true, minlength: 2}
        },
        messages: {
            emp_cnpj: {required: "CNPJ / CPF Deve ser Digitado", minlength: "O CNPJ deve ter 14 Numeros"},
            emp_rzs: {required: "Qual o nome razao da empresa?", minlenght: "Minimo 5 Letras"},
            cep: {required: "Qual o CEP? Pesquisa automatica :)", minlength: "Minimo 8 Numeros"},
            num: {required: "Numero do local.", minlength: "Minimo 1 Numero"},
            bai: {required: "Bairro da Localidade e Obrigatorio.", minlength: "Minimo 3 Letras"},
            cid: {required: "Cidade da Localidade e Obrigatorio.", minlength: "Minimo 3 Letras"},
            uf: {required: "Estado Obrigatorio.", minlength: "Min e Max 2 Letras"}
        }
    });
    if ($("#cad_emp").valid() == true) {
        $.post("../controller/TRIConsultaEmpresa.php", {
            acao: "inclusao",
            emp_cnpj: $("#emp_cnpj").val(),
            emp_rzs: $("#emp_rzs").val(),
            emp_cep: $("#cep").val(),
            emp_log: $("#log").val(),
            emp_num: $("#num").val(),
            emp_compl: $("#compl").val(),
            emp_bai: $("#bai").val(),
            emp_cid: $("#cid").val(),
            emp_uf: $("#uf").val()
        },
                function (data) {
                    $("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> ' + $("#emp_rzs").val() + ' cadastrado com sucesso! <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
                    console.log(data.status);//TO DO mensagem OK
                    //limpa_formulario_all();
                    $("#bt_nova_pes").trigger('click');
                }, "json");
    }
});

/*---------------|ROTINA ALTERA ENDEREÇO|---------------------------*\
| Author:   Cleber Marrara Prado                                     |
| Email:    cleber.marrara.prado@mail.com                            |
| Version:  1.0                                                      |
\*------------------------------------------------------------------*/

$("#bt_altera_end").on("click",function(){
    $.post("../controller/TRIEmpresas.php",
        {
            acao    : "altera_end",
            emp_razao : $("#emp_rzs").val(),
            emp_cod_ac: $("#emp_cod_ac").val(),
            emp_senha_ac: $("#emp_senha_ac").val(),
            emp_nasc : $("#emp_nasc").val(),
            emp_benef : $("#emp_benef").val(),
            emp_codigo : $("#emp_cod").val(),
            emp_cep : $("#cep").val(),
            emp_log : $("#log").val(),
            emp_num : $("#num").val(),
            emp_compl : $("#compl").val(),
            emp_bai : $("#bai").val(),
            emp_cid : $("#cid").val(),
            emp_uf : $("#uf").val()

        },function(data){
            if (data.status == "OK") {
                $("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-check"></i> ('+data.mensagem+') <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
                console.log(data.query);
            }
            else {
                $("<div></div>").addClass("alert alert-warning alert-dismissable").html('<i class="fa fa-warning"></i> Cliente j&aacute; cadastrado <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
               }
        }, "json");
});

/*---------------|ROTINA ALTERA ENDEREÇO|---------------------------*\
| Author:   Cleber Marrara Prado                                     |
| Email:    cleber.marrara.prado@mail.com                            |
| Version:  1.0                                                      |
\*------------------------------------------------------------------*/

$("#dados_sal_Obs").on("click",function(){
    $.post("../controller/TRIEmpresas.php",
        {
            acao    : "altera_obs",
            emp_codigo : $("#emp_cod").val(),
            emp_obs     : CKEDITOR.instances.emp_obs.getData()

        },function(data){
            if (data.status == "OK") {
                $("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-check"></i> ('+data.mensagem+') <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta_OBS");
                console.log(data.query);
            }
            else {
                $("<div></div>").addClass("alert alert-warning alert-dismissable").html('<i class="fa fa-warning"></i> Cliente j&aacute; cadastrado <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta_OBS");
               }
        }, "json");
});

/*----------------------|EXCLUIR CONTATO|---------------------------*\
| Author:   Cleber Marrara Prado                                     |
| Email:    cleber.marrara.prado@mail.com                            |
| Version:  1.0                                                      |
\*------------------------------------------------------------------*/

$(document.body).on("click","#exc_ctt",function(){
    
    $.post("../controller/TRIEmpresas.php",
    {
        acao    : "excluir",
        tabela  : $(this).data("tbl"),
        codigo  : $(this).data("contato")
    },
    function(data){
        if(data.status=="OK"){
            $("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> '+data.mensagem+' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
            $("#tabela_ctt").fadeOut();
            $("#tabela_ctt").load("../view/contatos.php?clicod="+ $("#clicod").val()).fadeIn("slow");
            console.log(data.mensagem);
            
        } else{
            $("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-times"></i> Ocorreu um erro! ('+data.mensagem+')<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
        }
        console.log(data.sql);//TO DO mensagem OK
    },
    "json");
});

/*----------------------------|CLIENTES|----------------------------*\
| Author:   Cleber Marrara Prado 07/06/2016                          |
| Email:    cleber.marrara.prado@mail.com                            |
| Version:  1.0                                                      |
\*------------------------------------------------------------------*/
$(document.body).on("click","#bt_altcli", function(){
    tipo = "cadastrar";
    var container = $("#formerros3");
    $("#cad_clientes").validate({
        debug: true,
        errorClass: "error",
        errorContainer: container,
        errorLabelContainer: $('ol', container),
        wrapper: 'li',
        rules: {
            cli_cod: {required: true},
            cli_cnpj: {required: true, minlength: 14},
            cli_nome: {required: true},
            cli_apelido: {required: true},
            cli_reg: {required: true},
            cli_tel: {required: true, minlength: 10},
            cep:     {required: true},
            log:     {required: true},
            num:     {required: true},
            bai:     {required: true},
            cid:     {required: true},
            uf:      {required: true}

        },
        messages: {
            cli_cod: {required: "Codigo do Cliente"},
            cli_cnpj: {required: "CNPJ / CPF Deve ser Digitado", minlength: "O CNPJ deve ter 14 Numeros"},
            cli_nome: {required: "Qual o nome razao da empresa?"},
            cli_apelido: {required: "Qual o apelido da empresa?"},
            cli_reg: {required: "Regiao da empresa"},
            cli_tel: {required: "Digite o telefone.", minlength: "Minimo 10 Letras"},
            cep:     {required: "Digite o CEP"},
            log:     {required: "Digite o nome da Rua/ Av."},
            num:     {required: "Digite o número"},
            bai:     {required: "Digite o bairro"},
            cid:     {required: "Digite a cidade"},
            uf:      {required: "Digite o estado"}

        },
        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error');
        }
    });

    if ($("#cad_clientes").valid() == true) {
        
        $.post("../controller/TRIEmpresas.php", {
            acao:       $("#acao").val(),
            cli_cod:    $("#cli_cod").val(),
            cli_cnpj:   $("#cli_cnpj").val(),
            cli_nome:   $("#cli_nome").val(),
            cli_apelido:$("#cli_apelido").val(),
            cli_cpr:    $("#cli_cpr").val(),
            cli_cnae:   $("#cli_cnae").val(),
            cli_nire:   $("#cli_nire").val(),
            cli_iest:   $("#cli_insc").val(),
            cli_imun:   $("#cli_imun").val(),
            cli_juce:   $("#cli_juce").val(),
            cli_inicio: $("#cli_inicio").val(),
            cli_cep:    $("#cep").val(),
            cli_log:    $("#log").val(),
            cli_num:    $("#num").val(),
            cli_compl:  $("#compl").val(),
            cli_bai:    $("#bai").val(),
            cli_cid:    $("#cid").val(),
            cli_uf:     $("#uf").val(),
            cli_capital: $("#cli_capital").val(),
            cli_integra: $("#cli_integra").val(),
            cli_atividade: $("#cli_atividade").val(),
            cli_resp:   $("#cli_resp").val(),
            cli_reg:    $("#cli_reg").val(),
            cli_tipo:   $("#emp_tipo").val(),
            cli_func:   $("#emp_funcs").val(),
            cli_tel:    $("#cli_tel").val(),
            cli_mail:   $("#cli_mail").val(),
            cli_site:   $("#cli_site").val(),
            cli_ativo:  $("input[name=cli_ativo]:checked").val(),
            cli_uda:    $("input[name=cli_uda]:checked").val(),
            cli_tribut: $("#cli_tribut").val(),
            cli_dataim:   $("#cli_dataim").val(),
            cli_datatrib:   $("#cli_datatrib").val(),
            cli_datacnpj:   $("#cli_datacnpj").val(),
            cli_dataie:   $("#cli_dataie").val()
        },
                function (data) {
					if(data.status=="OK"){
						$("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> ('+data.mensagem+') <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
						console.log(data.sql);//TO DO mensagem OK
						//limpa_formulario_all();
						$("#slc").load('vis_clientes.php').fadeIn('slow');
					}
					else{
						$("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-flag-checkered"></i> ('+data.mensagem+') <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
					}
                    
                }, "json");
    }
});

/*---------------|PESQUISAR EMPRESA POR COMBO|-----------------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado@gmail.com                      |
| Date:     22/09/2016                                          |
\*-------------------------------------------------------------*/
$(document.body).on("click","#bt_empsearch", function(){
    tipo = "aguarde";
    var cod = $("#pes_empresas").val();
    var token = $("#token").val();
    console.log("vis_clientes.php?cod="+cod+"&token="+token);
    $("#slc").load("vis_clientes.php?cod="+cod+"&token="+token);
    
});

/*---------------|EXCLUIR EMPRESA DO CADASTRO|-----------------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado@gmail.com                      |
| Date:     02/06/2016                                          |
\*-------------------------------------------------------------*/
/*|COM A CLASSE excEmpresa, FAZER A EXCLUSÃO DO BD|*/
$(document.body).on("click",".excEmpresa",function(){
    console.log("CLICK OK");
    cod = $(this).data("reg");
    $.post("../controller/TRIEmpresas.php",{
        acao: "exclui_empresa",
        emp_cod: cod
    },
    function(data){
        if(data.status=="OK"){
            alert(data.mensagem);
            location.reload();
        } 
        else{
            alert(data.mensagem);   
        }
    },
    "json");
});
/*---------------|PESQUISA PELO CÓDIGO DO CLIENTE|-------------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado@gmail.com                      |
| Date:     02/06/2016                                          |
| Objetivo  Consultar o código do cliente afim de evitar 
| duplicidades  
\*-------------------------------------------------------------*/
$(document.body).on("blur","#cli_cod",function(){
    cod = $(this).val();
    $.post("../controller/TRIEmpresas.php",{
        acao: "consulta_emp",
        emp_cod: cod
    },
    function(data){
        if(data.status=="OK"){
            $("#cli_cod").attr("readonly",true);
            $("#cli_cnpj").attr("readonly",true).val(data.cnpj);
            $("#cli_nome").val(data.empresa);
            $("#cli_apelido").val(data.apelido);
            $("#cli_resp").val(data.resp);
            $("#cli_reg").val(data.reg);
            $("#cli_tel").val(data.tel);
            $("#cli_mail").val(data.email);
            $("#cli_site").val(data.site);
			$("#acao").val("altera_cli");
            CKEDITOR.instances.editor1.setData(data.obs);
        } 
        else{
            alert(data.mensagem);
            $("#cli_cnpj").val("");
            $("#cli_nome").val("");
            $("#cli_apelido").val("");
            $("#cli_resp").val("");
            $("#cli_reg").val("");
            $("#cli_tel").val("");
            $("#cli_mail").val("");
            $("#cli_site").val("");
            CKEDITOR.instances.editor1.setData("");   
        }
    },
    "json");
});
/*---------------|CADASTRO DE SENHAS DO CLIENTE|---------------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado@gmail.com                      |
| Date:     23/09/2016											|
| Objetivo:	Cadastrar senhas para usu rotineiro					|
\*-------------------------------------------------------------*/
$(document.body).on("click","#bt_cadcliSenhas",function(){
	tipo = "cadastrar";
	var container = $("#formerros_Senha");
    $("#cad_senhas").validate({
        debug: true,
        errorClass: "error",
        errorContainer: container,
        errorLabelContainer: $('ol', container),
        wrapper: 'li',
        rules: {
            sen_desc: 	{required: true},
            sen_acesso:	{required: true, minlength: 10},
            sen_user: 	{required: true},
            sen_senha:	{required: true}
        },
        messages: {
            sen_desc: 	{required: "Digite a descricao da senha"},
            sen_acesso: {required: "Digite o site que deve ser acessado", minlength: "O site deve ter 10 caracteres"},
            sen_user: 	{required: "Digite o nome de usuario"},
            sen_senha: 	{required: "Digite a senha"}
        },
        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error');
        }
    });

    if ($("#cad_senhas").valid() == true) {
        $.post("../controller/TRIEmpresas.php", {
            acao:       	$("#acao").val(),
            sen_clicod:     $("#sen_clicod").val(), 
			sen_id:     	$("#sen_id").val(),	
            sen_desc:    	$("#sen_desc").val(),
            sen_acesso: 	$("#sen_acesso").val(),
            sen_user:   	$("#sen_user").val(),
            sen_senha:		$("#sen_senha").val(),
            sen_obs:		CKEDITOR.instances.editor_senha.getData()
        },
                function (data) {
					if(data.status=="OK"){
						$("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> ('+data.mensagem+') <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
						console.log(data.sql);//TO DO mensagem OK
						//limpa_formulario_all();
						location.href = "clientes.php?token=" +$("#token").val()+"&cnpj="+$("#cnpj").val()+"&clicod="+$("#sen_clicod").val()+"&tab=senhas";
					}
					else{
						$("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-flag-checkered"></i> ('+data.mensagem+') <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
					}
                    
                }, "json");
    }
 });

/*---------|CADASTRO DE PARTICULARIDADES DO CLIENTE|-----------*\
| Author:   Elvis Leite da silva                                |
| Version:  1.0                                                 |
| Email:    elvis7t@gmail.com                                   |
| Date:     24/09/2016                                          |
| Objetivo: Cadastrar particularidades para usu rotineiro       |
\*-------------------------------------------------------------*/
$(document.body).on("click","#bt_partic",function(){
    tipo = "cadastrar";
    var container = $("#formerros_partic");
    $("#cad_partic").validate({
        debug: true,
        errorClass: "error",
        errorContainer: container,
        errorLabelContainer: $('ol', container),
        wrapper: 'li',
        rules: {
            part_titulo:    {required: true},
            part_ativo:     {required: true},
            part_lei:       {required: true},
            part_link:      {required: true},
            part_obs:       {required: true}
        },
        messages: {
            part_titulo: {required: "Digite um titulo"},
            part_ativo:  {required: "Escolha uma op&cedil;&atilde;o para a particularidade"},
            part_lei:    {required: "Especifique a Lei:"},
            part_link:   {required: "Cole o link associado à lei:"},
            part_obs:    {required: "Forne&ccedil;a detalhes para a particularidade"}
        },
        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error');
        }
    });

    if ($("#cad_partic").valid() == true) {
        $.post("../controller/TRIEmpresas.php", {
            acao:           $("#acao").val(),
            part_id:        $("#part_id").val(),
            part_clicod:    $("#part_clicod").val(), 
            part_titulo:    $("#part_titulo").val(),
            part_depto:     $("#sel_dept").val(),
            part_tipo:      $("#part_tipo").val(),
            part_ativo:     $("#part_ativo").val(),
            part_lei:       $("#part_lei").val(),
            part_link:      $("#part_link").val(),
            part_obs:       CKEDITOR.instances.part_obs.getData()
        },
                function (data) {
                    if(data.status=="OK"){
                        $("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> ('+data.mensagem+') <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
                        console.log(data.sql);//TO DO mensagem OK
                        //limpa_formulario_all();
                        location.href = "clientes.php?token=" +$("#token").val()+"&cnpj="+$("#cnpj").val()+"&clicod="+$("#part_clicod").val()+"&tab=partic";
                    }
                    else{
                        $("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-flag-checkered"></i> ('+data.mensagem+') <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
                    }
                    
                }, "json");
    }
 });

/*---------|CADASTRO DE COMUNICAÇÃO DO CLIENTE|----------------*\
| Author:   Elvis Leite da silva                                |
| Version:  1.0                                                 |
| Email:    elvis7t@gmail.com                                   |
| Date:     24/09/2016                                          |
| Objetivo: Cadastrar canal de comunicação para usu rotineiro   |
\*-------------------------------------------------------------*/
$(document.body).on("click","#bt_cadCom",function(){
    tipo = "cadastrar";
    var container = $("#formerros_com");
    $("#cad_com").validate({
        debug: true,
        errorClass: "error",
        errorContainer: container,
        errorLabelContainer: $('ol', container),
        wrapper: 'li',
        rules: {
            com_canal:      {required: true},
            com_ativo:      {required: true},
            com_obs:        {required: true}
        },
        messages: {
            com_canal:   {required: "Digite um canal de comunica&cedil;&atilde;o"},
            com_ativo:   {required: "Escolha uma op&cedil;&atilde;o para a comunica&cedil;&atilde;o"},
            com_obs:     {required: "Forne&ccedil;a detalhes para a comunica&cedil;&atilde;o"}
        },
        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error');
        }
    });

    if ($("#cad_com").valid() == true) {
        $.post("../controller/TRIEmpresas.php", {
            acao:           $("#acao").val(),
            com_id:         $("#com_id").val(), 
            com_clicod:     $("#com_clicod").val(), 
            com_canal:      $("#com_canal").val(),
            com_depto:      $("#com_depto").val(),
            com_ativo:      $("#com_ativo").val(),
            com_obs:        CKEDITOR.instances.com_obs.getData()
        },
                function (data) {
                    if(data.status=="OK"){
                        $("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> ('+data.mensagem+') <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
                        console.log(data.sql);//TO DO mensagem OK
                        //limpa_formulario_all();
                        location.href = "clientes.php?token=" +$("#token").val()+"&cnpj="+$("#cnpj").val()+"&clicod="+$("#com_clicod").val()+"&tab=comunic";
                    }
                    else{
                        $("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-flag-checkered"></i> ('+data.mensagem+') <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
                    }
                    
                }, "json");
    }
 });

/*----------|CADASTRO DE OBRIGAÇÕES DO CLIENTE|----------------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado.com                            |
| Date:     26/09/2016                                          |
| Objetivo: Cadastrar Obrigações Acessórias para uso rotineiro  |
\*-------------------------------------------------------------*/
$(document.body).on("click","#bt_cadObr",function(){
    tipo = "cadastrar";
    var container = $("#formerros_obr");
    $("#cad_obr").validate({
        debug: true,
        errorClass: "error",
        errorContainer: container,
        errorLabelContainer: $('ol', container),
        wrapper: 'li',
        rules: {
            ob_titulo:  {required: true},
            ob_ativo:   {required: true}
        },
        messages: {
            ob_titulo:   {required: "Escolha a obrigação"},
            ob_ativo:    {required: "Escolha uma op&cedil;&atilde;o para a obriga&cedil;&atilde;o"}
        },
        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error');
        }
    });

    if ($("#cad_obr").valid() == true) {
        $.post("../controller/TRIEmpresas.php", {
            acao:          $("#acao").val(),
            ob_id:         $("#ob_id").val(), 
            ob_clicod:     $("#ob_clicod").val(), 
            ob_titulo:     $("#ob_titulo").val(),
            ob_depto:      $("#ob_depto").val(),
            ob_ativo:      $("#ob_ativo").val()
        },
                function (data) {
                    if(data.status=="OK"){
                        $("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> ('+data.mensagem+') <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
                        console.log(data.sql);//TO DO mensagem OK
                        //limpa_formulario_all();
                        location.href = "clientes.php?token=" +$("#token").val()+"&cnpj="+$("#cnpj").val()+"&clicod="+$("#ob_clicod").val()+"&tab=obrigac";
                    }
                    else{
                        $("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-flag-checkered"></i> ('+data.mensagem+') <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
                    }
                    
                }, "json");
    }
 }); 
/*----------|CADASTRO DE TRIBUTAÇÕES DO CLIENTE|---------------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado.com                            |
| Date:     26/09/2016                                          |
| Objetivo: Cadastrar Obrigações Acessórias para uso rotineiro  |
\*-------------------------------------------------------------*/
$(document.body).on("click","#bt_cadTrib",function(){
    tipo = "cadastrar";
    var container = $("#formerros_trib");
    $("#cad_trib").validate({
        debug: true,
        errorClass: "error",
        errorContainer: container,
        errorLabelContainer: $('ol', container),
        wrapper: 'li',
        rules: {
            tr_titulo:  {required: true},
            tr_ativo:   {required: true}
        },
        messages: {
            tr_titulo:   {required: "Escolha uma tributação"},
            tr_ativo:    {required: "Escolha uma op&cedil;&atilde;o para a tributa&cedil;&atilde;o"}
        },
        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error');
        }
    });

    if ($("#cad_trib").valid() == true) {
        $.post("../controller/TRIEmpresas.php", {
            acao:          $("#acao").val(),
            tr_id:         $("#tr_id").val(), 
            tr_clicod:     $("#tr_clicod").val(), 
            tr_titulo:     $("#tr_titulo").val(),
            tr_depto:      $("#tr_depto").val(),
            tr_ativo:      $("#tr_ativo").val()
        },
                function (data) {
                    if(data.status=="OK"){
                        $("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> ('+data.mensagem+') <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
                        console.log(data.sql);//TO DO mensagem OK
                        //limpa_formulario_all();
                        location.href = "clientes.php?token=" +$("#token").val()+"&cnpj="+$("#cnpj").val()+"&clicod="+$("#tr_clicod").val()+"&tab=tribut";
                    }
                    else{
                        $("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-flag-checkered"></i> ('+data.mensagem+') <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
                    }
                    
                }, "json");
    }
 }); 
/*---------------|GERAR CARTEIRAS FISCAL|----------------------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado@gmail.com                      |
| Date:     27/09/2016                                          |
\*-------------------------------------------------------------*/
$(document.body).on("change","#cf_colab",function(){
    console.log($(this).val());
    if($(this).val()==0){
        $("#gcart").attr("disabled",true);
    }
    else{
        $("#gcart").attr("disabled",false);
        
    }
});

$(document.body).on("click","#gcart", function () {
    $(this).html("<i class='fa fa-spinner fa-spin'></i> Gerando...");
    
    // solução para pegar todos os check de IR marcados para a geraçao do boleto
    var checkeditems = $('input:checkbox[name="emp_cods[]"]:checked')
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
                user     : $("#cf_colab").val(),
                dep      : $("#ef").val()
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
    $("#gcart").html("<i class='fa fa-user'></i> Associar");
});     
/*---------------|FILTRO CARTEIRA FISCAL|----------------------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado@gmail.com                      |
| Date:     30/09/2016                                          |
\*-------------------------------------------------------------*/
$(document.body).on("click","#fisPesq",function(){
    tipo = "aguarde";
    //$(this).html("<i class='fa fa-spin fa-spinner'></i> Processando...");
    var emp = ($("#pes_fisEmpresa").val()===null?"":$("#pes_fisEmpresa").val());
    var tri = $("#pes_fisTributacao").val();
    var imp = $("#pes_fisTributo").val();
    var tip = $("#pes_fisTipo").val(); //funcionários
    console.log("vis_cartfiscal.php?emp="+emp+"&tri="+tri+"&imp="+imp+"&tip="+tip);
    $("#rescfis").load("vis_cartfiscal.php?emp="+emp+"&tri="+tri+"&imp="+imp+"&tip="+tip);

    $("#bt_cartfis_rel").attr("href","../rel/rel_cartfiscal.php?emp="+emp+"&tri="+tri+"&imp="+imp+"&tip="+tip+"&r=1");
});
/*---------------|FILTRO CARTEIRA DP|--------------------------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado@gmail.com                      |
| Date:     30/09/2016                                          |
\*-------------------------------------------------------------*/


$(document.body).on("click","#dpPesq",function(){
    tipo = "aguarde";
	var emp = ($("#pes_dpEmpresa").val()===null?"":$("#pes_dpEmpresa").val());
    var tip = $("#pes_dpTipo").val();
    var por = $("#pes_dpPorte").val();
    console.log("vis_cartdp.php?emp="+emp+"&tip="+tip+"&por="+por);
    $("#respdp").load("vis_cartdp.php?emp="+emp+"&tip="+tip+"&por="+por);
});

/*---------------|FILTRO CARTEIRA CONTÁBIL|--------------------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado@gmail.com                      |
| Date:     02/10/2016                                          |
\*-------------------------------------------------------------*/


$(document.body).on("click","#ctPesq",function(){
    tipo = "aguarde";
	var emp = ($("#pes_ctEmpresa").val()===null?"":$("#pes_ctEmpresa").val());
    var tip = $("#pes_ctTipo").val();
    //var por = $("#pes_dpPorte").val();
    console.log("vis_cartcontabil.php?emp="+emp+"&tip="+tip/*+"&por="+por*/);
    $("#respct").load("vis_cartcontabil.php?emp="+emp+"&tip="+tip/*+"&por="+por*/);
    $("#bt_cartcon_rel").attr("href","../rel/rel_cartcontabil.php?emp="+emp+"&tip="+tip+"&r=1");
});


/*---------------|GERAR CARTEIRAS CONTABIL|--------------------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado@gmail.com                      |
| Date:     27/09/2016                                          |
\*-------------------------------------------------------------*/
$(document.body).on("change","#cc_colab",function(){
    console.log($(this).val());
    if($(this).val()==0){
        $("#gccart").attr("disabled",true);
    }
    else{
        $("#gccart").attr("disabled",false);
        
    }
});

$(document.body).on("click","#gccart", function () {
    $(this).html("<i class='fa fa-spinner fa-spin'></i> Gerando...");
    
    // solução para pegar todos os check de IR marcados para a geraçao do boleto
    var checkeditems = $('input:checkbox[name="emp_cods[]"]:checked')
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
                user     : $("#cc_colab").val(),
                dep      : $("#dc").val()
            },
            function(data){
                if(data.status=="OK"){
                        $("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> '+data.mensagem+' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
                        //location.reload();
                        
                    } else{
                        $("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-times"></i> Ocorreu um erro! ('+data.mensagem+')<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
                    }
                    console.log(data.sql);//TO DO mensagem OK
            },
            "json"
        );
    }
    $("#gccart").html("<i class='fa fa-user'></i> Associar");
}); 

/*---------------|SELECT ALL CONTABIL|-------------------------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado@gmail.com                      |
| Date:     03/10/2016                                          |
\*-------------------------------------------------------------*/
$('.checkAll').click(function(){
	$('input:checkbox').each(function(){
		$(this).prop('checked',true);
   })               
});

$('.uncheckAll').click(function(){
	$('input:checkbox').each(function(){
		$(this).prop('checked',false);
   })               
});

$(document.body).on("click","#bt_ctSel.btn-success",function(){
	$(this).removeClass("btn-success").addClass("btn-danger");
	$(this).html("<i class='fa fa-times'></i> Nenhum");
	$('input:checkbox').each(function(){
		$(this).prop('checked',true);
   })               
});

$(document.body).on("click","#bt_ctSel.btn-danger",function(){
	$(this).removeClass("btn-danger").addClass("btn-success");
	$(this).html("<i class='fa fa-check'></i> Todos");
	$('input:checkbox').each(function(){
		$(this).prop('checked',false);
   })               
});

/*---------------|GERAR CARTEIRAS DP|--------------------------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado@gmail.com                      |
| Date:     27/09/2016                                          |
\*-------------------------------------------------------------*/
$(document.body).on("change","#cd_colab",function(){
    console.log($(this).val());
    if($(this).val()==0){
        $("#gdcart").attr("disabled",true);
    }
    else{
        $("#gdcart").attr("disabled",false);
        
    }
});

$(document.body).on("click","#gdcart", function () {
    $(this).html("<i class='fa fa-spinner fa-spin'></i> Gerando...");
    
    // solução para pegar todos os check de IR marcados para a geraçao do boleto
    var checkeditems = $('input:checkbox[name="emp_cods[]"]:checked')
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
                user     : $("#cd_colab").val(),
                dep      : $("#dp").val()
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
    $("#gdcart").html("<i class='fa fa-user'></i> Associar");
});

/*---------|CADASTRO DE IMPOSTOS VIGENTES|---------------------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado@gmail.com                      |
| Date:     29/09/2016                                          |
| Objetivo: Cadastrar impostos com datas que devem ser          |
|           usadas no cadastro de imposto dos clientes.         |
\*-------------------------------------------------------------*/
$(document.body).on("click","#bt_cadimpostos",function(){
    tipo = "cadastrar";
    var container = $("#formerros_impostos");
    $("#cad_imposto").validate({
        debug: true,
        errorClass: "error",
        errorContainer: container,
        errorLabelContainer: $('ol', container),
        wrapper: 'li',
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        rules: {
            imp_nome:       {required: true},
            /*
            Obsoleto na versão 1.1.6
            imp_pasta:      {required: true},
            imp_arquivo:    {required: true},
            */
            imp_depto:      {required: true},
            imp_regra:      {required: true},
            imp_trib:       {required: true},
            imp_desc:       {required: true}
        },
        messages: {
            imp_nome:       {required: "Digite o nome do Imposto:"},
            /*
            Obsoleto na versão 1.1.6
            imp_pasta:      {required: "Em que pasta o arquivo &eacute; armazenado?"},
            imp_arquivo:    {required: "Qual sera o nome do arquivo?"},
            */
            imp_depto:      {required: "Qual o departamento do imposto?"},
            imp_regra:      {required: "Qual aregra de datas para esse imposto?"},
            imp_trib:       {required: "Qual o tipo para esse imposto?"},
            imp_desc:       {required: "Forne&ccedil;a detalhes para do imposto"}
        },
        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error');
        }
    });

    if ($("#cad_imposto").valid() == true) {
        $.post("../controller/TRIEmpresas.php", {
            acao:          $("#acao").val(),
            imp_id:        $("#imp_id").val(),
            imp_nome:      $("#imp_nome").val(),
            imp_depto:     $("#imp_depto").val(),
            imp_tipo:      $("#imp_trib").val(),
            imp_regra:     $("#imp_regra").val(),
             /*
            Obsoleto na versão 1.1.6
            imp_pasta:     $("#imp_pasta").val(),
            imp_arquivo:   $("#imp_arquivo").val(),
            */
            imp_venc:      $("#imp_venc").val(),
            imp_mes:      $("#imp_mes").val(),
            imp_desc:      CKEDITOR.instances.imp_desc.getData()
        },
                function (data) {
                    if(data.status=="OK"){
                        $("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> ('+data.mensagem+') <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
                        console.log(data.sql);//TO DO mensagem OK
                        //limpa_formulario_all();
                        location.href = "impostos.php?token=" +$("#token").val()+"&cnpj="+$("#cnpj").val();
                    }
                    else{
                        $("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-flag-checkered"></i> ('+data.mensagem+') <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
                    }
                    
                }, "json");
    }
 });

/*-----|POPULANDO O COMBO EMPREGADOS PELO TIPO DA EMPRESA|-----*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado@gmail.com                      |
| Date:     30/09/2016                                          |
| Objetivo: Popular  o campo de empregados de acordo com 		|
| 			o tipo da empresa          							|
\*-------------------------------------------------------------*/
$(document.body).on("change","#emp_tipo",function(){
	tipo: "aguarde";
	$.post("../controller/TRIEmpresas.php",
	{
		acao: "combo_func", 
		emp_tipo: $(this).val()
	},
	function(data){
		$("#emp_funcs").html(data);
	}
	, "html");
});

/*-----|POPULANDO O COMBO MATERIAIS PELO COD DA CATEGORIA|-----*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado@gmail.com                      |
| Date:     18/11/2016                                          |
| Objetivo: Popular  o campo de materiais pelo cod da categoria |
\*-------------------------------------------------------------*/
$(document.body).on("change","#mat_categoria",function(){
    tipo: "aguarde";
    $.post("../controller/TRIEmpresas.php",
    {
        acao: "combo_mat", 
        mcat_id: $(this).val()
    },
    function(data){
        $("#mat_cadastro").html(data);
    }
    , "html");
});

/*---------------|CONF NAO|------------------------------------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado@gmail.com                      |
| Date:     11/11/2016                                          |
| Limpa as mensagens armazenadas em msgConf                     |
\*-------------------------------------------------------------*/
$(document.body).on("click", "#confNao", function(){
    $("#msg_conf").html("");
    $("#confSim").data("reg","");
});
/*---------------|EXCLUIR PARTICULARIDADES|--------------------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado@gmail.com                      |
| Date:     11/11/2016                                          |
\*-------------------------------------------------------------*/
    
/*|COM A CLASSE excPart, FAZER A EXCLUSÃO DO BD|*/
$(document.body).on("click",".excPart",function(){
    console.log("CLICK OK");
    cod = $(this).data("reg");
    $.post("../controller/TRIEmpresas.php",{
        acao: "exclui_part",
        part_id: cod
    },
    function(data){
        if(data.status=="OK"){
            alert(data.mensagem);
            location.reload();
        } 
        else{
            alert(data.mensagem);   
        }
    },
    "json");
    
}); 

/*---------------|EXCLUIR OBRIGAÇÕES|--------------------------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado@gmail.com                      |
| Date:     27/03/2017                                          |
\*-------------------------------------------------------------*/
    
/*|COM A CLASSE excPart, FAZER A EXCLUSÃO DO BD|*/
$(document.body).on("click",".exc_Obrigac",function(){
    console.log("CLICK OK");
    cod = $("#cod").val();
    $.post("../controller/TRIEmpresas.php",{
        acao: "exclui_obrigac",
        ob_id: $(this).data("reg"),
        cod : cod    
    },
    function(data){
        if(data.status=="OK"){
            alert(data.mensagem);
            location.reload();
        } 
        else{
            alert(data.mensagem);   
        }
    },
    "json");
    
}); 
/*---------------|EXCLUIR ARQUIVOS|----------------------------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado@gmail.com                      |
| Date:     09/08/2017                                          |
\*-------------------------------------------------------------*/
    
/*|COM A CLASSE excPart, FAZER A EXCLUSÃO DO BD|*/
$(document.body).on("click",".exc_Arquivo",function(){
    console.log("CLICK OK");
    cod = $("#cod").val();
    $.post("../controller/TRIEmpresas.php",{
        acao: "exclui_arquivo",
        arq_id: $(this).data("reg")
    },
    function(data){
        if(data.status=="OK"){
            alert(data.mensagem);
            location.reload();
        } 
        else{
            alert(data.mensagem);   
        }
    },
    "json");
    
}); 

/*---------------|EXCLUIR BENEFICIOS IRPF|---------------------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado@gmail.com                      |
| Date:     11/11/2016                                          |
\*-------------------------------------------------------------*/
    
/*|COM A CLASSE exc_benef, FAZER A EXCLUSÃO DO BD|*/
$(document.body).on("click",".exc_benef",function(){
    console.log("CLICK OK");
    cod = $(this).data("reg");
    $.post("../controller/TRIEmpresas.php",{
        acao: "exclui_benef",
        codigo: cod
    },
    function(data){
        if(data.status=="OK"){
            alert(data.mensagem);
            location.reload();
        } 
        else{
            alert(data.mensagem);   
        }
    },
    "json");
    
}); 



/*---------------|CADASTRAR MATERIAIS|-------------------------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado@gmail.com                      |
| Date:     23/11/2016                                          |
\*-------------------------------------------------------------*/
    $(document.body).on("click","#CadMat", function(){
        var container = $("#formerrosCadMateriais");
        $("#cad_cadMat").validate({
            debug: true,
            errorClass: "error",
            errorContainer: container,
            errorLabelContainer: $("ol", container),
            wrapper: 'li',
            rules: {
                mat_cat  : {required: true, min:1},
                mat_qtdmin          : {required: true, min:0},
                mat_commin          : {required: true, min:0},
                mat_desc            : {required: true}
            },
            messages: {
                mat_cat     : {required: "Escolha a categoria", min:"Escolha a categoria"},
                mat_qtdmin  : {required: "Informe a quantidade m&iacute;nima", min:"Valor incorreto!"},
                mat_commin  : {required: "Informe a quantidade m&iacute;nima de compra", min:"Valor incorreto!"},
                mat_desc    : {required: "Informme o Nome do material"}
            },
            highlight: function(element) {
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function(element) {
                $(element).closest('.form-group').removeClass('has-error');
            }
        });
        if($("#cad_cadMat").valid()==true){
            $("#CadMat").html("<i class='fa fa-cog fa-spin'></i> Processando...");
            $.post("../controller/TRIEmpresas.php",{
                acao            : "inclui_matCad",
                mat_categorias  : $("#mat_cat").val(),
                mat_qtd         : $("#mat_qtdmin").val(),
                mat_commin      : $("#mat_commin").val(),
                mat_desc        : $("#mat_desc").val()
                },
                function(data){
                    if(data.status=="OK"){
                        $("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> '+data.mensagem+' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
                        $("#cad_cadMat")[0].reset();
                        $("#mat_cat").select2("val",0);
                        //$("#slc").load("vis_solic.php").fadeIn("slow");
                        $("#CadMat").html("<i class='fa fa-plus'></i> Solicitar");
                        location.reload();
                        
                    } else{
                        $("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-times"></i> Ocorreu um erro! ('+data.mensagem+')<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
                    }
                    console.log(data.sql);//TO DO mensagem OK
                },
                "json"
            );
        }
    });


/*-----------------|ALTERAR MATERIAIS|-------------------------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado@gmail.com                      |
| Date:     28/11/2016                                          |
\*-------------------------------------------------------------*/
    $(document.body).on("click","#AltMat",function(){
        $("#AltMat").html("<i class='fa fa-cog fa-spin'></i> Processando...");
        $.post("../controller/TRIEmpresas.php",{
            acao            : "alt_matCad",
            prod            : $("#mat_id").val(),
            mat_categorias  : $("#mat_cat").val(),
            mat_qtd         : $("#mat_qtdmin").val(),
            mat_commin      : $("#mat_commin").val(),
            mat_desc        : $("#mat_desc").val()
            },
            function(data){
                if(data.status=="OK"){
                    $("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> '+data.mensagem+' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
                    $("#cad_cadMat")[0].reset();
                    $("#mat_cat").select2("val",0);
                    //$("#slc").load("vis_solic.php").fadeIn("slow");
                    $("#CadMat").html("<i class='fa fa-plus'></i> Solicitar");
                    location.reload();
                    
                } else{
                    $("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-times"></i> Ocorreu um erro! ('+data.mensagem+')<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
                }
                console.log(data.sql);//TO DO mensagem OK
            },
            "json"
        );
        $("#AltMat").html("<i class='fa fa-pencil'></i> Alterar");
    });

/*---------------|SOLICITAR MATERIAIS|-------------------------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado@gmail.com                      |
| Date:     18/11/2016                                          |
\*-------------------------------------------------------------*/

    $(document.body).on("click","#bt_solicMat", function(){
        var container = $("#formerrosMateriais");
        $("#cad_solMat").validate({
            debug: true,
            errorClass: "error",
            errorContainer: container,
            errorLabelContainer: $("ol", container),
            wrapper: 'li',
            rules: {
                mat_categoria: {required: true, min:0},
                mat_cadastro : {required: true, min:0},
                mat_qtd      : {required: true, min:0},
                mat_opera    : {required: true},
                mat_obs      : {required: true}
            },
            messages: {
                mat_categoria: {required: "Escolha a categoria", min:"Informe a Categoria!"},
                mat_cadastro : {required: "Informe o Produto", min:"Informe o Produto!"},
                mat_qtd      : {required: "Digite a Quantidade", min:"Valor Incorreto!"},
                mat_opera    : {required: "Informe a natureza da opera&ccedil;&atilde;o"},
                mat_obs      : {required: "Descreva seu pedido"}
            },
            highlight: function(element) {
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function(element) {
                $(element).closest('.form-group').removeClass('has-error');
            }
        });
        if($("#cad_solMat").valid()==true){
            $("#bt_solicMat").html("<i class='fa fa-cog fa-spin'></i> Processando...");
            $.post("../controller/TRIEmpresas.php",{
                acao            : "inclui_matSol",
                mat_categoria   : $("#mat_categoria").val(),
                mat_cadastro    : $("#mat_cadastro").val(),
                mat_qtd         : $("#mat_qtd").val(),
                mat_opera       : $("#mat_opera").val(),
                mat_obs         : $("#mat_obs").val()
                },
                function(data){
                    if(data.status=="OK"){
                        $("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> '+data.mensagem+' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
                        $("#cad_solMat")[0].reset();
                        $("#mat_opera").select2("val","O");
                        $("#mat_categoria").select2("val",0);
                        $("#mat_cadastro").select2("val",0);
                        //$("#slc").load("vis_solic.php").fadeIn("slow");
                        $("#bt_solicMat").html("<i class='fa fa-plus'></i> Solicitar");
                        //location.reload();
                        
                    } else{
                        $("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-times"></i> Ocorreu um erro! ('+data.mensagem+')<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
                    }
                    console.log(data.sql);//TO DO mensagem OK
                },
                "json"
            );
        }
    });


/*--------|PESQUISA QUANTIDADE DE MATERIAL DISPONIVEL|---------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado@gmail.com                      |
| Date:     21/11/2016                                          |
\*-------------------------------------------------------------*/
    $(document.body).on("change","#mat_cadastro",function(){
        $.post("../controller/TRIEmpresas.php",
            {
                acao    : "pesq_mat",
                codId   : $(this).val(),
                catId   : $("#mat_categoria").val()
            },
            function(data){

                $("#mat_qtdDis").val(data);
            },
        "html");
    });

/*----------------|CONDIÇÕES DE PREENCHIMENTO|-----------------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado@gmail.com                      |
| Date:     21/11/2016                                          |
\*-------------------------------------------------------------*/

    $(document.body).on("keyup","#mat_qtd",function(){
        var pedi = parseInt($(this).val());
        var disp = parseInt($("#mat_qtdDis").val());
        var oper = $("#mat_opera").val();
        if(oper == 'O'){
            if(pedi > disp){
                alert("Quantidade maior que o disponível!");
                $(this).val("");
            }
        }
    });

    $(document.body).on("change","#mat_opera",function(){
        $("#mat_qtd").val("");
    });
/*---------------|BAIXAR ITENS DE MATERIAIS|-------------------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado@gmail.com                      |
| Date:     21/11/2016                                          |
\*-------------------------------------------------------------*/

    $(document.body).on("click",".ent_mat",function(){
        console.log("CLICK OK");
        cod = $(".ent_mat").data('reg');
        $.post("../controller/TRIEmpresas.php",{
            acao: "entregar_mat",
            mat_id: cod
        },
        function(data){
            if(data.status=="OK"){
                $("#confirma").modal("hide");
                $("#aguarde").modal("show");
                location.reload();
            } 
            else{
                alert(data.mensagem);   
            }
        },
        "json");
    });

/*---------------|NEGAR ITENS DE MATERIAIS|--------------------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado@gmail.com                      |
| Date:     21/11/2016                                          |
\*-------------------------------------------------------------*/

    $(document.body).on("click",".neg_mat",function(){
        console.log("CLICK OK");
        cod = $(".neg_mat").data('reg');
        $.post("../controller/TRIEmpresas.php",{
            acao: "nega_mat",
            mat_id: cod
        },
        function(data){
            if(data.status=="OK"){
                $("#confirma").modal("hide");
                $("#aguarde").modal("show");
                location.reload();
            } 
            else{
                alert(data.mensagem);   
            }
        },
        "json");
    });

/*---------------|PESQUISA IMPOSTO|----------------------------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado@gmail.com                      |
| Date:     03/11/2016                                          |
\*-------------------------------------------------------------*/

   /* $(document.body).on("click","#bt_impsearch",function(){
        nome = "bt_impsearch";
        tipo = "<i class='fa fa-search'></i>"
        var imp     = $("#imp_desc").val();
        var token   = $("#token").val();
        console.log("vis_impfiscal.php?imp="+imp+"&token="+token);
        location.reload("vis_impfiscal.php#slc?imp="+imp+"&token="+token);
        
    });*/
/*---------------|PESQUISA IMPOSTO POR EMPRESA|----------------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado@gmail.com                      |
| Date:     07/11/2016                                          |
\*-------------------------------------------------------------*/

    $(document.body).on("click","#btn_pesqImp",function(){
        var filtros = 0;
        $(this).html("<i class='fa fa-spin fa-spinner'></i>");
        if($("#sel_emp").val()!=""){filtros = filtros+1;}
        if($("#sel_dep").val()!=""){filtros = filtros+1;}
        if($("#sel_imp").val()!=""){filtros = filtros+1;}
        if($("#sel_usu").val()!=""){filtros = filtros+1;}
        if($("#sel_comp").val()!=""){filtros = filtros+1;}
        if(filtros <2){
            alert("Utilize no mínimo 2 filtros para a pesquisa!");
            $("#btn_pesqImp").html("<i class='fa fa-search'></i>");
        }
        else{
            $.post("../controller/TRIEmpresas.php",
                {
                    acao:   "imp_pesq", 
                    emp:    $("#sel_emp").val(),
                    dep:    $("#sel_dep").val(),
                    imp:    $("#sel_imp").val(),
                    usu:    $("#sel_usu").val(),
                    comp:    $("#sel_comp").val()
                },
                function(data){
                    $("#btn_pesqImp").html("<i class='fa fa-search'></i>");
                    $("#tbl_dados").html(data);//.fadeOut("slow").html(data);//.fadeIn("slow");
                    $(".chk_imp").bootstrapToggle({
                        on: "Sim",
                        off: "Não"
                    });
                }
                , "html"
            );
            var empresa = ($("#sel_emp").val()==""?0:$("#sel_emp").val());
            $("#emp_sen").load("vis_senhasemp.php?emp="+empresa); 
            
        }
        
    });

/*---------------|FILTRAR IMPOSTOS A CONFERIR|-----------------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado@gmail.com                      |
| Date:     12/05/2017                                          |
\*-------------------------------------------------------------*/

    $(document.body).on("click","#btn_pespc",function(){
        $(this).html("<i class='fa fa-spin fa-spinner'></i>");
        var emp = $("#pc_emp").val();
        var imp = $("#pc_imp").val();
        var usu = $("#pc_usu").val();
        var comp = $("#pc_comp").val();

        $("#pesq_conf").load("vis_impconferir.php?emp="+emp+"&imp="+imp+"&usu="+usu+"&comp="+comp, 
            function(){
                $("#btn_pespc").html("<i class='fa fa-search'></i>");    
            }
        );
    });

/*----------------|FILTRAR IMPOSTOS A ENVIAR|------------------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado@gmail.com                      |
| Date:     12/05/2017                                          |
\*-------------------------------------------------------------*/

    $(document.body).on("click","#btn_pespe",function(){
        $(this).html("<i class='fa fa-spin fa-spinner'></i>");
        var emp = $("#pe_emp").val();
        var imp = $("#pe_imp").val();
        var usu = $("#pe_usu").val();
        var comp = $("#pe_comp").val();

        $("#pesq_env").load("vis_impenviar.php?emp="+emp+"&imp="+imp+"&usu="+usu+"&comp="+comp, 
            function(){
                $("#btn_pespe").html("<i class='fa fa-search'></i>");    
            }
        );
    });

/*----------------|FILTRAR IMPOSTOS A CONFERIR ENVIO|----------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado@gmail.com                      |
| Date:     12/05/2017                                          |
\*-------------------------------------------------------------*/

    $(document.body).on("click","#btn_pesce",function(){
        $(this).html("<i class='fa fa-spin fa-spinner'></i>");
        var emp = $("#ce_emp").val();
        var imp = $("#ce_imp").val();
        var usu = $("#ce_usu").val();
        var comp = $("#ce_comp").val();

        $("#pesq_cenv").load("vis_confenviar.php?emp="+emp+"&imp="+imp+"&usu="+usu+"&comp="+comp, 
            function(){
                $("#btn_pesce").html("<i class='fa fa-search'></i>");    
            }
        );
    });

/*----------------|FILTRAR PRODUTIVIDADE|----------------------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado@gmail.com                      |
| Date:     17/05/2017                                          |
\*-------------------------------------------------------------*/

    $(document.body).on("click","#btn_pesqarea",function(){
        $(this).html("<i class='fa fa-spin fa-spinner'></i>");
        var envio = $("#area_envio").val();
        var dep = $("#area_dep").val();
        var usu = $("#area_usu").val();
        var comp = $("#area_comp").val();
        $("#areachart").fadeOut("slow");
        $("#areachart").load("vis_prodarea.php?envio="+envio+"&dep="+dep+"&usuario="+usu+"&competencia="+comp, 
            function(){
                $("#btn_pesqarea").html("<i class='fa fa-search'></i>");    
            }
        ).fadeIn("slow");
    });

/*----------------|GRAFICO DE PRODUTIVIDADE|-------------------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado@gmail.com                      |
| Date:     06/07/2017                                          |
\*-------------------------------------------------------------*/

    $(document.body).on("click","#btn_pesqprod",function(){
        //$(this).html("<i class='fa fa-spin fa-spinner'></i>");
        var emp = $("#prod_emp").val();
        var dep = $("#prod_dep").val();
        var usu = $("#prod_usu").val();
        var comp = $("#prod_comp").val();
        $("#graficos").fadeOut("slow");
        $("#graficos").load("vis_graficos.php?empresa="+emp+"&depto="+dep+"&usuario="+usu+"&competencia="+comp, 
            function(){
                $("#btn_pesce").html("<i class='fa fa-search'></i>");    
            }
        ).fadeIn("slow");
    });

/*----------------|FILTRAR PROD MENSAL|------------------------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado@gmail.com                      |
| Date:     17/05/2017                                          |
\*-------------------------------------------------------------*/

    $(document.body).on("click","#btn_pesqmensal",function(){
        $(this).html("<i class='fa fa-spin fa-spinner'></i>");
        var emp = $("#mensal_emp").val();
        var imp = $("#mensal_imp").val();
        var usu = $("#mensal_usu").val();
        var comp = $("#mensal_comp").val();
        $("#tbl_mensal").fadeOut("slow");
        $("#tbl_mensal").load("vis_mensalprod.php?empre="+emp+"&impos="+imp+"&usua="+usu+"&compet="+comp, 
            function(){
                $("#btn_pesqmensal").html("<i class='fa fa-search'></i>");    
            }
        ).fadeIn("slow");
    });

/*----------------|FILTRAR PRODUTIVIDADE|----------------------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado@gmail.com                      |
| Date:     17/05/2017                                          |
\*-------------------------------------------------------------*/

    $(document.body).on("click","#btn_pesqprogress",function(){
       
        $(this).html("<i class='fa fa-spin fa-spinner'></i>");
        var emp = $("#progr_emp").val();
        var dep = $("#progr_dep").val();
        var usu = $("#progr_usu").val();
        var timp = $("#progr_timp").val();
        var comp = $("#progr_comp").val();
        //$("#show_progress").fadeOut("slow");
        $("#show_progress").load("vis_dados_progresso.php?emp="+emp+"&dep="+dep+"&usu="+usu+"&timp="+timp+"&comp="+comp, 
            function(){
                $("#btn_pesqprogress").html("<i class='fa fa-search'></i>");
            }
        ).fadeIn("slow");
    });

/*---------------|PESQUISA IMPOSTO POR EMPRESA|----------------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado@gmail.com                      |
| Date:     01/06/2017                                          |
\*-------------------------------------------------------------*/

    $(document.body).on("click","#btn_pesfila",function(){
        $(this).html("<i class='fa fa-spin fa-spinner'></i>");
       
        $.post("../controller/TRIProdutividade.php",
            {
                acao:   "fila_arquivo", 
                emp:    $("#tar_emp").val(),
                imp:    $("#tar_arq").val(),
                usu:    $("#tar_usu").val(),
                comp:    $("#tar_comp").val()
            },
            function(data){
                $("#btn_pesfila").html("<i class='fa fa-search'></i>");
                $("#tbl_fila").fadeOut("slow").html(data).fadeIn("slow");
                $(".chk_imp").bootstrapToggle({
                    on: "Sim",
                    off: "Não"
                });
            }
            , "html"
        );
        
    });

/*---------------|DISPONIBILIZA ARQUIVO PARA A FILA|-----------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado@gmail.com                      |
| Date:     02/06/2017                                          |
\*-------------------------------------------------------------*/

    $(document.body).on("click","#bt_dispArq",function(){
        $(this).html("<i class='fa fa-spin fa-spinner'></i>");
        var token = $("#token").val();
        var cnpj = $("#cnpj").val();
        var container = $("#formerrosFila");
        $("#cad_filaimporta").validate({
            debug: true,
            errorClass: "error",
            errorContainer: container,
            errorLabelContainer: $("ol", container),
            wrapper: 'li',
            rules: {
                trata_usu: {required:true}
            },
            messages: {
                trata_usu: {required:"Escolha o funcionário reponsável pela importação"}
            },
            highlight: function(element) {
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function(element) {
                $(element).closest('.form-group').removeClass('has-error');
            }
        });
        if($("#cad_filaimporta").valid()==true){
            $.post("../controller/TRIProdutividade.php",
                {
                    acao:   "disp_arquivo", 
                    arq:    $("#trata_id").val(),
                    empresa: $("#cod_empresa").val(),
                    compet: $("#trata_competencia").val(),
                    venc:   $("#trata_venc").val(),
                    resp:   $("#trata_usu").val(),
                    cart:   $("#trata_respc").val(),
                    obs:     CKEDITOR.instances.editor1.getData()
                },
                function(data){
                    if(data.status=="OK"){
                        $("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> '+data.mensagem+' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
                        location.href = "index.php?token="+token+"&cnpj="+cnpj;
                        
                    } else{
                        $("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-times"></i> Ocorreu um erro! ('+data.mensagem+')<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
                    }
                    
                }
                , "json"
            ); 
        }
        $("#bt_dispArq").html("<i class='fa fa-mail-forward'></i> Disponibilizar");
        //location.href = "index.php?token="+token+"&cnpj="+cnpj;
        
    });

/*---------------|DISPONIBILIZA ARQUIVO PARA A FILA|-----------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado@gmail.com                      |
| Date:     02/06/2017                                          |
\*-------------------------------------------------------------*/

    $(document.body).on("click","#bt_finArq",function(){
        $(this).html("<i class='fa fa-spin fa-spinner'></i>");
        var token = $("#token").val();
        var cnpj = $("#cnpj").val();
        $.post("../controller/TRIProdutividade.php",
            {
                acao:   "fin_arquivo", 
                arq:    $("#trata_id").val(),
                obs:     CKEDITOR.instances.editor1.getData()
            },
            function(data){
                if(data.status=="OK"){
                    $("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> '+data.mensagem+' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
                    location.href = "index.php?token="+token+"&cnpj="+cnpj;
                    
                } else{
                    $("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-times"></i> Ocorreu um erro! ('+data.mensagem+')<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
                }
                
                $("#bt_finArq").html("<i class='fa fa-check-square-o'></i> Finalizar");
            }
            , "json"
        );
        
    });

/*---------------|DISPONIBILIZA ARQUIVO PARA A FILA|-----------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado@gmail.com                      |
| Date:     02/06/2017                                          |
\*-------------------------------------------------------------*/

    $(document.body).on("click","#bt_errArq",function(){
        $(this).html("<i class='fa fa-spin fa-spinner'></i>");
        var token = $("#token").val();
        var cnpj = $("#cnpj").val();
        $.post("../controller/TRIProdutividade.php",
            {
                acao:   "err_arquivo", 
                arq:    $("#trata_id").val(),
                empresa: $("#cod_empresa").val(),
                obs:     CKEDITOR.instances.editor1.getData()
            },
            function(data){
                if(data.status=="OK"){
                    $("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> '+data.mensagem+' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
                    location.href = "index.php?token="+token+"&cnpj="+cnpj;
                } else{
                    $("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-times"></i> Ocorreu um erro! ('+data.mensagem+')<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
                }
                
                $("#bt_errArq").html("<i class='fa fa-times'></i> Contém Erros");
            }
            , "json"
        );
        
    });

/*---------------------|EXCLUIR DOCUMENTOS|--------------------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado@gmail.com                      |
| Date:     28/11/2016                                          |
\*-------------------------------------------------------------*/
    
    /*|COM A CLASSE excPart, FAZER A EXCLUSÃO DO BD|*/
    $(document.body).on("click",".exc_doc",function(){
        console.log("CLICK OK");
        cod = $(this).data("reg");
        $.post("../controller/TRIEmpresas.php",{
            acao: "exclui_doc",
            doc_id: cod
        },
        function(data){
            if(data.status=="OK"){
                alert(data.mensagem);
                location.reload();
            } 
            else{
                alert(data.mensagem);   
            }
        },
        "json");
    });

/*-------------------|SOLICITAR RECALCULOS|--------------------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado@gmail.com                      |
| Date:     01/12/2016                                          |
\*-------------------------------------------------------------*/

    $(document.body).on("click","#bt_recalc", function(){
        var container = $("#formerrosCalc");
        $("#cad_Calc").validate({
            debug: true,
            errorClass: "error",
            errorContainer: container,
            errorLabelContainer: $("ol", container),
            wrapper: 'li',
            rules: {
                calc_emp:   {required:true},
                calc_doc:   {required:true},
                calc_comp:  {required:true},
                calc_qtd: {required:true, number:true},
                calc_valor: {required:true, number:true}
            },
            messages: {
                calc_emp:   {required:"Escolha a empresa..."},
                calc_doc:   {required:"Escolha o tipo do cálculo..."},
                calc_comp:  {required:"Digite a referência do cálculo..."},
                calc_qtd: {required:"Campo valor obrigatório", number:"Digite um valor numérico"},
                calc_valor: {required:"Campo valor obrigatório", number:"Digite um valor numérico, decimal separados por '.'- Ex: 12.00; 13.50"}
            },
            highlight: function(element) {
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function(element) {
                $(element).closest('.form-group').removeClass('has-error');
            }
        });
        if($("#cad_Calc").valid()==true){
            $("#bt_recalc").html("<i class='fa fa-cog fa-spin'></i> Processando...");
            $.post("../controller/TRIEmpresas.php",{
                acao            : "inclui_recalculo",
                calc_empresa    : $("#calc_emp").val(),
                calc_doc        : $("#calc_doc").val(),
                calc_comp       : $("#calc_comp").val(),
                calc_valor      : $("#calc_valor").val(),
                calc_qtd        : $("#calc_qtd").val(),
                calc_obs        : $("#calc_obs").val()
                },
                function(data){
                    if(data.status=="OK"){
                        $("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> '+data.mensagem+' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
                        $("#cad_Calc")[0].reset();
                        $("#calc_emp").select2("val","O");
                        $("#calc_doc").select2("val",0);
                        $("#slc").load("vis_recalc.php").fadeIn("slow");
                        $("#bt_recalc").html("<i class='fa fa-plus'></i> Solicitar");
                        //location.reload();
                        
                    } else{
                        $("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-times"></i> Ocorreu um erro! ('+data.mensagem+')<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
                    }
                    console.log(data.sql);//TO DO mensagem OK
                },
                "json"
            );
        }
    });
/*---------------------|CALCULAR RECLACULOS|-------------------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado@gmail.com                      |
| Date:     05/12/2016                                          |
\*-------------------------------------------------------------*/
    
    /*|COM A CLASSE save_recalc, FAZER A EXCLUSÃO DO BD|*/
    $(document.body).on("click",".save_recalc",function(){
        console.log("CLICK OK");
        cod = $(this).data("reg");
        $.post("../controller/TRIEmpresas.php",{
            acao: "save_calc",
            rec_id: cod
        },
        function(data){
            if(data.status=="OK"){
                alert(data.mensagem);
                location.reload();
            } 
            else{
                alert(data.mensagem);   
            }
        },
        "json");
    });

/*---------------------|CANCELAR RECLACULOS|-------------------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado@gmail.com                      |
| Date:     05/12/2016                                          |
\*-------------------------------------------------------------*/
    
    /*|COM A CLASSE save_recalc, FAZER A EXCLUSÃO DO BD|*/
    $(document.body).on("click",".exc_recalc",function(){
        console.log("CLICK OK");
        cod = $(this).data("reg");
        $.post("../controller/TRIEmpresas.php",{
            acao: "canc_calc",
            rec_id: cod
        },
        function(data){
            if(data.status=="OK"){
                alert(data.mensagem);
                location.reload();
            } 
            else{
                alert(data.mensagem);   
            }
        },
        "json");
    });


/*---------------------|CANCELAR RECLACULOS|-------------------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado@gmail.com                      |
| Date:     05/12/2016                                          |
\*-------------------------------------------------------------*/
    
    /*|COM A CLASSE save_recalc, FAZER A EXCLUSÃO DO BD|*/
    $(document.body).on("click",".fat_recalc",function(){
        console.log("CLICK OK");
        cod = $(this).data("reg");
        $.post("../controller/TRIEmpresas.php",{
            acao: "fat_recalc",
            rec_id: cod
        },
        function(data){
            if(data.status=="OK"){
                alert(data.mensagem);
                location.reload();
            } 
            else{
                alert(data.mensagem);   
            }
        },
        "json");
    });
/*--------------------|PESQUISAR RECLACULOS|-------------------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado@gmail.com                      |
| Date:     05/12/2016                                          |
\*-------------------------------------------------------------*/
    $(document.body).on("change","#rec_empresa",function(){
        var comp = $("#rec_empresa").val();
        $("#slc").fadeOut("fast").load("vis_recalc.php?comp="+comp).fadeIn("slow");
    });

/*-------------------|SOLICITAR HOMOLOGAÇÃO|--------------------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado@gmail.com                      |
| Date:     19/05/2017                                          |
\*-------------------------------------------------------------*/

    $(document.body).on("click","#bt_homol", function(){
        var container = $("#formerros_homo");
        var checkeditems = $('input:checkbox[name="hom_chk[]"]:checked')
                   .map(function() { return $(this).val() })
                   .get()
                   .join(",");
        if(checkeditems==""){
            alert("Os Documentos para a homologação!");
            
        }
        else{
            $("#cad_homol").validate({
                debug: true,
                errorClass: "error",
                errorContainer: container,
                errorLabelContainer: $("ol", container),
                wrapper: 'li',
                rules: {
                    hom_emp:    {required:true},
                    hom_data:   {required:true},
                    hom_nome:   {required:true},
                    hom_sind:   {required:true},
                    hom_local:  {required:true},
                    hom_hora:   {required:true}
                },
                messages: {
                    hom_emp:    {required:"Escolha a empresa..."},
                    hom_data:   {required:"Digite a data"},
                    hom_nome:   {required:"Digite o nome do homologado"},
                    hom_sind:   {required:"Entre com o nome do sindicato"},
                    hom_local:  {required:"Digite o Local da HOMOLOGAÇÃO"},
                    hom_hora:   {required:"Digite o horário da HOMOLOGAÇÃO"}
                },
                highlight: function(element) {
                    $(element).closest('.form-group').addClass('has-error');
                },
                unhighlight: function(element) {
                    $(element).closest('.form-group').removeClass('has-error');
                }
            });
            if($("#cad_homol").valid()==true){
                $("#bt_homol").html("<i class='fa fa-cog fa-spin'></i> Processando...");
                $.post("../controller/TRIEmpresas.php",{
                    acao:       "inclui_homologacao",
                    hom_emp:    $("#hom_emp").val(),
                    hom_nome:   $("#hom_nome").val(),
                    hom_datahom:$("#hom_data").val(),
                    hom_nome:   $("#hom_nome").val(),
                    hom_inden:  $("#hom_inden").val(),
                    hom_sind:   $("#hom_sind").val(),
                    hom_local:  $("#hom_local").val(),
                    hom_horario:   $("#hom_hora").val(),
                    hom_valor:   $("#hom_valor").val(),
                    hom_chk:    checkeditems
                    },
                    function(data){
                        if(data.status=="OK"){
                            $("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> '+data.mensagem+' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
                            $("#cad_homol")[0].reset();
                            $("#hom_emp").select2("val","");
                            $("#bt_homol").html("<i class='fa fa-hand-scissors-o'></i> Solicitar");
                            //location.reload();
                            
                        } else{
                            $("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-times"></i> Ocorreu um erro! ('+data.mensagem+')<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
                        }
                        console.log(data.sql);//TO DO mensagem OK
                    },
                    "json"
                );
            }
        }
    });

/*-------------------|EXCLUIR HOMOLOGAÇÃO|--------------------*-\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado@gmail.com                      |
| Date:     05/06/2017                                          |
\*-------------------------------------------------------------*/

    $(document.body).on("click",".excHomol", function(){
        console.log("CLICK OK");
        cod = $(this).data("reg");
        $.post("../controller/TRIEmpresas.php",{
            acao: "exclui_homol",
            hom_cod: cod
        },
        function(data){
            if(data.status=="OK"){
                alert(data.mensagem);
                location.reload();
            } 
            else{
                alert(data.mensagem);   
            }
        },
        "json");
    });

/*--------------|MARCAR HOMOLOGAÇÃO COMO FEITO|----------------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado@gmail.com                      |
| Date:     06/06/2017                                          |
\*-------------------------------------------------------------*/

    $(document.body).on("click",".chkHomol", function(){
        console.log("CLICK OK");
        cod = $(this).data("reg");
        $.post("../controller/TRIEmpresas.php",{
            acao: "ok_homol",
            hom_cod: cod
        },
        function(data){
            if(data.status=="OK"){
                alert(data.mensagem);
                location.reload();
            } 
            else{
                alert(data.mensagem);   
            }
        },
        "json");
    });

    
/*--------------|EXCLUIR ITEM DE HOMOLOGAÇÃO|------------------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado@gmail.com                      |
| Date:     05/06/2017                                          |
\*-------------------------------------------------------------*/

    $(document.body).on("click",".excDocHom", function(){
        console.log("CLICK OK");
        cod = $(this).data("reg");
        $.post("../controller/TRIEmpresas.php",{
            acao: "exclui_dochomol",
            doc_id: cod
        },
        function(data){
            if(data.status=="OK"){
                alert(data.mensagem);
                location.reload();
            } 
            else{
                alert(data.mensagem);   
            }
        },
        "json");
    });
    


/*----------|CADASTRO DE ARQUIVOS DO CLIENTE|------------------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado.com                            |
| Date:     01/06/2017                                          |
| Objetivo: Cadastrar Arquivos de Importação para uso rotineiro |
\*-------------------------------------------------------------*/
    $(document.body).on("click","#bt_cadArq",function(){
        tipo = "cadastrar";
        var container = $("#formerros_arquivos");
        $("#cad_arquivos").validate({
            debug: true,
            errorClass: "error",
            errorContainer: container,
            errorLabelContainer: $('ol', container),
            wrapper: 'li',
            rules: {
                arq_titulo: {required: true},
                arq_ativo:  {required: true},
                arq_venc:   {required: true}
            },
            messages: {
                arq_titulo: {required: "Escolha um tipo de arquivo"},
                arq_ativo:  {required: "Escolha uma op&cedil;&atilde;o para o arquivo"},
                arq_venc:   {required: "Escolha a data limite para importa&ccedil;&atilde;o"}
            },
            highlight: function(element) {
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function(element) {
                $(element).closest('.form-group').removeClass('has-error');
            }
        });

        if ($("#cad_arquivos").valid() == true) {
            $.post("../controller/TRIEmpresas.php", {
                acao:          $("#acao").val(),
                arq_id:         $("#arq_id").val(), 
                arq_clicod:     $("#arq_clicod").val(), 
                arq_titulo:     $("#arq_titulo").val(),
                arq_venc:      $("#arq_venc").val(),
                arq_ativo:      $("#arq_ativo").val()
            },
                    function (data) {
                        if(data.status=="OK"){
                            $("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> ('+data.mensagem+') <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
                            console.log(data.sql);//TO DO mensagem OK
                            //limpa_formulario_all();
                            location.href = "clientes.php?token=" +$("#token").val()+"&cnpj="+$("#cnpj").val()+"&clicod="+$("#arq_clicod").val()+"&tab=arquivos";
                        }
                        else{
                            $("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-flag-checkered"></i> ('+data.mensagem+') <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
                        }
                        
                    }, "json");
        }
    });

/*-----------------|SALVAR DE HOMOLOGAÇÔES|--------------------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado.com                            |
| Date:     06/06/2017                                          |
| Objetivo: Salvar homologações                                 |
\*-------------------------------------------------------------*/
    $(document.body).on("click","#bt_save_homol", function(){
        $("#bt_save_homol").html("<i class='fa fa-cog fa-spin'></i> Processando...");
            $.post("../controller/TRIEmpresas.php",{
                acao        : "salva_homolog",
                hom_id      : $("#hom_id").val(),
                hom_status  : $("#sel_status").val(),
                hom_obs : CKEDITOR.instances.editor1.getData()
                },
                function(data){
                    if(data.status=="OK"){
                        $("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> '+data.mensagem+' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
                        $("#cad_atendhom")[0].reset();
                        $("#bt_save_cham").html("<i class='fa fa-save'></i> Salvar");
                        //$("#slc").load("meus_chamados.php").fadeIn("slow");
                        location.reload();
                        
                    } else{
                        $("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-times"></i> Ocorreu um erro! ('+data.mensagem+')<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
                    }
                    console.log(data.sql);//TO DO mensagem OK
                },
                "json"
            );
    });

/*-----------------|ENCERRAR DE HOMOLOGAÇÔES|------------------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado.com                            |
| Date:     06/06/2017                                          |
| Objetivo: Encerrar homologações                               |
\*-------------------------------------------------------------*/
    $(document.body).on("click","#bt_encerra_homol",function(){
        var token = $("#token").val();
        var cnpj = $("#cnpj").val();
        $.post("../controller/TRIEmpresas.php",{
            acao        : "encerra_homolog",
            hom_id      : $("#hom_id").val(),
            },
            function(data){
                if(data.status=="OK"){
                    $("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> '+data.mensagem+' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
                    $("#bt_encerra_homol").html("<i class='fa fa-exclamation'></i> Encerrar");
                    //$("#slc").load("meus_chamados.php").fadeIn("slow");
                    location.href = "dp_homologa.php?token="+token+"&cnpj="+cnpj;
                    
                } else{
                    $("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-times"></i> Ocorreu um erro! ('+data.mensagem+')<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
                }
                console.log(data.sql);//TO DO mensagem OK
            },
            "json"
        );
    });

/*-----|POPULANDO FILTRO DE EMPREGADOS PELO DEPARTAMENTO|------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado@gmail.com                      |
| Date:     07/09/2017                                          |
| Objetivo: Popular  o campo de empregados de acordo com        |
|           DEPARTAMENTO                                        |
\*-------------------------------------------------------------*/
    $(document.body).on("change","#sel_dep",function(){
        tipo: "aguarde";
        $.post("../controller/TRIEmpresas.php",
        {
            acao: "get_empregados", 
            dep: $(this).val()
        },
        function(data){
            $("#sel_usu").html(data);
        }
        , "html");
    });
/*-----|POPULANDO FILTRO DE EMPREGADOS PELO DEPARTAMENTO|------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado@gmail.com                      |
| Date:     07/09/2017                                          |
| Objetivo: Popular  o campo de empregados de acordo com        |
|           DEPARTAMENTO                                        |
\*-------------------------------------------------------------*/
    $(document.body).on("change","#progr_dep",function(){
        tipo: "aguarde";
        $.post("../controller/TRIEmpresas.php",
        {
            acao: "get_empregados", 
            dep: $(this).val()
        },
        function(data){
            $("#progr_usu").html(data);
        }
        , "html");
    });
/*-----|POPULANDO FILTRO DE EMPREGADOS PELO DEPARTAMENTO|------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado@gmail.com                      |
| Date:     07/09/2017                                          |
| Objetivo: Popular  o campo de empregados de acordo com        |
|           DEPARTAMENTO                                        |
\*-------------------------------------------------------------*/
    $(document.body).on("change","#prod_dep",function(){
        tipo: "aguarde";
        $.post("../controller/TRIEmpresas.php",
        {
            acao: "get_empregados", 
            dep: $(this).val()
        },
        function(data){
            $("#prod_usu").html(data);
        }
        , "html");
    });
/*-----|POPULANDO FILTRO DE EMPREGADOS PELO DEPARTAMENTO|------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado@gmail.com                      |
| Date:     07/09/2017                                          |
| Objetivo: Popular  o campo de empregados de acordo com        |
|           DEPARTAMENTO                                        |
\*-------------------------------------------------------------*/
    $(document.body).on("change","#area_dep",function(){
        tipo: "aguarde";
        $.post("../controller/TRIEmpresas.php",
        {
            acao: "get_empregados", 
            dep: $(this).val()
        },
        function(data){
            $("#area_usu").html(data);
        }
        , "html");
    });

/*--------|MOSTRAR O RELATORIO DETALHADO DO PROGRESSO|---------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado@gmail.com                      |
| Date:     12/07/2017                                          |
| Objetivo: Mostrar os impostos das empresas no relatório de    |
|           progresso na PRODUTIVIDADE                          |
\*-------------------------------------------------------------*/

    $(document.body).on("click","#fakedash", function(){
        $("#fake_dash").modal("show");
        $.post("../controller/TRIEmpresas.php",
                {
                    acao:   "imp_pesq", 
                    emp:    $(this).data("cod"),
                    dep:    $("#progr_dep").val(),
                    comp:   $("#progr_comp").val(),
                    imp: '',
                    usu: '',
                    itp:    $("#progr_timp").val()
                },
                function(data){
                    $("#tbl_fakedash").html(data).fadeIn("slow");
                    $(".chk_imp").bootstrapToggle({
                        on: "Sim",
                        off: "Não"
                    });
                }
                , "html"
            );
    });

});