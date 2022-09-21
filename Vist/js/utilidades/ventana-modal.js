var ventanaModal = function() {
	
	var mostrar = function(_item_,_arrayDatos_) {

			$('.panel-body form').css('display', 'block');
			$('#procesandoDatosDialg').css('display', 'none');

			if ($('#buscardorTxt').length>0 || $('div#catalogo select#lista-control').length>0) {

				var datoCantColl1Row = $('table#catalogo #catalogoDatos tr td').length;
				var datoTxt = $('#buscardorTxt').val();
				var datoInt = $('div#catalogo select#lista-control').val();
				//
				if(datoTxt!="" && datoCantColl1Row==1 || datoInt>0){
					$(".campo-clave").val($('#buscardorTxt').val());
					$('#btnGuardar').prop('disabled', false);
				}else{
					return false;
				}
			}


		   $("#ventana-modal").css('overflow','auto');
		   //
		   $(".menu-usuario").css('z-index','-20');		            
					// colocar directamente el display sin usar Clases de CSS
		   $('#'+_item_).removeClass('ventana-modal-panel-accionCerrar').addClass('ventana-modal-panel-accionMostrar');


			$(_arrayDatos_).each(function (index, dato){

				if (dato!=null || dato!="") {

					switch (dato)
					{
					    case 'editar' : 

					   	break;						   
					   	case 'scroll' :
										$("#ventana-modal").css('overflow','auto');
					   
					   	break;
					}							
				};
			});		   
			$('#btnGuardar').prop('disabled', false);
			nucleo.tiempoParaSuspensionSistemaBDPublic();
	}
	var mostrarBasic = function() {

			$('.panel-body form').css('display', 'block');
			$('#procesandoDatosDialg').css('display', 'none');
						
		   $("#ventana-modal").css('overflow','auto');
		   //
		   $(".menu-usuario").css('z-index','-20');		            
					// colocar directamente el display sin usar Clases de CSS
		   $('#ventana-modal').removeClass('ventana-modal-panel-accionCerrar').addClass('ventana-modal-panel-accionMostrar');		   
		   nucleo.tiempoParaSuspensionSistemaBDPublic();
	}	
	var mostrarBasicItem = function(_item_) {
		   $('#'+_item_).removeClass('ventana-modal-panel-accionCerrar').addClass('ventana-modal-panel-accionMostrar');
		   nucleo.tiempoParaSuspensionSistemaBDPublic();
	}		
	var ocultar = function(_item_,_arrayDatos_) {
        $('#'+_item_).removeClass('ventana-modal-panel-accionMostrar').addClass('ventana-modal-panel-accionCerrar').slideUp(200);
        $(".menu-usuario").css('z-index','0px');	
		if ($('#btnGuardarFloatR').length>0) {
	 		$('#btnGuardarFloatR').css('display','block');	        
 		};        		        
        nucleo.reiniciarFormularioPublic();
        nucleo.tiempoParaSuspensionSistemaBDPublic();        
	}
	var ocultarSinReinic = function(_item_,_arrayDatos_) {
        $('#'+_item_).removeClass('ventana-modal-panel-accionMostrar').addClass('ventana-modal-panel-accionCerrar').slideUp(200);
        $(".menu-usuario").css('z-index','0px');	
		if ($('#btnGuardarFloatR').length>0) {
	 		$('#btnGuardarFloatR').css('display','block');	        
 		};        
        nucleo.tiempoParaSuspensionSistemaBDPublic();	
	}		
	var ocultarBasicItem = function(_item_) {
        $('#'+_item_).removeClass('ventana-modal-panel-accionMostrar').addClass('ventana-modal-panel-accionCerrar').slideUp(200);
		if ($('#btnGuardarFloatR').length>0) {
	 		$('#btnGuardarFloatR').css('display','block');	        
 		};        
        nucleo.tiempoParaSuspensionSistemaBDPublic();
	}	
	//Capa base , solo para procesos			
	var cambiaMuestraVentanaModalCapaBase = function(_vistVentanaModal_,_scroll_,_accion_) {

		if (_vistVentanaModal_!=0) {
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
	                    $("#ventana-modal-capa-base").html(response);
						
						nucleo.tiempoParaSuspensionSistemaBDPublic();

						$('.panel-body form').css('display', 'block');
						$('#procesandoDatosDialg').css('display', 'none');

				        if (_scroll_==0){
				            $("#ventana-modal-capa-base").css('overflow','hidden');
				        }else{
				            $("#ventana-modal-capa-base").css('overflow','auto');
				        };

			            $(".menu-usuario").css('z-index','-20');

						// colocar directamente el display sin usar Clases de CSS
				        $('#ventana-modal-capa-base').removeClass('ventana-modal-panel-accionCerrar').addClass('ventana-modal-panel-accionMostrar');
				        				        
				        if (_accion_== 1 || _accion_=='editar') {
						    $(".campo-clave").val($('#buscardorTxt').val());
							$('#btnGuardar').prop('disabled', false);        	
				        };
	                }
	        });		
		};
	}
	var cambiaMuestraVentanaModal = function(_vistVentanaModal_,_scroll_,_accion_) {

		if (_vistVentanaModal_!=0) {
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

						$('.panel-body form').css('display', 'block');
						$('#procesandoDatosDialg').css('display', 'none');

				        if (_scroll_==0){
				            $("#ventana-modal").css('overflow','hidden');
				        }else{
				            $("#ventana-modal").css('overflow','auto');
				        };

			            $(".menu-usuario").css('z-index','-20');

						// colocar directamente el display sin usar Clases de CSS
				        $('#ventana-modal').removeClass('ventana-modal-panel-accionCerrar').addClass('ventana-modal-panel-accionMostrar');
				        				        
				        if (_accion_== 1 || _accion_=='editar') {
						    $(".campo-clave").val($('#buscardorTxt').val());
							$('#btnGuardar').prop('disabled', false);        	
				        };
	                }
	        });		
		};
	}
	var cambiaMuestraVentanaModalCapa2 = function(_vistVentanaModal_,_scroll_,_accion_) {

		if (_vistVentanaModal_!=0) {
			var urlUbicacion = "Vist/paginas/";
			_vistVentanaModal_=urlUbicacion+_vistVentanaModal_;
	        $.ajax({
    				async : false,
	                url:   _vistVentanaModal_,
	                type:  'post',
	                beforeSend: function () {
	                    $("#menu-footer-mensaje").html('<b style="color: #80c9ce;">Cargando Nueva ventana Modal...En capa 2 </b>');
	                },
	                success:  function (response) {
	                    $("#menu-footer-mensaje").html('');                	
	                    $("#ventana-modal-capa2").html(response);
						
	                    nucleo.tiempoParaSuspensionSistemaBDPublic();

						$('.panel-body form').css('display', 'block');
						$('#procesandoDatosDialg').css('display', 'none');

				        if (_scroll_==0){
				            $("#ventana-modal-capa2").css('overflow','hidden');
				        }else{
				            $("#ventana-modal-capa2").css('overflow','auto');
				        };

			            $(".menu-usuario").css('z-index','-20');

						// colocar directamente el display sin usar Clases de CSS
				        $('#ventana-modal-capa2').removeClass('ventana-modal-panel-accionCerrar').addClass('ventana-modal-panel-accionMostrar');
				        				        
				        if (_accion_==1) {
						    $(".campo-clave").val($('#buscardorTxt').val());
							$('#btnGuardar').prop('disabled', false);        	
				        };
	                }
	        });		
		};

	}
	var cambiaMuestraVentanaModalCapa3 = function(_vistVentanaModal_,_scroll_,_accion_) {

		if (_vistVentanaModal_!=0) {
			var urlUbicacion = "Vist/paginas/";
			_vistVentanaModal_=urlUbicacion+_vistVentanaModal_;
	        $.ajax({
	                /*data:  parametros,*/
	                url:   _vistVentanaModal_,
	                type:  'post',
	                beforeSend: function () {
	                    $("#menu-footer-mensaje").html('<b style="color: #80c9ce;">Cargando Nueva ventana Modal...En capa 3</b>');
	                },
	                success:  function (response) {
	                    $("#menu-footer-mensaje").html('');                	
	                    $("#ventana-modal-capa3").html(response);
						
						nucleo.tiempoParaSuspensionSistemaBDPublic();
						
						$('.panel-body form').css('display', 'block');
						$('#procesandoDatosDialg').css('display', 'none');

				        if (_scroll_==0){
				            $("#ventana-modal-capa3").css('overflow','hidden');
				        }else{
				            $("#ventana-modal-capa3").css('overflow','auto');
				        };

			            $(".menu-usuario").css('z-index','-20');

						// colocar directamente el display sin usar Clases de CSS
				        $('#ventana-modal-capa3').removeClass('ventana-modal-panel-accionCerrar').addClass('ventana-modal-panel-accionMostrar');
				        				        
				        if (_accion_==1) {
						    $(".campo-clave").val($('#buscardorTxt').val());
							$('#btnGuardar').prop('disabled', false);        	
				        };
	                }
	        });		
		};

	}		
	/****************************************/
	var cambiaMuestraVentanaModalCapaAdmin = function(contentVtnMModuloAdministra_,contentVentana_,_vistVentanaModal_,_scroll_) {

		if (_vistVentanaModal_!=0) {
			var urlUbicacion = "Vist/paginas/";
			_vistVentanaModal_=urlUbicacion+_vistVentanaModal_;
	        $.ajax({
	                /*data:  parametros,*/
	                url:   _vistVentanaModal_,
	                type:  'post',
	                beforeSend: function () {
						$('.panel-body form').css('display', 'none');
						$('#procesandoDatosDialg').css('display', 'block');
	                    $("#menu-footer-mensaje").html('<b style="color: #80c9ce;">Cargando Nueva ventana de administración</b>');
	                },
	                success:  function (response) {
	                    $("#menu-footer-mensaje").html('');                	
	                    $("#"+contentVentana_).html('');
	                    $("#"+contentVentana_).html(response);

				        if (_scroll_==0){
				            $("#"+contentVentana_).css('overflow','hidden');
				        }else{
				            $("#"+contentVentana_).css('overflow','auto');
				        };
				        // Modificar boton de cierre de ventana modal
						$("#"+contentVentana_+" #ventana-modal-panel-cerrar").attr('onclick', "ventanaModal.ocultarSinReinicAdminPublic('"+contentVentana_+"')");
						// Modificar botones existentes de guardar, en ventana modal
						if ($("#"+contentVentana_+" button#btnGuardarFloatR").length>0) {
			            	$("#"+contentVentana_+" button#btnGuardarFloatR").attr('disabled', false);
						};
						if ($("#"+contentVentana_+" button#btnGuardar").length>0) {
			            
			            	$("#"+contentVentana_+" button#btnGuardar").attr('disabled', false);
			            //	$("#"+contentVentana_+" button#btnGuardar").attr('onclick','none');
						};
						//
				        $("#"+contentVentana_).removeClass('ventana-modal-panel-accionCerrar').addClass('ventana-modal-panel-accionMostrar');				        				        						
			            $(".menu-usuario").css('z-index','-20');

						$('.panel-body form').css('display', 'block');
						$('#procesandoDatosDialg').css('display', 'none');
						nucleo.tiempoParaSuspensionSistemaBDPublic();							 	 	                
	                }
	        });		
		};
	}	


	var ocultarSinReinicAdmin = function(_item_) {
        $('#'+_item_).removeClass('ventana-modal-panel-accionMostrar').addClass('ventana-modal-panel-accionCerrar').slideUp(200);
        $(".menu-usuario").css('z-index','0px');	
		if ($('#ventana-modal-cfg-internos').hasClass('ventana-modal-panel-accionMostrar')==true) {
			$('#administracion #ventana-modal-cfg-internos').html('');
        }else{
			$('#administracion #ventana-modal-cfg').html('');
        }; 		
        nucleo.tiempoParaSuspensionSistemaBDPublic();	
	}

	return{
		Iniciar : function() {


			console.log(" -- Finalizando carga de ventana Modal");
		},
		ocultarPulico : ocultar,
		ocultarSinReinicPublic : ocultarSinReinic,
		ocultarBasicItemPublic : ocultarBasicItem,
		mostrarPulico : mostrar,
		mostrarBasicPublico : mostrarBasic,
		mostrarBasicItemPublic : mostrarBasicItem,
		cambiaMuestraVentanaModalCapaBasePublic : cambiaMuestraVentanaModalCapaBase,
		cambiaMuestraVentanaModalPublic : cambiaMuestraVentanaModal,
		cambiaMuestraVentanaModalCapa2Public :cambiaMuestraVentanaModalCapa2,		
		cambiaMuestraVentanaModalCapa3Public :cambiaMuestraVentanaModalCapa3,	
		//Admin
		cambiaMuestraVentanaModalCapaAdminPublic : cambiaMuestraVentanaModalCapaAdmin,	
		ocultarSinReinicAdminPublic : ocultarSinReinicAdmin,

	}

}(); 