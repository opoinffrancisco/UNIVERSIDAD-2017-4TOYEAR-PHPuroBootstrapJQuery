	

		<!-- Panel de Ventana modal-->
		<div id="vtnProcsBusqdAvanzd" class="panel panel-primary ventana-modal-panel-mediano ">
			<!-- Cabecera -->
			<div class="panel-heading">
				<h3 class="panel-title">
					Seleccionar características para filtrar equipos
					<a href="javascript:;" id="ventana-modal-panel-cerrar" class="ventana-modal-panel-cerrar" style="" 
					onclick="ventanaModal.ocultarPulico('ventana-modal-capa-base')">x</a>
				</h3> 
			</div> 
			<!-- Contenido/Formulario -->
			<div class="panel-body"> 
				<form id="form" method="POST" >
						<input type="text" id="datoControl" value="" style="display:none;"></input>
						<input type="text" id="datoControlId" value="" style="display:none;"></input>
						<div id="listas">	


							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="1">Serial</label>
									    <input type="text" class="form-control" id="serialTxt" placeholder="Ingresar serial">
									</div>																					
								</div>				
								<div class="col-md-6">
									<div class="form-group">
										<label for="1">Serial bien nacional:</label>
									    <input type="text" class="form-control" id="serialBienNTxt" placeholder="Ingresar serial bien nacional">
									</div>																						
								</div>																					
							</div>		


							<div class="row">
							  	<div class="col-md-6 col-md-offset-0">
   							      	<label for="recurso">Tipo de periferico:</label>							  
							  	  	<div id="divTipoListD" class="form-group">
								    	<select  id="tipoListD" class="select campo-control selectpicker lista-control" data-select="1" name="Tipo" data-show-subtext="true" data-live-search="true"  >
											<option data-subtext="" value="0">No hay datos</option>								   		
								   		</select>
								  	</div>						  	
							  	</div>							  
							</div>

							<div class="row">
							  <div class="col-md-6 col-md-offset-0">
   							      <label for="recurso">Marca:</label>							  
							  	  	<div id="divMarcaListD" class="form-group">
								    	<select  id="marcaListD" class="select campo-control selectpicker lista-control " data-select="1" name="Marca" data-show-subtext="true" data-live-search="true"  >
											<option data-subtext="" value="0">No hay datos</option>								   		
								   		</select>
								  	</div>				  	
							  </div>
							  <div class="col-md-6 col-md-offset-0">
   							      <label for="recurso">Modelo:</label>							  
							  	  	<div id="divModeloListD" class="form-group">
								    	<select  id="modeloListD" class="select campo-control selectpicker lista-control" data-select="1" name="Modelo" data-show-subtext="true" data-live-search="true"  >
											<option data-subtext="" value="0">No hay datos</option>								   		
								   		</select>
								  	</div>						  	
							  </div>							  
							</div>



<div class="row">
	<div class="col-md-2 col-md-offset-10"  >

		<a href="javascript:;" onclick="mtdEquipo.opcionesBusquedaAvanvadaPublic()">
		    <button type="button" class="btn btn-default" id="btnFiltrar" >
		    <!-- disabled="false" -->
		  		Filtrar<!--<span class="glyphicon glyphicon-plus-sign"></span>-->
		  	</button>
		</a> 		

	</div>
</div>
<br>							
																
						</div>					
				</form>
				<?php 

					include '../../../../../secciones/dialogo/procesandoDatos.php';

				?>
			</div>				
		</div>



<!-- carga de complementos catalogo/ventana modal relacionados // Estos complementos deben de ser los ultimos en cargar-->
<script type="text/javascript">
	mtdEquipo.filtrarSelectPublic();

				//refrescar item
			  	nucleo.cargarListaDespegableListasPublic('marcaListD','cfg_c_fisc_mod_marca','marca');
			  	nucleo.cargarListaDespegableListasPublic('tipoListD','cfg_c_fisc_tipo','tipo');

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
	
            	$('#marcaListD').popover('show');
			  	$('#tipoListD').popover('show');

			    setTimeout(function(){ 

	            	$('#marcaListD').popover('destroy');
				  	$('#tipoListD').popover('destroy');


				  	$('#marcaListD').selectpicker('refresh');
				  	$('#tipoListD').selectpicker('refresh');

			        $('#btnSelectElegido0').attr('style','width:100%;');
			        $('#btnSelectElegido1').attr('style','width:100%;');
			        $('#btnSelectElegido2').attr('style','width:100%;');


			    }, 300);


				$(document).ready(function() {

				  	$('#marcaListD').selectpicker('refresh');
				  	$('#modeloListD').selectpicker('refresh');
				  	$('#tipoListD').selectpicker('refresh');

				});


</script>
