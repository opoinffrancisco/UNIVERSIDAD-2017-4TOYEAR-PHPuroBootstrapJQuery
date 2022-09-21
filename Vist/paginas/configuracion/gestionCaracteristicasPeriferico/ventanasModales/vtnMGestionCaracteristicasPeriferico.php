	

		<!-- Panel de Ventana modal-->
		<div id="vtnCaracteristicasPerifericos" class="panel panel-primary ventana-modal-panel-expandido ">
			<!-- Cabecera -->
			<div class="panel-heading">
				<h3 class="panel-title">
					Gestionar las carácteristicas del periferico
					<a href="javascript:;" id="ventana-modal-panel-cerrar" class="ventana-modal-panel-cerrar" style="" 
					onclick="ventanaModal.ocultarPulico('ventana-modal'),mtdCaracteristicasPerifericos.restablecerFormPublic()">x</a>
				</h3> 
			</div> 
			<!-- Contenido/Formulario -->
			<div class="panel-body"> 
				<form id="form" method="POST" >
						<input type="text" id="datoControl" value="" style="display:none;"></input>
						<input type="text" id="datoControlId" value="" style="display:none;"></input>
						<div class="row">
						    <div class="col-md-7 col-md-offset-1">
								<h5>
									Carácteristicas fisicas para gestionar el periferico :
								</h5>
							</div>
						</div>
						<div id="listas">													
							<div class="row">
							  <div class="col-md-5 col-md-offset-1">
   							      <label for="recurso">Marca:</label>							  
							  	  	<div id="divMarcaListD" class="form-group">
								    	<select  id="marcaListD" class="selectpicker lista-control " data-show-subtext="true" data-live-search="true"  >
								   		</select>
								  	</div>				  	
							  </div>
							  <div class="col-md-4 col-md-offset-1">
   							      <label for="recurso">Modelo:</label>							  
							  	  	<div id="divModeloListD" class="form-group">
								    	<select  id="modeloListD" class="selectpicker lista-control lista-control-change" data-show-subtext="true" data-live-search="true" 
									    data-content-popover="divModeloListD"
									    data-tabla-form="cfg_caracteristicas_fisc_perif"
									    data-tabla-campo="cfg_c_fisc_modelo"
										data-columna-campo="id_modelo_fisc" >
								   		</select>
								  	</div>						  	
							  </div>							  
							</div>
							<div class="row">
							  <div class="col-md-5 col-md-offset-1">
   							      <label for="recurso">Tipo : </label>							  
							  	  	<div id="divTipoListD" class="form-group">
								    	<select  id="tipoListD" class="selectpicker lista-control lista-control-change" data-show-subtext="true" data-live-search="true" 
								 	    data-content-popover="divTipoListD"
									    data-tabla-form="cfg_caracteristicas_fisc_perif"
									    data-tabla-campo="cfg_c_fisc_tipo"
										data-columna-campo="id_tipo_fisc" >
								   		</select>
								  	</div>					  	
							  </div>
							  <div class="col-md-4 col-md-offset-1">
   							      <label for="recurso">Interfaz de conexión:</label>							  
							  	  	<div id="divInterfazListD" class="form-group">
								    	<select  id="interfazListD" class="selectpicker lista-control lista-control-change" data-show-subtext="true" data-live-search="true"  
								    	data-content-popover="divInterfazListD"
									    data-tabla-form="cfg_caracteristicas_fisc_perif"
									    data-tabla-campo="cfg_c_fisc_interfaz_conexion"
										data-columna-campo="id_interfaz_fisc">
								   		</select>
								  	</div>						  	
							  </div>							  
							</div>													
						</div>					
					<hr>
						<div class="row">
							<div class="col-md-2 col-md-offset-10">
						  		<button type="submit" id="btnGuardar" class="btn btn-default" disabled="TRUE">Guardar</button>
						  	</div>
					  	</div>	
				</form>
				<?php 

					include '../../../../secciones/dialogo/procesandoDatos.php';

				?>
			</div>				
		</div>



<!-- carga de complementos catalogo/ventana modal relacionados // Estos complementos deben de ser los ultimos en cargar-->
<script type="text/javascript">
		mtdCaracteristicasPerifericos.Iniciar();
		mtdCaracteristicasPerifericos.cargarCatalogoPublic(1);	
		if ($('#ventana-modal-cfg').hasClass('ventana-modal-panel-accionMostrar')==false) {
			nucleo.asignarPermisosBotonesPublic(27);
		}		
				//refrescar item
			  	nucleo.cargarListaDespegableListasPublic('marcaListD','cfg_c_fisc_mod_marca','marca');
			  	nucleo.cargarListaDespegableListasPublic('modeloListD','cfg_c_fisc_modelo','modelo');
			  	nucleo.cargarListaDespegableListasPublic('tipoListD','cfg_c_fisc_tipo','tipo');
			  	nucleo.cargarListaDespegableListasPublic('interfazListD','cfg_c_fisc_interfaz_conexion','interfaz');

				$('#marcaListD').popover({
				    html: true, 
					placement: "right",
					content: function() {
				          return $('#procesandoDatosInput').html();
				        }
				});
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
				$('#interfazListD').popover({
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

			    setTimeout(function(){ 

	            	$('#marcaListD').popover('destroy');
				  	$('#modeloListD').popover('destroy');
				  	$('#tipoListD').popover('destroy');
				  	$('#interfazListD').popover('destroy');

				  	$('#marcaListD').selectpicker('refresh');
				  	$('#modeloListD').selectpicker('refresh');
				  	$('#tipoListD').selectpicker('refresh');
				  	$('#interfazListD').selectpicker('refresh');

			        $('#btnSelectElegido0').attr('style','width:100%;');
			        $('#btnSelectElegido1').attr('style','width:100%;');
			        $('#btnSelectElegido2').attr('style','width:100%;');
			        $('#btnSelectElegido3').attr('style','width:100%;');


			    }, 300);


	$(document).ready(function() {

	  	$('#marcaListD').selectpicker('refresh');
	  	$('#modeloListD').selectpicker('refresh');
	  	$('#tipoListD').selectpicker('refresh');
	  	$('#interfazListD').selectpicker('refresh');

	    
	});
	nucleo.verificarExistenciaSelectPublic('vtnCaracteristicasPerifericos');


</script>
