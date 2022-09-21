
var navegacion = (function() {

    var animaciones = function () {
        $(function () {
            $('.navbar-toggle').click(function () {
                $('.navbar-nav').toggleClass('slide-in');
                $('.side-body').toggleClass('body-slide-in');
                $('#search').removeClass('in').addClass('collapse').slideUp(200);

                /// uncomment code for absolute positioning tweek see top comment in css
                //$('.absolute-wrapper').toggleClass('slide-in');
                
            });

            /*
                    Si se realiza un click en un elemento se le asigna propiedades a ese,
                y propiedades distintas, a los demas
            */
            $('#menu-principal').click(function(e){
                var idSeleccion = e.target.id;

                var despegableAct = "";

                //---------------
                $('#menu-principal li a').each(function (index, item) {
                    var idItem = $(this).attr("id");

                    if (idSeleccion==idItem && $('#'+idItem).hasClass('despegable-menu')==false){

                        // Donde se realizo el click
                        $('#'+idItem).removeClass('menu-inactivo').addClass('menu-activo');
                        $('#'+idItem).css("color", "#FFF");
                        $('#'+idItem).css("background", "rgb(35, 95, 146)");

                    }else if (idSeleccion==idItem && $('#'+idItem).hasClass('despegable-menu')){
                        // Donde se realizo el click
                        $('#'+idItem).removeClass('menu-inactivo').addClass('menu-activo');
                        $('#'+idItem).css("color", "#FFF");
                        $('#'+idItem).css("background", "rgb(35, 95, 146)");

                        despegableAct = $('#'+idItem).data('menucontent');
                        var idmenuIntern = $('#'+despegableAct).data('idmenu');                                
                        $('#'+idmenuIntern).addClass('in');   

                    }else if(idItem==despegableAct){

                       // console.log(  "aca" +despegableAct );


                    }else{
                        // Donde no se realizo el click
                        $('#'+idItem).removeClass('menu-activo').addClass('menu-inactivo');
                        $('#'+idItem).css("color", "");
                        $('#'+idItem).css("background", "");                

                        if ($('#'+idItem).hasClass('despegable')){

                                var idmenuIntern = $('#'+idItem).data('idmenu');                                
                                $('#'+idmenuIntern).removeClass('in');   



                        }

                    }
                });

            });


           // Remove menu for searching
           $('#search-trigger').click(function () {
                $('.navbar-nav').removeClass('slide-in');
                $('.side-body').removeClass('body-slide-in');

                /// uncomment code for absolute positioning tweek see top comment in css
                //$('.absolute-wrapper').removeClass('slide-in');

            });
        });
    }

    var cambiarPagina = function(urlRecibida){
        $("#logo-menu").fadeIn(100);
        $.ajax({
                /*data:  parametros,*/
                url:   urlRecibida,
                type:  'post',
                beforeSend: function () {
                    $("#contenido").html('<img src="Vist/img/cargando2.gif" class="img-cargando">');
                },
                success:  function (response) {
                    $("#contenido").html(response);
                    nucleo.tiempoParaSuspensionSistemaBDPublic();
                }
        });
    }
    var cambiarPaginaMantenimineto = function() {
        $.ajax({
                /*data:  parametros,*/
                url:   'Vist/paginas/en-mantenimiento.php',
                type:  'post',
                beforeSend: function () {
                    $("#contenido").html('<img src="Vist/img/cargando2.gif" class="img-cargando">');
                },
                success:  function (response) {
                    $("#contenido").html(response);
                    nucleo.tiempoParaSuspensionSistemaBDPublic();
                }
        });
    }

    /* retornando un objeto literal */
    return{
        Iniciar : function(){

                animaciones();
            
            console.log(" -- Finalizando Carga de Navegacion");
        },
        cambiarPaginaPublic : cambiarPagina,
        cambiarPaginaManteniminetoPublic : cambiarPaginaMantenimineto,    
    }

})();














var navegacionEjemploOtro = function (JQ) {
        // body...
}($);