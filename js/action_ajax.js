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
 });