	

		<!-- Panel de Ventana modal-->
		<div id="vtnCaracteristicasSoftware" class="panel panel-primary ventana-modal-panel-expandido ">
			<!-- Cabecera -->
			<div class="panel-heading">
				<h3 class="panel-title">
					Gestionar el software
					<a href="javascript:;" id="ventana-modal-panel-cerrar" class="ventana-modal-panel-cerrar" style="" 
					onclick="ventanaModal.ocultarPulico('ventana-modal'),mtdCaracteristicasSoftware.restablecerFormPublic()">x</a>
				</h3> 
			</div> 
			<!-- Contenido/Formulario -->
			<div class="panel-body"> 
				<form id="form" method="POST" >
						<input type="text" id="datoControl" value="" style="display:none;"></input>
						<input type="text" id="datoControlId" value="" style="display:none;"></input>

							<div class="row">
							    <div class="col-md-5 col-md-offset-1">
   							      <label for="recurso">Nombre:</label>							  
							  	  	<div id="divNombreTxt" class="form-group">
								    	<input type="text" name="nombre" class="campo-clave campo-control form-control input-sm" id="nombreTxt" placeholder="Ingresar nombre"
											onkeypress="nucleo.verificarDatosInputPublic(event,this,'nombreTxt')"
											onkeyup="nucleo.verificarDatosPublic('eq_software','nombre','nombreTxt','nombreTxt')" 											
								    		data-cantmax="100" maxlength="100" data-cantmin="2"  data-vexistencia="0" 
								    	>
								  	</div>				  	
							    </div>
								<div class="col-md-5 col-md-offset-0">
	   							      <label for="recurso">Versión:</label>							  
								  	  	<div id="divVersionTxt" class="form-group">
									    	<input type="text" name="versión" class="campo-control form-control input-sm" id="versionTxt" placeholder="Ingresar version del software" 
												onkeypress="nucleo.verificarDatosInputPublic(event,'','',this,'versionTxt')"
									    		data-cantmax="20" maxlength="20" data-cantmin="1" data-solonumero="1">
									  	</div>				  	
								</div>
							</div>


							<div class="row">
								<div class="col-md-5 col-md-offset-1">
	   							    <label for="Tipo">Tipo : </label>							  
								  	<div id="divTipoListD" class="form-group">
									    <select  id="tipoListD" class="select campo-control selectpicker lista-control lista-control-change"  name="Tipo" data-select="1" data-show-subtext="true" 
									    data-content-popover="divTipoListD"
									    data-tabla-form="eq_software"
									    data-tabla-campo="cfg_c_logc_tipo"
										data-columna-campo="id_c_logc_tipo"
									    data-live-search="true"  >								
											<option data-subtext="" value="0">No hay datos</option>								   		
									   	</select>
									</div>				  	
								</div>
							  <div class="col-md-5 col-md-offset-0">
   							      <label for="Distribucion">Distribución:</label>							  
							  	  	<div id="divDistribucionListD" class="form-group">
								    	<select  id="distribucionListD" class="select campo-control selectpicker lista-control lista-control-change" data-select="1" name="Distribucion" 
								    	data-content-popover="divDistribucionListD"
									    data-tabla-form="eq_software" 
									    data-tabla-campo="cfg_c_logc_distribucion"
										data-columna-campo="id_c_logc_distribucion"
								    	data-show-subtext="true" data-live-search="true"  >
											<option data-subtext="" value="0">No hay datos</option>								   		
								   		</select>
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
		mtdCaracteristicasSoftware.Iniciar();
		mtdCaracteristicasSoftware.cargarCatalogoPublic(1,"","");	

		if ($('#ventana-modal-cfg').hasClass('ventana-modal-panel-accionMostrar')==false) {
			nucleo.asignarPermisosBotonesPublic(29);
		}		
				//refrescar item
			  	nucleo.cargarListaDespegableListasPublic('tipoListD','cfg_c_logc_tipo','');
			  	nucleo.cargarListaDespegableListasPublic('distribucionListD','cfg_c_logc_distribucion','');

				$('#tipoListD').popover({
				    html: true, 
					placement: "right",
					content: function() {
				          return $('#procesandoDatosInput').html();
				        }
				})
				$('#distribucionListD').popover({
				    html: true, 
					placement: "right",
					content: function() {
				          return $('#procesandoDatosInput').html();
				        }
				});	

            	$('#tipoListD').popover('show');
			  	$('#distribucionListD').popover('show');

			    setTimeout(function(){ 

	            	$('#tipoListD').popover('destroy');
				  	$('#distribucionListD').popover('destroy');

				  	$('#tipoListD').selectpicker('refresh');
				  	$('#distribucionListD').selectpicker('refresh');

			        $('#btnSelectElegido2').attr('style','width:100%;');
			        $('#btnSelectElegido3').attr('style','width:100%;');

			    }, 300);


	$(document).ready(function() {

	  	$('#tipoListD').selectpicker('refresh');
	  	$('#distribucionListD').selectpicker('refresh');

	});
//	nucleo.verificarExistenciaSelectPublic('vtnCaracteristicasSoftware');

</script>
