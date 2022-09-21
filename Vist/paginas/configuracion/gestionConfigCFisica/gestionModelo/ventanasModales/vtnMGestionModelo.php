	

		<!-- Panel de Ventana modal-->
		<div id="vtnCCompModelo" class="panel panel-primary ventana-modal-panel-expandido ">
			<!-- Cabecera -->
			<div class="panel-heading">
				<h3 class="panel-title">
					Gestionar el modelo
					<a href="javascript:;" id="ventana-modal-panel-cerrar" class="ventana-modal-panel-cerrar" style="" 
					onclick="ventanaModal.ocultarPulico('ventana-modal'),mtdCFiscModelo.restablecerFormPublic()">x</a>
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
								    	<input type="text" name="nombre" class="campo-clave campo-control form-control input-sm" id="nombreTxt" placeholder="Ingresar modelo" 
								  			onkeyup="nucleo.verificarDatosPublic('cfg_c_fisc_modelo','nombre','nombreTxt','divNombreTxt')"
								    		data-cantmax="30" maxlength="30" data-cantmin="1" data-vexistencia="1" 
								    		data-solonumero="0" data-sololetra="0" data-sololetrayespacio="0" data-vcorreo="0" data-letraexpresionnumero="1">
								  	</div>				  	
								</div>
							  	<div class="col-md-5 ">
							  	  	<div id="divMarcaTxt" class="form-group">
								    	<label for="Marca">Marca : </label>
										<select class="selectpicker lista-control form-control" id="marcaListD" data-tabla="cfg_c_fisc_mod_marca" data-show-subtext="true" data-live-search="true" >
											<option value="" selected="true">Seleccione una Marca</option>
										</select>

								  	</div>				  	
							  	</div>

							</div>												
						<hr>
							<div class="row">
								<div class="col-md-2 col-md-offset-10">
							  		<button type="submit" id="btnGuardar" class="btn btn-default" >Guardar</button>
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
		mtdCFiscModelo.Iniciar();
		mtdCFiscModelo.cargarCatalogoPublic(1);	


//refrescar item
			$('#marcaListD').popover({
			    html: true, 
				placement: "right",
				content: function() {
			          return $('#procesandoDatosInput').html();
			        }
			})

				nucleo.cargarListaDespegablePublic('marcaListD','cfg_c_fisc_mod_marca');


        	$('#marcaListD').popover('show');

		    setTimeout(function(){ 

            	$('#marcaListD').popover('destroy');

			  	$('#marcaListD').selectpicker('refresh');

		        $('#vtnCCompModelo #btnSelectElegido0').attr('style','width:100%;');

		    }, 300);





		nucleo.asignarPermisosBotonesPublic(21);		
		nucleo.guardarBitacoraPublic("INGRESO EN EL MODULO DE CONFIGURACIÓN - CARACTERISTICAS FISICAS - SECCIÓN : MODELOS"); 				
</script>
