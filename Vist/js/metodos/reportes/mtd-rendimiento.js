	var graficoMtdRendimiento = "";
	var mtdRendimiento = function () {

		/***************************Variables globales*************************/

		/**********************************************************************/


		/* 	La funcionalidad cargarGrafico
	 		# Uso : Se usa para extraer todos los datos relacionados con el filtro
			# Parametros :
			# Notas :
		*/
		var cargarGrafico = function() {

			// Iniciando variables
			var accion_ = "FiltrarLista";

			var filtro_ = $('#buscardorTxt').val();
			var buscardordesde_ = $('#buscardorDesde').val();
			var buscardorhasta_ = $('#buscardorHasta').val();	

			if (buscardordesde_!="" && buscardorhasta_=="") {
				buscardordesde_="";
			}		
			if (buscardordesde_=="" && buscardorhasta_!="") {
				buscardorhasta_="";
			}					
			//
	        $.ajax({
	        	async:false,
				url: 'Ctrl/reportes/ctrl-rendimiento.php',
				type:'GET',	
				data:{	
						cfg:accion_,
						filtro:filtro_,
						buscardordesde:buscardordesde_,
						buscardorhasta:buscardorhasta_,
					},
	            beforeSend: function () {

			       // $("#graficoRendimiento").html('');				
					//var tr = $('<div colspan="5" style="text-align: center;"><img src="Vist/img/cargando2.gif" class="img-cargando"></div>');
					//$('#graficoRendimiento').append(tr);

	            },
	            success:  function (data) {
		    
					console.log(JSON.stringify(data));
	                if (data.controlError==0) {


						$(data).each(function (index, dato) {
							
							graficoMtdRendimiento.setData(dato.resultados);

						});
	
					}else{
							graficoMtdRendimiento.setData([
								{"FECHA_FINALIZACION": new Date().getTime(),"TARDANZA_PREVENTIVA":"0","TARDANZA_CORRECTIVA":"0"},
							]);

						/*
							tr = $('<div style="text-align: center;">');
							tr.append('<b style="text-align: center;">No hay solicitud de mantenimiento realizada o visible para usted</b>');
							tr.append("</div>");
							$('#graficoRendimiento').append(tr);	
							*/						
					}
	            },
			    //error:  function(jq,status,message) {
		    	error:  function(error) {
						console.log(JSON.stringify(error));
						alertas.dialogoErrorPublic(error.readyState,error.responseText);	
			        //alert('A jQuery error has occurred. Status: ' + status + ' - Message: ' + message);
			    }	            
			});
	        //
			//e.preventDefault();
			return false;
		}

		var img_grafico_ = "";
		var img_grafico_id_temp_ = "";
		var generarProcesoFiltrar = function() {
			var ancho_div = $("div#graficoRendimiento").width();
			var alto_div = $("div#graficoRendimiento").height();
			nucleo.getScreenshotOfElementPublic($("div#graficoRendimiento").get(0), 0, 0, ancho_div, alto_div, function(data) {
			    // in the data variable there is the base64 image
			    // exmaple for displaying the image in an <img>
			    img_grafico_ = "data:image/png;base64,"+data;
			    img_grafico_id_temp_ = md5(new Date().getTime());
			    //$("img#captured").attr("src", "data:image/png;base64,"+data);
				//----------------------------------------------------------
					//Filtros
					var buscardorTxt_   = $('#buscardorTxt').val();
					var buscardorDesde_ = $('#buscardorDesde').val();
					var buscardorHasta_ = $('#buscardorHasta').val();
					// Otros
					var _TITULO_ = "RENDIMIENTO DE SERVICIOS";
					//
					var _configuracion_ = "CFG-RENDIMIENTO-SERVICIOS";
					var usuario_ = sessionStorage.getItem("nombre-US")+' '+sessionStorage.getItem("apellido-US");        	
					var datos = {
								accionNucleo:"encriptarDatosRPTyGraficos",
								u 			: 	usuario_,
								cfg 		: 	_configuracion_,
								tt 			:	_TITULO_,
								img_grafico_id_temp : img_grafico_id_temp_,
								img_grafico :   img_grafico_,
								cant_datosbd: 	1,		
								tabla 		: 	"",
								cant_datos	: 	3,
								dato_1		:	buscardorTxt_,
								campo_1 	: 	"",	
								dato_2		:	buscardorDesde_,
								campo_2 	: 	"",
								dato_3		:	buscardorHasta_,
								campo_3 	: 	"",	
							};					
					var datosEncrypt = reportes.encriptarDatosRPTPublic(datos);
					var win = window.open(configuracion.urlsPublic().modReporte.tabs.rendimientoServicio.api+'?cfg='+_configuracion_+'&datos='+datosEncrypt);
					win.focus();

				//-----------------------------------------------------------
			});

		}
		return{
			Iniciar: function () {

			},
			cargarGraficoPublic : cargarGrafico,		
			generarProcesoFiltrarPublic : generarProcesoFiltrar,
		}
	}();