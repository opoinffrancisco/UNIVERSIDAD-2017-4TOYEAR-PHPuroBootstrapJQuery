	

		<!-- Panel de Ventana modal-->
		<div id="vtnResponder" class="panel panel-primary ventana-modal-panel-mediano-sintop ">
			<!-- Cabecera -->
			<div class="panel-heading">
				<h3 class="panel-title">
					Respuesta 
					<a href="javascript:;" id="ventana-modal-panel-cerrar" class="ventana-modal-panel-cerrar" style="" 
					onclick="ventanaModal.ocultarSinReinicPublic('ventana-modal-capa2')">x</a>
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
									Dar respuesta final a la solicitud 
								</b>
							</div>
						</div>
						<div  class="row">
							<div class="col-md-12">
						
						    	<textarea type="text" name="observacion" class="campo-control form-control input-sm textarea" id="observacionTxt" placeholder="Ingresar descripcion" 
						  			onkeyup="nucleo.verificarDatosPublic('','','observacionTxt','')"
						  			rows="10" 
						    		data-descripcion="1" required="true"
									onblur="
										if($('#observacionTxt').val().length>255 || $('#observacionTxt').val().length<15){
											if($('#observacionTxt').val().length>255){
												nucleo.alertaErrorPublic('La observación tiene :'+$('#observacionTxt').val().length+' caracteres, máximo 255 ');
												$('#btnGuardar').attr('disabled', true);
											}
											if($('#observacionTxt').val().length<15){
												nucleo.alertaErrorPublic('La observación tiene :'+$('#observacionTxt').val().length+' caracteres, minimo 15 ');
												$('#btnGuardar').attr('disabled', true);
											}
										}else{
											$('#btnGuardar').attr('disabled', false);
										}
									" 
									onkeypress="
										if($(' #observacionTxt').val().length>255 || $('#observacionTxt').val().length<15){
											if($('#observacionTxt').val().length>255){
												$('#btnGuardar').attr('disabled', true);
											}
											if($('#observacionTxt').val().length<15){
												$('#btnGuardar').attr('disabled', true);
											}
										}else{
											$('#btnGuardar').attr('disabled', false);
										}
									" 
						    		>Equipo, reparado exitosamente.!</textarea>		

							</div>					
						</div>
						<hr>
						<div class="row">
							<div class="col-md-2 col-md-offset-10">
						      	<label for="recurso" style="color:#ffffff;">|||||||||||||||||:</label>							  
						  	  	<div id="divDetalles" class="form-group">								
									<a href="javascript:;" onclick="">
									    <button type="button" class="btn btn-default" id="btnGuardar" 
									    	onclick="mtdMantenimientoEquipo.guardarRespuestaSolicitudPublic();" >
									    <!-- disabled="false" -->
									  		Guardar<!--<span class="glyphicon glyphicon-plus-sign"></span>-->
									  	</button>
									</a>	
								</div>	
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
	$(document).ready(function () {
		if ($('#lbMensajeConformidad').text()=='Se necesita avisar al solicitante, que se le entregara el nuevo equipo asignado') {
			$('#observacionTxt').val('Se le asigno un nuevo equipo, por favor espere la entrega');
		};
	});
</script>
