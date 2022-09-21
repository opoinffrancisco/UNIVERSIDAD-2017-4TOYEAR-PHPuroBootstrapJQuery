<div class="row"  style="   background: #337ab7;    color: white;">
	<div class="col-md-12 col-md-offset-0">
		<h2>
			<a href="javascript:;" class="pestana-tab-activo" id="tabDetalles" 
						  		onclick="panelTabs.cambiarFormularioPublico(
									configuracion.urlsPublic().equipo.tabsDetallar.detalles, 
							  		'form',
						      		datosIdsTabs=[ 'tabDetalles' , 'tabSoftware'  ]
						   	)" style="
			    margin-right: 7%;
			    font-size: x-large;
			    text-align: center;
			    border-radius: 6px;
			    background: rgba(255, 255, 255, 0.47);
			    text-decoration: none;
			">
	      		Volver
	    	</a>
			<b> Software </b>
		</h2>
	</div>
</div>
<br>
				<form id="formADD" method="POST" >
					<input type="text" id="datoControlADD" value="" style="display:none;"></input>
					<input type="text" id="datoControlIdADD" value="" style="display:none;"></input>
					<input type="text" id="datoControlIdCaractADD" value="" style="display:none;"></input>					
					<div  class="row">
						<div class="col-md-3">
								<label for="Tipo" style="color:#000;" >Filtrar por nombre :</label>					
							  	<div id="divBuscadorTxt" class="form-group">
									<div class="input-group">
									  <!--<span class="input-group-addon glyphicon glyphicon-search" id="sizing-addon2"></span>-->
									  <span class="input-group-addon" id="sizing-addon2" >Buscar</span>
									  <input type="text" maxlength="30" min="1" class="form-control filtro_1" id="buscardorTxt" placeholder="Ingresar nombre" aria-describedby="sizing-addon2"

									  onkeyup="

											mtdEquipo.cargarListaCaracteristicasSoftwarePublic(1);
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
																'configuracion/gestionCaracteristicasSoftware/ventanasModales/vtnMGestionCaracteristicasSoftware.php',
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
								<div id="pgnListCaracteristicasSoftware">
										<div id="pagination">
											
										</div>
								</div>	
								<div id="listGestionCaractSoftware" class="list-group" style="FONT-SIZE: smaller;">
									
								</div>							
								<div id="pgnListCaracteristicasSoftware">
										<div id="pagination">
											
										</div>
								</div>	
						</div>
						<div class="col-md-9">
							<div class="row">

								<div class="col-md-12">
									<b>
										Detalles de las características
									</b>
						
									<div class="row">
										<div class="col-md-6">											
											<div class="form-group">
											    <label for="1">Nombre : </label>
											    <input type="text" class="form-control" id="nombretxt" disabled="TRUE">
											</div>											
										</div>				
										<div class="col-md-6">
											<div class="form-group">
												<label for="1">Versión : </label>
											    <input type="text" class="form-control" id="versiontxt" disabled="TRUE">
											</div>																						
										</div>																					
									</div>

									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="1">Tipo : </label>
											    <input type="text" class="form-control" id="tipotxt" disabled="TRUE">
											</div>											
										</div>				
										<div class="col-md-6">
											<div class="form-group">
												<label for="1">Distribución : </label>
											    <input type="text" class="form-control" id="distribuciontxt" disabled="TRUE">
											</div>												
										</div>																					
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

					include '../../../../../../../secciones/dialogo/procesandoDatos.php';

				?>


<!-- carga de complementos catalogo/ventana modal relacionados // Estos complementos deben de ser los ultimos en cargar-->
<script type="text/javascript">
	mtdEquipo.anadirSoftwarePublic();
	mtdEquipo.cargarListaCaracteristicasSoftwarePublic(1);
  	nucleo.cargarListaDespegableListasPublic('btipoListD','cfg_c_logc_tipo','');

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
		
			mtdEquipo.cargarListaCaracteristicasSoftwarePublic(1);

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
