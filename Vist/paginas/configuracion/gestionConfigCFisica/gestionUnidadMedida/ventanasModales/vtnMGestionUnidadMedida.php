		<!-- Panel de Ventana modal-->
		<div id="vtnCCompUMCapacidad" class="panel panel-primary ventana-modal-panel-expandido ">
			<!-- Cabecera -->
			<div class="panel-heading">
				<h3 class="panel-title">
					Gestionar la unidad de medida
					<a href="javascript:;" id="ventana-modal-panel-cerrar" class="ventana-modal-panel-cerrar" style="" 
					onclick="ventanaModal.ocultarPulico('ventana-modal'),mtdCFiscUMCapacidad.restablecerFormPublic()">x</a>
				</h3> 
			</div> 
			<!-- Contenido/Formulario -->
			<div class="panel-body"> 
					<form id="form" method="POST" >
							<input type="text" id="datoControl" value="" style="display:none;"></input>
							<input type="text" id="datoControlId" value="" style="display:none;"></input>
							<div class="row">
							  <div class="col-md-4 col-md-offset-2">
   							      <label for="recurso">Nombre:</label>							  
							  	  	<div id="divNombreTxt" class="form-group">
								    	<input type="text" name="nombre" class="campo-clave campo-control form-control input-sm" id="nombreTxt" placeholder="Ingresar nombre" 
								  			onkeypress="nucleo.verificarDatosInputPublic(event,this,'divNombreTxt')"
											onkeyup="nucleo.verificarDatosPublic('cfg_c_fisc_unidad_medida','nombre','nombreTxt','nombreTxt')" 
								    		data-cantmax="30" maxlength="30" data-cantmin="3" data-vexistencia="1" 
											data-sololetra="1">
								  	</div>				  	
							  </div>
							  <div class="col-md-2 col-md-offset-2">
   							      <label for="recurso">Abreviatura:</label>							  
							  	  	<div id="divAbreviaturaTxt" class="form-group">
								    	<input type="text" name="abreviatura" class="campo-control form-control input-sm" id="abreviaturaTxt" placeholder="Ingresar abreviatura" 
								  			onkeypress="nucleo.verificarDatosInputPublic(event,this,'divAbreviaturaTxt')"								    		
								  			onkeyup="nucleo.verificarDatosPublic('cfg_c_fisc_unidad_medida','abreviatura','abreviaturaTxt','divAbreviaturaTxt')"
								    		data-cantmax="5" maxlength="5" data-cantmin="1" data-vexistencia="1" 
								    		data-sololetra="1" >
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
		mtdCFiscUMCapacidad.Iniciar();
		mtdCFiscUMCapacidad.cargarCatalogoPublic(1);	
		nucleo.asignarPermisosBotonesPublic(23);
		nucleo.guardarBitacoraPublic("INGRESO EN EL MODULO DE CONFIGURACIÓN - CARACTERISTICAS FISICAS - SECCIÓN : UNIDAD DE MEDIDA "); 		

</script>
