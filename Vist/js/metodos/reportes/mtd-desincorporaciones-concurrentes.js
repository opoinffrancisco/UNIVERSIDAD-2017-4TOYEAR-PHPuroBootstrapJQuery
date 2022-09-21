	var opcionRptCfg = "generico";
	var GraficomtdDesincorporacionesConcurrentes = "";
	var mtdDesincorporacionesConcurrentes = function () {

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

			var filtro_funcion_ 	= $('#funcionListD').val();
			var filtro_departamento_ 	= $('#departamentoListD').val();
			var buscardordesde_ = $('#buscardorDesde').val();
			var buscardorhasta_ = $('#buscardorHasta').val();

			if (filtro_funcion_==0) {
				filtro_funcion_="";
			};
			if (filtro_departamento_==0) {
				filtro_departamento_="";
			};
			if (buscardordesde_!="" && buscardorhasta_=="") {
				buscardordesde_="";
			}		
			if (buscardordesde_=="" && buscardorhasta_!="") {
				buscardorhasta_="";
			}

			//
	        $.ajax({
	        	async:false,
				url: configuracion.urlsPublic().modReporte.tabs.desincorporacionesConcurrentes.api,
				type:'GET',	
				data:{
						cfg:accion_,
						filtro_funcion:filtro_funcion_,
						filtro_departamento:filtro_departamento_,
						buscardordesde:buscardordesde_,
						buscardorhasta:buscardorhasta_,
						opcionrpt:opcionRptCfg,
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
							
							GraficomtdDesincorporacionesConcurrentes.setData(dato.resultados);

						});
	
					}else{
							GraficomtdDesincorporacionesConcurrentes.setData([
							    {value: 0, label: 'SIN RESULTADOS', formatted: ' ' }
							]);

						/*
							[
							    {value: 70, label: 'foo', formatted: 'at least 70%' },
							    {value: 15, label: 'bar', formatted: 'approx. 15%' },
							    {value: 10, label: 'baz', formatted: 'approx. 10%' },
							    {value: 5, label: 'A really really long label', formatted: 'at most 5%' }
							]
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
					var filtro_funcion_ 	= $('#funcionListD').val();
					var filtro_departamento_ 	= $('#departamentoListD').val();
					var buscardordesde_ = $('#buscardorDesde').val();
					var buscardorhasta_ = $('#buscardorHasta').val();

					if (filtro_funcion_==0) {
						filtro_funcion_="";
					};
					if (filtro_departamento_==0) {
						filtro_departamento_="";
					};

					// Otros
					var _TITULO_ = "DESINCORPORACIONES Y CAMBIOS CONCURRENTES";
					//
					var _configuracion_ = "CFG-DESINCORPORACIONES-CONCURRENTES";
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
								cant_datos	: 	5,
								dato_1		:	filtro_funcion_,
								campo_1 	: 	"",	
								dato_2		:	filtro_departamento_,
								campo_2 	: 	"",
								dato_3		:	buscardordesde_,
								campo_3 	: 	"",
								dato_4		:	buscardorhasta_,
								campo_4 	: 	"",									
								dato_5		:	opcionRptCfg,
								campo_5 	: 	"",
							};					
					var datosEncrypt = reportes.encriptarDatosRPTPublic(datos);
					var win = window.open(configuracion.urlsPublic().modReporte.tabs.desincorporacionesConcurrentes.api+'?cfg='+_configuracion_+'&datos='+datosEncrypt);
					win.focus();

				//-----------------------------------------------------------
			});
		}

		var iniciarPanelTabEquipos = function () {

				mtdAsignar.filtrarSelectPublic();
			  	nucleo.cargarListaDespegableListasPublic('departamentoListD','cfg_departamento','un departamento');

				$('#funcionListD').popover({
				    html: true, 
					placement: "right",
					content: function() {
				          return $('#procesandoDatosInput').html();
				        }
				})
				$('#departamentoListD').popover({
				    html: true, 
					placement: "right",
					content: function() {
				          return $('#procesandoDatosInput').html();
				        }
				});	

	 
		     	$('#funcionListD').popover('show');
			  	$('#departamentoListD').popover('show');

			    setTimeout(function(){ 

	            	$('#funcionListD').popover('destroy');
				  	$('#departamentoListD').popover('destroy');

				  	$('#funcionListD').selectpicker('refresh');
				  	$('#departamentoListD').selectpicker('refresh');

			        $('#btnSelectElegido0').attr('style','width:100%;');
			        $('#btnSelectElegido1').attr('style','width:100%;');

			    }, 600);


				$(document).ready(function() {

				  	$('#funcionListD').selectpicker('refresh');
				  	$('#departamentoListD').selectpicker('refresh');

				    $('#listas .bootstrap-select ').each(function (index, datoItem) {

				        $(datoItem).attr('id','btnSelectElegido'+index);


				        $('#btnSelectElegido'+index+' button').on('click',function () {
				            
				            if($("#btnSelectElegido"+index+" .bs-searchbox input").length > 0 ) { 

				                    $('#btnSelectElegido'+index+' .bs-searchbox input').on('keyup',function () {

				                            if($("#btnSelectElegido"+index+" .no-results").length > 0 ) { 
				                                $("#btnSelectElegido"+index+" .no-results").html('');
				                                var filtro = $('#btnSelectElegido'+index+' .bs-searchbox input').val();
				                                $("#btnSelectElegido"+index+" .no-results").html('No hay resultados para " '+filtro+' " ');
				                            }


				                    });

				            }

				        });

				    });

				});
		}
		/******************************************/
		var opcionesRpt = function () {
				if ($("#rptGenerico").is(':checked')) {	
					$('#DivPrevisualizacionTxt').css('display', 'none');
					opcionRptCfg="generico";
				}
				if ($("#rptDetallado").is(':checked')) {
					$('#previsualizacionTxt').val('');
					$('#DivPrevisualizacionTxt').css('display', 'block');
					opcionRptCfg="detallado";
				}
				mtdDesincorporacionesConcurrentes.cargarGraficoPublic();
		}


		return{
			Iniciar: function () {
			},
			iniciarPanelTabEquiposPublic : iniciarPanelTabEquipos,
			cargarGraficoPublic : cargarGrafico,		
			generarProcesoFiltrarPublic : generarProcesoFiltrar,		
			opcionesRptPublic : opcionesRpt,
		}
	}();