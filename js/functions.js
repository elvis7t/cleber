function del(codigo, classe, msg){
	$("<span></span>").remove();
    $("<span></span>").html("Deseja excluir "+msg+" "+codigo+"?").appendTo("#msg_conf");
	$("#confSim").attr("data-reg", codigo);
	$("#confSim").addClass(classe);
	$("#confirma").modal("show");
}

function desativ(emp, codigo, classe, msg){
    $("<span></span>").remove();
    $("<span></span>").html("Deseja desativar "+msg+" "+codigo+"?").appendTo("#msg_conf");
    $("#cod").val(emp);
    $("#confSim").attr("data-reg", codigo);
    $("#confSim").addClass(classe);
    $("#confirma").modal("show");
}

function baixa(codigo, classe, msg){
    $("#msg_conf").html("");
    $("<span></span>").html(msg+" "+codigo+"?").appendTo("#msg_conf");
    $("#confSim").attr("data-reg", "");
    $("#confSim").attr("data-reg", codigo);
    $("#confSim").addClass(classe);
    $("#confirma").modal("show");
}

function ver_cpc(codigo, classe, msg){
    $("#msg_conf").html("");
    $("<span></span>").html(msg+" "+codigo+"?").appendTo("#msg_conf");
    $("#confSim").attr("data-reg", "");
    $("#confSim").attr("data-reg", codigo);
    $("#confSim").addClass(classe);
    $("#confirma").modal("show");
}

function pagar_reci(codigo, modal, msg){
    //$("<span></span>").html(msg+" "+codigo+"?").appendTo("#msg_conf");
    $("#id_recibo").val(codigo);
    $("#"+modal).modal("show");

}

function receber_docext(docs, empr, usu, depto, orig, local, refer){
    $("#aguarde").modal("show");
    var array = [docs];
    //alert(array[0]);
    $.post("../controller/TRIDocumentos.php",{
        acao    : "entra_docsext",
        doc     : array,
        emp     : empr,
        dep     : depto,
        res     : usu,
        obs     : 'Recebido via '+local,
        ori     : orig,
        loc     : local,
        ref     : refer
        },
        function(data){
            if(data.status=="OK"){
                $("#aguarde").modal("hide");
                $("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> '+data.mensagem+' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
                $("#bt_doc_pesq").trigger("click");
                //$("#bt_doc_ent").html("<i class='fa fa-folder-open'></i> Receber");
            } 
            
            else{
                $("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-times"></i> Ocorreu um erro! ('+data.mensagem+')<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");   
            }
            
            console.log(data.sql);//TO DO mensagem OK
        },
        "json"
    );
}


function notify(msg, pagina, tipo, icone = '') {
    Notification.requestPermission(function() {
        var notification = new Notification(tipo, {
            icon: (icone==""?'http://www.triangulocontabil.com.br/web/images/tri_Origem_FULL_H.png':icone),
            body: msg
        });
        notification.onclick = function() {
            window.open(pagina);
        }
    });
}
function ver_docs(div, file){
    $("#aguarde").modal("show");
    $("#"+div).attr('src',file);
    $("#aguarde").modal("hide");
}

function pad (str, max) {
  str = str.toString();
  return str.length < max ? pad("0" + str, max) : str;
}