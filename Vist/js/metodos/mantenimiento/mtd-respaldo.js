var dialog = "";
$(document).ready(function () {

    $("#pasar_table").click(function (e) {
        selectedAllElementFromSelectedRespaldo();
        addElementsToSelectedRespaldo();
    });

    $("#devolver_table").click(function (e) {
        removeElementsFromSelectedRespaldo();
    });

    $("#comenzar_respaldo").click(function (e) {
        generateSql();
    });

});


function selectedTablesDisponible() {
    var tables_disponible = [];
    $('#disponible_table option:selected').each(function (i, selected) {
        tables_disponible[i] = $(selected).text();
        //alert(tables_disponible[i]);
        /**/
    });
    return tables_disponible;
}


function selectedTablesSelected() {
    var tables_selected = [];
    $('#selected_table option:selected').each(function (i, selected) {
        tables_selected[i] = $(selected).text();
        //alert(tables_selected.length);
        /**/
    });
    return tables_selected;
}

function selectedAllElementFromSelectedRespaldo() {
    var tables_selected = [];
    $('#selected_table option').each(function () {
        tables_selected.push($(this).val());

    });
    $('#selected_table').html("");
    for (var p = 0; p < tables_selected.length; p++) {

        if (tables_selected[p] !== undefined) {
            $('#selected_table').append("<option value='" + tables_selected[p] + "' selected='selected' style='background-image: url(Vist/img/table24.png);background-repeat: no-repeat;padding-left: 30px;'>" + tables_selected[p] + "</option>");
        }
    }

}

function addElementsToSelectedRespaldo() {

    var tables_disponible = selectedTablesDisponible();
    if (tables_disponible.length > 0) {
        //alert(tables_disponible[0]);
        var tables_selected = selectedTablesSelected();
        var flag = false;
        var temp_selected = []; // temporal array
        var k = 0;
        if (tables_selected.length > 0) {
            for (var i = 0; i < tables_disponible.length; i++) {
                //alert(tables_disponible[i]);
                for (var j = 0; j < tables_selected.length; j++) {
                    //alert(tables_selected[j]);
                    //alert("disponible: " + tables_disponible[i].toString() + " es igual a :" + tables_selected[j].toString());
                    if (tables_disponible[i] !== tables_selected[j]) {
                        temp_selected[k] = tables_disponible[i];
                    } else {
                        //alert( temp_selected[k]+" IGUAL");
                        temp_selected[k] = undefined;
                        break;
                    }
                }
                if (temp_selected[k] !== undefined)
                    k++;
            }
        } else {
            temp_selected = tables_disponible;
        }

        for (var p = 0; p < temp_selected.length; p++) {
            if (temp_selected[p] !== undefined) {
                $('#selected_table').append("<option value='" + temp_selected[p] + "' selected='selected' style='background-image: url(Vist/img/table24.png);background-repeat: no-repeat;padding-left: 30px;'>" + temp_selected[p] + "</option>");
            }
        }


    }
}

function removeElementsFromSelectedRespaldo() {
    var tables_selected = selectedTablesSelected();
    for (var p = 0; p < tables_selected.length; p++) {
        if (tables_selected[p] !== undefined) {
            $("#selected_table option[value='" + tables_selected[p] + "']").remove();
        }
    }
}


function generateSql() {

    selectedAllElementFromSelectedRespaldo();
    var tables_selected = selectedTablesSelected();

    if (tables_selected.length > 0) {

        ventanaModal.mostrarBasicPublico();
        var allTables = tables_selected.toString();
        $.ajax({
            async: true,
            cache: false,
            dataType: "html",
            type: 'POST',
            url: "Ctrl/mantenimiento/ctrl_respaldo.php",
            data: {
                allTables: allTables,
                comenzarRespaldo: "comenzarRespaldo",
                ip_cliente : sessionStorage.getItem("ip_cliente-US"),
                id_usuario : sessionStorage.getItem("idUsuario-US"),                
            },
            beforeSend: function () {
                $('#vtnRespaldo #form').css("display", "none");
                $('#vtnRespaldo #procesandoDatosDialg').css("display", "block");           
            },
            success: function (respuesta) {
                $('#vtnRespaldo #form').css("display", "block");
                $('#vtnRespaldo #procesandoDatosDialg').css("display", "none");                    
                $("#content-sql").html($.trim(respuesta));
            },
            error: function (objXMLHttpRequest) {
            }
        });

    } else {
        alert("Debe seleccionar al menos una tabla para realizar el respaldo.");
    }

}


function guararArchivoSQL() {

    $.ajax({ 
        async: false,
        cache: false,
        dataType: "html",
        type: 'POST',  
        url: "Ctrl/mantenimiento/ctrl_respaldo.php",
        data: {
            contenido_sql: $("#content-sql").html(),
            guardarRespaldo: "guardarRespaldo",
            ip_cliente : sessionStorage.getItem("ip_cliente-US"),
            id_usuario : sessionStorage.getItem("idUsuario-US"),
        },
        beforeSend: function () {
            $('#vtnRespaldo #form').css("display", "none");
            $('#vtnRespaldo #procesandoDatosDialg').css("display", "block");              
        },        
        success: function (respuesta) {            
            $("#content-sql").html("");
            alertify.notify("Respaldo realizado con exito",'success',2,function(){ });
            ventanaModal.ocultarPulico('ventana-modal');
            $('#vtnRespaldo #form').css("display", "block");
            $('#vtnRespaldo #procesandoDatosDialg').css("display", "none");            
        },
        error: function (objXMLHttpRequest) {
        }
    });

}