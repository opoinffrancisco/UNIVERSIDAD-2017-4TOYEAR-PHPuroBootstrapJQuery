	

		<!-- Panel de Ventana modal-->
		<div id="vtnCaracteristicasComponentes" class="panel panel-primary ventana-modal-panel-mediano ">
			<!-- Cabecera -->
			<div class="panel-heading">
				<h3 class="panel-title">
					Seleccionar características para filtrar componente a agregar
					<a href="javascript:;" id="ventana-modal-panel-cerrar" class="ventana-modal-panel-cerrar" style="" 
					onclick="ventanaModal.ocultarPulico('ventana-modal-capa2')">x</a>
				</h3> 
			</div> 
			<!-- Contenido/Formulario -->
			<div class="panel-body"> 
				<form id="form" method="POST" >
						<input type="text" id="datoControl" value="" style="display:none;"></input>
						<input type="text" id="datoControlId" value="" style="display:none;"></input>
						<div id="listas">													
							<div class="row">
							  <div class="col-md-5 col-md-offset-1">
   							      <label for="recurso">Marca:</label>							  
							  	  	<div id="divMarcaListD" class="form-group">
								    	<select  id="marcaListD" class="select campo-control selectpicker lista-control " data-select="1" name="Marca" data-show-subtext="true" data-live-search="true"  >
											<option data-subtext="" value="0">No hay datos</option>								   		
								   		</select>
								  	</div>				  	
							  </div>
							  <div class="col-md-5 col-md-offset-0">
   							      <label for="recurso">Modelo:</label>							  
							  	  	<div id="divModeloListD" class="form-group">
								    	<select  id="modeloListD" class="select campo-control selectpicker lista-control" data-select="1" name="Modelo" data-show-subtext="true" data-live-search="true"  >
											<option data-subtext="" value="0">No hay datos</option>								   		
								   		</select>
								  	</div>						  	
							  </div>							  
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="1">Serial</label>
									    <input type="text" class="form-control" id="exampleInputName1" placeholder="Ingresar serial">
									</div>																					
								</div>				
								<div class="col-md-6">
									<div class="form-group">
										<label for="1">Serial bien nacional:</label>
									    <input type="text" class="form-control" id="exampleInputName1" placeholder="Ingresar serial bien nacional">
									</div>																						
								</div>																					
							</div>		
								<div class="row">

								    <div class="col-md-12"  style="background-color:#fff">
										<div class="catalogo">
											<table id="catalogo" class="table table-bordered table-hover ">
											 <thead>
											  <tr  class="row">
											   <th  class="col-md-2">Modelo </th>
											   <th  class="col-md-4">Tipo</th>
											   <th  class="col-md-2">Interfaz</th> 
											   <th  class="col-md-1">Voltaje</th> 
											   <th  class="col-md-1">Capacidad</th> 
											   <th  class="col-md-2">Opcion</th> 
											  </tr> 
											 </thead> 
											 <tbody id="catalogoDatos" class="catalogo-datos"> 
							 					<!-- Resultados de Datos -->
												<tr class="row ">
													<td style=" padding: 0px; text-align: center;vertical-align:middle;" class="col-md-2">
														EEE-45-F4
													</td>
													<td style=" padding: 0px; text-align: center;vertical-align:middle;" class="col-md-4">														
														DISCO DURO
													</td>
													<td style=" padding: 5px; text-align: center;vertical-align:middle;" class="col-md-2">
														ATA, SATA, IDE
													</td>
													<td style=" padding: 0px; text-align: center;vertical-align:middle;" class="col-md-2">														
														150 V
													</td>
													<td style=" padding: 5px; text-align: center;vertical-align:middle;" class="col-md-2">
														2 TB
													</td>
													<td style=" padding: 5px; text-align: center;vertical-align:middle;" class="col-md-2">
														<div class="btn-group" role="group" style="width: 100%;">
															<button type="button" class="btn btn-default" id="btnDetalles" onclick="" style="width: 100%;">Agregar</button>
														</div>
													</td>																										
												</tr>																																						 					
							 					<!-- Img de Carga de Datos -->
											  </tbody> 
											</table>
										</div>
									</div>

								</div>																	
						</div>					
				</form>
				<?php 

					include '../../../../../secciones/dialogo/procesandoDatos.php';

				?>
			</div>				
		</div>



