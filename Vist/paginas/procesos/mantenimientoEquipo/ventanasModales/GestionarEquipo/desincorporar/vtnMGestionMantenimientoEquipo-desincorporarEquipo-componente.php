	

		<!-- Panel de Ventana modal-->
		<div id="vtnMantenimientoEquipoDesincComp" class="ventana-desincorporacion panel panel-primary ventana-modal-panel-mediano-sintop ">
			<!-- Cabecera -->
			<div class="panel-heading">
				<h3 class="panel-title">
					Desincorporar componente del equipo 
					<a href="javascript:;" id="ventana-modal-panel-cerrar" class="ventana-modal-panel-cerrar" style="" 
					onclick="ventanaModal.ocultarSinReinicPublic('ventana-modal-capa3')">x</a>
				</h3> 
			</div> 
			<!-- Contenido/Formulario -->
			<div class="panel-body"> 
				<form id="form" method="POST" >
						<input type="text" id="datoControl" value="" style="display:none;"></input>
						<input type="text" id="datoControlId" value="" style="display:none;"></input>
						<div class="row">
							<div class="col-md-8">
								<b>
								Observación de la desincorporación:
								</b>
							</div>
						</div>
						<div  class="row">
							<div class="col-md-12">
						
						    	<textarea type="text" name="observacion" class="campo-control form-control input-sm textarea" id="observacionTxt" placeholder="" 
						    		onblur="nucleo.validadorPublic()" 
						  			onkeyup="nucleo.verificarDatosPublic('','','observacionTxt','')"
						  			rows="10" 
						    		data-cantmax="255" maxlength="255" data-cantmin="15" data-vexistencia="0" 
						    		data-solonumero="0" data-sololetra="0" data-sololetrayespacio="0" data-descripcion="1" data-vcorreo="0" required="true" > El componente esta dañado
						  		</textarea>		

							</div>					
						</div>
						<hr>
						<div class="row">
							<div class="col-md-2 col-md-offset-10">
						      	<label for="recurso" style="color:#ffffff;">|||||||||||||||||:</label>							  
						  	  	<div id="divDetalles" class="form-group">								
									<a href="javascript:;" onclick="">
									    <button type="button" class="btn btn-default" 
									     onclick="mtdMantenimientoEquipo.desincorporarPerCompSoftPublic(
									     'equipo_componente','id_componente'
									     );" >
									    <!-- disabled="false" -->
									  		Guardar<!--<span class="glyphicon glyphicon-plus-sign"></span>-->
									  	</button>
									</a>	
								</div>	
							</div>		
						</div>					
				</form>
				<?php 

					include '../../../../../../secciones/dialogo/procesandoDatos.php';

				?>
			</div>				
		</div>



<!-- carga de complementos catalogo/ventana modal relacionados // Estos complementos deben de ser los ultimos en cargar-->
<script type="text/javascript">
	mtdMantenimientoEquipo.guardarDiagnosticoSolicitudPublic();
</script>
