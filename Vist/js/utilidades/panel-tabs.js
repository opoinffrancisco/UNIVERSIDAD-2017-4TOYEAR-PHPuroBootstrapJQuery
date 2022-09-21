var panelTabs = function() {
	
	var cambiar = function(_urlCatalogo_,_urlVentanaModal_,_arrayDatos_) {
					// colocar directamente el display sin usar Clases de CSS
			        // para las pestañas
			        $(_arrayDatos_).each(function (index, dato) {
				        if (index==0) {
					        $('#'+dato).removeClass('pestana-tab-inactivo').addClass('pestana-tab-activo');
				        }else{
					        $('#'+dato).removeClass('pestana-tab-activo').addClass('pestana-tab-inactivo');
				        };
			        });
			        //cambiando catalogo
        			panelTabs.cambiarCatalogoPublic(_urlCatalogo_);
        			//cambiando ventana        			
        			panelTabs.cambiarVentanaModalPublic(_urlVentanaModal_);
				}
	var cambiarCatalogoTabs = function(_urlCatalogo_,_arrayDatos_) {
		// colocar directamente el display sin usar Clases de CSS
        // para las pestañas
        $(_arrayDatos_).each(function (index, dato) {
	        if (index==0) {
		        $('#'+dato).removeClass('pestana-tab-inactivo').addClass('pestana-tab-activo');
	        }else{
		        $('#'+dato).removeClass('pestana-tab-activo').addClass('pestana-tab-inactivo');
	        };
        });
        //cambiando catalogo
		panelTabs.cambiarCatalogoPublic(_urlCatalogo_);
	}				
	var cambiarCatalogo = function(_vistCatalogo_) {

		var urlUbicacion = "Vist/paginas/";
		_vistCatalogo_=urlUbicacion+_vistCatalogo_;

        $.ajax({
                /*data:  parametros,*/
                url:   _vistCatalogo_,
                type:  'post',
                beforeSend: function () {
                    $("#menu-footer-mensaje").html('<b style="color: #80c9ce;">Cargando Nuevo Catalogo... </b>');
                },
                success:  function (response) {
                    $("#menu-footer-mensaje").html('');
                    $("#catalogo").html(response);
                    nucleo.tiempoParaSuspensionSistemaBDPublic();
                }
        });		
	}
	var cambiarFormulario = function(_urlVistForm_,_contentVistForm_,_arrayDatos_) {

		var urlUbicacion = "Vist/paginas/";
		_urlVistForm_=urlUbicacion+_urlVistForm_;

        $.ajax({
                /*data:  parametros,*/
                url:   _urlVistForm_,
                type:  'post',
                beforeSend: function () {
                    $("#menu-footer-mensaje").html('<b style="color: #80c9ce;">Cargando Nuevo Formulario... </b>');
                },
                success:  function (response) {
                    $("#menu-footer-mensaje").html('');
                    $("#"+_contentVistForm_).html(response);
					// colocar directamente el display sin usar Clases de CSS
			        // para las pestañas
			        $(_arrayDatos_).each(function (index, dato) {
				        if (index==0) {
					        $('#'+dato).removeClass('pestana-tab-inactivo').addClass('pestana-tab-activo');
				        }else{
					        $('#'+dato).removeClass('pestana-tab-activo').addClass('pestana-tab-inactivo');
				        };
			        });
			        nucleo.tiempoParaSuspensionSistemaBDPublic();
                }
        });		
	}	
	var cambiarModal = function(_urlCatalogo_,_urlVentanaModal_,_arrayDatos_,_idCatalogoModal_) {
					// colocar directamente el display sin usar Clases de CSS
			        // para las pestañas
			        $(_arrayDatos_).each(function (index, dato) {
				        if (index==0) {
					        $('#'+dato).removeClass('pestana-tab-activo').addClass('pestana-tab-inactivo');
				        }else{
					        $('#'+dato).removeClass('pestana-tab-inactivo').addClass('pestana-tab-activo');
				        };
			        });
			        //cambiando catalogo
        			panelTabs.cambiarCatalogoModalPublic(_urlCatalogo_,_idCatalogoModal_);
        			//cambiando ventana        			
        			//panelTabs.cambiarVentanaModalPublic(_urlVentanaModal_);
				}	
	var cambiarCatalogoModal = function(_vistCatalogo_,_idCatalogoModal_) {

		var urlUbicacion = "Vist/paginas/";
		_vistCatalogo_=urlUbicacion+_vistCatalogo_;

        $.ajax({
                /*data:  parametros,*/
                url:   _vistCatalogo_,
                type:  'post',
                beforeSend: function () {
                    $("#menu-footer-mensaje").html('<b style="color: #80c9ce;">Cargando Nuevo Catalogo... </b>');
                },
                success:  function (response) {
                    $("#menu-footer-mensaje").html('');
                    $("#"+_idCatalogoModal_).html(response);
                    nucleo.tiempoParaSuspensionSistemaBDPublic();
                }
        });		
	}	
	var cambiarVentanaModal = function(_vistVentanaModal_) {

		var urlUbicacion = "Vist/paginas/";
		_vistVentanaModal_=urlUbicacion+_vistVentanaModal_;

        $.ajax({
                /*data:  parametros,*/
                url:   _vistVentanaModal_,
                type:  'post',
                beforeSend: function () {
                    $("#menu-footer-mensaje").html('<b style="color: #80c9ce;">Cargando Nueva ventana Modal... </b>');
                },
                success:  function (response) {
                    $("#menu-footer-mensaje").html('');                	
                    $("#ventana-modal").html(response);
                    nucleo.tiempoParaSuspensionSistemaBDPublic();
                }
        });		
	}
	
	return{
		Iniciar : function() {

			console.log(" -- Finalizando carga de panel tabs");
		},
		cambiarPulico : cambiar,
		cambiarCatalogoTabsPublic : cambiarCatalogoTabs,
		cambiarModalPulico : cambiarModal,
		cambiarCatalogoPublic : cambiarCatalogo,
		cambiarCatalogoModalPublic : cambiarCatalogoModal,
		cambiarVentanaModalPublic : cambiarVentanaModal,
		cambiarFormularioPublico : cambiarFormulario,
	}

}(); 