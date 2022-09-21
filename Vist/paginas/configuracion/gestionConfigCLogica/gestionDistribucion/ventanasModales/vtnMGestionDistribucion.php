	

		<!-- Panel de Ventana modal-->
		<div id="vtnCLogcDistribucion" class="panel panel-primary ventana-modal-panel-expandido ">
			<!-- Cabecera -->
			<div class="panel-heading">
				<h3 class="panel-title">
					Gestionar la distribución
					<a href="javascript:;" id="ventana-modal-panel-cerrar" class="ventana-modal-panel-cerrar" style="" 
					onclick="ventanaModal.ocultarPulico('ventana-modal'),mtdCLogcDistribucion.restablecerFormPublic()">x</a>
				</h3> 
			</div> 
			<!-- Contenido/Formulario -->
			<div class="panel-body"> 
					<form id="form" method="POST" >
							<input type="text" id="datoControl" value="" style="display:none;"></input>
							<input type="text" id="datoControlId" value="" style="display:none;"></input>
							<div class="row">
							  <div class="col-md-6 col-md-offset-3">
   							      <label for="recurso">Nombre:</label>							  
							  	  	<div id="divNombreTxt" class="form-group">
								    	<input type="text" name="nombre" class="campo-clave campo-control form-control input-sm" id="nombreTxt" placeholder="Ingresar nombre" 
								  			onkeypress="nucleo.verificarDatosInputPublic(event,this,'divNombreTxt')"
											onkeyup="nucleo.verificarDatosPublic('cfg_c_logc_distribucion','nombre','nombreTxt','divNombreTxt')" 								  			
								    		data-cantmax="30" maxlength="30" data-cantmin="2" data-vexistencia="1" 
								    		data-sololetraynumero="1">
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
		mtdCLogcDistribucion.Iniciar();
		mtdCLogcDistribucion.cargarCatalogoPublic(1);	
		nucleo.asignarPermisosBotonesPublic(18);
		nucleo.guardarBitacoraPublic("INGRESO EN EL MODULO DE CONFIGURACIÓN - CARACTERISTICAS LOGICAS - SECCIÓN : DistribucionS"); 		
</script>
