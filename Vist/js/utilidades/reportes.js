	var reportes = function() {

		/***************************/
		//Reportes de configuraciones
		var generar = function(_configuracion_,_arrayDatosCfg_,_arrayDatos_) {

			var tabla_ = "";
			var modulo_ = "";
			var usuario_ = sessionStorage.getItem("nombre-US")+' '+sessionStorage.getItem("apellido-US");
			var atributos_ = [];	
			var datos_ = [];	
			//
			var datos = "";	
			var numColl=0;

    		//Nombre y apellido, persona de usuario
        	datos=datos+'&u='+usuario_;		        

	        $(_arrayDatosCfg_).each(function (index, dato) {		        	

	        	if (index==0){
	        		// 0 = nombre tabla
		        	datos=datos+'&t='+dato;
	        	}else if(index==1){
	        		// 1 = nombre modulo
		        	datos=datos+'&m='+dato;
	        	}else{
	        		numColl=numColl+1;
	        		// datos de columnas, si se requieren
		        	//datos=datos+'&'+dato+'='+dato;       	 
		        	datos=datos+'&coll'+numColl+'='+dato;        		
	        	};
	        });

			console.log('MOTRAR DATOS : '+datos );

			var win = window.open('Ctrl/utilidades/ctrl-reporte.php?cfg='+_configuracion_+datos );
			win.focus();

		}
		var generar2 = function(_datosBD_,_composFiltro_,_configuracion_,_TITULO_) {

			var usuario_ = sessionStorage.getItem("nombre-US")+' '+sessionStorage.getItem("apellido-US");
        	
	       	var dato_1_ = $('.dato_1').val();
	       	var dato_2_ = "";

	       	if ($('.dato_2').length>0) {

	       		dato_2_ = $('.dato_2').val();

	       	}

			switch(_composFiltro_.length){
				case 1:
					var datos = {
									accionNucleo:"encriptarDatosRPT",
									u 			: 	usuario_,
									cfg 		: 	_configuracion_,
									tt 			:	_TITULO_,
									tabla 		: 	_datosBD_[0],
									cant_datos	: 	1,
									dato_1		:	dato_1_,
									campo_1 	: 	_composFiltro_[0],
								};		 
				break;
				case 2:
					//
					if(_datosBD_.length==1){
						
							var datos = {
										accionNucleo:"encriptarDatosRPT",
										u 			: 	usuario_,
										cfg 		: 	_configuracion_,
										tt 			:	_TITULO_,
										cant_datosbd: 	_datosBD_.length,										
										tabla 		: 	_datosBD_[0],
										cant_datos	: 	2,
										dato_1		:	dato_1_,
										dato_2		:	dato_2_,
										campo_1 	: 	_composFiltro_[0],
										campo_2 	: 	_composFiltro_[1],
									};
					}else{

							var datos = {
										accionNucleo:"encriptarDatosRPT",
										u 			: 	usuario_,
										cfg 		: 	_configuracion_,
										tt 			:	_TITULO_,
										cant_datosbd: 	_datosBD_.length,
										tabla 		: 	_datosBD_[0],
										trel 		: 	_datosBD_[1],
										rel1 		: 	_datosBD_[2],
										cant_datos	: 	2,
										dato_1		:	dato_1_,
										dato_2		:	dato_2_,
										campo_1 	: 	_composFiltro_[0],
										campo_2 	: 	_composFiltro_[1],
									};
						
						
					}
					//
				break;
				case '3':
				break;
				case '4':
				break;					
			}
			var datosEncrypt = encriptarDatosRPT(datos);

			var win = window.open('Ctrl/utilidades/ctrl-reporte.php?cfg='+_configuracion_+'&datos='+datosEncrypt);
			win.focus();
		}		
		var generar1Rel = function(_configuracion_,_arrayDatosCfg_,_arrayDatos_) {

	
			var tabla_ = "";
			var modulo_ = "";
			var usuario_ = sessionStorage.getItem("nombre-US")+' '+sessionStorage.getItem("apellido-US");
			var atributos_ = [];	
			var datos_ = [];	

			var datos = "";	
			var numColl=0;

    		//Nombre y apellido, persona de usuario
        	datos=datos+'&u='+usuario_;		        

	        $(_arrayDatosCfg_).each(function (index, dato) {		        	

	        	if (index==0){
	        		// 0 = nombre tabla
		        	datos=datos+'&t='+dato;
	        	}else if(index==1){
	        		// 1 = nombre modulo
		        	datos=datos+'&trel='+dato;
	        	}else if(index==2){
	        		// 1 = nombre modulo
		        	datos=datos+'&rel1='+dato;		        
	        	}else if(index==3){
	        		// 1 = nombre modulo
		        	datos=datos+'&m='+dato;
	
	        	}else{
	        		numColl=numColl+1;
	        		// datos de columnas, si se requieren
		        	//datos=datos+'&'+dato+'='+dato;       	 
		        	datos=datos+'&coll'+numColl+'='+dato;        		
	        	};
	        });

			console.log('MOTRAR DATOS : '+datos );

			var win = window.open('Ctrl/utilidades/ctrl-reporte.php?cfg='+_configuracion_+datos );
			win.focus();
		}
		var generarFiltrar = function(_configuracion_,_TITULO_) {

			var usuario_ = sessionStorage.getItem("nombre-US")+' '+sessionStorage.getItem("apellido-US");
        	
	       	var filtro_1_ = $('.filtro_1').val();
        	var filtro_2_ = $('#btipoListD').val();
        	if (filtro_2_==0) {
        		filtro_2_="";
        	}

			var datos = {
							accionNucleo:"encriptarDatosRPT",
							u 			: 	usuario_,
							cfg 		: 	_configuracion_,
							tt 			:	_TITULO_,
							cant_datosbd: 	1,		
							tabla 		: 	"",								
							cant_datos	: 	2,
							dato_1		:	filtro_1_,
							dato_2		:   filtro_2_,
							campo_1 	: 	"",
							campo_2 	: 	"",							
						};		        
						
			var datosEncrypt = encriptarDatosRPT(datos);

			var win = window.open('Ctrl/utilidades/ctrl-reporte.php?cfg='+_configuracion_+'&datos='+datosEncrypt);
			win.focus();
		}


		/*
			Para encriptar datos desde el servidor 
		*/
		var encriptarDatosRPT = function (datos_) {
				var dat_Gcontrol ="";
				$.ajax({
					async : false,
					url: 'Ctrl/utilidades/ctrl-nucleo.php',
					type:'POST',			
					data:datos_,
					success:  function (result) {
						dat_Gcontrol = result[0].datos;
					}
				}).fail(function (error) {
					console.log(JSON.stringify(error));
					alertas.dialogoErrorPublic(error.readyState,error.responseText);				
				});			
				return dat_Gcontrol; 
		}

	/****************Inicializacion e Intancias de metodos *******************/
		return{
			Iniciar : function() {
				console.log(" -- Finalizando carga de reportes");
			},			
			generarPublic : generar,
			generar2Public : generar2,
			generar1RelPublic : generar1Rel,
			generarFiltrarPublic : generarFiltrar,
			encriptarDatosRPTPublic : encriptarDatosRPT,
		}
	}();