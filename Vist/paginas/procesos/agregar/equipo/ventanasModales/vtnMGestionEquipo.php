	

		<!-- Panel de Ventana modal-->
		<div id="vtnProcsEquipo" class="panel panel-primary ventana-modal-panel-grande ">
			<!-- Cabecera -->
			<div class="panel-heading">
				<h3 class="panel-title">
					Agregar Equipos
					<a href="javascript:;" id="ventana-modal-panel-cerrar" class="ventana-modal-panel-cerrar" style="" 
					onclick="ventanaModal.ocultarPulico('ventana-modal-capa-base')">x</a>
				</h3> 
			</div> 
			<!-- Contenido/Formulario -->
			<div class="panel-body"> 
				<form id="form" method="POST" >
					<input type="text" id="datoControl" value="" style="display:none;"></input>
					<input type="text" id="datoControlId" value="" style="display:none;"></input>
					<input type="text" id="datoControlIdCaract" value="" style="display:none;"></input>				
					<div  class="row">
						<div class="col-md-3">

							    <label for="Tipo" style="color:#000;" >Filtrar caracteristicas por modelo :</label>					
							  	<div id="divBuscadorTxt" class="form-group">
									<div class="input-group">
									  <!--<span class="input-group-addon glyphicon glyphicon-search" id="sizing-addon2"></span>-->
									  <span class="input-group-addon" id="sizing-addon2" >Buscar</span>
									  <input type="text" maxlength="30" min="1" class="form-control filtro_1" id="buscardorTxt" placeholder="Ingresar modelo" aria-describedby="sizing-addon2"

									  onkeyup="

											mtdEquipo.cargarListaCaracteristicasPublic(1);
									  "

									  >
									</div>
								</div>
								<label for="Tipo" >Filtrar caracteristicas por tipo : </label>							  
							  	<div id="divTipoListD" class="form-group">
								    <select  id="btipoListD" class="filtro_2 selectpicker lista-control " data-select="1" name="Tipo" data-show-subtext="true" data-live-search="true"  >								
										<option data-subtext="" value="0">No hay datos</option>								   		
								   	</select>
								</div>				  	
								<div id="div-btn-admin" class="form-group">
									<a href="javascript:;" >
									    <button type="button" class="btn btn-default btn-cfg-admin" id="btnNuevo-admin"  style="width: 100%;"
														onclick="ventanaModal.cambiaMuestraVentanaModalCapaAdminPublic(
																'vtnProcsEquipo',
																'administracion #ventana-modal-cfg',
																'configuracion/gestionCaracteristicasEquipo/ventanasModales/vtnMGestionCaracteristicasEquipo.php',
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
								<div id="pgnListCaracteristicasEquipos">
										<div id="pagination">
											
										</div>
								</div>	
								<div id="listGestionCaractEqu" class="list-group" style="FONT-SIZE: smaller;">

								</div>							
								<div id="pgnListCaracteristicasEquipos">
										<div id="pagination">
											
										</div>
								</div>	
						</div>
						<div class="col-md-9">
							<b>
								Detalles de las características
							</b>						
							<div class="row">
								<div class="col-md-9">
									


									<div class="row">

										<div class="col-md-12">
											<div class="form-group">
												<label for="1">Tipo</label>
											    <input type="text" class="form-control" id="tipotxt" disabled="TRUE">
											</div>																						
										</div>																					
									</div>
								
									<div class="row">
										<div class="col-md-6">											
											<div class="form-group">
											    <label for="1">Marca</label>
											    <input type="text" class="form-control" id="marcatxt" disabled="TRUE">
											</div>											
										</div>				
										<div class="col-md-6">
											<div class="form-group">
												<label for="1">Modelo</label>
											    <input type="text" class="form-control" id="modelotxt" disabled="TRUE">
											</div>																						
										</div>																					
									</div>

									<div class="row">
										<div class="col-md-6" style="display: none;">
											<div class="form-group">
												<label for="1">Voltaje</label>
											    <input type="text" class="form-control" id="voltagetxt" disabled="TRUE">
											</div>											
										</div>				
									</div>
								</div>								
								<div class="col-md-3">
									
									<div class="form-group">
										<label for="1">Iterfaces</label>
										<div id="listGestionCaractInterfacesEqu" class="list-group" style="FONT-SIZE: smaller;">
											
										</div>							
									</div>
								</div>			
							</div>
							<hr>
							<div class="row" style="margin-bottom: 10px;">

								<div class="col-md-3 col-md-offset-7">
									<div class="btn-group" role="group" style="width: 100%;">
										<button type="button" class="btn btn-default" id="btnAggSeries" style="width: 100%;"
										onclick="listas.agregarItemInputPublic('vtnProcsEquipo','listVtnSeriesEquipos','btnAggSeries');" >Agregar Seriales</button>
									</div>	
									<br>									
								</div>
								<div class="col-md-2 col-md-offset-0" > 
									<div class="form-group">
									    <input type="number"  class="form-control" id="contadorList" disabled="TRUE" style="padding-left: 40%;">
									</div>
								</div>
							</div>
							<div class="row">

							    <div class="col-md-12"  style="background-color:#fff">
									<div class="catalogo">
										<table id="listVtnSeriesEquipos" class="table table-bordered table-hover ">
										 <thead>
										  <tr  class="row">
										   <th  class="col-md-5">Serial </th>
										   <th  class="col-md-5">Serial Bien Nacional</th>
										   <th  class="col-md-2">Opciones</th> 
										  </tr> 
										 </thead> 
										 <tbody id="catalogoDatos" class="catalogo-datos"> 
						 					<!-- Resultados de Datos -->

																																					 					
						 					<!-- Img de Carga de Datos -->
										  </tbody> 
										</table>
									</div>
								</div>

							</div>
						</div>
						
					</div>

			  		<button type="submit" id="btnGuardarFloatR" class="btn btn-default" 
							style="position: fixed; z-index: 99; float: right; right: 2%; bottom: 5%;"
			  		>Guardar</button>
				</form>
				<?php 

					include '../../../../../secciones/dialogo/procesandoDatos.php';

				?>
			</div>				
		</div>

<!-- carga de complementos catalogo/ventana modal relacionados // Estos complementos deben de ser los ultimos en cargar-->
<script type="text/javascript">
	mtdEquipo.guardarPublic();
	mtdEquipo.cargarListaCaracteristicasPublic(1);
	//refrescar item
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
		
			mtdEquipo.cargarListaCaracteristicasPublic(1);

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
	nucleo.controlAccessBtnAdminPublic();
</script>