<!-- carga de complementos catalogo/ventana modal relacionados // Estos complementos deben de ser los ultimos en cargar-->
<script type="text/javascript">
		mtdCaracteristicasComponentes.Iniciar();
//		mtdCaracteristicasComponentes.cargarCatalogoPublic(1);	

				//refrescar item
			  	nucleo.cargarListaDespegableListasPublic('marcaListD','cfg_c_fisc_mod_marca','marca');
			  	nucleo.cargarListaDespegableListasPublic('tipoListD','cfg_c_fisc_tipo','tipo');
			  	nucleo.cargarListaDespegableListasPublic('interfazListD','cfg_c_fisc_interfaz','interfaz');
			  	mtdCaracteristicasComponentes.cargarListaDespegableListasUNPublic('umvoltageListD','cfg_c_fisc_umvoltage','UM');
			  	mtdCaracteristicasComponentes.cargarListaDespegableListasUNPublic('umcapacidadListD','cfg_c_fisc_umcapacidad','UM');

				$('#marcaListD').popover({
				    html: true, 
					placement: "right",
					content: function() {
				          return $('#procesandoDatosInput').html();
				        }
				})
				$('#tipoListD').popover({
				    html: true, 
					placement: "right",
					content: function() {
				          return $('#procesandoDatosInput').html();
				        }
				});	
				$('#interfazListD').popover({
				    html: true, 
					placement: "right",
					content: function() {
				          return $('#procesandoDatosInput').html();
				        }
				});											
				$('#umvoltageListD').popover({
				    html: true, 
					placement: "right",
					content: function() {
				          return $('#procesandoDatosInput').html();
				        }
				});
				$('#umcapacidadListD').popover({
				    html: true, 
					placement: "right",
					content: function() {
				          return $('#procesandoDatosInput').html();
				        }
				});				
            	$('#marcaListD').popover('show');
			  	$('#modeloListD').popover('show');
			  	$('#tipoListD').popover('show');
			  	$('#interfazListD').popover('show');
			  	$('#umvoltageListD').popover('show');
			  	$('#umcapacidadListD').popover('show');

			    setTimeout(function(){ 

	            	$('#marcaListD').popover('destroy');
				  	$('#tipoListD').popover('destroy');
				  	$('#interfazListD').popover('destroy');
				  	$('#umvoltageListD').popover('destroy');
				  	$('#umcapacidadListD').popover('destroy');


				  	$('#marcaListD').selectpicker('refresh');
				  	$('#tipoListD').selectpicker('refresh');
				  	$('#interfazListD').selectpicker('refresh');
				  	$('#umvoltageListD').selectpicker('refresh');
				  	$('#umcapacidadListD').selectpicker('refresh');

			        $('#btnSelectElegido0').attr('style','width:100%;');
			        $('#btnSelectElegido1').attr('style','width:100%;');
			        $('#btnSelectElegido2').attr('style','width:100%;');
			        $('#btnSelectElegido3').attr('style','width:100%;');
			        $('#btnSelectElegido4').attr('style','width:100%;');


			    }, 300);


	$(document).ready(function() {

	  	$('#marcaListD').selectpicker('refresh');
	  	$('#modeloListD').selectpicker('refresh');
	  	$('#tipoListD').selectpicker('refresh');
	  	$('#interfazListD').selectpicker('refresh');
	  	$('#umvoltageListD').selectpicker('refresh');
	  	$('#umcapacidadListD').selectpicker('refresh');

		$('#marcaListD').on('change',function () {

			//alert($('#marcaListD').val());

		});

	    $('#listas .bootstrap-select ').each(function (index, datoItem) {

	        $(datoItem).attr('id','btnSelectElegido'+index);

//	        $('#btnSelectElegido'+index).attr('style','width:100px;');

	        $('#btnSelectElegido'+index+' button').on('click',function () {
		        //$('#btnSelectElegido'+index).css('width','100px');
	            
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


</script>
