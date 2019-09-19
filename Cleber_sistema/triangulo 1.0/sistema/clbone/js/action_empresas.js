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
    /*---------------------------------Nova Pesquisa ---------------------------------*/
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

/*-----------------------------------------|ROTINA PARA ALTERAÇÃO DE ENDEREÇO|-----------------------------------------------*/
    $("#bt_altera_end").on("click",function(){
        $.post("../controller/TRIEmpresas.php",
            {
                acao    : "altera_end",
                emp_razao : $("#emp_rzs").val(),
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
/*--------------|EXCLUIR CONTATOS|------------------*/
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
                cli_tel: {required: true, minlength: 10}
            },
            messages: {
                cli_cod: {required: "Codigo do Cliente"},
                cli_cnpj: {required: "CNPJ / CPF Deve ser Digitado", minlength: "O CNPJ deve ter 14 Numeros"},
                cli_nome: {required: "Qual o nome razao da empresa?"},
                cli_apelido: {required: "Qual o apelido da empresa?"},
                cli_reg: {required: "Regiao da empresa"},
                cli_tel: {required: "Digite o telefone.", minlength: "Minimo 10 Letras"}
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
                cli_resp:   $("#cli_resp").val(),
                cli_reg:    $("#cli_reg").val(),
                cli_tipo:   $("#emp_tipo").val(),
                cli_func:   $("#emp_funcs").val(),
                cli_tel:    $("#cli_tel").val(),
                cli_mail:   $("#cli_mail").val(),
                cli_site:   $("#cli_site").val(),
				cli_ativo:	$("#cli_ativo").val(),
				cli_tribut:	$("#cli_tribut").val(),
                cli_obs:    CKEDITOR.instances.editor1.getData()
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
                part_obs:       {required: true}
            },
            messages: {
                part_titulo: {required: "Digite um titulo"},
                part_ativo:  {required: "Escolha uma op&cedil;&atilde;o para a particularidade"},
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
                ob_titulo:   {required: "Digite a obriga&cedil;&atilde;o"},
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
                tr_titulo:   {required: "Digite a tributa&cedil;&atilde;o"},
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
        var container = $("#formerros_partic");
        $("#cad_imposto").validate({
            debug: true,
            errorClass: "error",
            errorContainer: container,
            errorLabelContainer: $('ol', container),
            wrapper: 'li',
            rules: {
                imp_nome:    {required: true},
                imp_venc:    {required: true},
                imp_pasta:   {required: true},
                imp_arquivo: {required: true},
                imp_desc:    {required: true}
            },
            messages: {
                imp_nome: {required: "Digite um titulo"},
                imp_venc: {required: "Digite o vencimento para a imposto"},
                imp_pasta:{required: "Em que pasta o arquivo &eacute; armazenado?"},
                imp_venc: {required: "Qual o nome padr&atilde;o do arquivo?"},
                imp_desc: {required: "Forne&ccedil;a detalhes para do imposto"}
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
                imp_arquivo:   $("#imp_arquivo").val(),
                imp_pasta:     $("#imp_pasta").val(),
                imp_venc:      $("#imp_venc").val(),
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
});