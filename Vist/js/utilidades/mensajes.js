var alertas = function (){
	

	// aun no es uso
	var Error = function(_contenido_){

		var alerta = alertify.notify(
			_contenido_,
			'error',
			2,
			function(){  
				//console.log('fin de notificaicon'); 
			});

	};
	// aun no es uso
	var Exito = function(_contenido_) {
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

	var dialogoError = function (_readyState_,_responseText_) {

		var titulo_    = "";
		var contenido_ = "";
		var detalles_  = _responseText_;

		switch(_readyState_) {
			case 1:
				titulo_    = "Error 1";
				contenido_ = "Porfavor, comuniquese con su administrador.";
			break;
			case 2: 
				titulo_    = "Error 2";
				contenido_ = "Porfavor, comuniquese con su administrador.";
			break;
			case 3: 
				titulo_    = "Error 3";
				contenido_ = "Porfavor, comuniquese con su administrador.";
			break;					
			case 4: 
				titulo_    = "Error de conexión";
				contenido_ = "SIGMANSTEC, No consiguio acceder a la base de datos. "+
				 			 "Porfavor, comuniquese con su administrador.";
				if($('#ventana-modal').lenght>1){
					ventanaModal.ocultarPulico('ventana-modal');
				}
			
			break;
			case 5:
				titulo_    = "Error 5";
				contenido_ = "Porfavor, comuniquese con su administrador.";
			break;			
			default:
				titulo_    = "Error en sistema";
				contenido_ = "Porfavor, comuniquese con su administrador.";			
			break;
		}

		var alerta = alertify.alert(
			titulo_,
			contenido_,
			function(){
		    	//alertify.message('OK');
		});
	}



	return{
		Iniciar:function () {
					
			console.log(" -- Finalizando carga de mensajes");
		},
		ErrorPublic : Error,
		ExitoPublic : Exito,
		dialogoErrorPublic : dialogoError,
	}
}();