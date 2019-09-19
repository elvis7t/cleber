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

function pagar_reci(codigo, modal, msg){
    //$("<span></span>").html(msg+" "+codigo+"?").appendTo("#msg_conf");
    $("#id_recibo").val(codigo);
    $("#"+modal).modal("show");

}


function notify(msg, pagina, tipo, icone = '') {
    Notification.requestPermission(function() {
        var notification = new Notification(tipo, {
            icon: (icone==""?'http://localhost/www/sistema/images/tri_Origem_FULL_H.png':icone),
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

$(function () {
	$('[data-toggle="tooltip"]').tooltip();
	$('[data-toggle="popover"]').popover({
        html:true
    });
});
