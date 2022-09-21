var dialog = "";
var fd = new FormData();
$(document).ready(function () {

    $("#archivo_sql").change(function () {
        var archivo = $(this).val();
        var pat = /.sql/;
        if (pat.test(archivo) === true) {
            if (confirm("¿Seguro que deseas restaurar está información?")) {
                fd = new FormData();
                fd.append('file', $('#archivo_sql')[0].files[0]);
                fd.append('mostrarSQL', "mostrarSQL");
                fd.append('ip_cliente', sessionStorage.getItem("ip_cliente-US"));
                fd.append('id_usuario', sessionStorage.getItem("idUsuario-US"));
                
                mostrarSql(fd);

            }
        } else {
            $("#archivo_sql").val("");
            alert("Seleccione un archivo con extensión sql");
        }
    });





});


function mostrarSql(file) {
    ventanaModal.mostrarBasicPublico();
    $.ajax({
        processData: false,
        contentType: false,
        dataType: "html",
        type: 'POST',
        url: "Ctrl/mantenimiento/ctrl_restauracion.php",
        data: file,
        beforeSend: function () {
            $('#vtnRestauracion #form').css("display", "none");
            $('#vtnRestauracion #procesandoDatosDialg').css("display", "block");    
        },        
        success: function (respuesta) {
            $('#vtnRestauracion #form').css("display", "block");
            $('#vtnRestauracion #procesandoDatosDialg').css("display", "none");                    
            $("#content-sql").html($.trim(respuesta));
        },
        error: function (objXMLHttpRequest) {
        }
    });

}

function restaurarDBSQL () {

    fd = new FormData();
    fd.append('file', $('#archivo_sql')[0].files[0]);
    fd.append('guardarRestauracion', "guardarRestauracion");
    fd.append('ip_cliente', sessionStorage.getItem("ip_cliente-US"));
    fd.append('id_usuario', sessionStorage.getItem("idUsuario-US"));
                
    $.ajax({
        processData: false,
        contentType: false,
        dataType: "html",
        type: 'POST',
        url: "Ctrl/mantenimiento/ctrl_restauracion.php",
        data: fd,
        beforeSend: function () {
            $('#vtnRestauracion #form').css("display", "none");
            $('#vtnRestauracion #procesandoDatosDialg').css("display", "block");           
        },
        success: function (respuesta) {
            $("#content-sql").html("");
            $("#archivo_sql").val("");            
            alertify.notify("Restauración realizada con exito",'success',2,function(){ });
            ventanaModal.ocultarPulico('ventana-modal');
            $('#vtnRestauracion #form').css("display", "block");
            $('#vtnRestauracion #procesandoDatosDialg').css("display", "none");  
        },
        error: function (objXMLHttpRequest) {
        }
    });

}
