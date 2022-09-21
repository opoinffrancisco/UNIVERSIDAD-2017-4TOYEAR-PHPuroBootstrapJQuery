	var nucleo = function() {
		/***************************Variables globales*************************/
			var resultadosError = {
					campoVacio:0, 
					resultadoCantDatos:0,
					existencia:0,
					existenciaCombinacionSelect:0,
					correoValido:0,
					inicioSesion:0,
					captcha:0,
				};
			var isEdicion = 0;
			var tiempoParaSuspensionSistema = 5;//min // seg
			var controlSuspension;
			var suspensionON=0;
			//-> CONTROL DE CAPCHAT EN SESION
			var dato_control_GLOBAL = "";
		/******************************** NOTAS *******************************/
		/*
				NOTA IMPORTANTE:  
					---
		*/		

		/***************************Metodos de funcionalidades******************/	

		var fechaMax = function (itemDOM) {
			var date = new Date();
			var mes = (date.getMonth() + 1 );
			if(mes.toString().length==1){
				mes = '0'+mes.toString();
			}
			var dia = date.getDate();
			if(dia.toString().length==1){
				dia = '0'+dia.toString();
			}
			$('input[type=date]').attr('max', date.getFullYear() + '-' + mes + '-' + dia);
		}

		var alertaError = function(_contenido_){

			var alerta = alertify.notify(
				_contenido_,
				'error',
				2,
				function(){  
					//console.log('fin de notificaicon'); 
				});
		}
		var alertaExito = function(_contenido_) {
			/*
			var alerta = alertify.notify(
				_contenido_,
				'success',
				4,
				function(){  
					//console.log('fin de notificaicon'); 
				});
			*/
		}
		var alertaDialogoError = function (_titulo_,_contenido_) {
			var alerta = alertify.alert(
				_titulo_,
				_contenido_,
				function(){
			    	//alertify.message('OK');
			});
		}
		/*
			Notificaciones fuera del navegador, 
		*/
		/*
		var notificacionEnDesarrollando= function(titulo, contenido) {
				//if ('undefined' === typeof notification)
				//return false; //No soportado....
				var notificar = new Notification(
										titulo, 
										{
											body: contenido, //el texto o resumen de lo que deseamos notificar
											dir: 'auto', // izquierda o derecha (auto) determina segun el idioma y region
											lang: 'ES', //El idioma utilizado en la notificación
											tag: 'notificationPopup', //Un ID para el elemento para hacer get/set de ser necesario
											icon: 'http://www.weblantropia.com/wp-content/uploads/2014/11/copy-weblantropia_logo.png' //El URL de una imágen para usarla como icono
										}
									);
				
				notificar.onclick = function () {
					console.log('notification.Click');
				};
				notificar.onerror = function () {
					console.log('notification.Error');
				};
				notificar.onshow = function () {
					console.log('notification.Show');
				};
				notificar.onclose = function () {
					console.log('notification.Close');
				};
				
				return true;
		}
		*/
		var iniciarSesion = function(_divCampoVistUsu_,_divCampoVistPss_) {

			$(function() {
				ipCLiente.Iniciar();
			});		
			// validar de new los campos
			if($('#usuarioTxt').val()==""){
				//e.preventDefault();
				nucleo.alertaErrorPublic("Campo 'Usuario' vacio");
				return false;
			}
			if($('#contrasenaTxt').val()==""){
				//e.preventDefault();
				nucleo.alertaErrorPublic("Campo 'Contraseña' vacio");
				return false;
			}
			if(nucleo.verificarCaptchaPublic()==1){
				//e.preventDefault();
				return false;
			}


			var accionNucleo_ ="iniciarSesion";
	
			var resultado =[];		

			// -- datos --
			//			ipCLiente.obtenerPublic(function (ip_cliente_) {
			//quitar
			//var ip_cliente_ = "192.168.1.1";

					var usuario_ = $('#usuarioTxt').val().toUpperCase();
					var contrasena_ = $('#contrasenaTxt').val().toUpperCase();
                console.log(sessionStorage.getItem("ip_cliente-US"));                
				console.log('INICIANDO SESION  :::::'+sessionStorage.getItem("ip_cliente-US"));
			//-----------
		        $.ajax({
					url: 'Ctrl/utilidades/ctrl-nucleo.php',
					type:'POST',
					data:{
							accionNucleo:accionNucleo_,
							ip_cliente:sessionStorage.getItem("ip_cliente-US"),
							usuario:usuario_,
							contrasena:contrasena_,
						},
		            beforeSend: function () {
		            	


		            },
		            success:  function (result) {
						//alert(JSON.stringify(result));
	    				$(result).each(function (index, datoItem) { 
			            	
			            	resultadosError.inicioSesion=datoItem.controlError;
	    					if (datoItem.controlError==1){
	    						resultadosError.inicioSesion=1;

								$('#usuarioTxt').popover('destroy');
								$('#contrasenaTxt').popover('destroy');
								$('#usuarioTxt').removeClass('imputWarnig');
								$('#contrasenaTxt').removeClass('imputWarnig');

								nucleo.alertaErrorPublic("No existe el usuario");
								$('#usuarioTxt').removeClass('imputSusess').addClass('imputWarnig');
		  						$('#usuarioTxt').popover({ 
		  							content: "No existe el usuario", 
		  							placement: "left"
		  						}); 				
								$('#usuarioTxt').popover('show');

	    					}else if(datoItem.controlError==2){
	    						resultadosError.inicioSesion=1;
								
								$('#usuarioTxt').popover('destroy');
								$('#contrasenaTxt').popover('destroy');
								$('#usuarioTxt').removeClass('imputWarnig');
								$('#contrasenaTxt').removeClass('imputWarnig');

								nucleo.alertaErrorPublic("Contraseña Incorrecta");
								$('#contrasenaTxt').removeClass('imputSusess').addClass('imputWarnig');
		  						$('#contrasenaTxt').popover({ 
		  							content: "Contraseña Incorrecta", 
		  							placement: "left"
		  						}); 				
								$('#contrasenaTxt').popover('show');

	    					}else if(datoItem.controlError==3){
	    						resultadosError.inicioSesion=1;
								
								$('#usuarioTxt').popover('destroy');
								$('#contrasenaTxt').popover('destroy');
								$('#usuarioTxt').removeClass('imputWarnig');
								$('#contrasenaTxt').removeClass('imputWarnig');

								nucleo.alertaErrorPublic("Cuenta desactivada");
								$('#usuarioTxt').removeClass('imputSusess').addClass('imputWarnig');
		  						$('#usuarioTxt').popover({ 
		  							content: "Cuenta desactivada", 
		  							placement: "left"
		  						}); 				
								$('#usuarioTxt').popover('show');							

	    					}else{    						
	    						resultadosError.inicioSesion=0;

								nucleo.datosSesionPublic(result.resultadosDatos, result.resultadosPermisos, result.token);

					    		$.ajax({
					                /*data:  parametros,*/
					                url:   'Vist/contenido.php',
					                type:  'post',
					                beforeSend: function () {
					                    $("#index").html('<img src="Vist/img/cargando2.gif" class="img-cargando">');
					                },
					                success:  function (response) {
					                    $("#index").html(response);
					                    //activar menu dinamico
										nucleo.asignarPermisosPublic();
										nucleo.asignarDatosPublic();
										nucleo.tiempoParaSuspensionSistemaBDPublic();
						            }
						        });							


	    					};

	    				});
	    				
		            }
				}).fail(function (error) {
					//$('#'+_campoVist_).popover('destroy');
					console.log(JSON.stringify(error));
					alertas.dialogoErrorPublic(error.readyState,error.responseText);				
					console.log("Ocurrio un error");
				});
			//			});
		}

	    var continuarSesion = function (_divCampoVistPss_) {
			
			$(function() {
				ipCLiente.Iniciar();
			});
			// validar de new los campos
			if($('#usuarioTxt').val()==""){
				//e.preventDefault();
				nucleo.alertaErrorPublic("Campo 'Usuario' vacio");
				return false;
			}
			if($('#contrasenaTxt').val()==""){
				//e.preventDefault();
				nucleo.alertaErrorPublic("Campo 'Contraseña' vacio");
				return false;
			}
			if(nucleo.verificarCaptchaPublic()==1){
				//e.preventDefault();
				return false;
			}

			var accionNucleo_ ="continuarSesion";
			// -- datos --
				var usuario_ = $('#usuarioTxt').val().toUpperCase();
				var contrasena_ = $('#contrasenaTxt').val().toUpperCase();
			//
	        $.ajax({
				url: 'Ctrl/utilidades/ctrl-nucleo.php',
				type:'POST',
				data:{
						accionNucleo:accionNucleo_,
						usuario:usuario_,
						contrasena:contrasena_,
					},
	            beforeSend: function () {
	            	
	            },
	            success:  function (result) {
					//alert(JSON.stringify(result));
    				$(result).each(function (index, datoItem) { 
		            	
		            	resultadosError.inicioSesion=datoItem.controlError;
    					if(datoItem.controlError==2){
    						resultadosError.inicioSesion=1;
							
							$('#usuusuarioTxtBienvarioTxt').popover('destroy');
							$('#contrasenaTxt').popover('destroy');
							$('#usuarioTxtBienv').removeClass('imputWarnig');
							$('#contrasenaTxt').removeClass('imputWarnig');

							nucleo.alertaErrorPublic("Contraseña Incorrecta");
							$('#contrasenaTxt').removeClass('imputSusess').addClass('imputWarnig');
	  						$('#contrasenaTxt').popover({ 
	  							content: "Contraseña Incorrecta", 
	  							placement: "left"
	  						}); 				
							$('#contrasenaTxt').popover('show');

    					}else if(datoItem.controlError==3){
    						resultadosError.inicioSesion=1;
							
							$('#usuarioTxtBienv').popover('destroy');
							$('#contrasenaTxt').popover('destroy');
							$('#usuarioTxtBienv').removeClass('imputWarnig');
							$('#contrasenaTxt').removeClass('imputWarnig');

							nucleo.alertaErrorPublic("Cuenta desactivada");
							$('#usuarioTxtBienv').removeClass('imputSusess').addClass('imputWarnig');
	  						$('#usuarioTxtBienv').popover({ 
	  							content: "Cuenta desactivada", 
	  							placement: "left"
	  						}); 				
							$('#usuarioTxtBienv').popover('show');							

    					}else{    						
    
   							resultadosError.inicioSesion=0;
    						// --> re-asignar datos a la sesion  desde local storage
		    				verificarToken();
		                    $("#index").html('<img src="Vist/img/cargando2.gif" class="img-cargando">');
						    setTimeout(function(){ 

				    				var dat = sessionStorage.getItem("sesionDat");
				    				var ipTemp = sessionStorage.getItem("ip_cliente-US");
				    				sessionStorage.clear();
				    				sessionStorage.setItem("ip_cliente-US",ipTemp);
				    				dat = JSON.parse(dat);
				    				
			    					var datSesion = dat.datosSesion;
			    					
			    					var token = localStorage.getItem("token");
					
									nucleo.datosSesionPublic(datSesion.resultadosDatos, datSesion.resultadosPermisos, token);
						    		$.ajax({
						                /*data:  parametros,*/
						                url:   'Vist/contenido.php',
						                type:  'post',
						                beforeSend: function () {
						                    $("#index").html('<img src="Vist/img/cargando2.gif" class="img-cargando">');	               
						                },
						                success:  function (response) {
						                    $("#index").html(response);
											nucleo.guardarBitacoraPublic("CONTINUO LA SESION"); 						
						                    //activar menu dinamico
											nucleo.asignarPermisosPublic();
											nucleo.asignarDatosPublic();
											nucleo.tiempoParaSuspensionSistemaBDPublic();
							            }
							        });							
						    },400);

    					};

    				});
    				
	            }
			}).fail(function (error) {
				//$('#'+_campoVist_).popover('destroy');
				console.log(JSON.stringify(error));
				alertas.dialogoErrorPublic(error.readyState,error.responseText);				
				console.log("Ocurrio un error");
			});
			//return $('#datoControl').val();

	    		
	    }

		var datosSesion = function(datos, datosPermisos, token) {

			$(datos).each(function (index, dato) { 
				if (typeof(Storage) !== "undefined") {
				    // Code for localStorage/sessionStorage.
				    //usuario
				    sessionStorage.setItem("id-US", dato.id);
				    sessionStorage.setItem("id_persona-US", dato.id_persona);
				    sessionStorage.setItem("cedula-US", dato.cedula);
				    sessionStorage.setItem("nombre-US", dato.nombre);
				    sessionStorage.setItem("apellido-US", dato.apellido);
				    sessionStorage.setItem("id_departamento-US", dato.id_departamento);
				    sessionStorage.setItem("tipo_foto-US", dato.tipo_foto);
				    //sessionStorage.setItem("foto-US", dato.foto);
				    sessionStorage.setItem("estadoPerona-US", dato.estadoPerona);
				    sessionStorage.setItem("idUsuario-US", dato.idUsuario);
				    sessionStorage.setItem("usuario-US", dato.usuario);
				    sessionStorage.setItem("id_perfil-US", dato.id_perfil);
				    sessionStorage.setItem("nombrePerfil-US", dato.nombrePerfil);
				    sessionStorage.setItem("estadoUsuario-US", dato.estadoUsuario);
				    //permisos
				    sessionStorage.setItem("permisos-PPS", JSON.stringify(datosPermisos));
				    // ->>>>>>>>>>>>>  Control <<<<<<<<<<<<<<
				    localStorage.setItem("token", token);
				} else {
				    // Sorry! No Web Storage support..
				    alert('navergador no sopórta Storage');
				}
			});
			ipCLiente.obtenerPublic(function (ip_cliente_) {
				//sessionStorage.setItem("ip_cliente-US", ip_cliente_);
				//sessionStorage.setItem("ip_cliente-US", "192.168.1.1");
			}); 
			return true;
		}

		var modulos_ = {};
		/*
			modulos_[fila.id_modulo]={
				id:fila.id_modulo,
				id_modulo_pertenece:fila.id_modulo_pertenece,
				permiso_acceso:fila.permiso_acceso,
				estado_modulo:fila.estadoModulo,
				permisos:fila,
				internos:{},
			};
		*/		
		var asignarPermisos = function () {

			$('.side-menu  #menu-principal .item-menu').each(function (index, item) { 

				var idModulo = $(item).data('idmodulo');
				var nameItem = $(item).attr("name");
				var idItem = $(item).attr("id");
				var datos = JSON.parse(sessionStorage.getItem("permisos-PPS"));
				var	controlAsignadoNO=0;
				var	controlAsignadoSI=0;	
				/**************************************************************/

				//-> almacenamos datos de los modulos

				$(datos).each(function (index, fila) { 
						
					modulos_[fila.id_modulo]={
						id:fila.id_modulo,
						id_modulo_pertenece:fila.id_modulo_pertenece,
						permiso_acceso:fila.permiso_acceso,
						estado_modulo:fila.estadoModulo,
						permisos:fila,
						internos:{},
					};
					//asignamos - globalidad
					if (idModulo==fila.id_modulo) {
						$('#'+idItem+' a').data('permisos',fila);
					}
				});

				//-> asignamos hacia el modulo que pertenece 

				$(datos).each(function (index, modulo) { 
					//console.log(index);
					var id_modulo_pertenece = modulo.id_modulo_pertenece;
					if (id_modulo_pertenece>0) {
						modulos_[id_modulo_pertenece].internos[modulo.id_modulo]=modulo;
						//
					}
				});

				//console.log(modulos_);

				/**************************************************************/
				$(datos).each(function (index, fila) { 
					// el la opcion del menu, perteneciente al modulo

					if (fila.id_modulo_pertenece==0) {
						if (idModulo==fila.id_modulo) {
							controlAsignadoSI=1;
							if (fila.permiso_acceso==1) {
								//modulo permitido
								if (fila.estadoModulo==0 && sessionStorage.getItem('id_perfil-US')!=0) {
									//alert('modulo en mantenimiento');

									$(item).replaceWith( '<li class="menu-border item-menu" data-idmodulo="5">'+
									                        '<a  id="EnMantenimiento" href="javascript:;" onclick="navegacion.cambiarPaginaManteniminetoPublic();return false;">'+
									                            '<span class="glyphicon glyphicon-exclamation-sign"></span>'+
									                            nameItem+
									                        '</a>'+
									                    '</li>');
								};
								$(item).data('permisos_btn', fila);
							}else{
								// quitar modulo
								$(item).remove();
							};
						}else{
							controlAsignadoNO=0;
						};
					}
				});
				controlAsignadoNO=controlAsignadoNO+controlAsignadoSI;
				if (controlAsignadoNO==0) {
					// quitar modulo si no esta asignado
					$(item).remove();
				};

			});
		}
		var asignarSubPermisos = function (_id_modulo_actual_) {
			//-> almacenamos datos de los modulos
			var tienePermisos = false;
			for(internos in modulos_[_id_modulo_actual_].internos){
				var internos = internos;
				console.log(internos);
				if (modulos_[internos].permiso_acceso==1) {
					//modulo permitido
					if (modulos_[internos].estadoModulo==0) {
						$('.opcion'+internos).html('');
						var nameItem = $('.opcion'+internos).attr('name');
						$('.opcion'+internos).html(nameItem+' en mantenimiento');
					}else{
						tienePermisos = true;
						$('.opcion'+_id_modulo_actual_).data('permisos', modulos_[_id_modulo_actual_]);							
						$('.opcion'+internos).data('permisos', modulos_[internos]);							
					};
				}else{
					// quitar modulo
					console.log($('.opcion'+internos));
					console.log(internos);
					$('.opcion'+internos).remove();
				};
			}
			return tienePermisos;
		}
		var asignarPermisosBotones = function (_id_modulo_actual_) {

				if(modulos_[_id_modulo_actual_].permisos.func_nuevo==1){
					$(".nuevoBtnDiv").css('display','block');
				}else{
					$(".nuevoBtnDiv").css('display','none');
				}

				if(modulos_[_id_modulo_actual_].permisos.func_editar==1){
					$(".editarBtnDiv").css('display','block');
				}else{
					$(".editarBtnDiv").css('display','none');
				}

				if(modulos_[_id_modulo_actual_].permisos.func_eliminacion_logica==1){
					$(".eliminacionLogBtnDiv").css('display','block');
				}else{
					$(".eliminacionLogBtnDiv").css('display','none');
				}

				if(modulos_[_id_modulo_actual_].permisos.func_generar_reporte==1){
					$(".generarRptBtnDiv").css('display','block');
				}else{
					$(".generarRptBtnDiv").css('display','none');
				}

				if(modulos_[_id_modulo_actual_].permisos.func_generar_reporte_filtrado==1){
					$(".generarRptFltBtnDiv").css('display','block');
				}else{
					$(".generarRptFltBtnDiv").css('display','none');
				}


				if(modulos_[_id_modulo_actual_].permisos.func_permisos_perfil==1){
					$(".permisosPerfilBtnDiv").css('display','block');
				}else{
					$(".permisosPerfilBtnDiv").css('display','none');
				}

				if(modulos_[_id_modulo_actual_].permisos.func_busqueda_avanzada==1){
					$(".busquedaAvanzadaBtnDiv").css('display','block');
				}else{
					$(".busquedaAvanzadaBtnDiv").css('display','none');
				}

				if(modulos_[_id_modulo_actual_].permisos.func_detalles==1){
					$(".detallesBtnDiv").css('display','block');
				}else{
					$(".detallesBtnDiv").css('display','none');
				}

				if(modulos_[_id_modulo_actual_].permisos.func_atender==1){
					$(".atenderBtnDiv").css('display','block');
				}else{
					$(".atenderBtnDiv").css('display','none');
				}

				if(modulos_[_id_modulo_actual_].permisos.func_asignar==1){
					$(".asignarBtnDiv").css('display','block');
				}else{
					$(".asignarBtnDiv").css('display','none');
				}

				if(modulos_[_id_modulo_actual_].permisos.func_programar_tarea==1){
					$(".programarTareaBtnDiv").css('display','block');
				}else{
					$(".programarTareaBtnDiv").css('display','none');
				}

				if(modulos_[_id_modulo_actual_].permisos.func_iniciar_finalizar_tarea==1){
					$(".iniciarFinalizarTareaBtnDiv").css('display','block');
				}else{
					$(".iniciarFinalizarTareaBtnDiv").css('display','none');
				}

				if(modulos_[_id_modulo_actual_].permisos.func_diagnosticar==1){
					$(".diagnosticarBtnDiv").css('display','block');
				}else{
					$(".diagnosticarBtnDiv").css('display','none');
				}

				if(modulos_[_id_modulo_actual_].permisos.func_respuesta_solicitud==1){
					$(".respuestaSoltBtnDiv").css('display','block');
				}else{
					$(".respuestaSoltBtnDiv").css('display','none');
				}

				if(modulos_[_id_modulo_actual_].permisos.func_finalizar_solicitud==1){
					$(".finalizarSoltBtnDiv").css('display','block');
				}else{
					$(".finalizarSoltBtnDiv").css('display','none');
				}

				if(modulos_[_id_modulo_actual_].permisos.func_gestion_equipo_mantenimiento==1){
					$(".gestionEquipoBtnDiv").css('display','block');
				}else{
					$(".gestionEquipoBtnDiv").css('display','none');
				}
				/*************************************************************/

				if(modulos_[_id_modulo_actual_].permisos.func_desincorporar_equipo==1){
					$(".desincorporarEquipoBtnDiv").css('display','block');
				}else{
					$(".desincorporarEquipoBtnDiv").css('display','none');
				}

				if(modulos_[_id_modulo_actual_].permisos.func_desincorporar_periferico==1){
					$(".desincorporarPerifericoBtnDiv").css('display','block');
				}else{
					$(".desincorporarPerifericoBtnDiv").css('display','none');
				}

				if(modulos_[_id_modulo_actual_].permisos.func_desincorporar_componente==1){
					$(".desincorporarComponenteBtnDiv").css('display','block');
				}else{
					$(".desincorporarComponenteBtnDiv").css('display','none');
				}

				if(modulos_[_id_modulo_actual_].permisos.func_cambiar_periferico==1){
					$(".cambiarPerifericoBtnDiv").css('display','block');
				}else{
					$(".cambiarPerifericoBtnDiv").css('display','none');
				}

				if(modulos_[_id_modulo_actual_].permisos.func_cambiar_componente==1){
					$(".cambiarComponenteBtnDiv").css('display','block');
				}else{
					$(".cambiarComponenteBtnDiv").css('display','none');
				}
				console.log("func_cambiar_software : "+modulos_[_id_modulo_actual_].permisos.func_cambiar_software);
				
				if(modulos_[_id_modulo_actual_].permisos.func_cambiar_software==1){
					$(".cambiarSoftwareBtnDiv").css('display','block');
					$(".cambiarSoftwareListDiv").css('display','block');
				}else{
					$(".cambiarSoftwareBtnDiv").css('display','none');
					$(".cambiarSoftwareListDiv").css('display','none');
				}

				if(modulos_[_id_modulo_actual_].permisos.func_inconformidad_atendida==1){
					$(".inconformidadAtendidaBtnDiv").css('display','block');
				}else{
					$(".inconformidadAtendidaBtnDiv").css('display','none');
				}
				/***********************/
					if(modulos_[_id_modulo_actual_].permisos.func_desincorporar_periferico==0
					&& modulos_[_id_modulo_actual_].permisos.func_cambiar_periferico==0){
						$(".niDesincorporaCambiaPerifBtnDiv").css('display','none');
					}else{
						$(".niDesincorporaCambiaPerifBtnDiv").css('display','block');
					}
					if(modulos_[_id_modulo_actual_].permisos.func_desincorporar_componente==0
					&& modulos_[_id_modulo_actual_].permisos.func_cambiar_componente==0){
						$(".niDesincorporaCambiaCompBtnDiv").css('display','none');
					}else{
						$(".niDesincorporaCambiaCompBtnDiv").css('display','block');
					}				
				/***********************/

		}
		var asignarDatos = function() {
			// datos usuario
			$('.menu-usuario-datos-cargo').html('');
			$('.menu-usuario-datos-cargo').html('BIENVENIDO : ');
			$('.menu-usuario-datos-nombre').html('');
			$('.menu-usuario-datos-nombre').html(sessionStorage.getItem("nombre-US")+' '+sessionStorage.getItem("apellido-US"));

		}
	    var cerrarSesion = function(){

			// -- datos --
			//ipCLiente.obtenerPublic(function (ip_cliente_) {
			//quitar
			//var ip_cliente_ = "192.168.1.1";
			
			var accionNucleo_ = "cerrarSesion";

			//-----------
		        $.ajax({
					url: 'Ctrl/utilidades/ctrl-nucleo.php',
					type:'POST',
					data:{
							accionNucleo:accionNucleo_,
							ip_cliente:sessionStorage.getItem("ip_cliente-US"),
							id_usuario:sessionStorage.getItem("idUsuario-US"),
						},
		            beforeSend: function () {
		            	
				        $("#index").html('<img src="Vist/img/cargando2.gif" class="img-cargando">');

		            },
		            success:  function (result) {
									

	    				sessionStorage.clear();
   	                    localStorage.clear();
	    				var ipTemp = sessionStorage.getItem("ip_cliente-US");
	    				sessionStorage.setItem("ip_cliente-US",ipTemp);
   	                    clearTimeout(controlSuspension);
               	    	window.location.href="";
	    				
		            }
				}).fail(function (error) {
					//$('#'+_campoVist_).popover('destroy');
					console.log(JSON.stringify(error));
					alertas.dialogoErrorPublic(error.readyState,error.responseText);				
					console.log("Ocurrio un error");
				});
			//			});
	    }		

	    var verificarToken = function () {

			var accionNucleo_ ="verificarToken";
			var resultado_ = "";
			var token_ = "";
			if (localStorage.getItem("token")==undefined){
				token_ = undefined;
			}else{

				token_ = localStorage.getItem("token");

			};

	        $.ajax({
				url: 'Ctrl/utilidades/ctrl-nucleo.php',
				type:'POST',
				data:{
						accionNucleo:accionNucleo_,
						token:token_,
					},
	            beforeSend: function () {
	            	
                    $("#index").html('<img src="Vist/img/cargando2.gif" class="img-cargando">');

	            },
	            success:  function (result) {
					//alert(JSON.stringify(result));
    				$(result).each(function (index, datoItem_) { 
		            	
				    		sessionStorage.setItem("sesionDat", JSON.stringify(datoItem_));
				    		//console.log(datoItem_);
    				});    			

	            }
			}).fail(function (error) {
				//$('#'+_campoVist_).popover('destroy');
				console.log(JSON.stringify(error));
				alertas.dialogoErrorPublic(error.readyState,error.responseText);				
				console.log("Ocurrio un error");
			});
	    }

	    var verificarSesion = function () {
			
			var accionNucleo_ ="verificarToken";
			var resultado_ = "";
			var token_ = "";
			if (localStorage.getItem("token")==undefined){
				token_ = undefined;
			}else{

				token_ = localStorage.getItem("token");

			};

	        $.ajax({
				url: 'Ctrl/utilidades/ctrl-nucleo.php',
				type:'POST',
				data:{
						accionNucleo:accionNucleo_,
						token:token_,
					},
	            beforeSend: function () {
	            	
                    $("#index").html('<img src="Vist/img/cargando2.gif" class="img-cargando">');

	            },
	            success:  function (result) {
					//alert(JSON.stringify(result));
    				$(result).each(function (index, datoItem_) { 
		            	
	    				var dat = JSON.stringify(datoItem_);
	    				var ipTemp = sessionStorage.getItem("ip_cliente-US");
	    				sessionStorage.clear();
	    				sessionStorage.setItem("ip_cliente-US",ipTemp);
						dat = JSON.parse(dat);    				

		            	resultadosError.inicioSesion=dat.controlError;

		            	if (dat.controlError>0) {
				    		//
				    		console.log('Aun no inicias sesión');
				    		// SI NO HA INICIADO SESSION SE CARGA LA ITERFAZ DE LOGIN
				    		$.ajax({
				                url:   'Vist/no-login.php',
				                type:  'post',
				                beforeSend: function () {
				                    $("#index").html('<img src="Vist/img/cargando2.gif" class="img-cargando">');
				                },
				                success:  function (response) {
				                    $("#index").html(response);
					            }
					        });									

				    	}else{

	    					var datSesion = dat.datosSesion;

				    		// SI HA INICIADO SESSION : SE CONFIGURA Y SE CARGA INTERFAZ DE CONTENIDO

							//nucleo.datosSesionPublic(result.resultadosDatos, result.resultadosPermisos, result.token);
				    		$.ajax({
				                url:   'Vist/login.php',
				                type:  'post',
				                beforeSend: function () {
				                    $("#index").html('<img src="Vist/img/cargando2.gif" class="img-cargando">');
				                },
				                success:  function (response) {
				                    $("#index").html(response);
				                    //activar menu dinamico
									//nucleo.asignarPermisosPublic();
									//nucleo.asignarDatosPublic();

							        console.log('INGRESA CONTRASEÑA PARA CONTINUAR');

							        $("#usuarioTxtBienv").html('Bienvenido  '+datSesion.resultadosDatos.nombre +'  '+ datSesion.resultadosDatos.apellido);
					            	$("#usuarioTxt").val(datSesion.resultadosDatos.usuario);
					            	//
					            	nucleo.tiempoParaSuspensionSistemaBDPublic();
					            }
					        });		
				    	};


    				});    			

	            }
			}).fail(function (error) {
				//$('#'+_campoVist_).popover('destroy');
				console.log(JSON.stringify(error));
				alertas.dialogoErrorPublic(error.readyState,error.responseText);				
				console.log("Ocurrio un error");
			});
	    }

	    var iniciarSesionOtraCuenta = function () {

	    	console.log("Iniciar sesion con otra cuenta");
	    	cerrarSesion();
	    }

	    var verificarExistenciaSelect = function (id_contenedor_) {

	    	//alert(nucleo.isEdicion);
			$("#"+id_contenedor_+" form select.lista-control-change").on("change", function(e){

				var itemChange_= $(e.target).attr('id'); 
				var contentControl = $('#'+itemChange_).data('content-popover');
				//alert(contentControl);
				var accion_ = "verificarExistenciaSelect";
				//

					var datos_={};
					var seleccionados=0;
					$('#'+id_contenedor_+' form select.lista-control-change').each(function (index, datoItem){
						
						// Obteniendo datos del select
						var id_ = $(datoItem).val();
						//alert(id_);
						var tabla_form_ = $(datoItem).data("tabla-form");
						var tabla_campo_ = $(datoItem).data("tabla-campo");
						var columna_campo_ = $(datoItem).data("columna-campo");

						if (id_!=null || id_!='' || id_!=undefined ) {
							//alert(id_);

							datos_['data'+index] = {
														id: id_, 
														tabla_form: tabla_form_,  
														tabla_campo: tabla_campo_,
														columna_campo: columna_campo_,
													};
							seleccionados=seleccionados+1;
						};
					});
					//alert('Cantidad: '+interfaces_.length+' array: '+interfaces_+' seleccionados: '+seleccionados);
					if (datos_.length<1 || seleccionados==0){
						var datos_=0;
					}else{
						//console.log(JSON.stringify(datos_));	
					};

			        var _id_ = $('#datoControlId').val();

			        if (_id_!=undefined) {
			        	//alert(_id_);	        	
			        }else{
			        	_id_=0;
			        };

				//
		        $.ajax({
					url: 'Ctrl/utilidades/ctrl-nucleo.php',
					type:'POST',	
					data:{	
							accionNucleo:accion_,
							id:_id_,
							datos:JSON.stringify(datos_),
						},
	                beforeSend: function () {
		            	// Camo de cambio
						$('#'+contentControl).popover({
						    html: true, 
							placement: "bottom",
							content: function() {
						          return $('#procesandoDatosInput').html();
						        }
						});
						$('#'+contentControl).popover('show');

	                },
	                success:  function (result) {

	                	//console.log(result.resultados);

	    				$(result).each(function (index, datoItem) { 
			            	$('#'+contentControl).popover('destroy');

							//console.log(datoItem.resultados);
	    				$(datoItem).each(function (index, datoItemInterno) { 

	    				});
	    					resultadosError.existenciaCombinacionSelect = datoItem.resultados;
	    					//console.log("Estado de existencia : "+datoItem.resultados);
	    					//alert("Estado de existencia : "+datoItem.resultados);
	    					if (datoItem.resultados>0) {
								nucleo.alertaErrorPublic("Ya existe la combinacion seleccionada");
								$('#'+contentControl).removeClass('imputSusess').addClass('imputWarnig');
		  						$('#'+contentControl).popover({ 
		  							content: "Ya existe la combinacion seleccionada", 
		  							placement: "bottom"
		  						}); 				
								$('#'+contentControl).popover('show');
	    					}else{
	    						resultadosError.existenciaCombinacionSelect=0;
								$('#'+contentControl).removeClass('imputWarnig').addClass('imputSusess');
	    					};
	    					validador();
	    				});

	                },
			    	error:  function(error) {
   						console.log(JSON.stringify(error));	
							alertas.dialogoErrorPublic(error.readyState,error.responseText);	   						
				    }
				});
		        //
		    });			
	    }
		var limpiar_caracteres_especiales = function (text_)
		{
			var text = text_.toLowerCase(); // a minusculas
			text = text.replace(/[áàäâå]/g, 'a');
			text = text.replace(/[éèëê]/g, 'e');
			text = text.replace(/[íìïî]/g, 'i');
			text = text.replace(/[óòöô]/g, 'o');
			text = text.replace(/[úùüû]/g, 'u');
			text = text.replace(/[ýÿ]/g, 'y');
			text = text.replace(/[ñ]/g, 'n');
			text = text.replace(/[ç]/g, 'c');
//			text = text.replace(/['']/g, '');
//			text = text.replace(/[^a-zA-Z0-9-]/g, ' '); //text = text.replace(/W/g, ' ');
//			text = text.replace(/s+/g, '-');
//			text = text.replace(/(_)$/g, '');
//			text = text.replace(/^(_)/g, '');
			return text;
		}

		var verificarExistencia = function(_tabla_,_columna_,_campoVist_,_divCampoVist_) {
			
			var accionNucleo_ ="verificarExistencia";
			var _filtro_ = $('#'+_campoVist_).val();
			_filtro_ = limpiar_caracteres_especiales(_filtro_);
	        var _id_ = $('#datoControlId').val();
	        var yaExiste = false;
	        if (_id_!=undefined) {
	        	//alert(_id_);	        	
	        }else{
	        	_id_=0;
	        };

			if(_filtro_==""){
				resultadosError.existencia=0;
				$('#'+_campoVist_).removeClass('imputWarnig').addClass('imputSusess');				
				return false;
			}
	        $.ajax({
				async : false,
				url: 'Ctrl/utilidades/ctrl-nucleo.php',
				type:'POST',
				data:{
						accionNucleo:accionNucleo_,
						tabla:_tabla_,
						columna:_columna_,
						filtro:_filtro_,
						id:_id_,
					},
	            beforeSend: function () {
	            	// Camo de origen
					$('#'+_divCampoVist_).popover({
					    html: true, 
						placement: "bottom",
						content: function() {
					          return $('#procesandoDatosInput').html();
					        }
					});
					$('#'+_divCampoVist_).popover('show');

	            },
	            success:  function (result) {
	            	console.log(JSON.stringify(result));
    				$(result).each(function (index, datoItem) { 
		            	$('#'+_divCampoVist_).popover('destroy');
		            	$('#'+_campoVist_).popover('destroy');

    					$('#datoControl').val(datoItem.resultados);
    					resultadosError.existencia = $('#datoControl').val();
    					//console.log("Estado de existencia : "+datoItem.resultados);
    					
    					if (datoItem.resultados>0) {
    						yaExiste = true;
							nucleo.alertaErrorPublic("Ya existe el/la "+_columna_);
							$('#'+_campoVist_).removeClass('imputSusess').addClass('imputWarnig');
	  						$('#'+_campoVist_).popover({ 
	  							content: "Ya existe el/la "+_columna_, 
	  							placement: "bottom"
	  						}); 				
							$('#'+_campoVist_).popover('show');
    					}else{
    						resultadosError.existencia=0;
							$('#'+_campoVist_).removeClass('imputWarnig').addClass('imputSusess');
    					};
    				});
	            }
			}).fail(function (error) {
				$('#'+_campoVist_).popover('destroy');
				console.log(JSON.stringify(error));
				alertas.dialogoErrorPublic(error.readyState,error.responseText);				
				console.log("Ocurrio un error");
			});
			return yaExiste;
		}

		var esValidoString = function(_stringRegular_,_string_) { 

		  		return _stringRegular_.test(_string_);
		} 

		var verificarDatosInput = function (event,_thisCampoVist_,_divCampoVist_) {

			var _campoVist_ = _thisCampoVist_.id;
			//
			var verificarSoloNumero = $('#'+_campoVist_).data("solonumero");
			var verificarSoloLetraYNumero = $('#'+_campoVist_).data("sololetraynumero");
			var verificarSoloLetra = $('#'+_campoVist_).data("sololetra");
			var verificarSoloLetraYEspacio = $('#'+_campoVist_).data("sololetrayespacio");
			var verificarDescripcion = $('#'+_campoVist_).data("descripcion");
			var verificarDescripcionYnumero = $('#'+_campoVist_).data("descripcionnumero");
			var verificarSoloLetraYExpresionesRnumero = $('#'+_campoVist_).data("letraexpresionnumero");
			//
			var texto = $('#'+_campoVist_).val();
			if (verificarSoloLetra==1){
		        var resultValidacion = esValidoString(/[a-zA-ZáÁéÉíÍóÓúÚñÑ]\D*/,event.key);
				if (resultValidacion==false){
					event.preventDefault();
				}
			};
			if (verificarSoloLetraYEspacio==1){
				var resultValidacion = esValidoString(/[a-zA-ZáÁéÉíÍóÓúÚñÑ ]\D*/,event.key);
				if (resultValidacion==false){
					event.preventDefault();
				}
			};
			if (verificarDescripcion==1){
				var resultValidacion = esValidoString(/[a-zA-Z ,.()¡!¿?"'ZáÁéÉíÍóÓúÚñÑ]\D*/,event.key);
				if (resultValidacion==false){
					event.preventDefault();
				}
			};
			if (verificarDescripcionYnumero==1){
				var resultValidacion = esValidoString(/[a-zA-Z0-9 ,.()¡!¿?"'ZáÁéÉíÍóÓúÚñÑ]\D*/,event.key);
				if (resultValidacion==false){
					event.preventDefault();
				}
			};			
			if (verificarSoloLetraYExpresionesRnumero==1){
				var resultValidacion = esValidoString(/[a-zA-Z.-_0-9áÁéÉíÍóÓúÚñÑ]\D*/,event.key);
				if (resultValidacion==false){
					event.preventDefault();
				}				
			};	
			if (verificarSoloLetraYNumero==1){
				var resultValidacion = esValidoString(/[a-zA-Z 0-9áÁéÉíÍóÓúÚñÑ]\D*/,event.key);
				if (resultValidacion==false){
					event.preventDefault();
				}						        
			};																
			if (verificarSoloNumero==1){
				var resultValidacion = esValidoString(/[0-9]\D*/,event.key);
				if (resultValidacion==false){
					event.preventDefault();
				}						        
			};
		}

		var verificarDatosDetector = function(_event_,_tabla_,_columna_,_campoVist_,_divCampoVist_) {
    		var codigoTecla = event.which || event.keyCode;			
    		console.log("Tecla presionada: " + codigoTecla);
				if (			codigoTecla==8 ||
								codigoTecla==9 ||
								/*codigoTecla==65 ||
								codigoTecla==66 ||
								codigoTecla==67 ||
								codigoTecla==68 ||
								codigoTecla==69 ||
								codigoTecla==70 ||
								codigoTecla==71 ||
								codigoTecla==72 ||
								codigoTecla==73 ||
								codigoTecla==74 ||
								codigoTecla==75 ||
								codigoTecla==76 ||
								codigoTecla==77 ||
								codigoTecla==78 ||
								codigoTecla==79 ||
								codigoTecla==80 ||
								codigoTecla==81 ||
								codigoTecla==82 ||
								codigoTecla==83 ||
								codigoTecla==84 ||
								codigoTecla==85 ||
								codigoTecla==86 ||
								codigoTecla==87 ||
								codigoTecla==88 ||
								codigoTecla==89 ||
								codigoTecla==90 ||*/
								codigoTecla==32 ||
								codigoTecla==35 ||
								codigoTecla==37 ||
								codigoTecla==38 ||
								codigoTecla==39 ||
								codigoTecla==40 ||								
								codigoTecla==46) {
					return false;
				}
			//
			var verificarExistencia = $('#'+_campoVist_).data("vexistencia");
			var verificarSoloNumero = $('#'+_campoVist_).data("solonumero");
			var verificarSoloLetraYNumero = $('#'+_campoVist_).data("sololetraynumero");
			var verificarSoloLetra = $('#'+_campoVist_).data("sololetra");
			var verificarSoloLetraYEspacio = $('#'+_campoVist_).data("sololetrayespacio");
			var verificarDescripcion = $('#'+_campoVist_).data("descripcion");
			var verificarSoloLetraYExpresionesRnumero = $('#'+_campoVist_).data("letraexpresionnumero");

			if (verificarExistencia==1){
				nucleo.verificarExistenciaPublic(_tabla_,_columna_,_campoVist_,_divCampoVist_);
			};
			if (verificarSoloLetra==1){
				var texto = $('#'+_campoVist_).val();
		        $('#'+_campoVist_).val((texto).replace(/[^a-zA-ZÁáÉéíÓúÚñÑ]/g, '') );
			    
			};
			if (verificarSoloLetraYEspacio==1){

				var texto = $('#'+_campoVist_).val();
				// es distinto a esto (segun las expresiones regulares )
		        if (texto.match(/[^a-zA-ZÁáÉéíÓúÚñÑ ]/g)) {
			        //se remplaza
			        $('#'+_campoVist_).val((texto).replace(/[^a-zA-ZÁáÉéíÓúÚñÑ ]/g, '') );
			    }else{
			    	console.log("todo bien...");
			    }	
			    			
			};
			if (verificarDescripcion==1){
		        $('#'+_campoVist_).val(($('#'+_campoVist_).val()).replace(/[^a-zA-Z ,.()¡!¿?"'ÁáÉéíÓúÚñÑ]/g, '') );
			};
			if (verificarSoloLetraYExpresionesRnumero==1){
		        $('#'+_campoVist_).val(($('#'+_campoVist_).val()).replace(/[^a-zA-Z.-_0-9]/g, '') );
			};	
			if (verificarSoloLetraYNumero==1){
		   	$('#'+_campoVist_).val(($('#'+_campoVist_).val()).replace(/[^a-zA-Z 0-9]/g, '') );
			};																
			if (verificarSoloNumero==1){
		        $('#'+_campoVist_).val(($('#'+_campoVist_).val()).replace(/[^0-9]/g, '') );
			};

		}
		var verificarDatos = function(_tabla_,_columna_,_campoVist_,_divCampoVist_) {
			var verificarExistencia = $('#'+_campoVist_).data("vexistencia");

			if (verificarExistencia==1){
				nucleo.verificarExistenciaPublic(_tabla_,_columna_,_campoVist_,_divCampoVist_);
			};
		}
		var camposDatos = function () {
			var erroCant=0;
			var errorCampV=0;
				//alert(resultadosError.campoVacio);
				$('.panel-body .row .form-group .campo-control ').each(function (index, datoItem) {

					// la suma de la existencia de errores dira si hay errores... 0 o mas de 0

					// Preparando Variables
					var idItem = $(datoItem).attr("id");
					var nameItem = $(datoItem).attr("name");
					var cantMax = $('#'+idItem).data("cantmax");
					var cantMin = $('#'+idItem).data("cantmin");
					var varidaraExistencia = $('#'+idItem).data("vexistencia");
					var varidaraCorreoElectronico = $('#'+idItem).data("vcorreo");
					var esSelect = 0;
					esSelect = $('#'+idItem).data("select");
					if (esSelect==undefined) {
						esSelect = 0;
					};
					var datos = $('#'+idItem).val();
					//
					// 1ro - Campos vacios
					if($('#'+idItem).val()==""){
						if ($('#'+idItem).hasClass("select")==false){
							$('#'+idItem).removeClass('imputSusess').addClass('imputWarnig');
							nucleo.alertaErrorPublic(" Campo ' "+nameItem+" ' Vacio ");

							errorCampV=1+errorCampV;
						};
					}else if(($('#'+idItem).val()==0 || $('#'+idItem).val()==null) && $('#'+idItem).hasClass("select")==true){

						$('select#'+idItem).removeClass('imputSusess').addClass('imputWarnig');
						nucleo.alertaErrorPublic("  "+nameItem+"  no seleccionado ");
						$('select#'+idItem).on('change',function (item) {
							$('#btnGuardar').prop('disabled', false);
						});
						errorCampV=1+errorCampV;
					}else{
						//alert(idItem);
						//	Ya que hay texto	-	Se convierte en mayuscula
						if (idItem!=undefined) {
							var mayusculas = $('#'+idItem).val().toUpperCase();
							$('#'+idItem).val(mayusculas);
						};
						//
						if (resultadosError.campoVacio==0 && resultadosError.existencia==0) {
							$('#'+idItem).removeClass('imputWarnig').addClass('imputSusess');
						} else{
							$('#'+idItem).removeClass('imputSusess').addClass('imputWarnig');
							$('#'+idItem).popover('destroy');
						};
					}


					if (esSelect==0 && idItem!=undefined) {

								//
								if( $('.no-v-minmax').length ){
								}else{	
									// 2do - datos en los campos
									if(datos.length>cantMax){

										$('#'+idItem).removeClass('imputSusess').addClass('imputWarnig');
										$('#'+idItem).popover('destroy');
				  						$('#'+idItem).popover({ 
				  							content: "Cantidad maxima de "+cantMax+" alcanzado ", 
				  							trigger: "click" ,
				  							placement: "bottom"
				  						}); 
				    					$('#'+idItem).click();
										erroCant=1+erroCant;

									} else if (datos.length<cantMin) {

										$('#'+idItem).removeClass('imputSusess').addClass('imputWarnig');
										$('#'+idItem).popover('destroy');
				  						$('#'+idItem).popover({ 
				  							content: "Cantidad minima de "+cantMin+" alcanzado ", 
				  							trigger: "click" ,
				  							placement: "bottom"
				  						}); 
				    					$('#'+idItem).click();
										erroCant=1+erroCant;
									}else{
										// aca se toma en cuenta si al campo sera le validara la existencia
										if(resultadosError.existencia==0 && varidaraExistencia==1) {
											$('#'+idItem).popover('destroy');
											$('#'+idItem).removeClass('imputWarnig').addClass('imputSusess');
										}else if (varidaraExistencia==0) {
											$('#'+idItem).popover('destroy');
											$('#'+idItem).removeClass('imputWarnig').addClass('imputSusess');							
										};						
									}
								}



								if (varidaraCorreoElectronico==1){
								   // Expresion regular para validar el correo					    	
							    	//formato = /^[_A-Za-z0-9-\\+]+(\\.[_A-Za-z0-9-]+)*@"+"[A-Za-z0-9-]+(\\.[A-Za-z0-9]+)*(\\.[A-Za-z]{2,})$/i;
							    	//[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
								    var formato = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;

									if (formato.test(datos)) {
										//correo valido
										resultadosError.correoValido=0;
										$('#'+idItem).popover('destroy');
										$('#'+idItem).removeClass('imputWarnig').addClass('imputSusess');
										
									}else if(datos==""){

										resultadosError.correoValido=1;
										$('#'+idItem).removeClass('imputSusess').addClass('imputWarnig');
										$('#'+idItem).popover('destroy');
				  						$('#'+idItem).popover({ 
				  							content: " Correo Electronico Invalido, ejemplo correcto: nombrecorreo@hostingservicio.com. <hr style='margin: 5px 0px;'> Prohibida la acentuación o simbologia similar a: }{<>¿?¡:(&$ ", 
				  							trigger: "click" ,
				  							placement: "bottom"
				  						}); 
				    					$('#'+idItem).click();
									}else{

										resultadosError.correoValido=1;
										$('#'+idItem).removeClass('imputSusess').addClass('imputWarnig');
										$('#'+idItem).popover('destroy');
				  						$('#'+idItem).popover({ 
				  							content: " Correo Electronico Invalido, ejemplo correcto: nombrecorreo@hostingservicio.com. <hr style='margin: 5px 0px;'> Prohibida la acentuación o simbologia similar a: }{<>¿?¡:(&$ ", 
											html : true,
				  							trigger: "click" ,
				  							placement: "bottom"
				  						}); 
				    					$('#'+idItem).click();
									
									}
								};
						};
					//
				});
				resultadosError.resultadoCantDatos = erroCant;
				resultadosError.campoVacio=errorCampV;
				erroCant=0;
				errorCampV=0;
			return resultadosError;	
		}

		var convetirMinMayus = function (this_,minMay_) {
			switch(minMay_){
				case 'min' :

					s=this_.selectionStart;
					e=this_.selectionEnd;
					texto=this_.value;

					this_.value=texto.toLowerCase();
					this_.selectionStart=s;
					this_.selectionEnd=e;

				break;
				case 'may' :

					s=this_.selectionStart;
					e=this_.selectionEnd;
					texto=this_.value;
					
					this_.value=texto.toUpperCase();
					this_.selectionStart=s;
					this_.selectionEnd=e;

				break;
			}

		}

		var cargarListaDespegable = function(_idCampo_,_tabla_) {
			var accionNucleo_ ="cargarListaDespegable";
	        $.ajax({
				url: 'Ctrl/utilidades/ctrl-nucleo.php',
				type:'POST',
				data:{
						accionNucleo:accionNucleo_,
						tabla:_tabla_,
					},
	            beforeSend: function () {
	            // cargando
	            },
	            success:  function (result) {
   					$('select#'+_idCampo_).html('');	            	
    				$(result).each(function (index, datoItem) { 
    					$(datoItem.resultados).each(function (index, item) {
	    					//console.log(item);
	    					var opcion = $('<option id="'+item.id+'" value="'+item.id+'">'+item.nombre+'</option>');
	    					$('select#'+_idCampo_).append(opcion);
    					});
    				});
	            }
			}).fail(function (error) {
				console.log(JSON.stringify(error));
				alertas.dialogoErrorPublic(error.readyState,error.responseText);				
				console.log("Ocurrio un error");
			});
		}

		var cargarListaDespegableUtf8Encode = function(_idCampo_,_tabla_) {
			var accionNucleo_ ="cargarListaDespegableUtf8Encode";
	        $.ajax({
				url: 'Ctrl/utilidades/ctrl-nucleo.php',
				type:'POST',
				data:{
						accionNucleo:accionNucleo_,
						tabla:_tabla_,
					},
	            beforeSend: function () {
	            // cargando
	            },
	            success:  function (result) {
   					$('select#'+_idCampo_).html('');	            	
    				$(result).each(function (index, datoItem) { 
    					$(datoItem.resultados).each(function (index, item) {
	    					//console.log(item);
	    					var opcion = $('<option id="'+item.id+'" value="'+item.id+'">'+item.nombre+'</option>');
	    					$('select#'+_idCampo_).append(opcion);
    					});
    				});
	            }
			}).fail(function (error) {
				console.log(JSON.stringify(error));
				alertas.dialogoErrorPublic(error.readyState,error.responseText);				
				console.log("Ocurrio un error");
			});
		}
		var cargarListaDespegableListas = function(_idCampo_,_tabla_,_nombreCampo_) {

			var accionNucleo_ ="cargarListaDespegable";
	        $.ajax({
				url: 'Ctrl/utilidades/ctrl-nucleo.php',
				type:'POST',
				data:{
						accionNucleo:accionNucleo_,
						tabla:_tabla_,
					},
	            beforeSend: function () {
	            // cargando
	            },
	            success:  function (result) {
   					$('#'+_idCampo_).html('');	            	
   					if (_nombreCampo_=="") {
						var noselect = $('<option data-subtext="" value="0" >Seleccione una opción </option>');   						
   					} else{
						var noselect = $('<option data-subtext="" value="0" >Seleccione '+_nombreCampo_+'</option>');   						
   					};	
	    			$('#'+_idCampo_).append(noselect);    		
    				$(result).each(function (index, datoItem) { 
    					$(datoItem.resultados).each(function (index, item) {
	    					//console.log(item);
	    					var opcion = $('<option data-subtext="'+/*_nombreCampo_+*/'"  value="'+item.id+'" >'+item.nombre+'</option>');
	    					$('#'+_idCampo_).append(opcion);
    					});
    				});
	            }
			}).fail(function (error) {
				console.log(JSON.stringify(error));
				alertas.dialogoErrorPublic(error.readyState,error.responseText);				
				console.log("Ocurrio un error");
			});
			//return $('#datoControl').val();
		}	
	
		var cargarListaDespegableListasAnidada = function(_idCampo_,_tabla_,_columna_,_id_filtro_,_nombreCampo_) {
			var accionNucleo_ ="cargarListaDespegableAnidada";
	        $.ajax({
				url: 'Ctrl/utilidades/ctrl-nucleo.php',
				type:'POST',
				data:{
						accionNucleo:accionNucleo_,
						tabla:_tabla_,
						columna:_columna_,
						id_filtro:_id_filtro_,
					},
	            beforeSend: function () {
	            // cargando
	            },
	            success:  function (result) {
   					$('#'+_idCampo_).html('');	            	
					if (_nombreCampo_=="") {
						var noselect = $('<option data-subtext="" value="0" >Seleccione una opción </option>');   						
   					} else{
						var noselect = $('<option data-subtext="" value="0" >Seleccione '+_nombreCampo_+'</option>');   						
   					};	

	    			$('#'+_idCampo_).append(noselect);    		
    				$(result).each(function (index, datoItem) { 
    					//console.log(JSON.stringify(result.resultados));
	    				if(result.resultados!=undefined) {	
	    					$(result.resultados).each(function (index, item) {
		    					//console.log(item);
		    					var opcion = $('<option data-subtext="'+/*_nombreCampo_+*/'"  value="'+item.id+'" >'+item.nombre+'</option>');
		    					$('#'+_idCampo_).append(opcion);
	    					});
	    				}else{
		   					$('#'+_idCampo_).html('');	            	
							var noselect = $('<option data-subtext="" value="0" select disabled>No hay '+_nombreCampo_+' relacionado</option>');	    					
			    			$('#'+_idCampo_).append(noselect);			
	    				};
    				});
	            }
			}).fail(function (error) {
				console.log(JSON.stringify(error));
				alertas.dialogoErrorPublic(error.readyState,error.responseText);
				console.log("Ocurrio un error");
			});
			//return $('#datoControl').val();
		}				
		var cargarPopOver = function(_idItem_){

			//alert("cargando notificacion");
			//$('#'+idItem).popover('destroy');
			$('#'+_idItem_).popover({ 
				content: "  <div class='row'><div class='col-md-2 col-md-offset-10'>"+
								""+
								"</div>"+
								"<div class='col-md-2 col-md-offset-10'>"+
								""+	
								"</div>"+
						    "</div>"+
							"<div class='row'>"+
								"<div class='col-md-12'>"+
									 "<span>Cerrar</span>"+
								"</div>"+								
						   "</div>"						   
						   , 
				html : true,
			//trigger: "click",
				placement: "bottom"
			});
			$('#'+_idItem_).popover('show');
			// CON ATRIBUTO DATA - INDICAR QUE EL OBJETO YA TIENE UN "popover"
	    	//$('#'+_idItem_).click();			
			/*
			$.ajax({
                //data:  parametros,	
                url:   urlRecibida,
                type:  'post',
                beforeSend: function () {
                    $("#contenido").html('<img src="Vist/img/cargando2.gif" class="img-cargando">');
                },
                success:  function (response) {
                    $("#contenido").html(response);
                }
        	});
			*/
			$('#'+_idItem_).on("dobleClick",function (argument){
				//alert("blickyer")
			});
		}

		function verificarFormatoImagene(archivo) { 
		   extensiones_permitidas = new Array(".png", ".jpg", ".jpeg"); 

		      //recupero la extensión de este nombre de archivo 
		      extension = (archivo.substring(archivo.lastIndexOf("."))).toLowerCase(); 
		      //alert (extension); 
		      //compruebo si la extensión está entre las permitidas 
		      permitida = false; 
		      for (var i = 0; i < extensiones_permitidas.length; i++) { 
		         if (extensiones_permitidas[i] == extension) { 
		         permitida = true; 
		         break; 
		         } 
		      } 
		      if (permitida) { 
		         return true; 
		      } 
		   //si estoy aqui es que no se ha podido submitir 
		   return false; 
		}		
		var reiniciarVariablesGNucleo = function() {
			
				resultadosError.campoVacio =0 ; 
				resultadosError.resultadoCantDatos=0;
				resultadosError.existencia=0;	
				resultadosError.correoValido=0;
				resultadosError.captcha=0;
		}
		var reiniciarFormulario = function() {
			$('#ventana-modal .panel-body .row .form-group .campo-control ').each(function (index, datoItem) {
				// Preparando Variables
				var idItem = $(datoItem).attr("id");
				$('#'+idItem).popover('destroy');

			});
			$('#ventana-modal .panel-body .row .form-group .listd-control').each(function (index, datoItem) {
				// Preparando Variables
				var idcampo_ = $(datoItem).attr('id');
				var tabla_ = $(datoItem).data('tabla');
				//alert(idcampo_+' '+tabla_);
				nucleo.cargarListaDespegablePublic(idcampo_, tabla_);		

			});						
	        if ($('#ventana-modal .panel-body #form').length>0) {
	        	$('#ventana-modal .panel-body #form')[0].reset();
	        };
        	        	
	        nucleo.isEdicion=0;
		}
		var controlBtnAdminInProcess = function () {
				// NO HAY NECIDAD DE COMPROBAR SI ESTA ABRIERTO EL PANEL DE CONFIGURACION,
				// PORQUE ES UNA CONDICION PARA PODER EJECUTAR ESTA FUNCION.
		        if ($('#ventana-modal-cfg-internos').hasClass('ventana-modal-panel-accionMostrar')==true) {
					$('#ventana-modal-cfg-internos').removeClass('ventana-modal-panel-accionMostrar').addClass('ventana-modal-panel-accionCerrar').slideUp(200);
		        }else{
					$('#ventana-modal-cfg').removeClass('ventana-modal-panel-accionMostrar').addClass('ventana-modal-panel-accionCerrar').slideUp(200);
		        };

		}
		var controlAccessBtnAdmin = function () {
				$(document).ready(function () {
				 	var id_perfil =	sessionStorage.getItem("id_perfil-US");
				 	if (id_perfil==1) {
				 		$('.btn-cfg-admin').css('display','block');
				 	}else{
				 		$('.btn-cfg-admin').css('display','none');
				 	};
				});
		}

	/****************************Metodos de control**************************/	

		var validador = function() {

			var validacion=true;
			var error = 0;

			// mayor que 0 es que presenta un error
			/*
					Tener en cuenta, que aca se controlan, el resultados de las validacion de todos los campos
			*/
			nucleo.camposDatosPublic();

			if(resultadosError.existencia>0){
				error=1;
				validacion=false;
			} else if(resultadosError.existenciaCombinacionSelect>0){
				error=1;
				validacion=false;
			} else if(resultadosError.resultadoCantDatos>0){
				error=1;
				validacion=false;
			} else if(resultadosError.campoVacio>0){
				error=1;
				validacion=false;
			} else if(resultadosError.correoValido>0){	
				error=1;
				validacion=false;				
			}else{
				error=0;
				validacion=true;				
			}

			if (error==0) {
				//nucleo.alertaExitoPublic(" Todo bien en los campos ");				
				//$('#btnGuardar').prop('disabled', false);
				$('#btnIniciarSesion').prop('disabled', false);
				nucleo.reiniciarVariablesGNPublic();
			} else{
				//$('#btnGuardar').prop('disabled', true);
				$('#btnIniciarSesion').prop('disabled', false);
			};
			
			//error = 0;
			return validacion;
		}
		/*
			
		*/
		var activarEnvioInicSesion = function () {
		
			var idForm = "#form-no-login";

			$(idForm+' input').on('keypress', function(e) {
			    if(e.keyCode==13){
					if(nucleo.validadorPublic()==true){
			        	nucleo.iniciarSesionPublic('divUsuarioTxt','divContrasenaTxt');
					}
			    }
			});
			//

		}
		var activarEnvioContSesion = function () {
		
			var idForm = "#form-login";

			$(idForm+' input').on('keypress', function(e) {
			    if(e.keyCode==13){
					if(nucleo.validadorPublic()==true){
			        	nucleo.continuarSesionPublic('divContrasenaTxt');
					}
			    }
			});
			//

		}
	/************************************/		
		var refreshCaptcha = function() {
			// validar que solo se actualice al pulsar el boton
			// y no por la URL
			var dato_control = md5(new Date().getTime());
			dato_control_GLOBAL = dato_control;
			$("#captcha_code").attr('src','Ctrl/utilidades/ctrl-captcha.php?accion=actualizar-captcha&dato_control='+dato_control);
		}
		var verificarCaptcha = function () {
			var accion_ = "verificar-captcha";
			var captchaTxt_ = $("#captchaTxt").val();	
			//
 			captchaTxt_ = (captchaTxt_).replace(/[oO]/g, '0');
  			//
    		$.ajax({
    			async : false,
				url: 'Ctrl/utilidades/ctrl-captcha.php',
				type:'POST',
				data:{
						accion:accion_,
						dato_control:dato_control_GLOBAL,
						captcha:captchaTxt_,
					},
	            beforeSend: function () {
	            // cargando
	            },
	            success:  function (result) {
		            resultadosError.captcha=0;	    

	    			
		            if(result.controlError>0){

						$('#captchaTxt').popover('destroy');
						$('#captchaTxt').removeClass('imputWarnig');
						nucleo.alertaErrorPublic(result.mensaje);
						$('#captchaTxt').removeClass('imputSusess').addClass('imputWarnig');
							$('#captchaTxt').popover({ 
								content: result.mensaje, 
								placement: "left"
							}); 				
						$('#captchaTxt').popover('show');	            

		            	resultadosError.captcha=1;

		            }else{

						$('#captchaTxt').popover('destroy');
						$('#captchaTxt').removeClass('imputWarnig').addClass('imputSusess');

		            }


	            }
			}).fail(function (error) {
				console.log(JSON.stringify(error));
				alertas.dialogoErrorPublic(error.readyState,error.responseText);				
				console.log("Ocurrio un error");
			});
			return resultadosError.captcha;
		}		

	/************************************/
		var finalizarSuspension = function () {

				console.log('Finalizando suspension');
				// validar de new los campos
				if($('#ventana-modal-suspension #usuarioTxt').val()==""){
					//e.preventDefault();
					nucleo.alertaErrorPublic("Campo 'Usuario' vacio");
					return false;
				}
				if($('#ventana-modal-suspension #contrasenaTxt').val()==""){
					//e.preventDefault();
					nucleo.alertaErrorPublic("Campo 'Contraseña' vacio");
					return false;
				}
				if(nucleo.verificarCaptchaPublic()==1){
					//e.preventDefault();
					return false;
				}

				var accionNucleo_ ="continuarSesion";
				// -- datos --
					var usuario_ = $('#ventana-modal-suspension #usuarioTxt').val();
					var contrasena_ = $('#ventana-modal-suspension #contrasenaTxt').val();
				//
		        $.ajax({
					url: 'Ctrl/utilidades/ctrl-nucleo.php',
					type:'POST',
					data:{
							accionNucleo:accionNucleo_,
							usuario:usuario_,
							contrasena:contrasena_,
						},
		            beforeSend: function () {
						
		            },
		            success:  function (result) {
						console.log(JSON.stringify(result));
	    				$(result).each(function (index, datoItem) { 
			            	
			            	resultadosError.inicioSesion=datoItem.controlError;
	    					if(datoItem.controlError==2){
	    						resultadosError.inicioSesion=1;
								
								$('#ventana-modal-suspension #usuusuarioTxtBienvarioTxt').popover('destroy');
								$('#ventana-modal-suspension #contrasenaTxt').popover('destroy');
								$('#ventana-modal-suspension #usuarioTxtBienv').removeClass('imputWarnig');
								$('#ventana-modal-suspension #contrasenaTxt').removeClass('imputWarnig');

								nucleo.alertaErrorPublic("Contraseña Incorrecta");
								$('#ventana-modal-suspension #contrasenaTxt').removeClass('imputSusess').addClass('imputWarnig');
		  						$('#ventana-modal-suspension #contrasenaTxt').popover({ 
		  							content: "Contraseña Incorrecta", 
		  							placement: "left"
		  						}); 				
								$('#ventana-modal-suspension #contrasenaTxt').popover('show');

	    					}else if(datoItem.controlError==3){
	    						resultadosError.inicioSesion=1;
								
								$('#ventana-modal-suspension #usuarioTxtBienv').popover('destroy');
								$('#ventana-modal-suspension #contrasenaTxt').popover('destroy');
								$('#ventana-modal-suspension #usuarioTxtBienv').removeClass('imputWarnig');
								$('#ventana-modal-suspension #contrasenaTxt').removeClass('imputWarnig');

								nucleo.alertaErrorPublic("Cuenta desactivada");
								$('#ventana-modal-suspension #usuarioTxtBienv').removeClass('imputSusess').addClass('imputWarnig');
		  						$('#ventana-modal-suspension #usuarioTxtBienv').popover({ 
		  							content: "Cuenta desactivada", 
		  							placement: "left"
		  						}); 				
								$('#ventana-modal-suspension #usuarioTxtBienv').popover('show');							

	    					}else if(datoItem.controlError==0){
	    						$("#ventana-modal-suspension").html('<img src="Vist/img/cargando2.gif" class="img-cargando">');	            	
	   							resultadosError.inicioSesion=0;
						    	$("#ventana-modal-suspension").html('');
								ventanaModal.ocultarBasicItemPublic('ventana-modal-suspension');		
								suspensionON=0;
								nucleo.activarSuspensionPublic();	
	    					};

	    				});
	    				
		            }
				}).fail(function (error) {
					//$('#'+_campoVist_).popover('destroy');
					console.log(JSON.stringify(error));
					alertas.dialogoErrorPublic(error.readyState,error.responseText);				
					console.log("Ocurrio un error");
				});
		}
		var activarSuspension = function () {
			if (suspensionON!=1) {
				clearTimeout(controlSuspension);
				//var tiempoFrecuenciaMiliSegs = tiempoFrecuenciaSegs*1000;
				//60.000 milisegundo ===> 60 segundos
				var tiempoFrecuenciaMiliSegs = tiempoParaSuspensionSistema*60000;
				controlSuspension = setTimeout(function(){

					suspesionSistema();

				}, tiempoFrecuenciaMiliSegs);
			}
		}
		var actualizarContadorSuspension = function (tiempo_){
			console.log('Reiniciando tiempo de suspensión');
			if(tiempo_>0){
				tiempoParaSuspensionSistema = tiempo_;
				nucleo.activarSuspensionPublic();
			}else{
				nucleo.activarSuspensionPublic();
			}
		}
		var tiempoParaSuspensionSistemaBD = function () {
			var accion_ = "defaul";
			$.ajax({
				async : true,
				url: configuracion.urlsPublic().mantenimineto.api,
				type:'POST',			
				data:{
					accion:accion_,
				},
				success:  function (result) {
					//console.log(JSON.stringify(result));	
					console.log('actualizando suspension desde BD : '+result[0].frecuencia_suspension);
					tiempoParaSuspensionSistema = result[0].frecuencia_suspension;
					nucleo.activarSuspensionPublic();
				}
			}).fail(function (error) {
				//$('#'+_campoVist_).popover('destroy');
				console.log(JSON.stringify(error));
				alertas.dialogoErrorPublic(error.readyState,error.responseText);				
				console.log("Ocurrio un error");
			});
		}
		var suspesionSistema = function() {		

			console.log('Stop suspension - panel suspension activo');
			$.ajax({
				//async : false,
	            url:   'Vist/login.php',
	            type:  'post',	            
	            success:  function (response) {
	                $("#ventana-modal-suspension").html('');
	                $("#ventana-modal-suspension").html(response);
	                //activar menu dinamico
					//nucleo.asignarPermisosPublic();
					//nucleo.asignarDatosPublic();

			        console.log('INGRESA CONTRASEÑA PARA CONTINUAR LA SESION');

			        $("#usuarioTxtBienv").html('Bienvenido  '+sessionStorage.getItem("nombre-US")+'  '+ sessionStorage.getItem("apellido-US"));
	            	$("#usuarioTxt").val(sessionStorage.getItem("usuario-US"));
	            	//
					$('#btnIniciarSesion').attr('onclick', "nucleo.finalizarSuspensionPublic();");
					ventanaModal.mostrarBasicItemPublic('ventana-modal-suspension');
					clearTimeout(controlSuspension);
					suspensionON=1;
	            }
	        });
		}
		var stopSuspension = function () {
				console.log('Stop suspension');
				clearTimeout(controlSuspension);
		}
	/************************************/

		var guardarBitacora = function (operacion_) {
			var accionNucleo_ = "guardarBitacora";
			$.ajax({
				async : true,
				url: 'Ctrl/utilidades/ctrl-nucleo.php',
				type:'POST',			
				data:{
				accionNucleo:accionNucleo_,
				ip_cliente:sessionStorage.getItem("ip_cliente-US"),
				id_usuario:sessionStorage.getItem("idUsuario-US"),
				operacion:operacion_,
				},
				success:  function (result) {
					console.log(JSON.stringify(result));			
				}
			}).fail(function (error) {
				//$('#'+_campoVist_).popover('destroy');
				console.log(JSON.stringify(error));
				alertas.dialogoErrorPublic(error.readyState,error.responseText);				
				console.log("Ocurrio un error");
			});
		}
		/* 
			ORIGEN DE PARAMETROS RELEVANTES :
				# id_equipo_:
					1- $('#datoControlIdSolicitud').val() -> id_solicitud desde mantenimiento correctivo
					-> id_equipo desde mantenimiento preventivo
					-> id_equipo desde solicitud
				#
		*/
		var guardarPersonaEjecuta = function (observacion_,estado_,id_tipo_mant_,id_tarea_equipo_,id_solicitud_,detalles_,id_funcion_persona_) {
			var accionNucleo_ = "guardarPersonaEjecuta";
			$.ajax({
				async : true,
				url: 'Ctrl/utilidades/ctrl-nucleo.php',
				type:'POST',			
				data:{
					accionNucleo:accionNucleo_,
					estado:estado_,
					id_tipo_mant:id_tipo_mant_,
					id_tarea_equipo:id_tarea_equipo_,
					id_solicitud:id_solicitud_,
					detalles:detalles_,
					id_persona:sessionStorage.getItem("id_persona-US"),
					id_funcion_persona:id_funcion_persona_,
					observacion:observacion_,
				},
				success:  function (result) {
					console.log(JSON.stringify(result));			
				}
			}).fail(function (error) {
				//$('#'+_campoVist_).popover('destroy');
				console.log(JSON.stringify(error));
				alertas.dialogoErrorPublic(error.readyState,error.responseText);				
				console.log("Ocurrio un error");
			});
		}
		var guardarPersonaEjecutaTareaP = function (detalles_,id_funcion_persona_,id_mantenimiento_) {
			var accionNucleo_ = "guardarPersonaEjecutaTareaP";
			$.ajax({
				async : true,
				url: 'Ctrl/utilidades/ctrl-nucleo.php',
				type:'POST',			
				data:{
					accionNucleo:accionNucleo_,
					detalles:detalles_,
					id_persona:sessionStorage.getItem("id_persona-US"),
					id_funcion_persona:id_funcion_persona_,
					id_mantenimiento:id_mantenimiento_,
				},
				success:  function (result) {
					console.log(JSON.stringify(result));			
				}
			}).fail(function (error) {
				//$('#'+_campoVist_).popover('destroy');
				console.log(JSON.stringify(error));
				alertas.dialogoErrorPublic(error.readyState,error.responseText);				
				console.log("Ocurrio un error");
			});
		}		
	/****************************Metodos de componentes***********************/	
		
		var listaColapse = function (idItem_,event_) {
				if ($('#'+idItem_+' #itemClpseLista').hasClass('itemClose')==true) {
					// caso 1 -> Si se presiono uno distinto al que esta abierto 

					$('.itemOpen').removeClass('itemOpen').addClass('itemClose');					
					$('#'+idItem_+' #itemClpseLista').removeClass('itemClose').addClass('itemOpen');

				}else if($('#'+idItem_+' #itemClpseLista').hasClass('itemOpen')==true) {
					// caso 2 -> Si se presiona sobre el mismo que esta abierto

					$('.itemOpen').removeClass('itemOpen').addClass('itemClose');					
					$('#'+idItem_+' #itemClpseLista').removeClass('itemOpen').addClass('itemClose');
	
				};				
		}

	/*************************************************************************/
	// Para reportes

	var getScreenshotOfElement = function (element, posX, posY, width, height, callback) {
	    html2canvas(element, {
	        onrendered: function (canvas) {
	            var context = canvas.getContext('2d');
	            var imageData = context.getImageData(posX, posY, width, height).data;
	            var outputCanvas = document.createElement('canvas');
	            var outputContext = outputCanvas.getContext('2d');
	            outputCanvas.width = width;
	            outputCanvas.height = height;

	            var idata = outputContext.createImageData(width, height);
	            idata.data.set(imageData);
	            outputContext.putImageData(idata, 0, 0);
	            callback(outputCanvas.toDataURL().replace("data:image/png;base64,", ""));
	        },
	        width: width,
	        height: height,
	        useCORS: true,
	        taintTest: false,
	        allowTaint: false
	    });
	}


	/****************Inicializacion e Intancias de metodos *******************/
		return{
			Iniciar : function() {
				console.log("Iniciando carga de nucleo");
					//
					seguridad.Iniciar();
					//
					menuContextual.Iniciar();
					alertas.Iniciar();
					ipCLiente.Iniciar();
					nucleo.verificarSesionPublic();
					configuracion.Iniciar();					
				console.log("Finalizando carga de nucleo");
			},			
			activarSuspensionPublic : activarSuspension,
			finalizarSuspensionPublic : finalizarSuspension,
			actualizarContadorSuspensionPublic : actualizarContadorSuspension,
			tiempoParaSuspensionSistemaBDPublic :tiempoParaSuspensionSistemaBD,
			stopSuspensionPublic : stopSuspension,
			alertaErrorPublic : alertaError,
			alertaExitoPublic : alertaExito,
			alertaDialogoErrorPublic : alertaDialogoError,
			validadorPublic : validador,
			fechaMaxPublic : fechaMax,
			verificarDatosPublic : verificarDatos,
			verificarDatosInputPublic : verificarDatosInput,
			verificarDatosDetectorPublic : verificarDatosDetector,
			verificarExistenciaPublic : verificarExistencia,
			verificarExistenciaSelectPublic : verificarExistenciaSelect,			
			verificarFormatoImagenePublic : verificarFormatoImagene,
			verificarSesionPublic : verificarSesion,
			camposDatosPublic : camposDatos,
			convetirMinMayusPublic : convetirMinMayus,
			reiniciarVariablesGNPublic : reiniciarVariablesGNucleo,
			reiniciarFormularioPublic : reiniciarFormulario,
			cargarListaDespegablePublic : cargarListaDespegable,
			cargarListaDespegableUtf8EncodePublic : cargarListaDespegableUtf8Encode,
			cargarListaDespegableListasPublic : cargarListaDespegableListas,
			cargarListaDespegableListasAnidadaPublic : cargarListaDespegableListasAnidada,
			cargarPopOverPublic : cargarPopOver,
			iniciarSesionPublic : iniciarSesion,
			iniciarSesionOtraCuentaPublic : iniciarSesionOtraCuenta,
			activarEnvioInicSesionPublic : activarEnvioInicSesion,
			activarEnvioContSesionPublic : activarEnvioContSesion,
			continuarSesionPublic : continuarSesion,
			datosSesionPublic : datosSesion,
			asignarPermisosPublic : asignarPermisos,
			asignarSubPermisosPublic : asignarSubPermisos,
			asignarPermisosBotonesPublic : asignarPermisosBotones,
			asignarDatosPublic : asignarDatos,
			cerrarSesionPublic  : cerrarSesion,
			refreshCaptchaPublic : refreshCaptcha,
			verificarCaptchaPublic : verificarCaptcha,
			// -> Seguridad auditable
			guardarBitacoraPublic : guardarBitacora,
			guardarPersonaEjecutaPublic : guardarPersonaEjecuta,
			guardarPersonaEjecutaTareaPPublic : guardarPersonaEjecutaTareaP,
			// -> Componentes
			listaColapsePublic : listaColapse,
			// -> controlBtnAdminInProcess
			controlBtnAdminInProcessPublic : controlBtnAdminInProcess,
			controlAccessBtnAdminPublic : controlAccessBtnAdmin,
			// -> Para Reportes
			getScreenshotOfElementPublic : getScreenshotOfElement,

		}
	}();

/*
	$('body').on('keypress', function (e) {
		console.log(e.key);
	});
*/