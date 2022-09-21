	var GraficoMtdAreasConcurrentesTareasCorrectivas = "";
	var mtdAreasConcurrentesTareasCorrectivas = function () {

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

			var filtro_marca_ = $('#marcaListD').val();
			var filtro_modelo_ = $('#modeloListD').val();
			var filtro_tipo_ = $('#tipoListD').val();
			var buscardordesde_ = $('#buscardorDesde').val();
			var buscardorhasta_ = $('#buscardorHasta').val();

			if (filtro_marca_==0) {
				filtro_marca_="";
			};
			if (filtro_modelo_==0) {
				filtro_modelo_="";
			};
			if (filtro_tipo_==0) {
				filtro_tipo_="";
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
				url: 'Ctrl/reportes/ctrl-areas-concurrentes-tareas-correctivas.php',
				type:'GET',	
				data:{
						cfg:accion_,
						filtro_marca:filtro_marca_,
						filtro_modelo:filtro_modelo_,
						filtro_tipo:filtro_tipo_,
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
							
							GraficoMtdAreasConcurrentesTareasCorrectivas.setData(dato.resultados);

						});
	
					}else{
							GraficoMtdAreasConcurrentesTareasCorrectivas.setData([
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
					var marcaListD_   	= $('#marcaListD').val();
					var modeloListD_ 	= $('#modeloListD').val();
					var tipoListD_ 		= $('#tipoListD').val();
					var buscardorDesde_ = $('#buscardorDesde').val();
					var buscardorHasta_ = $('#buscardorHasta').val();

					if (marcaListD_==0) {
						marcaListD_="";
					};
					if (modeloListD_==0) {
						modeloListD_="";
					}
					if (tipoListD_==0) {
						tipoListD_="";
					};
					
					// Otros
					var _TITULO_ = "AREAS CONCURRENTES DE TAREAS CORRECTIVAS";
					//
					var _configuracion_ = "CFG-TAREAS-CONCURRENTES";
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
								cant_datos	: 	6,
								dato_1		:	marcaListD_,
								campo_1 	: 	"",	
								dato_2		:	modeloListD_,
								campo_2 	: 	"",
								dato_3		:	tipoListD_,
								campo_3 	: 	"",	
								dato_4		:	buscardorDesde_,
								campo_4 	: 	"",
								dato_5		:	buscardorHasta_,
								campo_5 	: 	"",									
								dato_6		:	opcionRptCfg,
								campo_6 	: 	"",
							};					
					var datosEncrypt = reportes.encriptarDatosRPTPublic(datos);
					var win = window.open(configuracion.urlsPublic().modReporte.tabs.areasConcurrentesTareasCorrectivas.api+'?cfg='+_configuracion_+'&datos='+datosEncrypt);
					win.focus();

				//-----------------------------------------------------------
			});
		}

		var cargarListaDespegable = function(_idCampo_,_tabla_,_nombreCampo_) {

			var accionNucleo_ ="cargarListaDespegable";
	        $.ajax({
				url: 'Ctrl/reportes/ctrl-tareas-concurrentes.php',
				type:'GET',
				data:{
						cfg:accionNucleo_,
						tabla:_tabla_,
					},
	            beforeSend: function () {
	            // cargando
	            },
	            success:  function (result) {
	            	console.log(JSON.stringify(result));
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


		var iniciarPanelTabEquipos = function () {

				mtdAsignar.filtrarSelectPublic();

			  	nucleo.cargarListaDespegableListasPublic('marcaListD','cfg_c_fisc_mod_marca','una marca');
			  	mtdAreasConcurrentesTareasCorrectivas.cargarListaDespegablePublic('tipoListD','cfg_c_fisc_tipo','un tipo');

				$('#marcaListD').popover({
				    html: true, 
					placement: "right",
					content: function() {
				          return $('#procesandoDatosInput').html();
				        }
				})
				$('#modeloListD').popover({
				    html: true, 
					placement: "right",
					content: function() {
				          return $('#procesandoDatosInput').html();
				        }
				});	
				$('#tipoListD').popover({
				    html: true, 
					placement: "right",
					content: function() {
				          return $('#procesandoDatosInput').html();
				        }
				});	
	 
		     	$('#marcaListD').popover('show');
			  	$('#modeloListD').popover('show');
		     	$('#tipoListD').popover('show');

			    setTimeout(function(){ 

	            	$('#marcaListD').popover('destroy');
				  	$('#modeloListD').popover('destroy');
	            	$('#tipoListD').popover('destroy');

				  	$('#marcaListD').selectpicker('refresh');
				  	$('#modeloListD').selectpicker('refresh');
				  	$('#tipoListD').selectpicker('refresh');

			        $('#btnSelectElegido0').attr('style','width:100%;');
			        $('#btnSelectElegido1').attr('style','width:100%;');
			        $('#btnSelectElegido2').attr('style','width:100%;');

			    }, 600);


				$(document).ready(function() {

				  	$('#marcaListD').selectpicker('refresh');
				  	$('#modeloListD').selectpicker('refresh');
				  	$('#tipoListD').selectpicker('refresh');



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
		var opcionRptCfg = "generico";
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
				mtdAreasConcurrentesTareasCorrectivas.cargarGraficoPublic();
		}


		return{
			Iniciar: function () {
				opcionRptCfg="generico";
			},
			cargarGraficoPublic : cargarGrafico,		
			generarProcesoFiltrarPublic : generarProcesoFiltrar,
			cargarListaDespegablePublic : cargarListaDespegable,
			iniciarPanelTabEquiposPublic : iniciarPanelTabEquipos,
			opcionesRptPublic : opcionesRpt,
		}
	}();