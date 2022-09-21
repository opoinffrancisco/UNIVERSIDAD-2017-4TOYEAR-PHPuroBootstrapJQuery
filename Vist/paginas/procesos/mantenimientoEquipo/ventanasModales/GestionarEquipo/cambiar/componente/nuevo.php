<br>
			<div class="row">
				<div class="col-md-12" >
					<b>
						Seleccionar caracteriticas para el nuevo componente, ingresar seriales e indicar una observación
					</b>
				</div>
			</div>				
<hr>
<form id="formADD" method="POST" class="panel-vtn-content-datos" >
	<input type="text" id="datoControlIdCaractADD" value="" style="display:none;"></input>					
	<div  class="row">
		<div class="col-md-3">
				<label for="Tipo" style="color:#000;" >Filtrar por modelo :</label>					
			  	<div id="divBuscadorTxt" class="form-group">
					<div class="input-group">
					  <!--<span class="input-group-addon glyphicon glyphicon-search" id="sizing-addon2"></span>-->
					  <span class="input-group-addon" id="sizing-addon2" >Buscar</span>
					  <input type="text" maxlength="30" min="1" class="form-control filtro_1" id="buscardorTxt" placeholder="Ingresar modelo" aria-describedby="sizing-addon2"

					  onkeyup="

							mtdComponente.cargarListaCaracteristicasPublic(1);
					  "

					  >
					</div>
				</div>
				<label for="Tipo" >Filtrar por tipo : </label>							  
			  	<div id="divTipoListD" class="form-group">
				    <select  id="btipoListD" class="filtro_2 selectpicker lista-control " data-select="1" name="Tipo" data-show-subtext="true" data-live-search="true"  >								
						<option data-subtext="" value="0">No hay datos</option>								   		
				   	</select>
				</div>
				<div id="div-btn-admin" class="form-group">
					<a href="javascript:;" onclick="ventanaModal.mostrarPulico('ventana-modal', datosIdsTabs=['scroll','no'])">
					    <button type="button" class="btn btn-default btn-cfg-admin" id="btnNuevo-admin"  style="width: 100%;"
										onclick="ventanaModal.cambiaMuestraVentanaModalCapaAdminPublic(
												'vtnProcsEquipoConsulta',
												'administracion #ventana-modal-cfg',
												'configuracion/gestionCaracteristicasComponente/ventanasModales/vtnMGestionCaracteristicasComponente.php',
												1
										)"
					    >
					  		Agregar nuevas caracteristicas
					  	</button>
					</a>
				</div>

				<b>
					Seleccionar características
				</b>
				<div id="pgnListCaracteristicasComponentes">
						<div id="pagination">
							
						</div>
				</div>	
				<div id="listGestionCaractCompon" class="list-group" style="FONT-SIZE: smaller;">

				</div>							
				<div id="pgnListCaracteristicasComponentes">
						<div id="pagination">
							
						</div>
				</div>	
		</div>
		<div class="col-md-9">
			<div class="row">
				<div class="col-md-9">

					<b>
						Detalles de las características
					</b>
					<div class="row">

						<div class="col-md-12">
							<div class="form-group">
								<label for="1">Tipo</label>
							    <input type="text" class="form-control input-sm" id="tipotxt" disabled="TRUE">
							</div>																						
						</div>																					
					</div>
				
					<div class="row">
						<div class="col-md-6">											
							<div class="form-group">
							    <label for="1">Marca</label>
							    <input type="text" class="form-control input-sm" id="marcatxt" disabled="TRUE">
							</div>											
						</div>				
						<div class="col-md-6">
							<div class="form-group">
								<label for="1">Modelo</label>
							    <input type="text" class="form-control input-sm" id="modelotxt" disabled="TRUE">
							</div>																						
						</div>																					
					</div>
					<div class="row">
						<div class="col-md-6">											
							<div class="form-group">
							    <label for="1">Capacidad</label>
							    <input type="text" class="form-control input-sm" id="capacidadtxt" disabled="TRUE">
							</div>											
						</div>																					
					</div>						
				</div>								
				<div class="col-md-3">
					<div class="form-group">
						<label for="1">Interfaces de conexión</label>
						<div id="listGestionCaractInterfacesCompon" class="list-group" style="FONT-SIZE: smaller;">
							
						</div>							
					</div>
				</div>			
			</div>
			<div class="row"  id="listGestionCaractInterfacesCompon">
				<div class="col-md-12">
					<table id="listVtnSeriesComponentes" class="table table-bordered table-hover ">
						 <thead>
						  <tr class="row">
						   <th class="col-md-6">Serial </th>
						   <th class="col-md-6">Serial Bien Nacional</th>
						  </tr> 
						 </thead> 
						 <tbody id="catalogoDatos" class="catalogo-datos"> 
		 					<!-- Resultados de Datos -->

																																	 					
		 					<!-- Img de Carga de Datos -->
						  </tbody>
						  <tr class="row filaInputs" id="fila1" data-numfila="1" style="padding-top: 5px; padding-bottom: 5px; border-top: 1px solid #ddd; border-bottom: 0px solid #ddd;">
						  	<td style=" padding: 0px; text-align: center;vertical-align:middle;" class="col-md-6">
						  		<div class="form-group">
						  			<input type="text" class="form-control" id="input1" placeholder="Introducir serial" style="margin-bottom: 0px; border: 1px solid white; box-shadow: unset;">
						  		</div>
						  	</td>
						  	<td style=" padding: 0px; text-align: center;vertical-align:middle;" class="col-md-6">
						  		<div class="form-group">
						  			<input type="text" class="form-control" id="input2" placeholder="Introducir serial de bien Nacional" style="margin-bottom: 0px; border: 1px solid white; box-shadow: unset;">
						  		</div>
						  	</td>
						</tr> 
					</table>											
				</div>																				
			</div>


		<hr>

		<div class="row">

		    <div class="col-md-12"  style="background-color:#fff">

				<div class="row">
					<div class="col-md-8">
						<b>
						Observacion del porque el cambio :
						</b>
					</div>
				</div>
				<div  class="row">
					<div class="col-md-12">
				
				    	<textarea type="text" name="observación" class="campo-control form-control input-sm textarea" id="observacionTxt" placeholder="Ingresar observación" 
				    		onblur="nucleo.validadorPublic()" 
				  			onkeyup="nucleo.verificarDatosPublic('','','observacionTxt','')"
				  			rows="10" 
				    		data-cantmax="255" maxlength="255" data-cantmin="15" data-vexistencia="0" 
				    		data-solonumero="0" data-sololetra="0" data-sololetrayespacio="0" data-descripcion="1" data-vcorreo="0" required="true" > El componente actual esta dañado
				  		</textarea>		

					</div>					
				</div>
				<hr>
				<div class="row">
					<div class="col-md-2 col-md-offset-10">
				      	<label for="recurso" style="color:#ffffff;">|||||||||||||||||:</label>							  
				  	  	<div id="divDetalles" class="form-group">								
							<a href="javascript:;" onclick="">
							    <button type="button" class="btn btn-default" onclick="mtdMantenimientoEquipo.guardarCambioComponentePublic();" >
							    <!-- disabled="false" -->
							  		Guardar<!--<span class="glyphicon glyphicon-plus-sign"></span>-->
							  	</button>
							</a>	
						</div>	
					</div>		
				</div>			



			</div>

		</div>


		</div>


	</div>
	<!-- carga de complementos catalogo/ventana modal relacionados // Estos complementos deben de ser los ultimos en cargar-->
	<script type="text/javascript">
		mtdComponente.cargarListaCaracteristicasPublic(1);

	  	nucleo.cargarListaDespegableListasPublic('btipoListD','cfg_c_fisc_tipo','tipo');

		$('#btipoListD').popover({
		    html: true, 
			placement: "right",
			content: function() {
		          return $('#procesandoDatosInput').html();
		        }
		})

		$('#btipoListD').popover('show');

	    setTimeout(function(){ 

	    	$('#btipoListD').popover('destroy');

		  	$('#btipoListD').selectpicker('refresh');

	        $('#ctlgCaracteristicasPerifericos #btnSelectElegido0').attr('style','width:100%;');

	    }, 300);


		$(document).ready(function() {

			$('#btipoListD').on('change',function () {
			
				mtdComponente.cargarListaCaracteristicasPublic(1);

			});

		  	$('#btipoListD').selectpicker('refresh');

		    $('#ctlgCaracteristicasPerifericos #listas .bootstrap-select ').each(function (index, datoItem) {

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
</form>