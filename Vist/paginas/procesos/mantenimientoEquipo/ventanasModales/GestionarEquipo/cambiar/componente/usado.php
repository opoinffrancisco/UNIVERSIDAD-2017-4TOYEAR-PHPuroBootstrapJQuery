<br>
			<div class="row">
				<div class="col-md-12" >
					<b>
						Seleccionar el componente disponible e indicar una observación
					</b>
				</div>
			</div>				
<hr>
<form id="formADD" method="POST" class="panel-vtn-content-datos">
	<input type="text" id="datoControlIdCaractADD" value="" style="display:none;"></input>					
	<div  class="row">
		<div class="col-md-3">
				
				<label for="Tipo" style="color:#000;" >Filtrar por Serial :</label>					
			  	<div id="divBuscadorTxt" class="form-group">
					<div class="input-group">
					  <!--<span class="input-group-addon glyphicon glyphicon-search" id="sizing-addon2"></span>-->
					  <span class="input-group-addon" id="sizing-addon2" >Buscar</span>
					  <input type="text" maxlength="30" min="1" class="form-control filtro_1" id="buscardorTxt" placeholder="Ingresar serial" aria-describedby="sizing-addon2"

					  onkeyup="

							mtdMantenimientoEquipo.cargarListaComponentesDisponiblesPublic();
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
				<b>
					Seleccionar componente
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
							    <label for="1">Serial</label>
							    <input type="text" class="form-control input-sm" id="serialTxt" disabled="TRUE">
							</div>											
						</div>				
						<div class="col-md-6">
							<div class="form-group">
								<label for="1">Serial de bien nacional</label>
							    <input type="text" class="form-control input-sm" id="serialBienNacionalTxt" disabled="TRUE">
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
						<div id="listGestionCaractInterfacesComponUsado" class="list-group" style="FONT-SIZE: smaller;">
							
						</div>							
					</div>
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
							    <button type="button" class="btn btn-default" onclick="mtdMantenimientoEquipo.guardarCambioComponenteUsadoPublic();" >
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
		mtdMantenimientoEquipo.cargarListaComponentesDisponiblesPublic();
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
			
				mtdMantenimientoEquipo.cargarListaComponentesDisponiblesPublic();

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